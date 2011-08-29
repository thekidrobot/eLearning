<?
session_start(); 

$_SESSION["basededatos"] = "evaluaciones";
$_SESSION["servidor"] = "localhost";
$_SESSION["root"] = "root";
$_SESSION["claveBD"]="root";

$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link);	

?>