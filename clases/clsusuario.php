<?
include("ps_pagination.php");

class clsusuario
{
 
 //-----------------------------------------------------------------------------
 public function __construct()
 {
	$this->dbhost = $_SESSION["servidor"];
	$this->dbuser = $_SESSION["root"];
	$this->dbpass = $_SESSION["claveBD"];
	$this->dbname = $_SESSION["basededatos"];
 }
 
 //-----------------------------------------------------------------------------
 public $dbh;
 public function connect($host,$username,$password,$dbname)
 {
	$this->dbh = mysql_connect($host,$username,$password);
	//Of course, you'd want to do some actual error checking.
	//Also, you can have a separate function for selecting the DB if you need to use multiple databases
	mysql_select_db($dbname,$this->dbh);
	//You use $this->variable to refer to the connection handle
 }
 
 //-----------------------------------------------------------------------------
 public function query($sql)
 {
	return mysql_query($sql,$this->dbh);
 }
 
 //-----------------------------------------------------------------------------
 function validacionAdministrador($Usuario,$Clave)
 {
	$valido=0;

	$this->connect($this->dbhost, $this->dbuser,$this->dbpass,$this->dbname);

	$sql="SELECT * FROM administrador WHERE Clave='" . md5($Clave) . "' AND Login='" . $Usuario . "' ";
	$result = $this->query($sql);
	
	while ($row = mysql_fetch_array($result))
	{
	 $valido=$row["IdAdministrador"];
	}
	return $valido;
 }

 //-----------------------------------------------------------------------------
 function validacionUsuario($Usuario,$Clave)
 {
  $valido=0;
	$this->connect($this->dbhost, $this->dbuser,$this->dbpass,$this->dbname);

	$sql="SELECT * FROM usuarios WHERE Password='" . md5($Clave) . "' AND Usuario='" . $Usuario . "' ";
	$result = $this->query($sql);
 
	while ($row = mysql_fetch_array($result))
	{
	 $valido=$row["IdUsuario"];
	 $_SESSION['NombreCompleto']=$row["NombreCompleto"];
	}
	return $valido;
 }
 
 //-----------------------------------------------------------------------------
 function validacionLoginUsuario($Usuario)
 {
	$valido=1;
	$this->connect($this->dbhost, $this->dbuser,$this->dbpass,$this->dbname);

	$sql="SELECT * FROM usuarios WHERE  Usuario='" . trim($Usuario) . "' ";
	$result = $this->query($sql);
	
	while ($row = mysql_fetch_array($result))
	{
	 $valido=0;
	}
	return $valido;
 }

 //-----------------------------------------------------------------------------
 function actualizarClave($Login,$Clave)
 {
	$this->connect($this->dbhost, $this->dbuser,$this->dbpass,$this->dbname);
	$sql="update administrador set Clave='".$Clave."' where Login='".$Login."' ";
	$result = $this->query($sql);
 }
 
 //-----------------------------------------------------------------------------
 function actualizarDatosUsuario($Clave,$NombreCompleto,$Empresa,$Login)
 {
	$this->connect($this->dbhost, $this->dbuser,$this->dbpass,$this->dbname);
	$sql="update usuarios
				set Password='$Clave',NombreCompleto = '$NombreCompleto',
				Empresa = '$Empresa', Correo = '$Login' where Usuario='$Login'";
	$result = $this->query($sql);
 }

 //-----------------------------------------------------------------------------
 function consultarUsuarios()
 {
	$this->connect($this->dbhost, $this->dbuser,$this->dbpass,$this->dbname);
	$sql = "SELECT * FROM  usuarios order by NombreCompleto";
	$pager = new PS_Pagination($link, $sql, 100, 5);
	$result = $pager->paginate();
	?><div align="center"> <?php echo $pager->renderFullNav(); ?> </div><br/> <?php
	$result = $this->query($sql);
	return $result;
 }

 //-----------------------------------------------------------------------------
 function contarUsuarios()
 {
	$this->connect($this->dbhost, $this->dbuser,$this->dbpass,$this->dbname);
	$sql = "SELECT * FROM  usuarios order by NombreCompleto";
	
	$result = $this->query($sql);
	return $result;
 }

 //-----------------------------------------------------------------------------
 function consultarDetalleUsuarios($IdUsuario)
 {
	$this->connect($this->dbhost, $this->dbuser,$this->dbpass,$this->dbname);
  $sql = "SELECT * FROM  usuarios where IdUsuario=".$IdUsuario;
 
	$result = $this->query($sql);
	return $result;
 }

 //-----------------------------------------------------------------------------
 function consultarDetalleUsuariosPorNombre($Usuario)
 {
	$this->connect($this->dbhost, $this->dbuser,$this->dbpass,$this->dbname);
	$sql = "SELECT * FROM  usuarios where Usuario='$Usuario'";
	$result = $this->query($sql);
	return $result;
 }

 //-----------------------------------------------------------------------------
 function consultarDetalleUsuariosPorNombreLike($Usuario)
 {
	$this->connect($this->dbhost, $this->dbuser,$this->dbpass,$this->dbname);
	$sql = "SELECT * FROM  usuarios where NombreCompleto like'%$Usuario%' order by NombreCompleto";

	$pager = new PS_Pagination($link, $sql, 100, 5);
	$result = $pager->paginate();
	
	//$result = $this->query($sql);
	?><div align="center"> <?php echo $pager->renderFullNav(); ?> </div><br/> <?php
	return $result;
 }

 //-----------------------------------------------------------------------------
 function ingresarUsuario($Usuario,$Password,$NombreCompleto,$Empresa,$Correo)
 {
	$this->connect($this->dbhost, $this->dbuser,$this->dbpass,$this->dbname);
	$sql="insert into usuarios (Usuario,Password,NombreCompleto,Empresa,Correo,FechaCreacion)
				values ('".$Usuario."','".md5($Password)."','".$NombreCompleto."','".$Empresa."','".$Usuario."',NOW())";
	$result = $this->query($sql);
 }	
 
 //-----------------------------------------------------------------------------
 function actualizarUsuario($IdUsuario,$Password,$NombreCompleto,$Empresa,$Usuario)
 {
  $this->connect($this->dbhost, $this->dbuser,$this->dbpass,$this->dbname);
	$sql="update usuarios
				set Usuario='".$Usuario."',
				Correo='".$Usuario."',
				NombreCompleto='".$NombreCompleto."',
				Empresa='".$Empresa."',
				Password='".$Password."'
				where IdUsuario=".$IdUsuario;
	$result = $this->query($sql);
 }
 
 //-----------------------------------------------------------------------------
 function consultarUsuarioExistente($correo)
 {
  $this->connect($this->dbhost, $this->dbuser,$this->dbpass,$this->dbname);
	$sql = "SELECT Correo FROM usuarios WHERE Correo = '$correo'";
	$result = $this->query($sql);
	$correoExistente = mysql_num_rows($result);
	return $correoExistente;
 } 

 //-----------------------------------------------------------------------------
 function borrarUsuario($IdUsuario)
 {
	$this->connect($this->dbhost, $this->dbuser,$this->dbpass,$this->dbname);
	$sql="delete from usuarios where IdUsuario=".$IdUsuario;
	$result = $this->query($sql);
 }

 //-----------------------------------------------------------------------------
 function validacionCategorias($categorias)
 {
	$valido=1;
	$this->connect($this->dbhost, $this->dbuser,$this->dbpass,$this->dbname); 
 
	$sql="SELECT * FROM categorias WHERE  categorias='" . $categorias . "' ";
	$result = $this->query($sql);

	while ($row = mysql_fetch_array($result))
	{
	 $valido=0;
	}
	return $valido;
 }

 //-----------------------------------------------------------------------------
 function consultarDetalleCategorias($Idcategorias)
 {
	$this->connect($this->dbhost, $this->dbuser,$this->dbpass,$this->dbname);
	$sql = "SELECT * FROM  categorias where Idcategorias=".$Idcategorias;
	$result = $this->query($sql);
	return $result;
 }

 //-----------------------------------------------------------------------------
 function consultarCategorias()
 {
	$this->connect($this->dbhost, $this->dbuser,$this->dbpass,$this->dbname);
	$sql = "SELECT * FROM  categorias";
	$result = $this->query($sql);
	return $result;
 }

 //-----------------------------------------------------------------------------
 function ingresarCategorias($Detallecategorias)
 {
	$this->connect($this->dbhost, $this->dbuser,$this->dbpass,$this->dbname);
	$sql="insert into categorias (categorias) values ('" .$Detallecategorias. "') ";
	$result = $this->query($sql);
 }

 //-----------------------------------------------------------------------------
 function actualizarCategorias($Idcategorias,$categorias)
 {
	$this->connect($this->dbhost, $this->dbuser,$this->dbpass,$this->dbname);
	$sql="update categorias set categorias ='".$categorias."' where Idcategorias=".$Idcategorias;
	$result = $this->query($sql);
 }

 //--------------------------Change to classes----------------------------------
 function borrarCategorias($Idcategorias)
 {
	$this->connect($this->dbhost, $this->dbuser,$this->dbpass,$this->dbname);
	
	$sql = "delete from videosvistos
					where Idvideo in(select Idvideo from videos
													 where IdSubGrupo in((select IdSubGrupo from subgrupos
																								where IdGrupos in(select IdGrupos from grupos
																																	where IdCategorias = $Idcategorias))))";
	mysql_query($sql) or die('Invalid query: ' . mysql_error().' '.$sql);

	$sql = "delete from videosvistos
				 where Idvideo in(select Idvideo from videos
													where IdGrupos in(select IdGrupos from grupos
																						where IdCategorias = $Idcategorias))";
	mysql_query($sql) or die('Invalid query: ' . mysql_error().' '.$sql);
	 
	$sql = "delete from videos
					where IdSubGrupo in(select IdSubGrupo from subgrupos
														where IdGrupos in(select IdGrupos from grupos
																							where IdCategorias = $Idcategorias))";
	 mysql_query($sql) or die('Invalid query: ' . mysql_error().' '.$sql);
	 
	 $sql = "delete from videos
					 where IdGrupos in(select IdGrupos from grupos
														 where IdCategorias = $Idcategorias)";
	 mysql_query($sql) or die('Invalid query: ' . mysql_error().' '.$sql);
	 
	 $sql = "delete FROM permisos_usuarios WHERE IdCategorias = $Idcategorias";
	 mysql_query($sql) or die('Invalid query: ' . mysql_error().' '.$sql);
	 
	 $sql = "delete from permisos_usuarios
					 where IdGrupos in(select IdGrupos from grupos
														 where IdCategorias = $Idcategorias)";
	 mysql_query($sql) or die('Invalid query: ' . mysql_error().' '.$sql);
	 
	 $sql = "delete from permisos_usuarios
					 where IdSubGrupo in(select IdSubGrupo from subgrupos
															 where IdGrupos in(select IdGrupos from grupos
																								 where IdCategorias = $Idcategorias))";
	 mysql_query($sql) or die('Invalid query: ' . mysql_error().' '.$sql);
	 
	 $sql = "delete from subgrupos
					 where IdGrupos in (select IdGrupos from grupos
															where IdCategorias = $Idcategorias)";
	 mysql_query($sql) or die('Invalid query: ' . mysql_error().' '.$sql);
	 
	 $sql = "delete from grupos where IdCategorias = $Idcategorias";
	 mysql_query($sql) or die('Invalid query: ' . mysql_error().' '.$sql);
	 
	 $sql="delete from categorias where Idcategorias=".$Idcategorias;
	 $result = $this->query($sql);
 }

 //-----------------------------------------------------------------------------
 function consultarDetalleGrupos($IdGrupos)
 {
	$this->connect($this->dbhost, $this->dbuser,$this->dbpass,$this->dbname);
	$sql = "SELECT * FROM  grupos where IdGrupos=".$IdGrupos;
	$result = $this->query($sql);
	return $result;
 }

 //-----------------------------------------------------------------------------
 function consultarGrupos($Idcategorias)
 {
	$this->connect($this->dbhost, $this->dbuser,$this->dbpass,$this->dbname);
	$sql = "SELECT * FROM  grupos WHERE Idcategorias=$Idcategorias";
	$result = $this->query($sql);
	return $result;
 }

 //-----------------------------------------------------------------------------
 function ingresarGrupos($DetalleGrupos,$Idcategorias)
 {
	$this->connect($this->dbhost, $this->dbuser,$this->dbpass,$this->dbname);
	$sql="insert into grupos (grupos,Idcategorias) values ('" .$DetalleGrupos. "',$Idcategorias) ";
	$result = $this->query($sql);
 }

 //-----------------------------------------------------------------------------
 function actualizarGrupos($IdGrupos,$grupos)
 {
	$this->connect($this->dbhost, $this->dbuser,$this->dbpass,$this->dbname);
	$sql="update grupos set grupos ='".$grupos."' where IdGrupos=".$IdGrupos;
	$result = $this->query($sql);
 }

 //-----------------------------------------------------------------------------
 function borrarGrupos($IdGrupos,$IdCategorias)
 {
	$this->connect($this->dbhost, $this->dbuser,$this->dbpass,$this->dbname);
	$sql = "delete from subgrupos where IdGrupos = $IdGrupos";
	
	mysql_query($sql) or die('Invalid query: ' . mysql_error().' '.$sql);

	$sql = "delete from videosvistos where Idvideo in(select Idvideo from videos where IdGrupos = $IdGrupos)";
	mysql_query($sql) or die('Invalid query: ' . mysql_error().' '.$sql);

	$sql = "delete from videos where IdGrupos = $IdGrupos";
	mysql_query($sql) or die('Invalid query: ' . mysql_error().' '.$sql);

	$sql="delete from grupos where IdGrupos = $IdGrupos and IdCategorias = $IdCategorias";
	$result = $this->query($sql);
 }

 //-----------------------------------------------------------------------------
 function historialvista_videos($IdUsuario)
 {
	$this->connect($this->dbhost, $this->dbuser,$this->dbpass,$this->dbname);
	$sql="SELECT 	usuarios.IdUsuario,
								videos.nombre ,
								count(videosvistos.fecha) as vistos
			 FROM			usuarios
								INNER JOIN videosvistos
								ON (usuarios.IdUsuario = videosvistos.IdUsuario)
								INNER JOIN videos
								ON (videosvistos.Idvideo = videos.Idvideo)
			 WHERE		usuarios.IdUsuario = '".$IdUsuario ."'
			 GROUP BY	videos.nombre";
	
	$result = $this->query($sql);
	return $result;
 }

 //-----------------------------------------------------------------------------
 function validacionDepartamento($NomDepartamento)
 {
	$valido=1;
	$this->connect($this->dbhost, $this->dbuser,$this->dbpass,$this->dbname); 
	$sql="SELECT * FROM departamentos WHERE  NomDepartamento='" . $NomDepartamento. "' ";
	$result = $this->query($sql);
	
	while ($row = mysql_fetch_array($result))
	{
	 $valido=0;
	}
	return $valido;
 }

 //-----------------------------------------------------------------------------
 function ingresarDepartamento($NomDepartamento)
 {
	$this->connect($this->dbhost, $this->dbuser,$this->dbpass,$this->dbname);
	$sql="insert into departamentos (NomDepartamento) values ('".$NomDepartamento."') ";
	$result = $this->query($sql);
 }

 //-----------------------------------------------------------------------------
 function actualizarDepartamento($NomDepartamento,$IdDepartamento)
 {
	$this->connect($this->dbhost, $this->dbuser,$this->dbpass,$this->dbname);
	$sql="update departamentos set NomDepartamento='$NomDepartamento' where IdDepartamento=".$IdDepartamento;
	$result = $this->query($sql);
 }
 
 //-----------------------------------------------------------------------------
 function borrarDepartamento($IdDepartamento)
 {
	$this->connect($this->dbhost, $this->dbuser,$this->dbpass,$this->dbname);
	$sql="delete from departamentos_usuarios where IdDepartamento = $IdDepartamento";
	mysql_query($sql) or die('Invalid query: ' . mysql_error().' '.$sql);
	$sql="delete from departamentos where IdDepartamento=".$IdDepartamento;
	$result = $this->query($sql);
 }

 //-----------------------------------------------------------------------------
 function consultarDetalleDepartamentos($IdDepartamento)
 {
	$this->connect($this->dbhost, $this->dbuser,$this->dbpass,$this->dbname);
	$sql = "SELECT * FROM  departamentos where IdDepartamento=".$IdDepartamento;
	$result = $this->query($sql);
	return $result;
 }

 //-----------------------------------------------------------------------------
 function consultarDepartamentos()
 {
  $this->connect($this->dbhost, $this->dbuser,$this->dbpass,$this->dbname);
	$sql = "SELECT * FROM  departamentos order by NomDepartamento ";
	$pager = new PS_Pagination($link, $sql, 100, 5);
	$result = $pager->paginate();
	?><div align="center"> <?php echo $pager->renderFullNav(); ?> </div><br/> <?php
	$result = $this->query($sql);
	return $result;
 }
 
 //-----------------------------------------------------------------------------
 function consultarDepartamentos_nopag()
 {
  $this->connect($this->dbhost, $this->dbuser,$this->dbpass,$this->dbname);
  $sql = "SELECT * FROM  departamentos order by NomDepartamento ";
  $result = $this->query($sql);
  return $result;
 }

 //-----------------------------------------------------------------------------
 function consultarDepartamentosUsuario($IdDepartamento,$IdUsuario)
 {
	$this->connect($this->dbhost, $this->dbuser,$this->dbpass,$this->dbname);
	$sql = "SELECT count(*) as cuenta FROM  departamentos_usuarios where IdUsuario = $IdUsuario and IdDepartamento = $IdDepartamento";
	$result = $this->query($sql);
	return $result;
 }

 //-----------------------------------------------------------------------------
 function borrarDepartamentosUsuario($IdUsuario)
 {
	$this->connect($this->dbhost, $this->dbuser,$this->dbpass,$this->dbname);
	$sql = "delete FROM  departamentos_usuarios where IdUsuario = $IdUsuario";
	$result = $this->query($sql);
	return $result;
 }
 
 //-----------------------------------------------------------------------------
 function borrarPermisosUsuario($IdUsuario)
 {
	$this->connect($this->dbhost, $this->dbuser,$this->dbpass,$this->dbname);
	 
	$sql1 = "Delete from permisos_usuarios where IdUsuario = $IdUsuario";
	$result1 = $this->query($sql1);
	return $result;
 }
 
 //-----------------------------------------------------------------------------
 function ingresarDepartamentosUsuario($IdUsuario,$idDepartamento)
 {
  $this->connect($this->dbhost, $this->dbuser,$this->dbpass,$this->dbname);
 
  $sql = "insert ignore into departamentos_usuarios values($IdUsuario,$idDepartamento)";
  $result = $this->query($sql);

  $sql2 = "SELECT * FROM permisos_departamentos WHERE IdDepartamento = $idDepartamento";
  $result2 = $this->query($sql2);
   
  while ($row = mysql_fetch_array($result2))
  {
   if (is_null($row["IdCategorias"]))
		$IdCategorias='NULL';
   else
		$IdCategorias=$row["IdCategorias"];
      
   if (is_null($row["IdGrupos"]))
		$IdGrupos='NULL';
	 else
		$IdGrupos=$row["IdGrupos"];
			
   if (is_null($row["IdSubGrupo"]))
		$IdSubGrupo='NULL';
   else
		$IdSubGrupo=$row["IdSubGrupo"]; 
      
   $sql3 = "insert into permisos_usuarios(IdUsuario,IdCategorias,IdGrupos,IdSubGrupo,IdDepartamento)
						values ($IdUsuario,$IdCategorias,$IdGrupos,$IdSubGrupo,$idDepartamento)";
						
   $result3 = $this->query($sql3);
  }
  return $result2;
 }
}
?>