<?
$dbc = mysql_connect('localhost', 'root', 'admin') or die( 'błąd' );
$dcs = mysql_select_db('pressure');

if( $_POST["action"] == "remove" ){
  $query = "DELETE FROM `pressures` WHERE `pressures`.`id` = ".$_POST["id"];
  $data = mysql_query($query);
}

mysql_close($dbc);
?>
