<?
include("../conexion.php");
include("../clases/clsSubGrupo.php");
include("../clases/clsusuario.php");

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
$objUsuario=new clsusuario();
$objSubGrupo=new clsSubGrupo();
$msg="";

extract($_GET);
//informacion registro seleccionado
if($_GET["IdCategorias"]!="")
{
 $RSresultado=$objUsuario->consultarDetalleCategorias($_GET["IdCategorias"]);
 while ($row = mysql_fetch_array($RSresultado))
 {
  $vvTitulo=$row["categorias"]; 
 }
}
 
if($_GET["IdGrupos"]!="")
{
 $RSresultado=$objUsuario->consultarDetalleGrupos($_GET["IdGrupos"]);
 while ($row = mysql_fetch_array($RSresultado))
 {
  $vvgTitulo=$row["grupos"]; 
 }
}

///ingresar examen 
if($_POST["ingresar"]!="")
{
 $objSubGrupo->ingresarSubGrupo($_POST["valorTitulo"],$_POST["ValorEstado"],$_POST["IdGrupos"]);
 $msg="Registro ingresado";
}

///actualizar
if($_POST["actualizar"]!="")
{
 $objSubGrupo->actualizarSubGrupo($_POST["actualizar"],$_POST["valorTitulo"],$_POST["ValorEstado"]);
 $msg="Registro actualizado";
}

//informacion registro seleccionado
if($_GET["actualizar"]!="")
{
 $RSresultado=$objSubGrupo->consultarDetalleSubGrupo($_GET["actualizar"]);
 while ($row = mysql_fetch_array($RSresultado))
 {
  $vNombreSubGrupo=$row["NombreSubGrupo"]; 
  $vEstado=$row["estado"]; 
  $vIdGrupos=$row["IdGrupos"]; 
 }
}

///actualizar
if($_GET["borrar"]!="")
{
 $objSubGrupo->borrarSubGrupo($_GET["borrar"],$_GET["IdGrupos"]);
 $msg="Registro borrado";
}

?>
<html>
<head>
 <title>:: CUESTIONARIO ::</title>
 <link rel="stylesheet" href="../css/INDEX.CSS">
 <script language="javascript" src="../js/js.js"></script>
 <script language="javascript" src="../js/wforms.js">
 </script>
</head>
<body leftmargin="0" topmargin="0" background="" > 
 <table width="800" height="100%" align="center" cellpadding="0" cellspacing="0">
 <tr>
  <td width="12"><img src="../imagenes/spacer.gif" width="1" height="1"></td>
  <td width="785" bgcolor="white" valign="top">
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
	 <table cellpadding="5" cellspacing="1" width="90%" height="100%">
	 <tr>
	  <td  height="1"><img src="../imagenes/spacer.gif" width="1" height="1"></td>
	 </tr>
     <tr>
	  <td class="body-text1" background="" valign="top" align="left">
	   <table>
		<tr>
		 <td class="body-text1" >&nbsp;</td>
		 <td class="body-text1" >| <a href="javascript:history.go(-1)" style="color:red">Regresar</a> </td>
		</tr>
       </table>
       <br>
       <b><?=$vvTitulo?>::<?=$vvgTitulo?>::SubGrupos</b> 
       <br>
       <br>
       <form name="formProceso" action="admSubGrupo.php?IdGrupos=<?=$IdGrupos?>&IdCategorias=<?=$IdCategorias?>" method="post" onSubmit="return validarSubGrupo()">
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
		 <input type="text" name="valorTitulo" value="<?=$vNombreSubGrupo?>" maxlength="255" size="100" class="controles1">			</td>
        </tr>
        <tr>
		 <td class="body-text1">Activo</td>
		 <td class="body-text1">
		 <select name="ValorEstado" class="controles1 required" id="ValorEstado">
		  <option value="" selected>Seleccione</option>
		  <option value="1">SI</option>
		  <option value="0">NO</option>
         </select>
		 </td>
        </tr>
        <tr>
		 <td colspan="2" align="right" class="body-text1">
		 <input type="hidden" value="<?=$IdCategorias?>" name="IdCategorias">
		 <input type="hidden" value="<?=$IdGrupos?>" name="IdGrupos">
         <input type="image" src="../imagenes/ingresar.jpg"><a href="<?=$_SERVER['PHP_SELF']?>"><img src="../imagenes/cancelar.jpg" alt="borrar" border="0" /></a>
         <br><br>
         <?=$msg?>
		 </td>
        </tr>
        </table>
       </form>
       <br>
       <table border="1" bordercolor="D4D4D4" cellpadding="5" cellspacing="0" width="89%">
		<tr bgcolor="D4D4D4" >
		<td class="body-text1">Titulo</td>
        <td class="body-text1" width="7%">Activo</td>
        <td width="9%"  align="center" class="body-text1">Borrar</td>
        <td width="9%"  align="center" class="body-text1">Inf.	Adicional</td>
        <?
		 $RSresultado=$objSubGrupo->consultarSubGrupos($IdGrupos);
		 while ($row = mysql_fetch_array($RSresultado))
		 {
		  extract($row);
		  ?> 
		  <tr bgcolor="white" >
		   <td valign="top" class="body-text1">
			<a href="admSubGrupo.php?actualizar=<?=$IdSubGrupo?>&IdGrupos=<?=$IdGrupos?>&IdCategorias=<?=$IdCategorias?>" style="color:red "><?=$NombreSubGrupo?></a>
		   </td>
           <td width="7%" valign="top" class="body-text1"><?=$estado?></td>
 		   <td valign="top" class="body-text1">
			<a href="admSubGrupo.php?borrar=<?=$IdSubGrupo?>&IdGrupos=<?=$IdGrupos?>" style="color:red " onclick="return confirm('Seguro que desea borrar?')" >Borrar</a>
		   </td>
           <td class="body-text1"  align="center" valign="top">
           <a href="admvideos.php?IdSubGrupo=<?=$IdSubGrupo?>"><img src="../imagenes/iconos/ok.png" border="0"></a>				</td>
          </tr>
          <? } ?>
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
  <td colspan="3" height="2"><img src="../imagenes/spacer.gif" width="1" height="1"></td>
 </tr>
</table>
</body>
</html>