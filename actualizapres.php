<?
ini_set('allow_url_fopen' , '1');
ini_set('allow_url_include' , '1');
session_start();
include("conexion.php");
include("clases/clsVideos.php");

session_start();

$objVideos=new clsVideos();

if($_SESSION["usuario"]=="")
 {
  ?>
  <script language="javascript">
  document.location="inicio.html";
  </script>
  <?
 }
 
 
  $IdUsuario=$_SESSION["idusuario"];
  $Idvideo=$_GET['Idvideo'];
  
 
   $RSVideos=$objVideos->ConsultarVideo($Idvideo);
   $RSrow=mysql_fetch_assoc($RSVideos);
    $estado=$RSrow['estado'];
	$visita=$RSrow['visita'];
	$fecha=$RSrow['fecha'];
?>
<html>
<head>
<title>:: nucomm.tv ::</title>
<link rel="stylesheet" href="INDEX.CSS">
<script language="javascript" src="js.js">
</script>
 <script language="javascript">
 <?
 	if ($estado>0){

	  $RSVideosVistos=$objVideos->ConsultaVideosVistos($IdUsuario,$Idvideo);
      $NumVideosVistos=mysql_num_rows($RSVideosVistos);
	
	   if(($visita==0) || ($visita>$NumVideosVistos)){
     
	
	 
		  if (($fecha>=date("Y-m-d")) || ($fecha=='0000-00-00')){
	
     	  $objVideos->InsertaVideosVistos($IdUsuario,$Idvideo);
	       $UrlVideo=$RSrow['UrlVideo'];
		  }
	   }
	}
 
 
 
 ?>
 
  </script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
<!--
body {
	background-color: #000;
}
-->
</style></head>
<body leftmargin="0" topmargin="0" background="" > 
<table width="47%" height="100%" align="center" cellpadding="0" cellspacing="0">

 <tr>
  <td width="104"><img src="imagenes/spacer.gif" width="1" height="1"></td>
  <td width="16" background=""></td>
  <td width="753" bgcolor="#000000" valign="top">
   <table width="100%" height="100%" cellpadding="0" cellspacing="0">
    <!-- banner superior -->
    <tr>
      <td height="64" align="center" bgcolor="#000000" class="body-text1"><img src="imagenes/banner-presentaciones.jpg" width="800" height="50"></td>
    </tr>
    <!-- menu superior -->
    <tr>
	 <td class="body-text1"  height="20" align="right"> 
	  <table width="100%" cellpadding="0" cellspacing="0">
	   <tr>
		<td width="10"><img src="imagenes/spacer.gif" width="1" height="1"></td>	   
	    <td align="left">		</td>
	    <td class="body-text1" width="220">		</td>
	    <td width="10"><img src="imagenes/spacer.gif" width="1" height="1"></td>
	   </tr>
	  </table>	 </td>
	</tr>
	

    <!-- zona central -->
    <tr>
	 <td class="body-text1" valign="top">
	  <table cellpadding="5" cellspacing="1" width="100%" height="100%">
	   <tr>
	     <td  height="1"><img src="imagenes/spacer.gif" width="1" height="1">
	       
	       <? if ($UrlVideo!="")
		   {
			?><iframe src="<?=$UrlVideo?>" height="700px" frameborder="0" width="1000px"></iframe>
			<?
		   }
		 else{ echo "Ud no tiene permiso para ver este Video o ya a caducado <br> por favor comuniquese con el administrador del sistema"; }?>	       </td>
	     </tr>
	   <tr>
	     <td height="10"><img src="imagenes/spacer.gif" width="1" height="1"></td>
	     </tr>
	  </table>	 </td>
	</tr>
	<!-- footer -->
    <tr>
	 <td  background="" class="body-text1" height="20" align="center">	 </td>
	</tr>
   </table>
  </td>
  <td width="1" background="">
  </td>
  <td width="626"><img src="imagenes/spacer.gif" width="1" height="1"></td>
 </tr>
 <tr>
  <td colspan="5" height="50"><img src="imagenes/spacer.gif" width="1" height="1"></td>
 </tr>
</table>
</body>
</html>
