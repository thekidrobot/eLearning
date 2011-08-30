<?php 
	include("includes/connection.php");
	if (!isset($_SESSION))
	{
	  session_start();
	}
	include("clases/clsusuario.php");
	$objUsuario=new clsusuario();
	?>
	<div id="apodo" align="left">
	<?php
	if(!filter_var($_POST['Usuario'], FILTER_VALIDATE_EMAIL))
	{
		?>
		<label>Invalid email format</label>
		<?php
	}
	else
	{
		$login = "-1";
		$totalRows_rsApodo = 0;
		if (isset($_POST['Usuario'])) { $login = $_POST['Usuario']; }
		$totalRows_rsApodo = $objUsuario->consultarUsuarioExistente($login);

		if($totalRows_rsApodo>0)
		{
			?>
			<label>This login name is already taken.</label>
			<?php
		}
		else
		{
			?>
			<label>This login name is available.</label>
			<?php
		}  
	}
	?>
	</div>