<?
include("../conexion.php");

include("../clases/clsexamen.php");

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
$objExamen=new clsexamen();
$msg="";

///ingresar pregunta  
if($_POST["ingresar"]!="")
 {
    $objExamen->ingresarPregunta($_GET["examen"],$_POST["valorDetalle"]);
    $msg="Registro ingresado";
 }

///actualizar
if($_POST["actualizar"]!="")
 {
    $objExamen->actualizarPregunta($_POST["actualizar"],$_POST["valorDetalle"]);
    $msg="Registro actualizado";
 }

///borrar registro 
if($_GET["borrar"]!="")
 {
    $RSresultado=$objExamen->borrarPregunta($_GET["borrar"]);
    $msg="Registro borrado";
 }
 
//informacion de la pregunta seleccionada 
if($_GET["actualizar"]!="")
 {
   $RSresultado=$objExamen->consultarDetallePregunta($_GET["actualizar"]);
   while ($row = mysql_fetch_array($RSresultado))
	 {
	  $vDetallePregunta=$row["DetallePregunta"]; 
     }
 }

//informacion del examen seleccionado
if($_GET["examen"]!="")
 {
   $RSresultado=$objExamen->consultarDetalle($_GET["examen"]);
   while ($row = mysql_fetch_array($RSresultado))
	 {
	  $vTitulo=$row["Titulo"]; 
	  $vPreguntas=$row["Preguntas"]; 
	  $vCalificacion=$row["Calificacion"]; 
     }
 }

?>
<html>
<head>
<title>:: CUESTIONARIO ::</title>
<link rel="stylesheet" href="INDEX.CSS">
<script language="javascript" src="js.js">
</script>
</head>
<body leftmargin="0" topmargin="0" background="imagenes/fondo2.jpg" > 
<table width="100%" height="100%" cellpadding="0" cellspacing="0">

 <tr>
  <td width="104"><img src="imagenes/spacer.gif" width="1" height="1"></td>
  <td width="16" background="imagenes/fondo3.jpg"></td>
  <td width="751" bgcolor="white" valign="top">
   <table width="100%" height="100%" cellpadding="0" cellspacing="0">
    <!-- banner superior -->
    <tr>
	 <td class="body-text1" height="120"><img src="imagenes/titulo.jpg" width="751" height="120"></td> 
	</tr>

    <!-- menu superior -->
    <tr>
	 <td class="body-text1"  height="20" align="right"> 
	  <table width="100%" cellpadding="0" cellspacing="0">
	   <tr>
		<td width="10"><img src="imagenes/spacer.gif" width="1" height="1"></td>	   
	    <td align="left">
		</td>
	    <td class="body-text1" width="220">
		</td>
	    <td width="10"><img src="imagenes/spacer.gif" width="1" height="1"></td>
	   </tr>
	  </table>
	 </td>
	</tr>
	

    <!-- zona central -->
    <tr>
	 <td class="body-text1" valign="top">
	  <table cellpadding="5" cellspacing="1" width="100%" height="100%">
	   <tr>
	    <td  height="1"><img src="imagenes/spacer.gif" width="1" height="1"></td>
	   </tr>
	   <tr>
		<td class="body-text1"  valign="top" align="left">
	      <table>
		   <tr>
		    <td class="body-text1" >
			 <img src="imagenes/iconos/regresar.png" width="16" height="16">
			</td>
		    <td class="body-text1" >
			 <a href="admcuestionarios.php" style="color:red">Regresar</a>
			</td>
		   </tr>
		  </table>
		  <br>
		  <b>:: Preguntas: <?=$vTitulo?> </b> 
		  <br><br>
		  <form name="formProceso" action="admpreguntas.php?examen=<?=$_GET["examen"]?>" method="post" onSubmit="return validaPregunta()">
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
			 Detalle
			</td>
		    <td class="body-text1" valign="top">
			 <textarea name="valorDetalle" class="controles1" rows="6" cols="70"><?=$vDetallePregunta?></textarea>
			</td>
		   </tr>

		   <tr>
		    <td colspan="2" align="right" class="body-text1">
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
		    <td class="body-text1" width="80%">
			  Detalle
			</td>
		    <td class="body-text1"  align="center">
			  Respuestas
			</td>
		    <td class="body-text1"  align="center">
			  Borrar
			</td>
		   <tr>
		   
		   <?
		   $RSresultado=$objExamen->consultarPreguntasExamen($_GET["examen"]);
		   while ($row = mysql_fetch_array($RSresultado))
			 {
			  $IdPregunta=$row["IdPregunta"]; 
			  $DetallePregunta=$row["DetallePregunta"]; 
			  ?> 
			   <tr bgcolor="white" >
				<td class="body-text1" width="80%" valign="top">
				 <a href="admpreguntas.php?examen=<?=$_GET["examen"]?>&actualizar=<?=$IdPregunta?>" style="color:red "><?=$DetallePregunta?></a>
				</td>
				<td class="body-text1"  align="center" valign="top">
				 <a href="admrespuestaspregunta.php?examen=<?=$_GET["examen"]?>&pregunta=<?=$IdPregunta?>"><img src="imagenes/iconos/editar.png" border="0"></a>
				</td>
				<td class="body-text1"  align="center" valign="top">
				 <a href="admpreguntas.php?examen=<?=$_GET["examen"]?>&borrar=<?=$IdPregunta?>" onClick="return validarBorrar()"><img src="imagenes/iconos/delete.gif" border="0"></a>
				</td>
			   <tr>
			  <?
			 }
		   ?>
		  </table>
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
