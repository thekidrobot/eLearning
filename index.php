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

if(isset($_POST["Login"]))
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

      //I cannot use the function here. Requires validation first.
      $filename = 'admin/menuadmin.php';
      if (!headers_sent()) header('Location: '.$filename);
      else echo '<meta http-equiv="refresh" content="0;url='.$filename.'" />';
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
      $filename = 'usexamen.php';
      if (!headers_sent()) header('Location: '.$filename);
      else echo '<meta http-equiv="refresh" content="0;url='.$filename.'" />';
    }
  }
  $msg="El usuario es invalido";
}

?>
<html>
  <?php include("includes/head.php"); ?>
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
            <form name="formProceso" action="index.php" method="post" onSubmit="return validaAcceso()">
              <table>
                <tr>
                  <td>&nbsp;</td>
                  <td>Usuario</td>
                  <td><input type="text" name="valorLogin"></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td> Contrase&ntilde;a </td>
                  <td> <input type="password" name="valorClave"></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td> Modo </td>
                  <td><select name="valorModo">
                        <option value="2" selected>Usuario</option>
                        <option value="1">Administrador</option>
                      </select>
                  </td>
                </tr>
                <tr align="center">
                  <td colspan="3">
                    <input type="submit" value="Login" name="Login">
                  </td>
                </tr>
                <tr align="center">
                  <td colspan="3">
                    <span><?=$msg?></span></div>
                  </td>
                </tr>
                <tr>
                  <td colspan="3" align="center" class="tahoma_11">Aun no est&aacute; registrado?<a href="registro.php"> haga click ac&aacute;</a></td>
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