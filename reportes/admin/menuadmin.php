<?
include("../conexion.php");

session_start();

//validar sesion
if($_SESSION["usuario"]=="")
 {
  ?>
  <script language="javascript">
  document.location="index.php";
  </script>
  <?
 }

?>
<html>
<head>
<title>:: nucomm.tv ::</title>
<link rel="stylesheet" href="../css/INDEX.CSS">
<script language="javascript" src="../js/js.js">
</script>
</head>
<body leftmargin="0" topmargin="0" background="" > 
<table width="762" height="100%" align="center" cellpadding="0" cellspacing="0">

 <tr>
  <td width="6" height="258"><img src="imagenes/spacer.gif" width="1" height="1"></td>
  <td width="1" background="imagenes/fondo3.jpg"></td>
  <td width="753" bgcolor="white" valign="top">
   <table width="100%" height="100%" cellpadding="0" cellspacing="0">
    <!-- banner superior -->
    <tr>
	 <td class="body-text1" height="120"><img src="../imagenes/BannnerAdministrativo.jpg" width="800" height="171"></td> 
	</tr>
    <!-- menu superior -->
    <tr>
	 <td class="body-text1"  height="20" align="right"> 
	  <table width="100%" cellpadding="0" cellspacing="0">
	   <tr>
		<td width="10"><img src="imagenes/spacer.gif" width="1" height="1"></td>	   
	    <td align="left">
		</td>
	    <td class="body-text1" width="220">
		</td>
	    <td width="10"><img src="imagenes/spacer.gif" width="1" height="1"></td>
	   </tr>
	  </table>
	 </td>
	</tr>
	

    <!-- zona central -->
    <tr>
	 <td class="body-text1" valign="top">
	  <table cellpadding="0" cellspacing="0" width="100%" height="100%">
	   <tr>
	    <td  height="1"><img src="imagenes/spacer.gif" width="1" height="1"></td>
	   </tr>
	   <tr>
		<td class="body-text1" background="imagenes/fondoPAGINA.jpg"  valign="middle" align="center">
	      <table>
		   <tr>
			<td class="body-text1" >
			  <a href="admreporte.php" target="carga" class="tahoma_11_center" style="color:red">Reportes Por Usuario</a></td>

		<td class="body-text1" >&nbsp;</td>
		    <td class="body-text1" >
		      <a href="admreportevideo.php" target="carga" class="tahoma_11_center" style="color:red">Reportes Por Video</a></td>

		    <td class="body-text1" >&nbsp;</td>
		    <td class="body-text1" >
			 <a href="../index.php" class="tahoma_11_center" style="color:red">Salir</a>			</td>
		   </tr>
		  </table>
		</td>
	   </tr>
	   <tr>
	    <td  height="10"><img src="imagenes/spacer.gif" width="1" height="1"></td>
	   </tr>
	  </table>
	 </td>
	</tr>
	<!-- footer -->
    <tr>
	 <td  background="imagenes/seccion.jpg" class="body-text1" height="20" align="center">
	 </td>
	</tr>
   </table>
  </td>
  <td width="1" background="imagenes/fondo4.jpg">
  </td>
  <td width="1"><img src="imagenes/spacer.gif" width="1" height="1"></td>
 </tr>
 <tr>
  <td colspan="5" height="81"><img src="imagenes/spacer.gif" width="1" height="1">
    <iframe name="carga" frameborder="0" width="100%" src="" height="600" scrolling="auto" > </iframe></td>
 </tr>
 <tr>
   <td height="19" colspan="5" align="center" bgcolor="#0A028C"><span class="stepactive">CopyRight &bull; Todos los derechos reservados</span></td>
 </tr>
</table>
</body>
</html>
