<?
include("conexion.php");
include("clases/clsusuario.php");
include("clases/clsSubGrupo.php");
include("clases/clsVideos.php");

session_start();

//validar sesion
if($_SESSION["usuario"]=="")
 {
  ?>
  <script language="javascript">
  document.location="inicio.html";
  </script>
  <?
 }

///objetos
$objTaller=new clsSubGrupo();
$objUsuario=new clsusuario();
$objVideos= new clsVideos();

$msg="";
$idusuario=$_SESSION["idusuario"];
$RSUsuario=$objUsuario->consultarDetalleUsuarios($idusuario);
$RowUsuario=mysql_fetch_assoc($RSUsuario);

?>
<html>
 <head>
  <title>:: nucomm.tv ::</title>
  <link rel="stylesheet" href="css/INDEX.CSS">
  <script language="javascript" src="js.js"></script>
 <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
<!--
body {
	background-color: #000;
}
-->
</style></head>
 <body leftmargin="0" topmargin="0" background="" > 
  <table width="800" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
   <td colspan="3"><img src="imagenes/top.jpg" alt="" width="1024" height="176"></td>
  </tr>
  <tr>
   <td width="9" bgcolor="#000000">&nbsp;</td>
   <td width="237" bgcolor="#000000" class="borde_azul"><strong>Bienvenido</strong>
     <?=$RowUsuario['NombreCompleto'] ?>
- <a href="index.php" target = "_top" class="borde_azul" ?>Salir</a></td>
   <td width="778" align="right" valign="bottom" bgcolor="#000000" class="borde_azul"><img src="imagenes/menu_Progreso.jpg" width="579" height="25" border="0" align="absbottom" usemap="#Map">
     <map name="Map">
       <area shape="rect" coords="154,3,282,22" href="ushistorial.php">
       <area shape="rect" coords="300,4,430,21" href="usacceso.php">
       <area shape="rect" coords="444,5,565,20" href="#">
       <area shape="rect" coords="10,5,139,21" href="usexamen.php">
    </map></td>
  </tr>
  <tr>
   <td colspan="3" bgcolor="#FFFFFF" class="text10">
	<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
	 <tr>
	  <td  height="1" valign="top" bgcolor="#000000">&nbsp;</td>
    </tr>
    <tr>
     <td align="left"  valign="top" bgcolor="#000000">
	  <br>
	  <table width="720" border="0" align="center" cellpadding="0" cellspacing="0">
	    <tr>
	      <td height="22" bgcolor="#999999" class="tahoma_11"><strong>&nbsp;&nbsp;Historial de Cursos y Certificaciones</strong></td>
	      </tr>
	    </table>
	  <table width="720" border="0" align="center" cellpadding="5" cellspacing="0" bordercolor="D4D4D4"  bgcolor="#CECECE"class="bordes_blancos">
	    <tr bgcolor="D4D4D4" >
		   <td width="40%" align="left" bgcolor="#E1E1E1" class="tahoma_11" ><strong> T&iacute;tulo</strong></td>
		   <td width="3%"  align="center" bgcolor="#E1E1E1" class="body-title">&nbsp;</td>
		   <td width="17%"  align="center" bgcolor="#E1E1E1" class="tahoma_11_center"> Fecha </td>
		   <td width="9%"  align="center" bgcolor="#E1E1E1" class="tahoma_11_center">  Puntaje </td>
		   <td width="14%"  align="center" bgcolor="#E1E1E1" class="tahoma_11_center"> Resultado</td>
		   <td width="17%"  align="center" bgcolor="#E1E1E1" class="tahoma_11_center"> Certificado</td>
            <tr>
            <?	  
			 $RSresultado=$objTaller->consultarHistorialUsuario($_SESSION["idusuario"],'','');
			 while ($row = mysql_fetch_array($RSresultado))
			 {
			  $NotaObtenida=$row["NotaObtenida"]; 
			  $Fecha=$row["Fecha"]; 
			  $NotaBase=$row["NotaBase"]; 
			  $NotaMinima=$row["NotaMinima"]; 
			  $Titulo=$row["Titulo"];
			  $NombreTaller=$row["NombreTaller"];
			  $IdModulo = $row["IdModulo"];
			  ?>
              <tr bgcolor="white" >
			   <td  valign="top" bgcolor="#FFFFFF" class="borde_gris_abajo_fuente"><?=$Titulo?></td>
			   <td  valign="top" bgcolor="#FFFFFF" class="borde_gris_abajo_fuente">&nbsp;</td>
			   <td  valign="top" bgcolor="#FFFFFF" class="borde_gris_abajo_fuente">
				<div align="right"><?=$Fecha?></div>
			   </td>
			   <td  valign="top" bgcolor="#FFFFFF" class="borde_gris_abajo_fuente">
				<div align="right"><?=$NotaObtenida?></div>
			   </td>
               <td  valign="top" bgcolor="#FFFFFF" class="borde_gris_abajo_fuente">
				<div align="right">
				<?
				if($NotaObtenida>=$NotaMinima) { echo("Aprobo!"); }
				else { echo("<font color=red>Reprobo</font>"); }
				 ?>                  
                </div>
			   </td>
			   <td  valign="top" bgcolor="#FFFFFF" class="borde_gris_abajo_fuente">
				<div align="center">
				<?
				if($NotaObtenida>=$NotaMinima) { echo("<a href='diploma.php?IdModulo=$IdModulo' target='_blank'>Ver</a>"); }
				else { echo("&nbsp;"); }
				?>                  
                </div>
			   </td>
			  <tr>
              <?
			 }
			?>
            </table>
	  <br>
	  <table width="720" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="D4D4D4" class="bordes_blancos">
	    <tr>
		<td bgcolor="#FFFFFF" class="text10"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
		 <tr>
		  <p>
		  <td  valign="top" align="left"><table width="720" border="0" align="center" cellpadding="5" cellspacing="0" bordercolor="D4D4D4">	
		    <tr valign="top" bgcolor="#CECECE" class="borde_gris_abajo_fuente">
		     <td align="left" bgcolor="#999999" class="tahoma_11"><strong>Historial de Videos Visualizados</strong></td>
		     <td align="center" bgcolor="#999999" class="tahoma_11">&nbsp;</td>
		     <td align="center" bgcolor="#999999" class="tahoma_11">&nbsp;</td>
		     </tr>
		   <tr valign="top" bgcolor="#CECECE" class="borde_gris_abajo_fuente">
			<td width="363" align="left" bgcolor="#E1E1E1" class="tahoma_11"><strong>Nombre </strong></td>
			<td width="188" align="left" bgcolor="#E1E1E1" class="tahoma_11"><strong>Grupo </strong></td>
			<td width="93" align="center" bgcolor="#E1E1E1" class="tahoma_11"><strong>&nbsp;&nbsp;&nbsp;&nbsp; #Vistas</strong></td>
		   </tr>
		   <?
			$RSresultadoVistas=$objVideos->HistorialVideosGrupoUsuario($_SESSION["idusuario"]);
			while ($rowvistas = mysql_fetch_assoc($RSresultadoVistas))
			{
			 extract($rowvistas);
			 ?>
			 <tr bgcolor="white" align="center" >
			  <td align="left"  valign="top" class="borde_gris_abajo_fuente"><?=$nombre?></td>
			  <td align="left"  valign="top" class="borde_gris_abajo_fuente"><?=$NombreSubGrupo?></td>
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
		        <td width="389" align="left" bgcolor="#E1E1E1" class="tahoma_11"><strong>Nombre </strong></td>
		        <td width="199" align="left" bgcolor="#E1E1E1" class="tahoma_11"><strong>Subgrupo </strong></td>
		        <td width="102" align="center" bgcolor="#E1E1E1" class="tahoma_11"><strong>#Vistas</strong></td>
		        </tr>
		      <?
			$RSresultadoVistas=$objVideos->HistorialVideosSubgrupoUsuario($_SESSION["idusuario"]);
			while ($rowvistas = mysql_fetch_assoc($RSresultadoVistas))
			{
			 extract($rowvistas);
			 ?>
		      <tr bgcolor="white" align="center" >
		        <td align="left"  valign="top" class="borde_gris_abajo_fuente"><?=$nombre?></td>
		        <td align="left"  valign="top" class="borde_gris_abajo_fuente"><?=$NombreSubGrupo?></td>
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
	  <br>
	  <table width="720" border="0" align="center" cellpadding="0" cellspacing="0">
	    <tr>
	      <td height="22" bgcolor="#999999" class="tahoma_11"><strong>Total de Videos Visualizados:
              <?=$totalVideos ?>
	      </strong></td>
	      </tr>
	    </table>
	  <p class="" align="center"><br>
	  </p></td></tr>
		  <tr>
		    <td  height="10" align="left" bgcolor="#000000" class="rights"> &nbsp;&nbsp;  <img src="imagenes/spacer.gif" width="1" height="1">Todos los derechos reservados. &copy; nucomm.tv, 2010</td>
	    </tr>
		  <tr>
		    <td  height="10" align="center" bgcolor="#000000" class="borde_azul">&nbsp;</td>
	    </tr>
	   </table>
  </td>
	 </tr>
	<tr>
   <td colspan="3" bgcolor="#000000" class="text10"><div align="center" class="borde_azul"></div></td>
  </tr>
 </table>
  <br>
</body>
</html>
