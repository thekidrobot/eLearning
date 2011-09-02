<?php include("header.php"); ?>
<?
$objUsuario=new clsusuario();
$objSubGrupo=new clsSubGrupo();
$objPermisos=new clsPermisos();
$msg="";
//ingresar   
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

//actualizar
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

<body>
<div id="wrapper">
 <?php include("top_menu.php"); ?>
 <div id="page">
  <div id="content">
   <div class="post">
	 <b>Inicio >> Grupos de usuarios</b> 
   <br />
   <br />
	 <form name="formProceso" action="<?=$_SERVER['PHP_SELF']?>" method="post">
	 <fieldset>
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
	 <table width="100%">
	 <tr>
	  <td>
	   <span>Ingresar Grupos de usuarios</span>
	  </td>
	 </tr>
	 <tr>
	  <td>&nbsp;</td>
	 </tr>
	 <tr>
	  <td>
	   <span>Nombre: </span>
	   <input type="hidden" name="IdDepartamento" value="<?=$vIdDepto?>">
	   <input type="text" name="NomDepartamento" value="<?=$vNomDepto?>" maxlength="255">
	  </td>
	 </tr>
	 
	 <tr>
	  <td>
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
		 </td>
    </tr>

		<tr>
		 <td>
			<a href="javascript:seleccionar_todo()">Marcar todos</a> | <a href="javascript:deseleccionar_todo()">Marcar ninguno</a>
		 </td>
		</tr>
	
	 <tr>
		<td align="center">
		 <input type="image" src="../imagenes/ingresar.jpg"><a href="<?=$_SERVER['PHP_SELF']?>"><img src="../imagenes/cancelar.jpg" alt="borrar" border="0" /></a>
		</td>
	 </tr>
	
	 <tr>
		<td>
		 <?=$msg?>
    </td>
   </tr>
  </table>
  </fieldset>
  </form>
   
  <br>
   <table border="1" bordercolor="D4D4D4" cellpadding="5" cellspacing="0" width="100%">
	<tr bgcolor="D4D4D4" >
	 <td width="80%"> Nombre </td>
     <td align="center">Borrar</td>
     <tr>
	  <?
	  $RSresultado=$objUsuario->consultarDepartamentos();
	  while ($row = mysql_fetch_array($RSresultado))
	  {
	   $IdDepartamento=$row["IdDepartamento"]; 
	   $NomDepartamento=$row["NomDepartamento"];
	   ?>
	   <tr bgcolor="white" >
		<td width="80%" valign="top">
		 <a href="admdeptos.php?actualizar=<?=$IdDepartamento?>" ><?=$NomDepartamento?></a>
		</td>
		<td>
		 <a href="admdeptos.php?borrar=<?=$IdDepartamento?>" onclick="return confirm('Seguro que desea borrar?')" >Borrar</a>
		</td>
	   <tr>
	   <?
	  }
	  ?>
     <tr>
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