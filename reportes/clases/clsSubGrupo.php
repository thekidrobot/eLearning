<?
class clsSubGrupo
{
//////////////////////////////////////////////////////////////////////////////////////////////////
function ingresarSubGrupo($NombreSubGrupo,$estado,$IdGrupos)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link); 
$sql="insert into subgrupos (NombreSubGrupo, estado, IdGrupos) values ('".$NombreSubGrupo."','".$estado."','".$IdGrupos."')  ";
$result = mysql_query($sql);
}
//////////////////////////////////////////////////////////////////////////////////////////////////
function actualizarSubGrupo($IdSubGrupo,$NombreSubGrupo,$estado)
{  
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link); 
$sql="update subgrupos set NombreSubGrupo = '$NombreSubGrupo',estado = $estado where IdSubGrupo = $IdSubGrupo";
$result = mysql_query($sql);
}
/*//////////////////////////////////////////////////////////////////////////////////////////////////
function actualizarTaller($Idtaller,$NombreTaller,$estado,$IdGrupos)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link); 
$sql="update taller set estado='".$estado."', NombreTaller='".$NombreTaller."', IdGrupos='".$IdGrupos."' where  Idtaller=".$Idtaller;
$result = mysql_query($sql);
}*/
//////////////////////////////////////////////////////////////////////////////////////////////////
function ingresaModulo($Titulo,$Calificacion,$Idvideo,$CalificacionMinima,$estado)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link); 
$sql="insert into modulos (Titulo,Calificacion,Idvideo,CalificacionMinima,estado) values ('".$Titulo."',".$Calificacion.",".$Idvideo.",".$CalificacionMinima.",'".$estado."')";
$result = mysql_query($sql);
}
//////////////////////////////////////////////////////////////////////////////////////////////////
function actualizarModulo($IdModulo,$Titulo,$Calificacion,$CalificacionMinima,$Presentacion,$Juego,$Juego2,$estado)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link); 
$sql="update modulos set Titulo='".$Titulo."',Calificacion=".$Calificacion.",CalificacionMinima=".$CalificacionMinima.",Presentacion='".$Presentacion."',Juego='".$Juego."',Juego2='".$Juego2."',estado='".$estado."' where  IdModulo=".$IdModulo;
$result = mysql_query($sql);
}
//////////////////////////////////////////////////////////////////////////////////////////////////
function borrarModulo($IdModulo)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link); 

$sql = "delete from videosvistos where Idvideo in(select Idvideo from modulos where IdModulo = $IdModulo)";
mysql_query($sql) or die('Invalid query: ' . mysql_error().' '.$sql);

$sql = "delete from videos where Idvideo in(select Idvideo from modulos where IdModulo= $IdModulo)";
mysql_query($sql) or die('Invalid query: ' . mysql_error().' '.$sql);

$sql = "delete from respuesta where IdPregunta in(select IdPregunta from preguntas where IdModulo= $IdModulo)";
mysql_query($sql) or die('Invalid query: ' . mysql_error().' '.$sql);

$sql = "delete from from preguntas where IdModulo= $IdModulo";
mysql_query($sql) or die('Invalid query: ' . mysql_error().' '.$sql);

$sql="delete from modulos where IdModulo=".$IdModulo;
$result = mysql_query($sql);
}
//////////////////////////////////////////////////////////////////////////////////////////////////
function ingresarPreguntaTaller($IdModulo,$DetallePregunta)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link); 
$sql="insert into preguntas (IdModulo,DetallePregunta) values (".$IdModulo.",'".$DetallePregunta."') ";
$result = mysql_query($sql);
}
//////////////////////////////////////////////////////////////////////////////////////////////////
function ingresarrespPregMod($IdPregunta,$DetalleRespuesta,$Correcta)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link); 


if($Correcta=="1")
 {
   $sql="update respuesta set Correcta=0 where IdPregunta=".$IdPregunta;
   $result = mysql_query($sql);
 }

$sql="insert into respuesta (IdPregunta,DetalleRespuesta,Correcta) values (".$IdPregunta.",'".$DetalleRespuesta."',".$Correcta.") ";
$result = mysql_query($sql);

}
//////////////////////////////////////////////////////////////////////////////////////////////////

function actualizarrespPregMod($IdRespuesta,$DetalleRespuesta,$Correcta,$IdPregunta)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link); 


if($Correcta=="1")
 {
   $sql="update respuesta set Correcta=0 where IdPregunta=".$IdPregunta;
   $result = mysql_query($sql);
 }

$sql="update  respuesta set Correcta=".$Correcta.",DetalleRespuesta='".$DetalleRespuesta."' where IdRespuesta=".$IdRespuesta;
$result = mysql_query($sql);

}
//////////////////////////////////////////////////////////////////////////////////////////////////

function actualizarPreguntaTaller($IdPregunta,$DetallePregunta)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link); 
$sql="update preguntas set DetallePregunta='".$DetallePregunta."' where IdPregunta=".$IdPregunta;
$result = mysql_query($sql);
}
//////////////////////////////////////////////////////////////////////////////////////////////////

function ingresarNotaObtenida($IdUsuario,$IdModulo,$NotaObtenida,$NotaBase,$NotaMinima)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link); 
$sql="insert into resultadoexamen (IdUsuario,IdModulo,NotaObtenida,NotaBase,NotaMinima) values (".$IdUsuario.",".$IdModulo.",".$NotaObtenida.",".$NotaBase.",".$NotaMinima.")";
$result = mysql_query($sql);
}
//////////////////////////////////////////////////////////////////////////////////////////////////

function consultarDetallePreguntaTaller($IdPregunta)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link); 
$sql = "SELECT * FROM  preguntas where IdPregunta=".$IdPregunta;
$result = mysql_query($sql, $link);
return $result;
}
/////////////////////////////////////////////////////////////////////////////////////////////
function consultarDetalleRespPregMod($IdRespuesta)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link); 
$sql = "SELECT * FROM  respuesta where IdRespuesta=".$IdRespuesta;
$result = mysql_query($sql, $link);
return $result;
}
/////////////////////////////////////////////////////////////////////////////////////////////
function consultarRepuestasTotalesPregMod($IdPregunta)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link); 
$sql = "SELECT * FROM  respuesta where IdPregunta=".$IdPregunta;
$result = mysql_query($sql, $link);
return $result;
}
/////////////////////////////////////////////////////////////////////////////////////////////

function consultarSubGrupos($IdGrupos)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link); 
$sql = "SELECT 
  `subgrupos`.NombreSubGrupo,
  `subgrupos`.estado,
  `grupos`.grupos,
  `subgrupos`.IdSubGrupo
FROM
  `subgrupos`
  INNER JOIN `grupos` ON (`subgrupos`.IdGrupos = `grupos`.IdGrupos)  WHERE grupos.IdGrupos=$IdGrupos order by NombreSubGrupo";
$result = mysql_query($sql, $link);
return $result;
}
/////////////////////////////////////////////////////////////////////////////////////////////

function consultarTalleresUser()
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link); 
$sql = "SELECT 
  `taller`.NombreTaller,
  `taller`.estado,
  `grupos`.grupos,
  `taller`.Idtaller
FROM
  `taller`
  INNER JOIN `grupos` ON (`taller`.IdGrupos = `grupos`.IdGrupos) WHERE taller.estado = 1 order by NombreTaller";
$result = mysql_query($sql, $link);
return $result;
}
/////////////////////////////////////////////////////////////////////////////////////////////
function consultarTalleresUserGrupo($IdGrupos)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link); 
$sql = "SELECT 
  `taller`.NombreTaller,
  `taller`.estado,
  `grupos`.grupos,
  `taller`.Idtaller
FROM
  `taller`
  INNER JOIN `grupos` ON (`taller`.IdGrupos = `grupos`.IdGrupos) WHERE taller.estado = 1 and grupos.IdGrupos= '$IdGrupos'order by NombreTaller";
$result = mysql_query($sql, $link);
return $result;
}
/////////////////////////////////////////////////////////////////////////////////////////////

function consultarPreguntTalleresMod($IdModulo)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link); 
 $sql = "SELECT 
  modulos.Titulo,
  preguntas.IdPregunta,
  preguntas.IdModulo,
  preguntas.DetallePregunta
FROM
  modulos
  INNER JOIN preguntas ON (modulos.IdModulo = preguntas.IdModulo)
WHERE
  modulos.IdModulo =".$IdModulo;
$result = mysql_query($sql, $link);
return $result;
}
/////////////////////////////////////////////////////////////////////////////////////////////

function consultarModulosVideos($Idvideo)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link); 
$sql = "SELECT * FROM  modulos where Idvideo=".$Idvideo." order by Titulo";
return mysql_query($sql, $link);
}
/////////////////////////////////////////////////////////////////////////////////////////////


/////////////////////////////////////////////////////////////////////////////////////////////

function consultarModulosTalleresActivo($Idtaller)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link); 
$sql = "SELECT * FROM  modulos where Idtaller=".$Idtaller." and estado=1 order by Titulo";
$result = mysql_query($sql, $link);
return $result;
}
/////////////////////////////////////////////////////////////////////////////////////////////

function consultarDetalleSubGrupo($IdSubGrupo)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link); 
$sql = "SELECT * FROM  subgrupos where IdSubGrupo=".$IdSubGrupo;
$result = mysql_query($sql, $link);
return $result;
}
/////////////////////////////////////////////////////////////////////////////////////////////

function borrarSubGrupo($IdSubGrupo,$IdGrupos)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link);

$sql = "delete from videosvistos
	    where Idvideo in(select Idvideo from videos where IdSubGrupo = $IdSubGrupo)";
mysql_query($sql) or die('Invalid query: ' . mysql_error().' '.$sql);

$sql = "delete from videos where IdSubGrupo = $IdSubGrupo";
mysql_query($sql) or die('Invalid query: ' . mysql_error().' '.$sql);

$sql = "DELETE FROM  subgrupos where IdSubGrupo=$IdSubGrupo and IdGrupos = $IdGrupos";
$result = mysql_query($sql, $link);
return $result;
}
//////////////////////////////////////////////////////////////////////////////////////////////////
function consultarDetalleModulo($IdModulo)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link); 
$sql = "SELECT * FROM  modulos where IdModulo=".$IdModulo;
$result = mysql_query($sql, $link);
return $result;
}

//////////////////////////////////////////////////////////////////////////////////////////////////
function consultarHistorialUsuario($IdUsuario,$fdesde,$fhasta)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link); 

if($fdesde == '' or $fhasta == '')
$sql = "select * from resultadoexamen ,modulos
        where modulos.IdModulo=resultadoexamen.IdModulo
        and IdUsuario=".$IdUsuario." order by resultadoexamen.IdModulo ";
else{

$fdesde=$fdesde.' 00:00:00';
$fhasta=$fhasta.' 00:00:00';

$sql = "select * from resultadoexamen ,modulos
        where modulos.IdModulo=resultadoexamen.IdModulo
        AND fecha BETWEEN '$fdesde' AND '$fhasta'

        and IdUsuario=".$IdUsuario." order by resultadoexamen.IdModulo ";
  
}

$result = mysql_query($sql, $link);
return $result;
}

//////////////////////////////////////////////////////////////////////////////////////////////////
function respuestaValida($IdRespuesta)
{
$valido=0;
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]); 
mysql_select_db($_SESSION["basededatos"], $link); 
$sql="SELECT * FROM respuesta WHERE IdRespuesta=".$IdRespuesta." and  Correcta=1 ";
$result = mysql_query($sql, $link);

while ($row = mysql_fetch_array($result))
	 {
		$valido=1;
	 }
return $valido;
}

function NotaPreText($IdModulo,$IdUsuario)
{

$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]); 
mysql_select_db($_SESSION["basededatos"], $link); 
$sql="SELECT * FROM resultadoexamen WHERE IdModo=1 and IdModulo=".$IdModulo." and IdUsuario=".$IdUsuario;
$result = mysql_query($sql, $link);
$row = mysql_fetch_array($result);
return $row["NotaObtenida"];

}
/////////////////////////////////////////////////////////////////////////////////////////////



function consultarEstadoPasoUser($IdModo,$IdUsuario,$IdModulo)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link); 
$sql = "SELECT 
  resultadoexamen.IdResultado,
  resultadoexamen.IdUsuario,
  resultadoexamen.IdModulo,
  resultadoexamen.NotaObtenida,
  resultadoexamen.Fecha,
  resultadoexamen.NotaBase,
  resultadoexamen.IdModo,
  resultadoexamen.NotaMinima,
  resultadoexamen.VistoPresentacion,
  resultadoexamen.VistoJuego,
  resultadoexamen.VistoJuego2
FROM
  resultadoexamen
WHERE
  resultadoexamen.IdModo = $IdModo  AND 
  resultadoexamen.IdUsuario = $IdUsuario AND 
  resultadoexamen.IdModulo = $IdModulo ";
$result = mysql_query($sql, $link);
return $result;
}


//////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////
function aproboTaller($IdTaller,$IdUsuario)
{
$valido=0;
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]); 
mysql_select_db($_SESSION["basededatos"], $link); 
$sql="SELECT 
  resultadoexamen.IdUsuario,
  resultadoexamen.IdModulo,
  resultadoexamen.NotaObtenida,
  resultadoexamen.Fecha,
  resultadoexamen.NotaBase,
  resultadoexamen.IdModo,
  resultadoexamen.NotaMinima,
  modulos.Idtaller,
  modulos.Presentacion
FROM
  taller
  INNER JOIN modulos ON (taller.Idtaller = modulos.Idtaller)
  INNER JOIN resultadoexamen ON (modulos.IdModulo = resultadoexamen.IdModulo)
WHERE
  NotaObtenida >= NotaMinima AND 
  resultadoexamen.IdModo = 2 AND 
  resultadoexamen.IdUsuario = '".$IdUsuario."' and
  modulos.Idtaller='".$IdTaller."'";
$result = mysql_query($sql, $link);
while ($row = mysql_fetch_array($result))
	 {
		$valido=1;
	 }
return $valido;
}
////////////////////////////////////////////
/////////////////////////////////////////////
function validapasoaposttest($IdUsuario,$Titulo){
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]); 
mysql_select_db($_SESSION["basededatos"], $link); 
$sql="SELECT * FROM  resultadoexamen,  modo,  modulos,  taller
WHERE
  taller.IdTaller = modulos.IdTaller AND 
  modulos.IdModulo = resultadoexamen.IdModulo AND 
  modo.IdModo = resultadoexamen.IdModo AND 
  IdUsuario = $IdUsuario AND 
  Titulo = '$Titulo' AND 
  detalleModo = 'PostTest'        and
  notaobtenida>notaminima
ORDER BY
  resultadoexamen.IdModulo,
  modo.IdModo";
$result = mysql_query($sql);
$row=mysql_fetch_assoc($result);
$total= mysql_num_rows($result);
return $total;
}


}
?>

