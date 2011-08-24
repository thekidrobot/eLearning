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

///ingresar modulo        
if($_POST["ingresar"]!="")
 {
    $objTaller->ingresaModulo($_POST["valorTitulo"],$_POST["valorNotaMax"],$_GET["Idvideo"],$_POST["valorNotaMIn"],$_POST["ValorEstado"]);
    $msg="Registro ingresado";
 }

///actualizar
if($_POST["actualizar"]!="")
 {
    $objTaller->actualizarModulo($_POST["actualizar"],$_POST["valorTitulo"],$_POST["valorNotaMax"],$_POST["valorNotaMIn"],$_POST["valorPresentacion"],$_POST["valorJuego"],$_POST["valorJuego2"],$_POST["ValorEstado"]);
    $msg="Registro actualizado";
 }


//informacion registro seleccionado
if($_GET["actualizar"]!="")
{
 $RSresultado=$objTaller->consultarDetalleModulo($_GET["actualizar"]);
 while ($row = mysql_fetch_array($RSresultado))
 {
  $vTitulo=$row["Titulo"]; 
  $vCalificacion=$row["Calificacion"]; 
  $vCalificacionMinima=$row["CalificacionMinima"];
  $vPresentacion=$row["Presentacion"];
  $vJuego=$row["Juego"]; 
  $vJuego2=$row["Juego2"]; 
  $vEstado=$row["estado"]; 
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

///borrar
if($_GET["borrar"]!="")
 {
    $objTaller->borrarModulo($_GET["borrar"]);
    $msg="Registro Borrado";
 }

?>

<html>
 <head>
  <title>:: CUESTIONARIO ::</title>
  <link rel="stylesheet" href="../css/INDEX.CSS">
  <script language="javascript" src="../js/wforms.js"></script>
 </head>
 <body leftmargin="0" topmargin="0" background="" > 
 <table width="797" height="100%" align="center" cellpadding="0" cellspacing="0">
 <tr>
  <td width="22"><img src="../imagenes/spacer.gif" width="1" height="1"></td>
  <td width="774" bgcolor="white" valign="top">
   <table width="89%" height="100%" cellpadding="0" cellspacing="0">
   <!-- banner superior -->
   <!-- menu superior -->
   <tr>
	<td class="body-text1"  height="20" align="right"> 
	 <table width="100%" cellpadding="0" cellspacing="0">
	  <tr>
	   <td width="10"><img src="../imagenes/spacer.gif" width="1" height="1"></td>	   
       <td align="left"></td>
       <td class="body-text1" width="220"></td>
       <td width="10"><img src="../imagenes/spacer.gif" width="1" height="1"></td>
      </tr>
     </table>
    </td>
    </tr>
    <!-- zona central -->
    <tr>
	 <td class="body-text1" valign="top">
	  <table cellpadding="5" cellspacing="1" width="94%" height="100%">
	   <tr>
		<td  height="1"><img src="../imagenes/spacer.gif" width="1" height="1"></td>
       </tr>
       <tr>
        <td class="body-text1" background=""  valign="top" align="left">
		 <table>
          <tr>
		   <td class="body-text1" >&nbsp;</td>
		   <td class="body-text1" >| <a href="javascript:history.go(-1)" style="color:red">Regresar</a>			</td>
          </tr>
         </table>
         <br>
         <b>:: Cuestionario </b>
         <br>
         <br>
         <?=$taller?> 
         <br><br>
         <form name="formProceso" action="admmodulos.php?Idvideo=<?=$_GET["Idvideo"]?>" method="post" onSubmit="return validarModulos()">
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
		  <td class="body-text1">Titulo</td>
          <td class="body-text1">
          <input type="text" name="valorTitulo" value="<?=$vTitulo?>" maxlength="255" size="60" class="controles1 required"></td>
         </tr>
         <tr>
		  <td class="body-text1">Calificación máxima</td>
          <td class="body-text1">
          <input type="text" name="valorNotaMax" value="<?=$vCalificacion?>" maxlength="4" size="5" class="controles1 required"></td>
          </tr>
		  <tr>
		   <td class="body-text1">Calificación mímina aprobación</td>
           <td class="body-text1">
			<input type="text" name="valorNotaMIn" value="<?=$vCalificacionMinima?>" maxlength="4" size="5" class="controles1 required"></td>
          </tr>
          <tr>
		   <td class="body-text1">Activo</td>
		   <td class="body-text1"><select name="ValorEstado" class="controles1 required" id="ValorEstado">
		   <option value="" selected>Seleccione</option>
		   <option value="1">SI</option>
		   <option value="0">NO</option>
		   </select></td>
          </tr>
          <tr>
		   <td colspan="2" align="left" class="body-text1">
		   <input type="image" src="../imagenes/ingresar.jpg"><a href="<?=$_SERVER['PHP_SELF']?>"><img src="../imagenes/cancelar.jpg" alt="borrar" border="0" /></a>
		   <br><br>
		   <?=$msg?></td>
		  </tr>
          </table>
         </form>
         <br>
         <table border="1" bordercolor="D4D4D4" cellpadding="5" cellspacing="0" width="100%">
		  <tr bgcolor="D4D4D4" >
		   <td class="body-text1" width="77%">Titulo</td>
           <td class="body-text1" width="12%">Activo</td>
           <td class="body-text1" width="12%">Borrar</td>
           <td width="11%"  align="center" class="body-text1">Preguntas</td><tr>
           <?
			$RSresultado=$objTaller->consultarModulosVideos($_GET["Idvideo"]);
			while ($row = mysql_fetch_array($RSresultado))
			{
			 $IdModulo=$row["IdModulo"]; 
		     $Titulo=$row["Titulo"]; 
			 $vEstado=$row["estado"]; 
			 if ($IdModulo>0){
			 ?> 
             <tr bgcolor="white" >
			  <td width="77%" valign="top" class="body-text1">
			  <a href="admmodulos.php?Idvideo=<?=$_GET["Idvideo"]?>&actualizar=<?=$IdModulo?>" style="color:red "><?=$Titulo?></a></td>
			  <td width="12%" valign="top" class="body-text1"><?=$vEstado?></td>
              <td width="77%" valign="top" class="body-text1">
			  <a href="admmodulos.php?borrar=<?=$IdModulo?>&Idvideo=<?=$_GET["Idvideo"]?>" style="color:red" onclick="return confirm('Seguro que desea borrar?')">Borrar</a></td>
			  <td class="body-text1"  align="center" valign="top">
              <a href="admpreguntasmodulo.php?IdModulo=<?=$IdModulo?>&Idvideo=<?=$_GET["Idvideo"]?>"><img src="../imagenes/iconos/ok.png" border="0"></a></td>
             <tr>
			 <?
			}
		   }
		   ?>
          </table>
          <br><br>
          </td>
          </tr>
          <tr>
		   <td  height="10"><img src="../imagenes/spacer.gif" width="1" height="1"></td>
          </tr>
         </table>
        </td>
	   </tr>
      <!-- footer -->
     </table>
	</td>
	<td width="1"><img src="../imagenes/spacer.gif" width="1" height="1"></td>
	</tr>
	<tr>
	 <td colspan="3" height="50"><img src="../imagenes/spacer.gif" width="1" height="1"></td>
	</tr>
   </table>
  </body>
</html>