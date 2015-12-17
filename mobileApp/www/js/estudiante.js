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
    cargarCalificadoresCurso();
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
        "mobile" : 'calificacionAsesoria',
        "codigo" : localStorage.getItem("CodigoUsuario")
    };
    peticionAsincrona("get", false, null, parametros, construirCalificadores, function(){}); 
}
function construirCalificadores(response){
	if(response=="ok"){
    	try{
    		$("#calificaciones").html("<div data-role='collapsible'><h4>No hay calificaciones pendientes</h4></div>").collapsibleset("refresh")
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
function cargarCalificadoresCurso(){
    var parametros = {
        "mobile" : 'calificacionCurso',
        "codigo" : localStorage.getItem("CodigoUsuario")
    };
    peticionAsincrona("get", false, null, parametros, construirCalificadores, function(){}); 
}
function construirCalificadoresCurso(response){
    if(response=="ok"){
        try{
            $("#calificacionesCursos").html("<div data-role='collapsible'><h4>No hay calificaciones de cursos pendientes</h4></div>").collapsibleset("refresh")
        }catch(e){}
    }else{
        var data = JSON.parse(response);
        var struct = "";
        for(var val in data){
            struct += "<div data-role='collapsible'><h4>"+data[val].materia+" - "+data[val].tema+ " - " + data[val].amigo +" - "+ data[val].fecha+"</h4><button class='ui-btn' onclick=\"popupCalificarCurso('"+data[val].id+"')\">Calificar Esta asesoría</button></div>";
        }
        try{
            $("#calificacionesCursos").html(struct).collapsibleset("refresh")
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

/**
*   Abre el dialogo para calificar una asesoria
*/
function popupCalificarCurso (value) {
    $("#calificacionIDCurso").val(value)
    $( ":mobile-pagecontainer" ).pagecontainer( "change", "#popupCalificacionCurso", { 
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
   		"mobile" : 'registrarCalificacionAsesoria',
        "idAsesoria" : $("#calificacionID").val(),
        "puntaje" : $("#puntaje").val(),
        "comentario" : $("#comentario").val(),
        "estudiante" : localStorage.getItem("CodigoUsuario")
    };
    peticionAsincrona("post", false, null, parametros, calificacionExitosa, errorDeRed); 
 	return false;
});

 $('#calificacionCursoForm').submit(function() {  
    var parametros = {
        "mobile" : 'registrarCalificacionCurso',
        "idAsesoria" : $("#calificacionIDCurso").val(),
        "puntaje" : $("#puntajeCurso").val(),
        "comentario" : $("#comentarioCurso").val(),
        "estudiante" : localStorage.getItem("CodigoUsuario")
    };
    peticionAsincrona("post", false, null, parametros, calificacionExitosa, errorDeRed); 
    return false;
});