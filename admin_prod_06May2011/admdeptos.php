<?
include("../conexion.php");
include("../clases/clsusuario.php");

include("../clases/clsSubGrupo.php");
include("../clases/clsPermisos.php");

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

$objSubGrupo=new clsSubGrupo();
$objPermisos=new clsPermisos();

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
  
  $qShowStatus = "SHOW TABLE STATUS LIKE 'departamentos'";
  $qShowStatusResult = mysql_query($qShowStatus) or die( "Query failed: " . mysql_error() . "<br/>" . $qShowStatus );
 
  $row = mysql_fetch_assoc($qShowStatusResult);
  $next_increment = $row['Auto_increment'];
   
  $IdDepartamento = $next_increment-1;
   
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
      $objPermisos->Inserta_Categoria_Depto($IdDepartamento,$Id);
      break;	
     
     case 'G':
      //grupos
      $objPermisos->Inserta_Grupo_Depto($IdDepartamento,$Id);
      break;
		
     case 'S':
      //subgrupos
      $objPermisos->Inserta_Subgrupo_Depto($IdDepartamento,$Id);
      break;
    }
   }
  }
  
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

 $objPermisos->Elimina_Permisos_Depto($IdDepartamento);
  
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
     $objPermisos->Inserta_Categoria_Depto($IdDepartamento,$Id);
     break;	
    
    case 'G':
     //grupos
     $objPermisos->Inserta_Grupo_Depto($IdDepartamento,$Id);
     break;
	       
    case 'S':
     //subgrupos
     $objPermisos->Inserta_Subgrupo_Depto($IdDepartamento,$Id);
     break;
   }
  }
 }

 //Reescribe permisos de usuarios
 
 $sql = "select * from departamentos_usuarios where IdDepartamento = $IdDepartamento";
  
 $result = mysql_query($sql);
 
 while ($row = mysql_fetch_array($result))
 {
  $IdUsuario = $row["IdUsuario"]; 

  $sql2= "DELETE FROM permisos_usuarios
	  WHERE	 IdUsuario = $IdUsuario
	  AND IdDepartamento = $IdDepartamento";
  
  $result2 = mysql_query($sql2);
  
  $objUsuario->ingresarDepartamentosUsuario($IdUsuario,$IdDepartamento);	  
  
 }
  
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
 <script language="javascript" src="../js/js.js"></script>
 <script language="javascript">
  function seleccionar_todo()
  {
   for (i=0;i<document.formProceso.elements.length;i++)
   if(document.formProceso.elements[i].type == "checkbox")
   document.formProceso.elements[i].checked=1
  } 
 
  function deseleccionar_todo()
  {
   for (i=0;i<document.formProceso.elements.length;i++)
   if(document.formProceso.elements[i].type == "checkbox")
   document.formProceso.elements[i].checked=0
  } 
 </script> 
</head>
<body leftmargin="0" topmargin="0" background="" >
 <table width="41%" height="100%" align="center" cellpadding="5" cellspacing="1">
  <tr>
   <td  height="1"><img src="../imagenes/spacer.gif" width="1" height="1"></td>
  </tr>
  <tr>
   <td class="body-text1" background="" valign="top" align="left"><b>Inicio >>Departamentos</b><br><br>
   
   <form name="formProceso" action="<?=$_SERVER['PHP_SELF']?>" method="post">
    <? 
    if($_GET["actualizar"]!="")
    {?>
     <input type="hidden" name="actualizar" value="<?=$_GET["actualizar"]?>">
     <? 
    }
    else
    {?>
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
    <td class="body-text1" colspan="2">
    <br/>
    <?php
     $RSresultado=$objUsuario->consultarCategorias();
     while ($row = mysql_fetch_array($RSresultado))
     {
       $IdCategorias=$row["IdCategorias"]; 
       @$activo=$objPermisos->Consulta_Categoria_Depto($vIdDepto,$IdCategorias);
       if ($activo>0){$check='checked';}else{$check='';} 
       echo '<UL><input name="C'.$IdCategorias.'" type="checkbox" value="'.$IdCategorias.'" '.$check.' >'. $row["categorias"].'<UL>';
      
       //Grupos
       $RSresultadoGrupos=$objUsuario->consultarGrupos($IdCategorias);
       while ($rowGrupos = mysql_fetch_array($RSresultadoGrupos))
       {
        $IdGrupos=$rowGrupos["IdGrupos"]; 
        $grupos=$rowGrupos["grupos"]; 
        @$activo=$objPermisos->Consulta_Grupo_Depto($vIdDepto,$IdGrupos);
        if ($activo>0){$check='checked';}else{$check='';} 
        echo '<LI><input name="G'.$IdGrupos.'" type="checkbox" value="'.$IdGrupos.'" '.$check.' >'.$grupos.'<UL>';

        //subGrupos
        $RSSubGrupo=$objSubGrupo->consultarSubGrupos($IdGrupos);
        while ($rowSubGrupo = mysql_fetch_array($RSSubGrupo))
        {
	 $IdSubGrupo=$rowSubGrupo["IdSubGrupo"]; 
	 $NombreSubGrupo=$rowSubGrupo["NombreSubGrupo"]; 	
	 @$activo=$objPermisos->Consulta_Subgrupo_Depto($vIdDepto,$IdSubGrupo);
	 if ($activo>0){$check='checked';}else{$check='';} 
	 echo '<LI><input name="S'.$IdSubGrupo.'" type="checkbox" value="'.$IdSubGrupo.'" '.$check.' >'. $NombreSubGrupo.'</LI>';
	}
        echo '</UL></LI>';
       }
       echo '</UL></UL>';
      }
      ?>
      <br>
      <a href="javascript:seleccionar_todo()">Marcar todos</a> | <a href="javascript:deseleccionar_todo()">Marcar ninguno</a>
    </td>
    </td>
   
    <tr>
     <td colspan="2" align="right" class="body-text1">
      <input type="image" src="../imagenes/ingresar.jpg"><a href="<?=$_SERVER['PHP_SELF']?>"><img src="../imagenes/cancelar.jpg" alt="borrar" border="0" /></a>
      <br><br><?=$msg?>
     </td>
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
       <tr>
      </tr>
     </table><br><br>
    </td>
   </tr>
   <tr>
    <td  height="10"><img src="imagenes/spacer.gif" width="1" height="1"></td>
   </tr>
</table>
</body>
</html>