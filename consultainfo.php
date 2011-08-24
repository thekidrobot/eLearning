<?
include("functions/general_functions.php");

include("clases/clsVideos.php");
include("clases/clsSubGrupo.php");

$objVideos=new clsVideos();
$objTaller=new clsSubGrupo();

extract($_GET);

?>
 <table cellspacing="0">
	<tr>
	 <td colspan="2">
		<?php if (isset($IdSubGrupo))
		{ 
		 $sql = "SELECT c.categorias, sg.NombreSubGrupo,g.grupos
						 FROM 	subgrupos sg, grupos g, categorias c
						 WHERE 	sg.IdGrupos = g.IdGrupos
						 AND 	c.IdCategorias = g.IdCategorias
						 AND 	sg.IdSubGrupo = $IdSubGrupo";
				 
		 $RSresultado=mysql_query($sql,$link);
		 while ($row = mysql_fetch_array($RSresultado))
		 {
			$NombreCategorias = $row['categorias'];
			$NombreSubGrupo=$row["NombreSubGrupo"]; 
			$NombreGrupo=$row["grupos"];
			$nombre=$row["nombre"];
			echo "<div><b>Usted está en: </b> $NombreCategorias | $NombreGrupo  |  $NombreSubGrupo</div>";
		 }
		 
		 $RSresultado=$objVideos->ConsultarVideos($IdSubGrupo);
		}
		else
		{
		 $sql = "SELECT c.categorias, g.grupos
						 FROM 	grupos g, categorias c
						 WHERE 	c.IdCategorias = g.IdCategorias
						 AND 	g.IdGrupos= $IdGrupos";
	
		 $RSresultado=mysql_query($sql,$link);
		 while ($row = mysql_fetch_array($RSresultado))
		 {
			$NombreCategorias = $row['categorias'];
			$NombreGrupo=$row["grupos"];
			echo "<div>Usted está en: $NombreCategorias | $NombreGrupo</div>";
		 }
		 $RSresultado=$objVideos->ConsultarVideosGruposActivos($IdGrupos);
		}
		$nmodulos = mysql_num_rows($RSresultado); ?>
	 </td>
	</tr>
	<tr>
	 <td colspan="2">
	  Existen <?=$nmodulos?> modulos disponibles
	 </td>
	</tr>
	
	<?php
	while ($row = mysql_fetch_assoc($RSresultado))
	{
	 extract($row);
	 ?>
	  <tr>
	   <td>
			<?=$nombre?>
		 </td>
		 <?php
			$RSVideosVistos = $objVideos->ConsultaVideosVistos($_SESSION['idusuario'],$Idvideo);
			$row = mysql_num_rows($RSVideosVistos);
			if($row == 0) $ico = 'imagenes/iconos/delete.gif';
			else $ico = 'imagenes/iconos/ok.gif';
		 ?>
		 <td>
			<img src="<?=$ico?>"><a href="actualizapres.php?Idvideo=<?=$Idvideo?>" target="_blank">Ver Presentación </a>
		 </td>
		</tr>
		
		<tr>
		 <td>
		  <img src="apoyos/<?=$urlpic ?>" />
		 </td>
		 <td>
			<?=$descripcion?>
		 </td>
		</tr>
    
	 <tr>
		<td><strong>Duraci&oacute;n:</strong></td>
    <td><?=$duracion?></td>
   </tr>
   
	 <tr>
		<td><strong>Expositor:</strong></td>
    <td><?=$presentador?></td>
   </tr>
   
	 <tr>
		<td>
		 Material de apoyo
		</td>
		<td>
		 <?php
		  $RSMatApoyo=$objVideos->ConsultarMaterialApoyo($Idvideo);
		  $mat = 0;
		  while ($row = mysql_fetch_array($RSMatApoyo))
		  {
		   $NombreArchivo=$row["NombreArchivo"];
		   echo "<a class='link' href='apoyos/$NombreArchivo' target='_blank'>$NombreArchivo</a><br/>";
		   $mat++;
		  }
		  if($mat == 0) 
		  echo "No incluye material de apoyo adicional";
		  ?>
		 </td>
	  </tr>
		<?
		 $RSresultado2=$objTaller->consultarModulosVideos($Idvideo);
		 $totalcuestionarios=mysql_num_rows($RSresultado2);
		 if ($totalcuestionarios>0)
		 {
		  ?>
		  <tr>
		    <td colspan="2"><strong> &nbsp;Esta presentaci&oacute;n tiene un test asociado</strong></td>
	    </tr>
		   <?
		   while ($row = mysql_fetch_array($RSresultado2))
		   {	
		    $IdModulo=$row["IdModulo"]; 
		    $Titulo=$row["Titulo"]; 
		    $vEstado=$row["estado"]; 
		    
				$RSresultado3=$objTaller->consultarResultadoUsuario($IdModulo,$_SESSION["idusuario"]);
				while ($row = mysql_fetch_array($RSresultado3))
				{
				 $NotaObtenida=$row["NotaObtenida"]; 
				 $NotaMinima=$row["NotaMinima"]; 
				 
				 if($NotaObtenida < $NotaMinima) $aprobo = 0;
				 else $aprobo = 1;
				}
		    ?>
		    <tr>
		      <td colspan="2"> &nbsp;<?=$Titulo?></td>
        </tr>
		    <tr>
				 <td colspan="2">
					<?php
					 if($aprobo == 0)
					 {
						?>
						<a href="usrpreguntasmodulo.php?IdModulo=<?=$IdModulo?>" class="tahoma_11_derecha" >Presentar test</a>
						<?php
					 }
					 elseif($aprobo == 1)
					 {
						?>
						<a href="ushistorial.php" target="_top" class="tahoma_11_derecha" >Test Aprobado</a>
						<?php
					 }
					?>
				 </td>
	      </tr>
				<?
			 }	
			 ?>
    <tr>
	  <td colspan="2">
		<?
	}
	$RSVideosVistos = $objVideos->ConsultaVideosVistos($_SESSION['idusuario'],$Idvideo);
	$row = mysql_num_rows($RSVideosVistos);
	if($row == 0 and $orden != 0) break;
   }
  ?></td>
	</tr>
 </table>