<?php include("header.php"); ?>
<?
$objUsuario=new clsusuario();
$msg="";

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

<body>
<div id="wrapper">
 <?php include("top_menu.php"); ?>
 <div id="page">
  <div id="content">
   <div class="post">

    <b>Inicio >> Usuarios</b>
    <br>
    <br>
    
    <form name="formBuscar" action="<?=$_SERVER['PHP_SELF']?>" method="post">
     <fieldset>
     <table cellpadding="5" cellspacing="5">
      <tr>
       <td colspan="2">Buscar Usuarios</td>
      </tr>
      
      <tr>
       <td width="40%">Nombre : </td>
       <td>
        <input type="text" name="valorNombre" value="" maxlength="255">        
        <input type="hidden" name="buscar" value="1">
       </td>
      </tr>
      
      <tr>
       <td align="right" colspan="2">
        <input type="image" src="../imagenes/ingresar.jpg"><a href="<?=$_SERVER['PHP_SELF']?>"><img src="../imagenes/cancelar.jpg" alt="borrar" border="0" /></a>
       </td>
      </tr>
      
     </table>
     </fieldset>
    </form>
    
    <br>
    
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
	  <td colspan="2">
	   <span>Ingresar Usuarios </span>
	  </td>
	 </tr>
	 
	 <tr>
	  <td colspan="2">&nbsp;</td>
	 </tr>
      
      <tr>
       <td width="40%"> Nombre </td>
       <td><input type="text" name="valorNombre" value="<?=$vNombreCompleto?>" maxlength="255" ></td>
      </tr>
      <tr>
       <td> Login </td>
       <td><input type="text" name="valorLogin" value="<?=$vUsuario?>" maxlength="100" ></td>
      </tr>
      <tr>
       <td> Clave</td>
       <td><input type="password" name="valorClave" value="<?=$vPassword?>" maxlength="15" ></td>
      </tr>
      <tr>
       <td valign="top"> Departamentos</td>
      <td>
      <fieldset>
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
     <td colspan="2" align="right">
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
          <td width="5%">&nbsp;</td>
          <td width="80%"> Nombre </td>
          <td align="center"> Login </td>
          <td align="center">Borrar</td>
          <!--<td  align="center">Permisos</td>-->
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
	     <td width="5%" valign="top">
	      <input name="Usuarios[]" type="checkbox" value="<?=$IdUsuario?>">
	     </td>
	     <td width="80%" valign="top">
	      <a href="admusuarios.php?actualizar=<?=$IdUsuario?>">
	      <?=$NombreCompleto?>
	      </a>
	     </td>
	     <td  align="center"><?=$Usuario?></td>
	     <td>
	      <a href="admusuarios.php?borrar=<?=$IdUsuario?>" onclick="return confirm('Seguro que desea borrar?')" >Borrar</a>
	     </td>
	     <!--<td  align="center" valign="top"><a href="admpermisos.php?IdUsuario=<?=$IdUsuario?>"><img src="../imagenes/iconos/ok.png" border="0"></a></td>-->
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
	     <td width="5%" width="80%" valign="top">
	      <input name="Usuarios[]" id="usuario" type="checkbox" value="<?=$IdUsuario?>">
	     </td>
	     <td width="80%" valign="top">
	      <a href="admusuarios.php?actualizar=<?=$IdUsuario?>">
	      <?=$NombreCompleto?>
	      </a>
	     </td>
	     <td  align="center"><?=$Usuario?></td>
	     <td>
	      <a href="admusuarios.php?borrar=<?=$IdUsuario?>" onclick="return confirm('Seguro que desea borrar?')" >Borrar</a>
	     </td>
	     <!--<td  align="center" valign="top"><a href="admpermisos.php?IdUsuario=<?=$IdUsuario?>"><img src="../imagenes/iconos/ok.png" border="0"></a></td>-->
	     <tr>
	     <?
	    }
	   }
	   ?>
	  </table>
	<br>
          <a href="javascript:seleccionar_todo_usr()">Marcar todos</a> |
	  <a href="javascript:deseleccionar_todo_usr()">Marcar ninguno</a>
	  <br />
	  <br />
	  <fieldset>
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