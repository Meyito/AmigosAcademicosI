<?php


	
	if(isset($_POST["mobile"])){
		if($_POST["mobile"]=="login"){

			// Los datos de login llegan por post. Hace echo de un json con campos "nombre", "codigo"
			// y "tipo" (1=Admin | 2=AA | 3=User) si los datos son validos, echo "error"
			// en caso contrario
			// Recibe: $_POST["codigo"] y $_POST["password"]

			if($_POST["codigo"]=="1150972" && $_POST["password"]=="http"){
				$output = array("nombre"=>"Gerson Lázaro", "codigo"=>"1150972", "tipo"=>"3");
				echo (json_encode($output));
			}else{
				echo "error";
			}
		}else if($_POST["mobile"]=="signup"){
			//Los datos de registro llegan por post. Hace echo "ok" si el registro es exitoso, echo "error"
			//en caso contrario
			//Recibe: $_POST["codigo"],$_POST["nombre"],$_POST["semestre"],$_POST["correo"], $_POST["password"] y $_POST["password2"]
			echo "ok";
		}else if($_POST["mobile"]=="horario"){
			//Retorna un JSON donde la clave será la combinación de dia hora (12 Representa dia 1(lunes) a las 2pm)
			//y el valor serán los Amigos académicos, separados por -. Ver ejemplo
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
			echo json_encode($output);
		}else if($_POST["mobile"]=="temasSemana"){
			// Retorna la lista de temas de la semana con sus respectivas materias, como en el ejemplo siguiente:
			// La clave es el tema, el valor la materia
			$output = array(
				"Herencia" => "POO",
				"Polimorfismo" => "Fundamentos",
				"Derivadas" => "Calculo",
				"Inferencia" => "Matemáticas Discretas"
			);
			echo json_encode($output);
		}else if($_POST["mobile"]=="proximosCursos"){
			// Retorna los cursos con el formato indicado.
			// como en el siguiente ejemplo.
			$output = array(
				"1" => array(
					"nombre" => "Curso Poo",
					"amigo" => "Yurley Rojas",
					"fecha" => "06-03-1224"
					),
				"2" => array(
					"nombre" => "Curso Poo",
					"amigo" => "Yurley Rojas",
					"fecha" => "06-03-1224"
					),
				"3" => array(
					"nombre" => "Curso Poo",
					"amigo" => "Yurley Rojas",
					"fecha" => "06-03-1224"
					),
				"4" => array(
					"nombre" => "Curso Poo",
					"amigo" => "Yurley Rojas",
					"fecha" => "06-03-1224"
					),
				"5" => array(
					"nombre" => "Herencia",
					"amigo" => "Yurley Rojas",
					"fecha" => "06-03-1224"
					)
			);
			echo json_encode($output);
		}else if($_POST["mobile"]=="calificacion"){
			//Recibe un $_POST["codigo"] con el código del usuario para el que voy a cargar las calificaciones
			//Que tiene pendientes por realizar. Retorna identificador de la asesoria, Materia, Tema, Amigo y Fecha. Usar el mismo para cursos.
			
			//IMPORTANTE: Si no hay nada por calificar, hacer solo echo "ok";
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
			
			echo json_encode($output);	
		}else if($_POST["mobile"]=="registrarCalificacion"){
			//En este punto se inserta en la base de datos la calificación de una asesoria. Se recibe
			//$_POST["idAsesoria"] que guarda el identificador de la asesoria
			//$_POST["puntaje"] Valor numerico de la calificacion, de 1 a 5
        	//$_POST["comentario"] Comentario de la asesoría
        	//$_POST["estudiante"] Código del estudiante
        	//devuelve echo "ok" si funciona, echo "error" en caso contrario
        	echo "ok";
		}
	}

?>