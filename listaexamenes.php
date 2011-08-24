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

$_SESSION["indicePreguntas"]="";

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
	  <table cellpadding="5" cellspacing="3" width="100%" height="100%">
	   <tr>
	    <td  height="1"><img src="imagenes/spacer.gif" width="1" height="1"></td>
	   </tr>
	   <tr>
		<td class="body-text1"  valign="top" align="left">
		 <b>:: Lista de examenes</b> | <a href="inicio.html" style="color:red">Salir</a>
		 <br><br>
		 Seleccione el examén que desea presentar:
		 <br><br>
		 <table border="1" bordercolor="D4D4D4" cellpadding="5" cellspacing="0" width="100%">
		   <tr bgcolor="D4D4D4" >
		    <td class="body-text1" width="40%">
			  Detalle
			</td>
		    <td class="body-text1"  align="center">
			  No. Preguntas
			</td>
		    <td class="body-text1"  align="center">
			  Nota máxima
			</td>
		    <td class="body-text1"  align="center">
			  Historial
			</td>
		    <td class="body-text1"  align="center">
			 Presentar
			</td>
		   <tr>

		   <?
		   $RSresultado=$objExamen->consultarExamenes();
		   while ($row = mysql_fetch_array($RSresultado))
			 {
			  $IdExamen=$row["IdExamen"]; 
			  ?> 
			   <tr bgcolor="white" >
				<td class="body-text1" width="40%" valign="top">
				  <?=$row["Titulo"]?>
				</td>
				<td class="body-text1"  align="center" valign="top">
				  <?=$row["Preguntas"]?>
				</td>
				<td class="body-text1"  align="center" valign="top">
				  <?=$row["Calificacion"]?>
				</td>
				<td class="body-text1"  align="left" valign="top">
				  <?
				   $RSresultado2=$objExamen->consultarHistorialExamen($_SESSION["idusuario"],$IdExamen);
				   while ($row2 = mysql_fetch_array($RSresultado2))
				    {
					 echo("<li>".$row2["Fecha"]." <br>Nota: ".$row2["NotaObtenida"]." Sobre ".$row2["NotaBase"]."<br><br>");
					}
				  ?>
				  <font color="white">.</font>
				</td>
				<td class="body-text1"  align="center" valign="top">
				 <a href="presentarexamen.php?IdExamen=<?=$IdExamen?>" onClick="return validarPresentarExamen()"><img src="imagenes/iconos/editar.png" border="0"></a>
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
