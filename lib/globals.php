<?php

	if(!(isset($paginaIntegra) && $paginaIntegra === true)) exit();

?>
<?php

	//Array associativo che associa ad un codice di errore, un messaggio di errore.
	$errors = array(
		array(//ERRORI GENERALI
			"code"=>400,
			"message"=>"Login non effettuato"
		),
		array(
			"code"=>401,
			"message"=>"Codice fiscale già esistente"
		),
		array(
			"code"=>402,
			"message"=>"Si è verificato un errore nel passaggio dei parametri"
		),
		array(
			"code"=>403,
			"message"=>"Errore nella query sql"
		),
		array(
			"code"=>407,
			"message"=>"Utente non esistente"
		),
		array(
			"code"=>409,
			"message"=>"ReCaptcha non valido"
		),//ERRORI AGGIUNGI PRATICA
		array(
			"code"=>404,
			"message"=>"File non trovato"
		),
		array(
			"code"=>405,
			"message"=>"Impossibile salvare il file"
		),
		array(
			"code"=>407,
			"message"=>"Estensione file non valida"
		),
		array(
			"code"=>406,
			"message"=>"Dimensione file troppo grande"
		),
		array(
			"code"=>408,
			"message"=>"File già presente"
		),//ERRORI GESTISCI PAZIENTE
		array(
			"code"=>500,
			"message"=>"Errore nel prelevamento dell'ultimo utente"
		),
		array(
			"code"=>501,
			"message"=>"Errore nel controllo dell'esistenza dell'utente"
		),
		array(
			"code"=>502,
			"message"=>"Errore nell'inserimento del paziente"
		),
		array(
			"code"=>503,
			"message"=>"Errore nell'aggiornamento del paziente"
		),//DOWNLOAD FILE
		array(
			"code"=>504,
			"message"=>"Questa pratica non e' esistente o non hai le autorizzazioni per accedervi"
		)
	);


	//Voci Menu

	$pagine = array();	//Elementi del menu principale orizzontale
	$usercontrol_menu = array();  //Elementi del menu utente nell'header
	$menu_laterale = array();	//Elementi del menu laterale

	if(login_check_admin($conn)){	//amministratore
	    $pagine = array(
			array(
				"nome"=>"Fatturazione",
				"image"=>"icona-fatturazione.png",
				"sub"=>array(
					array(
					"nome"=>"Crea Fattura",
					"code"=>"crea-fattura",
					"url"=>"parti/admin/fatturazione/nuova-fattura.php",
					"default"=>true,
					"visibility"=>true
					),
					array(
					"nome"=>"Visualizza Fatture",
					"code"=>"lista-fatture",
					"url"=>"parti/admin/fatturazione/lista-fatture.php",
					"default"=>false,
					"visibility"=>true
					)
				)
			),
			array(
				"nome"=>"Anagrafica",
				"image"=>"icona-anagrafica.png",
				"sub"=>array(
					array(
					"nome"=>"Visualizza Paziente",
					"code"=>"visualizza-paziente",
					"url"=>"parti/admin/anagrafica/paziente/visualizza-paziente.php",
					"default"=>true,
					"visibility"=>true
					),
					array(
					"nome"=>"Aggiungi Paziente",
					"code"=>"aggiungi-paziente",
					"url"=>"parti/admin/anagrafica/paziente/aggiungi-paziente.php",
					"default"=>true,
					"visibility"=>false
					),
					array(
					"nome"=>"Modifica Paziente",
					"code"=>"modifica-paziente",
					"url"=>"parti/admin/anagrafica/paziente/modifica-paziente.php",
					"default"=>true,
					"visibility"=>false
					),
					array(
					"nome"=>"Visualizza Medico",
					"code"=>"visualizza-medico",
					"url"=>"parti/admin/anagrafica/medico/visualizza-medico.php",
					"default"=>true,
					"visibility"=>true
					),
					array(
					"nome"=>"Aggiungi Medico",
					"code"=>"aggiungi-medico",
					"url"=>"parti/admin/anagrafica/medico/aggiungi-medico.php",
					"default"=>true,
					"visibility"=>false
					),
					array(
					"nome"=>"Modifica Medico",
					"code"=>"modifica-medico",
					"url"=>"parti/admin/anagrafica/medico/modifica-medico.php",
					"default"=>true,
					"visibility"=>false
					)
				)
			),
			array(
				"nome"=>"Prestazioni",
				"image"=>"icona-prestazioni.png",
				"sub"=>array(
					array(
					"nome"=>"Visualizza Prestazioni",
					"code"=>"visualizza-prestazione",
					"url"=>"parti/admin/prestazioni/visualizza-prestazione.php",
					"default"=>true,
					"visibility"=>true
					),
					array(
					"nome"=>"Aggiungi Prestazione",
					"code"=>"aggiungi-prestazione",
					"url"=>"parti/admin/prestazioni/aggiungi-prestazione.php",
					"default"=>false,
					"visibility"=>true
					),
					array(
					"nome"=>"Modifica Prestazione",
					"code"=>"modifica-prestazione",
					"url"=>"parti/admin/prestazioni/modifica-prestazione.php",
					"default"=>false,
					"visibility"=>true
					)
				)
			),
		);
		
		array_push($usercontrol_menu, 
			array(
				"nome"=>"Gestisci Società",
				"url"=>"parti/admin/gestisci_societa.php",
				"code"=>"gestisci-societa",
				"image"=>"advanced-settings.svg"
			)
		);  
		
		array_push($menu_laterale, 
			array(//Elementi del menu collegati alla pagine gestisci-paziente
				"title"=>"Operazioni",
				"code"=>"gestisci-paziente",
				"items"=>array(
					array(
						"nome"=>"Modifica Generalità",
						"code"=>"modifica",
						"url"=>"parti/admin/form_info_paziente.php",
						"default"=>true
					),
					array(
						"nome"=>"Lista Referti",
						"code"=>"listareferti",
						"url"=>"parti/admin/lista_referti.php",
						"default"=>false
					)
				)
			),
			array(//Elementi del menu collegati alla pagine gestisci-paziente
				"title"=>"Operazioni",
				"code"=>"gestisci-societa",
				"items"=>array(
					array(
						"nome"=>"Report",
						"code"=>"view-report",
						"url"=>"parti/admin/view-report.php",
						"default"=>true
					)
				)
			)
		);
		
	
	}




?>