<?php

	session_start();

	require "Core/Controller/controller.php";

	$control=new controller();

	$control->index();

?>