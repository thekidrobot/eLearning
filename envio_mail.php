<html>
<head>
<title>::::merck::::</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
.bordes {
	border: 1px solid #CCCCCC;
}
.verdana {	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	font-style: normal;
	color: #000000;
}
.Estilo3 {	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	line-height: normal;
}
.bordes {
	border: 1px solid #999999;
}
-->
</style>
<link href="galeria/css/galeria.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.Estilo11 {
	font-family: Tahoma;
	font-size: 11px;
}
.Estilo13 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	line-height: normal;
}
body {
	background-color: #EBE9ED;
}
-->
</style>
</head>
<body>
<table width="471" border="0" align="center" cellspacing="0" bgcolor="#FFFFFF" class="bordes">
  <tr>
    <td colspan="3" align="center"><span class="Estilo3"><img src="imagenes/logo.jpg" width="316" height="105" /></span></td>
  </tr>
  <tr>
    <td colspan="3"><div align="right"></div></td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td width="19">&nbsp;</td>
    <td width="430"><div align="center"><span class="Estilo3 Estilo11"><span class="Estilo13">Su registro fue exitoso. Desde este momento puede <br>
      acceder a nuestro sistema. <br>
            <a href="index.php">Entrar</a></span></span></div></td>
    <td width="12">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" bgcolor="#EBE9ED"><div align="center"><span class="verdana"><strong>Powered By Nucomm&reg; </strong></span></div></td>
  </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>
  <?php /* require_once('Connections/cnx_local.php'); ?>
<?php
$destMail = "vzdc@vzdc.com";
$correo = $_POST["Correo"];
$nombres = $_POST["nombres"];
$apellidos = $_POST["apellidos"];
$usuario = $_POST["Nombre"];
$pass = $_POST["Clave"];

echo $_POST["nombres"];

$header = "From: Admin APConlinelearning";

mail($correo . "", "Gracias por registrarse en nuestro sistema. Recuerde que para ingresar debe digitar: www.apclearninnetwork.com.\n" , "Su usuario es: " . $usuario . "\n" . "Su clave es: " . $cargo . "\n" . "Correo: " . $pass);
mail($destMail . "", "registro APC learning network", "Nombres: " . $nombres . "\n" . "Apellidos: " . $apellidos . "\n" . "Correo: " . $correo); 

//if(mail($_POST['Correo'],"Registro de usuario APConlineLearning","Gracias por registrarse. Recuerde que para acceder a nuestro sistema usted puede digitar la siguiente direccion en su navegador preferido http://www.vzdc.com/apc/online \nSu usuario es: " . $_POST['Nombre'] . "\n" . "Su clave es: " . $_POST['Clave'],$adition))
{

/*	
	echo "<B>DATOS DEL E-MAIL ENVIADO<B><BR><BR>";
	echo "De = ".$_POST['from']."<br>";
	echo "Asunto = ".$_POST['Nombre']."<br>";
	echo "Mensaje = ".$_POST['Clave']."<br>";
	echo "Para = ".$_POST['Correo']."<br>";
*/
/*
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

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
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
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

$query_Recordset1 = sprintf("INSERT INTO usuarios2 (USU_LOGIN, USU_PASS , USU_MAIL, USU_NOMBRES, USU_APELLIDOS, USU_ACTIVADO ) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['Nombre'], "text"),
                       GetSQLValueString($_POST['Clave'], "text"),
                       GetSQLValueString($_POST['Correo'], "text"),
					   GetSQLValueString($_POST['nombres'], "text"),
					   GetSQLValueString($_POST['apellidos'], "text"),
					   GetSQLValueString($_POST['activo'], "text"));
					   
mysql_select_db($database_cnx_local, $cnx_local);
$Recordset1 = mysql_query($query_Recordset1, $cnx_local) or die(mysql_error());	
}
else
{
	echo "<B>NO SE PUDO ENVIAR<B><BR><BR>";
}

*/?>
</p>
<p>&nbsp;</p>

</body>
</html>