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
 
 
	
<div style="padding-top:170px;">
 <p>&nbsp;</p>
 <table width="100%" border="0" align="center" bgcolor="#FFFFFF" style="display: block; clear:both; position:relative;">
  <tr>
   <td bgcolor="#FFFFFF" class="text10"><table width="720" height="100%" align="left" cellpadding="5" cellspacing="1">
	<tr>
	  <td  valign="top" align="left"><div class="datePicker">
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
 </div></td>
	  </tr>
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
		  <td bgcolor="#FFFFFF" class="tahoma_11" ><?php
		  
		  if(trim($nombreUsuario) == '') echo "Numero de usuarios activos : $numUsuarios";
		  else echo $nombreUsuario;
		  
		  ?></td>
		  <td  align="center" bgcolor="#FFFFFF" class="titulo_curso">&nbsp;</td>
		  </tr>
		<tr bgcolor="D4D4D4" >
		<td width="78%" bgcolor="#E5E5E5" class="tahoma_11" ><strong>Nombre Video</strong></td>
		<td width="22%"  align="center" bgcolor="#E5E5E5" class="titulo_curso"><span class="tahoma_11">N&uacute;mero de visualizaciones </span></td>
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
          <td bgcolor="#FFFFFF" class="tahoma_11" ><strong>Historial de cursos y certificaciones</strong></td>
          <td  align="center" bgcolor="#FFFFFF" class="body-text1">&nbsp;</td>
          <td  align="center" bgcolor="#FFFFFF" class="body-text1">&nbsp;</td>
          <td  align="center" bgcolor="#FFFFFF" class="body-text1">&nbsp;</td>
          <td  align="center" bgcolor="#FFFFFF" class="body-text1">&nbsp;</td>
          <tr bgcolor="D4D4D4" >
		   <td width="53%" bgcolor="#E5E5E5" class="tahoma_11" ><strong>Titulo</strong></td>
		   <td width="2%"  align="center" bgcolor="#E5E5E5" class="body-title">&nbsp;</td>
		   <td width="16%"  align="center" bgcolor="#E5E5E5" class="tahoma_11"><strong> Fecha </strong></td>
		   <td width="14%"  align="center" bgcolor="#E5E5E5" class="tahoma_11"><strong>  Puntaje </strong></td>
		   <td width="15%"  align="center" bgcolor="#E5E5E5" class="tahoma_11"><strong> Resultado</strong></td>
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
