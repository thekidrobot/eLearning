<?php
include("includes/connection.php");
include("includes/formvalidator.php");

include("clases/clsusuario.php");
$objUsuario=new clsusuario();

session_start();

//Safely Redirects
function redirect($filename)
{
	if (!headers_sent()) header('Location: '.$filename);
	else echo '<meta http-equiv="refresh" content="0;url='.$filename.'" />';
}

//Safely escape values. Please use in your SQL queries. 
function escape_value($value)
{
	$value = trim($value);
	
  if(function_exists('mysql_real_escape_string'))
  {
    if(get_magic_quotes_gpc())
    { 
      $value = stripslashes($value); 
		}
		$value = mysql_real_escape_string($value);
	}
  else
  {
    if(!get_magic_quotes_gpc())
    { 
      $value = addslashes($value); 
    }
  }
  return $value;
}

//Random Password Generator
function genRandomString()
{
    $length = 12;
    $characters = "0123456789abcdefghijklmnopqrstuvwxyz";
    $string = '';    

    for ($p = 0; $p < $length; $p++) {
        $string .= $characters[mt_rand(0, strlen($characters))];
    }
    return $string;
}

?>