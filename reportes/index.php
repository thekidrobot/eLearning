<?
include("includes/connection.php");
include("clases/clsusuario.php");

session_start();

//variables de acceso
$_SESSION["usuario"]="";		// almacena el usuario en sesion
$_SESSION["idusuario"]="";		// almacena el id del usuario en sesion

//objetos
$objUsuario=new clsusuario();
$msg="";

///ingresar al sistema
if($_POST["ingresar"]!="")
 {
   if($_POST["valorModo"]=="1")
    {
	   //administrador
	   $clave=$_POST["valorClave"];
	   $valido=$objUsuario->validacionAdministrador($_POST["valorLogin"],$clave);

	   if($valido!="0")
		{
		  //valido
		  $_SESSION["usuario"]=$_POST["valorLogin"];
		  $_SESSION["idusuario"]=$valido;
		  ?>
		  <script language="javascript">
		  document.location="admin/menuadmin.php";
		  </script>
		  <?
		}
	}
   else
    {
	   //usuario
	   $valido=$objUsuario->validacionUsuario($_POST["valorLogin"],$_POST["valorClave"]);

	   if($valido!="0")
		{
		  //valido
		  $_SESSION["usuario"]=$_POST["valorLogin"];
		  $_SESSION["idusuario"]=$valido;
		  ?>
		  <script language="javascript">
		  document.location="usexamen.php";
		  </script>
		  <?
		}
	}
    
	$msg="El usuario es invalido";
 }

?>
<html>
<head>
<title><?=$website_name ?></title>
<link rel="stylesheet" href="css/INDEX.CSS">
<script language="javascript" src="js.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
<!--
body {
	background-color: #050505;
}
-->
</style></head>
<body leftmargin="0" topmargin="0" background="" >
<br>
<table width="1024" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><img src="imagenes/top.jpg" width="1024" height="176"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><form name="formProceso" action="index.php" method="post" onSubmit="return validaAcceso()">
      <input type="hidden" name="ingresar" value="1">
      <br>
      <table width="363" height="203" border="0" align="center" bgcolor="#EEEEEE" class="bordes_gris">
        <tr>
          <td colspan="3" class="tahoma_11_center">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="3" class="tahoma_11_center">Administrador</td>
        </tr>
        <tr>
          <td colspan="3" class="text10">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="3" align="center" class="link10"><span class="text10"><img src="imagenes/usuarios_regis2.png" width="268" height="40"></span></td>
        </tr>
        <tr>
          <td class="link10">&nbsp;</td>
          <td class="text10">&nbsp;</td>
          <td class="body-text1">&nbsp;</td>
        </tr>
        <tr>
          <td width="81" class="link10">&nbsp;</td>
          <td width="39" class="tahoma_11_light"> Login </td>
          <td width="227" class="body-text1"><input type="text" name="valorLogin" maxlength="10" class="text10" style="width:150"></td>
        </tr>
        <tr>
          <td class="link10">&nbsp;</td>
          <td class="tahoma_11_light"> Clave </td>
          <td class="body-text1"><input type="password" name="valorClave" maxlength="10" class="text10" style="width:150"></td>
        </tr>
        <tr>
          <td class="link10">&nbsp;</td>
          <td class="tahoma_11_light"> Modo </td>
          <td class="text10"><select name="valorModo" class="tahoma_11_light" style="width:150">
<option value="1">Administrador</option>
          </select></td>
        </tr>
        <tr>
          <td rowspan="2" align="right" class="body-text1">&nbsp;</td>
          <td rowspan="2" align="right" class="body-text1"><br>
            <br>
            <br>
            <br>
            <br>
            <br></td>
          <td align="right" valign="top" class="text10"><div align="left">
            <p>
              <input type="image" src="imagenes/ingresar.png" align="left">
            </p>
          </div>
            <div align="left"></div></td>
        </tr>
        <tr>
          <td align="right" valign="top" class="text10"><div align="left"><span class="verdana_red">
            <?=$msg?>
          </span></div></td>
        </tr>
        <tr>
          <td colspan="3" align="center" class="tahoma_11">&nbsp;</td>
          </tr>
      </table>
    </form></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" bgcolor="#050505">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" bgcolor="#050505"><span class="rights">Todos los derechos reservados. &copy; nucomm.tv, 2010</span></td>
  </tr>
  <tr>
    <td bgcolor="#050505"><div align="center" class="stepactive"></div></td>
  </tr>
</table>
</body>
</html>
