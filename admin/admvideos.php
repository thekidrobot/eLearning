<?php include("header.php"); ?>
<?

///objetos
$objUsuario=new clsusuario();
$objSubGrupo=new clsSubGrupo();
$objVideos=new clsVideos();
$msg="";

extract($_GET);

if($_POST["ingresar"]!="")
 {
 
 if (isset($_POST["IdSubGrupo"])){
     $objVideos->ingresarVideos
				 ($_POST["UrlVideo"],
				  $_POST["estado"],
				  $_POST["IdSubGrupo"],
				  $_POST['fecha'],
				  $_POST['visita'],
				  $_POST['nombre'],
				  $_POST['DescVideo'],
				  $_POST['PresVideo'],
				  $_POST['DurVideo'],
				  $_POST['OrdVideo']
				  );
    }
	else{
	 $objVideos->ingresarVideosGrupos
				 ($_POST["UrlVideo"],
				  $_POST["estado"],
				  $_POST["IdGrupos"],
				  $_POST['fecha'],
				  $_POST['visita'],
				  $_POST['nombre'],
				  $_POST['DescVideo'],
				  $_POST['PresVideo'],
				  $_POST['DurVideo'],
				  $_POST['OrdVideo']
				  );
	}
	$msg="Registro ingresado";
 }

///actualizar
if($_POST["actualizar"]!="")
 {
    $objVideos->actualizarVideo
				($_POST["actualizar"],
				 $_POST["UrlVideo"],
				 $_POST["estado"],
				 $_POST['fecha'],
				 $_POST['visita'],
				 $_POST['nombre'],
				 $_POST['DescVideo'],
				 $_POST['PresVideo'],
				 $_POST['DurVideo'],
				 $_POST['OrdVideo']
				 );
				
    $msg="Registro actualizado";
 }


//informacion registro seleccionado
if($_GET["actualizar"]!="")
 {
 
   $RSresultado=$objVideos->ConsultarVideo($_GET["actualizar"]);
   while ($row = mysql_fetch_array($RSresultado))
     {
	  $vUrlVideo=$row["UrlVideo"]; 
	  $vestado=$row["estado"]; 
	  $IdSubGrupo=$row["IdSubGrupo"]; 
	  $vfecha=$row["fecha"]; 
	  $vvisita=$row["visita"]; 
	  $IdGrupos=$row["IdGrupos"]; 
	  $vnombre=$row["nombre"];
	  $vDescVideo = $row["descripcion"];
	  $vDurVideo = $row["duracion"];
	  $vPresVideo = $row["presentador"];
	  $vOrdVideo = $row["orden"];
     }
 }

if($_GET["borrar"]!="")
{
 $objVideos->borrarVideos($_GET["borrar"]);
 $msg="Registro borrado";
} 

if($_GET["Quitar"]!="" and $_GET["idVideo"]!="")
{
 $objVideos->quitarVideos($_GET["idVideo"],$_GET["Quitar"]);
 $url = "admvideos.php?actualizar=".$_GET["idVideo"]."";
 echo "<meta http-equiv='refresh' content='0;URL=$url'>";
} 

?>

<body>
<div id="wrapper">
 <?php include("top_menu.php"); ?>
 <div id="page">
  <div id="content">
   <div class="post">
	
    <b><?=ucfirst($vvTitulo)?>::<?=ucfirst($vvgTitulo)?>::
	<?
	 if (isset($IdSubGrupo)){ echo "SubGrupos"; } else { echo "Grupos"; } ?>::Videos</b>   <br>
     <br>
	 <form name="formProceso" action="admvideos.php?<? if (isset($IdSubGrupo)){ echo "IdSubGrupo=".$IdSubGrupo; }else{ echo "IdGrupos=".$IdGrupos; }?>" method="post" onSubmit="return validarSubGrupo()">
     <fieldset>
	 <? 
	  if($_GET["actualizar"]!="")
	  {
	   ?>
	   <input type="hidden" name="actualizar" value="<?=$_GET["actualizar"]?>">
	   <? 
      }
	  else
	  {
	   ?>
	   <input type="hidden" name="ingresar" value="1">
	   <? 
	  }
	 ?>
     <table cellspacing="5" cellpadding="5">

	  <tr>
	   <td colspan="2">Informacion del Video</td>
	  </tr>
    
	  <tr>
	   <td>&nbsp;</td>
	  </tr>

	 <?
	  if($_GET["actualizar"]!="")
	  {?>
	   <tr>
		<td valign="top">Expositor: </td>
		<td >
		 <?php
		 $spgur = "../apoyos/speaker_".$_GET["actualizar"].".jpg";
		 echo "<img src='$spgur'>";
		 ?>
		</td>
	   </tr>
	   <?
	  }
	  ?>
      
	  <tr>
	   <td>Nombre : </td>
	   <td>
		<input type="text" name="nombre" value="<?=$vnombre?>" maxlength="50">
	   </td>
	  </tr>
    
	  <tr>
	   <td>Url del Video : </td>
		<td >
		<input type="text" name="UrlVideo" value="<?=$vUrlVideo?>" maxlength="255">
	   </td>
	  </tr>

	  <tr>
	   <td>Descripcion del Video</td>
	   <td >
		<input type="text" name="DescVideo" value="<?=$vDescVideo?>" maxlength="255">
	   </td>
	  </tr>

	  <tr>
	   <td >Duracion del Video <br /> (Ej: 1 hora)</td>
	   <td >
		<input type="text" name="DurVideo" value="<?=$vDurVideo?>" maxlength="255" >
	   </td>
	  </tr>
	  
	  <tr>
	   <td>Activo</td>
	   <td>
		<select name="estado" id="estado">
		 <option value="1" <? if ($vestado==1){ ?> selected="selected" <? } ?>>SI</option>
		 <option value="0" <? if ($vestado==0){ ?> selected="selected" <? } ?>>NO</option>
		</select>
	   </td>
	  </tr>
		  
	  <tr>
	   <td >Fecha Limite <br>(en blanco para indefinido)</td>
	   <td ><input type="text" name="fecha" value="<?=$vfecha?>" maxlength="12" size="12" >
			(eje:2010-12-31) 
	   </td>
	  </tr>
	  
	  <tr>
	   <td >Numero de vistas<br>(en	cero para indefinido)</td>
	   <td ><input type="text" name="visita" value="<?=$vvisita?>" maxlength="12" size="12" ></td>
	  </tr>
	  
	  <tr>
	   <td>Datos del presentador <br /> Ej: John Doe - Gerente de Producto</td>
		<td >
		 <input type="text" name="PresVideo" value="<?=$vPresVideo?>" maxlength="255" >
		</td>
	  </tr>

	  <tr>
	   <td >Orden del Video :</td>
	   <td ><input type="text" name="OrdVideo" value="<?=$vOrdVideo?>" maxlength="2" size="2" ></td>
      </tr>
		   
	  <tr>
	   <td valign="top">Archivos Adjuntos:</td>
	   <td >
	   <?
		if($_GET["actualizar"]!="")
		 {
		  $RSresultado_apoyo=$objVideos->ConsultarMaterialApoyo($_GET["actualizar"]);
		  while ($row_apoyo = mysql_fetch_array($RSresultado_apoyo))
		  {
		   $vIdArchivo = $row_apoyo["IdArchivo"];
		   $vIdVideo = $row_apoyo["IdVideo"];
		   $vNombreArchivo = $row_apoyo["NombreArchivo"];
		   echo $vNombreArchivo." |  <a href='admvideos.php?idVideo=$vIdVideo&Quitar=$vIdArchivo' onclick=\"return confirm('Seguro que desea borrar?')\" target='_self'>Quitar</a><br/><br/>";
		  }
		 }
		?>
		</td>
      </tr>
      
	  <tr>
	   <td colspan="2" align="right" >
	   <? if (isset($IdSubGrupo)){ ?>
	   <input type="hidden" value="<?=$IdSubGrupo?>" name="IdSubGrupo">
       <? }else{ ?>
       <input type="hidden" value="<?=$IdGrupos?>" name="IdGrupos">
       <? } ?>
	   </td>
	  </tr>
	  
	  <tr>
	   <td colspan="2" align="center">
		<input type="image" src="../imagenes/ingresar.jpg"><a href="<?=$_SERVER['PHP_SELF']?>">
		<img src="../imagenes/cancelar.jpg" alt="borrar" border="0" /></a>
		<br><br>
		<?=$msg?>
	   </td>
	  </tr>
     </table>
	</fieldset>
   </form>
   <br> 
   <table border="1" bordercolor="D4D4D4" cellpadding="5" cellspacing="0">
	<tr bgcolor="D4D4D4" >
	 <td width="74%" >Nombre</td>
	 <td width="7%">Borrar</td>
	 <td width="11%">Subir Material</td>
	 <td width="11%">Subir Foto Expositor</td>
	 <td width="11%">Activo</td>
	 <td width="11%">Orden</td>					
	 <td width="15%"  align="center" >Cuestionario	</td>
	 <?
	  if (isset($IdSubGrupo))
	  { 
	   $RSresultado=$objVideos->ConsultarVideos($IdSubGrupo);
	  }
	  else
	  {
	   $RSresultado=$objVideos->ConsultarVideosGrupos($IdGrupos);
	  }
	  while ($row = mysql_fetch_assoc($RSresultado))
	  {
	   extract($row);
	   ?> 
		<tr bgcolor="white" >
		 <td valign="top" ><a href="admvideos.php?actualizar=<?=$Idvideo?>&<? if (isset($IdSubGrupo)){ echo "IdSubGrupo=".$IdSubGrupo; }else{ echo "IdGrupos=".$IdGrupos; }?>"><?=$nombre?></a></td>
		 <td valign="top" >
		 <?php
		  if (isset($IdSubGrupo))
		  { 
		   ?><a href="admvideos.php?borrar=<?=$Idvideo?>&IdSubGrupo=<?=$IdSubGrupo?>" onclick="return confirm('Seguro que desea borrar?')" >Borrar</a><?php
		  }
		  elseif(isset($IdGrupos))
		  {
		   ?><a href="admvideos.php?borrar=<?=$Idvideo?>&IdGrupos=<?=$IdGrupos?>" onclick="return confirm('Seguro que desea borrar?')" >Borrar</a><?php
		  }
		  ?>
		  <td valign="top" >
		   <a href="subirmaterial.php?IdVideo=<?=$Idvideo ?>" target="_blank">Subir</a>
		  </td>
		  
		  <td valign="top" >
		   <a href="subirspeaker.php?IdVideo=<?=$Idvideo ?>"  target="_blank">Subir</a>
		  </td>
		 </td>
		 <td width="11%" valign="top" ><?
		  if ($estado==1) echo "<img src='../imagenes/iconos/ok.gif'>";
		  else echo "<img src='../imagenes/iconos/delete.gif'>";
		  ?>
		  </td>
		   <td width="11%" valign="top" ><?=$orden?></td>
		   <td align="center" valign="top"><a href="admmodulos.php?<? if (isset($IdSubGrupo)){ echo "IdSubGrupo=".$IdSubGrupo; }else{ echo "IdGrupos=".$IdGrupos; }?>&Idvideo=<?=$Idvideo?>"><img src="../imagenes/iconos/ok.png" border="0"></a></td>
		  </tr>
		   <? } ?>
		   </table>
   
   <br>
    <table border="1" bordercolor="D4D4D4" cellpadding="5" cellspacing="0" width="100%">
     <tr bgcolor="D4D4D4" >
      <td width="80%"> Nombre </td>
      <td align="center">Borrar</td>
       <tr>
       <?
		$RSresultado=$objUsuario->consultarDepartamentos();
		while ($row = mysql_fetch_array($RSresultado))
		{
		 $IdDepartamento=$row["IdDepartamento"]; 
		 $NomDepartamento=$row["NomDepartamento"];
		 ?>
		 <tr bgcolor="white" >
		  <td width="80%" valign="top">
		   <a href="admdeptos.php?actualizar=<?=$IdDepartamento?>" style="color:red "><?=$NomDepartamento?></a>
		  </td>
		  <td>
		   <a href="admdeptos.php?borrar=<?=$IdDepartamento?>" onclick="return confirm('Seguro que desea borrar?')" >Borrar</a>
		  </td>
		 <tr>
		 <?
		}
		?>
       <tr>
      </tr>
	  </table><br><br>
    </td>
   </tr>
  </table>
 </div>
</div>
<!-- end #content -->
<?php include("sidebar.php"); ?>
  <div style="clear: both;">&nbsp;</div>
</div>
<!-- end #page -->
</div>
<?php include("footer.php"); ?>
</body>
</html>