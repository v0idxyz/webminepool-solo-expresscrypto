<?php
  include_once("handler.php");
  $users     = $app->get_users();
  $hash_rate = $wmp->hash_rate(1000000)->satoshi-$config->comission;
  echo $hash_rate;
  echo  $users;
  file_put_contents(dirname(__FILE__)."/../users.json",     $users);
  file_put_contents(dirname(__FILE__)."/../hash_rate.json", $hash_rate);
?>