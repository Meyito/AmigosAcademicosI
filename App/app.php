<?php

	include_once "Core/Model/Mobile/querys.php";
	$mobileQuery = new MobileQuery();
	if(isset($_POST["mobile"])){
		if($_POST["mobile"]=="login"){

			// Los datos de login llegan por post. Hace echo de un json con campos "nombre", "codigo"
			// y "tipo" (1=Admin | 2=AA | 3=User) si los datos son validos, echo "error"
			// en caso contrario
			// Recibe: $_POST["codigo"] y $_POST["password"]
			/*
			if($_POST["codigo"]=="1150972" && $_POST["password"]=="http"){
				$output = array("nombre"=>"Gerson Lázaro", "codigo"=>"1150972", "tipo"=>"1");

				echo (json_encode($output));
			}else{
				echo "error";
			}
			*/
			$array = $mobileQuery->login($_POST["codigo"],sha1($_POST["password"]));
			if(!$array){
				echo "error";
			}
			else{
				$output = array("nombre"=>$array['nombre'], "codigo"=>$array['id'], "tipo"=>$array['tipo']);
				echo (json_encode($output));
			}

		}else if($_POST["mobile"]=="signup"){
			//Los datos de registro llegan por post. Hace echo "ok" si el registro es exitoso, echo "error"
			//en caso contrario
			//Recibe: $_POST["codigo"],$_POST["nombre"],$_POST["semestre"],$_POST["correo"], $_POST["password"] y $_POST["password2"]
			$query = $mobileQuery->registrar($_POST["codigo"],$_POST["nombre"],$_POST["correo"],$_POST["semestre"],$_POST["password"],$_POST["password2"]);
			if($query){
				echo "ok";
			}
			else{
				echo "error";
			}


		}else if($_POST["mobile"]=="registrarCalificacionAsesoria"){
			//En este punto se inserta en la base de datos la calificación de una asesoria. Se recibe
			//$_POST["idAsesoria"] que guarda el identificador de la asesoria
			//$_POST["puntaje"] Valor numerico de la calificacion, de 1 a 5
        	//$_POST["comentario"] Comentario de la asesoría
        	//$_POST["estudiante"] Código del estudiante
        	//devuelve echo "ok" si funciona, echo "error" en caso contrario
        	$query = $mobileQuery->registrarCalificacionAsesoria($_POST["idAsesoria"],$_POST["puntaje"],$_POST["comentario"],$_POST["estudiante"]);
        	if($query){
        		echo "ok";
        	}
        	else{
        		echo "error";
        	}



		}else if($_POST["mobile"]=="registrarCalificacionCurso"){
			//En este punto se inserta en la base de datos la calificación de una asesoria. Se recibe
			//$_POST["idAsesoria"] que guarda el identificador de la asesoria
			//$_POST["puntaje"] Valor numerico de la calificacion, de 1 a 5
        	//$_POST["comentario"] Comentario de la asesoría
        	//$_POST["estudiante"] Código del estudiante
        	//devuelve echo "ok" si funciona, echo "error" en caso contrario
        	$query = $mobileQuery->registrarCalificacionCurso($_POST["idCurso"],$_POST["puntaje"],$_POST["estudiante"]);
        	if($query){
        		echo "ok";
        	}
        	else{
        		echo "error";
        	}



		}else if($_POST["mobile"]=="registrarAsesoria"){
			//Registra una asesoria en el sistema
			//Recibe $_POST["materia"] Que trae el CODIGO de la materia
			//$_POST["tema"] Que trae el ID del tema
			//$_POST["codigo"] Código del ESTUDIANTE
			//$_POST["comentario"] Comentario enviado
			//Guarda en la BD y retorna echo "ok" o echo "error" segun corresponda 
			$query = $mobileQuery->registrarAsesoria($_POST["materia"],$_POST["tema"],$_POST["codigoAmigo"],$_POST["codigo"],$_POST["comentario"]);
        	if($query){
        		echo "ok";
        	}
        	else{
        		echo "error";
        	}

		}else if($_POST["mobile"]=="registrarAsistenciaCurso"){
			//Registra en la base de datos la asistencia a un curso
			//Recibe $_POST["idCurso"] con el id del curso y
			//$_POST["codigo"] con el código del estudiante
			//Retorna echo "ok" o echo "error" según corresponda
			$query = $mobileQuery->registrarAsistenciaCurso($_POST["idCurso"],$_POST["codigo"]);
        	if($query){
        		echo "ok";
        	}
        	else{
        		echo "error";
        	}

		}else if($_POST["mobile"]=="registrarTema"){
			//Registra un tema en la bd. Recibe $_POST["tema"] con el nombre del tema
			// y $_POST["codigoMateria"] Con el código de la materia que representa al tema
			//Retorna echo "ok" o echo "error" según corresponda
			$query = $mobileQuery->registrarTema($_POST["tema"],$_POST["codigoMateria"]);
        	if($query){
        		echo "ok";
        	}
        	else{
        		echo "error";
        	}
        	//REVISAR ESTE METODO
		}else if($_POST["mobile"]=="editarCurso"){
			//Edita un curso existente en la BD
			//Recibe por $_POST:
			//"id" (ID propio del curso)
			//"idMateria"
			//"idTema"
			//"idAmigo"
			//"fecha"
			//"hora"
			//"descripcion"
			//Retorna echo "ok" o echo "error" según corresponda
			$query = $mobileQuery->editarCurso($_POST["id"],$_POST["idMateria"],$_POST["idTema"],$_POST["idAmigo"],$_POST["fecha"],$_POST['hora'],$_POST["descripcion"]);
        	if($query){
        		echo "ok";
        	}
        	else{
        		echo "error";
        	}
		}else if($_POST["mobile"]=="eliminarCurso"){
			//Elimina el curso con el id que recibe el $_POST["id"]
			//Retorna echo "ok" o echo "error" según corresponda
			$query = $mobileQuery->eliminarCurso($_POST["id"]);
        	if($query){
        		echo "ok";
        	}
        	else{
        		echo "error";
        	}
        	//REVISAR ESTE METODO
		}else if($_POST["mobile"]=="crearCurso"){
			//Crea un curso en la BD con los datos recibidos
			//Recibe por $_POST:
			//"idMateria"
			//"idTema"
			//"idAmigo"
			//"fecha"
			//"hora"
			//"descripcion"
			//Retorna echo "ok" o echo "error" según corresponda
			$query = $mobileQuery->crearCurso($_POST["idTema"],$_POST["descripcion"],$_POST["idAmigo"],$_POST["fecha"],$_POST["hora"],$_POST["idMateria"]);
        	if($query){
        		echo "ok";
        	}
        	else{
        		echo "error";
        	}

		}else if($_POST["mobile"]=="actualizarAmigo"){
			//Actualiza un amigo en la BD. Los siguientes datos llegan por $_POST
			//"mobile"
			//"codigo"
			//"nombre"
			//"email"
			//"semestre"
			//Retorna echo "ok" o echo "error" según corresponda
			$query = $mobileQuery->actualizarAmigo($_POST["codigo"],$_POST["nombre"],$_POST["email"],$_POST["semestre"]);
        	if($query){
        		echo "ok";
        	}
        	else{
        		echo "error";
        	}

		}else if($_POST["mobile"]=="nuevoAmigo"){
			//Registra un nuevo amigo en la BD. Recibe por $_POST los siguientes valores:
			//"mobile"
			//"codigo"
			//"nombre"
			//"email"
			//"semestre"
			//Retorna echo "ok" o echo "error" según corresponda
			$query = $mobileQuery->nuevoAmigo($_POST["codigo"],$_POST["nombre"],$_POST["email"],$_POST["semestre"],$_POST["password"],$_POST["password2"]);
        	if($query){
        		echo "ok";
        	}
        	else{
        		echo "error";
        	}
		}
	}else if(isset($_GET["mobile"])){

		if($_GET["mobile"]=="horario"){
			//Retorna un JSON donde la clave será la combinación de dia hora (12 Representa dia 1(lunes) a las 2pm)
			//y el valor serán los Amigos académicos, separados por -. Ver ejemplo
			/*
			$output = array(
				"12" => "Denis Isidro - Yurley Rojas",
				"13" => "Denis Isidro - Andrea Angarita",
				"14" => "Arturo Saavedra - Jorge Pulido",
				"15" => "Jorge Pulido - Nancy Alvarez",
				"16" => "Denis Isidro - Yurley Rojas",
				"22" => "Arturo Saavedra - Jorge Pulido",
				"23" => "Jorge Pulido - Nancy Alvarez",
				"24" => "Denis Isidro - Yurley Rojas",
				"25" => "Denis Isidro - Andrea Angarita",
				"26" => "Arturo Saavedra - Jorge Pulido",
				"32" => "Jorge Pulido - Nancy Alvarez",
				"33" => "Denis Isidro - Yurley Rojas",
				"34" => "Denis Isidro - Andrea Angarita",
				"35" => "Arturo Saavedra - Jorge Pulido",
				"36" => "Jorge Pulido - Nancy Alvarez",
				"42" => "Denis Isidro - Yurley Rojas",
				"43" => "Denis Isidro - Andrea Angarita",
				"44" => "Arturo Saavedra - Jorge Pulido",
				"45" => "Jorge Pulido - Nancy Alvarez",
				"46" => "Denis Isidro - Yurley Rojas",
				"51" => "Denis Isidro - Andrea Angarita",
				"52" => "Arturo Saavedra - Jorge Pulido",
				"53" => "Jorge Pulido - Nancy Alvarez",
				"54" => "Denis Isidro - Yurley Rojas",
				"55" => "Denis Isidro - Andrea Angarita",
				"56" => "Denis Isidro - Yurley Rojas",
			);
			*/
			$array = $mobileQuery->horario();
			$output = array();
			$index = 0;
			while($index<sizeof($array)){
				if(array_key_exists($array[$index][0]+$array[$index][1]+"",$output)){
					$output[$array[$index][0].$array[$index][1]] += " - " + $array[$index][2];
				}
				else{
					$output[$array[$index][0].$array[$index][1]] = $array[$index][2];
				}
				$index++;
			}
			echo json_encode($output);



		}else if($_GET["mobile"]=="temasSemana"){
			// Retorna la lista de temas de la semana con sus respectivas materias, como en el ejemplo siguiente:
			// La clave es el tema, el valor la materia
			$array = $mobileQuery->temasSemana();
			$output = array();
			$index = 0;
			while($index<sizeof($array)){
				$output[$array[$index][0]] = $array[$index][1];
				$index++;
			}
			/*
			$output = array(
				"Herencia" => "POO",
				"Polimorfismo" => "Fundamentos",
				"Derivadas" => "Calculo",
				"Inferencia" => "Matemáticas Discretas"
			);
			*/
			echo json_encode($output);




		}else if($_GET["mobile"]=="proximosCursos"){
			// Retorna los cursos con el formato indicado.
			// como en el siguiente ejemplo.
			// El nombre es el tema
			// La fecha debe estar "AAAA-MM-DD" y la hora "HH:MM" en formato 24h
			$array = $mobileQuery->proximosCursos();
			$output = array();
			$index = 0;
			while($index<sizeof($array)){
				$output[($index+1).""] = array(
									"id" => $array[$index][0],
									"nombre" => $array[$index][1],
									"descripcion" => $array[$index][2],
									"amigo" => $array[$index][3],
									"fecha" => $array[$index][4],
									"hora" => $array[$index][5],
									"materia" => $array[$index][6]);
				$index++;
			}
			/*
			$output = array(
				"1" => array(
					"id" => "1",
					"nombre" => "Variables",
					"descripcion" => "Descripción",
					"amigo" => "Arturo Saavedra",
					"fecha" => "2015-03-12",
					"hora" => "15:00",
					"materia" => "Discretas"
					),
				"2" => array(
					"id" => "2",
					"nombre" => "Curso Poo",
					"descripcion" => "Descripción",
					"amigo" => "Yurley Rojas",
					"fecha" => "3412-03-24",
					"hora" => "03:00",
					"materia" => "POO"
					),
				"3" => array(
					"id" => "3",
					"nombre" => "Curso Poo",
					"descripcion" => "Descripción",
					"amigo" => "Yurley Rojas",
					"fecha" => "3412-03-24",
					"hora" => "15:00",
					"materia" => "POO"
					),
				"4" => array(
					"id" => "4",
					"nombre" => "Curso Poo",
					"descripcion" => "Descripción",
					"amigo" => "Yurley Rojas",
					"fecha" => "3412-03-24",
					"hora" => "15:00",
					"materia" => "POO"
					),
				"5" => array(
					"id" => "5",
					"nombre" => "Curso Poo",
					"descripcion" => "Descripción",
					"amigo" => "Yurley Rojas",
					"fecha" => "3412-03-24",
					"hora" => "15:00",
					"materia" => "POO"
					)
			);
			*/
			echo json_encode($output);




		}else if($_GET["mobile"]=="calificacionAsesoria"){
			//Recibe un $_GET["codigo"] con el código del usuario para el que voy a cargar las calificaciones por realizar
			//Que tiene pendientes por realizar. Retorna identificador de la asesoria, Materia, Tema, Amigo y Fecha. Usar el mismo para cursos.
			
			//IMPORTANTE: Si no hay nada por calificar, hacer solo echo "ok";
			$array = $mobileQuery->listarCursos($_GET["amigo"]);
			$output = array();
			$index = 0;
			while($index<sizeof($array)){
				$output[($index+1).""] = array(
									"id" => $array[$index][0],
									"materia" => $array[$index][1],
									"tema" => $array[$index][2],
									"amigo" => $array[$index][3],
									"fecha" => $array[$index][4]);
				$index++;
			}
			/*
			$output = array(
				"1" => array(
					"id" => "132",
					"materia" => "POO",
					"tema" => "Herencia",
					"amigo" => "Denis Isidro",
					"fecha" => "64-12-2012"
					),
				"2" => array(
					"id" => "132",
					"materia" => "Calculo",
					"tema" => "Curso Integrales",
					"amigo" => "Denis Isidro",
					"fecha" => "64-12-2012"
					),
				"3" => array(
					"id" => "132",
					"materia" => "POO",
					"tema" => "Herencia",
					"amigo" => "Denis Isidro",
					"fecha" => "64-12-2012"
					),
				"4" => array(
					"id" => "132",
					"materia" => "POO",
					"tema" => "Herencia",
					"amigo" => "Denis Isidro",
					"fecha" => "64-12-2012"
					)
			);
			*/
			echo json_encode($output);	




		}else if($_GET["mobile"]=="calificacionCurso"){
			//Recibe un $_GET["codigo"] con el código del usuario para el que voy a cargar las calificaciones por realizar
			//Que tiene pendientes por realizar. Retorna identificador de la asesoria, Materia, Tema, Amigo y Fecha. Usar el mismo para cursos.
			
			//IMPORTANTE: Si no hay nada por calificar, hacer solo echo "ok";
			$array = $mobileQuery->listarCursos($_GET["amigo"]);
			$output = array();
			$index = 0;
			while($index<sizeof($array)){
				$output[($index+1).""] = array(
									"id" => $array[$index][0],
									"materia" => $array[$index][1],
									"tema" => $array[$index][2],
									"amigo" => $array[$index][3],
									"fecha" => $array[$index][4]);
				$index++;
			}
			/*
			$output = array(
				"1" => array(
					"id" => "132",
					"materia" => "POO",
					"tema" => "Herencia",
					"amigo" => "Denis Isidro",
					"fecha" => "64-Diciemre-2012, 3:00PM"
					),
				"2" => array(
					"id" => "132",
					"materia" => "Calculo",
					"tema" => "Curso Integrales",
					"amigo" => "Denis Isidro",
					"fecha" => "64-Diciemre-2012, 3:00PM"
					),
				"3" => array(
					"id" => "132",
					"materia" => "POO",
					"tema" => "Herencia",
					"amigo" => "Denis Isidro",
					"fecha" => "64-Diciemre-2012, 3:00PM"
					),
				"4" => array(
					"id" => "132",
					"materia" => "POO",
					"tema" => "Herencia",
					"amigo" => "Denis Isidro",
					"fecha" => "64-Diciemre-2012, 3:00PM"
					)
			);
			*/
			echo json_encode($output);	




		}else if($_GET["mobile"]=="cargarMaterias"){
			//Aqui retorna una lista de materias con el siguiente formato (Código de la materia => nombre de la materia):
			$array = $mobileQuery->cargarMaterias();
			$output = array();
			$index = 0;
			while($index<sizeof($array)){
				$output[$array[$index][0]] = $array[$index][1];
				$index++;
			}
			/*
			$output = array(
				"115093" => "calculo",
				"113232" => "POO",
				"343434" => "Discretas"
			);
			*/
			echo json_encode($output);




		}else if($_GET["mobile"]=="cargarTemas"){
			//Aqui retorna una lista de temas de una materia especifica con el siguiente formato 
			//(id del tema => nombre del tema):
			//IMPORTANTE: La materia de la que se obtienen los temas llega como $_GET["materia"]
			$array = $mobileQuery->cargarTemas($_GET["materia"]);
			$output = array();
			$index = 0;
			while($index<sizeof($array)){
				$output[$array[$index][0]] = $array[$index][1];
				$index++;
			}
			/*
			$output = array(
				"115093" => "Herencia",
				"113232" => "Polimorfismo",
				"343434" => "Variables"
			);
			*/
			echo json_encode($output);



		}else if($_GET["mobile"]=="listarCursos"){
			//Lista el id del curso, el nombre (que será el nombre del tema), y la fecha
			//Esto es para la sección agregar asistencia a cursos del amigo académico
			//Donde se listan los cursos para que el amigo seleccione uno y agregue la asistencia
			$array = $mobileQuery->listarCursos($_GET["amigo"]);
			$output = array();
			$index = 0;
			while($index<sizeof($array)){
				$output[($index+1).""] = array(
									"id" => $array[$index][0],
									"nombre" => $array[$index][1],
									"fecha" => $array[$index][2]);
				$index++;
			}
			/*
			$output = array(
				"1" => array(
					"id" => "4",
					"nombre" => "Polimorfismo",
					"fecha" => "06-dic-2014"
				),
				"2" => array(
					"id" => "4",
					"nombre" => "Herencia",
					"fecha" => "06-dic-2014"
				),
				"3" => array(
					"id" => "4",
					"nombre" => "Clases",
					"fecha" => "06-dic-2014"
				),
			);
			*/
			//Si no hay cursos:
			//echo "empty";
			if(empty($output)){
				echo "empty";
			}
			else{
				echo json_encode($output);
			}
			



		}else if($_GET["mobile"]=="cargarListaAmigos"){
			//Retorna una lista de codigo-nombre de amigos académicos
			$array = $mobileQuery->cargarListaAmigos();
			$output = array();
			$index = 0;
			while($index<sizeof($array)){
				$output[$array[$index][0]] = $array[$index][1];
				$index++;
			}
			/*
			$output = array(
				"12321" => "Andrea Angarita",
				"1134" => "Denis Isidro",
				"145667" => "Arturo Saavedra"
			);
			*/
			echo json_encode($output);



		}else if($_GET["mobile"]=="obtenerDatosAA"){
			//Obtiene los datos del amigo académico cuyo código es $_GET["codigoAA"]
			//Devolver con el siguiente formato
			$array = $mobileQuery->obtenerDatosAA($_GET["codigoAA"]);
			$output = array(
				"codigo" => $array[0],
				"nombre" => $array[1],
				"email" => $array[2],
				"semestre" => $array[3]
			);
			
			echo json_encode($output);

		}
	}


?>