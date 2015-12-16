/**
*	Libreria con utilidades para administradores de la plataforma
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
  	cargarMateriasRegistroAsesoria();
  	cargarCursosAdmin();
  	cargarMateriasCrearCurso ();
  	cargarTemasCrearCurso ();
  	cargarAmigos("");
}


/**
*	Sidebars propios de la vista Admin
*/
swipeSidebar("amigosScreen", "sidebarAmigos");
swipeSidebar("crearTemaScreen", "sidebarcrearTema");
swipeSidebar("editarCursoScreen", "sidebarEditarCurso");
swipeSidebar("crearCursoScreen", "sidebarCrearCurso");
swipeSidebar("editarAmigoScreen", "sidebarEditarAmigo");
swipeSidebar("crearAmigoScreen", "sidebarCrearAmigo");



/**
*	Carga la lista editable de cursos
*/
function cargarCursosAdmin(){
	peticionAsincrona("get", true, "cursosEstudiante", {"mobile" : 'proximosCursos'}, construirCursosAdmin, function(){});
}

function construirCursosAdmin (response) {
	var data = JSON.parse(response);
	var struct = "";
   	for(var val in data){
   		struct += "<tr><th colspan='2'>"+data[val].nombre+"</th></tr><tr><td>"+data[val].fecha+" "+data[val].hora+"</td><td><button class='ui-btn' onclick='editarCurso(\""+data[val].id+"\", \""+data[val].materia+"\", \""+data[val].fecha+"\", \""+data[val].hora+"\", \""+data[val].nombre+"\", \""+data[val].amigo+"\", \""+data[val].descripcion+"\" )'>Editar</button</td></tr>";
   	}
   	$("#tablaCursos").html(struct)
}

/**
*	Desplega el formulario para edición de un curso especifico
*/
function editarCurso (id, materia, fecha, hora, nombre, amigo, descripcion) {
	cargarMateriasEditarCurso (materia, nombre);
	cargarAmigos(amigo);
	$("#editCursoFecha").val(fecha);
	$("#editCursoHora").val(hora);
	$("#editCursoComentario").val(descripcion);
	$("#editCursoMateria").change(recargarTemasEditMateria);
	$( ":mobile-pagecontainer" ).pagecontainer( "change", "#editarCursoScreen", { 
		role: "page"
	});
}

/**
*	Carga las Materias del formulario editar curso, dejando como selected la actual
*/
function cargarMateriasEditarCurso (materia, nombre) {
	var _materia = materia;
	var _nombre = nombre;
	peticionAsincrona("get", true, "listaMaterias", {"mobile" : 'cargarMaterias'}, function(response){
		var val = construirEditarMateriasCurso(response, _materia);
		cargarTemasEditarCurso(val, _nombre);
	}, function(){});
}

/**
*	Construye el select para editar las materias
*/
function construirEditarMateriasCurso(response, materia){
	var data = JSON.parse(response);
	var option = "";
	var struct = "";
	var idMat;
	for(var val in data){
		if(data[val] == materia){
			option = "<option selected='selected' value='"+ val +"'>"+ data[val] +"</option>";
			idMat = val;
		}else{
			struct += "<option value='"+ val +"'>"+ data[val] +"</option>";
		}
	}
	struct = option + struct;
	$("#editCursoMateria").html(struct);
	try{
		$("#editCursoMateria").selectmenu("refresh", true);
	}catch(e){}
	return idMat;
	
}
/**
*	Carga la lista de temas
*/
function cargarTemasEditarCurso (idMateria, tema) {
	var _tema = tema;
	var parametros = {
		"mobile" : 'cargarTemas',
		"materia" : idMateria
    };
    peticionAsincrona("get", false, null, parametros, function(response){
    	construirEditarTemasCurso(response, _tema);
    }, function(){});
}

/**
*	Construye el select con los temas
*/
function construirEditarTemasCurso(response, tema){
	if(tema == undefined){
		tema = "";
	}
	var data = JSON.parse(response);
	var option = "";
	var struct = "";
	for(var val in data){
		if(data[val] == tema){
			option = "<option selected='selected' value='"+ val +"'>"+ data[val] +"</option>";
		}else{
			struct += "<option value='"+ val +"'>"+ data[val] +"</option>";
		}
	}
	struct = option + struct;
	$("#editCursoTema").html(struct);
	try{
		$("#editCursoTema").selectmenu("refresh", true);
	}catch(e){}
}

/**
*	Recarga el select de temas al cambiar de materia
*/
function recargarTemasEditMateria () {
	var parametros = {
		"mobile" : 'cargarTemas',
		"materia" : $("#editCursoMateria").val()
    };
    peticionAsincrona("get", false, null, parametros, construirEditarTemasCurso, function(){});

}

/**
*	Construye el select de Amigos Académicos
*/
function construirSelectEditarAmigos(response, amigo){
	var data = JSON.parse(response);
	var option = "";
	var struct = "";
	for(var val in data){
		if(data[val] == amigo){
			option = "<option selected='selected' value='"+ val +"'>"+ data[val] +"</option>";
		}else{
			struct += "<option value='"+ val +"'>"+ data[val] +"</option>";
		}
	}
	struct = option + struct;
	$("#editCursoAmigo").html(struct);
	try{
		$("#editCursoAmigo").selectmenu("refresh", true);
	}catch(e){
		
	}
}

/**
*	Carga la lista de Materias para el select en el menu de crear un curso
*/

function cargarMateriasCrearCurso () {
	peticionAsincrona("get", true, "listaMaterias", {"mobile" : 'cargarMaterias'}, construirCrearMateriasCurso, function(){});
}

/**
*	Construye el select de Materias en el menu de crear curso
*/
function construirCrearMateriasCurso(response){
	var data = JSON.parse(response);
	var struct = "";
	for(var val in data){
		struct += "<option value='"+ val +"'>"+ data[val] +"</option>";
	}
	$("#crearCursoMateria").html(struct);
	try{
		$("#crearCursoMateria").selectmenu("refresh", true);
	}catch(e){}	
}

/**
*	Carga la lista de temas para el select en el menu de crear un curso
*/
function cargarTemasCrearCurso () {
	var parametros = {
		"mobile" : 'cargarTemas',
		"materia" : $("#crearCursoMaterial").val()
    };
    peticionAsincrona("get", false, null, parametros, construirCrearTemasCurso, function(){});
}

/**
*	Construye el select de temas en el menu de crear curso
*/
function construirCrearTemasCurso(response){
	var data = JSON.parse(response);
	var struct = "";
	for(var val in data){
		struct += "<option value='"+ val +"'>"+ data[val] +"</option>";
	}
	$("#crearCursoTema").html(struct);
	try{
		$("#crearCursoTema").selectmenu("refresh", true);
	}catch(e){}
}

/**
*	Construye el select de amigos en el menú de crear Curso
*/
function construirSelectCrearAmigos(response){
	var data = JSON.parse(response);
	var struct = "";
	for(var val in data){
		struct += "<option value='"+ val +"'>"+ data[val] +"</option>";
	}
	$("#crearCursoAmigo").html(struct);
	try{
		$("#crearCursoAmigo").selectmenu("refresh", true);
	}catch(e){}
}

/**
*	Carga la lista de amigos para construir la tabla
*/
function cargarAmigos(amigo){
	var _amigo = amigo;
	peticionAsincrona("get", true, "listaAmigos", {"mobile" : 'cargarListaAmigos'}, function(response){
		construirSelectEditarAmigos(response, _amigo);
		construirSelectCrearAmigos(response);
		if(_amigo==""){
			construirAmigos(response);
		}
	}, function(){}); 
}
function construirAmigos(response){
	var data = JSON.parse(response);
	var struct = "<thead><tr><th colspan='2'>Amigo Académico</th><th> </th></tr></thead><tbody>";
	for(var val in data){
   		struct += "<tr><td>"+data[val]+"</td><td><button class='ui-btn' onclick='editarAmigo(\""+val+"\")'>Editar</button></td></tr>";
   	}
   	struct += "</tbody>";
    $("#tablaAmigos").html(struct)
}

/**
*	Carga en el formulario de edición de amigos sus datos
*/
function editarAmigo(codigoAmigo){
	var parametros = {
		"mobile" : "obtenerDatosAA",
		"codigoAA": codigoAmigo
	};
	peticionAsincrona("get", false, null, parametros, construirEditarAmigos, errorDeRed); 	
}
/**
*	Construye el menu de edición de amigos
*/
function construirEditarAmigos (response) {
	var data = JSON.parse(response);
    $("#codigoEditAmigo").val(data.codigo);
    $("#nombreEditAmigo").val(data.nombre);
    $("#emailEditAmigo").val(data.email);
    $("#semestreEditAmigo").val(data.semestre);
    $( ":mobile-pagecontainer" ).pagecontainer( "change", "#editarAmigoScreen", { 
		role: "page"
	});
}

/**
*	Informa de una edición exitosa en el formulario de amigo académico
*/
function exitoEdicionAmigo (response) {
	if(response=="ok"){
		cargarAmigos("");
        $( ":mobile-pagecontainer" ).pagecontainer( "change", "#amigosScreen", { 
			role: "page"
		});
    }else{
        errorDeRed();
    }
}

/**
*	Mensaje cuando un tema se ha registrado exitosamente
*/
function exitoCreacionTema(response){
	if(response=="ok"){
		cargarTemas();
		$('#formNuevoTema').trigger("reset");
		$( ":mobile-pagecontainer" ).pagecontainer( "change", "#registroCorrectoScreen", { 
			role: "dialog"
		});
	}else{
		errorDeRed();
	}
}

/**
*
*/
function exitoEdicionCurso (response) {
	if(response=="ok"){
		cargarCursosAdmin();
		$("editarCurso").trigger("reset");
		$( ":mobile-pagecontainer" ).pagecontainer( "change", "#cursosScreen", { 
			role: "page"
		});
	}else{
	   	errorDeRed();
	}
}
/**
*	EVENTOS
*/

/**
*	Edición de un amigo académico
*/
$("#editarAmigoForm").submit(function(){
	var parametros = {
		"mobile": "actualizarAmigo",
		"codigo": $("#codigoEditAmigo").val(),
		"nombre": $("#nombreEditAmigo").val(),
		"email": $("#emailEditAmigo").val(),
		"semestre": $("#semestreEditAmigo").val()
	};
	peticionAsincrona("post", false, null, parametros, exitoEdicionAmigo, errorDeRed);
	return false;
});

/**
*	Creación de un amigo académico
*/
$("#crearAmigoForm").submit(function(){
	var parametros = {
		"mobile": "nuevoAmigo",
		"codigo": $("#codigoEditAmigo").val(),
		"nombre": $("#nombreEditAmigo").val(),
		"email": $("#emailEditAmigo").val(),
		"semestre": $("#semestreEditAmigo").val(),
		"password": $("#passwordCrearAmigo").val(),
		"password": $("#password2CrearAmigo").val()
	};
	peticionAsincrona("post", false, null, parametros, exitoEdicionAmigo, errorDeRed);
	return false;
});

/**
*	Creación de un tema
*/
$("#formNuevoTema").submit(function(){
	if($("#materiaAse").val() != "Seleccionar Materia"){
		var parametros = {
	        "mobile" : 'registrarTema',
	        "tema" : $("#temaNombre").val(),
	        "codigoMateria" : $("#materiaAse").val()
	    };
	    peticionAsincrona("post", false, null, parametros, exitoCreacionTema, errorDeRed);
	}
	return false;
});

/**
*	Edición de un curso
*/
$("#editCursoEditar").click(function(){
	var parametros = {
		"mobile": "editarCurso",
		"id": $("#editCursoID").val(),
		"idMateria" : $("#editCursoMateria").val(),
		"idTema" : $("#editCursoTema").val(),
		"idAmigo" : $("#editCursoAmigo").val(),
		"fecha" : $("#editCursoFecha").val(),
		"hora" : $("#editCursoHora").val(),
		"descripcion" : $("#editCursoComentario").val()
	};
	peticionAsincrona("post", false, null, parametros, exitoEdicionCurso, errorDeRed);
});

/**
*	Eliminación de un curso
*/
$("#editCursoEliminar").click(function(){
	var parametros = {
		"mobile" : "eliminarCurso",
		"id" : $("#editCursoID").val()
	};
	peticionAsincrona("post", false, null, parametros, exitoEdicionCurso, errorDeRed);
});

$("#editarCurso").submit(function(){
	$( ":mobile-pagecontainer" ).pagecontainer( "change", "#cursosScreen", { 
		role: "page"
	});
	return false;
});

/**
*	Creación de un curso
*/
$("#crearCurso").submit(function(){
	var parametros = {
		"mobile": "crearCurso",
		"idMateria" : $("#crearCursoMateria").val(),
		"idTema" : $("#crearCursoTema").val(),
		"idAmigo" : $("#crearCursoAmigo").val(),
		"fecha" : $("#crearCursoFecha").val(),
		"hora" : $("#crearCursoHora").val(),
		"descripcion" : $("#crearCursoComentario").val()
	};
	peticionAsincrona("post", false, null, parametros, exitoEdicionCurso, errorDeRed);
	return false;
});

$("#crearCursoMateria").change(cargarTemasCrearCurso); //Activación de un curso
