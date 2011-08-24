<?php
include("dhtmlgoodies_tree.class.php");
include("conexion.php");
//include("clases/clsusuario.php");
//include("clases/clsSubGrupo.php");
include("clases/clsPermisos.php");
$objCategorias=new clsusuario();
$objSubGrupo=new clsSubGrupo();
$objPermisos=new clsPermisos();

$IdUsuario=$_SESSION["idusuario"];

           $tree = new dhtmlgoodies_tree();	// Creating new tree object
		   //Categorias
		   $RSresultado=$objCategorias->consultarCategorias();
		   while ($row = mysql_fetch_array($RSresultado))
			 {
			 $IdCategorias=$row["IdCategorias"]; 
				$activo=$objPermisos->Consulta_Categoria($IdUsuario,$IdCategorias);
				if ($activo>0){
						   
			 			 $tree->addToArray($IdCategorias, $row["categorias"],0,"");
						  //Grupos
						  $RSresultadoGrupos=$objCategorias->consultarGrupos($IdCategorias);
			    		   while ($rowGrupos = mysql_fetch_array($RSresultadoGrupos))
				     			 {
								 $IdGrupos=$rowGrupos["IdGrupos"]; 
								 $grupos=$rowGrupos["grupos"]; 
									  $activo=$objPermisos->Consulta_Grupo($IdUsuario,$IdGrupos);
									  if ($activo>0){

										   $tree->addToArray($IdCategorias.$IdGrupos,$grupos,$IdCategorias,"consultainfo.php?IdGrupos=".$IdGrupos,"marco");
										   //subGrupos
										  $RSSubGrupo=$objSubGrupo->consultarSubGrupos($IdGrupos);
										       while ($rowSubGrupo = mysql_fetch_array($RSSubGrupo))
										              {
														$IdSubGrupo=$rowSubGrupo["IdSubGrupo"]; 
														$NombreSubGrupo=$rowSubGrupo["NombreSubGrupo"]; 
														$activo=$objPermisos->Consulta_Subgrupo($IdUsuario,$IdSubGrupo);
										                    if ($activo>0){
															   
													          $tree->addToArray($IdCategorias.$IdGrupos.$IdSubGrupo,$NombreSubGrupo,$IdCategorias.$IdGrupos,"consultainfo.php?IdSubGrupo=".$IdSubGrupo,"marco","images/dhtmlgoodies_sheet.gif");
										                     }// if subgrupos
							                         }
						             }//if grupos
					          }
				}//if categorias
		  }

?>	