<?php
	 
	/**
 	* .............................................
 	* UNIVERSIDAD  FRANCISCO  DE  PAULA  SANTANDER
 	*    PROGRAMA  DE  INGENIERIA   DE   SISTEMAS
 	*         AMIGOS ACADEMICOS INTERACTIVOS
 	*             SAN JOSE DE CUCUTA-2015
	* ............................................
 	*/

 	include "adminDB.php";

 	/**
	* @author Gerson Yesid Lazaro Carrillo 1150972
	* @author Angie Melissa Delgado León 1150990
	* @author Juan Daniel Vega Santos 1150958
	*/

	$q=$_POST['q'];
	$adminModel=new AdminDB();
	$temas=$adminModel->getTema($q);

	$tm="";
	for($i=0; $i<count($temas); $i++){
		$tm .="<option value='".$temas[$i][0]."'>".$temas[$i][1]."</option>";
	}

	echo $tm;
?>