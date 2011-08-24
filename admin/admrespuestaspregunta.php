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

///ingresar respuesta    
if($_POST["ingresar"]!="")
 {	
    $correcta=0;
 	if($_POST["valorCorrecta"]!="")
	 {
	    $correcta=1;
	 }
	 
    $objExamen->ingresarRespuesta($_GET["pregunta"],$_POST["valorDetalle"],$correcta);
    $msg="Registro ingresado";
 }

///actualizar
if($_POST["actualizar"]!="")
 {
    $correcta=0;
 	if($_POST["valorCorrecta"]!="")
	 {
	    $correcta=1;
	 }

    $objExamen->actualizarRespuesta($_POST["actualizar"],$_POST["valorDetalle"],$correcta);
    $msg="Registro actualizado";
 }

///borrar registro 
if($_GET["borrar"]!="")
 {
    $RSresultado=$objExamen->borrarRespuseta($_GET["borrar"]);
    $msg="Registro borrado";
 }
 
//informacion de la respuesta seleccionada 
if($_GET["actualizar"]!="")
 {
   $RSresultado=$objExamen->consultarDetalleRespuesta($_GET["actualizar"]);
   while ($row = mysql_fetch_array($RSresultado))
	 {
	  $vDetalleRespuesta=$row["DetalleRespuesta"]; 
	  $vCorrecta=$row["Correcta"]; 
     }
 }

//informacion de la pregunta seleccionada
if($_GET["pregunta"]!="")
 {
   $RSresultado=$objExamen->consultarDetallePregunta($_GET["pregunta"]);
   while ($row = mysql_fetch_array($RSresultado))
	 {
	  $vDetallePregunta=$row["DetallePregunta"]; 
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
  <!-- banner superior -->
  <tr>
    <td class="body-text1" height="120"><img src="../imagenes/titulo.jpg" width="751" height="120"></td>
  </tr>
  <!-- menu superior -->
  <tr>
    <td class="body-text1"  height="20" align="right"><table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td width="10"><img src="imagenes/spacer.gif" width="1" height="1"></td>
        <td align="left"></td>
        <td class="body-text1" width="220"></td>
        <td width="10"><img src="imagenes/spacer.gif" width="1" height="1"></td>
      </tr>
    </table></td>
  </tr>
  <!-- zona central -->
  <tr>
    <td class="body-text1" valign="top"><table width="750" height="100%" align="center" cellpadding="5" cellspacing="1">
      <tr>
        <td  height="1"><img src="imagenes/spacer.gif" width="1" height="1"></td>
      </tr>
      <tr>
        <td class="body-text1"  valign="top" align="left"><table>
          <tr>
            <td class="body-text1" ><img src="imagenes/iconos/regresar.png" width="16" height="16"> </td>
            <td class="body-text1" ><a href="javascript:history.go(-1)" style="color:red">Regresar</a> </td>
          </tr>
        </table>
              <br>
              <b>:: Respuestas:
                <?=$vDetallePregunta?>
              </b> <br>
          <br>
              <form name="formProceso" action="admrespuestaspregunta.php?pregunta=<?=$_GET["pregunta"]?>&examen=<?=$_GET["examen"]?>" method="post" onSubmit="return validaPregunta()">
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
                    <td class="body-text1" valign="top"> Detalle </td>
                    <td class="body-text1" valign="top"><textarea name="valorDetalle" class="controles1" rows="6" cols="50"><?=$vDetalleRespuesta?>
  </textarea>
                    </td>
                  </tr>
                  <tr>
                    <td class="body-text1" valign="top"> Corr&eacute;cta </td>
                    <td class="body-text1" valign="top"><input type="checkbox" name="valorCorrecta" value="1" <? if($vCorrecta=="1"){?> checked <? } ?> >
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2" align="right" class="body-text1"><input name="image" type="image" src="imagenes/ingresar.jpg">
                        <br>
                      <br>
                        <?=$msg?>
                    </td>
                  </tr>
                </table>
              </form>
          <br>
              <table border="1" bordercolor="D4D4D4" cellpadding="5" cellspacing="0" width="100%">
                <tr bgcolor="D4D4D4" >
                  <td class="body-text1" width="80%"> Detalle respuesta </td>
                  <td class="body-text1"  align="center"> Corr&eacute;cta </td>
                  <td class="body-text1"  align="center"> Borrar </td>
                <tr>
                  <?
		   $RSresultado=$objExamen->consultarRespuestasPregunta($_GET["pregunta"]);
		   while ($row = mysql_fetch_array($RSresultado))
			 {
			  $IdRespuesta=$row["IdRespuesta"]; 
			  $DetalleRespuesta=$row["DetalleRespuesta"]; 
			  $Correcta=$row["Correcta"]; 
			  ?>
                <tr bgcolor="white" >
                  <td class="body-text1" width="80%" valign="top"><a href="admrespuestaspregunta.php?pregunta=<?=$_GET["pregunta"]?>&examen=<?=$_GET["examen"]?>&actualizar=<?=$IdRespuesta?>" style="color:red ">
                    <?=$DetalleRespuesta?>
                  </a> </td>
                  <td class="body-text1"  align="center" valign="top"><?
				 if($Correcta=="1")
				  {
				   echo(" S ");
				  }
				 else
				  {
				    echo(" <font color=white>.</font>");
				  }
				 ?>
                  </td>
                  <td class="body-text1"  align="center" valign="top"><a href="admrespuestaspregunta.php?pregunta=<?=$_GET["pregunta"]?>&examen=<?=$_GET["examen"]?>&borrar=<?=$IdRespuesta?>" onClick="return validarBorrar()"><img src="imagenes/iconos/delete.gif" border="0"></a> </td>
                <tr>
                  <?
			 }
		   ?>
              </table></td>
      </tr>
      <tr>
        <td  height="10"><img src="imagenes/spacer.gif" width="1" height="1"></td>
      </tr>
    </table></td>
  </tr>
  <!-- footer -->
  <tr>
    <td  background="imagenes/seccion.jpg" class="body-text1" height="20" align="center"></td>
  </tr>
</table> 

</body>
</html>
