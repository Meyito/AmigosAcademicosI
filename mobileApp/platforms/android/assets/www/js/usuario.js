$( document ).ready(function() {
  		verificarSesion();
  		cargarHorario();
  		cargarTemas();
  		cargarCursos();
});

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
        type:  'post',
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
        type:  'post',
        success:  function (response) {
        	var data = JSON.parse(response);
        	var dataToStore = JSON.stringify(data);
        	localStorage.setItem('temasEstudiante', dataToStore);
	        construirTemas(data);
        }	
	});
}
function construirTemas(data){
	var struct = "<tr><th>Materia</th><th>Tema</th></tr>";
	for(var val in data){
   		struct += "<tr><td>"+data[val]+"</td><td>"+val+"</td></tr>";
   	}
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
        type:  'post',
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
   		struct += "<tr><th colspan='2'>"+data[val].nombre+"</th></tr><tr><td>"+data[val].fecha+"</td><td>"+data[val].amigo+"</td></tr>";
   	}
   	$("#tablaCursos").html(struct)
}