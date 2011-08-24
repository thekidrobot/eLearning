<?
include("conexion.php");
include("clases/clsVideos.php");
include("clases/clsSubGrupo.php");

session_start();

$objVideos=new clsVideos();
$objTaller=new clsSubGrupo();

extract($_GET);

//validar sesion
if($_SESSION["usuario"]==""){
 ?>
 <script language="javascript">document.location="index.php";</script>
 <?
}
?>
<html>
 <head>
  <title>:: CUESTIONARIO ::</title>
  <!-- refresco de pantalla para activar o no contenido-->
  <?php if (isset($IdSubGrupo)) {?>
  <meta http-equiv="refresh" content="30; url=consultainfo.php?IdSubGrupo=<?=$IdSubGrupo ?>" />
  <?php
  }
  if (isset($IdGrupos)) { ?>
  <meta http-equiv="refresh" content="30; url=consultainfo.php?IdGrupos=<?=$IdGrupos?>" />
  <?php
  }
  ?>
  <!-- fin refresco de pantalla para activar o no contenido-->
  <link rel="stylesheet" href="css/INDEX.CSS">
  <script language="javascript" src="js.js"></script>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
 <style type="text/css">
<!--
body {
	background-color: #000;
}
-->
</style></head>
 <body leftmargin="0" topmargin="0" >
 <table width="710" height="2%" align="center" cellpadding="5" cellspacing="1">
  <tr>
   <td width="657" height="316" align="left"  valign="top" class="body-text1">
	<table width="672" border="0" cellpadding="0"  background="imagenes/navegacion.jpg"cellspacing="0" repeat="no">
	 <tr>
	  <td width="3%" height="33" valign="middle" background="" class="tahoma_11_light">&nbsp;</td>
	  <td width="97%" valign="middle" background="" class="stepactive_gris"><?
	if (isset($IdSubGrupo))
	{ 
	 $sql = "SELECT c.categorias, sg.NombreSubGrupo,g.grupos
			 FROM 	subgrupos sg, grupos g, categorias c
			 WHERE 	sg.IdGrupos = g.IdGrupos
			 AND 	c.IdCategorias = g.IdCategorias
			 AND 	sg.IdSubGrupo = $IdSubGrupo";
			   
	 $link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
	 mysql_select_db($_SESSION["basededatos"], $link);	
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

	 $link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
	 mysql_select_db($_SESSION["basededatos"], $link);	
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
	  <td width="3%" height="33" valign="middle" background="" class="tahoma_11_light">&nbsp;</td>
	  <td width="97%" valign="middle" background="" class="stepactive_gris">
	   Existen <?=$nmodulos?> modulos disponibles
	  </td>
	</tr>
	 </table>
	
	<?php
	while ($row = mysql_fetch_assoc($RSresultado))
	{
	 extract($row);
	 ?>
	<table width="670" border="0" cellpadding="5" cellspacing="0" bordercolor="D4D4D4" class="borde_gris_debajo">
	  <tr bgcolor="white" >
	   <td height="31" colspan="3" align="right" valign="middle" bgcolor="#DFDFDF" class=" fondo_tabla_ver">
	    <table width="461" border="0" align="left">
		 <tr>
	      <td width="301" valign="middle" class="tahoma_13_azul"> &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;<?=$nombre?></td>
	
	      <?php
	       $RSVideosVistos = $objVideos->ConsultaVideosVistos($_SESSION['idusuario'],$Idvideo);
	       $row = mysql_num_rows($RSVideosVistos);
	       if($row == 0) $ico = 'imagenes/iconos/delete.gif';
	       else $ico = 'imagenes/iconos/ok.gif';
	      ?>

	      <td width="150" align="right"><img src="<?=$ico?>">&nbsp;&nbsp;&nbsp;<a href="actualizapres.php?Idvideo=<?=$Idvideo?>" target="_blank" class="tahoma_11_derecha">Ver Presentación </a></td>
	     </tr>
	    </table>
	   </td>
	   <td  width="188" height="31" align="center" valign="middle" bgcolor="#DFDFDF"  class=" fondo_tabla_material" > Material de apoyo </td>
		<tr>
		 <td width="100" bgcolor="#FFFFFF" class="stepactive_gris">
		  <img src="apoyos/<?=$urlpic ?>" height="100" width="100" />
		 </td>
		 <td width="341" valign="top" bgcolor="#DFDFDF" class="stepactive_gris"><table width="320" border="0" cellpadding="0" cellspacing="0">
		   <tr>
		     <td colspan="2" class="tahoma_11_light"><?=$descripcion?></td>
		     </tr>
            <tr>
              <td width="66" class="stepactive_gris"><strong>Duraci&oacute;n:</strong></td>
              <td width="254" class="stepactive_gris"><?=$duracion?></td>
            </tr>
            <tr>
              <td valign="top" class="stepactive_gris"><strong>Expositor:</strong></td>
              <td valign="top" class="stepactive_gris"><?=$presentador?></td>
            </tr>
          </table></td>
		  <td width="1" valign="top" bgcolor="#DFDFDF" class="stepactive_gris">&nbsp;</td>
		  <td valign="top" width="188" class="stepactive_gris"><?php
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
		   <tr bgcolor="white" >
		    <td height="32" colspan="4" valign="middle" bgcolor="#DFDFDF" class="fondo_tabla_test">&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong> &nbsp;Esta presentaci&oacute;n tiene un test asociado</strong></td>
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
		    <tr bgcolor="white" class="borde_gris_debajo" >
		      <td colspan="2" valign="middle" class="tahoma_11_light"> &nbsp;<?=$Titulo?></td>
		      <td valign="top" class="tahoma_11_light">&nbsp;</td>
        </tr>
		    <tr bgcolor="white" class="borde_gris_debajo" >
		    <td colspan="2" align="left" valign="middle" class="tahoma_11_light"><table border="0" align="left">
		      <tr>
		        <td><div align="left">
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
		          </div></td>
	          </tr>
		      </table></td>
		    <td valign="top" class="tahoma_11_light">&nbsp;</td>
	    </tr>
		 <?
		}	
	  ?>
     </table>
	 <table width="670" height="27" border="0" cellpadding="0" cellspacing="0">
	  <tr>
	    <td width="644" bgcolor="#DFDFDF"><?
	}
	$RSVideosVistos = $objVideos->ConsultaVideosVistos($_SESSION['idusuario'],$Idvideo);
	$row = mysql_num_rows($RSVideosVistos);
	if($row == 0 and $orden != 0) break;
   }
  ?></td>
	    </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
