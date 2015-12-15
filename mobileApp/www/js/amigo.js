$( document ).ready(function() {
  		verificarSesion();
  		cargarHorario();
  		cargarTemas();
  		cargarCursos();
  		cargarMateriasRegistroAsesoria();
  		listarCursos();
});


/***************SIDEBAR REGISTRO ASESORIA*****************/
$(document).on("pagecreate", "#registroAsesoriaScreen", function(){
	$(document).on("swiperight", "#registroAsesoriaScreen", function(e){
		if($(".ui-page-active").jqmData("panel") !== "open"){
			if(e.type == "swiperight"){
				$('#sidebarRegistroAsesoria').panel("open");
			}
		}
	});
});
/***************SIDEBAR REGISTRO CURSO*****************/
$(document).on("pagecreate", "#addAsistenteCursoScreen", function(){
	$(document).on("swiperight", "#addAsistenteCursoScreen", function(e){
		if($(".ui-page-active").jqmData("panel") !== "open"){
			if(e.type == "swiperight"){
				$('#sidebarRegistroAsistenciaCurso').panel("open");
			}
		}
	});
});

$(document).on("pagecreate", "#registroCursoScreen", function(){
	$(document).on("swiperight", "#registroCursoScreen", function(e){
		if($(".ui-page-active").jqmData("panel") !== "open"){
			if(e.type == "swiperight"){
				$('#sidebarAddAsistenteCurso').panel("open");
			}
		}
	});
});


function cargarMateriasRegistroAsesoria () {
	if(localStorage.getItem("MateriasRegistroAsesoria")!=null){
		construirMateriasRegistroAsesoria(JSON.parse(localStorage.getItem("MateriasRegistroAsesoria")));
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
	    	construirMateriasRegistroAsesoria (data);
	    	
	    }
	});
}

function construirMateriasRegistroAsesoria (data) {
	var struct = "<option>Seleccionar Materia</option>";
	for(var val in data){
		struct += "<option value='"+val+"'>"+data[val]+"</option>";
	}
	$("#materiaAse").html(struct)
}

$("#materiaAse").change(cargarTemasRegistroAsesoria)

function cargarTemasRegistroAsesoria () {
	if($("#materiaAse").val() != "Seleccionar Materia"){
		
		var parametros = {
			"mobile" : 'cargarTemas',
			"materia" : $("#materiaAse").val() 
	    };
	    $.ajax({
		    data:  parametros,
		    url:   root,
		    type:  'post',
		    success:  function (response) {
		    	var data = JSON.parse(response);
		    	var struct = "<option>Seleccionar Tema</option>";
				for(var val in data){
					struct += "<option value='"+val+"'>"+data[val]+"</option>";
				}
				$("#temaAse").selectmenu("enable")		
				$("#temaAse").html(struct)
		    	    	
		    },
		    error: function(xhr, status){
		    	$( ":mobile-pagecontainer" ).pagecontainer( "change", "#errorRedScreen", { 
					role: "dialog"
				});
		    }
		});
	}else{
		$("#temaAse").selectmenu("disable");
	}	
}



$("#registrarAsesoria").submit(function() {  
	if($("#materiaAse").val() != "Seleccionar Materia" && $("#temaAse").val() != "Seleccionar Tema"){
		var parametros = {
			"mobile" : 'registrarAsesoria',
			"materia" : $("#materiaAse").val(),
			"tema" : $("#temaAse").val(),
			"codigo" : $("#codigoAse").val(),
			"comentario" : $("#comentarioAse").val() 
	    };
	    $.ajax({
		    data:  parametros,
		    url:   root,
		    type:  'post',
		    success:  function (response) {
		    	$('#registrarAsesoria').trigger("reset");
		    	$( ":mobile-pagecontainer" ).pagecontainer( "change", "#registroCorrectoScreen", { 
					role: "dialog"
				});
		    },
		    error: function(xhr, status){
		    	$( ":mobile-pagecontainer" ).pagecontainer( "change", "#materiaTemaScreen", { 
					role: "dialog"
				});
		    }
		});
	}else{
		$( ":mobile-pagecontainer" ).pagecontainer( "change", "#materiaTemaScreen", { 
			role: "dialog"
		});
	}
	return false;
});


/************CALIFICAR CURSO**************/
function listarCursos () {
	var parametros = {
        "mobile" : 'listarCursos',
        "codigo" : localStorage.getItem("CodigoUsuario")
    };
    $.ajax({
		data:  parametros,
		url:   root,
		type:  'post',
		success:  function (response) {
			if(response == "empty"){
				try{
        			$("#collapAsistenciaCurso").html("<div data-role='collapsible'><h4>No hay cursos disponibles</h4><p>Vuelve mas tarde.</p></div>").collapsibleset("refresh")
        		}catch(e){
        			console.log("Excepción controlada");
        		}
			}else{
				var data = JSON.parse(response);
				var struct = "";
        		for(var val in data){
        			struct += "<div data-role='collapsible'><h4>"+data[val].nombre+" - "+data[val].fecha+"</h4><button class='ui-btn' onclick=\"popupAsistenciaCurso('"+data[val].id+"')\">Añadir asistentes</button></div>";
        		}
        		try{
        			$("#collapAsistenciaCurso").html(struct).collapsibleset("refresh")
        		}catch(e){
        			console.log("Excepción controlada");
        		}
			}
		}

	});

}

function popupAsistenciaCurso (value) {
	$("#idCurso").val(value)
	$( ":mobile-pagecontainer" ).pagecontainer( "change", "#addAsistenteCursoScreen", { 
    	role: "page"
    });
}

$("#formAddAsistenciaCurso").submit(function(){
	var parametros = {
        "mobile" : 'registrarAsistenciaCurso',
        "idCurso" : $("#idCurso").val(),
        "codigo" : $("#asistenciaCursoCodigo").val()
    };
    $.ajax({
		data:  parametros,
		url:   root,
		type:  'post',
		success:  function (response) {
			if(response == "ok"){
				$("#clic").click()
				console.log("pasa");
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