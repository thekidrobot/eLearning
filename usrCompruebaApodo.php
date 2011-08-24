<?php 
require_once('Connections/cnx_local.php');

?>
<?php
if (!isset($_SESSION)) {
  session_start();
}

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$colname_rsApodo = "-1";
if (isset($_POST['Usuario'])) {
  $colname_rsApodo = $_POST['Usuario'];
}
mysql_select_db($database_cnx_local, $cnx_local);
$query_rsApodo = sprintf("SELECT count(*)  as cuenta FROM usuarios WHERE Correo = %s", GetSQLValueString($colname_rsApodo, "text"));
$rsApodo = mysql_query($query_rsApodo, $cnx_local) or die(mysql_error());
$row_rsApodo = mysql_fetch_assoc($rsApodo);
$totalRows_rsApodo = mysql_num_rows($rsApodo);

mysql_free_result($rsApodo);

?>
<div id="apodo" align="left">
<?php

if(!filter_var($_POST['Usuario'], FILTER_VALIDATE_EMAIL))
{
  ?>
  <label class="errUser">Formato de correo no valido</label>
  <?php
}
else
{
  if($row_rsApodo['cuenta']==1)
  {
	?>
	<label class="errUser">este login ya esta siendo usado </label>
	<?php
  }
  else
  {
  	?>
    <label class="okUser">Este usuario esta disponible</label>
    <?php
  }  
}
?>
</div>