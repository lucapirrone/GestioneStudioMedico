<?php

	//Questo script permette di nascondere la destinazione delle richieste fatte da javascript

	if(!(isset($paginaIntegra) && $paginaIntegra === true)) exit();


	if(
		isset($_POST['action']) &&
		isset($_POST['action_code']) &&
		$_POST['action'] === "request"
	){

		if(isset($_POST['action_token']) && isset($_SESSION['action_token']) && $_POST['action_token'] === $_SESSION['action_token']){
									
			$actions = array(
				array(
					"code"=>"1",
					"url"=>"action/get-info-prestazione.php",
					"admin"=>true
				),
				array(
					"code"=>"2",
					"url"=>"action/autocomplete_codicefiscale_suggestions.php",
					"admin"=>true
				),
				array(
					"code"=>"3",
					"url"=>"action/modifica-paziente.php",
					"admin"=>true
				),
				array(
					"code"=>"4",
					"url"=>"action/autocomplete_medico_suggestions.php",
					"admin"=>true
				),
				array(
					"code"=>"5",
					"url"=>"action/modifica-medico.php",
					"admin"=>true
				),
				array(
					"code"=>"6",
					"url"=>"action/aggiungi-prestazione.php",
					"admin"=>true
				),
				array(
					"code"=>"7",
					"url"=>"action/autocomplete_societa_esterna_suggestions.php",
					"admin"=>true
				)
			);

			foreach($actions as $item){
				if($item['code']== $_POST['action_code']){
					if (file_exists($item['url'])) 
					{
						include($item['url']);
					} 
				}
			}
			
			
		}else{
			echo "TOKEN DI RICHIESTA NON VALIDO: ".$_SESSION['action_token'];
			exit();
		}
		
	} 



	//MANAGE GET REQUESTS
	if(
		isset($_GET['action']) &&
		isset($_GET['action_code']) &&
		$_GET['action'] === "request"
	){
		
		
		if(isset($_GET['action_token']) && isset($_SESSION['action_token']) && $_GET['action_token'] === $_SESSION['action_token'] || 1){
					
			$actions = array(
				array(
					"code"=>"1",
					"url"=>"action/get_file_secure.php",
					"admin"=>false
				),
				array(
					"code"=>"2",
					"url"=>"action/primanota-stampa.php",
					"admin"=>true
				),
				array(
					"code"=>"3",
					"url"=>"action/view_document.php",
					"admin"=>true
				)
			);

			foreach($actions as $item){
				if($item['code']== $_GET['action_code']){
					if($item['admin']) 
					if (file_exists($item['url'])) 
					{
						include($item['url']);
						exit();
					} 
				}
			}
			
			exit();
		
		}else{
			echo "TOKEN DI RICHIESTA NON VALIDO";
			exit();
		}

		exit();
	} 




?>

	