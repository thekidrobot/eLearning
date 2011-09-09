<?php include("header.php"); ?>
<?
//objetos
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

<body>
<div id="wrapper">
 <?php include("top_menu.php"); ?>
 <div id="page">
  <div id="content">
   <div class="post">
	<b>Inicio >> Categorias >> <?=ucfirst($vvTitulo)?> :: <?=ucfirst($vvgTitulo)?> :: SubGrupos</b> 
	 <br>
	 <br>
     <form name="formProceso" action="admSubGrupo.php?IdGrupos=<?=$IdGrupos?>&IdCategorias=<?=$IdCategorias?>" method="post" onSubmit="return validarSubGrupo()">
	  <fieldset>
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
		<td colspan="2">Ingresar Subgrupo</td>
	   </tr>

	   <tr>
		<td colspan="2">&nbsp;</td>
	   </tr>
	   
	   <tr>
		<td width="30%">Titulo</td>
		 <td>
		  <input type="text" name="valorTitulo" value="<?=$vNombreSubGrupo?>" maxlength="255" >
		 </td>
        </tr>
        
		<tr>
		 <td width="30%">Activo</td>
		 <td>
		 <select name="ValorEstado" class="controles1 required" id="ValorEstado">
		  <option value="" selected>Seleccione</option>
		  <option value="1">SI</option>
		  <option value="0">NO</option>
         </select>
		 </td>
        </tr>
        <tr>
		 <td colspan="2" align="right">
		 <input type="hidden" value="<?=$IdCategorias?>" name="IdCategorias">
		 <input type="hidden" value="<?=$IdGrupos?>" name="IdGrupos">
         <input type="image" src="../imagenes/ingresar.jpg"><a href="<?=$_SERVER['PHP_SELF']?>"><img src="../imagenes/cancelar.jpg" alt="borrar" border="0" /></a>
         <br><br>
         <?=$msg?>
		 </td>
        </tr>
        </table>
		</fieldset>
       </form>
       <br>
       <table border="1" bordercolor="D4D4D4" cellpadding="5" cellspacing="0">
		<tr bgcolor="D4D4D4" align="center" >
		<td>Titulo</td>
        <td width="7%">Activo</td>
        <td width="9%">Borrar</td>
        <td width="15%">Inf. Adicional</td>
        <?
		 $RSresultado=$objSubGrupo->consultarSubGrupos($IdGrupos);
		 while ($row = mysql_fetch_array($RSresultado))
		 {
		  extract($row);
		  ?> 
		  <tr bgcolor="white" >
		   <td>
			<a href="admSubGrupo.php?actualizar=<?=$IdSubGrupo?>&IdGrupos=<?=$IdGrupos?>&IdCategorias=<?=$IdCategorias?>" ><?=ucfirst($NombreSubGrupo)?></a>
		   </td>
           <td width="7%" align="center"><?=$estado?></td>
 		   <td>
			<a href="admSubGrupo.php?borrar=<?=$IdSubGrupo?>&IdGrupos=<?=$IdGrupos?>"  onclick="return confirm('Seguro que desea borrar?')" >Borrar</a>
		   </td>
           <td align="center">
           <a href="admvideos.php?IdSubGrupo=<?=$IdSubGrupo?>"><img src="../imagenes/iconos/ok.png" border="0"></a>				</td>
          </tr>
          <? } ?>
         </table>
 </div>
</div>
<!-- end #content -->
<?php include("sidebar.php"); ?>
  <div style="clear: both;">&nbsp;</div>
</div>
<!-- end #page -->
</div>
<?php include("footer.php"); ?>
</body>
</html>