<?php include("header.php"); ?>
<?

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
<body>
<div id="wrapper">
 <?php include("top_menu.php"); ?>
 <div id="page">
  <div id="content">
   <div class="post">
	
	  <b>:: Cuestionario </b>
      <br>
      <br>
      <?=$taller?> 
      <br><br>
      <form name="formProceso" action="admmodulos.php?Idvideo=<?=$_GET["Idvideo"]?>" method="post" onSubmit="return validarModulos()">
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
		  <td>Titulo</td>
          <td>
			<input type="text" name="valorTitulo" value="<?=$vTitulo?>" maxlength="255">
		  </td>
         </tr>
		 
         <tr>
		  <td >Calificación máxima</td>
          <td >
			<input type="text" name="valorNotaMax" value="<?=$vCalificacion?>" maxlength="4" size="5" >
		  </td>
         </tr>
		  
		  <tr>
		   <td >Calificación mímina aprobación</td>
           <td >
			<input type="text" name="valorNotaMIn" value="<?=$vCalificacionMinima?>" maxlength="4" size="5" ></td>
          </tr>
         
		  <tr>
		   <td >Activo</td>
		   <td ><select name="ValorEstado"  id="ValorEstado">
		   <option value="1">SI</option>
		   <option value="0">NO</option>
		   </select></td>
          </tr>
		  
          <tr>
		   <td colspan="2" align="right">
		   <input type="image" src="../imagenes/ingresar.jpg"><a href="<?=$_SERVER['PHP_SELF']?>"><img src="../imagenes/cancelar.jpg" alt="borrar" border="0" /></a>
		   <br><br>
		   <?=$msg?></td>
		  </tr>
          </table>
		  </fieldset>
         </form>
         <br>
         <table border="1" bordercolor="D4D4D4" cellpadding="5" cellspacing="0">
		  <tr bgcolor="D4D4D4" >
		   <td  width="77%">Titulo</td>
           <td  width="12%">Activo</td>
           <td  width="12%">Borrar</td>
           <td width="11%"  align="center" >Preguntas</td><tr>
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
			  <td width="77%" >
			  <a href="admmodulos.php?Idvideo=<?=$_GET["Idvideo"]?>&actualizar=<?=$IdModulo?>"  "><?=$Titulo?></a></td>
			  <td width="12%" ><?=$vEstado?></td>
              <td width="77%" >
			  <a href="admmodulos.php?borrar=<?=$IdModulo?>&Idvideo=<?=$_GET["Idvideo"]?>" " onclick="return confirm('Seguro que desea borrar?')">Borrar</a></td>
			  <td   align="center" valign="top">
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