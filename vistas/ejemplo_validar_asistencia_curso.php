
<?php

/*Cada $cod[i] guarda un código recibido, Al recorrer el array debe hacerse el if que contiene el strcpm para evitar añadir 
espacios vacios
.*/
if (isset($_POST['codigo'])) {
    $cod = $_POST['codigo'];
    for ($i=0; $i<count($cod); $i++) {
    	if(strcmp($cod[$i], "")!==0){
    		echo $cod[$i]."<br />";
    	}
        
    }
}
?>