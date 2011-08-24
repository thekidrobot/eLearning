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
<html>
<head>
<title>:: TALLERES ::</title>
<link rel="stylesheet" href="../css/INDEX.CSS">
<script language="javascript" src="js.js">
</script>
</head>
<body leftmargin="0" topmargin="0" background="imagenes/fondo2.jpg" >
<table width="750" height="100%" align="center" cellpadding="0" cellspacing="0">
  <!-- banner superior -->
  <!-- menu superior -->
  <!-- zona central -->
  <tr>
    <td class="body-text1" valign="top"><table cellpadding="5" cellspacing="1" width="628" height="100%">
      <tr>
        <td width="614"  height="1"><img src="imagenes/spacer.gif" width="1" height="1"></td>
      </tr>
      <tr>
        <td class="body-text1" background="imagenes/fondoPAGINA.jpg"  valign="top" align="left"><table>
          <tr>
            <td class="body-text1" >&nbsp;</td>
            <td class="body-text1" >| <a href="javascript:history.go(-1)" style="color:red">Regresar</a> </td>
          </tr>
        </table>
              <br>
              <b>:: Preguntas</b> <br>
          <br>
              <?=$taller?>
          |
          <?=$Titulomodulo?>
          <br>
          <br>
          <form name="formProceso" action="admpreguntasmodulo.php?IdModulo=<?=$_GET["IdModulo"]?>&Idvideo=<?=$_GET["Idvideo"]?>" method="post" onSubmit="return validaPreguntaTaller()">
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
                <td class="body-text1" valign="top"> Pregunta </td>
                <td class="body-text1" valign="top"><textarea name="valorPregunta" class="controles1" rows="7" cols="50"><?=$vDetallePregunta?>
</textarea>
                </td>
              </tr>
              <tr>
                <td colspan="2" align="left" class="body-text1"><input name="image" type="image" src="imagenes/ingresar.jpg">
                      <br>
                  <br>
                      <?=$msg?>
                </td>
              </tr>
            </table>
          </form>
          <br>
          <table border="1" bordercolor="D4D4D4" cellpadding="5" cellspacing="0" width="86%">
            <tr bgcolor="D4D4D4" >
              <td class="body-text1" width="80%"> Pregunta </td>
              <td class="body-text1"  align="center"> Respuestas </td>
            <tr>
              <?
		   $RSresultado=$objTaller->consultarPreguntTalleresMod($_GET["IdModulo"]);
		   while ($row = mysql_fetch_array($RSresultado))
			 {
			  $IdPregunta=$row["IdPregunta"]; 
			  $DetallePregunta=$row["DetallePregunta"]; 
			  ?>
            <tr bgcolor="white" >
              <td class="body-text1" width="80%" valign="top"><a href="admpreguntasmodulo.php?actualizar=<?=$IdPregunta?>&IdModulo=<?=$_GET["IdModulo"]?>&Idtaller=<?=$_GET["Idtaller"]?>" style="color:red ">
                <?=$DetallePregunta?>
              </a> </td>
              <td class="body-text1"  align="center" valign="top"><a href="admrespuesmodvideo.php?IdPregunta=<?=$IdPregunta?>&IdModulo=<?=$_GET["IdModulo"]?>&Idvideo=<?=$_GET["Idvideo"]?>"><img src="../imagenes/iconos/ok.png" border="0"></a> </td>
            <tr>
              <?
			 }
		   ?>
            </table>
          <br>
          <br>
        </td>
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
