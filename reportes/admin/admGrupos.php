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
$objGrupos=new clsusuario();
$msg="";

extract($_GET);
//informacion registro seleccionado
if($_GET["IdCategorias"]!="")
{
 $RSresultado=$objGrupos->consultarDetalleCategorias($_GET["IdCategorias"]);
 while ($row = mysql_fetch_array($RSresultado))
 {
  $vvTitulo=$row["categorias"];
 }
}

///ingresar examen   
if($_POST["ingresar"]!="")
 {
    $objGrupos->ingresarGrupos($_POST["valorTitulo"],$_POST['IdCategorias']);
    $msg="Registro ingresado";
 }

///actualizar
if($_POST["actualizar"]!="")
{
 $objGrupos->actualizarGrupos($_POST["actualizar"],$_POST["valorTitulo"]);
 $msg="Registro actualizado";
}

//informacion registro seleccionado
if($_GET["actualizar"]!="")
{
 $RSresultado=$objGrupos->consultarDetalleGrupos($_GET["actualizar"]);
 while ($row = mysql_fetch_array($RSresultado))
 {
  $vTitulo=$row["grupos"]; 
 }
}

if($_GET["borrar"]!="")
{
 $RSresultado=$objGrupos->borrarGrupos($_GET["borrar"],$_GET["IdCategorias"]);
 $msg="Registro borrado";
}

?>
<html>
 <head>
  <title>:: CUESTIONARIO ::</title>
  <link rel="stylesheet" href="../css/INDEX.CSS">
  <script language="javascript" src="../js/js.js">
  </script>
 </head>
 <body leftmargin="0" topmargin="0" background="" > 
  <table width="639" height="69%" align="center" cellpadding="0" cellspacing="0">
  <tr>
   <td width="10"><img src="../imagenes/spacer.gif" width="1" height="1"></td>
   <td width="626" bgcolor="white" valign="top">
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
	   <td  height="1"><img src="imagenes/spacer.gif" width="1" height="1"></td>
      </tr>
      <tr>
	   <td class="body-text1"  valign="top" align="left"><b><?=$vvTitulo?>:: Grupos</b><br>
	   <br>
	   <form name="formProceso" action="admGrupos.php?IdCategorias=<?=$IdCategorias?>" method="post" onSubmit="return validaNuevaAudiencia()">
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
         <td class="body-text1">
		   <input type="text" name="valorTitulo" value="<?=$vTitulo?>" maxlength="100" size="50" class="controles1">
		 </td>
        </tr>
        <tr>
		 <td colspan="2" align="right" class="body-text1">
		  <input type="hidden" value="<?=$IdCategorias?>" name="IdCategorias">
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
		<td class="body-text1" width="47%">Detalle</td>
		<td class="body-text1" width="43%">Borrar</td>
		<td class="body-text1" width="43%">SubGrupo</td>
		<td width="9%" align="center" class="body-text1">Inf.	Adicional</td>
       <tr>   
       <?
	   $RSresultado=$objGrupos->consultarGrupos($IdCategorias);
	   while ($row = mysql_fetch_array($RSresultado))
	   {
	    $IdGrupos=$row["IdGrupos"]; 
		$grupos=$row["grupos"]; 
		?> 
		<tr bgcolor="white" >
		 <td width="47%" valign="top" class="body-text1">
		  <a href="admGrupos.php?actualizar=<?=$IdGrupos?>&IdCategorias=<?=$IdCategorias?>" style="color:red "><?=$grupos?></a>
		 </td>
		 <td width="47%" valign="top" class="body-text1">
		  <a href="admGrupos.php?borrar=<?=$IdGrupos?>&IdCategorias=<?=$IdCategorias?>" style="color:red " onclick="return confirm('Seguro que desea borrar?')" >Borrar</a>
		 </td>
		 <td width="43%" valign="top" class="body-text1">
		  <a href="admSubGrupo.php?IdGrupos=<?=$IdGrupos?>&IdCategorias=<?=$IdCategorias?>" style="color:red ">>></a>
		 </td>
		 <td width="10%" valign="top" class="body-text1">
		  <a href="admvideos.php?IdGrupos=<?=$IdGrupos?>"><img src="../imagenes/iconos/ok.png" border="0"></a>
		 </td>
        <tr>
		<?
	   }
	   ?>
	  </table>
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
</table>
</body>
</html>