<?
include("../conexion.php");
include("../clases/clsSubGrupo.php");
include("../clases/clsVideos.php");
include("../clases/clsusuario.php");

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
$objUsuario=new clsusuario();
$objSubGrupo=new clsSubGrupo();
$objVideos=new clsVideos();
$msg="";

extract($_GET);

if($_POST["ingresar"]!="")
 {
 
 if (isset($_POST["IdSubGrupo"])){
     $objVideos->ingresarVideos
				 ($_POST["UrlVideo"],
				  $_POST["estado"],
				  $_POST["IdSubGrupo"],
				  $_POST['fecha'],
				  $_POST['visita'],
				  $_POST['nombre'],
				  $_POST['DescVideo'],
				  $_POST['PresVideo'],
				  $_POST['DurVideo'],
				  $_POST['OrdVideo']
				  );
    }
	else{
	 $objVideos->ingresarVideosGrupos
				 ($_POST["UrlVideo"],
				  $_POST["estado"],
				  $_POST["IdGrupos"],
				  $_POST['fecha'],
				  $_POST['visita'],
				  $_POST['nombre'],
				  $_POST['DescVideo'],
				  $_POST['PresVideo'],
				  $_POST['DurVideo'],
				  $_POST['OrdVideo']
				  );
	}
	$msg="Registro ingresado";
 }

///actualizar
if($_POST["actualizar"]!="")
 {
    $objVideos->actualizarVideo
				($_POST["actualizar"],
				 $_POST["UrlVideo"],
				 $_POST["estado"],
				 $_POST['fecha'],
				 $_POST['visita'],
				 $_POST['nombre'],
				 $_POST['DescVideo'],
				 $_POST['PresVideo'],
				 $_POST['DurVideo'],
				 $_POST['OrdVideo']
				 );
				
    $msg="Registro actualizado";
 }


//informacion registro seleccionado
if($_GET["actualizar"]!="")
 {
 
   $RSresultado=$objVideos->ConsultarVideo($_GET["actualizar"]);
   while ($row = mysql_fetch_array($RSresultado))
     {
	  $vUrlVideo=$row["UrlVideo"]; 
	  $vestado=$row["estado"]; 
	  $IdSubGrupo=$row["IdSubGrupo"]; 
	  $vfecha=$row["fecha"]; 
	  $vvisita=$row["visita"]; 
	  $IdGrupos=$row["IdGrupos"]; 
	  $vnombre=$row["nombre"];
	  $vDescVideo = $row["descripcion"];
	  $vDurVideo = $row["duracion"];
	  $vPresVideo = $row["presentador"];
	  $vOrdVideo = $row["orden"];
     }
 }

if($_GET["borrar"]!="")
{
 $objVideos->borrarVideos($_GET["borrar"]);
 $msg="Registro borrado";
} 

if($_GET["Quitar"]!="" and $_GET["idVideo"]!="")
{
 $objVideos->quitarVideos($_GET["idVideo"],$_GET["Quitar"]);
 $url = "admvideos.php?actualizar=".$_GET["idVideo"]."";
 echo "<meta http-equiv='refresh' content='0;URL=$url'>";
} 

?>
<html>
<head>
<title>:: CUESTIONARIO ::</title>
<link rel="stylesheet" href="../css/INDEX.CSS">
<script language="javascript" src="../js/js.js">
</script>
<script language="javascript" src="../js/wforms.js">
</script>
</head>
<body leftmargin="0" topmargin="0" background="" > 
<table width="800" height="100%" align="center" cellpadding="0" cellspacing="0">

 <tr>
  <td width="1"><img src="../imagenes/spacer.gif" width="1" height="1"></td>
  <td width="796" bgcolor="white" valign="top">
    <table width="100%" height="100%" cellpadding="0" cellspacing="0">
      <!-- banner superior -->
      <!-- menu superior -->
      <tr>
        <td class="body-text1"  height="20" align="right"> 
          <table width="100%" cellpadding="0" cellspacing="0">
            <tr>
              <td width="10"><img src="../imagenes/spacer.gif" width="1" height="1"></td>	   
              <td align="left">
                </td>
              <td class="body-text1" width="220">
                </td>
              <td width="10"><img src="../imagenes/spacer.gif" width="1" height="1"></td>
              </tr>
            </table>
          </td>
        </tr>
      
      
      <!-- zona central -->
      <tr>
        <td class="body-text1" valign="top">
          <table cellpadding="5" cellspacing="1" width="100%" height="100%">
            <tr>
              <td  height="1"><img src="../imagenes/spacer.gif" width="1" height="1"></td>
              </tr>
            <tr>
              <td class="body-text1" background="" valign="top" align="left">
                <table>
                  <tr>
                    <td class="body-text1" >&nbsp;</td>
                    <td class="body-text1" >| <a href="javascript:history.go(-1)" style="color:red">Regresar</a> </td>
                    </tr>
                  </table>
                <br>
                <b><?=$vvTitulo?>::<?=$vvgTitulo?>::    <?
			 if (isset($IdSubGrupo)){ echo "SubGrupos"; } else { echo "Grupos"; } ?>::Videos</b>   <br>
                
                <br>
                <form name="formProceso" action="admvideos.php?<? if (isset($IdSubGrupo)){ echo "IdSubGrupo=".$IdSubGrupo; }else{ echo "IdGrupos=".$IdGrupos; }?>" method="post" onSubmit="return validarSubGrupo()">
                  <? 
		  if($_GET["actualizar"]!="")
		   {
		     ?>
                  <input type="hidden" name="actualizar" value="<?=$_GET["actualizar"]?>">
                  <? 
		   }
		  else
		   {
		     ?>
                  <input type="hidden" name="ingresar" value="1">
                  <? 
		   }
		  ?>
                  <table>
		  <?
		  if($_GET["actualizar"]!="")
		  {?>
		  <tr>
		  <td class="body-text1" valign="top">
		    Expositor: </td>
		  <td class="body-text1">
		   <?php
		   $spgur = "../apoyos/speaker_".$_GET["actualizar"].".jpg";
		   echo "<img src='$spgur'>";
		  ?>
		  </td>
		  </tr>
		  <?
		  }
		  ?>
                    <tr>
                      <td class="body-text1">
                        Nombre</td>
                      <td class="body-text1">
                        <input type="text" name="nombre" value="<?=$vnombre?>" maxlength="50" size="50" class="controles1">			</td>
                      </tr>
                    
                    <tr>
					 <td class="body-text1">
					  Url del	Video
					 </td>
					 <td class="body-text1">
					  <input type="text" name="UrlVideo" value="<?=$vUrlVideo?>" maxlength="255" size="100" class="controles1">
					 </td>
                    </tr>

                    <tr>
					 <td class="body-text1">
					  Descripcion del Video
					 </td>
					 <td class="body-text1">
					  <input type="text" name="DescVideo" value="<?=$vDescVideo?>" maxlength="255" size="100" class="controles1">
					 </td>
                    </tr>

                    <tr>
					 <td class="body-text1">
					  Duracion del Video <br /> (Ej: 1 hora)
					 </td>
					 <td class="body-text1">
					  <input type="text" name="DurVideo" value="<?=$vDurVideo?>" maxlength="255" size="100" class="controles1">
					 </td>
                    </tr>
                    
                    <tr>
                      <td class="body-text1">Activo</td>
                      <td class="body-text1">
                        <select name="estado" class="controles1 required" id="estado">
                          <option value="" selected>Seleccione</option>
                          <option value="1" <? if ($vestado==1){ ?> selected="selected" <? } ?>>SI</option>
                          <option value="0" <? if ($vestado==0){ ?> selected="selected" <? } ?>>NO</option>
                          </select>
                        </td>
                      </tr>
                    <tr>
                      <td class="body-text1">Fecha Limite</td>
                      <td class="body-text1"><input type="text" name="fecha" value="<?=$vfecha?>" maxlength="12" size="12" class="controles1">
                        (eje:2010-12-31) deje	en	blanco para indefinido	</td>
                      </tr>
                    <tr>
                      <td class="body-text1">Numero de vistas</td>
                      <td class="body-text1"><input type="text" name="visita" value="<?=$vvisita?>" maxlength="12" size="12" class="controles1">
                        deje	en	cero para indefinido </td>
                      </tr>
                    <tr>
					 
					<tr>
					 <td class="body-text1">
					  Datos del presentador <br /> Ej: John Doe - Gerente de Producto
					 </td>
					 <td class="body-text1">
					  <input type="text" name="PresVideo" value="<?=$vPresVideo?>" maxlength="255" size="100" class="controles1">
					 </td>
                    </tr>

					<tr>
					 <td class="body-text1">Orden del Video :</td>
					 <td class="body-text1">
					  <input type="text" name="OrdVideo" value="<?=$vOrdVideo?>" maxlength="2" size="2" class="controles1">
					 </td>
                    </tr>
		    <tr>
		     <td class="body-text1" valign="top">
					  Archivos Adjuntos:
					 </td>
		     <td class="body-text1">
		                             <?
 		       if($_GET["actualizar"]!="")
		       {
			$RSresultado_apoyo=$objVideos->ConsultarMaterialApoyo($_GET["actualizar"]);
			while ($row_apoyo = mysql_fetch_array($RSresultado_apoyo))
			{
			 $vIdArchivo = $row_apoyo["IdArchivo"];
			 $vIdVideo = $row_apoyo["IdVideo"];
			 $vNombreArchivo = $row_apoyo["NombreArchivo"];
			 echo $vNombreArchivo." |  <a href='admvideos.php?idVideo=$vIdVideo&Quitar=$vIdArchivo' onclick=\"return confirm('Seguro que desea borrar?')\" target='_self'>Quitar</a><br/><br/>";
			}
		       }
		       ?>
		     </td>
		     </tr>
                      <td colspan="2" align="right" class="body-text1">
                        
                        <? if (isset($IdSubGrupo)){ ?>
                        <input type="hidden" value="<?=$IdSubGrupo?>" name="IdSubGrupo">
                        <? }else{ ?>
                        <input type="hidden" value="<?=$IdGrupos?>" name="IdGrupos">
                        <? } ?>
                        


			
                        <input type="image" src="../imagenes/ingresar.jpg"><a href="<?=$_SERVER['PHP_SELF']?>">
						<img src="../imagenes/cancelar.jpg" alt="borrar" border="0" /></a>
                        <br><br>
                        <?=$msg?>
						</td>
                      </tr>
                    </table>
                  </form>
                <br>
                <table border="1" bordercolor="D4D4D4" cellpadding="5" cellspacing="0" width="83%">
                  <tr bgcolor="D4D4D4" >
                    <td width="74%" class="body-text1">
                      Nombre			</td>
					<td class="body-text1" width="7%">Borrar</td>
                    <td class="body-text1" width="11%">Subir Material</td>
                    <td class="body-text1" width="11%">Subir Foto Expositor</td>
                    <td class="body-text1" width="11%">Activo</td>
                    <td class="body-text1" width="11%">Orden</td>					
                    <td width="15%"  align="center" class="body-text1">
                      Cuestionario	</td>
                    
                    <?
			 if (isset($IdSubGrupo)){ 
			   $RSresultado=$objVideos->ConsultarVideos($IdSubGrupo);
		       }else{
			    $RSresultado=$objVideos->ConsultarVideosGrupos($IdGrupos);
			   }
			    while ($row = mysql_fetch_assoc($RSresultado))
			 {
			extract($row);
			  ?> 
                    <tr bgcolor="white" >
                      <td valign="top" class="body-text1"><a href="admvideos.php?actualizar=<?=$Idvideo?>&<? if (isset($IdSubGrupo)){ echo "IdSubGrupo=".$IdSubGrupo; }else{ echo "IdGrupos=".$IdGrupos; }?>" style="color:red "><?=$nombre?></a>				                </td>
                      <td valign="top" class="body-text1">
					  <?php
					  if (isset($IdSubGrupo)){ 
					  ?><a href="admvideos.php?borrar=<?=$Idvideo?>&IdSubGrupo=<?=$IdSubGrupo?>" style="color:red " onclick="return confirm('Seguro que desea borrar?')" >Borrar</a><?php
					  }elseif(isset($IdGrupos)){
					  ?><a href="admvideos.php?borrar=<?=$Idvideo?>&IdGrupos=<?=$IdGrupos?>" style="color:red " onclick="return confirm('Seguro que desea borrar?')" >Borrar</a><?php
					  }
					  ?>
                     <td valign="top" class="body-text1">
					 <a href="subirmaterial.php?IdVideo=<?=$Idvideo ?>" style="color:red" target="_blank">Subir</a>
					 </td>
                     <td valign="top" class="body-text1">
					 <a href="subirspeaker.php?IdVideo=<?=$Idvideo ?>" style="color:red" target="_blank">Subir</a>
					 </td>
					  </td>
					  <td width="11%" valign="top" class="body-text1"><?
					  
					  if ($estado==1) echo "<img src='../imagenes/iconos/ok.gif'>";
					  else echo "<img src='../imagenes/iconos/delete.gif'>";
					  
					  
					  ?></td>
					  <td width="11%" valign="top" class="body-text1"><?=$orden?></td>
                      <td class="body-text1"  align="center" valign="top"><a href="admmodulos.php?<? if (isset($IdSubGrupo)){ echo "IdSubGrupo=".$IdSubGrupo; }else{ echo "IdGrupos=".$IdGrupos; }?>&Idvideo=<?=$Idvideo?>"><img src="../imagenes/iconos/ok.png" border="0"></a></td>
                    </tr>
				  <? } ?>
                  </table>
                <br><br>
                </td>
              </tr>
            <tr>
              <td  height="10"><img src="../imagenes/spacer.gif" width="1" height="1"></td>
              </tr>
            </table>
          </td>
        </tr>
      <!-- footer -->
      </table>
  </td>
  <td width="1"><img src="../imagenes/spacer.gif" width="1" height="1"></td>
 </tr>
 <tr>
  <td colspan="3" height="50"><img src="../imagenes/spacer.gif" width="1" height="1"></td>
 </tr>
</table>
</body>
</html>