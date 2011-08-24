<?
include("conexion.php");
include("clases/clsusuario.php");
include("clases/clsSubGrupo.php");

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
?>
<html>
<head>
<title>:: CUESTIONARIO ::</title>
<link rel="stylesheet" href="css/INDEX.CSS">
<script language="javascript" src="js.js">
</script>
</head>
<body leftmargin="0" topmargin="0" >
<table width="500" height="100%" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td  height="25"><span class="titulo_curso">Resultados</span></td>
  </tr>
  <tr>
    <td  height="35"><img src="imagenes/spacer.gif" width="1" height="1">
      <table width="80" align="right">
        <tr>
          <td width="95" class="body-text1" ><div align="right" class="tahoma_11_light"><a href="javascript:history.go(-1)" class="tahoma_11_light" style="color:gray">Regresar</a></div></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td height="33" align="left"  valign="top" class="titulo_curso"><span class="body-text1"><img src="imagenes/pestana_pres.jpg" width="551" height="33"></span></td>
  </tr>
  <tr>
    <td height="80" align="left"  valign="top" class="tahoma_11_light"><?
		   $RSresultado=$objTaller->consultarDetalleModulo($_GET["IdModulo"]);
		   while ($row = mysql_fetch_array($RSresultado))
			 {
			  $Calificacion=$row["Calificacion"]; 
			  $CalificacionMinima=$row["CalificacionMinima"]; 
			 }

		   $contador=1;
		   $puntosAFavor=0;
		   $valorPunto=$Calificacion/$_POST["numeroPreguntas"];
		   $notaFinal=0;
		   
		   while($contador<=$_POST["numeroPreguntas"])
		    {
			 $nombrecontrol="opcion".$contador;
			 $respuesta="0";
			 
			 if($_POST[$nombrecontrol]!="")
			  {
			    $respuesta=$objTaller->respuestaValida($_POST[$nombrecontrol]);
			  }
			 
			 if($respuesta=="1")
			  {
			    $puntosAFavor++;
			  }
			 			 
			 $contador++;
			}
			
			$notaFinal=$puntosAFavor*$valorPunto;
			$notaFinal=round($notaFinal * 100) / 100;  //redondear
			
			//guardar los datos en la base de datos
			 $objTaller->ingresarNotaObtenida($_SESSION["idusuario"],$_GET["IdModulo"],$notaFinal,$Calificacion,$CalificacionMinima);
			
	       ?>
Sus respuestas se han enviado satisfactoriamente. <br>
<br>
Su puntuaci&oacute;n ha sido:
<?=$notaFinal?>
<br>
<br>
<? 
     // $RSresultado1=$objTaller->consultarDetalle($_GET["IdExamen"]);
  // $row = mysql_fetch_array($RSresultado1);
  echo ' Calificacion minima para aprobar: ';
  echo $CalificacionMinima;
  
			if ($notaFinal>=$CalificacionMinima) { ?>
<br>
<a href="diploma.php?IdModulo=<?=$_GET["IdModulo"]?>" target="_blank"> <br>
Ver Certificado</a>
<? }?>
<br>
<span class="body-text1"><br>
<br>
<img src="imagenes/continuar.jpg" alt="" width="89" height="38" border="0" usemap="#Map"></span><br>
<br>
<map name="Map">
  <area shape="rect" coords="6,5,83,31" href="blank.html">
</map></td>
  </tr>
  <tr>
    <td height="29" align="left"  valign="top" class="tahoma_11_light"><br></td>
  </tr>
  <tr>
    <td height="52" align="left"  valign="top" class="body-text1">&nbsp;</td>
  </tr>
  <tr>
    <td  height="10"><img src="imagenes/spacer.gif" width="1" height="1"></td>
  </tr>
</table>
</body>
</html>
