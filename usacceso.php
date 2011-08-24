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

///actualizar clave
if($_POST["ingresar"]!="")
{
 $clave=$_POST["valorClave"];
 $correo = $_POST["valorCorreo"];
 $objUsuario->actualizarClaveUsuario($_SESSION["usuario"],$clave,$correo);
 $msg="Clave actualizada satisfactoriamente";
}
?>
<html>
<head>
 <title>:: nucomm.tv ::</title>
 <link rel="stylesheet" href="css/INDEX.CSS">
 <script language="javascript" src="js.js">
 </script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
<!--
body {
	background-color: #000;
}
-->
</style></head>
<body leftmargin="0" topmargin="0" background="" >
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
     <td colspan="3"><img src="imagenes/top.jpg" alt="" width="1024" height="176"></td>
  </tr>
   <tr>
     <td width="9" bgcolor="#000000">&nbsp;</td>
     <td width="237" bgcolor="#000000" class="borde_azul"><strong>Bienvenido</strong>
       <?=$RowUsuario['NombreCompleto'] ?>
       - <a href="index.php" target = "_top" class="borde_azul" ?>Salir</a></td>
     <td width="778" align="right" valign="bottom" bgcolor="#000000" class="borde_azul"><img src="imagenes/menu_Prefe.jpg" width="579" height="25" border="0" align="absbottom" usemap="#Map">
       <map name="Map">
         <area shape="rect" coords="154,3,282,22" href="ushistorial.php">
         <area shape="rect" coords="300,4,430,21" href="usacceso.php">
         <area shape="rect" coords="444,5,565,20" href="#">
         <area shape="rect" coords="10,5,139,21" href="usexamen.php">
     </map></td>
   </tr>
   <tr>
     <td colspan="3" bgcolor="#FFFFFF" class="text10"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
       <tr>
         <td  height="1" valign="top" bgcolor="#000000">&nbsp;</td>
       </tr>
       <tr>
         <td align="left"  valign="top" bgcolor="#000000"><br>
           <table width="47%" height="100%" align="center" cellpadding="5" cellspacing="1">
             <tr>
               <td align="left"  valign="top" background="imagenes/fondoPAGINA.jpg" bgcolor="#999999" class="titulo_curso">Acceso Usuario</td>
             </tr>
             <?php 
     $RSUsuario=$objUsuario->consultarDetalleUsuariosPorNombre($_SESSION["usuario"]);
     $RowUsuario=mysql_fetch_assoc($RSUsuario);
    ?>
             <tr>
               <td align="left"  valign="top" bgcolor="#CECECE" class="tahoma_11_light">Cambie su clave por una que pueda recordar f&aacute;cilmente </td>
             </tr>
             <tr>
               <td align="left"  valign="top" bgcolor="#CECECE" class="body-text1"><form name="formProceso" action="<?=$_SERVER['PHP_SELF']?>" method="post" onSubmit="return validaCambioClave()">
                 <input type="hidden" name="ingresar" value="1">
                 <table width="317" align="center" class="text10">
                   <tr>
                     <td width="125" class="tahoma_11_light"><strong> Usuario </strong></td>
                     <td width="180" class="text10"><input type="text" value="<?=$RowUsuario['NombreCompleto']?>" class="tahoma_11_light" readonly></td>
                     </tr>
                   <tr>
                     <td width="125" class="tahoma_11_light"><strong> Login </strong></td>
                     <td width="180" class="text10"><input type="text" value="<?=$RowUsuario['Usuario']?>" class="tahoma_11_light" readonly></td>
                     </tr>
                   <tr>
                     <td width="125" class="tahoma_11_light"><strong> Empresa</strong></td>
                     <td width="180" class="text10"><input type="text" value="<?=$RowUsuario['Cedula']?>" class="tahoma_11_light" readonly></td>
                     </tr>
                   <tr>
                     <td width="125" class="tahoma_11_light"><strong> Correo </strong></td>
                     <td width="180" class="text10"><input type="text" value="<?=$RowUsuario['Correo']?>" name="valorCorreo" class="tahoma_11_light"></td>
                     </tr>
                   <tr>
                     <td width="125" class="tahoma_11_light"><strong> Digite su nueva Clave </strong></td>
                     <td width="180" class="text10"><input type="password" name="valorClave" class="tahoma_11_light"></td>
                     </tr>
                   <tr>
                     <td align="right" class="body-text1">&nbsp;</td>
                     <td align="right" class="text10"><div align="left">
                       <p>
                         <input type="image" src="imagenes/ingresar.jpg">
                         </p>
                       <p align="left">
                         <?=$msg?>
                         </p>
                       </div></td>
                     </tr>
                   </table>
                </form></td>
             </tr>
            </table></td>
       </tr>
       <tr>
         <td  height="10" align="center" bgcolor="#000000">&nbsp;</td>
       </tr>
       <tr>
         <td  height="10" align="center" bgcolor="#000000">&nbsp;</td>
       </tr>
       <tr>
         <td  height="10" align="center" bgcolor="#000000">&nbsp;</td>
       </tr>
       <tr>
         <td  height="10" align="center" bgcolor="#000000">&nbsp;</td>
       </tr>
       <tr>
         <td  height="10" align="center" bgcolor="#000000">&nbsp;</td>
       </tr>
       <tr>
         <td  height="10" align="left" bgcolor="#000000"><span class="rights">&nbsp;&nbsp;&nbsp; Todos los derechos reservados. &copy; nucomm.tv, 2010</span></td>
       </tr>
       <tr>
         <td  height="10" align="center" bgcolor="#000000">&nbsp;</td>
       </tr>
     </table></td>
   </tr>
   <tr>
     <td colspan="3" bgcolor="#000000" class="text10"><div align="center" class="borde_azul"></div></td>
   </tr>
</table>
</body>
</html>
