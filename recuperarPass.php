<?php
include("includes/connection.php");

$link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
mysql_select_db($_SESSION["basededatos"], $link); 

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

if (isset($_POST['mail'])) {
  $colname_rsPass = $_POST['mail'];

  $query_rsPass = sprintf("SELECT * FROM usuarios WHERE Correo = %s", GetSQLValueString($colname_rsPass, "text"));
  $rsPass = mysql_query($query_rsPass) or die(mysql_error());
  $row_rsPass = mysql_fetch_assoc($rsPass);
  $totalRows_rsPass = mysql_num_rows($rsPass);
  $mensaje="";
  
  $email = $row_rsPass['Correo'].
  $subject = "Servicio de envio de password";
  $message = "Su usuario es: ".$row_rsPass['Usuario'].", Su password es: ".$row_rsPass['Password'];
  
  mail($email,$subject,$message);
  
//  if (mail($email,$subject,$message))
//  {
//	$mensaje = "mensaje enviado a $email.";
//  }
//  else
//  {
//	$mensaje = "Error - mensaje no enviado.";
//  }

}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>nucomm.tv</title>
    <script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
    <link href="galeria/css/galeria.css" rel="stylesheet" type="text/css">
    <link href="../consultortic/css/INDEX.CSS" rel="stylesheet" type="text/css">
    <style type="text/css">
    body {
	  background-color: #000000;
    }
    span{
      color:#FFFFFF;
    }
    a:visited{
      text-decoration:none;
      color:#FFFFFF;
    }
    a:hover{
      text-decoration:none;
      color:#FFFFFF;
    }
    a:link{
      text-decoration:none;
      color:#FFFFFF;
    }
    </style>
  </head>
  <body>
  <table width="840" border="0" align="center" cellpadding="0" class="stepactive">
  <tr>
    <th colspan="3" scope="col"><img src="imagenes/top.jpg" width="1024" height="176"></th>
  </tr>
  <tr>
    <th width="24" scope="col">&nbsp;</th>
    <th width="782" scope="col">&nbsp;</th>
    <th width="30" scope="col">&nbsp;</th>
  </tr>
  <tr>
    <th scope="col">&nbsp;</th>
    <th scope="col"><p>&nbsp;</p>
    <p>
    <?php
    if($mensaje=="")
    {
      ?></p>
      <form name="form1" method="post" action="">
        <label><span class="stepinactive">Ingrese el e-mail registrado y luego haga click en enviar. A su e-mail llegar&aacute; el password registrado.<br>
        </span><br>
        <input name="mail" type="text" class="tahoma_11" id="mail">
        </label> 
        <label>
	<input name="aceptar" type="submit" class="tahoma_11" id="aceptar" value="Enviar">
	</label>
      </form>
    <p>
      <?php
	}
	else
	{
	  ?>
	  <label><span class="stepinactive">
	    <?=$mensaje;?>
	  </span></label>
	  <?
	  }
	?>

    </p>
    <p class="tahomaLight"><a href="index.php" class="stepinactive">Volver</a> </p></th>
    <th scope="col">&nbsp;</th>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#000000">&nbsp;</td>
    <td bgcolor="#000000"><div align="center"><span class="rights">Todos los derechos reservados. &copy; nucomm.tv, 2010</span></div></td>
    <td bgcolor="#000000">&nbsp;</td>
  </tr>
</table>
</body>
</html>
<?php
@mysql_free_result($rsPass);
?>
