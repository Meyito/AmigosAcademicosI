$( document ).ready(function() {
  		verificarSesion();
  		cargarHorario();
  		cargarTemas();
  		cargarCursos();
  		cargarCalificadores();
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

/***************SIDEBAR ESTUDIANTE CALIFICACION*****************/
$(document).on("pagecreate", "#calificacionScreen", function(){
	$(document).on("swiperight", "#calificacionScreen", function(e){
		if($(".ui-page-active").jqmData("panel") !== "open"){
			if(e.type == "swiperight"){
				$('#sidebar4').panel("open");
			}
		}
	});
});