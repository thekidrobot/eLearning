<?
include("../conexion.php");
include("../clases/clsusuario.php");

session_start();

//validar sesion
if($_SESSION["usuario"]=="")
 {
  ?>
  <script language="javascript">
  document.location="inicio.html";
  </script>
  <?
 }

///objetos
$objUsuario=new clsusuario();
$msg="";

///actualizar clave
if($_POST["ingresar"]!="")
 {
    $clave=$_POST["valorClave"];
    $objUsuario->actualizarClave($_SESSION["usuario"],$clave);
    $msg="Clave actualizada";
 }
?>
<html>
<head>
<title>:: CUESTIONARIO ::</title>
<link rel="stylesheet" href="../css/INDEX.CSS">
<script language="javascript" src="../js/js.js">
</script>
</head>
<body leftmargin="0" topmargin="0" background="" > 
<table width="800" height="100%" align="center" cellpadding="0" cellspacing="0">

 <tr>
  <td width="104"><img src="../imagenes/spacer.gif" width="1" height="1"></td>
  <td width="751" bgcolor="white" valign="top">
    <table width="100%" height="100%" cellpadding="0" cellspacing="0">
      <!-- banner superior -->
      <!-- menu superior -->
      <tr>
        <td class="body-text1"  height="20" align="right"> 
          <table width="100%" cellpadding="0" cellspacing="0">
            <tr>
              <td width="10"><img src="../imagenes/spacer.gif" width="1" height="1"></td>	   
              <td align="left">
                </td>
              <td class="body-text1" width="220">
                </td>
              <td width="10"><img src="../imagenes/spacer.gif" width="1" height="1"></td>
              </tr>
            </table>
          </td>
        </tr>
      
      
      <!-- zona central -->
      <tr>
        <td class="body-text1" valign="top">
          <table cellpadding="5" cellspacing="1" width="100%" height="100%">
            <tr>
              <td  height="1"><img src="../imagenes/spacer.gif" width="1" height="1"></td>
              </tr>
            <tr>
              <td class="body-text1" background=""  valign="top" align="left"><b>:: Acceso</b> 
                <br>
                <br>
                <span class="tahoma_11_light">Cambie su clave de administrador por una que recuerde facilmente</span><br>
                <form name="formProceso" action="admacceso.php" method="post" onSubmit="return validaCambioClave()">
                  <input type="hidden" name="ingresar" value="1">
                  <table>
                    <tr>
                      <td class="body-text1">
                        Clave
                        </td>
                      <td class="body-text1">
                        <input type="password" name="valorClave" class="controles1">
                        </td>
                      </tr>
                    <tr>
                      <td colspan="2" align="right" class="body-text1">
                        <input type="image" src="../imagenes/ingresar.jpg"><a href="<?=$_SERVER['PHP_SELF']?>"><img src="../imagenes/cancelar.jpg" alt="borrar" border="0" /></a>
                        <br><br>
                        <?=$msg?>
                        </td>
                      </tr>
                    </table>
                  </form>
                </td>
              </tr>
            <tr>
              <td  height="10"><img src="../imagenes/spacer.gif" width="1" height="1"></td>
              </tr>
            </table>
          </td>
        </tr>
      <!-- footer -->
      </table>
  </td>
  <td><img src="../imagenes/spacer.gif" width="1" height="1"></td>
 </tr>
 <tr>
  <td colspan="3" height="50"><img src="../imagenes/spacer.gif" width="1" height="1"></td>
 </tr>
</table>
</body>
</html>