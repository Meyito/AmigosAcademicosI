<?php

$connect = mysqli_connect("sandbox2.ufps.edu.co","ufps_88","ufps_uy","ufps_88") or die(("Error " . mysqli_error($connect)));

$query = "CREATE TABLE Periodo(
			id int AUTO_INCREMENT NOT NULL,
			descripcion varchar(10) NOT NULL,
			cantidadEstudiantes int NOT NULL,
			asistenciasPeriodo int NOT NULL, 
			PRIMARY KEY(id)
			)";

mysqli_query($connect,$query);

$query  = "CREATE TABLE Usuario(
			id varchar(7) NOT NULL,
			nombre varchar(40) NOT NULL,
			contrasenia varchar(40) NOT NULL,
			correoElectronico varchar(40),
			semestre int,
			tipo int NOT NULL,
			avatar varchar(100) NOT NULL,
			estado varchar(10) NOT NULL,
			PRIMARY KEY(id)
			)";
mysqli_query($connect,$query);

$query = "CREATE TABLE Materia(
			id varchar(7) NOT NULL,
			nombre varchar(40) NOT NULL,
			semestre int NOT NULL,
			PRIMARY KEY(id)
			)";
mysqli_query($connect,$query);

$query  = "CREATE TABLE MateriaHistorico(
			idMateria varchar(7) NOT NULL,
			idPeriodo int NOT NULL,
			asistencias int NOT NULL,
			promedio float(7) NOT NULL,
			PRIMARY KEY(idMateria, idPeriodo),
			FOREIGN KEY(idMateria) REFERENCES Materia(id),
			FOREIGN KEY(idPeriodo) REFERENCES Periodo(id)
			)";
mysqli_query($connect,$query);

$query = "CREATE TABLE Tema(
			id int AUTO_INCREMENT NOT NULL,
			nombre varchar(40) NOT NULL,
			idMateria varchar(7) NOT NULL,
			estado int NOT NULL,
			PRIMARY KEY(id),
			FOREIGN KEY(idMateria) REFERENCES Materia(id)
			)";
mysqli_query($connect,$query);

$query  = "CREATE TABLE AsistenciaHistorico(
			idTema int NOT NULL,
			idPeriodo int NOT NULL,
			tipo ENUM('Asesoria', 'Curso') NOT NULL,
			asistencia int NOT NULL,
			promedio float(7) NOT NULL,
			PRIMARY KEY(idTema, idPeriodo, tipo),
			FOREIGN KEY(idTema) REFERENCES Tema(id),
			FOREIGN KEY(idPeriodo) REFERENCES Periodo(id)
			)";
mysqli_query($connect,$query);

$query = "CREATE TABLE Agenda(
			idAmigoAcademico varchar(7) NOT NULL,
			dia int NOT NULL,
			hora int NOT NULL,
			PRIMARY KEY(idAmigoAcademico,dia,hora),
			FOREIGN KEY(idAmigoAcademico) REFERENCES Usuario(id)
			)";
mysqli_query($connect,$query);

$query = "CREATE TABLE Curso(
			id int AUTO_INCREMENT NOT NULL,
			idTema int NOT NULL,
			descripcion varchar(144),
			idAmigoAcademico varchar(7) NOT NULL,
			fecha Date NOT NULL,
			hora time NOT NULL,
			estado varchar(15) NOT NULL,
			idMateria varchar(7) NOT NULL,
			promedioCalificacion float(7),
			PRIMARY KEY(id),
			FOREIGN KEY(idAmigoAcademico) REFERENCES Usuario(id),
			FOREIGN KEY(idMateria) REFERENCES Materia(id),
			FOREIGN KEY(idTema) REFERENCES Tema(id)
			)";
mysqli_query($connect,$query);

$query = "CREATE TABLE EstudianteCurso(
			idEstudiante varchar(7) NOT NULL,
			idCurso int NOT NULL,
			calificacion int,
			PRIMARY KEY(idEstudiante,idCurso),
			FOREIGN KEY(idEstudiante) REFERENCES Usuario(id),
			FOREIGN KEY(idCurso) REFERENCES Curso(id)
			)";
mysqli_query($connect,$query);

$query = "CREATE TABLE Asesoria(
			id int AUTO_INCREMENT NOT NULL,
			idAmigoAcademico varchar(7) NOT NULL,
			fecha Date NOT NULL,
			idMateria varchar(7) NOT NULL,
			idTema int NOT NULL,
			promedioCalificacion float(7),
			PRIMARY KEY(id),
			FOREIGN KEY(idMateria) REFERENCES Materia(id),
			FOREIGN KEY(idAmigoAcademico) REFERENCES Usuario(id),
			FOREIGN KEY(idTema) REFERENCES Tema(id)
			)";
mysqli_query($connect,$query);

$query = "CREATE TABLE EstudianteAsesoria(
			idEstudiante varchar(7) NOT NULL,
			idAsesoria int NOT NULL,
			observacionAmigo varchar(144) NOT NULL,
			observacionEstudiante varchar(144),
			calificacion int,
			PRIMARY KEY(idEstudiante,idAsesoria),
			FOREIGN KEY(idEstudiante) REFERENCES Usuario(id),
			FOREIGN KEY(idAsesoria) REFERENCES Asesoria(id)
			)";
mysqli_query($connect,$query);

$query = "CREATE TABLE AmigoPeriodo(
			idAmigoAcademico varchar(7) NOT NULL,
			idPeriodo int NOT NULL,
			PRIMARY KEY(idAmigoAcademico,idPeriodo),
			FOREIGN KEY(idAmigoAcademico) REFERENCES Usuario(id),
			FOREIGN KEY(idPeriodo) REFERENCES Periodo(id)
			)";
mysqli_query($connect,$query);

//Datos de Inicializacion de la Aplicacion


//Usuarios
$query = "INSERT INTO Usuario(id,nombre,contrasenia,correoElectronico,tipo,avatar,estado) VALUES('1150001','Janeth Parada',sha1('1234'),'janethpc@ufps.edu.co',1,'Static/img/avatars/m3.png','activo')";
mysqli_query($connect,$query);

//Materias

//SEMESTRE 1
$query = "INSERT INTO Materia VALUES('1155101','Calculo Diferencial',1)";
mysqli_query($connect,$query);
$query = "INSERT INTO Materia VALUES('1155102','Matematicas Discretas',1)";
mysqli_query($connect,$query);
$query = "INSERT INTO Materia VALUES('1155104','Fundamentos de Programacion',1)";
mysqli_query($connect,$query);
$query = "INSERT INTO Materia VALUES('1155105','Introduccion a Ingenieria de Sistemas',1)";
mysqli_query($connect,$query);

//SEMESTRE 2
$query = "INSERT INTO Materia VALUES('1155201','Calculo Integral',2)";
mysqli_query($connect,$query);
$query = "INSERT INTO Materia VALUES('1155202','Algebra Lineal',2)";
mysqli_query($connect,$query);
$query = "INSERT INTO Materia VALUES('1155203','Fisica Mecanica',2)";
mysqli_query($connect,$query);
$query = "INSERT INTO Materia VALUES('1155204','Programacion Orientada a Objetos',2)";
mysqli_query($connect,$query);
$query = "INSERT INTO Materia VALUES('1155209','Seminario Integrador I',2)";
mysqli_query($connect,$query);

//SEMESTRE 3
$query = "INSERT INTO Materia VALUES('1155301','Calculo Vectorial',3)";
mysqli_query($connect,$query);
$query = "INSERT INTO Materia VALUES('1155303','Fisica Electromagnetica',3)";
mysqli_query($connect,$query);
$query = "INSERT INTO Materia VALUES('1155304','Estructuras de Datos',3)";
mysqli_query($connect,$query);
$query = "INSERT INTO Materia VALUES('1155305','Programacion Orientada a Objetos II',3)";
mysqli_query($connect,$query);
$query = "INSERT INTO Materia VALUES('1155306','Seminario de Investigacion I',3)";
mysqli_query($connect,$query);

//SEMESTRE 4
$query = "INSERT INTO Materia VALUES('1155401','Ecuaciones Diferenciales',4)";
mysqli_query($connect,$query);
$query = "INSERT INTO Materia VALUES('1155402','Probabilidad y Estadistica',4)";
mysqli_query($connect,$query);
$query = "INSERT INTO Materia VALUES('1155403','Ondas y Particulas',4)";
mysqli_query($connect,$query);
$query = "INSERT INTO Materia VALUES('1155404','Analisis de Algoritmos',4)";
mysqli_query($connect,$query);
$query = "INSERT INTO Materia VALUES('1155405','Teoria de La Computacion',4)";
mysqli_query($connect,$query);


//Temas

//Fundamentos de Programacion
$query = "INSERT INTO Tema(nombre,idMateria,estado) VALUES('Concepto de Encapsulamiento','1155104',2)";
mysqli_query($connect,$query);
$query = "INSERT INTO Tema(nombre,idMateria,estado) VALUES('Constructores','1155104',1)";
mysqli_query($connect,$query);
$query = "INSERT INTO Tema(nombre,idMateria,estado) VALUES('Metodos','1155104',2)";
mysqli_query($connect,$query);

//Matematicas Discretas
$query = "INSERT INTO Tema(nombre,idMateria,estado) VALUES('Calculo Proposicional','1155102',2)";
mysqli_query($connect,$query);
$query = "INSERT INTO Tema(nombre,idMateria,estado) VALUES('Calculo de Predicados','1155102',1)";
mysqli_query($connect,$query);
$query = "INSERT INTO Tema(nombre,idMateria,estado) VALUES('Teoria de Conjuntos','1155102',2)";
mysqli_query($connect,$query);
$query = "INSERT INTO Tema(nombre,idMateria,estado) VALUES('Relaciones y Funciones','1155102',2)";
mysqli_query($connect,$query);
$query = "INSERT INTO Tema(nombre,idMateria,estado) VALUES('Algebra de Boole','1155102',2)";
mysqli_query($connect,$query);
$query = "INSERT INTO Tema(nombre,idMateria,estado) VALUES('Conteo y Analisis Combinatorio','1155102',2)";
mysqli_query($connect,$query);

//Estructuras de Datos
$query = "INSERT INTO Tema(nombre,idMateria,estado) VALUES('Vectores','1155304',2)";
mysqli_query($connect,$query);
$query = "INSERT INTO Tema(nombre,idMateria,estado) VALUES('Listas Simples','1155304',2)";
mysqli_query($connect,$query);
$query = "INSERT INTO Tema(nombre,idMateria,estado) VALUES('Listas Dobles y Dobles Circulares','1155304',2)";
mysqli_query($connect,$query);
$query = "INSERT INTO Tema(nombre,idMateria,estado) VALUES('Pilas y Colas','1155304',1)";
mysqli_query($connect,$query);
$query = "INSERT INTO Tema(nombre,idMateria,estado) VALUES('Recursion','1155304',2)";
mysqli_query($connect,$query);
$query = "INSERT INTO Tema(nombre,idMateria,estado) VALUES('Arboles Binarios','1155304',2)";
mysqli_query($connect,$query);
$query = "INSERT INTO Tema(nombre,idMateria,estado) VALUES('Metodos de Ordenamiento','1155304',2)";
mysqli_query($connect,$query);

//Programacion Orientada a Objetos II
$query = "INSERT INTO Tema(nombre,idMateria,estado) VALUES('Hilos','1155305',2)";
mysqli_query($connect,$query);
$query = "INSERT INTO Tema(nombre,idMateria,estado) VALUES('Sockets','1155305',1)";
mysqli_query($connect,$query);

//Programacion Orientada a Objetos
$query = "INSERT INTO Tema(nombre,idMateria,estado) VALUES('Modularidad','1155204',2)";
mysqli_query($connect,$query);
$query = "INSERT INTO Tema(nombre,idMateria,estado) VALUES('Abstraccion de Objetos','1155204',2)";
mysqli_query($connect,$query);
$query = "INSERT INTO Tema(nombre,idMateria,estado) VALUES('Herencia','1155204',1)";
mysqli_query($connect,$query);
$query = "INSERT INTO Tema(nombre,idMateria,estado) VALUES('Concepto de Clase','1155204',2)";
mysqli_query($connect,$query);
$query = "INSERT INTO Tema(nombre,idMateria,estado) VALUES('Diagrama de Clases UML','1155204',2)";
mysqli_query($connect,$query);

//Ondas y Particulas
$query = "INSERT INTO Tema(nombre,idMateria,estado) VALUES('Conceptos Basicos de la Relatividad','1155403',2)";
mysqli_query($connect,$query);
$query = "INSERT INTO Tema(nombre,idMateria,estado) VALUES('Movimiento Oscilatorio','1155403',2)";
mysqli_query($connect,$query);
$query = "INSERT INTO Tema(nombre,idMateria,estado) VALUES('Ondas Mecanicas','1155403',2)";
mysqli_query($connect,$query);
$query = "INSERT INTO Tema(nombre,idMateria,estado) VALUES('Ondas Electromagneticas','1155403',2)";
mysqli_query($connect,$query);

//PERIODO
$query = "INSERT INTO Periodo(descripcion,cantidadEstudiantes,asistenciasPeriodo) VALUES('IIS2014',0,0)";
mysqli_query($connect,$query);
$query = "INSERT INTO Periodo(descripcion,cantidadEstudiantes,asistenciasPeriodo) VALUES('IS2015',0,0)";
mysqli_query($connect,$query);
$query = "INSERT INTO Periodo(descripcion,cantidadEstudiantes,asistenciasPeriodo) VALUES('IIS2015',0,0)";
mysqli_query($connect,$query);


mysqli_close($connect);

?>