<?php

	session_start();

	require_once "Core/Controller/controller.php";
	require_once "Core/Controller/admin.php";
	require_once "Core/Controller/student.php";
	require_once "Core/Controller/amigo.php";
	require_once "Core/Controller/estadisticas.php";

	require_once "Core/Controller/estadisticas.php";

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
					$adminC->courseRegister($_POST["tema"], $_POST["descripción"], $_POST["amigo"], $_POST["fecha"], $_POST["materia"], $_POST["hora"]);
				}else if($_POST["accion"]=="actualizarCurso"){
					$adminC->updateC($_POST["id"], $_POST["descripción"], $_POST["amigo"], $_POST["fecha"], $_POST["materia"], $_POST["tema"]);
				}else if($_POST["accion"]=="eliminarCurso"){
					$adminC->deleteCourse($_POST["id"]);
				}else if($_POST["accion"]=="actualizarAA"){
					$adminC->updateAA($_POST["codigo"], $_POST["password"], $_POST["nombre"], $_POST["semestre"], $_POST["email"], $_POST["horario"]);	
				}else if($_POST["accion"]=="agregarTema"){
					$adminC->agregarTema($_POST["tema"], $_POST["materia"]);	
				}else if($_POST["accion"]=="desactivarTema"){
					$adminC->desactivarTema($_POST["activado"]);	
				}else if($_POST["accion"]=="activarTema"){
					$adminC->activarTema($_POST["activado"]);	
				}else if($_POST["accion"]=="eliminarTema"){
					$adminC->eliminarTema($_POST["valor"]);	
				}else if($_POST["accion"]=="reiniciarSistema"){
					$adminC->reiniciar($_POST["nombreSemestre"], $_POST["noEstudiantes"]);
				}else if($_POST["accion"]=="activarAAHistorico"){
					$adminC->activarAAHistorico($_POST["codigo"]);
				}else if($_POST["accion"]=="cambiarAvatar"){
					$adminC->changeAvatar($_POST["avatar"]);
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
				}else if($_GET["accion"]=="help"){
					$adminC->help();
				}else if($_GET["accion"]=="historicos"){
					$adminC->historic();
				}else if($_GET["accion"]=="estadisticaIndividual" && isset($_GET["materia"])){
					$adminC->estadistica2();
				}else if($_GET["accion"]=="estadisticaIndividual" && isset($_GET["amigo"])){
					$adminC->estadistica3();
				}else if($_GET["accion"]=="reiniciar"){
					$adminC->vistaReiniciarSistema();
				}else if($_GET["accion"]=="historicosAA"){
					$adminC->vistaHistoricosAA();
				}else if($_GET["accion"]=="verAAHistorico"){
					$adminC->vistaAmigoHistorico($_GET["id"]);
				}

				/*PROCESAMIENTO DE LAS PETICIONES AJAX DE LAS ESTADISTICAS*/
			}else if(isset($_GET["peticion"])){

				$stats=new Estadisticas();

				if($_GET["peticion"] == "promedioAACalificacionCurso"){
					if($_GET["promedioCursoAA"] == "Todos"){
						$numero = $stats->getPromedioCursos();
					}else{
						$numero = $stats->getPromedioCursoAmigo($_GET["idPromAmigo"]);
					}
					echo $numero;

				}else if($_GET["peticion"] == "asistenciaCursosAA"){
					if($_GET["asistenciaCursoAA"] == "Todos"){
						$string = $stats->getAsistenciaCursos();
					}else{
						$string = $stats->getAsistenciaCursoAmigo($_GET["asistenciaCursoAA"]);
					}
					echo $string;

				}else if($_GET["peticion"] == "asistenciaMateria"){
					$string = $stats->getAsistenciasMateria();
					echo $string;

				}else if($_GET["peticion"] == "calificacionMateriaPromedio"){
					$string =$stats->getPromedioMateria();
					echo $string;

				}else if($_GET["peticion"] == "ListaMaterias"){
					$string=$stats->getListaMaterias();
					echo $string;

				}else if($_GET["peticion"] == "ListaTemas"){
					$string=$stats->getListaTemas($_GET["idMateria"]);
					echo $string;

				}else if($_GET["peticion"] == "TablaFrecuencia"){
					if($_GET["materia"] == "todo"){
						$string=$stats->getFrecuenciaEstudiantes();
					}else if($_GET["materia"] != "todo" && $_GET["tema"] == "todo"){
						$string=$stats->getFrecuenciaEstudiantesMateria($_GET["materia"]);
					}else{
						$string=$stats->getFrecuenciaEstudiantesTema($_GET["tema"]);
					}
					echo $string;

				}else if($_GET["peticion"] == "selectAsistenciaCurso"){
					$string=$stats->getAmigos();
					echo $string;

				}else if($_GET["peticion"] == "asesoriaAmigo"){
					$string=$stats->getAsesoriasAmigo();
					echo $string;

				}else if($_GET["peticion"] == "totalEstudiantes"){
					$string=$stats->getPorcentajeEstudiantes();
					echo $string;

				}else if($_GET["peticion"] == "HistoricaMaterias"){
					$string=$stats->getHistoricaMateria();
					echo $string;

				}else if($_GET["peticion"] == "periodoPrevioI"){
					$string=$stats->getCursosPrevio2();
					echo $string;

				}else if($_GET["peticion"] == "periodoPrevioII"){
					$string=$stats->getCursosPrevio();
					echo $string;

				}else if($_GET["peticion"] == "comparativa"){
					$string=$stats->getComparativa();
					echo $string;

				}else if($_GET["peticion"]=="EstadisticaMateriaTema"){
					$string=$stats->getEstadisticaMateriaTema($_GET["materia"]);
					echo $string;

				}else if($_GET["peticion"]=="EstadisticaPorAmigo"){
					$string=$stats->getEstadisticaAmigo($_GET["amigo"]);
					echo $string;

				}else if($_GET["peticion"] == "calificacionAsesorias"){
					$string=$stats->getComentariosAsesorias($_GET["amigo"]);
					echo $string;

				}
			}else{
				$adminC->index();
			}
		}else if($_SESSION["tipo"]=="Estudiante"){
			$studentC=new Student();
			if(isset($_POST["accion"])){
				if($_POST["accion"]=="calificarAsesoria"){
					$studentC->rateAdvice($_POST["asesoria"], $_POST["calificacion"], $_POST["comentarios"]);
				}elseif($_POST["accion"]=="calificarCurso"){
					$studentC->rateCourse($_POST["asesoria"], $_POST["calificacion"]);
				}else if($_POST["accion"]=="cambiarAvatar"){
					$studentC->changeAvatar($_POST["avatar"]);
				}

			}else if(isset($_GET["accion"])){
				if($_GET["accion"]=="logout"){
					$studentC->logout();
				}else if($_GET["accion"]=="temas"){
					$studentC->topics();
				}else if($_GET["accion"]=="cursos"){
					$studentC->courses();
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
				}else if($_POST["accion"]=="registrarAsistenciaCurso"){
					$amigoC->registrarAsistenciaCurso($_POST["idCurso"], $_POST["codigo"]);
				}else if($_POST["accion"]=="cambiarAvatar"){
					$amigoC->changeAvatar($_POST["avatar"]);
				}

			}else if(isset($_GET["accion"])){
				if($_GET["accion"]=="logout"){
					$amigoC->logout();
				}else if($_GET["accion"]=="help"){
					$amigoC->help();
				}else if($_GET["accion"]=="asesoria"){
					$amigoC->adviceRegister();
				}else if($_GET["accion"]=="cursos"){
					$amigoC->courseAssistantR();
				}else if($_GET["accion"]=="asistenciaCursos"){
					$amigoC->registrarAsisC($_GET["id"]);
				}else if($_GET["accion"]=="estadisticas"){
					$amigoC->estadistica();
				}
			}else if(isset($_GET["peticion"])){

				$stats=new Estadisticas();

				if($_GET["peticion"]=="EstadisticaPorAmigo"){
					$string=$stats->getEstadisticaAmigo($_SESSION["codigo"]);
					echo $string;

				}else if($_GET["peticion"] == "calificacionAsesorias"){
					$string=$stats->getComentariosAsesorias($_SESSION["codigo"]);
					echo $string;

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
		}else{
			$control->studentRegister($_POST["codigo"], $_POST["nombre"], $_POST["correo"], $_POST["semestre"], $_POST["password"]);
		}
	}else{
		$control->index();
	}

?>