

/*****************VERIFICAR SESION*****************/
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



/***************SIDEBAR ESTUDIANTE INICIO*****************/
$(document).on("pagecreate", "#inicio", function(){
	$(document).on("swiperight", "#inicio", function(e){
		if($(".ui-page-active").jqmData("panel") !== "open"){
			if(e.type == "swiperight"){
				$('#sidebar').panel("open");
			}
		}
	});
});

/***************SIDEBAR ESTUDIANTE TEMAS*****************/
$(document).on("pagecreate", "#temasScreen", function(){
	$(document).on("swiperight", "#temasScreen", function(e){
		if($(".ui-page-active").jqmData("panel") !== "open"){
			if(e.type == "swiperight"){
				$('#sidebar2').panel("open");
			}
		}
	});
});
/***************SIDEBAR ESTUDIANTE CURSOS*****************/
$(document).on("pagecreate", "#cursosScreen", function(){
	$(document).on("swiperight", "#cursosScreen", function(e){
		if($(".ui-page-active").jqmData("panel") !== "open"){
			if(e.type == "swiperight"){
				$('#sidebar3').panel("open");
			}
		}
	});
});


$("#cerrarSesion").click(cerrarSesion);
$("#cerrarSesion1").click(cerrarSesion);
$("#cerrarSesion2").click(cerrarSesion);
$("#cerrarSesion3").click(cerrarSesion);
$("#cerrarSesion4").click(cerrarSesion);
$("#cerrarSesion5").click(cerrarSesion);
$("#cerrarSesion6").click(cerrarSesion);
$("#cerrarSesion7").click(cerrarSesion);
$("#cerrarSesion8").click(cerrarSesion);




function cerrarSesion () {
	localStorage.clear();
	verificarSesion();
}



/*************HORARIO****************/
function cargarHorario () {
	if(localStorage.getItem("horarioEstudiante")!=null){
		construirHorario(JSON.parse(localStorage.getItem("horarioEstudiante")));
	}
	var parametros = {
        "mobile" : 'horario'
    };
	$.ajax({
		data:  parametros,
        url:   root,
        type:  'get',
        success:  function (response) {
        	var data = JSON.parse(response);
        	var dataToStore = JSON.stringify(data);
        	localStorage.setItem('horarioEstudiante', dataToStore);
        	construirHorario(data);
        }	
	});
}

function construirHorario (data) {
	for(var val in data){
   		$("#"+val).html(data[val])
   	}
}





/********TEMAS DE LA SEMANA*********/
function cargarTemas(){
	if(localStorage.getItem("temasEstudiante")!=null){
		construirTemas(JSON.parse(localStorage.getItem("temasEstudiante")));
	}

	var parametros = {
        "mobile" : 'temasSemana'
    };
    $.ajax({
		data:  parametros,
        url:   root,
        type:  'get',
        success:  function (response) {

        	var data = JSON.parse(response);
        	var dataToStore = JSON.stringify(data);
        	localStorage.setItem('temasEstudiante', dataToStore);
	        construirTemas(data);
        }	
	});
}
function construirTemas(data){
	var struct = "<thead><tr><th>Materia</th><th>Tema</th></tr></thead><tbody>";
	for(var val in data){
   		struct += "<tr><td>"+data[val]+"</td><td>"+val+"</td></tr>";
   	}
   	struct += "</tbody>";
    $("#tablaTemas").html(struct)
}

/********PRÓXIMOS CURSOS*********/
function cargarCursos(){
	if(localStorage.getItem("cursosEstudiante")!=null){
		construirCursos(JSON.parse(localStorage.getItem("cursosEstudiante")));
	}

	var parametros = {
        "mobile" : 'proximosCursos'
    };
    $.ajax({
		data:  parametros,
        url:   root,
        type:  'get',
        success:  function (response) {
        	var data = JSON.parse(response);
        	var dataToStore = JSON.stringify(data);
        	localStorage.setItem('cursosEstudiante', dataToStore);
        	construirCursos(data);
        }	
	});
}

function construirCursos (data) {
	var struct = "";
   	for(var val in data){
   		struct += "<tr><th colspan='2'>"+data[val].nombre+"</th></tr><tr><td>"+data[val].fecha+" "+data[val].hora+"</td><td>"+data[val].amigo+"</td></tr>";
   	}
   	$("#tablaCursos").html(struct)
}




/************CALIFICACIONES***************/
function cargarCalificadores(){
	var parametros = {
        "mobile" : 'calificacion',
        "codigo" : localStorage.getItem("CodigoUsuario")
    };
    $.ajax({
		data:  parametros,
        url:   root,
        type:  'get',
        success:  function (response) {

        	if(response=="ok"){
        		try{
        			$("#calificaciones").html("<div data-role='collapsible'><h4>No hay calificaciones pendientes</h4><p>Vuelve mas tarde.</p></div>").collapsibleset("refresh")
        		}catch(e){
        			console.log("Excepción controlada");
        		}
        	}else{
        		var data = JSON.parse(response);
        		var struct = "";
        		for(var val in data){
        			struct += "<div data-role='collapsible'><h4>"+data[val].materia+" - "+data[val].tema+ " - " + data[val].amigo +" - "+ data[val].fecha+"</h4><button class='ui-btn' onclick=\"popupCalificar('"+data[val].id+"')\">Calificar Esta asesoría</button></div>";
        		}
        		try{
        			$("#calificaciones").html(struct).collapsibleset("refresh")
        		}catch(e){
        			console.log("Excepción controlada");
        		}
        	}
        	
        	
        }	
	});
}
$("#verifyAsesoria").click(cargarCalificadores)

function popupCalificar (value) {
	$("#calificacionID").val(value)
	$( ":mobile-pagecontainer" ).pagecontainer( "change", "#popupCalificacion", { 
    	role: "dialog"
    });
}



/*******CALIFICAR ASESORIA*******/

 $('#calificacionForm').submit(function() {  
 	var parametros = {
   		"mobile" : 'registrarCalificacion',
        "idAsesoria" : $("#calificacionID").val(),
        "puntaje" : $("#puntaje").val(),
        "comentario" : $("#comentario").val(),
        "estudiante" : localStorage.getItem("CodigoUsuario")
    };
    $.ajax({
            data:  parametros,
            url:   root,
            type:  'post',
            success:  function (response) {
                if(response=="error"){
                   	$( ":mobile-pagecontainer" ).pagecontainer( "change", "#errorRedScreen", { 
   				    	role: "dialog"
				    });
                }else{
                   	$( ":mobile-pagecontainer" ).pagecontainer( "change", "#successCalificacion", { 
   				    	role: "dialog"
				    });
                }
            },
            error : function(xhr, status) {
			    $( ":mobile-pagecontainer" ).pagecontainer( "change", "#errorRedScreen", { 
					role: "dialog",
				   	transition: "pop"
			    });
			}
        });
 	return false;
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
	    type:  'get',
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