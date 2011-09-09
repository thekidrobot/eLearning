<?php include("header.php"); ?>
<?
//objetos

$objTaller=new clsSubGrupo();
$objUsuario= new clsusuario();
$msg="";

?>
<body>
<div id="wrapper">
 <?php include("top_menu.php"); ?>
 <div id="page">
  <div id="content">
   <div class="post">

   <b>Inicio >> Reportes por Usuario</b><br><br>

   <form name="form1" method="post" action="">
    <fieldset>
	 <p><label >Seleccione el usuario:</label>
	 <select name="IdUsuario">
	 <option value="0">Seleccione</option>
	 <?
	  $RSUsuarios=$objUsuario->contarUsuarios();
	  $numUsuarios = 0;
	  while ($rowUsuarios = mysql_fetch_array($RSUsuarios))
	  {
	   extract($rowUsuarios);
	   ?>
	   <option value="<?=$IdUsuario?>"><?=$NombreCompleto?></option>
	   <?
	   $numUsuarios++;
	  }
	 ?>
	  </select>
	 </p>
	 <p><label for="dp-3">Fecha Desde</label> : <input type="text" id="dp-3" name="fdesde" value="" READONLY/></p>
	 <script type="text/javascript">
	  // <![CDATA[       
	  var opts = {                            
	   formElements:{"dp-3":"Y-ds-m-ds-d"},
	   showWeeks:true,
	   // Show a status bar and use the format "l-cc-sp-d-sp-F-sp-Y" (e.g. Friday, 25 September 2009)
	   statusFormat:"l-cc-sp-d-sp-F-sp-Y"                    
	  };      
	  datePickerController.createDatePicker(opts);
	  // ]]>
	 </script>
	 <p><label for="dp-3">Fecha Hasta</label> : <input type="text" id="dp-4" name="fhasta" value=""READONLY /></p>
	 <script type="text/javascript">
	  // <![CDATA[       
	  var opts = {                            
	   formElements:{"dp-4":"Y-ds-m-ds-d"},
	   showWeeks:true,
	   // Show a status bar and use the format "l-cc-sp-d-sp-F-sp-Y" (e.g. Friday, 25 September 2009)
	   statusFormat:"l-cc-sp-d-sp-F-sp-Y"                    
	  };      
	  datePickerController.createDatePicker(opts);
	  // ]]>
	 </script>
	 <input name="Submit" type="submit" value="Consultar">
	 <input name="Reset" type="Reset" value="Cancelar">
    </p>
	</fieldset>
    </form>	
   </div>
 
   <?
	extract($_POST);
	$nombreUsuario = "";
	if ($_POST['IdUsuario'])
	{		
	 $RSresultadoUsuario=$objUsuario->consultarDetalleUsuarios($_POST['IdUsuario']);
	 while ($rowUsuarios = mysql_fetch_assoc($RSresultadoUsuario))
	 {
	  $nombreUsuario = $rowUsuarios['NombreCompleto'];
	  extract($rowUsuarios);
	 }
	}
   ?>
   
   <table border="0" align="center" cellpadding="5" cellspacing="0" bordercolor="D4D4D4" width="100%">
	
	<tr bgcolor="D4D4D4" >
	 <td>
	  <?php
	   if(trim($nombreUsuario) == '') echo "Numero de usuarios activos : $numUsuarios";
	   else echo $nombreUsuario;
	  ?>
	  </td>
	  <td align="center">&nbsp;</td>
	 </tr>
	 
	<tr bgcolor="D4D4D4" >
	 <td bgcolor="#E1E1E1" class="tahoma_11" ><b>Nombre Video</b></td>
	 <td width="24%" align="center" bgcolor="#E1E1E1" >Visualizaciones</td>
	</tr>
	
	<?
	 $RSresultadoVistas=$objUsuario->historialvista_videos($IdUsuario);
	 while ($rowvistas = mysql_fetch_assoc($RSresultadoVistas))
	 {
	  extract($rowvistas);
	  ?>
	   <tr bgcolor="white" >
		<td><?=$nombre?></td>
		<td align="right"><?=$vistos?></td>
	   </tr>
	   <?
	 }
	 ?>
     </table>
    
	<br>
	 <table border="0" align="center" cellpadding="5" cellspacing="0" bordercolor="D4D4D4">
	  <tr bgcolor="D4D4D4" >
	   <td><strong>Hist&oacute;rico cursos y certificaciones</strong></td>
	   <td align="center">&nbsp;</td>
	   <td align="center">&nbsp;</td>
	   <td align="center">&nbsp;</td>
	   <td align="center">&nbsp;</td>
	   <tr bgcolor="D4D4D4">
	   <td width="37%" bgcolor="#E1E1E1"><strong>Titulo</strong></td>
	   <td width="4%" align="center" bgcolor="#E1E1E1">&nbsp;</td>
	   <td width="19%" align="center" bgcolor="#E1E1E1"><strong>Fecha</strong></td>
	   <td width="10%" align="center" bgcolor="#E1E1E1"><strong>Puntaje</strong></td>
	   <td width="17%"  align="center" bgcolor="#E1E1E1"><strong>Resultado</strong></td>
	  <tr>
	  <?
	  if ($_POST['IdUsuario'])
	  {
	   
	   $fdesde = trim($_POST['fdesde']);
	   $fhasta = trim($_POST['fhasta']);
	   
	   $RSresultado=$objTaller->consultarHistorialUsuario($IdUsuario,$fdesde,$fhasta);
	  }
	  
	  while ($row = @mysql_fetch_array($RSresultado))
	  {
	   $NotaObtenida=$row["NotaObtenida"]; 
	   $Fecha=$row["Fecha"]; 
	   $NotaBase=$row["NotaBase"]; 
	   $NotaMinima=$row["NotaMinima"]; 
	   $Titulo=$row["Titulo"];
	   $NombreTaller=$row["NombreTaller"]; 
	   ?>
	   <tr bgcolor="white" >
		<td valign="top"><?=$Titulo?></td>
		<td valign="top">&nbsp;</td>
		<td valign="top"><?=$Fecha?></td>
		<td valign="top" align="right"><?=$NotaObtenida?></td>
		<td valign="top" align="right">
		 <?
		 if($NotaObtenida>=$NotaMinima)
		 {
		  echo("Aprobo!");
		 }
		 else
		 {
		  echo("<font color=red>Reprobo</font>");
		 }
		 ?>
		</td>
	   <tr>
	   <?
	  }
	  ?>
	 </table>
	 
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