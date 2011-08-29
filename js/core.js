function validarExamen()
{
	var resp;
	resp=confirm("Si está seguro de sus respuestas por favor haga click en Aceptar, de lo contrario haga las correcciones necesarias para proceder.");
	if(resp)
	{
		return true; 
	}
	else
	{
		return false; 
	}
}

function validarNuevoUsuario()
{
	if(document.formProceso.valorNombre.value=="")
	{
		alert("Ingrese el nombre");
		return false; 
	}

	if(document.formProceso.valorLogin.value=="")
	{
		alert("Ingrese el login");
		return false; 
	}

	if(document.formProceso.valorClave.value=="")
	{
		alert("Ingrese la clave");
		return false; 
	}
	return true;
}

function validaRespModuloTall()
{
	if(document.formProceso.valorResp.value=="")
	{
		alert("Ingrese la respuesta");
		return false; 
	}
	return true;
}

function validaPreguntaTaller()
{
	if(document.formProceso.valorPregunta.value=="")
	{
		alert("Ingrese la pregunta");
		return false; 
	}	
	return true;
}

function validarModulos()
{
	if(document.formProceso.valorTitulo.value=="")
	{
		alert("Ingrese el nombre del modulo");
		return false; 
	}
	if(document.formProceso.valorNotaMax.value=="")
	{
		alert("Ingrese la calificiación máxima");
		return false; 
	}
	if(isNaN(document.formProceso.valorNotaMax.value))
	{
		alert("Calificación máxima invalida");
		return false; 
	}
	if(parseInt(document.formProceso.valorNotaMax.value)<=0)
	{
		alert("Calificación máxima invalida");
		return false; 
	}
	if(document.formProceso.valorNotaMIn.value=="")
	{
		alert("Ingrese la calificiación mínima de aprobación");
		return false; 
	}
	if(isNaN(document.formProceso.valorNotaMIn.value))
	{	
		alert("Calificación mínima de aprobación invalida");
		return false; 
	}
	if(parseInt(document.formProceso.valorNotaMIn.value)<=0)
	{
		alert("Calificación mínima de aprobación invalida");
		return false; 
	}
	if(parseInt(document.formProceso.valorNotaMIn.value)>=parseInt(document.formProceso.valorNotaMax.value))
	{
		alert("Calificación mínima de aprobación no puede ser mayor ni igual a la calificación máxima");
		return false; 
	}
	return true;	
}

function validarTaller()
{
	if(document.formProceso.valorTitulo.value=="")
	{
		alert("Ingrese el nombre del taller");
		return false; 
	}
	return true;	
}

function BotonDerecho(e)
{
  var mensaje = "Función desactivada.";
  if (navigator.appName == 'Netscape' && e.which == 3)
	{
		alert(mensaje);
    return false;
  }
	else if (navigator.appName == 'Microsoft Internet Explorer' && event.button == 2)
	{
		alert(mensaje);
		return false;
  }
  return true
}

//Netscape: para que capture TODOS los eventos de este
//tipo dentro del documento, hay que añadir esto
if (navigator.appName == 'Netscape') 
   document.captureEvents(Event.MOUSEDOWN);
	
document.onmousedown = BotonDerecho;
/////////////////////////////////////////////////////////////////////////////////////////////////
function validarRespSeleccionada(respuesta)
{
var resp;
resp=confirm("Desea seleccionar la respuesta Número "+respuesta+"?");

if(resp)
 {
	 //selecciono la respuesta
	 
	 //determinar si es valida
	 if(parseInt(document.formProceso.numeroCorrecta.value)==parseInt(respuesta))
	  {
	    //es correcta
		alert("La respuesta es corrécta");
	    document.formProceso.bien.value="S";
	  }
	 else
	  {
		alert("Es incorrecto. La respuesta erá la número: "+document.formProceso.numeroCorrecta.value);
	    document.formProceso.bien.value="N";
	  }
	 
	 //procesar el form
	 document.formProceso.numeroSeleccionado.value=respuesta;
	 formProceso.submit();	 
 }

}
/////////////////////////////////////////////////////////////////////////////////////////////////
function validarPresentarExamen()
{
var resp;
resp=confirm("Desea presentar el examen?");

if(resp)
 {
	 return true; 
 }
else
 {
	return false; 
 }
}
/////////////////////////////////////////////////////////////////////////////////////////////////

function validarBorrar()
{
var resp;
resp=confirm("Desea borrar el registro?");

if(resp)
 {
	 return true; 
 }
else
 {
	return false; 
 }
}
/////////////////////////////////////////////////////////////////////////////////////////////////
function validaPregunta()
{
if(document.formProceso.valorDetalle.value=="")	
 {
   alert("Ingrese el detalle");
   return false;	 
 }

return true;	
}
/////////////////////////////////////////////////////////////////////////////////////////////////
function validaExamen()
{
if(document.formProceso.valorTitulo.value=="")	
 {
   alert("Ingrese el titulo");
   return false;	 
 }

if(document.formProceso.valorPreguntas.value=="")	
 {
   alert("Ingrese el número de preguntas que aplica en la prueba");
   return false;	 
 }

if(isNaN(document.formProceso.valorPreguntas.value))	
 {
   alert("El número de preguntas que aplica en la prueba es invalido");
   return false;	 
 }

if(parseInt(document.formProceso.valorPreguntas.value)<=0)	
 {
   alert("El número de preguntas que aplica en la prueba es invalido");
   return false;	 
 }

if(document.formProceso.valorCalificacion.value=="")	
 {
   alert("Ingrese la calificación");
   return false;	 
 }

if(isNaN(document.formProceso.valorCalificacion.value))	
 {
   alert("La calificacion es invalida");
   return false;	 
 }

if(parseInt(document.formProceso.valorCalificacion.value)<=0)	
 {
   alert("La calificacion es invalida");
   return false;	 
 }


return true;	
	
}

function validaCambioClave()
{
if(document.formProceso.valorClave.value=="")	
 {
   alert("Ingrese la clave");
   return false;	 
 }

return true;	
}

function validaAcceso()
{
if(document.formProceso.valorLogin.value=="")	
 {
   alert("Ingrese el login");
   return false;	 
 }
if(document.formProceso.valorClave.value=="")	
 {
   alert("Ingrese la clave");
   return false;	 
 }

return true;
}


