<?
include("../conexion.php");
include("../clases/clsusuario.php");
include("../clases/clsSubGrupo.php");

session_start();
//validar sesion
if($_SESSION["usuario"]=="")
{
 ?>
 <script language="javascript">
 document.location="../index.php";
 </script>
 <?
}

//objetos

$objTaller=new clsSubGrupo();
$objUsuario= new clsusuario();
$msg="";

?>
<html>
<head>
 <title>:: CUESTIONARIO ::</title>
 <link rel="stylesheet" href="../css/INDEX.CSS">
 <script language="javascript" src="js.js"></script>

 <script type="text/javascript" src="../js/datepicker.js">{"describedby":"fd-dp-aria-describedby"}</script>
 <link href="../css/datepicker.css" rel="stylesheet" type="text/css" />
 
</head>

 <body leftmargin="0" topmargin="0" background="" > 
 
 <div class="datePicker">
  <form name="form1" method="post" action="">
   <fieldset>
   <p><label  class="tahoma_11_light">Seleccione el usuario:</label>
	<select name="IdUsuario" class="tahoma_11_light">
	<option value="0">Seleccione</option>

	<?
	 $RSUsuarios=$objUsuario->consultarUsuarios();
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
    <p><label for="dp-3" class="tahoma_11_light">Fecha Desde</label> : <input type="text" class="w16em" id="dp-3" name="fdesde" value="" READONLY/></p>
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

    <p><label for="dp-3" class="tahoma_11_light">Fecha Hasta</label> : <input type="text" class="w16em" id="dp-4" name="fhasta" value=""READONLY /></p>
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
	
	<input name="Submit" type="submit" class="tahoma_11_light" value="Consultar">
	<input name="Reset" type="Reset" class="tahoma_11_light" value="Cancelar">
    </p>
	</fieldset>
    </form>	
 </div>
	
<div style="padding-top:170px;">
 <table width="100%" border="0" align="center" bgcolor="#FFFFFF" style="display: block; clear:both; position:relative;">
  <tr>
   <td bgcolor="#FFFFFF" class="text10"><table cellpadding="5" cellspacing="1" width="720" height="100%">
	<tr>
	 <p>
	 <td  valign="top" align="left">
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
      <br>
      </p>
	   <table width="720" border="0" align="center" cellpadding="5" cellspacing="0" bordercolor="D4D4D4">
		<tr bgcolor="D4D4D4" >
		  <td width="76%" class="titulo_curso" ><?php
		  
		  if(trim($nombreUsuario) == '') echo "Numero de usuarios activos : $numUsuarios";
		  else echo $nombreUsuario;
		  
		  ?></td>
		  <td  align="center" class="titulo_curso">&nbsp;</td>
		  </tr>
		<tr bgcolor="D4D4D4" >
		<td bgcolor="#E1E1E1" class="tahoma_11" ><strong>Nombre Video</strong></td>
		<td width="24%"  align="center" bgcolor="#E1E1E1" class="titulo_curso"><span class="tahoma_11">Visualizaciones </span></td>
		</tr>
		<?
		 $RSresultadoVistas=$objUsuario->historialvista_videos($IdUsuario);
		 while ($rowvistas = mysql_fetch_assoc($RSresultadoVistas))
		 {
		  extract($rowvistas);
		  ?>
		  <tr bgcolor="white" >
			<td valign="top" class="borde_gris_abajo_fuente"><?=$nombre?></td>
            <td class="borde_gris_abajo_fuente"  valign="top">
			 <div align="right"><?=$vistos?></div>
			</td>
            </tr>
            <?
		  }
		 ?>
        </table>
        <br>
        <table width="720" border="0" align="center" cellpadding="5" cellspacing="0" bordercolor="D4D4D4">
		 <tr bgcolor="D4D4D4" >
		  <td class="tahoma_11" ><strong>Hist&oacute;rico cursos y certificaciones</strong></td>
		  <td  align="center" class="titulo_curso">&nbsp;</td>
          <td  align="center" class="titulo_curso">&nbsp;</td>
          <td  align="center" class="titulo_curso">&nbsp;</td>
          <td  align="center" class="titulo_curso">&nbsp;</td>
          <tr bgcolor="D4D4D4" class="tahoma_11" >
		   <td width="37%" bgcolor="#E1E1E1" class="tahoma_11" ><strong>Titulo</strong></td>
		   <td width="4%"  align="center" bgcolor="#E1E1E1" class="body-title">&nbsp;</td>
		   <td width="19%"  align="center" bgcolor="#E1E1E1" class="tahoma_11"><strong> Fecha </strong></td>
		   <td width="10%"  align="center" bgcolor="#E1E1E1" class="tahoma_11"><strong>  Puntaje </strong></td>
		   <td width="17%"  align="center" bgcolor="#E1E1E1" class="tahoma_11"><strong> Resultado</strong></td>
		  <tr>
          <?
		  if ($_POST['IdUsuario']){
		   
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
           <td class="borde_gris_abajo_fuente"  valign="top"><?=$Titulo?></td>
           <td class="borde_gris_abajo_fuente"  valign="top">&nbsp;</td>
           <td class="borde_gris_abajo_fuente"  valign="top">
			<div align="right"><?=$Fecha?></div>
		   </td>
           <td class="borde_gris_abajo_fuente"  valign="top">
			<div align="right"><?=$NotaObtenida?></div>
		   </td>
           <td class="borde_gris_abajo_fuente"  valign="top"><div align="right">
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
			</div></td>
			<tr>
		   <?
		  }
		  ?>
		  </table>
		<p>&nbsp;</p>
        <p><br><br></p>
		</td>
		</tr>
		<tr>
        <td  height="10"><img src="imagenes/spacer.gif" width="1" height="1"></td>
		</tr>
		</table>
	   </td>
	 </tr>
   </table>
 </div>
 </body>
</html>
