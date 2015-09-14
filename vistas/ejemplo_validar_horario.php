<?php


/*Cada $horas[i] guarda una clave del horario, se puede recorrer el array $horas para saber los dias seleccionados.
Cada posición de $horas es un entero de dos digitos. El primer representa el dia, el segundo la hora
lunes=1
martes=2
miercoles=3
jueves=4
viernes=5

Ejemplo: Número 32 indica miercoles a las 2. Numero 56, viernes a las 6.*/

if (isset($_POST['horario'])) {
    $horas = $_POST['horario'];
    for ($i=0; $i<count($horas); $i++) {
        echo $horas[$i]."<br />";
    }
}
?>