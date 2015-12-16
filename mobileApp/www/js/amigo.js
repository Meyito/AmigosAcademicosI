/**
*	Libreria con utilidades para amigos académicos
*	@author Gerson Lázaro - Melissa Delgado - Daniel Vega
*	@date 15-12-2015
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
  	cargarMateriasRegistroAsesoria();
  	listarCursos();
}



/**
*	Sidebars propios de la interfaz para Amigos académicos
*/
swipeSidebar("registroAsesoriaScreen","sidebarRegistroAsesoria");
swipeSidebar("addAsistenteCursoScreen","sidebarAddAsistenteCurso");
swipeSidebar("registroCursoScreen","sidebarRegistroAsistenciaCurso");




/**
*	Carga el select con los Temas de una materia
*/
function cargarTemasRegistroAsesoria () {
	if($("#materiaAse").val() != "Seleccionar Materia"){
		peticionAsincrona("get", false, null, {"mobile" : 'cargarTemas',"materia" : $("#materiaAse").val()},construirTemasRA, errorDeRed);
	}else{
		$("#temaAse").selectmenu("disable");
	}	
}
function construirTemasRA (response) {
	var data = JSON.parse(response);
	var struct = "<option>Seleccionar Tema</option>";
	for(var val in data){
		struct += "<option value='"+val+"'>"+data[val]+"</option>";
	}		
	$("#temaAse").html(struct);
	try{
		$("#temaAse").selectmenu("enable");
		$("#temaAse").selectmenu("refresh", true);
	}catch(e){}
}



/**
*	Lista todos los cursos 
*/
function listarCursos () {
	peticionAsincrona("get", false, null, {"mobile" : 'listarCursos', 'amigo': localStorage.getItem("CodigoUsuario")}, listarCursosConstruir, function(){});
}

function listarCursosConstruir (response) {
	if(response == "empty"){
		try{
        	$("#collapAsistenciaCurso").html("<div data-role='collapsible'><h4>No hay cursos disponibles</h4><p>Vuelve mas tarde.</p></div>").collapsibleset("refresh")
    	}catch(e){}
	}else{
		var data = JSON.parse(response);
		var struct = "";
        for(var val in data){
        	struct += "<div data-role='collapsible'><h4>"+data[val].nombre+" - "+data[val].fecha+"</h4><button class='ui-btn' onclick=\"popupAsistenciaCurso('"+data[val].id+"')\">Añadir asistentes</button></div>";
        }
        try{
        	$("#collapAsistenciaCurso").html(struct).collapsibleset("refresh")
        }catch(e){}
	}
}

/**
*	Permite cargar el formulario para añadir asistentes a un curso
*/
function popupAsistenciaCurso (value) {
	$("#idCurso").val(value)
	$( ":mobile-pagecontainer" ).pagecontainer( "change", "#addAsistenteCursoScreen", { 
    	role: "page"
    });
}
/**
*	Informa un registro con exito
*/
function avisoRegistroExitoso () {
	$('#registrarAsesoria').trigger("reset");
	$( ":mobile-pagecontainer" ).pagecontainer( "change", "#registroCorrectoScreen", { 
		role: "dialog"
	});
}
/**
*	Informa un error en la coincidencia materia/tema
*/
function avisoErrorTema () {
	$( ":mobile-pagecontainer" ).pagecontainer( "change", "#materiaTemaScreen", { 
		role: "dialog"
	});
}

/**
*	Método disparado al registrar una asistencia
*/
function accionPostRegistroAsistencia (response) {
	if(response == "ok"){
		$("#clic").click()
	}else{
		errorDeRed();
	}
}

/**
*	Eventos
*/
$("#materiaAse").change(cargarTemasRegistroAsesoria) //Carga los temas al seleccionar una materia


//	Registra una asesoria
$("#registrarAsesoria").submit(function() { 
	var parametrosAsesoria = {
		"mobile" : 'registrarAsesoria',
		"materia" : $("#materiaAse").val(),
		"tema" : $("#temaAse").val(),
		"codigo" : $("#codigoAse").val(),
		"comentario" : $("#comentarioAse").val(),
		"codigoAmigo" : localStorage.getItem("CodigoUsuario")
	   };
	

	if($("#materiaAse").val() != "Seleccionar Materia" && $("#temaAse").val() != "Seleccionar Tema"){
		peticionAsincrona("post", false, null, parametrosAsesoria, avisoRegistroExitoso, avisoErrorTema);
	}else{
		$( ":mobile-pagecontainer" ).pagecontainer( "change", "#materiaTemaScreen", { 
			role: "dialog"
		});
	}
	return false;
});

//Registrar asistencia a un curso
$("#formAddAsistenciaCurso").submit(function(){
	var parametrosAsistencia = {
        "mobile" : 'registrarAsistenciaCurso',
        "idCurso" : $("#idCurso").val(),
        "codigo" : $("#asistenciaCursoCodigo").val()
    };
    peticionAsincrona("post", false, null, parametrosAsistencia, accionPostRegistroAsistencia, errorDeRed);
	return false;
});

