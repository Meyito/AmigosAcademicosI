<?php

	session_start();

	require "Core/Controller/controller.php";

	$control=new controller();

	if(isset($_POST["signIn"])){
		$control->login($_POST["codigo"], $_POST["password"]);
	}else{
		$control->index();
	}

?>