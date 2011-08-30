<?php 
	include("functions/login_functions.php");

	$postArray = &$_POST ;
	$submit = escape_value($postArray['Register']);
	$fullname = escape_value($postArray['fullname']);
	$email = escape_value($postArray['email']);
	$company = escape_value($postArray['company']);
	$login = escape_value($postArray['login']);
	$password = escape_value($postArray['password']);
	$password2 = escape_value($postArray['password2']);
	$captcha = escape_value($postArray['captcha']);

	$msg = '';

	if(isset($submit))
	{
		//Setup Validations
		$validator = new FormValidator();
		$validator->addValidation("fullname","req","Please fill in Name");
		$validator->addValidation("company","req","Please fill in Company");
		$validator->addValidation("login","email","The input for Email should be a valid email value");
		$validator->addValidation("login","req","Please fill in Login");
		$validator->addValidation("password","req","Please fill in password");
		$validator->addValidation("password","minlen=7","The password should have 7 characters or more");
		$validator->addValidation("password","req","Please confirm your password");
		$validator->addValidation("password2","eqelmnt=password","The passwords doesn't match");
		$validator->addValidation("captcha","req","Please fill the three black letters in the captcha field");
		
		if($validator->ValidateForm())
		{ 
			if(isset($_POST["captcha"]))
			if($_SESSION["captcha"]==$_POST["captcha"])
			{
				$mailAlreadyRegistered = 0;
				
				$mailAlreadyRegistered = $objUsuario->consultarUsuarioExistente($login);
				if($mailAlreadyRegistered>0)
				{
					$msg = "This login name is already taken.";
				}
				else
				{
					$objUsuario->ingresarUsuario($login,$password,$fullname,$company,$user);
					$msg = "User Registered Sucessfully. <a href = 'index.php'>Login</a>";					
				}
			}
			else
			{
				$msg.= "Captcha not valid<br/>\n";
			}
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

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title><?=$website_name?></title>
	<script type="text/javascript" src="ajax/core.js"></script>
	<script type="text/javascript">
	function mirar()
	{
		p=document.getElementById('login');
		if(p.value=='') alert('ingrese un nombre de usuario v&aacute;lido');
		else invocaGenericoPost("apodo","usrCompruebaApodo.php","Usuario="+p.value,"Checking...");
	}
	</script>
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
	<div id="header">
		<div id="logo">
      <h1><a href="#">Compromise</a></h1>
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
					<form id="form1" name="form1" method="post" action="<?=$_SERVER['PHP_SELF']?>">
						<table>
							<tr>
								<td>Full Name <span>*</span></div></td>
								<td><input name="fullname" type="text" id="fullname" value="<?=$fullname?>" /></td>
							</tr>
							<tr>
								<td>Company <span>*</span></div></td>
								<td><input name="company" type="text" id="company" value="<?=$company?>"/></td>
							</tr>
							<tr>
								<td>Email (Will be also your login) <span>*</span></td>
								<td>
									<input name="login" type="text" id="login" value="<?=$login?>" onchange="javascript:mirar();" />
									<div id="apodo" align="left">&nbsp;</div>
								</td>
							</tr>
							<tr>
								<td><b>Choose a Password </b><span>*</span></div></td>
								<td>
									<input name="password" type="password" id="password" value="<?=$password ?>" />
								</td>
							</tr>
							<tr>
								<td><b>Confirm Password </b><span>*</span></div></td>
								<td>
									<input name="password2" type="password" id="password2" value="<?=$password2 ?>" />
								</td>
							</tr>
							<tr>
								<td><b>Captcha (Only black Symbols)</b></td>
								<td>
									<div align="left"><img src="captcha.php" align="left" /></div>&nbsp;&nbsp;
									<input type="text" name="captcha" maxlength="3" size="3" />
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
									<input name="Register" type="submit" id="submit" value="Register" />
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
	<?php include("includes/footer.php"); ?>
</body>
</html> 