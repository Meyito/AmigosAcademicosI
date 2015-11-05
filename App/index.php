<?php

	session_start();

	require "Core/Controller/controller.php";
	require "Core/Controller/admin.php";
	require "Core/Controller/student.php";
	require "Core/Controller/amigo.php";

	$control=new controller();

	if(isset($_SESSION["tipo"])){
		if($_SESSION["tipo"]=="Administrador"){
			$adminC=new Admin();
			if(isset($_POST["accion"])){
				if($_POST["accion"]=="registrarAA"){
					if($_POST["password"]!=$_POST["password2"]){
						echo "cotraseñas diferentes";
					}else{
						$adminC->registerAA($_POST["codigo"], $_POST["password"], $_POST["nombre"], $_POST["semestre"], $_POST["email"], $_POST["horario"]);	
					}
				}else if($_POST["accion"]=="registrarCurso"){
					$adminC->courseRegister($_POST["tema"], $_POST["descripción"], $_POST["amigo"], $_POST["fecha"], $_POST["materia"]);
				}else if($_POST["accion"]=="actualizarCurso"){
					$adminC->updateC($_POST["id"], $_POST["descripción"], $_POST["amigo"], $_POST["fecha"], $_POST["materia"], $_POST["tema"]);
				}else if($_POST["accion"]=="eliminarCurso"){
					$adminC->deleteCourse($_POST["id"]);
				}else if($_POST["accion"]=="actualizarAA"){
					if($_POST["password"]!=$_POST["password2"]){
						echo "cotraseñas diferentes";
					}else{
						$adminC->updateAA($_POST["codigo"], $_POST["password"], $_POST["nombre"], $_POST["semestre"], $_POST["email"], $_POST["horario"]);	
					}
				}

			}else if(isset($_GET["accion"])){
				if($_GET["accion"]=="amigos"){
					$adminC->showAA();
				}else if($_GET["accion"]=="temas"){
					$adminC->topics();
				}else if($_GET["accion"]=="cursos"){
					$adminC->courses();
				}else if($_GET["accion"]=="estadisticas"){
					$adminC->statistics();
				}else if($_GET["accion"]=="logout"){
					$adminC->logout();
				}else if($_GET["accion"]=="editarAA"){
					$adminC->aaUpdate($_GET["id"]);
				}else if($_GET["accion"]=="registrarAA"){
					$adminC->aaViewRegister();
				}else if($_GET["accion"]=="addCourse"){
					$adminC->createCourse();
				}else if($_GET["accion"]=="editarCurso"){
					$adminC->updateCourse($_GET["id"]);
				}else if($_GET["accion"]=="addCourse"){
					$adminC->createCourse();
				}else if($_GET["accion"]=="cambiarAvatar"){
					$adminC->changeAvatar();
				}else if($_GET["accion"]=="help"){
					$adminC->help();
				}
			}else{
				$adminC->index();
			}
		}else if($_SESSION["tipo"]=="Estudiante"){
			$studentC=new Student();
			if(isset($_GET["accion"])){
				if($_GET["accion"]=="logout"){
					$studentC->logout();
				}else if($_GET["accion"]=="temas"){
					$studentC->topics();
				}else if($_GET["accion"]=="cursos"){
					$studentC->courses();
				}else if($_GET["accion"]=="cambiarAvatar"){
					$studentC->changeAvatar();
				}else if($_GET["accion"]=="help"){
					$studentC->help();
				}
			}else{
				$studentC->index();	
			}
		}else if($_SESSION["tipo"]=="Amigo Académico"){
			$amigoC=new Amigo();
			if(isset($_POST["accion"])){
				if($_POST["accion"]=="registrarAsesoria"){
					$amigoC->registrarAsesoria($_POST["materia"], $_POST["tema"], $_POST["codigo"], $_POST["tipoComentario"], $_POST["comentario"]);
					//print_r($_POST);
					/*Array ( [accion] => registrarAsesoria [materia] => 1151 [tema] => 1 [codigo] => Array ( [0] => 23 [1] => 23123 [2] => 1123123 [3] => 123123 ) [tipoComentario] => 1 [comentario] => Array ( [0] => holiwis [1] => vamos [2] => a ver [3] => como funciona ) )*/
				}else if($_POST["accion"]=="registrarAsistenciaCurso"){
					$amigoC->registrarAsistenciaCurso($_POST["idCurso"], $_POST["codigo"]);
				}
			}else if(isset($_GET["accion"])){
				if($_GET["accion"]=="logout"){
					$amigoC->logout();
				}else if($_GET["accion"]=="cambiarAvatar"){
					$amigoC->changeAvatar();
				}else if($_GET["accion"]=="help"){
					$amigoC->help();
				}else if($_GET["accion"]=="asesoria"){
					$amigoC->adviceRegister();
				}else if($_GET["accion"]=="cursos"){
					$amigoC->courseAssistantR();
				}else if($_GET["accion"]=="asistenciaCursos"){
					$amigoC->registrarAsisC($_GET["id"]);
				}
			}else{
				$amigoC->index();	
			}			
		}
	}else if(isset($_POST["signIn"])){
		$control->login($_POST["codigo"], $_POST["password"]);
	}else if(isset($_POST["signUp"])){
		if($_POST["password"]!=$_POST["password2"]){
			$control->index();
			//mensaje error;
		}else{
			$control->studentRegister($_POST["codigo"], $_POST["nombre"], $_POST["correo"], $_POST["semestre"], $_POST["password"]);
		}
	}else{
		$control->index();
	}

?>