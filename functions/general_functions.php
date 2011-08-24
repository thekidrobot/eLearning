<?php
session_start();
include("includes/connection.php");

// Shows the name of the script in execution, used by menus and custom scripts
$file = $_SERVER["SCRIPT_NAME"];
$break = Explode('/', $file);
$curr_page = $break[count($break) - 1];

//Validate login
if($_SESSION["usuario"]=="")
{
 redirect('index.php'); 
}

$website_name = "My eLearning Site";

//Safely Redirects
function redirect($filename)
{
	if (!headers_sent()) header('Location: '.$filename);
	else echo '<meta http-equiv="refresh" content="0;url='.$filename.'" />';
}

?>