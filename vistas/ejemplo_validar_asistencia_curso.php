<?php
if (isset($_POST['codigo'])) {
    $cod = $_POST['codigo'];
    for ($i=0; $i<count($cod); $i++) {
        echo $cod[$i]."<br />";
    }
}
?>