<?
include("functions/general_functions.php");

include("includes/connection.php");
include("clases/clsusuario.php");
include("clases/clsSubGrupo.php");

//objetos
$objTaller=new clsSubGrupo();
$objUsuario=new clsusuario();
$msg="";
$idusuario=$_SESSION["idusuario"];
$RSUsuario=$objUsuario->consultarDetalleUsuarios($idusuario);
$RowUsuario=mysql_fetch_assoc($RSUsuario);

//actualizar clave
if($_POST["ingresar"]!="")
{
 $clave=$_POST["valorClave"];
 $correo = $_POST["valorCorreo"];
 $objUsuario->actualizarClaveUsuario($_SESSION["usuario"],$clave,$correo);
 $msg="Clave actualizada satisfactoriamente";
}
?>

<html>
<?php include("includes/head.php"); ?>

<body>
 <div id="header">
	<div id="logo">
	 <h1><a href="#">Compromise </a></h1>
	  <p>
		 Welcome <?=$RowUsuario['NombreCompleto'] ?> - <a href="index.php">Logout</a>
		</p>
	 </div>
	</div>
	<!-- end #header -->
	<div id="menu">
	 <ul>
	  <li class="first"><a href="#">Home</a></li>
		<li><a href="ushistorial.php">Catalog</a></li>
		<li><a href="usacceso.php">My progress</a></li>
		<li><a href="#">Settings</a></li>
		<li><a href="usexamen.php">Contact</a></li>
		<li><a href="usexamen.php">Help</a></li>
	 </ul>
	</div>
	<!-- end #menu -->
	<div id="wrapper">
	 <div class="btm">
		<div id="page">
		 <div id="content">
			
			<div class="post">
			 
			<?php 
			 $RSUsuario=$objUsuario->consultarDetalleUsuariosPorNombre($_SESSION["usuario"]);
			 $RowUsuario=mysql_fetch_assoc($RSUsuario);
			?>
			<p>Cambie su clave por una que pueda recordar f&aacute;cilmente </p>
			
			<form name="formProceso" action="<?=$_SERVER['PHP_SELF']?>" method="post" onSubmit="return validaCambioClave()">
			 <input type="hidden" name="ingresar" value="1">
			 <table>
				<tr>
				 <td><strong> Usuario </strong></td>
					<td><input type="text" value="<?=$RowUsuario['NombreCompleto']?>" readonly></td>
				 </tr>
				 <tr>
					<td><strong> Login </strong></td>
					<td><input type="text" value="<?=$RowUsuario['Usuario']?>" readonly></td>
				 </tr>
				 <tr>
					<td><strong> Empresa</strong></td>
					<td><input type="text" value="<?=$RowUsuario['Cedula']?>" readonly></td>
				 </tr>
				 <tr>
					<td><strong> Correo </strong></td>
					<td><input type="text" value="<?=$RowUsuario['Correo']?>" name="valorCorreo" class="tahoma_11_light"></td>
				 </tr>
				 <tr>
					<td><strong> Digite su nueva Clave </strong></td>
					<td><input type="password" name="valorClave"></td>
				 </tr>
				 <tr>
					<td align="right">&nbsp;</td>
					<td align="right">
					 <input type="image" src="imagenes/ingresar.jpg"><?=$msg?>
					</td>
				 </tr>
				</table>
			 </form>
			</div>
			
		</div>
		<!-- end #content -->
		<div id="sidebar">
			<!--<h2>Categories</h2>-->
			<? //include('functions/tree.php');?>
			<? //include('functions/drawtree.php');?>
		</div>
		<!-- end #sidebar -->
		<div style="clear: both;">&nbsp;</div>
	</div>
	<!-- end #page -->
</div>
</div>
	<div id="footer">
		<p>Copyright (c) 2008 Sitename.com. All rights reserved. Design by <a href="http://www.freecsstemplates.org/">Free CSS Templates</a>.</p>
	</div>
	<!-- end #footer -->
</body>
</html>