<?php require_once('Connections/cnx_local.php');
include("captcha/class/captchaZDR.php");

if (!isset($_SESSION)) {
  session_start();
}
?>
<?php
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
$activo = 1;
$capt = new captchaZDR;

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	if($capt->check_result())
	{ 
			$errrorCaptcha = "si";
			  $insertSQL = sprintf("INSERT INTO usuarios (Usuario, Password, NombreCompleto, Cedula, Correo) VALUES (%s, %s, %s, %s, %s)",
								   GetSQLValueString($_POST['login'], "text"),
								   GetSQLValueString($_POST['Password'], "text"),
								   GetSQLValueString($_POST['NombreCompleto'], "text"),
								   GetSQLValueString($_POST['Cedula'], "text"),
								   GetSQLValueString($_POST['Correo'], "text"));
			
			  mysql_select_db($database_cnx_local, $cnx_local);
			  $Result1 = mysql_query($insertSQL, $cnx_local) or die(header("Location: mensaje_error.php?mError=". mysql_error()));
			
			  $insertGoTo = "envio_mail.php";
			  if (isset($_SERVER['QUERY_STRING'])) {
				$insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
				$insertGoTo .= $_SERVER['QUERY_STRING'];
			  }
			  
			   //inserta el usuario en los grupos seleccionados 3 y 4 	  
			  $sql2="insert into permisos_usuarios (idUsuario,IdCategorias,IdGrupos) 
						values((select idUsuario from usuarios where Usuario = '" . $_POST['login'] . "'),12,12)";
			  $resultado = mysql_query($sql2, $cnx_local) or die(mysql_error());
			  
			  $sql2="insert into permisos_usuarios (idUsuario,IdCategorias,IdGrupos) 
						values((select idUsuario from usuarios where Usuario = '" . $_POST['login'] . "'),13,11)";
			  $resultado = mysql_query($sql2, $cnx_local) or die(mysql_error());
			  
			  //inserta el usuario en los grupos seleccionados 3 y 4 
			  /*$sql2="insert into grupos_usuario (idusuario,idgrupos,ramp_cant_descargas) 
						values((select idUsuario from usuarios where Usuario = '" . $_POST['Nombre'] . "'),4,50)";*/
						
			  $resultado = mysql_query($sql2, $cnx_local) or die(mysql_error());
			  
			  
			  header(sprintf("Location: %s", $insertGoTo));
	}
		else
		{
				$errrorCaptcha = "no";
		}
}
$destMail = "consultortic@nucomm.tv";
$correo = $_POST['Correo'];
$nombres = $_POST['NombreCompleto'];
$apellidos = $_POST['Cedula'];


////Contenido HTML
$contenido="<table width='591' height='170' border='1' cellpadding='0' bordercolor='#CCCCCC' bgcolor='#FFFFFF'>
  <tr>
    <th height='46' colspan='3' scope='col'><img src='http://www.nucomm.tv/consultortic/images/logo.jpg' width='464' height='60'></th>
  </tr>
  <tr>
    <td colspan='3' bordercolor='#CCCCCC'><div align='center'><strong>". $_POST['NombreCompleto'] ."<br>
      </strong>Gracias por registrarse en nuestro sistema.<br>
      Recuerde que para ingresar debe digitar: <A href='http://www.nucomm.tv/consultortic'>www.nucomm.tv/consultortic</A>.<br>
      <BR>
    </div></td>
  </tr>
  
  
  <tr>
    <td width='32' bordercolor='#CCCCCC'>&nbsp;</td>
    <td width='91' bordercolor='#CCCCCC' bgcolor='#EBE9ED'><strong>Su Usuario:</strong></td>
    <td width='452' bordercolor='#CCCCCC' bgcolor='#EBE9ED'>". $_POST['login'] ."</td>
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
</table>
";
$cabeceras = "Content-type: text/html\r\n";
mail($correo . "", "Registro ConsultorTIC",$contenido,$cabeceras);

//fin contenido Html
$header = "From: Admin ConsultorTIC";
$header = "Reply-To: Admin ConsultorTIC";
mail($destMail . "", "registro ConsultorTIC", "Nombres y Apellidos: " . $nombres . "\n" . "Correo: " . $correo, $header); 


?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>::::nucomm::::</title>
<style type="text/css">
<!--
.verdana {	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	font-style: normal;
	color: #000000;
}
.Estilo9 {color: #FF0000}
-->
</style>
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
	{//11
		a=document.getElementById('Correo')
		if(a.value=="")
		{
			alert("ingrese una dirección de correo válida");
			a.focus();
		}
		else
		{//9
				a=document.getElementById('Cedula')
				if(a.value=="")
				{
					alert("por favor ingrese el nombre de la empresa a la que pertenece");
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
				}//8
			}//9
	}//11
}//12

function validar()
{
	
	
}
function mirar()
{
	p=document.getElementById('login');
	if(p.value=='')
		alert('ingrese un nombre de usuario v&aacute;lido');
	else
	invocaGenericoPost("apodo","usrCompruebaApodo.php","Usuario="+p.value,"Comprobando disponibilidad...");
}

</script>
<script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
<link href="galeria/css/galeria.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	background-color: #FFF;
}
-->
</style></head>

<style type="text/css">
<!--
.Estilo1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
}
.Estilo3 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	line-height: normal;
}
.Estilo5 {font-size: 10px}
.bordes {
	border: 1px solid #CCCCCC;
}
.Estilo7 {font-size: 10px; font-weight: bold; }
.Estilo8 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; line-height: normal; font-weight: bold; }
.okUser {
	font-family: Arial, Helvetica, sans-serif;
	color: #FFF;
	background-color: #0C0;
	text-align: left;
}
.errUser {
	font-family: Arial, Helvetica, sans-serif;
	color: #FFF;
	background-color: #F00;
	text-align: left;
}
-->
</style>
<form id="form1" name="form1" method="post" action="<?php echo $editFormAction; ?>e&amp;VActivo=activo">
  <p></p>
  <table width="464" border="0" align="center" cellpadding="1" bgcolor="#FFFFFF" class="bordes">
    <tr>
      <th colspan="3" valign="middle" class="Estilo3" scope="col"><img src="imagenes/logo.jpg" width="316" height="105" /></th>
    </tr>
    <tr>
      <th valign="middle" class="Estilo3" scope="col">&nbsp;</th>
      <td colspan="2" scope="col"><div align="right"><a href="index.php" class="verdana">Volver a inicio</a></div></td>
    </tr>
    <tr>
      <th width="31%" valign="middle" class="Estilo3" scope="col"><div align="left"><strong><span class="Estilo5">Nombres y Apellidos</span></strong><span class="Estilo9">*</span></div></th>
      <th colspan="2" scope="col"><div align="left"><span class="Estilo3">
        <input name="NombreCompleto" type="text" class="Estilo3" id="NombreCompleto" value="<?php echo $_POST['NombreCompleto']; ?>" size="50" />
      </span></div></th>
    </tr>
    <tr>
      <th valign="middle" class="Estilo3" scope="col"><div align="left"><strong>E-mail </strong><span class="Estilo9">*</span></div></th>
      <th colspan="2" scope="col"><div align="left"><span class="Estilo3">
          <input name="Correo" type="text" class="Estilo3" id="Correo" value="<?php echo $_POST['Correo']; ?>" size="50" />
      </span></div></th>
    </tr>
    <tr>
      <th height="19" valign="middle" class="Estilo3" scope="col"><div align="left">Empresa<span class="Estilo9">*</span></div></th>
      <th colspan="2" scope="col"><div align="left">
          <input name="Cedula" type="text" class="Estilo3" id="Cedula" size="50" value="<?php echo $_POST['Cedula']; ?>"/>
      </div></th>
    </tr>
    <tr>
      <th valign="top" class="Estilo3" scope="col"><div align="left" class="Estilo7">Usuario<span class="Estilo9">*</span></div></th>
      <th colspan="2" valign="top" scope="col"><div align="left"><span class="Estilo3">
          <input name="login" type="text" class="Estilo3" id="login" value="<?php echo $_POST['login']; ?>" />
          </span>
              <label>
              <input name="comprobar" type="button" class="Estilo3" id="comprobar" value="comprobar diponibilidad" onclick="javascript:mirar();" />
              </label>
        </div>
          <div id="apodo" align="left">&nbsp;</div></th>
    </tr>
    <tr>
      <th valign="top" class="Estilo3" scope="col"><div align="left"><strong>Contrase&ntilde;a </strong><span class="Estilo9">*</span></div></th>
      <th colspan="2" valign="top" scope="col"><div align="left"><span class="Estilo3">
        <input name="Password" type="password" class="Estilo3" id="Password" value="<?php echo $_POST['Password']; ?>" />
      </span></div></th>
    </tr>
    <tr>
      <th valign="middle" class="Estilo3" scope="col">&nbsp;</th>
      <th colspan="2" scope="col"><img src="captcha/captcha_img.php" align="left" /></th>
    </tr>
    <tr>
      <th colspan="3" valign="top" class="Estilo3" scope="col">Ingrese el resultado o las palabras del cuadro de imagen</th>
    </tr>
    <tr>
      <th valign="top" class="Estilo3" scope="col"><div align="left"></div></th>
      <th colspan="2" scope="col" align="left"><input name="capt" type="text" id="capt" style="width: 80px" />
          <div align="left">
            <?php
if(!extension_loaded('gd')) echo '<div style="color: red">GD extension is not Loaded!<br /> Please load GD extension in your <b>php.ini</b> file.</div><br />';
?>
            <span class="errUser">
            <?php if($errrorCaptcha =="no"){echo "No coincide el codigo con lo descrito en la imagen";}?>
        </div></th>
    </tr>
    <tr>
      <td colspan="3" valign="middle" class="Estilo8">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" valign="middle" class="Estilo8"><div align="left" class="verdana">
          <input name="activo" type="checkbox" id="activo" value="1" />
        Acepto pol&iacute;ticas de uso</div>
          <span class="Estilo3">
          <label></label>
        </span></td>
      <td width="43%" valign="bottom" class="Estilo3">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3" valign="middle" class="Estilo8"><span class="Estilo3"><span class="Estilo1">
        <input name="enviar" type="button" class="Estilo3" id="enviar" onclick="acepta();" value="enviar" />
        <a href="../index.html">
         <div align="right"></div>
            <p class="Estilo3"><span class="Estilo1"><label></label>
              </span>
                <label class="Estilo3"></label><input type="hidden" name="MM_insert" value="form1" />
          </p>
        <?php
?>
      </a></span></span></td>
    </tr>
    <tr>
      <td colspan="3" valign="middle" bgcolor="#EBE9ED" class="Estilo3"><a href="index.html"></a></td>
    </tr>
    <tr>
      <td colspan="3" valign="middle" bgcolor="#EBE9ED" class="Estilo8"><div align="center" class="Estilo5">Powered By Nucomm&reg; </div></td>
    </tr>
  </table>
  <p>&nbsp;  </p>
</form>
<p>&nbsp;</p>
<p>&nbsp;</p>

