<?php

	session_start();

	require "Core/Controller/controller.php";
	require "Core/Controller/admin.php";

	$control=new controller();

	if(isset($_SESSION["tipo"])){
		if($_SESSION["tipo"]=="Administrador"){
			$adminC=new Admin();
			$adminC->index();
		}
	}else if(isset($_POST["signIn"])){
		$control->login($_POST["codigo"], $_POST["password"]);
	}else{
		$control->index();
	}

?>