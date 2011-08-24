<?php

include("../conexion.php");
include("../clases/clsVideos.php");

session_start();
$objVideos=new clsVideos();

// This started out as this — http://www.evoluted.net/community/code/directorylisting.php
// It was then edited by Ryan McCue from http://cubegames.net/ to include file uploading
// Then I took it and stripped it back to it's bare minimum of less than 150 lines of 
// PHP and HTML and just 20 lines of CSS. My name is Jim Whimpey and you can
// find me at valhallaisland.com

// This code is released under GPL 3.0 which is included in the bundle

// Files to hide in the directory listing
// add and subtract as you please
$hide = array(	'resources',
		'index.php',
		'.htaccess',
		'.htpasswd',
		'.DS_Store');
		
error_reporting(E_ERROR);

// When downloading force it to actually download
// rather than just open it in the browser
if ($_GET['download']) {
	$file = str_replace('/', '', $_GET['download']);
	$file = str_replace('..', '', $file);

	if (file_exists($file)) {
		header("Content-type: application/x-download");
		header("Content-Length: ".filesize($file)); 
		header('Content-Disposition: attachment; filename="'.$file.'"');
		readfile($file);
		die();
	}
}

$filepath = $_SERVER['SCRIPT_FILENAME'];
$scriptname = basename($filepath);
$readpath = str_replace($scriptname, "", $filepath);
$handle = opendir($readpath);

// If deleting
if (isset($_GET['rmfile'])) {
	unlink($readpath . $_GET['rmfile']);

//Delete from database
$objVideos->BorrarMaterialApoyo($_GET['rmfile']);
	
}

// If uploading
if ($_FILES['file']) {
	$success = move_uploaded_file($_FILES['file']['tmp_name'], $_FILES['file']['name']);
}

while ($file = readdir($handle)) { 
	
	if ($file == "." || $file == ".." || in_array($file, $hide))  continue;
	
	$key = @filemtime($file);
	
	$files[$key] = $file;
	
}

closedir($handle); 

// Sort our files
@ksort($files, SORT_NUMERIC);
$files = @array_reverse($files);

?>

<!DOCTYPE html>
<html>

	<head>
		<title>File Manager</title>
		<link rel="stylesheet" type="text/css" href="resources/styles.css" />
	</head>
	<body>
		<div align="center"><b>Archivos Disponibles</b><br/><br/></div>
		<?php $baseurl = $_SERVER['PHP_SELF']; ?>
		<table border="0" width="100%">
		<td><b>&nbsp;</b></td>	
		<td><b>Nombre</b></td>	
		<td><b>Tamaño</b></td>	
		<td><b>Fecha Creacion</b></td>	
		<td><b>Videos</b></td>	
		<td><b>&nbsp;</b></td>	
		<?php
			$arsize = sizeof($files);
			for ($i=0; $i<$arsize; $i++)
			{
			
				$ext = strtolower(substr($files[$i], strrpos($files[$i], '.')+1));
				$filename = stripslashes($files[$i]);
				$fileurl = $files[$i];
				if (strlen($filename) > 43) {
					$filename = substr($files[$i], 0, 40) . '...';
				}
		
				$es_pic = '';
				$pic = 'speaker_';
				$es_pic = stristr($filename, $pic); 
				if(strlen($es_pic) == 0)
				{				
				?>
				<tr>
					<td><img src="resources/docs.png" /></td>
					<td><a href="./index.php?download=<?php echo $filename; ?>"><?php echo $filename; ?></a></td>
					<td><?php echo round(filesize($leadon.$files[$i])/1024); ?>KB</td>
					<td><?php echo date ("d/m/y", filemtime($leadon.$files[$i]));?></td>
					<td>
					<?php
						$RSresultado = $objVideos->ConsultarMaterialApoyoVideo($filename);
						
						if(mysql_num_rows($RSresultado) > 0)
						{
							while ($rowFile = mysql_fetch_array($RSresultado))
							{
								$Descripcion=$rowFile["descripcion"].'<br />';	
								
							}							
						}
						else
						{
							$Descripcion = "No asociado";
							
						}
						echo $Descripcion;
					?>
					</td>
					<td><a href="./index.php?rmfile=<?php echo $filename;?>" onclick="return confirm('Seguro que desea borrar?')" >Delete</a></td>
				</tr>
			<?php }
			
			}?>
		
		</table>

		<!--<div id="upload">-->
		<!--	<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data">-->
		<!--		<p><input type="file" name="file" /></p>-->
		<!--		<p><input type="submit" value="Upload" /></p>-->
		<!--	</form>-->
		<!--</div>-->
	</body>
	
</html>
