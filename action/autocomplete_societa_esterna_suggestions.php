<?php

/*
	 Questo script eseguibile solamente da amministratore, permette di programmare i referti nel database, passando come paremetri di tipo POST:
	 - Codice Fiscale dell'utente a cui aggiungere il referto;
	 - Data della visita riferita al referto;
	 - Tipo di referto;
	 - Note riguardo il referto o la visita;
	 
	*/
	if(!(isset($paginaIntegra) && $paginaIntegra === true)) exit();

    $array_info = [
        "query"
    ];


	//INIZIO FUNZIONI DI CONTROLLO


	function _success($sugg){

      
	   $json_return = array(
			"code"=>200,
			"message"=>"Operazione avvenuta con successo",
		    "suggestions"=> $sugg

		);

        echo json_encode($sugg);
        die();
    }

    function checkValidate($array_info, $conn){
        $valido=true;

		//Controllo che tutti i parametri passati via post siano validi
        for($i=0; $i<=count($array_info)-1; $i++){
            if(!isset($_POST[$array_info[$i]])){
                $valido = false;
                error(402, null);
                return $valido;
            }
        }
		
		//Controlla che la sessione è loggata e che è di tipo AMMINISTRATORE
        if(login_check_admin($conn) == false){
            $valido = false;    
            error(400, null); 
            return $valido;       
        }

        
        return $valido;

    }


	//FINE FUNZIONI DI CONTROLLO



    if(checkValidate($array_info, $conn)) { 
		
		$data = "%".strtoupper($_POST['query'])."%";
	
		if ($stmt_utente = $conn->prepare("SELECT  ID, NOME, INDIRIZZO, CAP, CITTA, COD_FISCALE, P_IVA FROM SOCIETA_ESTERNA where KCO = ? and NOME LIKE ?")){
			$stmt_utente->bind_param("is", $_SESSION['company_id'], $data);
			if($stmt_utente->execute()){ // esegue la query appena creata.
				$stmt_utente->store_result();
				$stmt_utente->bind_result($id, $nome, $indirizzo, $cap, $citta, $codicefiscale, $p_iva);

				$sugg = array();
				

				while($stmt_utente->fetch()) {
					$data = array();
					
					if($nome!=null) $label = $nome;
					if($indirizzo!=null) $label = $label." - ".$indirizzo.", ";
					if($cap!=null) $label = $label.$cap.", ";
					if($citta!=null) $label = $label.$citta;
					if($codicefiscale!=null) $label = $label." - ".$codicefiscale." - ";

					$label = $label." (".$id.")";
					
            		$sugg[] = array(
						"id"=>$id,
						"nome"=>$nome,
						"codicefiscale"=>$codicefiscale,
						"label"=>$label
					);

				}
				
				_success($sugg);
			}else{
				echo mysqli_error($conn);
			}
		}else{
			echo mysqli_error($conn);
		}
		
	}





?>