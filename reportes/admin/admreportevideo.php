<?
include("../conexion.php");
include("../clases/clsVideos.php");
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
$objUsuario= new clsVideos();
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
  <form name="form1" method="post" action="<?=$_SERVER['PHP_SELF']?>">
  <h1 class="tahoma_11">&nbsp;</h1>
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


<?php if ($_POST['Submit']){

$fdesde = trim($_POST['fdesde']. ' 00:00:00');
$fhasta = trim($_POST['fhasta']. ' 00:00:00');
$totalVideos = 0;
 
?> 
<div style="padding-top:130px;">
 <table width="100%" border="0" align="center" bgcolor="#FFFFFF" style="display: block; clear:both; position:relative;">
  <tr>
   <td bgcolor="#FFFFFF" class="text10"><table cellpadding="5" cellspacing="1" width="720" height="100%">
	<tr>
	 <p>
	 <td  valign="top" align="left"><br>
     </p>
	  <table width="720" border="0" align="center" cellpadding="5" cellspacing="0" bordercolor="D4D4D4">	
	  <tr bgcolor="D4D4D4">
	   <td width="53%" align="center" bgcolor="#E1E1E1" class="titulo_curso"><span class="tahoma_11">Nombre </span></td>
	   <td width="31%" align="center" bgcolor="#E1E1E1" class="tahoma_11"><strong>Grupo </strong></td>
	   <td width="16%" align="center" bgcolor="#E1E1E1" class="tahoma_11"><strong>#Vistas</strong></td>
	  </tr>
	  <?
	   $RSresultadoVistas=$objUsuario->HistorialVideosGrupo($fdesde,$fhasta);
	   while ($rowvistas = mysql_fetch_assoc($RSresultadoVistas))
	   {
		extract($rowvistas);
		?>
	    <tr bgcolor="white" align="left" >
		 <td class="borde_gris_abajo_fuente"  valign="top"><?=$nombre?></td>
		 <td class="borde_gris_abajo_fuente"  valign="top"><?=$NombreSubGrupo?></td>
		 <td align="right"  valign="top" class="borde_gris_abajo_fuente"><?=$totalvistas?></td>
        </tr>
       <?
	   $totalVideos++;
	   }
	  ?>
	  </table>
	  <br>
	  <table width="720" border="0" align="center" cellpadding="5" cellspacing="0" bordercolor="D4D4D4">
	    <tr bgcolor="D4D4D4" class="tahoma_11">
	   <td width="53%" align="center" bgcolor="#E1E1E1" class="tahoma_11"><strong>Nombre </strong></td>
	   <td width="31%" align="center" bgcolor="#E1E1E1" class="tahoma_11"><strong>Subgrupo </strong></td>
	   <td width="16%" align="center" bgcolor="#E1E1E1" class="tahoma_11"><strong>#Vistas</strong></td>
	  </tr>
	  <?
	   $RSresultadoVistas=$objUsuario->HistorialVideosSubgrupo($fdesde,$fhasta);
	   while ($rowvistas = mysql_fetch_assoc($RSresultadoVistas))
	   {
		extract($rowvistas);
		?>
	    <tr bgcolor="white" align="left" >
		 <td class="borde_gris_abajo_fuente"  valign="top"><?=$nombre?></td>
		 <td class="borde_gris_abajo_fuente"  valign="top"><?=$NombreSubGrupo?></td>
		 <td align="right"  valign="top" class="borde_gris_abajo_fuente"><?=$totalvistas?></td>
        </tr>
       <?
	    $totalVideos++;
	   }
	  ?>
     </table>
	</td>
		</tr>
		<tr>
        <td  height="10"><img src="imagenes/spacer.gif" width="1" height="1"></td>
		</tr>
		</table>
	   </td>
	 </tr>
   </table>
 <p class="borde_gris_abajo_fuente" align="center">Total de Videos: <?=$totalVideos ?></p>
 </div>
<?php } ?>
 </body>
</html>
