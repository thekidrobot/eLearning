<?php require_once('Connections/live.php'); ?>
<?php
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

$editFormAction = $_SERVER['PHP_SELF'];

  $aLeidos = $_POST['leido'];  
  $N = count($aLeidos);
  if($N > 0)
  {
   for($i=0; $i < $N; $i++)
   {
    $updateSQL = "UPDATE livechat SET leido=1 WHERE id=$aLeidos[$i]";
    mysql_select_db($database_live, $live);
    $Result1 = mysql_query($updateSQL, $live) or die(mysql_error());
   } 
  }  

mysql_select_db($database_live, $live);
$query_live = "SELECT * FROM livechat ORDER BY fecha DESC";
$live1 = mysql_query($query_live, $live) or die(mysql_error());
$row_live = mysql_fetch_assoc($live1);
$totalRows_live = mysql_num_rows($live1);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1"/>
<meta http-equiv="refresh" content="10; url=consulta_preguntas.php ">
<title>Consulta Preguntas</title>
<link href="css/estilos.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
body {
	background-color: #333;
}
-->
</style></head>

<body>
<form name="form1" method="POST" action="<?php echo $editFormAction; ?>">
  <table width="827" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr class="tahoma_11_titulos">
      <td bgcolor="#CCCCCC" class="trebuchet_15">&nbsp;</td>
      <td height="32" bgcolor="#CCCCCC" class="trebuchet_15"><label>
        <input type="submit" name="marcar" id="marcar" value="marcar">
      </label></td>
      <td height="32" colspan="4" bgcolor="#CCCCCC" class="trebuchet_15">Consulta preguntas</td>
    </tr>
    <tr class="tahoma_11_titulos">
      <td width="27" bgcolor="#666666">&nbsp;</td>
      <td width="27" bgcolor="#666666">&nbsp;</td>
      <td width="181" height="20" bgcolor="#666666">Nombre</td>
      <td width="403" bgcolor="#666666">Pregunta</td>
      <td width="74" bgcolor="#666666">Leido</td>
      <td width="115" bgcolor="#666666">fecha</td>
    </tr>
    <?php do {
      
      $id = $row_live['id'];
      
      $class = "";
      $check = "";
      if ($row_live['leido'] == 1) {
	$check = "checked disabled";
      }

      if ($row_live['leido'] == 0) {
	$class = "bold";
      }
      
      ?>
    <tr class="tahoma_11_borde">
      <td bgcolor="#CCCCCC" class="tahoma_11_borde">&nbsp;</td>
      <td align="center" bgcolor="#CCCCCC" class="tahoma_11_borde"><?php echo "<input name='leido[]' type='checkbox' id='leido' value='$id' $check>"; ?></td>
      <td height="28" bgcolor="#CCCCCC" class="tahoma_11_borde"><?php echo $row_live['Nombre']; ?></td>
      <td bgcolor="#CCCCCC" class="tahoma_11_borde <?=$class?>"><?php echo $row_live['comentario']; ?></td>
      <td bgcolor="#CCCCCC" class="tahoma_11_borde"><?php echo $row_live['leido']; ?></td>
      <td bgcolor="#CCCCCC" class="tahoma_11_borde"><?php echo $row_live['fecha']; ?></td>
    </tr>
  
    <?php } while ($row_live = mysql_fetch_assoc($live1)); ?>
      
      <tr class="tahoma_11_borde">
      <td bgcolor="#CCCCCC" class="tahoma_11_borde">&nbsp;</td>
      <td bgcolor="#CCCCCC" class="tahoma_11_borde"><input type="submit" name="marcar" id="marcar" value="marcar"></td>
      <td height="28" bgcolor="#CCCCCC" class="tahoma_11_borde">&nbsp;</td>
      <td bgcolor="#CCCCCC" class="tahoma_11_borde">&nbsp;</td>
      <td bgcolor="#CCCCCC" class="tahoma_11_borde">&nbsp;</td>
      <td bgcolor="#CCCCCC" class="tahoma_11_borde">&nbsp;</td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
</form>
</body>
</html>
<?php
mysql_free_result($live1);
?>
