<?php
	include("functions/login_functions.php");

	if (isset($_POST['mail']))
	{
		if(!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL))
		{
			$mensaje = "Invalid Mail Format.";
		}
		else
		{
			$rsPass = $objUsuario->consultarDetalleUsuariosPorNombre(escape_value($_POST['mail']));
			$row_rsPass = mysql_fetch_array($rsPass);
			$totalRows_rsPass = mysql_num_rows($rsPass);
		
			if($totalRows_rsPass > 0)
			{
				$new_pass = genRandomString();
				
				$objUsuario->actualizarDatosUsuario(md5($new_pass),$row_rsPass['NombreCompleto'],$row_rsPass['Empresa'],$row_rsPass['Correo']);
	
				$email_admin = "noreply@nucomm.tv";
				
				$headers='Content-type: text/html; charset=iso-8859-1'."\r\n";
				$headers.='From:'. $email_admin ."\r\n";
			
				$email = trim($row_rsPass['Correo']);
				$subject = "Your new Password";
				$message = "<p>Dear User: <br /><br />Your new password is $new_pass </p>";
				
				if (mail($email,$subject,$message,$headers))
				{
					$mensaje = "Your user data has been sent to $email.";
				}
				else
				{
					$mensaje = "Error - Message not sent.";
				}	
			}
			else
			{
				$mensaje = "The given mail is not registered. <a href='registro.php'>Register</a>";
			}	
		}
	}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head>
	  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title><?=$website_name?></title>
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
									<label> Type your registered email address, and we will send a new password there.<br><br>
										<input name="mail" type="text" id="mail" maxlength="150">
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
						<p><a href="index.php">Back to main page</a></p>
					</div>
				<!-- end #content -->
			<div style="clear: both;">&nbsp;</div>
		</div>
	<!-- end #page -->
</div>
</div>
	<?php include("includes/footer.php"); ?>
</body>
</html>