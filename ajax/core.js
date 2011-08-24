function nuevoAjax()
{ 
	/* Crea el objeto AJAX. Esta funcion es generica para cualquier utilidad de este tipo, por
	lo que se puede copiar tal como esta aqui */
	var xmlhttp=false; 
	try 
	{ 
		// Creacion del objeto AJAX para navegadores no IE
		xmlhttp=new ActiveXObject("Msxml2.XMLHTTP"); 
	}
	catch(e)
	{ 
		try
		{ 
			// Creacion del objet AJAX para IE 
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); 
		} 
		catch(E) { xmlhttp=false; }
	}
	if (!xmlhttp && typeof XMLHttpRequest!='undefined') { xmlhttp=new XMLHttpRequest(); } 

	return xmlhttp; 
}

function traerDatos(grupo,nombre)
{
	// Obtendo la capa donde se muestran las respuestas del servidor
	var capa=document.getElementById("apDiv1");
	// Creo el objeto AJAX
	var ajax=nuevoAjax();
	// Coloco el mensaje "Cargando..." en la capa
	capa.innerHTML="Cargando...";
	// Abro la conexión, envío cabeceras correspondientes al uso de POST y envío los datos con el método send del objeto AJAX
	ajax.open("POST", "filtrarUsuario.php", true);
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	ajax.send("grupoId="+grupo+"&nombreUsu="+nombre);
	ajax.onreadystatechange=function()
	{
		if (ajax.readyState==4)
		{
			// Respuesta recibida. Coloco el texto plano en la capa correspondiente
			capa.innerHTML=ajax.responseText;
		}
	}
}
function invocaGenericoPost(nombreDiv,pagina,parametros,mensaje)
{
	// Obtendo la capa donde se muestran las respuestas del servidor
	var capa=document.getElementById(nombreDiv);
	// Creo el objeto AJAX
	var ajax=nuevoAjax();
	// Coloco el mensaje "Cargando..." en la capa
	//capa.innerHTML=mensaje;
	capa.innerHTML="<img src='ajax/ajax-loader.gif' alt='Cargando...' title='" + mensaje + "' />";	
	// Abro la conexión, envío cabeceras correspondientes al uso de POST y envío los datos con el método send del objeto AJAX
	ajax.open("POST", pagina, true);
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	ajax.send(parametros);
	ajax.onreadystatechange=function()
	{
		if (ajax.readyState==4)
		{
			// Respuesta recibida. Coloco el texto plano en la capa correspondiente
			capa.innerHTML=ajax.responseText;
		}
	}
}
