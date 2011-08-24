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
            <input type="hidden" name="ingresar" value="1">
            <br>
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
                <tr>
                  <td>
                    <div align="left">
                      <input type="image" src="imagenes/ingresar.png" align="left">
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>
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