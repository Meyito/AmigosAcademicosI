<?php

	session_start();

	require "Core/Controller/controller.php";
	require "Core/Controller/admin.php";

	$control=new controller();

	if(isset($_SESSION["tipo"])){
		if($_SESSION["tipo"]=="Administrador"){
			$adminC=new Admin();
			if(isset($_GET["accion"])){
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
					echo $_GET["id"];
				}




				else if($_GET["accion"]=="registrarAA"){
					$adminC->aaRegister();
				}else if($_GET["accion"]=="registrarCurso"){
					$adminC->createCourse();
				}else if($_GET["accion"]=="administrarTema"){
					$adminC->topics();
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