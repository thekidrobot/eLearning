<?
class clsPermisos
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
  function Elimina_Permisos($IdUsuario)
  {
    $this->connect($this->dbhost, $this->dbuser,$this->dbpass,$this->dbname); 
    $sql="DELETE FROM  permisos_usuarios WHERE  IdUsuario='$IdUsuario'";
    $result = $this->query($sql);
  }
  
  //-----------------------------------------------------------------------------
  function Consulta_Categoria($IdUsuario,$Idcategorias)
  {
    $this->connect($this->dbhost, $this->dbuser,$this->dbpass,$this->dbname); 
    $sql="SELECT * FROM permisos_usuarios WHERE IdUsuario=$IdUsuario AND Idcategorias=$Idcategorias";
    $result= $this->query($sql);
    return mysql_num_rows($result);
  }
  
  //-----------------------------------------------------------------------------
  function Inserta_Categoria($IdUsuario,$Idcategorias)
  {
    $this->connect($this->dbhost, $this->dbuser,$this->dbpass,$this->dbname); 
    $sql="INSERT INTO permisos_usuarios (IdUsuario,Idcategorias) VALUES ($IdUsuario,$Idcategorias)";
    $result = $this->query($sql);
  }

  //-----------------------------------------------------------------------------
  function Inserta_Grupo($IdUsuario,$IdGrupos)
  {
    $this->connect($this->dbhost, $this->dbuser,$this->dbpass,$this->dbname); 
    $sql="INSERT INTO permisos_usuarios (IdUsuario,IdGrupos) VALUES ($IdUsuario,$IdGrupos)";
    $result = $this->query($sql);
  }

  //-----------------------------------------------------------------------------
  function Consulta_Grupo($IdUsuario,$IdGrupos)
  {
    $this->connect($this->dbhost, $this->dbuser,$this->dbpass,$this->dbname); 
    $sql="SELECT * FROM permisos_usuarios WHERE IdUsuario=$IdUsuario AND IdGrupos=$IdGrupos";
    $result = $this->query($sql);
    return mysql_num_rows($result);
  }
  
  //-----------------------------------------------------------------------------
  function Inserta_Subgrupo($IdUsuario,$IdSubGrupo)
  {
    $this->connect($this->dbhost, $this->dbuser,$this->dbpass,$this->dbname); 
    $sql="INSERT INTO permisos_usuarios (IdUsuario,IdSubGrupo) VALUES ($IdUsuario,$IdSubGrupo)";
    $result = $this->query($sql);
  }

  //-----------------------------------------------------------------------------
  function Consulta_Subgrupo($IdUsuario,$IdSubGrupo)
  {
    $this->connect($this->dbhost, $this->dbuser,$this->dbpass,$this->dbname); 
    $sql="SELECT * FROM permisos_usuarios WHERE IdUsuario=$IdUsuario AND IdSubGrupo=$IdSubGrupo";
    $result = $this->query($sql);
    return mysql_num_rows($result);
  }

  //-----------------------------------------------------------------------------
  function Elimina_Permisos_Depto($IdDepartamento)
  {
    $this->connect($this->dbhost, $this->dbuser,$this->dbpass,$this->dbname); 
    $sql="DELETE FROM  permisos_departamentos WHERE  IdDepartamento='$IdDepartamento'";
    $result = $this->query($sql);
  }

  //-----------------------------------------------------------------------------
  function Consulta_Categoria_Depto($IdDepartamento,$Idcategorias)
  {
    $this->connect($this->dbhost, $this->dbuser,$this->dbpass,$this->dbname); 
    $sql="SELECT * FROM permisos_departamentos WHERE IdDepartamento=$IdDepartamento AND Idcategorias=$Idcategorias";
    $result = $this->query($sql);
    return mysql_num_rows($result);
  }
  
  //-----------------------------------------------------------------------------
  function Consulta_Grupo_Depto($IdDepartamento,$IdGrupos)
  {
   $this->connect($this->dbhost, $this->dbuser,$this->dbpass,$this->dbname); 
   $sql="SELECT * FROM permisos_departamentos WHERE IdDepartamento=$IdDepartamento AND IdGrupos=$IdGrupos";
   $result = $this->query($sql);
   return mysql_num_rows($rs);
  }
  
  //-----------------------------------------------------------------------------
  function Consulta_Subgrupo_Depto($IdDepartamento,$IdSubGrupo)
  {
    $this->connect($this->dbhost, $this->dbuser,$this->dbpass,$this->dbname);   
    $sql="SELECT * FROM permisos_departamentos WHERE IdDepartamento=$IdDepartamento AND IdSubGrupo=$IdSubGrupo";
    $result = $this->query($sql);
    return mysql_num_rows($result);
  }

  //-----------------------------------------------------------------------------
  function Inserta_Categoria_Depto($IdDepartamento,$Idcategorias)
  {
    $this->connect($this->dbhost, $this->dbuser,$this->dbpass,$this->dbname); 
    $sql="INSERT INTO permisos_departamentos (IdDepartamento,Idcategorias) VALUES ($IdDepartamento,$Idcategorias)";
    $result = $this->query($sql);
  }
  
  //-----------------------------------------------------------------------------
  function Inserta_Grupo_Depto($IdDepartamento,$IdGrupos)
  {
    $this->connect($this->dbhost, $this->dbuser,$this->dbpass,$this->dbname); 
    $sql="INSERT INTO permisos_departamentos (IdDepartamento,IdGrupos) VALUES ($IdDepartamento,$IdGrupos)";
    $result = $this->query($sql);
  }
  //-----------------------------------------------------------------------------
  function Inserta_Subgrupo_Depto($IdDepartamento,$IdSubGrupo)
  {
    $this->connect($this->dbhost, $this->dbuser,$this->dbpass,$this->dbname); 
    $sql="INSERT INTO permisos_departamentos (IdDepartamento,IdSubGrupo) VALUES ($IdDepartamento,$IdSubGrupo)";
    $result = $this->query($sql);
  }

}
?>