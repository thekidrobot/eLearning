<?
include("includes/connection.php");
include("clases/clsexamen.php");

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


//validar id examen
if($_GET["IdExamen"]=="")
 {
  ?>
  <script language="javascript">
  document.location="listaexamenes.php";
  </script>
  <?
 }
 
///objetos
$objExamen=new clsexamen();

//informacion del examen
if($_GET["IdExamen"]!="")
 {
   $RSresultado=$objExamen->consultarDetalle($_GET["IdExamen"]);
   while ($row = mysql_fetch_array($RSresultado))
	 {
	  $vTitulo=$row["Titulo"]; 
	  $totalPReguntasAEvaluar=$row["Preguntas"]; 
	  $vCalificacion=$row["Calificacion"]; 
     }
 }





//procesar la respuesta seleccionada
if($_POST["ingresar"]!="")
 {
   //incrementar la pregunta actual
   $_SESSION["indicePreguntas"]=$_SESSION["indicePreguntas"]+1;
   
   //incrementar el numero de preguntas evaluadas
   $_SESSION["totalPreguntasEvaluadas"]=$_SESSION["totalPreguntasEvaluadas"]+1;
   
   //sumatoria de respuestas validas 

   $valorPunto=$vCalificacion/$totalPReguntasAEvaluar;				//VALOR DE CADA PUNTO

   if($_POST["bien"]=="S")
    {
	  //la respuesta es correcta
	  $_SESSION["totalPuntos"]=$_SESSION["totalPuntos"]+$valorPunto;
	}
 }

 

//generar las preguntas aleatorias::  (Lo hace la primera vez que carga la pagina)
if($_SESSION["indicePreguntas"]=="")
 {
    //indice del arreglo que almacena los id de las preguntas ya evaluadas
    $_SESSION["indicePreguntas"]="0";

    //almacena el total de preguntas ya evaluadas
    $_SESSION["totalPreguntasEvaluadas"]=0;
   
    ///almacena los puntos alcanzados
    $_SESSION["totalPuntos"]=0;   

    //conseguir las preguntas aleatorias para la prueba
	//conseguir el total de preguntas que tiene el examen
	$totalPReguntasExamen=$objExamen->consultarTotalPreguntasExamen($_GET["IdExamen"]);
	
	if($totalPReguntasExamen<$totalPReguntasAEvaluar)
	 {
	   //el numero de preguntas a evaluar es menor al total de preguntas existentes en el examen
	   ?>
	   <script language="javascript">
	   alert("El examen no tiene el número de preguntas suficientes. Por favor contacte al administrador del sistema.");
	   document.location="listaexamenes.php";
	   </script>
	   <?
	 }
	
	$indice=0;
	while($indice<$totalPReguntasAEvaluar)
	 {
	   $preguntaAleatoria = rand(1,$totalPReguntasExamen);
	   $existe=0;
	   $indice2=0;
	   for($indice2=0;$indice2<$indice;$indice2++)
		{
		  if($arrPreguntasAleatorias[$indice2]==$preguntaAleatoria)
		   {
			 //ya existe la pregunta en el arreglo
			 $existe=1;
		   }
		}
	   
	   if($existe==0)
		{
		  //no existe la pregunta en el arreglo
		  $arrPreguntasAleatorias[$indice]=$preguntaAleatoria;
		  $indice++;
		}
	 }
	
	//guardar en sesion las preguntas selccionadas
	$_SESSION["listaPreguntas"]=$arrPreguntasAleatorias;
 }



//determinar si ya se evaluaron todas las preguntas
$terminar=0;

if($_SESSION["totalPreguntasEvaluadas"]<$totalPReguntasAEvaluar)
 {
	//recuperar las lista de preguntas guardadas en sesion
	$arrPreguntasAleatorias2=$_SESSION["listaPreguntas"];
	
	//conseguir el id de la pregunta actual
	$RSresultado=$objExamen->consultarPreguntasExamen($_GET["IdExamen"]);
	$IdPreguntaSeleccionada=0;
	$contador=1;
	while ($row = mysql_fetch_array($RSresultado))
	 {
	   $IdPregunta=$row["IdPregunta"]; 
	   
	   if($contador==$arrPreguntasAleatorias2[$_SESSION["indicePreguntas"]])
		{
		  //id de la pregunta actual
		  $IdPreguntaSeleccionada=$IdPregunta;
		}
	   
	   $contador++;
	 }
	
	//conseguir informacion de la pregunta
	$RSresultado=$objExamen->consultarDetallePregunta($IdPreguntaSeleccionada);
	while ($row = mysql_fetch_array($RSresultado))
	 {
	   $DetallePregunta=$row["DetallePregunta"]; 
	 }
 }
else
 {
  //ya termino de evaluar las preguntas
  $terminar=1;
 }

?>
<html>
<head>
<title>:: CUESTIONARIO ::</title>
<link rel="stylesheet" href="INDEX.CSS">
<script language="javascript" src="js.js">
</script>
</head>
<body leftmargin="0" topmargin="0" background="imagenes/fondo2.jpg" > 
<table width="100%" height="100%" cellpadding="0" cellspacing="0">

 <tr>
  <td width="104"><img src="imagenes/spacer.gif" width="1" height="1"></td>
  <td width="16" background="imagenes/fondo3.jpg"></td>
  <td width="751" bgcolor="white" valign="top">
   <table width="100%" height="100%" cellpadding="0" cellspacing="0">
    <!-- banner superior -->
    <tr>
	 <td class="body-text1" height="120"><img src="imagenes/titulo.jpg" width="751" height="120"></td> 
	</tr>

    <!-- menu superior -->
    <tr>
	 <td class="body-text1"  height="20" align="right"> 
	  <table width="100%" cellpadding="0" cellspacing="0">
	   <tr>
		<td width="10"><img src="imagenes/spacer.gif" width="1" height="1"></td>	   
	    <td align="left">
		</td>
	    <td class="body-text1" width="220">
		</td>
	    <td width="10"><img src="imagenes/spacer.gif" width="1" height="1"></td>
	   </tr>
	  </table>
	 </td>
	</tr>
	

    <!-- zona central -->
    <tr>
	 <td class="body-text1" valign="top">
	  <table cellpadding="5" cellspacing="3" width="100%" height="100%">
	   <tr>
	    <td  height="1"><img src="imagenes/spacer.gif" width="1" height="1"></td>
	   </tr>
	   <tr>
		<td class="body-text1"  valign="top" align="left">
		 <b>:: Examen :</b>
		 <br><br>
		 <?=$vTitulo?>
		 <br><br><br><br>
		 
		 <?
		 if($terminar==0)
		  {
		   //hay preguntas por evaluar
		 ?> 
			 <?=$DetallePregunta?>
			 <br><br>
			 <form name="formProceso" action="presentarexamen.php?IdExamen=<?=$_GET["IdExamen"]?>" method="post">
			 <input type="hidden" name="ingresar" value="1">
			 <table border="1" bordercolor="D4D4D4" cellpadding="5" cellspacing="0" width="100%">
			   <tr bgcolor="D4D4D4" >
				<td class="body-text1" width="40%" colspan="2">
				  Respuesta
				</td>
				<td class="body-text1"  align="center">
				  Seleccionar
				</td>
			   <tr>
	
			   <?
			   $RSresultado=$objExamen->consultarRespuestasPregunta($IdPreguntaSeleccionada);
			   $numero=1;
			   $respuesta=0;
			   
			   while ($row = mysql_fetch_array($RSresultado))
				 {
				  $IdRespuesta=$row["IdRespuesta"]; 
				  $Correcta=$row["Correcta"]; 
				  
				  if($Correcta=="1")
				   {
					//es la respuesta correcta, almacena el numero de la pregunta
					$respuesta=$numero;
				   }
				   
				  ?> 
				   <tr bgcolor="white" >
					<td class="body-text1" width="4%" align="center">
					  <?=$numero?>
					</td>
					<td class="body-text1" width="90%">
					  <?=$row["DetalleRespuesta"]?>
					</td>
					<td class="body-text1"  align="center">
					 <img src="imagenes/iconos/ok.gif" onClick="validarRespSeleccionada('<?=$numero?>')">
					</td>
				   <tr>
				  <?
				  $numero++;
				 }
			   ?>
			 </table>
			 <input type="hidden" name="numeroCorrecta" value="<?=$respuesta?>">
			 <input type="hidden" name="numeroSeleccionado" value="0">
			 <input type="hidden" name="bien" value="0">
			 </form>
		 
		 <?
		  }
		 else
		  {
		   //fin de la prueba
		   $notaFinal=$_SESSION["totalPuntos"];
		   $NotaObtenida=round($notaFinal * 100) / 100;
		   
		  ?>
		   Prueba terminada.<br><br>
		   <b>Calificación :<?=$NotaObtenida?> sobre <?=$vCalificacion?></b>
		   <br><br>
		   <a href="listaexamenes.php" style="color:red ">Lista de examenes</a>
		  <?
		  
		   //guardar los puntos obtenidos (guardar la nota obtenida)
		   $objExamen->ingresarPuntosPrueba($_SESSION["idusuario"],$_GET["IdExamen"],$_SESSION["totalPuntos"],$vCalificacion);
		  }
		 ?>
		 
		</td>
	   </tr>
	   <tr>
	    <td  height="10"><img src="imagenes/spacer.gif" width="1" height="1"></td>
	   </tr>
	  </table>
	 </td>
	</tr>
	<!-- footer -->
    <tr>
	 <td  background="imagenes/seccion.jpg" class="body-text1" height="20" align="center">
	 </td>
	</tr>
   </table>
  </td>
  <td width="13" background="imagenes/fondo4.jpg">
  </td>
  <td><img src="imagenes/spacer.gif" width="1" height="1"></td>
 </tr>
 <tr>
  <td colspan="5" height="50"><img src="imagenes/spacer.gif" width="1" height="1"></td>
 </tr>
</table>
</body>
</html>
