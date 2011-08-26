<?php 
	include("includes/connection.php");
	include("captcha/class/captchaZDR.php");

	if (!isset($_SESSION))
	{
		session_start();
	}

	if (!function_exists("GetSQLValueString"))
	{
		function GetSQLValueString($tdeValue, $tdeType, $tdeDefinedValue = "", $tdeNotDefinedValue = "") 
		{
			$tdeValue = get_magic_quotes_gpc() ? stripslashes($tdeValue) : $tdeValue;
			$tdeValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($tdeValue) : mysql_escape_string($tdeValue);
		
			switch ($tdeType)
			{
				case "text":
					$tdeValue = ($tdeValue != "") ? "'" . $tdeValue . "'" : "NULL";
					break;    
				case "long":
				case "int":
					$tdeValue = ($tdeValue != "") ? intval($tdeValue) : "NULL";
					break;
				case "double":
					$tdeValue = ($tdeValue != "") ? "'" . doubleval($tdeValue) . "'" : "NULL";
					break;
				case "date":
					$tdeValue = ($tdeValue != "") ? "'" . $tdeValue . "'" : "NULL";
					break;
				case "defined":
					$tdeValue = ($tdeValue != "") ? $tdeDefinedValue : $tdeNotDefinedValue;
					break;
			}
			return $tdeValue;
		}
	}

	$editFormAction = $_SERVER['PHP_SELF'];
	if (isset($_SERVER['QUERY_STRING']))
	{
		$editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
	}
	$activo = 1;
	$capt = new captchaZDR;
	
	if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1"))
	{
		if($capt->check_result())
		{ 
			$errrorCaptcha = "si";
				
			if(!filter_var($_POST['login'], FILTER_VALIDATE_EMAIL))
			{
				?>
				<script type="text/javascript">
					alert('Formato de correo no valido');
				</script>
				<?php
			}
			else
			{
				
				$insertSQL = sprintf("INSERT INTO usuarios (Usuario, Password, NombreCompleto, Cedula, Pais, Ciudad, Correo) VALUES (%s, %s, %s, %s, %s, %s ,%s)",
										GetSQLValueString($_POST['login'], "text"),
										GetSQLValueString($_POST['Password'], "text"),
										GetSQLValueString($_POST['NombreCompleto'], "text"),
										GetSQLValueString($_POST['Cedula'], "text"),
										GetSQLValueString($_POST['Pais'], "text"),
										GetSQLValueString($_POST['Ciudad'], "text"),
										GetSQLValueString($_POST['login'], "text"));
				
				$Result1 = mysql_query($insertSQL) or die(header("Location: mensaje_error.php?mError=". mysql_error()));
				
				$insertGoTo = "envio_mail.php";
				if (isset($_SERVER['QUERY_STRING']))
				{
					$insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
					$insertGoTo .= $_SERVER['QUERY_STRING'];
				}
					
				//inserta el usuario en los grupos seleccionados 3 y 4 	  
				$sql2=	"insert into permisos_usuarios (idUsuario,IdCategorias,IdGrupos) 
								values((select idUsuario from usuarios where Usuario = '" . $_POST['login'] . "'),12,12)";
				$resultado = mysql_query($sql2, $cnx_local) or die(mysql_error());
				
				$sql2=	"insert into permisos_usuarios (idUsuario,IdCategorias,IdGrupos) 
								values((select idUsuario from usuarios where Usuario = '" . $_POST['login'] . "'),13,11)";
				$resultado = mysql_query($sql2, $cnx_local) or die(mysql_error());
				
				$sql2=	"insert into permisos_usuarios (idUsuario,IdCategorias,IdGrupos) 
								values((select idUsuario from usuarios where Usuario = '" . $_POST['login'] . "'),21,13)";
				$resultado = mysql_query($sql2, $cnx_local) or die(mysql_error());

									
				$resultado = mysql_query($sql2, $cnx_local) or die(mysql_error());
					
				header(sprintf("Location: %s", $insertGoTo));
		
				$destMail = "consultortic@nucomm.tv";
				$correo = $_POST['Correo'];
				$nombres = $_POST['NombreCompleto'];
				$apellidos = $_POST['Cedula'];
					
					////Contenido HTML
					$contenido="
						<table widtd='591' height='170' border='1' cellpadding='0' bordercolor='#CCCCCC' bgcolor='#FFFFFF'>
						<tr>
							<td height='46' colspan='3' scope='col'><img src='http://www.nucomm.tv/consultortic/images/logo.jpg' widtd='464' height='60'></td>
						</tr>
						<tr>
							<td colspan='3' bordercolor='#CCCCCC'><div align='center'><strong>". $_POST['NombreCompleto'] ."<br>
								</strong>Gracias por registrarse en nuestro sistema.<br>
								Recuerde que para ingresar debe digitar: <A href='http://www.nucomm.tv/consultortic'>www.nucomm.tv/consultortic</A>.<br>
								<BR>
							</div></td>
						</tr>
						
						<tr>
							<td widtd='32' bordercolor='#CCCCCC'>&nbsp;</td>
							<td widtd='91' bordercolor='#CCCCCC' bgcolor='#EBE9ED'><strong>Su Usuario:</strong></td>
							<td widtd='452' bordercolor='#CCCCCC' bgcolor='#EBE9ED'>". $_POST['login'] ."</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td bgcolor='#EBE9ED'><strong>Su clave es:</strong></td>
							<td bgcolor='#EBE9ED'>". $_POST['Password'] ."</td>
						</tr>
						<tr>
							<td colspan='3'><div align='center'><strong><br></strong><br>
								<br>
							</div></td>
						</tr>
						<tr>
							<td colspan='3' bgcolor='#EBE9ED'>&nbsp;</td>
						</tr>
						</table>";
					$cabeceras = "Content-type: text/html\r\n";
					mail($correo . "", "Registro ConsultorTIC",$contenido,$cabeceras);
					
					//fin contenido Html
					$header = "From: Admin ConsultorTIC";
					$header = "Reply-To: Admin ConsultorTIC";
					mail($destMail . "", "registro ConsultorTIC", "Nombres y Apellidos: " . $nombres . "\n" . "Correo: " . $correo, $header); 
			}
		}
		else
		{
			$errrorCaptcha = "no";
		}
	}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title><?=$website_name?></title>
	<script type="text/javascript" src="ajax/core.js"></script>
	<script type="text/javascript">
		function acepta()
		{//12
			var a;
			a=document.getElementById('NombreCompleto')
			if(a.value=="")
			{
				alert("ingrese el nombre");
				a.focus();
			}
			else
			{
				//11
				//a=document.getElementById('Correo')
				//if(a.value=="")
				//{
				//	alert("ingrese una dirección de correo válida");
				//	a.focus();
				//}
				//else
				//{//9
					a=document.getElementById('Cedula')
					if(a.value=="")
					{
						alert("por favor ingrese el nombre de la empresa a la que pertenece");
						a.focus();
					}
					else
					{//4
						a=document.getElementById('Pais')
						if(a.value=="--")
						{
							alert("seleccione su país");
							a.focus();
						}
						else
						{//2a
							a=document.getElementById('Ciudad')
							if(a.value=="")
							{
								alert("escriba su ciudad");
								a.focus();
							}
							else
							{//8
								a=document.getElementById('login')
								if(a.value=="")
								{
									alert("escriba un nombre de usuario");
									a.focus();
								}
								else
								{//2
									a=document.getElementById('Password')
									if(a.value=="")
									{
										alert("escriba una clave que recuerde fácilmente");
										a.focus();
									}
									else
									{//1
										a = document.getElementById('activo');
										if(a.checked==true)
										{
											// alert("bien");
											document.form1.submit();
											a.focus();
										}
										else
										{
											alert("debe aceptar las políticas de uso de Consultor TIC");
											a.focus();
										}												
									}//1
								}//2
							}//1
						}//8
					}//9
			//}//9
			}//11
		}//12
		
		function validar(){ }
	
		function mirar()
		{
			p=document.getElementById('login');
			if(p.value=='') alert('ingrese un nombre de usuario v&aacute;lido');
			else invocaGenericoPost("apodo","usrCompruebaApodo.php","Usuario="+p.value,"Comprobando disponibilidad...");
		}
	</script>
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
						<form id="form1" name="form1" metdod="post" action="<?php echo $editFormAction; ?>e&amp;VActivo=activo">
							<table>
								<tr>
									<td>Nombres y Apellidos<span>*</span></div></td>
									<td><input name="NombreCompleto" type="text" id="NombreCompleto" value="<?php echo $_POST['NombreCompleto']; ?>" /></td>
								</tr>
								<!--<tr>-->
								<!--  <td valign="middle"><strong>E-mail </strong><span>*</span></div></td>-->
								<!--  <td colspan="2">-->
								<!--      <input name="Correo" type="text" id="Correo" value="<?php echo $_POST['Correo']; ?>" />-->
								<!--  </span></div></td>-->
								<!--</tr>-->
								<tr>
									<td>Empresa<span>*</span></div></td>
									<td colspan="2">
										<input name="Cedula" type="text" id="Cedula" value="<?php echo $_POST['Cedula']; ?>"/>
									</td>
								</tr>
								<tr>
									<td><strong>Pa&iacute;s<span>*</span></strong></td>
									<td colspan="2">
										<select name="Pais" id="Pais">
											<option value="--" selected="selected">Seleccione uno</option>
											<option value="Argentina">Argentina</option>
											<option value="Bolivia">Bolivia</option>
											<option value="Brasil">Brasil</option>
											<option value="Colombia">Colombia</option>
											<option value="Costa Rica">Costa Rica</option>
											<option value="Chile">Chile</option>
											<option value="Ecuador">Ecuador</option>
											<option value="Estados Unidos">Estados Unidos</option>
											<option value="El Salvador">El Salvador</option>
											<option value="Guatemala">Guatemala</option>
											<option value="Honduras">Honduras</option>
											<option value="Nicaragua">Nicaragua</option>
											<option value="Mexico">Mexico</option>
											<option value="Panama">Panama</option>
											<option value="Paraguay">Paraguay</option>
											<option value="Peru">Peru</option>
											<option value="Puerto Rico">Puerto Rico</option>
											<option value="Republica dominicana">Republica dominicana</option>
											<option value="Uruguay">Uruguay</option>
											<option value="Venezuela">Venezuela</option>
										</select>
									</td>
								</tr>
								<tr>
									<td><strong>Ciudad<span>*</span></strong></td>
									<td colspan="2">
										<input name="Ciudad" type="text" id="Ciudad" value="<?php echo $_POST['Ciudad']; ?>" />
									</td>
								</tr>
								<tr>
									<td>Email - Usuario<span>*</span></td>
									<td colspan="2">
										<input name="login" type="text" id="login" value="<?php echo $_POST['login']; ?>" />
										<label>
											<input name="comprobar" type="button" id="comprobar" value="comprobar diponibilidad" onclick="javascript:mirar();" />
										</label>
										<div id="apodo" align="left">&nbsp;</div>
									</td>
								</tr>
								<tr>
									<td><strong>Contrase&ntilde;a </strong><span>*</span></div></td>
									<td colspan="2">
										<input name="Password" type="password" id="Password" value="<?php echo $_POST['Password']; ?>" />
									</td>
								</tr>
								<tr>
									<td valign="middle">&nbsp;</td>
									<td colspan="2"><img src="captcha/captcha_img.php" align="left" /></td>
								</tr>
								<tr>
									<td colspan="3">Ingrese el resultado o las palabras del cuadro de imagen</td>
								</tr>
								<tr>
									<td colspan="2" align="left">
										<input name="capt" type="text" id="capt" style="widtd: 80px" />
										<?php
											if(!extension_loaded('gd'))
											echo '<div style="color: red">GD extension is not Loaded!<br /> Please load GD extension in your <b>php.ini</b> file.</div><br />';
										?>
										<span class="errUser">
										<?php if($errrorCaptcha =="no"){echo "No coincide el codigo con lo descrito en la imagen";}?>
									</td>
								</tr>
								<tr>
									<td colspan="3">
										<input name="activo" type="checkbox" id="activo" value="1" />Acepto pol&iacute;ticas de uso
									</td>
								</tr>
								<tr>
									<td colspan="3">
										<input name="enviar" type="button" id="enviar" onclick="acepta();" value="enviar" />
										<input type="hidden" name="MM_insert" value="form1" />
										</span></span>
									</td>
								</tr>
							</table>
						</form>
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