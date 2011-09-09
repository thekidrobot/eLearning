<?php
 include("header.php"); 
 
 $msg="";

 $objUsuario=new clsusuario();

 $aUsuarios = $_POST['Usuarios'];
 $aDepartamentosUsuarios = $_POST['DepartamentosUsuarios'];

 $U = count($aUsuarios);
 $D = count($aDepartamentosUsuarios);

 if($U > 0 and $D > 0)
 {
  foreach($aUsuarios as $Usuarios)
  {
   foreach($aDepartamentosUsuarios as $Departamentos)
    {
     $objUsuario->ingresarDepartamentosUsuario($Usuarios,$Departamentos);
    }
  }
  $msg="Registro actualizado";
 } 
 

 //Add User
 if($_POST["insert"]!="")
 {
  $postArray = &$_POST ;
  $fullname = escape_value($postArray['fullname']);
  $email = escape_value($postArray['email']);
  $company = escape_value($postArray['company']);
  $login = escape_value($postArray['login']);
  $password = escape_value($postArray['password']);

  $resp=$objUsuario->validacionLoginUsuario($login);
  if($resp=="1")
  {
   //Setup Validations
	 $validator = new FormValidator();
   $validator->addValidation("fullname","req","Please fill in Name");
   $validator->addValidation("company","req","Please fill in Company");
   $validator->addValidation("login","email","The input for Email should be a valid email value");
	 $validator->addValidation("password","req","Please fill in password");
	 $validator->addValidation("password","minlen=7","The password should have 7 characters or more");

   if($validator->ValidateForm())
	 {
    $objUsuario->ingresarUsuario($login,$password,$fullname,$company,$login);
    $qShowStatus = "SHOW TABLE STATUS LIKE 'usuarios'";
    $qShowStatusResult = mysql_query($qShowStatus) or die( "Query failed: " . mysql_error() . "<br/>" . $qShowStatus );
  
    $row = mysql_fetch_assoc($qShowStatusResult);
    $next_increment = $row['Auto_increment'];
        
    $aDepartamentos = $_POST['Departamentos'];
    $N = count($aDepartamentos);
    if($N > 0)
    {
     for($i=0; $i < $N; $i++)
     {
      $objUsuario->ingresarDepartamentosUsuario($next_increment-1,$aDepartamentos[$i]);
     } 
    }
    $msg="User added"; 
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
  else
  {
   $msg="User login already registered";
  }
 }

 //Update user
 if($_POST["update"]!="")
 {
  $postArray = &$_POST ;
  $userId = escape_value($postArray["uid"]);
  $fullname = escape_value($postArray['fullname']);
  $company = escape_value($postArray['company']);
  $login = escape_value($postArray['login']);
  $password = escape_value($postArray['password']);
  
  //Setup Validations
  $validator = new FormValidator();
  $validator->addValidation("fullname","req","Please fill in Name");
  $validator->addValidation("company","req","Please fill in Company");
  $validator->addValidation("login","email","The input for Email should be a valid email value");
  $validator->addValidation("password","req","Please fill in password");
  $validator->addValidation("password","minlen=7","The password should have 7 characters or more");

  if($validator->ValidateForm())
	{

   $RSresultado=$objUsuario->consultarDetalleUsuarios($userId);
   while ($row = mysql_fetch_array($RSresultado))
   {
    $vPassword=$row["Password"]; 
   } 
  
   if($vPassword == $password)
   {
    $objUsuario->actualizarUsuario($userId,$vPassword,$fullname,$company,$login);
   }
   else
   {
    $objUsuario->actualizarUsuario($userId,md5($password),$fullname,$company,$login);
   }
 
   $objUsuario->borrarDepartamentosUsuario($userId);
   $objUsuario->borrarPermisosUsuario($userId);
  
   $aDepartamentos = $_POST['Departamentos'];
   $N = count($aDepartamentos);
   if($N > 0)
   {
    for($i=0; $i < $N; $i++)
    {
     $objUsuario->ingresarDepartamentosUsuario($userId,$aDepartamentos[$i]);
    } 
   } 
   $msg="User Updated";
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

 //informacion registro seleccionado
 if($_GET["actualizar"]!="")
 {
  $RSresultado=$objUsuario->consultarDetalleUsuarios($_GET["actualizar"]);
  while ($row = mysql_fetch_array($RSresultado))
  {
   $vUsuario=$row["Usuario"]; 
   $vPassword=$row["Password"]; 
   $vEmpresa=$row["Empresa"]; 
   $vNombreCompleto=$row["NombreCompleto"]; 
   $vIdGrupos=$row["idGrupo"];
  }
 }

 //Borrar Usuario
 if($_GET["borrar"]!="")
 {
  $objUsuario->borrarUsuario($_GET["borrar"]);
  $msg="Usuario borrado";
 }

?>

<body>
 <div id="wrapper">
 <?php include("top_menu.php"); ?>
 <div id="page">
  <div id="content">
   <div class="post">
    <b>Home &gt;&gt; Users</b>
    <br />
    <br />
    
    <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
    <fieldset><legend>User Search by name</legend>
     <div class="notes">
      <h4>User Search</h4>
       <p class="last">
        Lorem Ipsum is simply dummy text of the printing and typesetting
        industry. Lorem Ipsum has been the industry's standard dummy text ever
        since the 1500s.
       </p>
       </div>
      <div class="optional">
       <label>Name :</label><input type="text" name="valorNombre" value="" maxlength="255" class="inputText" />
      </div>
      <div class="submit">
       <input type="submit" value="search" name="search" class="inputSubmit" />
      </div>
     </fieldset>
    </form>

    <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
     <fieldset><legend>Add / Modify User</legend>
      <div class="notes">
       <h4>User Search</h4>
        <p class="last">
         Lorem Ipsum is simply dummy text of the printing and typesetting
         industry. Lorem Ipsum has been the industry's standard dummy text ever
         since the 1500s.
        </p>
       </div>
       <? 
       if($_GET["actualizar"]!="")
       {
        ?>
        <input type="hidden" name="uid" value="<?=$_GET["actualizar"]?>">
        <? 
       }
       else
       {
        ?>
        <input type="hidden" name="insert" value="1">
        <? 
       }
      ?>
       <div class="optional">
        <label>Name: </label>
        <input type="text" class="inputText" name="fullname" value="<?=$vNombreCompleto?>" maxlength="255" />
       </div>
       <div class="optional">
        <label>Company: </label>
        <input type="text" class="inputText" name="company" value="<?=$vEmpresa?>" maxlength="255" />
       </div>
       <div class="optional">
        <label>Email (Will be used as login) :</label>
        <input type="text" class="inputText" name="login" value="<?=$vUsuario?>" maxlength="100" />
       </div>
       <div class="optional">
        <label>Password</label>
        <input type="password" class="inputText" name="password" value="<?=$vPassword?>" maxlength="15" />
       </div>
       <div class="optional">
        <fieldset><legend>Member of:</legend>
         <?php
         $RSresultado=$objUsuario->consultarDepartamentos_nopag();
         while ($rowDepto = mysql_fetch_array($RSresultado))
         {
          $IdDepartamento=$rowDepto["IdDepartamento"]; 
          $NomDepartamento=$rowDepto["NomDepartamento"];
          $RSactivo=$objUsuario->consultarDepartamentosUsuario($IdDepartamento,$_GET["actualizar"]);
          $rowCuenta = @mysql_fetch_array($RSactivo);			  
          if ($rowCuenta['cuenta']>0){$check='checked="yes"';} else{$check='';} 
          echo "<input class='labelCheckbox' name='Departamentos[]' type='checkbox' value='$IdDepartamento' $check />  $NomDepartamento<br />";
         }
        ?>
        </fieldset>
       </div>
       <div class="submit">
        <?php
        if(isset($_GET['actualizar']))
        {
         ?>
         <input type="submit" value="Update" name="update" class="inputSubmit"  />
         <?
        }
        else
        {
         ?>
         <input type="submit" value="Insert" name="insert" class="inputSubmit" />
         <?
        }
        ?>
       </div>
       <?=$msg?>
      </fieldset>
     </form>

     <form>
     <fieldset><legend>Departments mass upgrade</legend>
      <div class="notes">
       <h4>User Search</h4>
       <p class="last">
        Lorem Ipsum is simply dummy text of the printing and typesetting
        industry. Lorem Ipsum has been the industry's standard dummy text ever
        since the 1500s.
       </p>
      </div>
       <div class="optional">
        <fieldset><legend>Department List:</legend>
        <?php 
        $RSresultado=$objUsuario->consultarDepartamentos_nopag();
        while ($rowDepto = mysql_fetch_array($RSresultado))
        {
         $IdDepartamento=$rowDepto["IdDepartamento"]; 
         $NomDepartamento=$rowDepto["NomDepartamento"];
         echo "<input class='labelCheckbox' name='DepartamentosUsuarios[]' type='checkbox' value='$IdDepartamento'>   $NomDepartamento<br />";
        }
        ?>
        </fieldset>
     
     <div class="submit">
      <input type="submit" value="Upgrade" name="upgrade" class="inputSubmit" />
     </div>
     </fieldset>
     <br />
     <?=$msg?>
     <br />
    </form>  
 
     <form method="post" action="<?=$_SERVER['PHP_SELF']?>">
     <fieldset><legend>User List</legend>
      <table>
        <tr>
         <th colspan="2"> Name </th>
         <th> Login </th>
         <th align="center"> Delete </th>
         <!--<td  align="center">Permisos</td>-->
        <tr>
        <tr>
         <td colspan="4" align="center">
          <a href="javascript:seleccionar_todo_usr()">Select All</a> |
          <a href="javascript:deseleccionar_todo_usr()">Select None</a>
         </td>
        </tr>
        <?
        ///Buscar
        if($_POST["buscar"]!="")
        {
         $RSresultado=$objUsuario->consultarDetalleUsuariosPorNombreLike($_POST["valorNombre"]);
         while ($row = mysql_fetch_array($RSresultado))
         {
          $IdUsuario=$row["IdUsuario"]; 
          $NombreCompleto=$row["NombreCompleto"]; 
          $Usuario=$row["Usuario"]; 
          ?>
          <tr bgcolor="white" >
          <td valign="top">
           <input name="Usuarios[]" type="checkbox" value="<?=$IdUsuario?>">
          </td>
          <td valign="top">
           <a href="admusuarios.php?actualizar=<?=$IdUsuario?>">
           <?=$NombreCompleto?>
           </a>
          </td>
          <td align="center"><?=$Usuario?></td>
          <td align="center">
           <a href="admusuarios.php?borrar=<?=$IdUsuario?>" onclick="return confirm('Are you sure you want to delete?')" ><img src="../images/icons/delete.gif" alt="delete"></a>
          </td>
          <!--<td  align="center" valign="top"><a href="admpermisos.php?IdUsuario=<?=$IdUsuario?>"><img src="../imagenes/iconos/ok.png" border="0"></a></td>-->
          <tr>
          <?
         }
        }
        else
        {
         $RSresultado=$objUsuario->consultarUsuarios();
         while ($row = mysql_fetch_array($RSresultado))
         {
          $IdUsuario=$row["IdUsuario"]; 
          $NombreCompleto=$row["NombreCompleto"]; 
          $Usuario=$row["Usuario"]; 
          ?>
          <tr>
           <td valign="top">
            <input name="Usuarios[]" id="usuario" type="checkbox" value="<?=$IdUsuario?>">
           </td>
           <td>
            <a href="admusuarios.php?actualizar=<?=$IdUsuario?>"><?=$NombreCompleto?></a>
           </td>
           <td align="center"><?=$Usuario?></td>
           <td align="center">
            <a href="admusuarios.php?borrar=<?=$IdUsuario?>" onclick="return confirm('Are you sure you want to delete?')" ><img src="../images/icons/delete.gif" alt="delete"></a>
           </td>
          <!--<td  align="center" valign="top"><a href="admpermisos.php?IdUsuario=<?=$IdUsuario?>"><img src="../imagenes/iconos/ok.png" border="0"></a></td>-->
          <tr>
          <?
         }
        }
        ?>
        <tr>
         <td colspan="4" align="center">
          <a href="javascript:seleccionar_todo_usr()">Select All</a> |
          <a href="javascript:deseleccionar_todo_usr()">Select None</a>
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