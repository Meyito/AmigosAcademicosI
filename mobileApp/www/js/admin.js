$( document ).ready(function() {
  		verificarSesion();
  		cargarHorario();
  		cargarTemas();
  		cargarMateriasRegistroAsesoria();
  		
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
		    		$('#registrarAsesoria').trigger("reset");
			    	$( ":mobile-pagecontainer" ).pagecontainer( "change", "#registroCorrectoScreen", { 
						role: "dialog"
					});
		    	}else{
		    		$('#registrarAsesoria').trigger("reset");
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