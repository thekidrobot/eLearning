<?php include("header.php"); ?>
<?

///objetos
$objTaller=new clsSubGrupo();
$msg="";

///ingresar pregunta         
if($_POST["ingresar"]!="")
 {
    $objTaller->ingresarPreguntaTaller($_GET["IdModulo"],$_POST["valorPregunta"]);
    $msg="Registro ingresado";
 }

///actualizar
if($_POST["actualizar"]!="")
 {
    $objTaller->actualizarPreguntaTaller($_POST["actualizar"],$_POST["valorPregunta"]);
    $msg="Registro actualizado";
 }


//informacion registro seleccionado
if($_GET["actualizar"]!="")
 {
   $RSresultado=$objTaller->consultarDetallePreguntaTaller($_GET["actualizar"]);
   while ($row = mysql_fetch_array($RSresultado))
	 {
	  $vDetallePregunta=$row["DetallePregunta"]; 
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
	
     <b>:: Preguntas</b>
	 <br>
     <br>
     <?=$taller?> | <?=$Titulomodulo?>
	  <br>
      <br>
      <form name="formProceso" action="admpreguntasmodulo.php?IdModulo=<?=$_GET["IdModulo"]?>&Idvideo=<?=$_GET["Idvideo"]?>" method="post" onSubmit="return validaPreguntaTaller()">
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
			   <td colspan="2"> Ingresar Preguntas </td>
			</tr>

			<tr>
			   <td colspan="2"> &nbsp;</td>
			</tr>
			
			<tr>
			 <td valign="top" width="30%"> Pregunta : </td>
             <td valign="top"><textarea name="valorPregunta" rows="7" cols="50"><?=$vDetallePregunta?></textarea></td>
			</tr>
			
			<tr align="left">
			 <td colspan="2"><input name="image" type="image" src="../imagenes/ingresar.jpg">
			  <br>
			  <br>
			  <?=$msg?>
			 </td>
            </tr>
         </table>
		 </fieldset>
      </form>
      
	  <br>
      <table border="1" bordercolor="D4D4D4" cellpadding="5" cellspacing="0" width="100%">
		 <tr bgcolor="D4D4D4" >
			<td  width="80%"> Pregunta </td>
            <td  align="center"> Respuestas </td>
         <tr>
         <?
			$RSresultado=$objTaller->consultarPreguntTalleresMod($_GET["IdModulo"]);
			while ($row = mysql_fetch_array($RSresultado))
			{
			   $IdPregunta=$row["IdPregunta"]; 
			   $DetallePregunta=$row["DetallePregunta"]; 
			   ?>
			   <tr bgcolor="white" >
				  <td  width="80%" valign="top">
					 <a href="admpreguntasmodulo.php?actualizar=<?=$IdPregunta?>&IdModulo=<?=$_GET["IdModulo"]?>&Idtaller=<?=$_GET["Idtaller"]?>"><?=$DetallePregunta?></a>
				  </td>
				  <td align="center" valign="top">
					 <a href="admrespuesmodvideo.php?IdPregunta=<?=$IdPregunta?>&IdModulo=<?=$_GET["IdModulo"]?>&Idvideo=<?=$_GET["Idvideo"]?>"><img src="../imagenes/iconos/ok.png" border="0"></a>
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