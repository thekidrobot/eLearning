<?
include("includes/connection.php");
include("clases/clsexamen.php");

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

///ingresar examen 
if($_POST["ingresar"]!="")
 {
    $objExamen->ingresar($_POST["valorTitulo"],$_POST["valorPreguntas"],$_POST["valorCalificacion"]);
    $msg="Registro ingresado";
 }

///actualizar
if($_POST["actualizar"]!="")
 {
    $objExamen->actualizar($_POST["actualizar"],$_POST["valorTitulo"],$_POST["valorPreguntas"],$_POST["valorCalificacion"]);
    $msg="Registro actualizado";
 }


//informacion registro seleccionado
if($_GET["actualizar"]!="")
 {
   $RSresultado=$objExamen->consultarDetalle($_GET["actualizar"]);
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
			 <a href="menuadmin.php" style="color:red">Menú principal</a>
			</td>
		   </tr>
		  </table>
		  <br>
		  <b>:: Cuestionarios</b> 
		  <br><br>
		  <form name="formProceso" action="admcuestionarios.php" method="post" onSubmit="return validaExamen()">
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
		    <td class="body-text1">
			 Titulo
			</td>
		    <td class="body-text1">
			 <input type="text" name="valorTitulo" value="<?=$vTitulo?>" maxlength="100" size="50" class="controles1">
			</td>
		   </tr>

		   <tr>
		    <td class="body-text1">
			 Número preguntas prueba
			</td>
		    <td class="body-text1">
			 <input type="text" name="valorPreguntas" value="<?=$vPreguntas?>"  size="10" maxlength="3" class="controles1">
			</td>
		   </tr>

		   <tr>
		    <td class="body-text1">
			 Calificación
			</td>
		    <td class="body-text1">
			 <input type="text" name="valorCalificacion" value="<?=$vCalificacion?>" size="10" maxlength="3" class="controles1">
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
			  Titulo
			</td>
		    <td class="body-text1"  align="center">
			  Preguntas
			</td>
		   <tr>
		   
		   <?
		   $RSresultado=$objExamen->consultarExamenes();
		   while ($row = mysql_fetch_array($RSresultado))
			 {
			  $IdExamen=$row["IdExamen"]; 
			  $Titulo=$row["Titulo"]; 
			  ?> 
			   <tr bgcolor="white" >
				<td class="body-text1" width="80%" valign="top">
				 <a href="admcuestionarios.php?actualizar=<?=$IdExamen?>" style="color:red "><?=$Titulo?></a>
				</td>
				<td class="body-text1"  align="center" valign="top">
				 <a href="admpreguntas.php?examen=<?=$IdExamen?>"><img src="imagenes/iconos/editar.png" border="0"></a>
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
