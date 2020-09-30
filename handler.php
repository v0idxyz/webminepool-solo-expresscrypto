<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if(isset($_GET['r'])){
    setcookie("referral", $_GET['r'], time()+2592000) or die('unable to create cookie');
    header("Location: /");

}

include_once("lib/Faucethub.php");
include_once("lib/Webminepool.php");

include_once("lib/Main.php");
$config= json_decode(file_get_contents("config.json"));
$wmp    = new WMP($config->wmp_private_key);
$fh     = new FaucetHub($config->fh_api_key);
$app    = new Main($config, $wmp, $fh);

$action = isset($_GET['action']) ? $_GET['action'] : (isset($_POST['action']) ? $_POST['action'] : null);
switch($action){
    case "login":
        $app->set_address($_POST['address']);
        break;
    case "withdraw":
        if($config->manual_payouts==1){
            echo "oops";
        }else{
            $app->withdraw($_POST['address']);
        }
        break;
    case "pay_all":
        if($app->admin==1){
            $app->pay_all();
        }
        break;
    case "pay":
        if($app->admin==1){
            $app->withdraw($_GET['address']);
        }            
        break;
    case "delete":
        if($app->admin==1){
            $app->delete_user($_GET['address']);
        }
        break;
    default:
        break;
}
