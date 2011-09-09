<?php include("header.php"); ?>
<?

//objetos
$objCategorias=new clsusuario();
$msg="";

//ingresar examen   
if($_POST["ingresar"]!="")
{
 $resp=$objCategorias->validacionCategorias($_POST["valorTitulo"]);
 if($resp=="1")
 {
  $objCategorias->ingresarCategorias($_POST["valorTitulo"]);
  $msg="Registro ingresado";  
 }
 else 
  $msg="Categoria ya existe, por favor cambiela";
}

//actualizar
if($_POST["actualizar"]!="")
{
 $resp=$objCategorias->validacionCategorias($_POST["valorTitulo"]);
 if($resp=="1")
 {
  $objCategorias->actualizarCategorias($_POST["actualizar"],$_POST["valorTitulo"]);
  $msg="Registro actualizado";
 }
 else
  $msg="Categoria ya existe, por favor cambiela"; 
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

<body>
<div id="wrapper">
 <?php include("top_menu.php"); ?>
 <div id="page">
  <div id="content">
   <div class="post">
	
	  <b>Inicio >> Categorias</b> 
      <br>
      <br>
      <form name="formProceso" action="admCategorias.php" method="post" onSubmit="return validaNuevaAudiencia()">
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
		   Ingresar Categorias
		  </td>
		 </tr>

		 <tr>
		  <td colspan="2">&nbsp;</td>
		 </tr>
		 
		 <tr>
		  <td width="30%">Detalle : </td>
          <td><input type="text" name="valorTitulo" value="<?=$vTitulo?>" maxlength="100"></td>
		 </tr>
		 <tr>
		  <td colspan="2" align="right">
		  <input type="image" src="../imagenes/ingresar.jpg"><a href="<?=$_SERVER['PHP_SELF']?>"><img src="../imagenes/cancelar.jpg" alt="borrar" border="0" /></a>
		  <br><br>
		  <?=$msg?>
		  </td>
         </tr>
        </table>
		</fieldset>
        </form>
        <br>
        <table border="1" bordercolor="D4D4D4" cellpadding="5" cellspacing="0" width="100%">
		 <tr bgcolor="D4D4D4" >
		  <td width="65%">Detalle</td>
          <td width="35%">Borrar</td>
          <td width="35%">Grupos</td>
         <tr>   
         <?
		  $RSresultado=$objCategorias->consultarCategorias();
		  while ($row = mysql_fetch_array($RSresultado))
		  {
		   extract($row);
		   ?> 
         <tr bgcolor="white" >
		  <td width="60%" valign="top">
		   <a href="admCategorias.php?actualizar=<?=$IdCategorias?>" ><?=$categorias?></a>
		  </td>
		  <td width="20%" valign="top">
		   <a href="admCategorias.php?borrar=<?=$IdCategorias?>"  onclick="return confirm('Seguro que desea borrar?')" >Borrar</a>
		  </td>
		   <td width="20%" valign="top">
		   <a href="admGrupos.php?IdCategorias=<?=$IdCategorias?>" >>></a>
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