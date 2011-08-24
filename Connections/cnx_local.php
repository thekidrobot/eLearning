<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_cnx_local = "db2657.perfora.net";
$database_cnx_local = "db345338034";
$username_cnx_local = "dbo345338034";
$password_cnx_local = "webtv123";
$cnx_local = mysql_pconnect($hostname_cnx_local, $username_cnx_local, $password_cnx_local) or trigger_error(mysql_error(),E_USER_ERROR); 
?>