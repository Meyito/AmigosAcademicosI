El formulario de contenido_asistencia_asesoria.html retorna por metodo post:  

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



