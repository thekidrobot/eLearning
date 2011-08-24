<?
include("../conexion.php");
include("clases/ps_pagination.php");

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

$NomDepartamento = "";

include("../clases/clsusuario.php");
$objCategorias=new clsusuario();
?>

<html>
 <head>
  <title>:: CUESTIONARIO ::</title>
  <link rel="stylesheet" href="../css/INDEX.CSS">
  <script language="javascript" src="../js/js.js"></script>
  <script language="javascript">
   function seleccionar_todo(){
	 for (i=0;i<document.f1.elements.length;i++)
	 if(document.f1.elements[i].type == "checkbox")
	  document.f1.elements[i].checked=1
	} 
 
  function deseleccionar_todo(){
	for (i=0;i<document.f1.elements.length;i++)
	 if(document.f1.elements[i].type == "checkbox")
	 document.f1.elements[i].checked=0
   } 
 </script>
 </head>
 <body leftmargin="0" topmargin="0" background="" > 
  <b>Inicio >> Multiples Usuarios</b><br><br>
   <form name="form1" method="post" action="">
	<fieldset>
	<p><label  class="tahoma_11_light">Seleccione el departamento:</label>
	 <select name="IdDepartamento" class="tahoma_11_light">
	 <option value="0">Seleccione</option>
	 <?
	  $link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
	  mysql_select_db($_SESSION["basededatos"], $link);	
	  $RSUsuarios=mysql_query("select * from departamentos order by NomDepartamento",$link);
	  while ($rowUsuarios = mysql_fetch_array($RSUsuarios))
	  {
	   extract($rowUsuarios);
	  ?>
	  <option value="<?=$IdDepartamento?>"><?=$NomDepartamento?></option>
	  <?
	 }
	?>
	</select>
	</p>
	<input name="Submit" type="submit" class="tahoma_11_light" value="Consultar">
	<input name="Reset" type="Reset" class="tahoma_11_light" value="Cancelar">
	</fieldset>
    </form>	
 
 <?php
 
 //if($_POST['Submit']){
  
 $IdDepartamento = $_REQUEST['IdDepartamento'];
 ?>
  
  <table width="800" height="100%" align="center" cellpadding="0" cellspacing="0">
   <tr>
   <td width="13"><img src="../imagenes/spacer.gif" width="1" height="1"></td>
   <td width="771" bgcolor="white" valign="top">
    <table width="100%" height="100%" cellpadding="0" cellspacing="0">
		 <!-- banner superior -->
		 <!-- menu superior -->
		 <!-- zona central -->
     <tr>
	   <td class="body-text1" valign="top">
      <table cellpadding="5" cellspacing="1" width="100%" height="100%">
       <tr>
       <div class="body-text1" >| <a href="javascript:history.go(-1)" style="color:red">Regresar</a> 
       <br>
       <br>
	 </div>
	 <?
	  if($IdDepartamento != 0)
	  {
	   $link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
	   mysql_select_db($_SESSION["basededatos"], $link);	
	   $RSUsuarios=mysql_query("select * from departamentos where IdDepartamento = $IdDepartamento",$link);
	   while ($rowUsuarios = mysql_fetch_array($RSUsuarios))
	   {
	    extract($rowUsuarios);
	   }
	?>
        <td class="body-text1" background="" valign="top" align="left"><b><?=$NomDepartamento ?> :: Administrar Permisos </b> 
        <? } ?>
	<br>
         <form name="f1" method="post" action="admpermisos.php" >
	  <div align="left">
	  <?
	   $sql = "SELECT * FROM usuarios
		   WHERE IdUsuario IN(SELECT IdUsuario FROM departamentos_usuarios
		   WHERE IdDepartamento = $IdDepartamento) order by FechaCreacion desc";
								   
	   $link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
	   mysql_select_db($_SESSION["basededatos"], $link);
	   
	   $pager = new PS_Pagination($link, $sql, 100, 5,"IdDepartamento=$IdDepartamento");
	   $RSresultado = $pager->paginate();
	   
	   ?><div align="center"> <?php echo $pager->renderFullNav(); ?> </div><br/> <?php
	  
	   //$RSresultado=mysql_query($sql,$link);
	   while ($row = mysql_fetch_array($RSresultado))
	   {
	    $IdUsuario=$row["IdUsuario"]; 
	    $Usuario=$row["Usuario"];
	    $NombreCompleto = $row["NombreCompleto"];
	    echo '<UL><input name="Usuarios[]" type="checkbox" value="'.$IdUsuario.'">'. $NombreCompleto.' | '.$Usuario.'</UL>';
	   }
	   ?> 
	   <br>
	   <div align="right">
	   <input type="image" src="../imagenes/ingresar.jpg"><a href="<?=$_SERVER['PHP_SELF']?>">
	   <img src="../imagenes/cancelar.jpg" alt="borrar" border="0" /></a>
	  </div>
	</div>
        </form>
	<?=$msg?><br /><br />
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
 <?php
 
 //}
 
 ?>
</body></html>