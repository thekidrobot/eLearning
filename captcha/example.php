<?php
/*
Captcha ZDR
This is simple powerfull captcha tool writen in PHP
for protecting your web FORMS from spamers.

Copyright (C) 2007  Zdravko Shishmanov 
Country: Bulgaria 
Email: zdrsoft@yahoo.com
http://www.webtoolbag.com

GNU General Public License

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.s
*/

session_start();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Example Captcha ZDR</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<style type="text/css">
<!--

BODY {
font-size: 12px; 
font-family: arial, verdana, ms sans serif;
}

INPUT {
 font-size: 12px; 
 background-color: #CCCCCC; 
 border: 1px solid #666666; 
font-family: arial, verdana, ms sans serif;
font-weight: bold;
} 

-->
</style>
</head>

<body>
<form name="form1" method="post" action="example_submited.php">
<table width="200" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="200" height="100"  style="border: 1px solid #666666;"><img src="captcha_img.php" border="0"></td>
  </tr>
  <tr>
    <td style="padding-top: 5px" style="font-size: 12px;font-family: arial, verdana, ms sans serif;">    
      Result from image: <input type="text" name="capt" style="width: 80px">
      <div style="padding-top: 5px"><input type="submit" name="Submit" value="Submit"></div>
    </td>
  </tr>
</table>
</form>
<br /><br />
<?
if(!extension_loaded('gd')) echo '<div style="color: red">GD extension is not Loaded!<br /> Please load GD extension in your <b>php.ini</b> file.</div><br />';
?>

</body>
</html>
