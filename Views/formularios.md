El formulario de registrar_asistencia_asesoria.html retorna por metodo post:  

$_POST["materia"]  		-> Nombre de la materia  
$_POST["tema"] 			-> Nombre del tema  
$_POST["codigo"] 		-> ARRAY con uno o varios códigos de estudiantes registrados  
$_POST["comentario"] 	-> ARRAY con los comentarios. Cada posición en este array pertenece al estudiante en la misma posición de $_POST["codigo"]  

El formulario de registrar_amigo_academico.html retorna por metodo post:  

$_POST["codigo"] 		-> Código del estudiante  
$_POST["email"] 		-> Email del estudiante  
$_POST["password"] 		-> Contraseña del estudiante  
$_POST["password2"] 	-> Contraseña del estudiante para verificar que este bien digitada  
$_POST["horario"] 		-> ARRAY con valores numericos de dos digitos, el primero indicando dia de la semana, y el segundo indicando hora.  


El formulario de registrar_asistencia_curso.html retorna por metodo post:  

$_POST["codigo"] 		-> ARRAY con el o los códigos de los asistentes.  

El formulario de registrar_curso.html retorna por metodo post:  

$_POST["materia"] 		-> Materia del curso
$_POST["fecha"] 		-> Fecha del curso
$_POST["hora"] 			-> Hora del curso
$_POST["amigo"] 		-> Amigo académico a cargo
$_POST["tema"] 			-> Tema del curso
$_POST["descripcion"] 	-> Descripción del curso