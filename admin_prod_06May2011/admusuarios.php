<?
include("../conexion.php");
include("../clases/clsusuario.php");

session_start();

///objetos

$objUsuario=new clsusuario();
$msg="";

//validar sesion
if($_SESSION["usuario"]=="")
{
 ?>
 <script language="javascript">
 document.location="../inicio.html";
 </script>
 <?
}

  $aUsuarios = $_POST['Usuarios'];
  $U = count($aUsuarios);

  $aDepartamentosUsuarios = $_POST['DepartamentosUsuarios'];
  $D = count($aDepartamentosUsuarios);
  
  
  if($U > 0 and $D > 0)
  {
   foreach($aUsuarios as $Usuarios)
   {
    foreach($aDepartamentosUsuarios as $Departamentos)
     {
      $objUsuario->ingresarDepartamentosUsuario($Usuarios,$Departamentos);
     }
   }
    $msg="Registro actualizado";
  } 

///ingresar   
if($_POST["ingresar"]!="")
{
 $resp=$objUsuario->validacionLoginUsuario($_POST["valorLogin"]);
 if($resp=="1")
 {
  $objUsuario->ingresarUsuario($_POST["valorLogin"],$_POST["valorClave"],$_POST["valorNombre"],$_POST["valorGrupo"]);
  $qShowStatus = "SHOW TABLE STATUS LIKE 'usuarios'";
  $qShowStatusResult = mysql_query($qShowStatus) or die( "Query failed: " . mysql_error() . "<br/>" . $qShowStatus );
 
  $row = mysql_fetch_assoc($qShowStatusResult);
  $next_increment = $row['Auto_increment'];
      
  $aDepartamentos = $_POST['Departamentos'];
  $N = count($aDepartamentos);
  if($N > 0)
  {
   for($i=0; $i < $N; $i++)
   {
    $objUsuario->ingresarDepartamentosUsuario($next_increment-1,$aDepartamentos[$i]);
   } 
  }
      
  $msg="Registro ingresado";
 }
 else
 {
  $msg="El login ya existe, por favor cambielo";
 }
}


///actualizar
if($_POST["actualizar"]!="")
{
 $objUsuario->actualizarUsuario($_POST["actualizar"],$_POST["valorClave"],$_POST["valorNombre"],$_POST["valorLogin"]);
 $objUsuario->borrarDepartamentosUsuario($_POST["actualizar"]);
 $objUsuario->borrarPermisosUsuario($_POST["actualizar"]);

 $aDepartamentos = $_POST['Departamentos'];
 $N = count($aDepartamentos);
 if($N > 0)
 {
  for($i=0; $i < $N; $i++)
  {
   $objUsuario->ingresarDepartamentosUsuario($_POST["actualizar"],$aDepartamentos[$i]);
  } 
 }
  
 $msg="Registro actualizado";
}

//informacion registro seleccionado
if($_GET["actualizar"]!="")
{
 $RSresultado=$objUsuario->consultarDetalleUsuarios($_GET["actualizar"]);
 while ($row = mysql_fetch_array($RSresultado))
 {
  $vUsuario=$row["Usuario"]; 
  $vPassword=$row["Password"]; 
  $vNombreCompleto=$row["NombreCompleto"]; 
  $vIdGrupos=$row["idGrupo"];
 }
}

//Borrar Usuario
if($_GET["borrar"]!="")
{
 $objUsuario->borrarUsuario($_GET["borrar"]);
 $msg="Usuario borrado";
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
    if(document.f1.elements[i].type == "checkbox" && document.f1.elements[i].id == "usuario")
    document.f1.elements[i].checked=1
   } 
 
   function deseleccionar_todo()
   {
    for (i=0;i<document.f1.elements.length;i++)
    if(document.f1.elements[i].type == "checkbox" && document.f1.elements[i].id == "usuario")
    document.f1.elements[i].checked=0
   } 
 </script>
 </head>
 <body leftmargin="0" topmargin="0" background="" >
  <table width="41%" height="100%" align="center" cellpadding="5" cellspacing="1">
   <tr>
    <td  height="1"><img src="../imagenes/spacer.gif" width="1" height="1"></td>
   </tr>
   <tr>
    <td class="body-text1" background="" valign="top" align="left">
     <b>Inicio >> Usuarios</b><br><br>
     <form name="formBuscar" action="<?=$_SERVER['PHP_SELF']?>" method="post">
     <fieldset>
     <table>
      <tr>
      <tr>
       <td class="body-text1"> Buscar Usuarios</td>
       <td class="body-text1">&nbsp;</td>
      </tr>
      </tr>
      <tr>
       <td class="body-text1"> Nombre </td>
       <td class="body-text1"><input type="text" name="valorNombre" value="" maxlength="255" size="100" class="controles1"></td>
      </tr>
      <tr>
       <td colspan="2" align="right" class="body-text1">
        <input type="image" src="../imagenes/ingresar.jpg"><a href="<?=$_SERVER['PHP_SELF']?>"><img src="../imagenes/cancelar.jpg" alt="borrar" border="0" /></a>
        <input type="hidden" name="buscar" value="1">
       <br>
       </td>
      </tr>
     </table>
     </fieldset>
    </form>
    
     <form name="formProceso" action="admusuarios.php" method="post" onSubmit="return validarNuevoUsuario()">
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
       <td class="body-text1"> Nombre </td>
       <td class="body-text1"><input type="text" name="valorNombre" value="<?=$vNombreCompleto?>" maxlength="255" size="100" class="controles1"></td>
      </tr>
      <tr>
       <td class="body-text1"> Login </td>
       <td class="body-text1"><input type="text" name="valorLogin" value="<?=$vUsuario?>" maxlength="100" size="50" class="controles1" ></td>
      </tr>
      <tr>
       <td class="body-text1"> Clave</td>
       <td class="body-text1"><input type="password" name="valorClave" value="<?=$vPassword?>" maxlength="15" size="50" class="controles1"></td>
      </tr>
      <tr>
       <td class="body-text1"> Departamentos</td>
      <td>
      <fieldset class="scroll_checkboxes">
      <?php
       $RSresultado=$objUsuario->consultarDepartamentos_nopag();
       while ($rowDepto = mysql_fetch_array($RSresultado))
       {
	$IdDepartamento=$rowDepto["IdDepartamento"]; 
	$NomDepartamento=$rowDepto["NomDepartamento"];
       
	$RSactivo=$objUsuario->consultarDepartamentosUsuario($IdDepartamento,$_GET["actualizar"]);
	$rowCuenta = @mysql_fetch_array($RSactivo);			  
	if ($rowCuenta['cuenta']>0){$check='checked="yes"';} else{$check='';} 
	echo "<input name='Departamentos[]' type='checkbox' value='$IdDepartamento' $check>$NomDepartamento<br />";
       }
      ?>
      </fieldset>
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
    </fieldset>
    </form>
    <br>
     
     <form name="f1" method="post" action="admusuarios.php" >
      <table border="1" bordercolor="D4D4D4" cellpadding="5" cellspacing="0" width="100%">
        <tr bgcolor="D4D4D4" >
          <td class="body-text1" width="5%">&nbsp;</td>
          <td class="body-text1" width="80%"> Nombre </td>
          <td class="body-text1" align="center"> Login </td>
          <td class="body-text1" align="center">Borrar</td>
          <!--<td class="body-text1"  align="center">Permisos</td>-->
        <tr>
          <?
	   ///Buscar
	   if($_POST["buscar"]!="")
	   {
	    $RSresultado=$objUsuario->consultarDetalleUsuariosPorNombreLike($_POST["valorNombre"]);
	    while ($row = mysql_fetch_array($RSresultado))
	    {
	     $IdUsuario=$row["IdUsuario"]; 
	     $NombreCompleto=$row["NombreCompleto"]; 
	     $Usuario=$row["Usuario"]; 
	     ?>
	     <tr bgcolor="white" >
	     <td class="body-text1" width="5%" valign="top">
	      <input name="Usuarios[]" type="checkbox" value="<?=$IdUsuario?>">
	     </td>
	     <td class="body-text1" width="80%" valign="top">
	      <a href="admusuarios.php?actualizar=<?=$IdUsuario?>" style="color:red ">
	      <?=$NombreCompleto?>
	      </a>
	     </td>
	     <td  align="center" class="body-text1"><?=$Usuario?></td>
	     <td class="body-text1">
	      <a href="admusuarios.php?borrar=<?=$IdUsuario?>" onclick="return confirm('Seguro que desea borrar?')" >Borrar</a>
	     </td>
	     <!--<td  align="center" valign="top" class="body-text1"><a href="admpermisos.php?IdUsuario=<?=$IdUsuario?>"><img src="../imagenes/iconos/ok.png" border="0"></a></td>-->
	     <tr>
	     <?
	    }
	   }
	   else
	   {
	    $RSresultado=$objUsuario->consultarUsuarios();
	    while ($row = mysql_fetch_array($RSresultado))
	    {
	     $IdUsuario=$row["IdUsuario"]; 
	     $NombreCompleto=$row["NombreCompleto"]; 
	     $Usuario=$row["Usuario"]; 
	     ?>
	     <tr bgcolor="white" >
	     <td class="body-text1" width="5%" width="80%" valign="top">
	      <input name="Usuarios[]" id="usuario" type="checkbox" value="<?=$IdUsuario?>">
	     </td>
	     <td class="body-text1" width="80%" valign="top">
	      <a href="admusuarios.php?actualizar=<?=$IdUsuario?>" style="color:red ">
	      <?=$NombreCompleto?>
	      </a>
	     </td>
	     <td  align="center" class="body-text1"><?=$Usuario?></td>
	     <td class="body-text1">
	      <a href="admusuarios.php?borrar=<?=$IdUsuario?>" onclick="return confirm('Seguro que desea borrar?')" >Borrar</a>
	     </td>
	     <!--<td  align="center" valign="top" class="body-text1"><a href="admpermisos.php?IdUsuario=<?=$IdUsuario?>"><img src="../imagenes/iconos/ok.png" border="0"></a></td>-->
	     <tr>
	     <?
	    }
	   }
	   ?>
	  </table>
	<br>
          <a href="javascript:seleccionar_todo()">Marcar todos</a> |
	  <a href="javascript:deseleccionar_todo()">Marcar ninguno</a>
	  <br />
	  <br />
	  <fieldset class='scroll_checkboxes'>
	  <?php 
	   $RSresultado=$objUsuario->consultarDepartamentos_nopag();
	   while ($rowDepto = mysql_fetch_array($RSresultado))
	   {
	    $IdDepartamento=$rowDepto["IdDepartamento"]; 
	    $NomDepartamento=$rowDepto["NomDepartamento"];
       	    echo "<input name='DepartamentosUsuarios[]' type='checkbox' value='$IdDepartamento'>$NomDepartamento<br />";
	   }
	   ?>
	  </fieldset>
	  <br />
	  <?=$msg?>
	  <br />
	  <br />
	  <input type="image" src="../imagenes/ingresar.jpg">
	  <a href="<?=$_SERVER['PHP_SELF']?>"><img src="../imagenes/cancelar.jpg" alt="borrar" border="0" /></a>
	  
    </td>
  </tr>
  <tr>
    <td  height="10"><img src="imagenes/spacer.gif" width="1" height="1"></td>
  </tr>
</table>
</form>  
</body>
</html>