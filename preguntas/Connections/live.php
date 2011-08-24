<?php
ini_set('display_errors',1); 
error_reporting(E_ALL);

# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_live = "localhost";
$database_live = "evaluaciones";
$username_live = "root";
$password_live = "root";
$live = mysql_pconnect($hostname_live, $username_live, $password_live) or trigger_error(mysql_error(),E_USER_ERROR);

?>