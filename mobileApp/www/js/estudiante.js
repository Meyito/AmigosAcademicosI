$( document ).ready(function() {
  		verificarSesion();
  		cargarHorario();
  		cargarTemas();
  		cargarCursos();
  		cargarCalificadores();
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