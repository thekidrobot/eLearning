<?php
/*
Captcha ZDR
This is simple powerfull captcha tool writen in PHP
for protecting your web FORMS from spamers.

Copyright (C) 2007  Zdravko Shishmanov 
Country: Bulgaria 
Email: zdrsoft@yahoo.com
http://www.webtoolbag.com

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
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

session_start();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Example Submited Captcha ZDR</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<style type="text/css">
<!--

BODY {
font-size: 12px; 
font-family: arial, verdana, ms sans serif;
}

-->
</style>

</head>

<body>

<table width="200" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="200" height="100"  style="border: 1px solid #666666;font-size: 12px; font-family: verdana, ms sans serif;" align="center">
<b>
<?php
// $_SESSION['captcha'] contain true value from captcha image, you can make COMPARISON with string entered from user. EXAMPLE:

include("class/captchaZDR.php");
$capt = new captchaZDR;

if($capt->check_result())
{ 
	echo 'Your Input is true!  :-)';
} 
else 
{
	echo 'Your Input is wrong! :-(';
}
?></b>    
<br />
<br />
<a href="example.php"><-Back</a>
    </td>
  </tr>
</table>
<br /><br /><br />
<b>CaptchaZDR Tool</b><br />
License: GPL<br />
Author: Zdravko Shishmanov<br />
Download: <a href="" target="_blank">CaptchaZDR Tool</a><br />
FORUM: <a href="http://www.webtoolbag.com/forum/" target="_blank">Captcha ZDR FORUM</a><br />
<a href="http://www.webtoolbag.com" target="_blank">http://www.webtoolbag.com</a>
</body>
</html>











