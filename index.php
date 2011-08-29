<?php 
include("includes/connection.php");
include("includes/formvalidator.php");
include("clases/clsusuario.php");

session_start();

$_SESSION["usuario"]="";
// almacena el usuario en sesion
$_SESSION["idusuario"]="";
// almacena el id del usuario en sesion

//objetos
$objUsuario=new clsusuario();
$msg="";

$postArray = &$_POST ;
$login = $postArray['Login'];
$userlogin = $postArray['username'];
$usertype = $postArray['type'];
$userpass = $postArray['pass'];

if(isset($login))
{
  //Setup Validations
  $validator = new FormValidator();
  $validator->addValidation("username","req","Please fill in Username");
  $validator->addValidation("pass","req","Please fill in Password");
  if($validator->ValidateForm())
  {
    if($usertype=="1")
    {
      //administrador
      $valido=$objUsuario->validacionAdministrador($userlogin,$userpass);
      if($valido!="0")
      {
        //valido
        $_SESSION["usuario"]=$userlogin;
        $_SESSION["idusuario"]=$valido;
  
        //I cannot use the function here. Requires validation first.
        $filename = 'admin/menuadmin.php';
        if (!headers_sent()) header('Location: '.$filename);
        else echo '<meta http-equiv="refresh" content="0;url='.$filename.'" />';
      }
      else
      {
        $msg = "User / Password incorrect <br/>\n";  
      }
    }
    else
    {
      //usuario
      $valido=$objUsuario->validacionUsuario($userlogin,$userpass);
  
      if($valido!="0")
      {
        //valido
        $_SESSION["usuario"]=$userlogin;
        $_SESSION["idusuario"]=$valido;
        
        //I cannot use the function here. Requires validation first.
        $filename = 'usexamen.php';
        if (!headers_sent()) header('Location: '.$filename);
        else echo '<meta http-equiv="refresh" content="0;url='.$filename.'" />';
      }
      else
      {
        $msg = "User / Password incorrect <br/>\n"; 
      }
    }  
  }
  else
  {
    $error_hash = $validator->GetErrors();
    foreach($error_hash as $inpname => $inp_err)
    {
      $msg.="$inp_err<br/>\n";
    }
  }
  
  
  
  
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
            <form name="formProceso" action="<?=$_SERVER['PHP_SELF']?>" method="post">
              <table>
                <tr>
                  <td>User</td>
                  <td><input type="text" name="username"></td>
                </tr>
                <tr>
                  <td>Password</td>
                  <td><input type="password" name="pass"></td>
                </tr>
                <tr>
                  <td>Type</td>
                  <td>
                    <select name="type">
                      <option value="2" selected>User</option>
                      <option value="1">Admin</option>
                    </select>
                  </td>
                </tr>
                <tr align="center">
                  <td colspan="2">
                    <input type="submit" value="Login" name="Login">
                  </td>
                </tr>
                <?php if (trim($msg)!=''){ ?>
                <tr align="center">
                  <td colspan="2">
                    <span><?=$msg?></span></div>
                  </td>
                </tr>
                <?php
                }
                ?>
                <tr>
                  <td colspan="2" align="center" class="tahoma_11">Not registered yet? <a href="registro.php">Register</a></td>
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
<?php include("includes/footer.php"); ?>
</body>
</html>