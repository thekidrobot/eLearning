<?
class clsVideos
{
//////////////////////////////////////////////////////////////////////////////////////////////////
function ingresarVideos($UrlVideo,$estado,$IdSubGrupo,$fecha,$visita,$nombre,$DescVideo,$PresVideo,$DurVideo,$OrdVideo)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link); 
$sql="insert into videos
       (UrlVideo, estado, IdSubGrupo,fecha,visita,nombre,descripcion,duracion,presentador,orden)
      values
       ('$UrlVideo','$estado','$IdSubGrupo','$fecha','$visita','$nombre','$DescVideo','$DurVideo','$PresVideo',$OrdVideo)";
$result = mysql_query($sql);
}
//////////////////////////////////////////////////////////////////////////////////////////////////
function borrarVideos($Idvideo)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link); 
$sql="delete from videos where Idvideo = $Idvideo";
$result = mysql_query($sql);
}
//////////////////////////////////////////////////////////////////////////////////////////////////
function ConsultarVideos($IdSubGrupo)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link); 
$sql="select * from videos WHERE IdSubGrupo=$IdSubGrupo order by orden";
return $result = mysql_query($sql);
}
//////////////////////////////////////////////////////////////////////////////////////////////////
function ConsultarVideosActivos($IdSubGrupo)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link); 
$sql="select * from videos WHERE IdSubGrupo=$IdSubGrupo AND estado=1";
return $result = mysql_query($sql);
}
//////////////////////////////////////////////////////////////////////////////////////////////////
function ConsultarVideo($Idvideo)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link); 
$sql="select * from videos WHERE Idvideo=$Idvideo";
return $result = mysql_query($sql);
}

function ConsultarMaterialApoyo($Idvideo)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link); 
$sql="select * from archivos_videos WHERE Idvideo=$Idvideo";
return $result = mysql_query($sql);
}

//////////////////////////////////////////////////////////////////////////////////////////////////
function actualizarVideo($Idvideo,$UrlVideo,$estado,$fecha,$visita,$nombre,$DescVideo,$PresVideo,$DurVideo,$OrdVideo)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link); 
$sql="update videos set estado='$estado',
                        UrlVideo='$UrlVideo',
                        fecha='$fecha',
                        visita='$visita',
                        nombre='$nombre',
                        duracion='$DurVideo',
                        descripcion='$DescVideo',
                        presentador='$PresVideo',
                        orden = $OrdVideo
                        WHERE  Idvideo=".$Idvideo;
$result = mysql_query($sql);
}
//////////////////////////////////////////////////////////////////////////////////////////////////

///videos grupos

//////////////////////////////////////////////////////////////////////////////////////////////////
function ingresarVideosGrupos($UrlVideo,$estado,$IdGrupos,$fecha,$visita,$nombre,$DescVideo,$PresVideo,$DurVideo,$OrdVideo)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link); 
$sql="insert into videos
      (UrlVideo, estado, IdGrupos,fecha,visita,nombre,descripcion,duracion,presentador,orden)
      values
      ('$UrlVideo','$estado','$IdGrupos','$fecha','$visita','$nombre','$DescVideo','$DurVideo','$PresVideo',$OrdVideo)";
$result = mysql_query($sql);
}
//////////////////////////////////////////////////////////////////////////////////////////////////
function ConsultarVideosGrupos($IdGrupos)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link); 
$sql="select * from videos WHERE IdGrupos=$IdGrupos order by orden";
return $result = mysql_query($sql);
}
//////////////////////////////////////////////////////////////////////////////////////////////////
function ConsultarVideosGruposActivos($IdGrupos)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link); 
$sql="select * from videos WHERE IdGrupos=$IdGrupos AND estado=1 order by orden";
return $result = mysql_query($sql);
}
//////////////////////////////////////////////////////////////////////////////////////////////////

function InsertaVideosVistos($IdUsuario,$Idvideo)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link); 
$sql="INSERT INTO videosvistos (IdUsuario,Idvideo) VALUES ('$IdUsuario','$Idvideo')";
return $result = mysql_query($sql);
}

function ConsultaVideosVistos($IdUsuario,$Idvideo)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link); 
$sql="SELECT * FROM  videosvistos WHERE IdUsuario='$IdUsuario' AND Idvideo='$Idvideo'";
return $result = mysql_query($sql);
}

function HistorialVideosSubgrupo($fdesde,$fhasta)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link); 

$sql="SELECT 
            v.UrlVideo,v.nombre,v.estado,s.NombreSubGrupo,COUNT(vv.IdVideo) as totalvistas
         FROM
             videos v,
             subgrupos s,
             videosvistos vv
         
         WHERE 	v.Idvideo = vv.Idvideo
         AND  	v.IdSubGrupo = s.IdSubGrupo";
         
if($fdesde != '' and $fhasta != '')
$sql.= " AND 	vv.fecha BETWEEN '$fdesde' AND '$fhasta'";

$sql.= " GROUP BY vv.IdVideo";

return $result = mysql_query($sql);

}

function HistorialVideosSubgrupoUsuario($IdUsuario)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link); 

$sql="SELECT 
            v.UrlVideo,v.nombre,v.estado,s.NombreSubGrupo,COUNT(vv.IdVideo) as totalvistas
         FROM
             videos v,
             subgrupos s,
             videosvistos vv
         
         WHERE 	v.Idvideo = vv.Idvideo
         AND  	v.IdSubGrupo = s.IdSubGrupo
         AND    vv.IdUsuario = $IdUsuario
         GROUP BY vv.IdVideo";

return $result = mysql_query($sql);

}


function HistorialVideosGrupo($fdesde,$fhasta)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link); 

$sql="SELECT 
        v.UrlVideo,v.nombre,v.estado,g.grupos,COUNT(vv.IdVideo) AS totalvistas
     FROM
         videos v,
         grupos g,
         videosvistos vv
     
     WHERE 	v.Idvideo = vv.Idvideo
     AND	v.IdGrupos = g.IdGrupos";

if($fdesde != '' and $fhasta != '')
$sql.= " AND 	vv.fecha BETWEEN '$fdesde' AND '$fhasta'";     
     
$sql.= " GROUP BY vv.IdVideo";

return $result = mysql_query($sql);
}


function HistorialVideosGrupoUsuario($IdUsuario)
{
$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link); 

$sql="SELECT 
        v.UrlVideo,v.nombre,v.estado,g.grupos,COUNT(vv.IdVideo) AS totalvistas
     FROM
         videos v,
         grupos g,
         videosvistos vv
     
     WHERE 	v.Idvideo = vv.Idvideo
     AND	v.IdGrupos = g.IdGrupos
     AND    vv.IdUsuario = $IdUsuario
     GROUP BY vv.IdVideo";

return $result = mysql_query($sql);
}


}
?>