/**
*   Libreria con utilidades para estudiantes
*   @author Gerson Lázaro - Melissa Delgado - Daniel Vega
*   @date 15-12-2015
*/

/**
*   Inicializa datos desde la BD
*/
$( document ).ready(function() {
  	inicializar();
});

function inicializar () {
    verificarSesion();
    cargarHorario();
    cargarTemas();
    cargarCursos();
    cargarCalificadores();
}


/**
*	Sidebar exclusivos de la vista estudiante
*/
swipeSidebar("calificacionScreen", "sidebar4");


/**
*	Calificación de las asesorias recibidas
*/
function cargarCalificadores(){
	var parametros = {
        "mobile" : 'calificacion',
        "codigo" : localStorage.getItem("CodigoUsuario")
    };
    peticionAsincrona("get", false, null, parametros, construirCalificadores, function(){}); 
}
function construirCalificadores(response){
	if(response=="ok"){
    	try{
    		$("#calificaciones").html("<div data-role='collapsible'><h4>No hay calificaciones pendientes</h4><p>Vuelve mas tarde.</p></div>").collapsibleset("refresh")
    	}catch(e){}
    }else{
    	var data = JSON.parse(response);
    	var struct = "";
    	for(var val in data){
    		struct += "<div data-role='collapsible'><h4>"+data[val].materia+" - "+data[val].tema+ " - " + data[val].amigo +" - "+ data[val].fecha+"</h4><button class='ui-btn' onclick=\"popupCalificar('"+data[val].id+"')\">Calificar Esta asesoría</button></div>";
    	}
    	try{
    		$("#calificaciones").html(struct).collapsibleset("refresh")
    	}catch(e){}
    }
}



/**
*	Abre el dialogo para calificar una asesoria
*/
function popupCalificar (value) {
	$("#calificacionID").val(value)
	$( ":mobile-pagecontainer" ).pagecontainer( "change", "#popupCalificacion", { 
    	role: "dialog"
    });
}

function calificacionExitosa(response){
	if(response=="error"){
        errorDeRed ();
    }else{
        cargarCalificadores();
        $( ":mobile-pagecontainer" ).pagecontainer( "change", "#successCalificacion", { 
   			role: "dialog"
	    });
    }
}


/**
*	EVENTOS
*/
$("#verifyAsesoria").click(cargarCalificadores)

/**
*	Envio de la calificación de una asesoría
*/

 $('#calificacionForm').submit(function() {  
 	var parametros = {
   		"mobile" : 'registrarCalificacion',
        "idAsesoria" : $("#calificacionID").val(),
        "puntaje" : $("#puntaje").val(),
        "comentario" : $("#comentario").val(),
        "estudiante" : localStorage.getItem("CodigoUsuario")
    };
    peticionAsincrona("pos", false, null, parametros, calificacionExitosa, errorDeRed); 
 	return false;
});
