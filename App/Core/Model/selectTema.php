<?php
	 
include "adminDB.php";

	$q=$_POST['q'];
	$adminModel=new AdminDB();
	$temas=$adminModel->getTema($q);

	$tm="";
	for($i=0; $i<count($temas); $i++){
		$tm .="<option value='".$temas[$i][0]."'>".$temas[$i][1]."</option>";
	}

	echo $tm;
?>