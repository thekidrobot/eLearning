README FILE
###########

About "Captcha ZDR"

This is simple, complete and powerfull captcha tool written in PHP
for protecting your web FORMS from spammers.Under GPL.

"Captcha ZDR" offers several methods of captcha protection - different fonts, 
string protection, calculation protection (simple sum and deduction), noise in image, 
string symbols, are hard for reading from spamer machines. 
8 unique backgrounds for captcha image.

The class "Captcha ZDR" is under GPL. You can visit forum related to Captcha ZDR, and get some support.
  FORUM:    http://www.webtoolbag.com/forum/
  DOWNLOAD: http://www.webtoolbag.com/downloads/captcha_zdr.zip

REQUIREMENT

1. PHP 4.3 and above
2. GD extension

INSTALLATION

1. Copy file "captcha_img.php" to your "FORM" directory;
2. Copy directory "png_bank" to directory where is captcha_img.php;
3. Copy directory "class" to directory where is captcha_img.php;
4. Paste CAPTCHA image in your "FORM". Example: <img src="captcha_img.php?<?=session_name()?>=<?=session_id()?>" border="0">
5. Paste CAPTCHA field in your "FORM". Example <input type="text" name="capt" style="width: 80px">
6. Make some logic in your "VERIFY" page (submit target page). Example:

if($_SESSION['captcha']!=$_POST['capt'] || $_SESSION['captcha']=='BADCODE')
{ 
  $_SESSION['captcha']=='BADCODE';
  echo 'Your Input is wrong! :-(';
} 
else 
{
  echo 'Your Input is true!  :-)';
}

IMPORTANT: 
$_SESSION['captcha'] variable contains RIGHT result from CAPTCHA image.
You can use example.php and example_submit.php for more information.
Write in the forum of Captcha ZDR http://www.webtoolbag.com/forum/

Success! :)



The class "Captcha ZDR" is under GPL. 
You can visit forum related to Captcha ZDR, and get some support.
http://www.webtoolbag.com/forum/

Copyright (C) 2007  Zdravko Shishmanov 
Country: Bulgaria 
Email: zdrsoft[at]yahoo.com
http://www.webtoolbag.com 
