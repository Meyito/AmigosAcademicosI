/**
*	Libreria para el manejo de sesiones
*	@author Gerson Lázaro - Melissa Delgado - Daniel Vega
*	@date 15-12-2015
*/

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

	$( document ).ready(function() {
  		cambiarVista();
	});

	/**
	*	Desplega información cuando se presenta un error de red
	*/
	function errorDeRed () {
		$( ":mobile-pagecontainer" ).pagecontainer( "change", "#errorRedScreen", { 
			role: "dialog"
		});
	}

	/**
	*	Enrutador de la aplicación.
	*/
	function cambiarVista(){
		if(localStorage.getItem('TipoUsuario') != null){
  			if(localStorage.getItem('TipoUsuario') == "1"){
  				window.location.href = "inicioAdmin.html";
  			}else if(localStorage.getItem('TipoUsuario') == "2"){
  				window.location.href = "inicioAmigo.html";
  			}else if(localStorage.getItem('TipoUsuario') == "3"){
  				window.location.href = "inicioEstudiante.html";
  			}
  		}
	}




	/**
	*	Inicio de sesión
	*/
    $('#login').submit(function() {  
		var parametros = {
        		"mobile" : 'login',
                "codigo" : $("#codigo").val(),
                "password" : $("#password").val()
        };
        peticionAsincrona("post", false, null, parametros, inicioDeSesion, errorDeRed);
		return false;
		
	});

	/**
	*	Funcion encargada de la redirección al iniciar sesión
	*/
	function inicioDeSesion(response){
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
	}


	/**
	*	Registro de usuario	
	*/
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
	        peticionAsincrona("post", false, null, parametros, signup, errorDeRed);
	    }
		return false;

	});

	function signup (response) {
		if(response=="ok"){
	        $( ":mobile-pagecontainer" ).pagecontainer( "change", "#successSignupDialog", { 
				role: "dialog"
			});
	    }else{
	        $( ":mobile-pagecontainer" ).pagecontainer( "change", "#errorSignupDialog", { 
				role: "dialog"
			});
	    }
	}
