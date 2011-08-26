<?php
	include("includes/connection.php");
	
	if (!function_exists("GetSQLValueString"))
	{
		function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
		{
			$theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
			$theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);
		
			switch ($theType)
			{
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

	if (isset($_POST['mail']))
	{
		$colname_rsPass = $_POST['mail'];
	
		$query_rsPass = sprintf("SELECT * FROM usuarios WHERE Correo = %s", GetSQLValueString($colname_rsPass, "text"));
		$rsPass = mysql_query($query_rsPass) or die(mysql_error());
		$row_rsPass = mysql_fetch_assoc($rsPass);
		$totalRows_rsPass = mysql_num_rows($rsPass);
	
		$email = $row_rsPass['Correo'].
		$subject = "Servicio de envio de password";
		$message = "Su usuario es: ".$row_rsPass['Usuario'].", Su password es: ".$row_rsPass['Password'];
  
		if (mail($email,$subject,$message))
		{
			$mensaje = "mensaje enviado a $email.";
		}
		else
		{
			$mensaje = "Error - mensaje no enviado.";
		}

}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head>
	  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title><?=$website_name?></title>
    <script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
    <link rel="stylesheet" href="css/style.css">
  </head>
	<body>
		<div id="header">
			<div id="logo">
				<h1><a href="#">Compromise </a></h1>
			</div>
		</div>
		<!-- end #header -->
		<div id="menu">
			<ul>
				<li class="first"><a href="index.php">Home</a></li>
			</ul>
		</div>
		<!-- end #menu -->
		<div id="wrapper">
			<div class="btm">
				<div id="page">
					<div id="content">
						<?php
							if($mensaje=="")
							{
								?>
								<form name="form1" method="post" action="<?=$_SERVER['PHP_SELF']?>">
									<label> Ingrese el e-mail registrado y luego haga click en enviar.
													A su e-mail llegar&aacute; el password registrado.<br><br>
										<input name="mail" type="text" id="mail">
									</label> 
									<label>
										<input name="aceptar" type="submit" id="aceptar" value="Enviar">
									</label>
								</form>
								<?php
							}
							else
							{
								?>
								<span><?=$mensaje;?></span>
								<?
							}
						?>
						<p><a href="index.php">Volver</a></p>
					</div>
				<!-- end #content -->
			<div style="clear: both;">&nbsp;</div>
		</div>
	<!-- end #page -->
</div>
</div>
	<div id="footer">
		<p>Copyright (c) 2008 Sitename.com. All rights reserved. Design by <a href="http://www.freecsstemplates.org/">Free CSS Templates</a>.</p>
	</div>
	<!-- end #footer -->
</body>
</html> 
<?php
	@mysql_free_result($rsPass);
?>
