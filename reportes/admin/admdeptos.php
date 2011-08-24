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

$objUsuario=new clsusuario();
$msg="";

///ingresar   
if($_POST["ingresar"]!="")
 {
   $NomDepartamento = $_POST["NomDepartamento"];
  
    $resp=$objUsuario->validacionDepartamento($NomDepartamento);
	
	if($resp=="1")
	 {
	  $objUsuario->ingresarDepartamento($NomDepartamento);
	  $msg="Registro ingresado";
	 }
	else
	 {
	  $msg="El departamento ya existe, por favor cambielo";
	 }
 }

///actualizar
if($_POST["actualizar"]!="")
 {
  $NomDepartamento = $_POST["NomDepartamento"];
  $IdDepartamento = $_POST["IdDepartamento"];
  
  $objUsuario->actualizarDepartamento($NomDepartamento,$IdDepartamento);
  $msg="Registro actualizado";
 }


//informacion registro seleccionado
if($_GET["actualizar"]!="")
 {
  $IdDepartamento = $_GET["actualizar"];

  $RSresultado=$objUsuario->consultarDetalleDepartamentos($IdDepartamento);
  while ($row = mysql_fetch_array($RSresultado))
  {
   $vIdDepto=$row["IdDepartamento"]; 
   $vNomDepto=$row["NomDepartamento"]; 
  }
 }

//Borrar Usuario
if($_GET["borrar"]!="")
{
  	$objUsuario->borrarDepartamento($_GET["borrar"]);
    $msg="Usuario borrado";
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
<table width="41%" height="100%" align="center" cellpadding="5" cellspacing="1">
  <tr>
    <td  height="1"><img src="../imagenes/spacer.gif" width="1" height="1"></td>
  </tr>
  <tr>
    <td class="body-text1" background="" valign="top" align="left"><b>:: Departamentos</b> <br>
      <br>
      <form name="formProceso" action="<?=$_SERVER['PHP_SELF']?>" method="post" onSubmit="return validarNuevoUsuario()">
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
            <td class="body-text1"> Nombre </td>
            <td class="body-text1">
			 <input type="hidden" name="IdDepartamento" value="<?=$vIdDepto?>">
			 <input type="text" name="NomDepartamento" value="<?=$vNomDepto?>" maxlength="255" size="100" class="controles1">
			</td>
          </tr>
          <tr>
            <td colspan="2" align="right" class="body-text1">
			 <input type="image" src="../imagenes/ingresar.jpg"><a href="<?=$_SERVER['PHP_SELF']?>"><img src="../imagenes/cancelar.jpg" alt="borrar" border="0" /></a>
			  <br>
              <br>
              <?=$msg?></td>
          </tr>
        </table>
      </form>
      <br>
      <table border="1" bordercolor="D4D4D4" cellpadding="5" cellspacing="0" width="100%">
        <tr bgcolor="D4D4D4" >
         <td class="body-text1" width="80%"> Nombre </td>
         <td class="body-text1"  align="center">Borrar</td>
		<tr>
          <?
		   $RSresultado=$objUsuario->consultarDepartamentos();
		   while ($row = mysql_fetch_array($RSresultado))
			 {
			  $IdDepartamento=$row["IdDepartamento"]; 
			  $NomDepartamento=$row["NomDepartamento"];
			  ?>
        <tr bgcolor="white" >
		 <td class="body-text1" width="80%" valign="top">
		  <a href="admdeptos.php?actualizar=<?=$IdDepartamento?>" style="color:red "><?=$NomDepartamento?></a>
		 </td>
		 <td class="body-text1">
		  <a href="admdeptos.php?borrar=<?=$IdDepartamento?>" onclick="return confirm('Seguro que desea borrar?')" >Borrar</a>
		 </td>
        <tr>
        <?
		 }
		?>
      </table>
      <br>
    <br></td>
  </tr>
  <tr>
    <td  height="10"><img src="imagenes/spacer.gif" width="1" height="1"></td>
  </tr>
</table>
</body>
</html>