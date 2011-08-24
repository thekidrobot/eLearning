<?
include("includes/connection.php");

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
<title>:: CUESTIONARIO ::</title>
<link rel="stylesheet" href="css/INDEX.CSS">
<script language="javascript" src="js.js">
</script>
<script type="text/javascript">
<!--
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->
</script>
</head>
<body background="" leftmargin="0" topmargin="0" onLoad="MM_preloadImages('imagenes/home_r4_c1_S.jpg','imagenes/home_r4_c2_S.jpg','imagenes/home_r4_c3_S.jpg','imagenes/home_r4_c4_S.jpg')" > 
<table width="793" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><img src="imagenes/top.jpg" alt="" width="800" height="176"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Bienvenido: <?=$_SESSION['NombreCompleto']; ?></td>
  </tr>
  <tr>
    <td><div align="center"><img src="imagenes/bienvenido_large.jpg" width="671" height="62"></div></td>
  </tr>
  <tr>
    <td><div align="center"></div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="671" border="0" align="center" cellpadding="0" cellspacing="0">
      <!-- fwtable fwsrc="home.png" fwbase="home.jpg" fwstyle="Dreamweaver" fwdocid = "182207746" fwnested="0" -->
      <tr>
        <td><img src="imagenes/spacer.gif" width="164" height="1" border="0" alt="" /></td>
        <td><img src="imagenes/spacer.gif" width="170" height="1" border="0" alt="" /></td>
        <td><img src="imagenes/spacer.gif" width="171" height="1" border="0" alt="" /></td>
        <td><img src="imagenes/spacer.gif" width="166" height="1" border="0" alt="" /></td>
        <td><img src="imagenes/spacer.gif" width="1" height="1" border="0" alt="" /></td>
      </tr>
      <tr>
        <td><img name="home_r1_c1" src="imagenes/home_r1_c1.jpg" width="164" height="46" border="0" id="home_r1_c1" alt="" /></td>
        <td><img name="home_r1_c2" src="imagenes/home_r1_c2.jpg" width="170" height="46" border="0" id="home_r1_c2" alt="" /></td>
        <td><img name="home_r1_c3" src="imagenes/home_r1_c3.jpg" width="171" height="46" border="0" id="home_r1_c3" alt="" /></td>
        <td><img name="home_r1_c4" src="imagenes/home_r1_c4.jpg" width="166" height="46" border="0" id="home_r1_c4" alt="" /></td>
        <td><img src="imagenes/spacer.gif" width="1" height="46" border="0" alt="" /></td>
      </tr>
      <tr>
        <td><img name="home_r2_c1" src="imagenes/home_r2_c1.jpg" width="164" height="151" border="0" id="home_r2_c1" alt="" /></td>
        <td><img name="home_r2_c2" src="imagenes/home_r2_c2.jpg" width="170" height="151" border="0" id="home_r2_c2" alt="" /></td>
        <td><img name="home_r2_c3" src="imagenes/home_r2_c3.jpg" width="171" height="151" border="0" id="home_r2_c3" alt="" /></td>
        <td><img name="home_r2_c4" src="imagenes/home_r2_c4.jpg" width="166" height="151" border="0" id="home_r2_c4" alt="" /></td>
        <td><img src="imagenes/spacer.gif" width="1" height="151" border="0" alt="" /></td>
      </tr>
      <tr>
        <td><img name="home_r3_c1" src="imagenes/home_r3_c1.jpg" width="164" height="132" border="0" id="home_r3_c1" alt="" /></td>
        <td><img name="home_r3_c2" src="imagenes/home_r3_c2.jpg" width="170" height="132" border="0" id="home_r3_c2" alt="" /></td>
        <td><img name="home_r3_c3" src="imagenes/home_r3_c3.jpg" width="171" height="132" border="0" id="home_r3_c3" alt="" /></td>
        <td><img name="home_r3_c4" src="imagenes/home_r3_c4.jpg" width="166" height="132" border="0" id="home_r3_c4" alt="" /></td>
        <td><img src="imagenes/spacer.gif" width="1" height="132" border="0" alt="" /></td>
      </tr>
      <tr>
        <td><a href="usexamen.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image35','','imagenes/home_r4_c1_S.jpg',1)"><img src="imagenes/home_r4_c1.jpg" name="Image35" width="164" height="44" border="0"></a></td>
        <td><a href="ushistorial.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image36','','imagenes/home_r4_c2_S.jpg',1)"><img src="imagenes/home_r4_c2.jpg" name="Image36" width="170" height="44" border="0"></a></td>
        <td><a href="usacceso.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image37','','imagenes/home_r4_c3_S.jpg',1)"><img src="imagenes/home_r4_c3.jpg" name="Image37" width="171" height="44" border="0"></a></td>
        <td><a href="#" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image38','','imagenes/home_r4_c4_S.jpg',1)"><img src="imagenes/home_r4_c4.jpg" name="Image38" width="166" height="44" border="0"></a></td>
        <td><img src="imagenes/spacer.gif" width="1" height="44" border="0" alt="" /></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#CCCCCC" class="text10"><div align="center"> CopyRight &bull; Todos los derechos reservados</div></td>
  </tr>
</table>
<div align="center"></div>
</body>
</html>
