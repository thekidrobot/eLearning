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
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
<!--
body {
	background-color: #DFDFDF;
}
-->
</style></head>
<body leftmargin="0" topmargin="0" >
<table width="24%" height="100%" align="center" cellpadding="5" cellspacing="1">
      
      <tr>
        <td height="29" align="left"  valign="bottom" class="tahoma_11"><table align="right">
          <tr>
              <td class="body-text1" ><div align="right"><a href="javascript:history.go(-1)" class="tahoma_11_light" style="color:gray">Regresar</a></div></td>
          </tr>
        </table></td>
  </tr>
      <tr>
        <td height="31" align="left"  valign="bottom" class="tahoma_11"><strong>Test de
            <?
		   $RSresultado=$objTaller->consultarPreguntTalleresMod($_GET["IdModulo"]);
		   $contador=1;
		   $row = mysql_fetch_array($RSresultado);
		   echo $row["Titulo"];
		  ?>
        </strong></td>
      </tr>
      <tr>
        <td height="43" align="left"  valign="top" class="body-text1"><img src="imagenes/pestana_pres.jpg" width="661" height="33"></td>
      </tr>
      <tr>
        <td class="body-text1"  valign="top" align="left"><form name="formulario" action="respuestaexamen.php?IdModulo=<?=$_GET["IdModulo"]?>" method="post" onSubmit="return validarExamen()">
              <table width="95%" border="0" align="center" cellpadding="5" cellspacing="0" bordercolor="D4D4D4">
                <tr bgcolor="D4D4D4" >
                  <td bgcolor="#FFFFFF" class="tahoma_11_light">&nbsp;</td>
                <tr>
                  <?
		   $RSresultado=$objTaller->consultarPreguntTalleresMod($_GET["IdModulo"]);
		   $contador=1;
		   while ($row = mysql_fetch_array($RSresultado))
			 {
			  $IdPregunta=$row["IdPregunta"]; 
			  $DetallePregunta=$row["DetallePregunta"]; 
			  $nombrecontrol="opcion".$contador;
			  ?>
                <tr bgcolor="white" >
                  <td class="borde_gris_abajo_fuente"  valign="top"><?=$DetallePregunta?>
                      <br>
                      <br>
                      <table border="0" class="text10">
                   <?
				 $RSresultado2=$objTaller->consultarRepuestasTotalesPregMod($IdPregunta);
				  do{
				  if ($row["IdRespuesta"]!=""){
				 ?>
                      <tr>
                          <td width="30" valign="top" class="text10">
						  <input type="radio" value="<?=$row["IdRespuesta"]?>" name="<?=$nombrecontrol?>"></td>
                          <td valign="middle" class="tahoma_11"><?=$row["DetalleRespuesta"]?></td>
                        </tr>
                  <?
				 } } while ($row = mysql_fetch_array($RSresultado2));
				 ?>
                    </table>
                  </td>
                <tr>
                  <?
			   $contador++;
			 }
			 
			 $contador--;
		   ?>
                  <input type="hidden" name="numeroPreguntas" value="<?=$contador?>">
                <tr bgcolor="white" >
                  <td class="body-text1" align="left"><input type="image" src="imagenes/ingresar.jpg">                  </td>
                <tr>
              </table>
              <div align="center"></div>
            </form>
          <br>
            <br>        </td>
      </tr>
    </table>
</body>
</html>
