<?
include("functions/general_functions.php");

include("clases/clsusuario.php");
include("clases/clsSubGrupo.php");

///objetos
$objTaller=new clsSubGrupo();
$objUsuario=new clsusuario();

$msg="";

$idusuario=$_SESSION["idusuario"];
$RSUsuario=$objUsuario->consultarDetalleUsuarios($idusuario);
$RowUsuario=mysql_fetch_assoc($RSUsuario);

?>
<html>
<?php include("includes/head.php"); ?>

<body>
	<?php include("includes/logo.php") ?>
	<!-- end #header -->
	<?php include("includes/top_menu.php"); ?>
	<!-- end #menu -->
	<div id="wrapper">
	 <div class="btm">
		<div id="page">
		 <div id="content">
			
			<div class="post">
			 <iframe name="marco" frameborder="0" width="600" height="608" scrolling="auto" > </iframe>			
			</div>
			
		</div>
		<!-- end #content -->
		<div id="sidebar">
			<h2>Categories</h2>
			<? include('functions/tree.php');?>
			<? include('functions/drawtree.php');?>
		</div>
		<!-- end #sidebar -->
		<div style="clear: both;">&nbsp;</div>
	</div>
	<!-- end #page -->
</div>
</div>
 <?php include("includes/footer.php"); ?>
</body>
</html>