<?php
$connect = mysqli_connect("localhost","root","") or die(mysqli_error($connect));
$create = "CREATE DATABASE AA";
mysqli_query($connect,$create);
mysqli_close($connect);

$connect = mysqli_connect("localhost","root","","AA") or die(mysqli_error($connect));


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

$query = "CREATE TABLE Tema(
			id int AUTO_INCREMENT NOT NULL,
			nombre varchar(40) NOT NULL,
			idMateria varchar(7) NOT NULL,
			estado int NOT NULL,
			PRIMARY KEY(id),
			FOREIGN KEY(idMateria) REFERENCES Materia(id)
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
			idTema varchar(40) NOT NULL,
			descripcion varchar(144),
			idAmigoAcademico varchar(7) NOT NULL,
			fecha Date NOT NULL,
			estado varchar(15) NOT NULL,
			idMateria varchar(7) NOT NULL,
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
			PRIMARY KEY(id),
			FOREIGN KEY(idMateria) REFERENCES Materia(id),
			FOREIGN KEY(idAmigoAcademico) REFERENCES Usuario(id)
			)";
mysqli_query($connect,$query);

$query = "CREATE TABLE EstudianteAsesoria(
			idEstudiante varchar(7) NOT NULL,
			idAsesoria int NOT NULL,
			observacion varchar(144) NOT NULL,
			calificacion int,
			idTema int NOT NULL,
			PRIMARY KEY(idEstudiante,idAsesoria),
			FOREIGN KEY(idEstudiante) REFERENCES Usuario(id),
			FOREIGN KEY(idAsesoria) REFERENCES Asesoria(id),
			FOREIGN KEY(idTema) REFERENCES Tema(id)
			)";
mysqli_query($connect,$query);

mysqli_close($connect);

?>