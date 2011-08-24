<?
include("../conexion.php");
include("../clases/clsSubGrupo.php");
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
<html>
<head>
<title>:: TALLERES ::</title>
<link rel="stylesheet" href="../css/INDEX.CSS">
<script language="javascript" src="js.js">
</script>
</head>
<body leftmargin="0" topmargin="0" background="imagenes/fondo2.jpg" > 
<table width="800" height="100%" align="center" cellpadding="0" cellspacing="0">

 <tr>
  <td width="104"><img src="imagenes/spacer.gif" width="1" height="1"></td>
  <td width="16" background="imagenes/fondo3.jpg"></td>
  <td width="751" bgcolor="white" valign="top">
   <table width="100%" height="100%" cellpadding="0" cellspacing="0">
    <!-- banner superior -->
    <!-- menu superior -->
    <!-- zona central -->
    <tr>
	 <td class="body-text1" valign="top">
	  <table cellpadding="5" cellspacing="1" width="100%" height="100%">
	   <tr>
	     <td class="body-text1" background="imagenes/fondoPAGINA.jpg"  valign="top" align="left">
	       <table>
	         <tr>
	           <td class="body-text1" >&nbsp;</td>
	           <td class="body-text1" >| <a href="admpreguntasmodulo.php?IdModulo=<?=$_GET["IdModulo"]?>&Idtaller=<?=$_GET["Idtaller"]?>" style="color:red">Regresar</a>
	             </td>
	           </tr>
	         </table>
	       <br>
	       <b>:: Respuestas</b>
	       <br><br>
	       <?=$taller?> | <?=$Titulomodulo?>
	       <br><br>
	       <form name="formProceso" action="admrespuesmodvideo.php?IdPregunta=<?=$_GET["IdPregunta"]?>&IdModulo=<?=$_GET["IdModulo"]?>&Idvideo=<?=$_GET["Idvideo"]?>" method="post" onSubmit="return validaRespModuloTall()">
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
	             <td class="body-text1" valign="top">
	               Respuesta
	               </td>
	             <td class="body-text1" valign="top">
	               <textarea name="valorResp" class="controles1" rows="7" cols="100"><?=$vDetalleRespuesta?></textarea>
	               </td>
	             </tr>
	           
	           <tr>
	             <td class="body-text1" valign="top">
	               Correcta
	               </td>
	             <td class="body-text1" valign="top">
	               <select name="correcta" class="controles1">
	                 <option value="1" <? if($vCorrecta=="1"){ ?> selected <? } ?> >SI</option>
	                 <option value="0" <? if($vCorrecta=="0"){ ?> selected <? } ?> >NO</option>
	                 </select>
	               </td>
	             </tr>
	           
	           <tr>
	             <td colspan="2" align="left" class="body-text1">
	               <input type="image" src="imagenes/ingresar.jpg">
	               <br><br>
	               <?=$msg?>
	               </td>
	             </tr>
	           </table>
	         </form>
	       <br>
	       <table border="1" bordercolor="D4D4D4" cellpadding="5" cellspacing="0" width="100%">
	         <tr bgcolor="D4D4D4" >
	           <td width="70%" class="body-text1" >
	             Respuestas
	             </td>
	           <td width="30%" class="body-text1" >
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
	               <td class="body-text1"  valign="top">
	                 <a href="admrespuesmodvideo.php?actualizar=<?=$IdRespuesta?>&IdPregunta=<?=$_GET["IdPregunta"]?>&IdModulo=<?=$_GET["IdModulo"]?>&Idtaller=<?=$_GET["Idtaller"]?>" style="color:red "><?=$DetalleRespuesta?></a>
	                 </td>
	               <td class="body-text1"  valign="top">
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
	       <br><br>
	       </td>
	     </tr>
	   <tr>
	    <td  height="10"><img src="imagenes/spacer.gif" width="1" height="1"></td>
	   </tr>
	  </table>
	 </td>
	</tr>
	<!-- footer -->
    <tr>
	 <td  background="imagenes/seccion.jpg" class="body-text1" height="20" align="center">
	 </td>
	</tr>
   </table>
  </td>
  <td width="13" background="imagenes/fondo4.jpg">
  </td>
  <td><img src="imagenes/spacer.gif" width="1" height="1"></td>
 </tr>
 <tr>
  <td colspan="5" height="50"><img src="imagenes/spacer.gif" width="1" height="1"></td>
 </tr>
</table>
</body>
</html>
