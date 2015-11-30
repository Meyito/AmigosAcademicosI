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
	$string = '{
		  "cols": [
		        {"label":"Curso","type":"string"},
		        {"label":"No. Estudiantes","type":"number"}
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
}else if($_GET["peticion"] == "calificacionMateriaPromedio"){
	$string = '{"promedio" : 3.12}';
	echo $string;
}


?>