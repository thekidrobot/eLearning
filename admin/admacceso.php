<?php include("header.php"); ?>
<?php
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
<body>
<div id="wrapper">
 <?php include("top_menu.php"); ?>
 <div id="page">
  <div id="content">
   <div class="post">

    <b>:: Acceso</b><br><br>
    <span>Cambie su clave de administrador por una que recuerde facilmente.</span><br><br>
    
    <form name="formProceso" action="admacceso.php" method="post" onSubmit="return validaCambioClave()">
    <fieldset>
     <input type="hidden" name="ingresar" value="1">
      <table>
       <tr>
        <td>Clave</td>
        <td><input type="password" name="valorClave"></td>
       </tr>
       <tr>
        <td colspan="2" align="right">
         <input type="image" src="../imagenes/ingresar.jpg"><a href="<?=$_SERVER['PHP_SELF']?>"><img src="../imagenes/cancelar.jpg" alt="borrar" border="0" /></a>
         <br><br>
         <?=$msg?>
         </td>
       </tr>
      </table>
     </fieldset> 
     </form>
    
 </div>
</div>
<!-- end #content -->
<?php include("sidebar.php"); ?>
  <div style="clear: both;">&nbsp;</div>
</div>
<!-- end #page -->
</div>
<?php include("footer.php"); ?>
</body>
</html>