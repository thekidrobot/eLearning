<?php

//ini_set('display_errors',1);
//error_reporting(E_ALL);
session_start();

include("general_functions.php");

include("../includes/connection.php");
include("../includes/formvalidator.php");

include("../clases/clsusuario.php");
include("../clases/clsSubGrupo.php");
include("../clases/clsPermisos.php");
include("../clases/clsVideos.php");
include("../clases/clsexamen.php");