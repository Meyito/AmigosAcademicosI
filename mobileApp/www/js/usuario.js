/**
*	Libreria con utilidades para todos los usuarios de la plataforma
*	@author Gerson Lázaro - Melissa Delgado - Daniel Vega
*	@date 15-12-2015
*/



/**
*
* Redirecciona a la página indicada según el tipo de usuario
*/
function verificarSesion () {
	if(localStorage.getItem('TipoUsuario') != $("body").attr("id")){
		window.location.href = "index.html";
	}else{
		var className = $(".userName");
		var classType = $(".userType");
		var text;

		for(i = 0; i < className.length; i++){
			className[i].innerHTML = localStorage.getItem('NombreUsuario');
		}
		if(localStorage.getItem('TipoUsuario')=="1"){
			text = "Administrador";
		}else if(localStorage.getItem('TipoUsuario')=="2"){
			text = "Amigo Academico";
		}else if(localStorage.getItem('TipoUsuario')=="3"){
			text = "Estudiante";
		}
		for(i = 0; i < classType.length; i++){
			classType[i].innerHTML = text;
		}

	}
}


/**
*
*	Método usado para comunicarse con ajax
*/
function peticionAsincrona(tipoHttp, boolLocalStorage, varLocalStorage, parametros, fSuccess, fError) {
	if(boolLocalStorage){
		if(localStorage.getItem(varLocalStorage)!=null){
			fSuccess(localStorage.getItem(varLocalStorage));
		}
	}
	$.ajax({
		data:  parametros,
        url:   root,
        type: tipoHttp,
        success:  function (response) {
        	console.log(response);
        	if(boolLocalStorage){
        		var data = JSON.parse(response);
        		var dataToStore = JSON.stringify(data);
        		localStorage.setItem(varLocalStorage, dataToStore);
        	} 
        	fSuccess(response);   	
        },
        error: function(xhr, status){
        	fError();
        }
    });
}




/**
*	Utilidades para activar el sidebar al hacer swipe de izquierda a derecha
*	En este espacio SOLO estan los sidebar propios de todos los usuarios
*	Los especificos de cada usuario estan en sus propios archivos *.js
*/
function swipeSidebar (idPage, idSidebar) {
	$(document).on("pagecreate", "#"+idPage, function(){
		$(document).on("swiperight", "#"+idPage, function(e){
			if($(".ui-page-active").jqmData("panel") !== "open"){
				if(e.type == "swiperight"){
					$('#'+idSidebar).panel("open");
				}
			}
		});
	});
}
swipeSidebar("inicio", "sidebar");
swipeSidebar("temasScreen", "sidebar2");
swipeSidebar("cursosScreen", "sidebar3");





/**
*
*	Activa los cierres de sesión desde las diferentes secciones
*/
function cerrarSesion () {
	localStorage.clear();
	verificarSesion();
}
$("#cerrarSesion").click(cerrarSesion);
$("#cerrarSesion1").click(cerrarSesion);
$("#cerrarSesion2").click(cerrarSesion);
$("#cerrarSesion3").click(cerrarSesion);
$("#cerrarSesion4").click(cerrarSesion);
$("#cerrarSesion5").click(cerrarSesion);
$("#cerrarSesion6").click(cerrarSesion);
$("#cerrarSesion7").click(cerrarSesion);
$("#cerrarSesion8").click(cerrarSesion);




/**
*	Carga el horario y lo construye en pantalla
*/
function cargarHorario () {
	peticionAsincrona("get", true, "horarioEstudiante", {"mobile" : 'horario'}, construirHorario, function(){});
}
function construirHorario (response) {
	var data = JSON.parse(response);
	for(var val in data){
   		$("#"+val).html(data[val])
   	}
}


/**
*	Carga la tabla de temas de la semana
*/
function cargarTemas () {
	peticionAsincrona("get", true, "temasEstudiante",{"mobile" : 'temasSemana'}, construirTemas, function(){});
}

function construirTemas(response){
	var data = JSON.parse(response);
	var struct = "<thead><tr><th>Materia</th><th>Tema</th></tr></thead><tbody>";
	for(var val in data){
   		struct += "<tr><td>"+data[val]+"</td><td>"+val+"</td></tr>";
   	}
   	struct += "</tbody>";
    $("#tablaTemas").html(struct)
}


/**
*	Carga la tabla de próximos cursos
*/
function cargarCursos(){
	peticionAsincrona("get", true, "cursosEstudiante", {"mobile" : 'proximosCursos'}, construirCursos, function(){}); 
}

function construirCursos (response) {
	var data = JSON.parse(response);
	var struct = "";
   	for(var val in data){
   		struct += "<tr><th colspan='2'>"+data[val].nombre+"</th></tr><tr><td>"+data[val].fecha+" "+data[val].hora+"</td><td>"+data[val].amigo+"</td></tr>";
   	}
   	$("#tablaCursos").html(struct)
}



/**
*	Cargar select con las materias
*/
function cargarMateriasRegistroAsesoria () {
	peticionAsincrona("get", true, "listaMaterias", {"mobile" : 'cargarMaterias'}, construirMateriasRegistroAsesoria, function(){}); 
}

function construirMateriasRegistroAsesoria (response) {
	var data = JSON.parse(response);
	var struct = "<option>Seleccionar Materia</option>";
	for(var val in data){
		struct += "<option value='"+val+"'>"+data[val]+"</option>";
	}
	$("#materiaAse").html(struct)
}


/**
*	Desplega información cuando se presenta un error de red
*/
function errorDeRed () {
	$( ":mobile-pagecontainer" ).pagecontainer( "change", "#errorRedScreen", { 
		role: "dialog"
	});
}