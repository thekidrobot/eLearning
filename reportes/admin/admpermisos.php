<?
include("../conexion.php");
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

include("../clases/clsusuario.php");
include("../clases/clsSubGrupo.php");
include("../clases/clsPermisos.php");

$objCategorias=new clsusuario();
$objSubGrupo=new clsSubGrupo();
$objPermisos=new clsPermisos();

 //if ($_GET['IdUsuario'])
 //{
 // //$IdUsuario = $_GET['IdUsuario'].'|';
 // $IdUsuario = $_GET['IdUsuario'];
 //}
 //else
 //{
  $aUsuarios = $_POST['Usuarios'];
  $N = count($aUsuarios);
  if($N > 0)
  {
   for($i=0; $i < $N; $i++)
   {
	$IdUsuario.=$aUsuarios[$i].'|';
   } 
  } 
 //}
  
 if (($_POST['IdUsuario']))
 {
  
  $ArrayIdUsuario = explode('|',$_POST['IdUsuario'],-1);
 
  foreach($ArrayIdUsuario as $IdUsuario)
  {
	$objPermisos->Elimina_Permisos($IdUsuario);
	
	foreach ($_POST as $nombre => $valor)
	{
	 $largo=strlen($nombre);
	 if ($largo>1)
	 {
		$tipo=substr($nombre,0,1);
		$Id=substr($nombre,1,$largo-1);
		 
		switch ($tipo)
		{
		 case 'C':
		 //categorias
		 $objPermisos->Inserta_Categoria($IdUsuario,$Id);
		 break;	
			
		 case 'G':
		 //grupos
			$objPermisos->Inserta_Grupo($IdUsuario,$Id);
		 break;
		 
		 case 'S':
		 //subgrupos
		 $objPermisos->Inserta_Subgrupo($IdUsuario,$Id);
		 break;
		}
	 }
	 $msg = "Permisos otorgados con exito.<br /><br /><a href='admpermisosusuarios.php' target='carga'>Volver</a>";
	}
  }
 }

?>
<html>
 <head>
  <title>:: CUESTIONARIO ::</title>
  <link rel="stylesheet" href="../css/INDEX.CSS">
  <script language="javascript" src="../js/js.js"></script>
  <script language="javascript">
   function seleccionar_todo()
   {
	for (i=0;i<document.f1.elements.length;i++)
	if(document.f1.elements[i].type == "checkbox") document.f1.elements[i].checked=1
   } 
 
   function deseleccionar_todo()
   {
	for (i=0;i<document.f1.elements.length;i++)
	if(document.f1.elements[i].type == "checkbox") document.f1.elements[i].checked=0
   } 
  </script>
 </head>
 <body leftmargin="0" topmargin="0" background="" > 
 <table width="800" height="100%" align="center" cellpadding="0" cellspacing="0">
 <tr>
  <td width="13"><img src="../imagenes/spacer.gif" width="1" height="1"></td>
  <td width="771" bgcolor="white" valign="top">
   <table width="100%" height="100%" cellpadding="0" cellspacing="0">
   <tr>
	<td class="body-text1" valign="top">
    <table cellpadding="5" cellspacing="1" width="100%" height="100%">
    <tr>
    <div class="body-text1" >| <a href="javascript:history.go(-1)" style="color:red">Regresar</a><br><br></div>
    <td class="body-text1" background="" valign="top" align="left"><b>:: Administrar Permisos </b><br><br><br>
    <form name="f1" method="post" >
	<div align="left">
	<?
	
    $RSresultado=$objCategorias->consultarCategorias();
	while ($row = mysql_fetch_array($RSresultado))
    {
	 $IdCategorias=$row["IdCategorias"]; 
	 @$activo=$objPermisos->Consulta_Categoria($aUsuarios[0],$IdCategorias);
	 if ($activo>0){$check='checked';}else{$check='';} 
	 echo '<UL><input name="C'.$IdCategorias.'" type="checkbox" value="'.$IdCategorias.'" '.$check.' >'. $row["categorias"].'<UL>';
	
	 //Grupos
	 $RSresultadoGrupos=$objCategorias->consultarGrupos($IdCategorias);
	 while ($rowGrupos = mysql_fetch_array($RSresultadoGrupos))
	 {
	  $IdGrupos=$rowGrupos["IdGrupos"]; 
	  $grupos=$rowGrupos["grupos"]; 
	  @$activo=$objPermisos->Consulta_Grupo($aUsuarios[0],$IdGrupos);
	  if ($activo>0){$check='checked';}else{$check='';} 
	  echo '<LI><input name="G'.$IdGrupos.'" type="checkbox" value="'.$IdGrupos.'" '.$check.' >'.$grupos.'<UL>';
		
	  //subGrupos
	  $RSSubGrupo=$objSubGrupo->consultarSubGrupos($IdGrupos);
	  while ($rowSubGrupo = mysql_fetch_array($RSSubGrupo))
	  {
	   $IdSubGrupo=$rowSubGrupo["IdSubGrupo"]; 
	   $NombreSubGrupo=$rowSubGrupo["NombreSubGrupo"]; 
	   @$activo=$objPermisos->Consulta_Subgrupo($aUsuarios[0],$IdSubGrupo);
	   if ($activo>0){$check='checked';}else{$check='';} 
	   echo '<LI><input name="S'.$IdSubGrupo.'" type="checkbox" value="'.$IdSubGrupo.'" '.$check.' >'. $NombreSubGrupo.'</LI>';
	  }
	  echo '</UL></LI>';
	 }
	 echo '</UL></UL>';
	}
	?> 
	<br>
	<div align="right">
	<input type="image" src="../imagenes/ingresar.jpg"><a href="<?=$_SERVER['PHP_SELF']?>">
	<img src="../imagenes/cancelar.jpg" alt="borrar" border="0" /></a>
   </div>
   </div>
   <input name="IdUsuario" type="hidden" value="<?=$IdUsuario?>">
   </form>
   <?=$msg ?><br /><br /><br />
   <a href="javascript:seleccionar_todo()">Marcar todos</a> |
   <a href="javascript:deseleccionar_todo()">Marcar ninguno</a></td>
  </tr>
  <tr>
  <td  height="10"><img src="imagenes/spacer.gif" width="1" height="1"></td>
  </tr>
  </table>
  </td>
  </tr>
  <!-- footer -->
  <tr>
  <td  background="imagenes/seccion.jpg" class="body-text1" height="20" align="center"></td>
  </tr>
  </table>
  </td>
  <td width="13" background="imagenes/fondo4.jpg"></td>
  <td width="1"><img src="imagenes/spacer.gif" width="1" height="1"></td>
	</tr>
	<tr>
	 <td colspan="4" height="50"><img src="imagenes/spacer.gif" width="1" height="1"></td>
	</tr>
 </table>
</body>
</html>