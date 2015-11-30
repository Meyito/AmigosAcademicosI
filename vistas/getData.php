<?php

// $_GET["peticion"] indica que es lo que está solicitando
// $_GET["asistenciaCursoAA"]  indica el amigo academico del que se desean ver los cursos

if($_GET["peticion"] == "promedioAACalificacionCurso"){

	/* retorna eñ siguiente formato
	$numero = '{
	  "promedio" : "4.32"
	}';
	*/
	if($_GET["promedioCursoAA"] == "Todos"){
		// carga el promedio total
		$numero = '{"promedio" : 4.32}';
	}else{
		//Va a la base de datos y busca el id del amigo académico guardado en $_GET["idPromAmigo"]
		//carga el promedio del amigo elegido
		$numero = '{"promedio" : 4.71}';
	}

	echo $numero;

	
}else if($_GET["peticion"] == "asistenciaCursosAA"){
	/*
		El string que esto retorna debe llevar este formato: 
		$string = '{
		  "cols": [
		        {"label":"Curso","type":"string"},
		        {"label":"No. Estudiantes","type":"number"}
		      ],
		  "rows": [
		        {"c":[{"v":"Nombre del curso"},{"v":3}]},
		        {"c":[{"v":"Nombre del curso"},{"v":1}]},
		        {"c":[{"v":"Nombre del curso"},{"v":3}]},
		        {"c":[{"v":"Nombre del curso"},{"v":5}]},
		        {"c":[{"v":"Nombre del curso"},{"v":8}]},
		        {"c":[{"v":"Nombre del curso"},{"v":1}]}
		      ]
		}';


	*/


	if($_GET["asistenciaCursoAA"] == "Todos"){

		// Crea el string con todos los valores
		$string = '{ "cols": [{"label":"Curso","type":"string"},{"label":"No. Estudiantes","type":"number"}],"rows": [ {"c":[{"v":"Calculo Proposicional"},{"v":"2"}]},{"c":[{"v":"Vectores"},{"v":"1"}]},{"c":[{"v":"Calculo de Predicados"},{"v":"2"}]}]}';
	}else{

		//Va a la base de datos y busca el id del amigo académico guardado en $_GET["asistenciaCursoAA"]
		//Crea el string solo con los datos de ese amigo	
		$string = '{
		  "cols": [
		        {"label":"Curso","type":"string"},
		        {"label":"No. Estudiantes","type":"number"}
		      ],
		  "rows": [
		        {"c":[{"v":"Nombr1"},{"v":3}]},
		        {"c":[{"v":"Nombre del curso"},{"v":1}]},
		        {"c":[{"v":"Nombre del curso"},{"v":3}]},
		        {"c":[{"v":"Nombre del curso"},{"v":5}]},
		        {"c":[{"v":"Nombre del curso"},{"v":8}]},
		        {"c":[{"v":"Nombre del curso"},{"v":1}]}
		      ]
		}';
	}
	echo $string;

}else if($_GET["peticion"] == "asistenciaMateria"){

	/*Construye un string como el que sigue*/
	$string = '{
		  "cols": [
		        {"label":"Curso","type":"string"},
		        {"label":"No. Estudiantes","type":"number"}
		      ],
		  "rows": [
		        {"c":[{"p":"ID", "v":"POO"},{"v":3}]},
		        {"c":[{"p":"ID", "v":"Calculo"},{"v":1}]},
		        {"c":[{"p":"ID", "v":"Discretas"},{"v":3}]},
		        {"c":[{"p":"1224", "v":"Estructuras"},{"v":5}]},
		        {"c":[{"p":"1254", "v":"Introducción"},{"v":8}]},
		        {"c":[{"p":"I689", "v":"Tengo hambre"},{"v":1}]}
		      ]
		}';
	echo $string;

}else if($_GET["peticion"] == "calificacionMateriaPromedio"){

	/*Devuelve un json como el siguiente*/
	$string = '{"promedio" : 3.12}';
	echo $string;

}else if($_GET["peticion"] == "ListaMaterias"){
	
	/*
	Devuelve un JSON como el siguiente
	*/
	$string = '[
		{"id": 123, "nombre" : "POO"},
		{"id": 45324, "nombre" : "Estructuras"},
		{"id": 5674, "nombre" : "TGS"},
		{"id": 576234, "nombre" : "Redes"},
	    {"id": 78, "nombre" : "Fundamentos"},
		{"id": 45, "nombre" : "Calculo"}
	]';
	echo $string;

}else if($_GET["peticion"] == "ListaTemas"){
	/*Devuelve un JSON como el siguiente con los temas de la materia indicada en $_GET["idMateria"]*/
	/*Si $_GET["idMateria"] == "todo", devolver todos los temas de la materia*/
	$string = '[
		{"id": 123, "nombre" : "Herencia"},
		{"id": 45324, "nombre" : "Polimorfismo"},
		{"id": 5674, "nombre" : "Recursividad"},
		{"id": 576234, "nombre" : "Ola"},
	    {"id": 78, "nombre" : "Ke"},
		{"id": 45, "nombre" : "Ase"}
	]';

	echo $string;
}else if($_GET["peticion"] == "TablaFrecuencia"){
	/*Este es para los estudiantes con mas frecuencia*/

	if($_GET["materia"] == "todo"){
		/*aqui devolver las generales, sin filtrar*/
		$string = '[
		{"nombre": "Estudiante 1", "asesorias": 34},
		{"nombre": "Estudiante 2", "asesorias": 12}]';
	}else if($_GET["materia"] != "todo" && $_GET["tema"] == "todo"){
		/*Aqui devolver las asesorias de estudiantes a la materia con el id $_GET["materia"]*/
		$string = '[
		{"nombre": "Estudiante 3", "asesorias": 8},
		{"nombre": "Estudiante 4", "asesorias": 32}]';
	}else{
		/*Aqui devolver las asesorias de estudiantes al tema con el id $_GET["tema"]*/
		$string = '[
		{"nombre": "Estudiante 5", "asesorias": 11}]';
	}
	echo $string;
}else if($_GET["peticion"] == "selectAsistenciaCurso"){
	/*Esto es para un select que muestra todos los amigos, debe retornar los ids y nombres de ellos*/
	$string = '[
		{"id":1 , "nombre":"Denis"},
		{"id":2 , "nombre":"Yurley"},
		{"id":3 , "nombre":"Andrea"},
		{"id":4 , "nombre":"Arturo"},
		{"id":5 , "nombre":"Jorge"}
	]';

	echo $string;


}else if($_GET["peticion"] == "asesoriaAmigo"){
	$string = '{
		  "cols": [
		        {"label":"Amigo Académico","type":"string"},
		        {"label":"No. Asesorias","type":"number"}
		      ],
		  "rows": [
		        {"c":[{"v":"Denis"},{"v":3}]},
		        {"c":[{"v":"Yurley"},{"v":1}]},
		        {"c":[{"v":"Andrea"},{"v":3}]},
		        {"c":[{"v":"Arturo"},{"v":5}]},
		        {"c":[{"v":"Jorge"},{"v":8}]},
		        {"c":[{"v":"¿Quien me falta?"},{"v":1}]}
		      ]
		}';


		echo $string;

}else if($_GET["peticion"] == "totalEstudiantes"){
	$string =  '{
		  "cols": [
		        {"label":"Estudiantes","type":"string"},
		        {"label":"Total","type":"number"}
		      ],
		  "rows": [
		        {"c":[{"v":"Asistentes al programa"},{"v":110}]},
		        {"c":[{"v":"Población total"},{"v":560}]}
		      ]
		}';
	echo $string;

}else if($_GET["peticion"] == "HistoricaMaterias"){
	$string = '{
		  "cols": [
		        {"label":"Materia","type":"string"},
		        {"label":"NOMBRE SEMESTRE I","type":"number"},
		        {"label":"NOMBRE SEMESTRE II","type":"number"}
		      ],
		  "rows": [
		        {"c":[{"v":"Poo"},{"v":34},{"v":34}]},
		        {"c":[{"v":"Estructuras"},{"v":11},{"v":34}]},
		        {"c":[{"v":"Bases"},{"v":33},{"v":34}]},
		        {"c":[{"v":"Etica"},{"v":59},{"v":34}]},
		        {"c":[{"v":"Religión"},{"v":81},{"v":34}]},
		        {"c":[{"v":"Edu. Fisica"},{"v":13},{"v":34}]}
		      ]
		}';


		echo $string;
}else if($_GET["peticion"] == "periodoPrevioI"){
	$string = '{
		  "cols": [
		        {"label":"NOMBRE SEMESTRE I","type":"string"},
		        {"label":"No. Estudiantes","type":"number"}
		      ],
		  "rows": [
		        {"c":[{"v":"Curso 1"},{"v":3}]},
		        {"c":[{"v":"Curso 2"},{"v":1}]},
		        {"c":[{"v":"Curso 3"},{"v":3}]},
		        {"c":[{"v":"Curso 4"},{"v":5}]},
		        {"c":[{"v":"Curso 5"},{"v":8}]},
		        {"c":[{"v":"Curso 6"},{"v":1}]}
		      ]
		}';
	echo $string;

}else if($_GET["peticion"] == "periodoPrevioII"){
	$string = '{
		  "cols": [
		        {"label":"NOMBRE SEMESTRE II","type":"string"},
		        {"label":"No. Estudiantes","type":"number"}
		      ],
		  "rows": [
		        {"c":[{"v":"Curso 1"},{"v":3}]},
		        {"c":[{"v":"Curso 2"},{"v":1}]},
		        {"c":[{"v":"Curso 3"},{"v":3}]},
		        {"c":[{"v":"Curso 4"},{"v":5}]},
		        {"c":[{"v":"Curso 5"},{"v":8}]},
		        {"c":[{"v":"Curso 6"},{"v":1}]}
		      ]
		}';
	echo $string;
}else if($_GET["peticion"] == "comparativa"){
	/*Nombre periodo1 y 2, es algo como la fecha o "Semestre*/
	$string = '{
  "Periodo1": {
  	"nombre": "Primer Semestre 2015",
    "calificacion": "4.3",
    "asistentes": "122",
    "estudiantes": "450",
    "porcentaje": "45"
  },
  "Periodo2": {
  	"nombre": "Segundo Semestre 2015",
    "calificacion": "4.3",
    "asistentes": "122",
    "estudiantes": "450",
    "porcentaje": "45"
  }
}';
		echo $string;


}else if($_GET["peticion"]== "EstadisticaMateriaTema"){
	/*
IMPORTANTE: en $_GET["materia"] viene la materia para la cual se cargarán los temas
	*/

	$string = '{
		  "cols": [
		        {"label":"Tema","type":"string"},
		        {"label":"No. Estudiantes","type":"number"}
		      ],
		  "rows": [
		        {"c":[{"v":"Herencia"},{"v":3}]},
		        {"c":[{"v":"Polimorfismo"},{"v":1}]},
		        {"c":[{"v":"Hola"},{"v":3}]},
		        {"c":[{"v":"Duele"},{"v":5}]},
		        {"c":[{"v":"Mi"},{"v":8}]},
		        {"c":[{"v":"Cabeza"},{"v":1}]}
		      ]
		}';
	echo $string;

}else if($_GET["peticion"]=="EstadisticaPorAmigo"){
	/*
IMPORTANTE: en $_GET["amigo"] viene el ID del amigo al cual revisaremos sus asesorias
	*/
	$string = '{
		  "cols": [
		        {"label":"Materia","type":"string"},
		        {"label":"No. Asesorias","type":"number"}
		      ],
		  "rows": [
		        {"c":[{"v":"POO"},{"v":3}]},
		        {"c":[{"v":"Calculo"},{"v":1}]},
		        {"c":[{"v":"Discretas"},{"v":3}]},
		        {"c":[{"v":"Estructuras"},{"v":5}]},
		        {"c":[{"v":"Introducción"},{"v":8}]},
		        {"c":[{"v":"Tengo hambre"},{"v":1}]}
		      ]
		}';
		echo $string;
}else if($_GET["peticion"] == "calificacionAsesorias"){
	$string = '{
				  "1": {
				    "calificacion": "4",
				    "comentario": "Muy buena metodologia"
				  },
				  "2": {
				    "calificacion": "3",
				    "comentario": "Muy buena metodologia"
				  },
				  "3": {
				    "calificacion": "2",
				    "comentario": "Muy buena metodologia"
				  }
				}';
				echo $string;
}


?>