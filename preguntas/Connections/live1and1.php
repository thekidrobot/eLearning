<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_live = "db2854.perfora.net";
$database_live = "db361189811";
$username_live = "dbo361189811";
$password_live = "camilo123";
$live = mysql_pconnect($hostname_live, $username_live, $password_live) or trigger_error(mysql_error(),E_USER_ERROR); 
?>