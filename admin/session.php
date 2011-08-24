<?php

//ini_set('display_errors',1);
//error_reporting(E_ALL);

session_start();

if($_SESSION["usuario"]=="")
{
    if (!headers_sent())
    {
        header("Location: ../index.php");
    }
    else
    {
        echo "<meta http-equiv=\"refresh\" content=\"0;url=../index.php\">\r\n";
    }
}



include("../conexion.php");

include("../clases/clsusuario.php");
include("../clases/clsSubGrupo.php");
include("../clases/clsPermisos.php");
include("../clases/clsVideos.php");
include("../clases/clsexamen.php");