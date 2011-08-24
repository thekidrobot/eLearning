<?

include("ps_pagination.php");

class clsusuario
{
/////////////////////////////////////////////////////////////////////////////////////////////
function validacionAdministrador($Usuario,$Clave)
{
$valido=0;
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]); 
mysql_select_db($_SESSION["basededatos"], $link); 
$sql="SELECT * FROM administrador WHERE Clave='" . $Clave . "' AND Login='" . $Usuario . "' ";
$result = mysql_query($sql, $link);

while ($row = mysql_fetch_array($result))
	 {
		$valido=$row["IdAdministrador"];
	 }
return $valido;
}
/////////////////////////////////////////////////////////////////////////////////////////////
function validacionUsuario($Usuario,$Clave)
{
$valido=0;
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]); 
mysql_select_db($_SESSION["basededatos"], $link); 
$sql="SELECT * FROM usuarios WHERE Password='" . $Clave . "' AND Usuario='" . $Usuario . "' ";
$result = mysql_query($sql, $link);

while ($row = mysql_fetch_array($result))
	 {
		$valido=$row["IdUsuario"];
		$_SESSION['NombreCompleto']=$row["NombreCompleto"];
	 }
return $valido;


}
/////////////////////////////////////////////////////////////////////////////////////////////

function validacionLoginUsuario($Usuario)
{
$valido=1;
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]); 
mysql_select_db($_SESSION["basededatos"], $link); 
$sql="SELECT * FROM usuarios WHERE  Usuario='" . $Usuario . "' ";
$result = mysql_query($sql, $link);

while ($row = mysql_fetch_array($result))
	 {
		$valido=0;
	 }
return $valido;
}
/////////////////////////////////////////////////////////////////////////////////////////////

function actualizarClave($Login,$Clave)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link); 
$sql="update administrador set Clave='".$Clave."' where Login='".$Login."' ";
$result = mysql_query($sql);
}
/////////////////////////////////////////////////////////////////////////////////////////////
function actualizarClaveUsuario($Login,$Clave,$Correo)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link); 
$sql="update usuarios set Password='$Clave', Correo = '$Correo',Usuario='$Correo' where Usuario='".$Login."' ";
$result = mysql_query($sql);
}
/////////////////////////////////////////////////////////////////////////////////////////////

function consultarUsuarios()
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link); 
$sql = "SELECT * FROM  usuarios order by NombreCompleto";

$pager = new PS_Pagination($link, $sql, 100, 5);
$result = $pager->paginate();

//$result = mysql_query($sql, $link);

?><div align="center"> <?php echo $pager->renderFullNav(); ?> </div><br/> <?php


return $result;
}

function contarUsuarios()
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link); 
$sql = "SELECT * FROM  usuarios order by NombreCompleto";
$result = mysql_query($sql, $link);
return $result;
}

/////////////////////////////////////////////////////////////////////////////////////////////
function consultarDetalleUsuarios($IdUsuario)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link); 
$sql = "SELECT * FROM  usuarios where IdUsuario=".$IdUsuario;
$result = mysql_query($sql, $link);
return $result;
}
/////////////////////////////////////////////////////////////////////////////////////////////
function consultarDetalleUsuariosPorNombre($Usuario)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link); 
$sql = "SELECT * FROM  usuarios where Usuario='$Usuario'";
$result = mysql_query($sql, $link);
return $result;
}
/////////////////////////////////////////////////////////////////////////////////////////////
function consultarDetalleUsuariosPorNombreLike($Usuario)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link); 
$sql = "SELECT * FROM  usuarios where NombreCompleto like'%$Usuario%' order by NombreCompleto";

$pager = new PS_Pagination($link, $sql, 100, 5);
$result = $pager->paginate();

//$result = mysql_query($sql, $link);

?><div align="center"> <?php echo $pager->renderFullNav(); ?> </div><br/> <?php

return $result;
}

/////////////////////////////////////////////////////////////////////////////////////////////
function ingresarUsuario($Usuario,$Password,$NombreCompleto,$idGrupo)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link); 
$sql="insert into usuarios (Usuario,Password,NombreCompleto,FechaCreacion) values ('".$Usuario."','".$Password."','".$NombreCompleto."',NOW()) ";
$result = mysql_query($sql);
}
/////////////////////////////////////////////////////////////////////////////////////////////
function actualizarUsuario($IdUsuario,$Password,$NombreCompleto,$Usuario)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link); 
$sql="update usuarios set Usuario='".$Usuario."',NombreCompleto='".$NombreCompleto."',Password='".$Password."' where IdUsuario=".$IdUsuario;
$result = mysql_query($sql);
}
/////////////////////////////////////////////////////////////////////////////////////////////
function borrarUsuario($IdUsuario)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link); 
$sql="delete from usuarios where IdUsuario=".$IdUsuario;
$result = mysql_query($sql);
}
/////////////////////////////////////////////////////////////////////////////////////////////
function validacionCategorias($categorias)
{
$valido=1;
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]); 
mysql_select_db($_SESSION["basededatos"], $link); 
$sql="SELECT * FROM categorias WHERE  categorias='" . $categorias . "' ";
$result = mysql_query($sql, $link);

while ($row = mysql_fetch_array($result))
	 {
		$valido=0;
	 }
return $valido;
}
//////////////////////////////////////////////////////////////////////////////////////////////

function consultarDetalleCategorias($Idcategorias)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link); 
$sql = "SELECT * FROM  categorias where Idcategorias=".$Idcategorias;
$result = mysql_query($sql, $link);
return $result;
}

/////////////////////////////////////////////////////////////////////////////////////////////
function consultarCategorias()
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link); 
$sql = "SELECT * FROM  categorias";
$result = mysql_query($sql, $link);
return $result;
}
/////////////////////////////////////////////////////////////////////////////////////////////

function ingresarCategorias($Detallecategorias)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link); 

$sql="insert into categorias (categorias) values ('" .$Detallecategorias. "') ";
$result = mysql_query($sql);

}
/////////////////////////////////////////////////////////////////////////////////////////////
function actualizarCategorias($Idcategorias,$categorias)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link); 

$sql="update categorias set categorias ='".$categorias."' where Idcategorias=".$Idcategorias;
$result = mysql_query($sql);

}
/////////////////////////////////////////////////////////////////////////////////////////////
function borrarCategorias($Idcategorias)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link); 

$sql = "delete from videosvistos
	    where Idvideo in(select Idvideo from videos
						 where IdSubGrupo in((select IdSubGrupo from subgrupos
											  where IdGrupos in(select IdGrupos from grupos
															    where IdCategorias = $Idcategorias))))";
mysql_query($sql) or die('Invalid query: ' . mysql_error().' '.$sql);

$sql = "delete from videosvistos
	    where Idvideo in(select Idvideo from videos
				  where IdGrupos in(select IdGrupos from grupos
									where IdCategorias = $Idcategorias))";
mysql_query($sql) or die('Invalid query: ' . mysql_error().' '.$sql);

$sql = "delete from videos
	   where IdSubGrupo in(select IdSubGrupo from subgrupos
						    where IdGrupos in(select IdGrupos from grupos
											  where IdCategorias = $Idcategorias))";
mysql_query($sql) or die('Invalid query: ' . mysql_error().' '.$sql);

$sql = "delete from videos
	   where IdGrupos in(select IdGrupos from grupos
						 where IdCategorias = $Idcategorias)";
mysql_query($sql) or die('Invalid query: ' . mysql_error().' '.$sql);

$sql = "delete FROM permisos_usuarios WHERE IdCategorias = $Idcategorias";
mysql_query($sql) or die('Invalid query: ' . mysql_error().' '.$sql);

$sql = "delete from permisos_usuarios
	    where IdGrupos in(select IdGrupos from grupos
						  where IdCategorias = $Idcategorias)";
mysql_query($sql) or die('Invalid query: ' . mysql_error().' '.$sql);

$sql = "delete from permisos_usuarios
	    where IdSubGrupo in(select IdSubGrupo from subgrupos
						    where IdGrupos in(select IdGrupos from grupos
											  where IdCategorias = $Idcategorias))";
mysql_query($sql) or die('Invalid query: ' . mysql_error().' '.$sql);

$sql = "delete from subgrupos
			 where IdGrupos in (select IdGrupos from grupos
							    where IdCategorias = $Idcategorias)";
mysql_query($sql) or die('Invalid query: ' . mysql_error().' '.$sql);


$sql = "delete from grupos where IdCategorias = $Idcategorias";
mysql_query($sql) or die('Invalid query: ' . mysql_error().' '.$sql);

$sql="delete from categorias where Idcategorias=".$Idcategorias;
$result = mysql_query($sql);

}
/////////////////////////////////////////////////////////////////////////////////////////////
function consultarDetalleGrupos($IdGrupos)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link); 
$sql = "SELECT * FROM  grupos where IdGrupos=".$IdGrupos;
$result = mysql_query($sql, $link);
return $result;
}

/////////////////////////////////////////////////////////////////////////////////////////////
function consultarGrupos($Idcategorias)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link); 
 $sql = "SELECT * FROM  grupos WHERE Idcategorias=$Idcategorias";
$result = mysql_query($sql, $link);
return $result;
}
/////////////////////////////////////////////////////////////////////////////////////////////

function ingresarGrupos($DetalleGrupos,$Idcategorias)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link); 

$sql="insert into grupos (grupos,Idcategorias) values ('" .$DetalleGrupos. "',$Idcategorias) ";
$result = mysql_query($sql);

}
/////////////////////////////////////////////////////////////////////////////////////////////
function actualizarGrupos($IdGrupos,$grupos)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link); 

$sql="update grupos set grupos ='".$grupos."' where IdGrupos=".$IdGrupos;
$result = mysql_query($sql);

}

/////////////////////////////////////////////////////////////////////////////////////////////
function borrarGrupos($IdGrupos,$IdCategorias)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link); 

$sql = "delete from subgrupos where IdGrupos = $IdGrupos";
mysql_query($sql) or die('Invalid query: ' . mysql_error().' '.$sql);

$sql = "delete from videosvistos where Idvideo in(select Idvideo from videos where IdGrupos = $IdGrupos)";
mysql_query($sql) or die('Invalid query: ' . mysql_error().' '.$sql);

$sql = "delete from videos where IdGrupos = $IdGrupos";
mysql_query($sql) or die('Invalid query: ' . mysql_error().' '.$sql);

$sql="delete from grupos where IdGrupos = $IdGrupos and IdCategorias = $IdCategorias";
$result = mysql_query($sql);

}

function historialvista_videos($IdUsuario){

$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link); 

$sql="SELECT 
  usuarios.IdUsuario,
   videos.nombre ,
    count(videosvistos.fecha)  as vistos
FROM
  usuarios
  INNER JOIN videosvistos ON (usuarios.IdUsuario = videosvistos.IdUsuario)
  INNER JOIN videos ON (videosvistos.Idvideo = videos.Idvideo)
WHERE
  usuarios.IdUsuario = '".$IdUsuario ."'
group by videos.nombre";

$result = mysql_query($sql, $link);
return $result;
}

/////////////////////////////////////////////////////////////////////////////////////////////

function validacionDepartamento($NomDepartamento)
{
$valido=1;
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]); 
mysql_select_db($_SESSION["basededatos"], $link); 
$sql="SELECT * FROM departamentos WHERE  NomDepartamento='" . $NomDepartamento. "' ";
$result = mysql_query($sql, $link);

while ($row = mysql_fetch_array($result))
	 {
		$valido=0;
	 }
return $valido;
}

/////////////////////////////////////////////////////////////////////////////////////////////
function ingresarDepartamento($NomDepartamento)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link); 
$sql="insert into departamentos (NomDepartamento) values ('".$NomDepartamento."') ";
$result = mysql_query($sql);
}
/////////////////////////////////////////////////////////////////////////////////////////////
function actualizarDepartamento($NomDepartamento,$IdDepartamento)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link); 
$sql="update departamentos set NomDepartamento='$NomDepartamento' where IdDepartamento=".$IdDepartamento;
$result = mysql_query($sql);
}
/////////////////////////////////////////////////////////////////////////////////////////////
function borrarDepartamento($IdDepartamento)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link);
$sql="delete from departamentos_usuarios where IdDepartamento = $IdDepartamento";
mysql_query($sql) or die('Invalid query: ' . mysql_error().' '.$sql);
$sql="delete from departamentos where IdDepartamento=".$IdDepartamento;
$result = mysql_query($sql);
}

/////////////////////////////////////////////////////////////////////////////////////////////

function consultarDetalleDepartamentos($IdDepartamento)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link); 
$sql = "SELECT * FROM  departamentos where IdDepartamento=".$IdDepartamento;
$result = mysql_query($sql, $link);
return $result;
}

/////////////////////////////////////////////////////////////////////////////////////////////

function consultarDepartamentos()
{
   $link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
   mysql_select_db($_SESSION["basededatos"], $link); 
   $sql = "SELECT * FROM  departamentos order by NomDepartamento ";
   
   $pager = new PS_Pagination($link, $sql, 100, 5);
   $result = $pager->paginate();
   
   ?><div align="center"> <?php echo $pager->renderFullNav(); ?> </div><br/> <?php

   //$result = mysql_query($sql, $link);
   return $result;
}


function consultarDepartamentos_nopag()
{
   $link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
   mysql_select_db($_SESSION["basededatos"], $link); 
   $sql = "SELECT * FROM  departamentos order by NomDepartamento ";
   $result = mysql_query($sql, $link);
   return $result;
}

/////////////////////////////////////////////////////////////////////////////////////////////

function consultarDepartamentosUsuario($IdDepartamento,$IdUsuario)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link); 
$sql = "SELECT count(*) as cuenta FROM  departamentos_usuarios where IdUsuario = $IdUsuario and IdDepartamento = $IdDepartamento";
$result = mysql_query($sql, $link);
return $result;
}

/////////////////////////////////////////////////////////////////////////////////////////////

function borrarDepartamentosUsuario($IdUsuario)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link); 
$sql = "delete FROM  departamentos_usuarios where IdUsuario = $IdUsuario";
$result = mysql_query($sql, $link);
return $result;
}

function borrarPermisosUsuario($IdUsuario)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link); 
$sql1 = "Delete from permisos_usuarios where IdUsuario = $IdUsuario";
$result1 = mysql_query($sql1, $link);
return $result;
}

function ingresarDepartamentosUsuario($IdUsuario,$idDepartamento)
{
   $link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
   mysql_select_db($_SESSION["basededatos"], $link); 
   
   $sql = "insert ignore into departamentos_usuarios values($IdUsuario,$idDepartamento)";
   $result = mysql_query($sql, $link);

   $sql2 = "SELECT * FROM permisos_departamentos WHERE IdDepartamento = $idDepartamento";
   $result2 = mysql_query($sql2, $link);
   
   while ($row = mysql_fetch_array($result2))
   {
      if (is_null($row["IdCategorias"]))
         $IdCategorias='NULL';
      else
         $IdCategorias=$row["IdCategorias"];
      
      if (is_null($row["IdGrupos"]))
         $IdGrupos='NULL';
      else
         $IdGrupos=$row["IdGrupos"]; 

      if (is_null($row["IdSubGrupo"]))
         $IdSubGrupo='NULL';
      else
         $IdSubGrupo=$row["IdSubGrupo"]; 
      
      $sql3 = "insert into permisos_usuarios(IdUsuario,IdCategorias,IdGrupos,IdSubGrupo,IdDepartamento) values ($IdUsuario,$IdCategorias,$IdGrupos,$IdSubGrupo,$idDepartamento)";
      $result3 = mysql_query($sql3, $link);
   }
   
   return $result2;
}



}
?>
