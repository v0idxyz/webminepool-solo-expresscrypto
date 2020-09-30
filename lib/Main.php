<?php

class Main{
    public $config;
    public $wmp;
    public $fh;
    
    public $balance;
    public $rate;
    public $faucet_balance;
    public $referral;
    public $admin=0;
    public $users;
    
    
    public function __construct($config, $wmp, $fh){
        $this->config = $config;
        $this->wmp    = $wmp;
        $this->fh     = $fh;
        $this->users  = $this->load_users_from_file();
        switch(true){
            case $this->is_admin():
                $this->admin         =true;
                $this->faucet_balance= $this->fh->getBalance()['balance'];
                $this->rate          = file_get_contents(dirname(__FILE__)."/../hash_rate.json") != '' ? file_get_contents(dirname(__FILE__)."/../hash_rate.json") : $wmp->hash_rate(1000000)->satoshi-$config->comission; ;
                
                return;
                break;
            
            case !isset($_COOKIE['btc_address']):
                $this->rate          = file_get_contents(dirname(__FILE__)."/../hash_rate.json") != '' ? file_get_contents(dirname(__FILE__)."/../hash_rate.json") : $wmp->hash_rate(1000000)->satoshi-$config->comission; ;
                return;
                break;
            
            case isset($_COOKIE['btc_address'])&&!isset($_COOKIE['rate']):
                $this->faucet_balance= $this->fh->getBalance()['balance'];
                $this->rate          = file_get_contents(dirname(__FILE__)."/../hash_rate.json") != '' ? file_get_contents(dirname(__FILE__)."/../hash_rate.json") : $wmp->hash_rate(1000000)->satoshi-$config->comission; ;
                $user                = $this->get_user($_COOKIE['btc_address']);
                if($user!==false){
                    $this->balance   = $user->hashes; // $balance_request->success==true ? $balance_request->hashes : 0;
                    $this->referral  = $user->referral!=null ? $user->referral : "none";
                }else{
                    $this->balance   = 0;
                    $this->referral  = "none";
                }
                try{
                    setcookie("rate", $this->rate, time() + 61);
                    setcookie("balance", $this->balance, time() + 61);
                    setcookie("faucet_balance", $this->faucet_balance, time() + 61);
                    if(!isset($_COOKIE['referral'])){
                        setcookie("referral", $this->referral, time() + 315360000);
                    }
                }catch(Exception $e){
                    echo $e;
                }
                break;
            
            default:
                $this->rate=$_COOKIE['rate'];
                $this->balance=$_COOKIE['balance'];
                $this->faucet_balance=$_COOKIE['faucet_balance'];
                $this->referral=$_COOKIE['referral'];
        }
    }
    
    public function set_address($address){
        $reply=$this->fh->checkAddress($address);
        if($reply['status']!=200){
            echo $reply['message'];
            return;
        }
        try{
            if (isset($_COOKIE['referral'])){
                $this->wmp->create_user($address, $_COOKIE['referral']);
            }else{
                $this->wmp->create_user($address);
            }
            setcookie("btc_address", $address, time() + 2592000);
            echo "success";
        }catch(Exception $e){
            echo $e;
        }
        return;
    }
    
    
    public function withdraw($address){
        $rate=$this->wmp->hash_rate(1000000)->satoshi-$this->config->comission;
        $user=$this->wmp->user_hashes($address);
        $user_balans_sat=$user->hashes/1000000*$rate;
        if($user_balans_sat>=$this->config->minimal_payout){
            $this->wmp->reset_user_hashes($address);
            $result=$this->fh->send($address, $user_balans_sat, false);
            if($result['success']==true){
                echo "success";
                setcookie("rate", '', time() - 3600);
                if($user->referral!=null){
                    $this->fh->send($user->referral, $user_balans_sat/100*$this->config->referral, true);
                }
                return;
            }else{
                echo $result['message'];
            }
            
        }else{
            echo "You need to mine a bit more to make a withdraw...";
        }
    }
    
    public function delete_user($address){
        $this->wmp->delete_user($address);
    }
    
    public function get_users($threshold=0){
        $users=$this->wmp->users($threshold);
        if($users->success=="true"){
            $this->users=$users->users;
        }else{
            $this->users=false;
            return "{message: 'no users'}";
        }
        return json_encode($users->users);
    }
    public function load_users_from_file(){
        return json_decode(file_get_contents(dirname(__FILE__)."/../users.json"));
    }
    public function get_user($address){
        $users=$this->users;
        if($users!=null){
            foreach($users as $user){
                if ($user->name == $address){
                    return $user;
                }
            }
        }
        return false;
    }
    
    public function pay_all(){
        $users = json_decode($this->get_users($this->config->minimal_payout/$this->rate*1000000));
        if($users == NULL){
            echo "No users have enough money to withdraw.";
            return;
        }
        $sum = 0;
        foreach($users as $user){
            $sum=$sum+round($user->hashes/1000000*$this->rate);
        }
        if($this->faucet_balance < $sum){
            echo "Not enough FaucetHub balance to withdraw all this users!";
            return;
        }else{
            foreach($users as $user){
                $this->send_money($user);
            }
            $this->wmp->reset_all_user_hashes($this->config->minimal_payout/$this->rate*1000000);
        }
        
    }
    
    public function draw_users_table(){
        $this->get_users();
        if(!$this->users){
            echo "No users";
            die();
        }
        echo "<br><a href='?admin_name=".$this->config->admin_name."&admin_pwd=".$this->config->admin_pwd."&action=pay_all' class='btn btn-success'>Pay all</a>

            <table class='table' id='users-table'>
                <thead>
                  <tr>
                    <th scope='col'>Username</th>
                    <th scope='col'>Balance</th>
                    <th scope='col'>Referral</th>
                    <th scope='col'>Action</th>
                  </tr>
                </thead>
                <tbody>";
        foreach($this->users as $user){
            echo "<tr>
                    <th scope='row'>".$user->name."</th>
                    <td>".$user->hashes/1000000*$this->rate."</td>
                    <td>".$user->referral."</td>
                    <td>
                        <a href='?admin_name=".$this->config->admin_name."&admin_pwd=".$this->config->admin_pwd."&action=pay&address=".$user->name."' class='btn btn-success'>Pay</a>
                        <a href='?admin_name=".$this->config->admin_name."&admin_pwd=".$this->config->admin_pwd."&action=delete&address=".$user->name."' class='btn btn-danger'>Delete</a>
                    </td>
                  </tr>";
        }
        echo "          
                </tbody>
              </table>
        ";
    }
    
    private function is_admin(){
        if(isset($_GET['admin_name'])&& isset($_GET['admin_pwd'])&&$_GET['admin_name']==$this->config->admin_name&&$_GET['admin_pwd']==$this->config->admin_pwd){
            return true;
        }else{
            return false;
        }
    }
}