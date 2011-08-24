<?php include("header.php"); ?>
<?php

//objetos

$objTaller=new clsSubGrupo();
$objUsuario= new clsVideos();
$msg="";

?>
<body>
<div id="wrapper">
 <?php include("top_menu.php"); ?>
 <div id="page">
  <div id="content">
   <div class="post">
	
   <b>Inicio >> Reportes por Video</b><br><br>
 
   <div class="datePicker">
   <form name="form1" method="post" action="<?=$_SERVER['PHP_SELF']?>">
	<fieldset>
    <p>
	 <label for="dp-3">Fecha Desde</label> : <input type="text" class="w16em" id="dp-3" name="fdesde" value="" READONLY/></p>
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
	 <p>
	  <label for="dp-3">Fecha Hasta</label> : <input type="text" class="w16em" id="dp-4" name="fhasta" value=""READONLY />
	 </p>
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
   
 <?php if ($_POST['Submit']){
 
 $fdesde = trim($_POST['fdesde']. ' 00:00:00');
 $fhasta = trim($_POST['fhasta']. ' 00:00:00');
 $totalVideos = 0;
?>
<div style="padding-top:150px !important">
 <table border="0" align="center" cellpadding="5" cellspacing="0" bordercolor="D4D4D4" width="100%">	
  <tr bgcolor="D4D4D4">
   <td width="53%" align="center" bgcolor="#E1E1E1" class="titulo_curso"><b>Nombre</b></td>
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
	<td><?=$nombre?></td>
	<td><?=$NombreSubGrupo?></td>
	<td align="right"><?=$totalvistas?></td>
   </tr>
   <?
	$totalVideos++;
  }
  ?>
 </table>
 <br>
 <table border="0" align="center" cellpadding="5" cellspacing="0" bordercolor="D4D4D4" width="100%">
  <tr bgcolor="D4D4D4" class="tahoma_11">
   <td width="53%" align="center" bgcolor="#E1E1E1" class="tahoma_11"><strong>Nombre</strong></td>
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
  <p align="center">Total de Videos: <?=$totalVideos ?></p>
 </div>
<?php } ?>
  
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