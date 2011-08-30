<?php
include("functions/general_functions.php");

include("includes/connection.php");
include("clases/clsusuario.php");
include("clases/clsSubGrupo.php");
include("clases/clsVideos.php");

//objetos
$objTaller=new clsSubGrupo();
$objUsuario=new clsusuario();
$objVideos= new clsVideos();

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
			
			 <table border="0" cellpadding="0" cellspacing="0">
				<tr>
				 <td colspan="5">
					<strong>&nbsp;&nbsp;Historial de Cursos y Certificaciones</strong>
				 </td>
				</tr>
				<tr>
				 <td>T&iacute;tulo</td>
				 <td> Fecha </td>
				 <td> Puntaje </td>
				 <td> Resultado </td>
				 <td> Certificado </td>
				</tr>
				<?php
				 $RSresultado=$objTaller->consultarHistorialUsuario($_SESSION["idusuario"],'','');
				 while ($row = mysql_fetch_array($RSresultado))
				 {
					$NotaObtenida=$row["NotaObtenida"]; 
					$Fecha=$row["Fecha"]; 
					$NotaBase=$row["NotaBase"]; 
					$NotaMinima=$row["NotaMinima"]; 
					$Titulo=$row["Titulo"];
					$NombreTaller=$row["NombreTaller"];
					$IdModulo = $row["IdModulo"];
					?>
					<tr>
					 <td><?=$Titulo?></td>
					 <td><?=$Fecha?></td>
					 <td><?=$NotaObtenida?></td>
					 <td>
						<?php
						 if($NotaObtenida>=$NotaMinima) { echo("Aprobo!"); }
						 else { echo("<font color=red>Reprobo</font>"); }
						?>                  
					 </td>
					 <td>
						<?php
						if($NotaObtenida>=$NotaMinima)
						{
						 echo("<a href='diploma.php?IdModulo=$IdModulo' target='_blank'>Ver</a>");
						}
						else { echo("&nbsp;"); }
					 ?>                  
					 </td>
					</tr>
					<?php
				 }
				?>
			 <tr>
				<td colspan="5">Historial de Videos Visualizados</td>
			 </tr>
			 <tr>
				<td colspan="3"><strong>Nombre </strong></td>
				<td><strong>Grupo </strong></td>
				<td><strong># Vistas</strong></td>
			 </tr>
			 <?
				$RSresultadoVistas=$objVideos->HistorialVideosGrupoUsuario($_SESSION["idusuario"]);
				while ($rowvistas = mysql_fetch_assoc($RSresultadoVistas))
				{
				 extract($rowvistas);
				 ?>
				 <tr>
					<td colspan="3"><?=$nombre?></td>
					<td><?=$NombreSubGrupo?></td>
					<td><?=$totalvistas?></td>
				 </tr>
			 <?
			 $totalVideos++;
			 }
				?>
				<tr>
				 <td colspan="3"><strong>Nombre </strong></td>
				 <td><strong>Subgrupo </strong></td>
				 <td><strong># Vistas</strong></td>
				</tr>
				<?
				$RSresultadoVistas=$objVideos->HistorialVideosSubgrupoUsuario($_SESSION["idusuario"]);
				while ($rowvistas = mysql_fetch_assoc($RSresultadoVistas))
				{
				 extract($rowvistas);
				 ?>
				 <tr>
					<td colspan="3"><?=$nombre?></td>
					<td><?=$NombreSubGrupo?></td>
					<td><?=$totalvistas?></td>
				 </tr>
				 <?
				 $totalVideos++;
				}
				?>
				<tr>
				 <td colspan="5">
					<strong>Total de Videos Visualizados:<?=$totalVideos ?></strong>
				 </td>
				</tr>
			 </table>
			</div>

		</div>
		<!-- end #content -->
		<!--<div id="sidebar">-->
			<!--<h2>Categories</h2>-->
			<? //include('functions/tree.php');?>
			<? //include('functions/drawtree.php');?>
		<!--</div>-->
		<!-- end #sidebar -->
		<div style="clear: both;">&nbsp;</div>
	</div>
	<!-- end #page -->
</div>
</div>
 <?php include("includes/footer.php"); ?>
</body>
</html>