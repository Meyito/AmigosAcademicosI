$( document ).ready(function() {
  		verificarSesion();
  		cargarHorario();
  		cargarTemas();
  		cargarMateriasRegistroAsesoria();
  		cargarCursosAdmin();
  		cargarMateriasCrearCurso ();
  		cargarTemasCrearCurso ();
  		cargarAmigos("");
  		
});


/***************SIDEBAR AMIGOS ACADEMICOS*****************/
$(document).on("pagecreate", "#amigosScreen", function(){
	$(document).on("swiperight", "#amigosScreen", function(e){
		if($(".ui-page-active").jqmData("panel") !== "open"){
			if(e.type == "swiperight"){
				$('#sidebarAmigos').panel("open");
			}
		}
	});
});

/***************SIDEBAR CREAR TEMA*****************/
$(document).on("pagecreate", "#crearTemaScreen", function(){
	$(document).on("swiperight", "#crearTemaScreen", function(e){
		if($(".ui-page-active").jqmData("panel") !== "open"){
			if(e.type == "swiperight"){
				$('#sidebarcrearTema').panel("open");
			}
		}
	});
});
/***************SIDEBAR EDITAR CURSO*****************/
$(document).on("pagecreate", "#editarCursoScreen", function(){
	$(document).on("swiperight", "#editarCursoScreen", function(e){
		if($(".ui-page-active").jqmData("panel") !== "open"){
			if(e.type == "swiperight"){
				$('#sidebarEditarCurso').panel("open");
			}
		}
	});
});

/***************SIDEBAR NUEVO CURSO*****************/
$(document).on("pagecreate", "#crearCursoScreen", function(){
	$(document).on("swiperight", "#crearCursoScreen", function(e){
		if($(".ui-page-active").jqmData("panel") !== "open"){
			if(e.type == "swiperight"){
				$('#sidebarCrearCurso').panel("open");
			}
		}
	});
});

/***************SIDEBAR EDITAR AMIGO*****************/
$(document).on("pagecreate", "#editarAmigoScreen", function(){
	$(document).on("swiperight", "#editarAmigoScreen", function(e){
		if($(".ui-page-active").jqmData("panel") !== "open"){
			if(e.type == "swiperight"){
				$('#sidebarEditarAmigo').panel("open");
			}
		}
	});
});

/***************SIDEBAR AÑADIR AMIGO*****************/
$(document).on("pagecreate", "#crearAmigoScreen", function(){
	$(document).on("swiperight", "#crearAmigoScreen", function(e){
		if($(".ui-page-active").jqmData("panel") !== "open"){
			if(e.type == "swiperight"){
				$('#sidebarCrearAmigo').panel("open");
			}
		}
	});
});

$("#formNuevoTema").submit(function(){
	if($("#materiaAse").val() != "Seleccionar Materia"){
		var parametros = {
	        "mobile" : 'registrarTema',
	        "tema" : $("#temaNombre").val(),
	        "codigoMateria" : $("#materiaAse").val()
	    };
	    $.ajax({
		    data:  parametros,
		    url:   root,
		    type:  'post',
		    success:  function (response) {
		    	if(response=="ok"){
		    		$('#formNuevoTema').trigger("reset");
			    	$( ":mobile-pagecontainer" ).pagecontainer( "change", "#registroCorrectoScreen", { 
						role: "dialog"
					});
		    	}else{
			    	$( ":mobile-pagecontainer" ).pagecontainer( "change", "#errorRedScreen", { 
						role: "dialog"
					});
		    	}
		    },
		    error: function ( xhr, status){
		    	$('#registrarAsesoria').trigger("reset");
		    	$( ":mobile-pagecontainer" ).pagecontainer( "change", "#errorRedScreen", { 
					role: "dialog"
				});
		    }
		});
	}
	return false;
});


/********PRÓXIMOS CURSOS*********/
function cargarCursosAdmin(){
	if(localStorage.getItem("cursosEstudiante")!=null){
		construirCursosAdmin(JSON.parse(localStorage.getItem("cursosEstudiante")));
	}

	var parametros = {
        "mobile" : 'proximosCursos'
    };
    $.ajax({
		data:  parametros,
        url:   root,
        type:  'post',
        success:  function (response) {
        	var data = JSON.parse(response);
        	var dataToStore = JSON.stringify(data);
        	localStorage.setItem('cursosEstudiante', dataToStore);
        	construirCursosAdmin(data);
        }	
	});
}

function construirCursosAdmin (data) {
	var struct = "";
   	for(var val in data){
   		struct += "<tr><th colspan='2'>"+data[val].nombre+"</th></tr><tr><td>"+data[val].fecha+" "+data[val].hora+"</td><td><button class='ui-btn' onclick='editarCurso(\""+data[val].id+"\", \""+data[val].materia+"\", \""+data[val].fecha+"\", \""+data[val].hora+"\", \""+data[val].nombre+"\", \""+data[val].amigo+"\", \""+data[val].descripcion+"\" )'>Editar</button</td></tr>";
   	}
   	$("#tablaCursos").html(struct)
}


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



function cargarMateriasEditarCurso (materia, nombre) {
	if(localStorage.getItem("MateriasRegistroAsesoria")!=null){
		construirEditarMateriasCurso(JSON.parse(localStorage.getItem("MateriasRegistroAsesoria")));
	}
	var parametros = {
		"mobile" : 'cargarMaterias'
    };
    $.ajax({
	    data:  parametros,
	    url:   root,
	    type:  'post',
	    success:  function (response) {
	    	var data = JSON.parse(response);
	    	var dataToStore = JSON.stringify(data);
        	localStorage.setItem('MateriasRegistroAsesoria', dataToStore);
	    	var val = construirEditarMateriasCurso(data, materia);
			cargarTemasEditarCurso(val, nombre);
	    }
	});
}

function construirEditarMateriasCurso(data, materia){
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
	}catch(e){

	}
	return idMat;
	
}
function cargarTemasEditarCurso (idMateria, tema) {
	var parametros = {
		"mobile" : 'cargarTemas',
		"materia" : idMateria
    };
    $.ajax({
	    data:  parametros,
	    url:   root,
	    type:  'post',
	    success:  function (response) {
	    	var data = JSON.parse(response);
	    	construirEditarTemasCurso(data, tema);
	    }
	});
}

function construirEditarTemasCurso(data, tema){
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
	}catch(e){
		
	}
}


function recargarTemasEditMateria () {
	var parametros = {
		"mobile" : 'cargarTemas',
		"materia" : $("#editCursoMateria").val()
    };
    $.ajax({
	    data:  parametros,
	    url:   root,
	    type:  'post',
	    success:  function (response) {
	    	var data = JSON.parse(response);
	    	construirEditarTemasCurso(data, "");
	    }
	});
}


function construirSelectEditarAmigos(data, amigo){
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
	$.ajax({
		data: parametros,
		url: root,
		type: "post",
		success: function(response){
			if(response=="ok"){
				$("editarCurso").trigger("reset");
				$( ":mobile-pagecontainer" ).pagecontainer( "change", "#cursosScreen", { 
					role: "page"
				});
			}else{
		    	$( ":mobile-pagecontainer" ).pagecontainer( "change", "#errorRedScreen", { 
					role: "dialog"
				});
		    }
		},
		error: function(xhr, status){
			$( ":mobile-pagecontainer" ).pagecontainer( "change", "#errorRedScreen", { 
				role: "dialog"
			});
		}
	});
});

$("#editCursoEliminar").click(function(){
	var parametros = {
		"mobile" : "eliminarCurso",
		"id" : $("#editCursoID").val()
	};
	$.ajax({
		data: parametros,
		url: root,
		type: "post",
		success: function(response){
			if(response=="ok"){
				$("editarCurso").trigger("reset");
				$( ":mobile-pagecontainer" ).pagecontainer( "change", "#cursosScreen", { 
					role: "page"
				});
			}else{
		    	$( ":mobile-pagecontainer" ).pagecontainer( "change", "#errorRedScreen", { 
					role: "dialog"
				});
		    }
		},
		error: function(xhr, status){
			$( ":mobile-pagecontainer" ).pagecontainer( "change", "#errorRedScreen", { 
				role: "dialog"
			});
		}
	})
});

$("#editarCurso").submit(function(){
	$( ":mobile-pagecontainer" ).pagecontainer( "change", "#cursosScreen", { 
		role: "page"
	});
	return false;
});





function cargarMateriasCrearCurso () {
	if(localStorage.getItem("MateriasRegistroAsesoria")!=null){
		construirCrearMateriasCurso(JSON.parse(localStorage.getItem("MateriasRegistroAsesoria")));
	}
	var parametros = {
		"mobile" : 'cargarMaterias'
    };
    $.ajax({
	    data:  parametros,
	    url:   root,
	    type:  'post',
	    success:  function (response) {
	    	var data = JSON.parse(response);
	    	var dataToStore = JSON.stringify(data);
        	localStorage.setItem('MateriasRegistroAsesoria', dataToStore);
			construirCrearMateriasCurso(data);
	    }
	});
}

function construirCrearMateriasCurso(data){
	var struct = "";
	for(var val in data){
		struct += "<option value='"+ val +"'>"+ data[val] +"</option>";
	}
	$("#crearCursoMateria").html(struct);
	try{
		$("#crearCursoMateria").selectmenu("refresh", true);
	}catch(e){
	}	
}


function cargarTemasCrearCurso () {
	var parametros = {
		"mobile" : 'cargarTemas',
		"materia" : $("#crearCursoMaterial").val()
    };
    $.ajax({
	    data:  parametros,
	    url:   root,
	    type:  'post',
	    success:  function (response) {
	    	var data = JSON.parse(response);
	    	construirCrearTemasCurso(data);
	    }
	});
}

function construirCrearTemasCurso(data){
	var struct = "";
	for(var val in data){
		struct += "<option value='"+ val +"'>"+ data[val] +"</option>";
	}
	$("#crearCursoTema").html(struct);
	try{
		$("#crearCursoTema").selectmenu("refresh", true);
	}catch(e){
	}
}

$("#crearCursoMateria").change(cargarTemasCrearCurso);


function construirSelectCrearAmigos(data){
	var struct = "";
	for(var val in data){
		struct += "<option value='"+ val +"'>"+ data[val] +"</option>";
	}
	$("#crearCursoAmigo").html(struct);
	try{
		$("#crearCursoAmigo").selectmenu("refresh", true);
	}catch(e){
		
	}
}

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
	$.ajax({
		data: parametros,
		url: root,
		type: "post",
		success: function(response){
			console.log("ee "+response);
			if(response=="ok"){
				$( ":mobile-pagecontainer" ).pagecontainer( "change", "#cursosScreen", { 
					role: "page"
				});
			}else{
		    	$( ":mobile-pagecontainer" ).pagecontainer( "change", "#errorRedScreen", { 
					role: "dialog"
				});
		    }
		},
		error: function(xhr, status){
			$( ":mobile-pagecontainer" ).pagecontainer( "change", "#errorRedScreen", { 
				role: "dialog"
			});
		}
	});
	return false;
});



function cargarAmigos(amigo){
	if(localStorage.getItem("listaAmigos")!=null){
		construirTemas(JSON.parse(localStorage.getItem("listaAmigos")));
	}

	var parametros = {
        "mobile" : 'cargarListaAmigos'
    };
    $.ajax({
		data:  parametros,
        url:   root,
        type:  'post',
        success:  function (response) {
        	var data = JSON.parse(response);
        	var dataToStore = JSON.stringify(data);
        	localStorage.setItem('listaAmigos', dataToStore);
        	construirSelectEditarAmigos(data, amigo);
			construirSelectCrearAmigos(data);
			if(amigo==""){
				construirAmigos(data);
			}
	        
        }	
	});
}
function construirAmigos(data){
	var struct = "<thead><tr><th colspan='2'>Amigo Académico</th><th> </th></tr></thead><tbody>";
	for(var val in data){
   		struct += "<tr><td>"+data[val]+"</td><td><button onclick='editarAmigo(\""+val+"\")'>Editar</button></td></tr>";
   	}
   	struct += "</tbody>";
    $("#tablaAmigos").html(struct)
}

function editarAmigo(codigoAmigo){
	var parametros = {
		"mobile" : "obtenerDatosAA",
		"codigoAA": codigoAmigo
	};
	$.ajax({
		data:  parametros,
        url:   root,
        type:  'post',
        success:  function (response) {
        	var data = JSON.parse(response);
        	$("#codigoEditAmigo").val(data.codigo);
        	$("#nombreEditAmigo").val(data.nombre);
        	$("#emailEditAmigo").val(data.email);
        	$("#semestreEditAmigo").val(data.semestre);
        	$( ":mobile-pagecontainer" ).pagecontainer( "change", "#editarAmigoScreen", { 
				role: "page"
			});
        },
        error: function(xhr,status){
        	$( ":mobile-pagecontainer" ).pagecontainer( "change", "#errorRedScreen", { 
				role: "dialog"
			});
        }
    });
	
}

$("#editarAmigoForm").submit(function(){
	var parametros = {
		"mobile": "actualizarAmigo",
		"codigo": $("#codigoEditAmigo").val(),
		"nombre": $("#nombreEditAmigo").val(),
		"email": $("#emailEditAmigo").val(),
		"semestre": $("#semestreEditAmigo").val()
	};
	$.ajax({
		data:  parametros,
        url:   root,
        type:  'post',
        success:  function (response) {
        	if(response=="ok"){
        		$( ":mobile-pagecontainer" ).pagecontainer( "change", "#amigosScreen", { 
					role: "page"
				});
        	}else{
        		$( ":mobile-pagecontainer" ).pagecontainer( "change", "#errorRedScreen", { 
					role: "dialog"
				});
        	}
        },
        error: function(xhr,status){
        	$( ":mobile-pagecontainer" ).pagecontainer( "change", "#errorRedScreen", { 
				role: "dialog"
			});
        }
    });
	return false;
});


$("#crearAmigoForm").submit(function(){
	var parametros = {
		"mobile": "nuevoAmigo",
		"codigo": $("#codigoEditAmigo").val(),
		"nombre": $("#nombreEditAmigo").val(),
		"email": $("#emailEditAmigo").val(),
		"semestre": $("#semestreEditAmigo").val()
	};
	$.ajax({
		data:  parametros,
        url:   root,
        type:  'post',
        success:  function (response) {
        	console.log(response);
        	if(response=="ok"){
        		$( ":mobile-pagecontainer" ).pagecontainer( "change", "#amigosScreen", { 
					role: "page"
				});
        	}else{
        		$( ":mobile-pagecontainer" ).pagecontainer( "change", "#errorRedScreen", { 
					role: "dialog"
				});
        	}
        },
        error: function(xhr,status){
        	$( ":mobile-pagecontainer" ).pagecontainer( "change", "#errorRedScreen", { 
				role: "dialog"
			});
        }
    });
	return false;
});
