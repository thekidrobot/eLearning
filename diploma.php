<?
session_start();
include("clases/clsusuario.php");
include("clases/clsSubGrupo.php");
include("includes/connection.php");
//validar sesion
if($_SESSION["usuario"]=="")
 {
  ?>
  <script language="javascript">
  document.location="inicio.html";
  </script>
  <?
 }
$objTaller=new clsSubGrupo();
$RSresultado=$objTaller->consultarDetalleModulo($_GET["IdModulo"]);
while ($row = mysql_fetch_array($RSresultado))
{
 $Titulo=$row["Titulo"]; 
}

$RSresultado=$objTaller->consultarFechaAprobacion($_GET["IdModulo"],$_SESSION["usuario"]);
while ($row = mysql_fetch_array($RSresultado))
{
 $fechaAprobacion=$row["Fecha"]; 
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- saved from url=(0014)about:internet -->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>:::::certificado:::::</title>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<style type="text/css">
td img {display: block;}.Estilo1 {font-size: 9px}
.Estilo2 {
	font-size: 23px;
	font-weight: bold;
}
.bordes {
	border: 3px solid #666666;
}
</style>
<!--Fireworks 8 Dreamweaver 8 target.  Created Thu Sep 04 09:30:43 GMT-0500 (SA Pacific Standard Time) 2008-->
<link href="css/INDEX.CSS" rel="stylesheet" type="text/css" />
</head>
<body bgcolor="#ffffff">
<br />
<table width="731" border="0" align="center" cellpadding="0" cellspacing="0" class="bordes">
  <!-- fwtable fwsrc="Sin t&iacute;tulo" fwbase="Certificado.gif" fwstyle="Dreamweaver" fwdocid = "1289419408" fwnested="0" -->
  <tr>
    <td><img src="imagenes/spacer.gif" width="408" height="1" border="0" alt="" /></td>
    <td><img src="imagenes/spacer.gif" width="279" height="1" border="0" alt="" /></td>
    <td><img src="imagenes/spacer.gif" width="44" height="1" border="0" alt="" /></td>
    <td><img src="imagenes/spacer.gif" width="1" height="1" border="0" alt="" /></td>
  </tr>
  <tr>
    <td colspan="3"><img name="Certificado_r1_c1" src="imagenes/Certificado_r1_c1.gif" width="731" height="137" border="0" id="Certificado_r1_c1" alt="" /></td>
    <td><img src="imagenes/spacer.gif" width="1" height="137" border="0" alt="" /></td>
  </tr>
  <tr>
    <td colspan="3"><img name="Certificado_r2_c1" src="imagenes/Certificado_r2_c1.gif" width="731" height="39" border="0" id="Certificado_r2_c1" alt="" /></td>
    <td><img src="imagenes/spacer.gif" width="1" height="39" border="0" alt="" /></td>
  </tr>
  <tr>
    <td colspan="3"><img name="Certificado_r3_c1" src="imagenes/Certificado_r3_c1.gif" width="731" height="41" border="0" id="Certificado_r3_c1" alt="" /></td>
    <td><img src="imagenes/spacer.gif" width="1" height="41" border="0" alt="" /></td>
  </tr>
  <tr>
    <td colspan="3" align="center" background="imagenes/Certificado_r4_c1.gif" class="Arial-28"><strong>
      <?=$_SESSION['NombreCompleto']; ?>
    </strong></td>
    <td><img src="imagenes/spacer.gif" width="1" height="40" border="0" alt="" /></td>
  </tr>
  <tr>
    <td colspan="3"><img name="Certificado_r5_c1" src="imagenes/Certificado_r5_c1.gif" width="731" height="30" border="0" id="Certificado_r5_c1" alt="" /></td>
    <td><img src="imagenes/spacer.gif" width="1" height="30" border="0" alt="" /></td>
  </tr>
  <tr>
    <td colspan="3" align="center" background="imagenes/Certificado_r6_c1.gif"><span class="Arial-28">
      <?=$Titulo?>
    </span></td>
    <td><img src="imagenes/spacer.gif" width="1" height="65" border="0" alt="" /></td>
  </tr>
  <tr>
    <td colspan="3"><img name="Certificado_r7_c1" src="imagenes/Certificado_r7_c1.gif" width="731" height="69" border="0" id="Certificado_r7_c1" alt="" /></td>
    <td><img src="imagenes/spacer.gif" width="1" height="69" border="0" alt="" /></td>
  </tr>
  <tr>
    <td rowspan="3"><img name="Certificado_r8_c1" src="imagenes/Certificado_r8_c1.gif" width="408" height="129" border="0" id="Certificado_r8_c1" alt="" /></td>
    <td colspan="2"><img name="Certificado_r8_c2" src="imagenes/Certificado_r8_c2.gif" width="323" height="19" border="0" id="Certificado_r8_c2" alt="" /></td>
    <td><img src="imagenes/spacer.gif" width="1" height="19" border="0" alt="" /></td>
  </tr>
  <tr>
    <td align="center" class="tahoma_11"><?="Bogota D.C., ".$fechaAprobacion; ?></td>
    <td rowspan="2"><img name="Certificado_r9_c3" src="imagenes/Certificado_r9_c3.gif" width="44" height="110" border="0" id="Certificado_r9_c3" alt="" /></td>
    <td><img src="imagenes/spacer.gif" width="1" height="27" border="0" alt="" /></td>
  </tr>
  <tr>
    <td><img name="Certificado_r10_c2" src="imagenes/Certificado_r10_c2.gif" width="279" height="83" border="0" id="Certificado_r10_c2" alt="" /></td>
    <td><img src="imagenes/spacer.gif" width="1" height="83" border="0" alt="" /></td>
  </tr>
</table>
<span class="Estilo1">
<?=$row['Convencion']; ?>
</span>
</body>
</html>