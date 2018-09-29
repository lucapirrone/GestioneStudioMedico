<?php
if(!(isset($paginaIntegra) && $paginaIntegra === true)) exit();

// Elimina tutti i valori della sessione.

if(isset($_GET['action']) && $_GET['action']=="logout"){
	logout($conn);
	
	header('Location: ../');
}


?>