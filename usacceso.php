<?
include("functions/general_functions.php");
include("includes/formvalidator.php");

include("clases/clsusuario.php");
$objUsuario=new clsusuario();

$msg="";

$idusuario=$_SESSION["idusuario"];
$usuario = $_SESSION["usuario"];

$RSUsuario=$objUsuario->consultarDetalleUsuariosPorNombre($usuario);
$RowUsuario=mysql_fetch_assoc($RSUsuario);

$current_password = $RowUsuario['Password'];

$postArray = &$_POST ;
$change = $postArray['Change'];
$fullname = escape_value($postArray['fullname']);
$email = escape_value($postArray['email']);
$company = escape_value($postArray['company']);
$login = escape_value($postArray['login']);
$password = escape_value($postArray['password']);
$password2 = escape_value($postArray['password2']);

if(isset($change))
{
 //Setup Validations
 $validator = new FormValidator();
 $validator->addValidation("fullname","req","Please fill in Name");
 $validator->addValidation("company","req","Please fill in Company");
 $validator->addValidation("password","req","Please fill in password");
 $validator->addValidation("password","minlen=7","The password should have 7 characters or more");
 $validator->addValidation("password","req","Please confirm your password");
 $validator->addValidation("password2","eqelmnt=password","The passwords doesn't match");

 if($validator->ValidateForm())
 { 
	if($current_password == $password)
	{
	 $objUsuario->actualizarDatosUsuario($current_password,$fullname,$company,$login);
	}
	else
	{
	 $objUsuario->actualizarDatosUsuario(md5($password),$fullname,$company,$login);
	}
	$msg="User data updated successfully.";
	redirect($_SERVER['PHP_SELF']);
 }
 else
 {
	$error_hash = $validator->GetErrors();
	foreach($error_hash as $inpname => $inp_err)
	{
		$msg.= "$inp_err<br/>\n";
	}
 }
}
?>

<html>
<?php include("includes/head.php"); ?>
 <body>
  <?php include("includes/logo.php") ?>
  <!-- end #header -->
  <?php include("includes/top_menu.php"); ?>
  <!-- end #menu -->
	<div id="wrapper">
   <div class="btm">
		<div id="page">
		 <div id="content">
			<div class="post">
			<?php 

			?>
			<p>Change your personal data </p>
			<form id="form1" name="form1" method="post" action="<?=$_SERVER['PHP_SELF']?>">
			 <table>
				<tr>
				 <td>Full Name <span>*</span></div></td>
					<td><input name="fullname" type="text" id="fullname" value="<?=$RowUsuario['NombreCompleto']?>" /></td>
				 </tr>
				 <tr>
					<td>Company <span>*</span></div></td>
					<td><input name="company" type="text" id="company" value="<?=$RowUsuario['Empresa']?>"/></td>
				 </tr>
				 <tr>
					<td>Email<span>*</span></td>
					<td>
					 <input name="login" type="text" id="login" value="<?=$RowUsuario['Correo']?>" readonly />
					</td>
				 </tr>
				 <tr>
					<td><b>Choose a Password </b><span>*</span></div></td>
					<td>
					 <input name="password" type="password" id="password" value="<?=$current_password ?>" />
					</td>
				 </tr>
				 <tr>
					<td><b>Confirm Password </b><span>*</span></div></td>
					<td>
					 <input name="password2" type="password" id="password2" value="<?=$current_password ?>" />
					</td>
				 </tr>
				 <?php
				 if (trim($msg)!='')
				 {
				 ?>
				 <tr align="center">
					 <td colspan="2">
						 <span><?=$msg?></span>
					 </td>
				 </tr>
				 <?php
				 }
				 ?>
				 <tr>
					<td colspan="2" align="center">
					 <input name="Change" type="submit" id="submit" value="Change" />
					</td>
				 </tr>
				</table>
			 </form>
			</div>
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