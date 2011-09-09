<?php include("header.php"); ?>
<?
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

<body>
<div id="wrapper">
 <?php include("top_menu.php"); ?>
 <div id="page">
  <div id="content">
   <div class="post">
	
	   <b>Inicio >> Categorias >> <?=ucfirst($vvTitulo)?> :: Grupos</b>
	   <br>
	   <br>
	   
	   <form name="formProceso" action="admGrupos.php?IdCategorias=<?=$IdCategorias?>" method="post" onSubmit="return validaNuevaAudiencia()">
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
		  <td colspan="2">
		   Ingresar Grupo
		  </td>
		 </tr>

		 <tr>
		  <td colspan="2">&nbsp;</td>
		 </tr>

		 <tr>
		  <td width="30%">Detalle :</td>
		  <td>
		   <input type="text" name="valorTitulo" value="<?=$vTitulo?>" maxlength="100">
		  </td>
		 </tr>
		 
        <tr>
		 <td colspan="2" align="right">
		  <input type="hidden" value="<?=$IdCategorias?>" name="IdCategorias">
		  <input type="image" src="../imagenes/ingresar.jpg"><a href="<?=$_SERVER['PHP_SELF']?>"><img src="../imagenes/cancelar.jpg" alt="borrar" border="0" /></a>
		  <br>
		  <br>
		  <?=$msg?>
         </td>
		</tr>
       </table>
	   </fieldset>
	  </form>
      
	  <br>
      <table border="1" bordercolor="D4D4D4" cellpadding="5" cellspacing="0" width="100%">
	   <tr bgcolor="D4D4D4" align="center">
		<td>Detalle</td>
		<td>Borrar</td>
		<td width="15%">SubGrupo</td>
		<td width="20%">Inf.	Adicional</td>
       <tr>   
       <?
	   $RSresultado=$objGrupos->consultarGrupos($IdCategorias);
	   while ($row = mysql_fetch_array($RSresultado))
	   {
	    $IdGrupos=$row["IdGrupos"]; 
		$grupos=$row["grupos"]; 
		?> 
		<tr bgcolor="white" >
		 <td>
		  <a href="admGrupos.php?actualizar=<?=$IdGrupos?>&IdCategorias=<?=$IdCategorias?>" style="color:red "><?=ucfirst($grupos)?></a>
		 </td>
		 <td>
		  <a href="admGrupos.php?borrar=<?=$IdGrupos?>&IdCategorias=<?=$IdCategorias?>" style="color:red " onclick="return confirm('Seguro que desea borrar?')" >Borrar</a>
		 </td>
		 <td width="15%" align="center">
		  <a href="admSubGrupo.php?IdGrupos=<?=$IdGrupos?>&IdCategorias=<?=$IdCategorias?>" style="color:red ">>></a>
		 </td>
		 <td width="20%" align="center">
		  <a href="admvideos.php?IdGrupos=<?=$IdGrupos?>"><img src="../imagenes/iconos/ok.png" border="0"></a>
		 </td>
        <tr>
		<?
	   }
	   ?>
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