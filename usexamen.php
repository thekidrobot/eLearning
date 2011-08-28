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
	<div id="footer">
		<p>Copyright (c) 2008 Sitename.com. All rights reserved. Design by <a href="http://www.freecsstemplates.org/">Free CSS Templates</a>.</p>
	</div>
	<!-- end #footer -->
</body>
</html>