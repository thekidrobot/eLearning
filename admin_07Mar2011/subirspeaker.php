<?
include("../conexion.php");
include("../clases/clsusuario.php");

session_start();

//validar sesion
if($_SESSION["usuario"]=="")
{
 ?>
 <script language="javascript">
 document.location="../inicio.html";
 </script>
 <?
}
?>
<html>
<head>
<title>:: nucomm.tv ::</title>
<link rel="stylesheet" href="../css/INDEX.CSS">
</script>
</head>

<?php
$large_image_location = $_SERVER['DOCUMENT_ROOT']."/consultortic/apoyos/";
$gallery_upload_path = $_SERVER['DOCUMENT_ROOT']."/consultortic/apoyos/";

$IdVideo = $_REQUEST['IdVideo'];

if (isset($_POST["upload"]))
{
 $IdVideo = $_POST['IdVideo'];
 
 $extensionesPermitidas = array("jpg","jpeg","gif","png","jpg","jpeg","gif","png"); 
 
 //Get the file information
 //loop
 for($i=0;$i<count($_FILES['image']['name']);$i++)
 {
  $userfile_name = $_FILES['image']['name'][$i];
  $userfile_tmp = $_FILES['image']['tmp_name'][$i];
  $userfile_size = $_FILES['image']['size'][$i];
  $filename = basename($_FILES['image']['name'][$i]);

  $file_ext = substr($filename, strrpos($filename, '.') + 1);	
  //Remove the Extension
  $filename_strip= substr($filename,0,strrpos($filename, '.'));	
  
  $filename_strip = "speaker_".$IdVideo;
  
  if((!empty($_FILES["image"]['name'][$i])) && ($_FILES['image']['error'][$i] == 0))
  {
   if (!in_array($file_ext,$extensionesPermitidas)) 
   {
    $error= "Extension no permitida. Solamente se permiten imagenes.";
   }
   else
   {
    //Everything is ok, so we can upload the image.
    if (strlen($error)==0)
    {
     if (isset($_FILES['image']['name'][$i]))
     {
      //check if image exists
      if(is_file($gallery_upload_path.$userfile_name))
      {
       while (file_exists($gallery_upload_path .$filename_strip.".".$file_ext))
       {
        unlink($gallery_upload_path .$filename_strip.".".$file_ext);
       }
      }
      $filename=$filename_strip.".".$file_ext;
      $large_image_location=$gallery_upload_path .$filename;
      move_uploaded_file($userfile_tmp, $large_image_location);
      @chmod($large_image_location, 0777);
      //save in db
      $link = mysql_connect($_SESSION["servidor"], $_SESSION["root"],$_SESSION["claveBD"]);
      mysql_select_db($_SESSION["basededatos"], $link); 
      $query="update videos set urlpic = '$filename' where Idvideo = $IdVideo";
      $r= mysql_query($query)or die(mysql_error()."Error ".$query);
     } //for loop
     $msg = "Foto Subida con Exito.";
    }    
   }
  } 
 }
}

//Display error message if there are any
if(strlen($error)>0)
{
  echo "<p>".$error."</p>";
}
else echo "<p>".$msg."</p>";

if ($_GET['IdVideo']){ ?>
 <h3>Subir Archivos (Se permiten imagenes, JPG o GIF).</h3>
 <fieldset>
 <form name="photo" enctype="multipart/form-data" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
 Foto: <input type="file" name="image[]" size="30" /><br /><br />
 <input type="hidden" name="IdVideo" value="<?=$_GET['IdVideo'];?>" />
 <input type="submit" name="upload" value="Upload" />

 </form>
 </fieldset>

<?php
}
?>

</body>
</html>