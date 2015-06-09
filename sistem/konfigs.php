<?php
$name="localhost";
$user="root";
$pass="apaajaboleh";
$db="is";
$connection = mysql_connect($name,$user,$pass) or die(mysql_error());
mysql_select_db($db,$connection) or die(mysql_error());
?>

