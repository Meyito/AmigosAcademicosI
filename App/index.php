<?php

	session_start();

	require "Core/Controller/controller.php";
	require "Core/Controller/admin.php";

	$control=new controller();

	if(isset($_SESSION["tipo"])){
		if($_SESSION["tipo"]=="Administrador"){
			$adminC=new Admin();
			if(isset($_POST["accion"])){
				if($_POST["accion"]=="registrarAA"){
					if($_POST["password"]!=$_POST["password2"]){
						echo "cotraseñas diferentes";
					}else{
						$adminC->registerAA($_POST["codigo"], $_POST["email"], $_POST["password"], $_POST["horario"]);	
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
					echo $_GET["id"];
				}else if($_GET["accion"]=="addCourse"){
					$adminC->createCourse();
				}
			}else{
				$adminC->index();
			}
		}
	}else if(isset($_POST["signIn"])){
		$control->login($_POST["codigo"], $_POST["password"]);
	}else{
		$control->index();
	}

?>