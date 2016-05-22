<?php
  include 'passwords.php';
  session_start();
  $_SESSION["auth"] = false;
  $_SESSION["last-page"] = null;
  $dbc = mysql_connect(HOST, LOGIN, PASSWORD) or die( 'błąd' );
  $dcs = mysql_select_db('pressure');

  $query = "SELECT `rememberMe` FROM `users` WHERE `login` = 'admin'";
  $data = mysql_query($query);
  $rememberMe = json_decode(mysql_fetch_array($data)['rememberMe']);

  if( isset( $_COOKIE["token"] ) ){
    $val = $_COOKIE["token"];
    unset($rememberMe[array_search($val, $rememberMe)]);
    $rememberMe = array_values($rememberMe);

    $query2 = "UPDATE `users` SET `rememberMe` = '".json_encode($rememberMe)."' WHERE `users`.`id` = 1;";
    $data2 = mysql_query($query2);
  }

  mysql_close($dbc);
  unset($_COOKIE['token']);
  setcookie('token', '', time() - 3600, '/');
  header("Location: .");
  die();
?>
