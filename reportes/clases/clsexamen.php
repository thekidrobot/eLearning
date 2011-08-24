<?
class clsexamen
{
/////////////////////////////////////////////////////////////////////////////////////////////
//GUARDA LA NOTA DEL EXAMEN PRESENTADO
function ingresarPuntosPrueba($Id,$IdExamen,$NotaObtenida,$NotaBase)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link); 

//redondear la nota
$NotaObtenida=round($NotaObtenida * 100) / 100;

$sql="insert into resultadoexamen (Id,IdExamen,NotaObtenida,NotaBase,Fecha) values (".$Id.",".$IdExamen.",".$NotaObtenida.",".$NotaBase.",'".date("y/m/d")."')";
$result = mysql_query($sql);
}
/////////////////////////////////////////////////////////////////////////////////////////////
function consultarDetalle($IdExamen)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link); 
$sql = "SELECT * FROM  examen WHERE IdExamen=".$IdExamen;
$result = mysql_query($sql, $link);
return $result;
}
/////////////////////////////////////////////////////////////////////////////////////////////
function consultarExamenes()
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link); 
$sql = "SELECT * FROM  examen ORDER BY IdExamen DESC ";
$result = mysql_query($sql, $link);
return $result;
}
/////////////////////////////////////////////////////////////////////////////////////////////
function consultarPreguntasExamen($IdExamen)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link); 
$sql = "SELECT * FROM  preguntas where IdExamen=".$IdExamen." ORDER BY IdPregunta DESC ";
$result = mysql_query($sql, $link);
return $result;
}
/////////////////////////////////////////////////////////////////////////////////////////////
function consultarTotalPreguntasExamen($IdExamen)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link); 
$sql = "SELECT * FROM  preguntas where IdExamen=".$IdExamen." ORDER BY IdPregunta DESC ";
$result = mysql_query($sql, $link);
$total=0;

while ($row = mysql_fetch_array($result))
 {
  $total++;
 }
 
return $total;
}
/////////////////////////////////////////////////////////////////////////////////////////////

function consultarDetallePregunta($IdPregunta)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link); 
$sql = "SELECT * FROM  preguntas where IdPregunta=".$IdPregunta;
$result = mysql_query($sql, $link);
return $result;
}
/////////////////////////////////////////////////////////////////////////////////////////////
function consultarDetalleRespuesta($IdRespuesta)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link); 
$sql = "SELECT * FROM  respuesta where IdRespuesta=".$IdRespuesta;
$result = mysql_query($sql, $link);
return $result;
}
/////////////////////////////////////////////////////////////////////////////////////////////

function consultarRespuestasPregunta($IdPregunta)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link); 
$sql = "SELECT * FROM  respuesta where IdPregunta=".$IdPregunta." order by IdRespuesta desc ";
$result = mysql_query($sql, $link);
return $result;
}
/////////////////////////////////////////////////////////////////////////////////////////////

function consultarHistorialExamen($Id,$IdExamen)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link); 
$sql = "SELECT * FROM  resultadoexamen where IdExamen=".$IdExamen." and Id=".$Id." order by IdResultado desc ";
$result = mysql_query($sql, $link);
return $result;
}
/////////////////////////////////////////////////////////////////////////////////////////////


function ingresar($Titulo,$Preguntas,$Calificacion)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link); 
$sql="insert into examen (Titulo,Preguntas,Calificacion) values ('".$Titulo."',".$Preguntas.",".$Calificacion.") ";
$result = mysql_query($sql);
}
/////////////////////////////////////////////////////////////////////////////////////////////
function actualizar($IdExamen,$Titulo,$Preguntas,$Calificacion)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link); 
$sql="update examen  set Titulo='".$Titulo."',Preguntas=".$Preguntas.",Calificacion=".$Calificacion." where IdExamen=".$IdExamen; 
$result = mysql_query($sql);
}
/////////////////////////////////////////////////////////////////////////////////////////////
function ingresarPregunta($IdExamen,$DetallePregunta)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link); 
$sql="insert into preguntas (IdExamen,DetallePregunta) values (".$IdExamen.",'".$DetallePregunta."') ";
$result = mysql_query($sql);
}
/////////////////////////////////////////////////////////////////////////////////////////////
function ingresarRespuesta($IdPregunta,$DetalleRespuesta,$Correcta)
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
/////////////////////////////////////////////////////////////////////////////////////////////
function actualizarRespuesta($IdRespuesta,$DetalleRespuesta,$Correcta)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link); 

if($Correcta=="1")
 {
 
 	//conseguir el id de la respuesta
	$sql = "SELECT * FROM  respuesta where IdRespuesta=".$IdRespuesta;
	$result = mysql_query($sql, $link);
	while ($row = mysql_fetch_array($result))
	 {
	  $IdPregunta=$row["IdPregunta"]; 
	 }
 
	$sql="update respuesta set Correcta=0 where IdPregunta=".$IdPregunta;
	$result = mysql_query($sql);
 }

$sql="update respuesta set DetalleRespuesta='".$DetalleRespuesta."',Correcta=".$Correcta." where IdRespuesta=".$IdRespuesta;
$result = mysql_query($sql);
}
/////////////////////////////////////////////////////////////////////////////////////////////

function actualizarPregunta($IdPregunta,$DetallePregunta)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link); 
$sql="update preguntas set DetallePregunta='".$DetallePregunta."' where IdPregunta=".$IdPregunta;
$result = mysql_query($sql);
}
/////////////////////////////////////////////////////////////////////////////////////////////

function borrarPregunta($IdPregunta)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link); 

$sql="delete from respuesta where IdPregunta=".$IdPregunta;
$result = mysql_query($sql);

$sql="delete from preguntas where IdPregunta=".$IdPregunta;
$result = mysql_query($sql);

}
/////////////////////////////////////////////////////////////////////////////////////////////
function borrarRespuseta($IdRespuesta)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link); 

$sql="delete from respuesta where IdRespuesta=".$IdRespuesta;
$result = mysql_query($sql);

}
/////////////////////////////////////////////////////////////////////////////////////////////


}
?>