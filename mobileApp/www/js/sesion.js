/**
Variables localStorage:
NombreUsuario
CodigoUsuario
TipoUsuario 1 = Admin || 2 = Amigo || 3 = Estudiante
*/	


	$( document ).ready(function() {
  		cambiarVista();
	});


	/*************Cambiar Vista************/
	function cambiarVista(){
		if(localStorage.getItem('TipoUsuario') != null){
  			if(localStorage.getItem('TipoUsuario') == "1"){

  			}else if(localStorage.getItem('TipoUsuario') == "2"){

  			}else if(localStorage.getItem('TipoUsuario') == "3"){
  				window.location.href = "inicioEstudiante.html";
  			}
  		}
	}




	/*******LOGIN DE USUARIO**************/
    $('#login').submit(function() {  
		var parametros = {
        		"mobile" : 'login',
                "codigo" : $("#codigo").val(),
                "password" : $("#password").val()
        };
        $.ajax({
                data:  parametros,
                url:   root,
                type:  'post',
                success:  function (response) {
                        if(response=="error"){
                        	$( ":mobile-pagecontainer" ).pagecontainer( "change", "#errorLoginDialog", { 
						    	role: "dialog"
						    });
                        }else{
                        	var data = JSON.parse(response);
                        	localStorage.setItem("NombreUsuario", data.nombre);
                        	localStorage.setItem("CodigoUsuario", data.codigo);
                        	localStorage.setItem("TipoUsuario", data.tipo);
                        	cambiarVista();
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




	/********REGISTRO DE USUARIO*********/
	 $('#registro').submit(function() {  
	 	if($("#passwordR").val() != $("#password2").val()){
	 		$( ":mobile-pagecontainer" ).pagecontainer( "change", "#errorPasswordDialog", { 
		    	role: "dialog"
			});
	 	}else{
	 		var parametros = {
        		"mobile" : 'signup',
                "codigo" : $("#codigoR").val(),
                "nombre" : $("#nombre").val(),
                "semestre" : $("#semestre").val(),
                "correo" : $("#correo").val(),
                "password" : $("#passwordR").val(),
                "password2" : $("#password2").val()
	        };
	        $.ajax({
	                data:  parametros,
	                url:   root,
	                type:  'post',
	                success:  function (response) {
	                        if(response=="ok"){
	                        	$( ":mobile-pagecontainer" ).pagecontainer( "change", "#successSignupDialog", { 
							    	role: "dialog"
							    });
	                        }else{
	                        	$( ":mobile-pagecontainer" ).pagecontainer( "change", "#errorSignupDialog", { 
							    	role: "dialog"
							    });
	                        }
	                },
	                error : function(xhr, status) {
				        $( ":mobile-pagecontainer" ).pagecontainer( "change", "#errorRedScreen", { 
							role: "dialog"
					    });
				    }
	        });
	    }
		return false;

	});

