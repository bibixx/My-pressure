<?
include 'passwords.php';
$dbc = mysql_connect(HOST, LOGIN, PASSWORD) or die( 'błąd' );
$dcs = mysql_select_db(DATABASE);

$query = "DELETE FROM `pressures` WHERE `pressures`.`id` = ".$_POST["id"];
$data = mysql_query($query);

mysql_close($dbc);
?>
