<?php include("header.php"); ?>
<?

///objetos
$objTaller=new clsSubGrupo();
$msg="";

///ingresar respuesta valorResp         
if($_POST["ingresar"]!="")
 {
    $objTaller->ingresarrespPregMod($_GET["IdPregunta"],$_POST["valorResp"],$_POST["correcta"]);
    $msg="Registro ingresado";
 }

///actualizar
if($_POST["actualizar"]!="")
 {
    $objTaller->actualizarrespPregMod($_POST["actualizar"],$_POST["valorResp"],$_POST["correcta"],$_GET["IdPregunta"]);
    $msg="Registro actualizado";
 }


//informacion registro seleccionado
if($_GET["actualizar"]!="")
 {
   $RSresultado=$objTaller->consultarDetalleRespPregMod($_GET["actualizar"]);
   while ($row = mysql_fetch_array($RSresultado))
	 {
	  $vDetalleRespuesta=$row["DetalleRespuesta"]; 
	  $vCorrecta=$row["Correcta"]; 
     }
 }

//informacion taller seleccionado
if($_GET["Idtaller"]!="")
 {
   $RSresultado=$objTaller->consultarDetalleTaller($_GET["Idtaller"]);
   while ($row = mysql_fetch_array($RSresultado))
	 {
	  $taller=$row["NombreTaller"]; 
     }
 }

//informacion modulo seleccionado
if($_GET["IdModulo"]!="")
 {
   $RSresultado=$objTaller->consultarDetalleModulo($_GET["IdModulo"]);
   while ($row = mysql_fetch_array($RSresultado))
	 {
	  $Titulomodulo=$row["Titulo"]; 
     }
 }

?>
<body>
<div id="wrapper">
 <?php include("top_menu.php"); ?>
 <div id="page">
  <div id="content">
   <div class="post">
	
   <table>
	  <tr>
		 <td><a href="admpreguntasmodulo.php?IdModulo=<?=$_GET["IdModulo"]?>&Idtaller=<?=$_GET["Idtaller"]?>">Regresar</a></td>
	  </tr>
   </table>
   
   <br>
	  <b>:: Respuestas</b>
	  <br><br><?=$taller?> | <?=$Titulomodulo?>
	  <br><br>
	  <form name="formProceso" action="admrespuesmodvideo.php?IdPregunta=<?=$_GET["IdPregunta"]?>&IdModulo=<?=$_GET["IdModulo"]?>&Idvideo=<?=$_GET["Idvideo"]?>" method="post" onSubmit="return validaRespModuloTall()">
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
	  <table>

		 <tr>
			<td colspan="2">Ingresar Respuestas</td>
	     </tr>
		 
		 <tr>
			<td>&nbsp;</td>
	     </tr>

		 <tr>
			<td valign="top">Respuesta</td>
			<td valign="top">
			   <textarea name="valorResp" class="controles1" rows="7" cols="70"><?=$vDetalleRespuesta?></textarea>
			</td>
	     </tr>
	           
	     <tr>
			<td  valign="top">Correcta</td>
			<td  valign="top">
			  <select name="correcta" class="controles1">
				<option value="1" <? if($vCorrecta=="1"){ ?> selected <? } ?> >SI</option>
				<option value="0" <? if($vCorrecta=="0"){ ?> selected <? } ?> >NO</option>
				</select>
			  </td>
		 </tr>
	           
	     <tr>
			<td colspan="2" align="left" ><input type="image" src="../imagenes/ingresar.jpg">
			   <br><br>
			   <?=$msg?>
			</td>
	     </tr>
	  </table>
	  </fieldset>
	  </form>
	  
	  <br>
		 <table border="1" bordercolor="D4D4D4" cellpadding="5" cellspacing="0" width="100%">
	         <tr bgcolor="D4D4D4" >
	           <td width="70%"  >
	             Respuestas
	             </td>
	           <td width="30%"  >
	             Correcta
	             </td>
	           <tr>
	             
	             <?
		   $RSresultado=$objTaller->consultarRepuestasTotalesPregMod($_GET["IdPregunta"]);
		   while ($row = mysql_fetch_array($RSresultado))
			 {
			  $IdRespuesta=$row["IdRespuesta"]; 
			  $DetalleRespuesta=$row["DetalleRespuesta"]; 
			  $Correcta=$row["Correcta"]; 
			  ?> 
	             <tr bgcolor="white" >
	               <td   valign="top">
	                 <a href="admrespuesmodvideo.php?actualizar=<?=$IdRespuesta?>&IdPregunta=<?=$_GET["IdPregunta"]?>&IdModulo=<?=$_GET["IdModulo"]?>&Idtaller=<?=$_GET["Idtaller"]?>" style="color:red "><?=$DetalleRespuesta?></a>
	                 </td>
	               <td   valign="top">
	                 <?
				 if($Correcta=="1")
				  {
				   echo("SI");
				  }
				 else
				  {
				   echo("NO");
				  }
				 ?>
	                 </td>
	               <tr>
	                 <?
			 }
		   ?>
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