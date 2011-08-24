<?
include("../conexion.php");
include("../clases/clsusuario.php");

session_start();

//validar sesion
if($_SESSION["usuario"]=="")
 {
  ?>
  <script language="javascript">
  document.location="../inicio.html";
  </script>
  <?
 }

///objetos
$objCategorias=new clsusuario();
$msg="";

///ingresar examen   
if($_POST["ingresar"]!="")
{
 $objCategorias->ingresarCategorias($_POST["valorTitulo"]);
 $msg="Registro ingresado";
}

///actualizar
if($_POST["actualizar"]!="")
{
 $objCategorias->actualizarCategorias($_POST["actualizar"],$_POST["valorTitulo"]);
 $msg="Registro actualizado";
}

//informacion registro seleccionado
if($_GET["actualizar"]!="")
{
 $RSresultado=$objCategorias->consultarDetalleCategorias($_GET["actualizar"]);	
 while ($row = mysql_fetch_array($RSresultado))
 {
  $vTitulo=$row["categorias"]; 
 }
}

//informacion registro seleccionado
if($_GET["borrar"]!="")
{
 $RSresultado=$objCategorias->borrarCategorias($_GET["borrar"]);	
 $msg="Registro borrado";
}

?>
<html>
<head>
 <title>:: CUESTIONARIO ::</title>
 <link rel="stylesheet" href="../css/INDEX.CSS">
 <script language="javascript" src="../js/js.js"></script>
 </head>
<body leftmargin="0" topmargin="0" background=""> 
 <table width="613" height="100%" align="center" cellpadding="0" cellspacing="0">
  <tr>
   <td width="1"><img src="../imagenes/spacer.gif" width="1" height="1"></td>
   <td width="783" bgcolor="white" valign="top">
	<table width="100%" height="100%" cellpadding="0" cellspacing="0">
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
	  <table cellpadding="5" cellspacing="1" width="100%" height="100%">
	   <tr>
		<td  height="1"><img src="../imagenes/spacer.gif" width="1" height="1"></td>
	   </tr>
       <tr>
        <td class="body-text1"  valign="top" align="left"><b>:: Categorias</b> 
        <br>
        <br>
        <form name="formProceso" action="admCategorias.php" method="post" onSubmit="return validaNuevaAudiencia()">
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
		  <td class="body-text1">Detalle</td>
          <td class="body-text1"><input type="text" name="valorTitulo" value="<?=$vTitulo?>" maxlength="100" size="50" class="controles1"></td>
		 </tr>
		 <tr>
		  <td colspan="2" align="right" class="body-text1">
		  <input type="image" src="../imagenes/ingresar.jpg"><a href="<?=$_SERVER['PHP_SELF']?>"><img src="../imagenes/cancelar.jpg" alt="borrar" border="0" /></a>
		  <br><br>
		  <?=$msg?>
		  </td>
         </tr>
        </table>
        </form>
        <br>
        <table border="1" bordercolor="D4D4D4" cellpadding="5" cellspacing="0" width="100%">
		 <tr bgcolor="D4D4D4" >
		  <td class="body-text1" width="65%">Detalle</td>
          <td class="body-text1" width="35%">Borrar</td>
          <td class="body-text1" width="35%">Grupos</td>
         <tr>   
         <?
		  $RSresultado=$objCategorias->consultarCategorias();
		  while ($row = mysql_fetch_array($RSresultado))
		  {
		   extract($row);
		   ?> 
         <tr bgcolor="white" >
		  <td width="60%" valign="top" class="body-text1">
		   <a href="admCategorias.php?actualizar=<?=$IdCategorias?>" style="color:red "><?=$categorias?></a>
		  </td>
		  <td width="20%" valign="top" class="body-text1">
		   <a href="admCategorias.php?borrar=<?=$IdCategorias?>" style="color:red " onclick="return confirm('Seguro que desea borrar?')" >Borrar</a>
		  </td>
		   <td width="20%" valign="top" class="body-text1">
		   <a href="admGrupos.php?IdCategorias=<?=$IdCategorias?>" style="color:red ">>></a>
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
  <td width="1"><img src="imagenes/spacer.gif" width="1" height="1"></td>
 </tr>
 <tr>
  <td colspan="4" height="50"><img src="imagenes/spacer.gif" width="1" height="1"></td>
 </tr>
</table>
</body>
</html>