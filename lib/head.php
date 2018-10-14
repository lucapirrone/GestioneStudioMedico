<?php

	if(!(isset($paginaIntegra) && $paginaIntegra === true)) exit();

?>
<?php 

	
    require 'settings.php';

    sec_session_start(); // usiamo la nostra funzione per avviare una sessione php sicura

	if(isset($_SESSION['action_token'])) $action_token = $_SESSION['action_token'];
	if(isset($_SESSION['token'])) $token = $_SESSION['token'];

	require 'connect_guest.php';	//ospite

	if(login_check_admin($conn))	require 'connect_admin.php';	//amministratore					

   	require 'globals.php';

	//Inclusione Classi
	include 'classes/load.php';

	//Script che hanno bisogno di scrivere header
	//include 'parti/download.php'; 

 	//Controllo se la richiesta fatta è da nascondere
	include 'manage_request.php';

?>

<link rel="shortcut icon" href="../favicon.ico?v=<?php echo time() ?>" />
