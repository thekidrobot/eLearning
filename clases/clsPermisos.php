<?
class clsPermisos
{
/////////////////////////////////////////////////////////////////////////////////////////////
function Elimina_Permisos($IdUsuario)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]); 
mysql_select_db($_SESSION["basededatos"], $link); 
$sql="DELETE FROM  permisos_usuarios WHERE  IdUsuario='$IdUsuario'";
$result = mysql_query($sql, $link);
}
/////////////////////////////////////////////////////////////////////////////////////////////
function Consulta_Categoria($IdUsuario,$Idcategorias)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]); 
mysql_select_db($_SESSION["basededatos"], $link); 
$sql="SELECT * FROM permisos_usuarios WHERE IdUsuario=$IdUsuario AND Idcategorias=$Idcategorias";
$rs=mysql_query($sql, $link);
return mysql_num_rows($rs);
}
/////////////////////////////////////////////////////////////////////////////////////////////
function Inserta_Categoria($IdUsuario,$Idcategorias)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]); 
mysql_select_db($_SESSION["basededatos"], $link); 
$sql="INSERT INTO permisos_usuarios (IdUsuario,Idcategorias) VALUES ($IdUsuario,$Idcategorias)";
$result = mysql_query($sql, $link);
}
/////////////////////////////////////////////////////////////////////////////////////////////
function Inserta_Grupo($IdUsuario,$IdGrupos)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]); 
mysql_select_db($_SESSION["basededatos"], $link); 
$sql="INSERT INTO permisos_usuarios (IdUsuario,IdGrupos) VALUES ($IdUsuario,$IdGrupos)";
$result = mysql_query($sql, $link);
}
/////////////////////////////////////////////////////////////////////////////////////////////
function Consulta_Grupo($IdUsuario,$IdGrupos)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]); 
mysql_select_db($_SESSION["basededatos"], $link); 
$sql="SELECT * FROM permisos_usuarios WHERE IdUsuario=$IdUsuario AND IdGrupos=$IdGrupos";
$rs=mysql_query($sql, $link);
return mysql_num_rows($rs);
}
/////////////////////////////////////////////////////////////////////////////////////////////
function Inserta_Subgrupo($IdUsuario,$IdSubGrupo)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]); 
mysql_select_db($_SESSION["basededatos"], $link); 
$sql="INSERT INTO permisos_usuarios (IdUsuario,IdSubGrupo) VALUES ($IdUsuario,$IdSubGrupo)";
$result = mysql_query($sql, $link);
}
/////////////////////////////////////////////////////////////////////////////////////////////
function Consulta_Subgrupo($IdUsuario,$IdSubGrupo)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]); 
mysql_select_db($_SESSION["basededatos"], $link); 
$sql="SELECT * FROM permisos_usuarios WHERE IdUsuario=$IdUsuario AND IdSubGrupo=$IdSubGrupo";
$rs=mysql_query($sql, $link);
return mysql_num_rows($rs);
}

/////////////////////////////////////////////////////////////////////////////////////////////
function Elimina_Permisos_Depto($IdDepartamento)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]); 
mysql_select_db($_SESSION["basededatos"], $link); 
$sql="DELETE FROM  permisos_departamentos WHERE  IdDepartamento='$IdDepartamento'";
$result = mysql_query($sql, $link);
}
/////////////////////////////////////////////////////////////////////////////////////////////
function Consulta_Categoria_Depto($IdDepartamento,$Idcategorias)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]); 
mysql_select_db($_SESSION["basededatos"], $link); 
$sql="SELECT * FROM permisos_departamentos WHERE IdDepartamento=$IdDepartamento AND Idcategorias=$Idcategorias";
$rs=mysql_query($sql, $link);
return mysql_num_rows($rs);
}
/////////////////////////////////////////////////////////////////////////////////////////////
function Consulta_Grupo_Depto($IdDepartamento,$IdGrupos)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]); 
mysql_select_db($_SESSION["basededatos"], $link); 
$sql="SELECT * FROM permisos_departamentos WHERE IdDepartamento=$IdDepartamento AND IdGrupos=$IdGrupos";
$rs=mysql_query($sql, $link);
return mysql_num_rows($rs);
}
/////////////////////////////////////////////////////////////////////////////////////////////
function Consulta_Subgrupo_Depto($IdDepartamento,$IdSubGrupo)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]); 
mysql_select_db($_SESSION["basededatos"], $link); 
$sql="SELECT * FROM permisos_departamentos WHERE IdDepartamento=$IdDepartamento AND IdSubGrupo=$IdSubGrupo";
$rs=mysql_query($sql, $link);
return mysql_num_rows($rs);
}

/////////////////////////////////////////////////////////////////////////////////////////////
function Inserta_Categoria_Depto($IdDepartamento,$Idcategorias)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]); 
mysql_select_db($_SESSION["basededatos"], $link); 
$sql="INSERT INTO permisos_departamentos (IdDepartamento,Idcategorias) VALUES ($IdDepartamento,$Idcategorias)";
$result = mysql_query($sql, $link);
}
/////////////////////////////////////////////////////////////////////////////////////////////
function Inserta_Grupo_Depto($IdDepartamento,$IdGrupos)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]); 
mysql_select_db($_SESSION["basededatos"], $link); 
$sql="INSERT INTO permisos_departamentos (IdDepartamento,IdGrupos) VALUES ($IdDepartamento,$IdGrupos)";
$result = mysql_query($sql, $link);
}
/////////////////////////////////////////////////////////////////////////////////////////////
function Inserta_Subgrupo_Depto($IdDepartamento,$IdSubGrupo)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]); 
mysql_select_db($_SESSION["basededatos"], $link); 
$sql="INSERT INTO permisos_departamentos (IdDepartamento,IdSubGrupo) VALUES ($IdDepartamento,$IdSubGrupo)";
$result = mysql_query($sql, $link);
}

}
?>
