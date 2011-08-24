<?php require_once('Connections/live.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO livechat (Nombre, mail, comentario, leido) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['nombre'], "text"),
                       GetSQLValueString($_POST['mail'], "text"),
                       GetSQLValueString($_POST['pregunta'], "text"),
                       GetSQLValueString($_POST['leido'], "text"));

  mysql_select_db($database_live, $live);
  $Result1 = mysql_query($insertSQL, $live) or die(mysql_error());

  $insertGoTo = "enviado.html";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Documento sin título</title>
<script type="text/javascript">
<!--
function MM_validateForm() { //v4.0
  if (document.getElementById){
    var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
    for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=document.getElementById(args[i]);
      if (val) { nm=val.name; if ((val=val.value)!="") {
        if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
          if (p<1 || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.\n';
        } else if (test!='R') { num = parseFloat(val);
          if (isNaN(val)) errors+='- '+nm+' must contain a number.\n';
          if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
            min=test.substring(8,p); max=test.substring(p+1);
            if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
      } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' is required.\n'; }
    } if (errors) alert('The following error(s) occurred:\n'+errors);
    document.MM_returnValue = (errors == '');
} }
//-->
</script>
<style type="text/css">
<!--
-->
</style>
<link href="css/estilos.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
body {
	background-color: #333;
}
-->
</style></head>

<body>
<form action="<?php echo $editFormAction; ?>" method="POST" name="form1" onSubmit="MM_validateForm('nombre','','R','mail','','NisEmail','pregunta','','R');return document.MM_returnValue">
<p>&nbsp;</p>
  <table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td height="21" colspan="3" bgcolor="#CCCCCC" class="trebuchet_15">&nbsp;</td>
    </tr>
    <tr>
      <td height="28" bgcolor="#CCCCCC" class="trebuchet_15">&nbsp;</td>
      <td height="28" bgcolor="#CCCCCC" class="trebuchet_15">Preguntas</td>
      <td height="28" bgcolor="#CCCCCC" class="trebuchet_15">&nbsp;</td>
    </tr>
    <tr>
      <td width="7%" bgcolor="#CCCCCC" class="tahoma_11">&nbsp;</td>
      <td width="15%" height="28" bgcolor="#CCCCCC" class="tahoma_11">Nombre*</td>
      <td width="78%" bgcolor="#CCCCCC"><label>
        <input name="nombre" type="text" class="tahoma_11" id="nombre" size="50">
      </label></td>
    </tr>
    <tr>
      <td bgcolor="#CCCCCC" class="tahoma_11">&nbsp;</td>
      <td height="28" bgcolor="#CCCCCC" class="tahoma_11">E-mail*</td>
      <td bgcolor="#CCCCCC"><label>
        <input name="mail" type="text" class="tahoma_11" id="mail" size="50">
      </label></td>
    </tr>
    <tr>
      <td valign="top" bgcolor="#CCCCCC" class="tahoma_11">&nbsp;</td>
      <td height="30" valign="top" bgcolor="#CCCCCC" class="tahoma_11">Pregunta*</td>
      <td bgcolor="#CCCCCC"><label>
        <textarea name="pregunta" cols="50" rows="5" class="tahoma_11" id="pregunta"></textarea>
      </label></td>
    </tr>
    <tr>
      <td bgcolor="#CCCCCC">&nbsp;</td>
      <td bgcolor="#CCCCCC">&nbsp;</td>
      <td bgcolor="#CCCCCC"><label>
        <input name="enviar" type="submit" class="tahoma_11" id="enviar" value="Preguntar">
      </label></td>
    </tr>
    <tr>
      <td bgcolor="#CCCCCC">&nbsp;</td>
      <td bgcolor="#CCCCCC">&nbsp;</td>
      <td bgcolor="#CCCCCC"><label>
        <input name="leido" type="hidden" id="leido" value="0" checked>
      </label></td>
    </tr>
    <tr>
      <td colspan="3" align="center" bgcolor="#CCCCCC" class="tahoma_11">Por favor sea concreto&nbsp;en el momento de formular su pregunta</td>
    </tr>
    <tr>
      <td colspan="3" bgcolor="#CCCCCC" class="trebuchet_15">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3" bgcolor="#CCCCCC" class="trebuchet_15">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3" bgcolor="#CCCCCC">&nbsp;</td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1">
</form>
</body>
</html>