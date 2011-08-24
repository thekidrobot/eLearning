<?
include("conexion.php");
include("clases/clsusuario.php");
include("clases/clsSubGrupo.php");

session_start();

//validar sesion
if($_SESSION["usuario"]=="")
 {
  ?>
  <script language="javascript">
  document.location="inicio.html";
  </script>
  <?
 }

///objetos
$objTaller=new clsSubGrupo();
$objUsuario=new clsusuario();
$msg="";
$idusuario=$_SESSION["idusuario"];
$RSUsuario=$objUsuario->consultarDetalleUsuarios($idusuario);
$RowUsuario=mysql_fetch_assoc($RSUsuario);

?>
<html>
<head>
<title>:: nucomm.tv ::</title>
<link rel="stylesheet" href="css/INDEX.CSS">
<script language="javascript" src="js.js">
</script>
<style type="text/css">
<!--
.Estilo1 {color: #FFFFFF}
.Estilo2 {font-size: 12px; font-style: normal; line-height: normal; font-weight: normal; font-variant: normal; text-transform: none; text-decoration: none; font-family: Verdana, Arial, Helvetica, sans-serif;}
body {
	background-color: #000;
	margin-top: 0px;
}
-->
</style>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>
<body leftmargin="0" background="" >
<table width="1024" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="4"><img src="imagenes/top.jpg" width="1024" height="176"></td>
  </tr>
  <tr>
    <td height="26" bgcolor="#000000">&nbsp;</td>
    <td valign="middle" bgcolor="#000000" class="borde_azul"><strong>Bienvenido</strong>
        <?=$RowUsuario['NombreCompleto'] ?>
- <a href="index.php" target = "_top" class="borde_azul" ?>Salir</a></td>
    <td bgcolor="#000000" class="borde_azul">&nbsp;</td>
    <td align="right" valign="bottom" bgcolor="#000000" class="borde_azul"><img src="imagenes/menu.jpg" width="579" height="25" border="0" usemap="#Map"></td>
  </tr>
  <tr>
    <td colspan="3" align="center"><img src="imagenes/categorias.jpg" width="305" height="41"></td>
    <td width="720" rowspan="3" valign="top"><iframe name="marco" frameborder="0" width="720" src="blank.html" height="608" scrolling="auto" > </iframe></td>
  </tr>
  <tr>
    <td width="12" height="562" bgcolor="#CECECE" class="repeat_left">&nbsp;</td>
    <td width="286" valign="top" bgcolor="#CECECE"><table width="274" border="0" align="left" cellpadding="5" cellspacing="0" background="imagenes/menu_r2_c1.jpg" bgcolor="#CCCCCC">
      <tr bgcolor="D4D4D4" >
        <td width="85%" bgcolor="#CECECE"   class="index-titles" ><? include('tree.php');?>
          <? include('drawtree.php');?></td>
      </tr>
    </table></td>
    <td width="6" bgcolor="#CECECE" class="repeat_right">&nbsp;</td>
  </tr>
  <tr>
    <td height="9" colspan="3" valign="top"><img src="imagenes/base_menu.jpg" width="305" height="9"></td>
  </tr>
  <tr>
    <td colspan="4" align="center" class="rights">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Todos los derechos reservados. &copy; nucomm.tv, 2010</td>
  </tr>
  <tr>
    <td colspan="4" align="center" class="borde_azul">&nbsp;</td>
  </tr>
</table>

<map name="Map">
  <area shape="rect" coords="154,3,282,22" href="ushistorial.php">
  <area shape="rect" coords="300,4,430,21" href="usacceso.php">
  <area shape="rect" coords="444,5,565,20" href="#">
  <area shape="rect" coords="10,5,139,21" href="usexamen.php">
</map>
</body>
</html>