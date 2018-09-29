<?php

/*
	 Questo script eseguibile solamente da amministratore, permette di programmare i referti nel database, passando come paremetri di tipo POST:
	 - Codice Fiscale dell'utente a cui aggiungere il referto;
	 - Data della visita riferita al referto;
	 - Tipo di referto;
	 - Note riguardo il referto o la visita;
	 
	*/

    $array_info = [
        "codicesocieta",
    ];


	//INIZIO FUNZIONI DI CONTROLLO


	function _success(){

      
	   $json_return = array(
			"code"=>200,
			"message"=>"Operazione avvenuta con successo",

		);

        echo json_encode($json_return);
        die();
    }

    function checkValidate($array_info, $conn){
        $valido=true;
		
		if(checkToken()===false){
			$valido = false;
			error(403, "Token Non Valido");
			return $valido;
		}
		
		//Controllo che tutti i parametri passati via post siano validi
        for($i=0; $i<=count($array_info)-1; $i++){
            if(!isset($_POST[$array_info[$i]])){
                $valido = false;
                error(402, null);
                return $valido;
            }
        }
		
		//Controlla che la sessione è loggata e che è di tipo AMMINISTRATORE
        if(login_check_admin($conn) == false || $_SESSION['type']==0){
            $valido = false;    
            error(400, null); 
            return $valido;       
        }

        
        return $valido;

    }

	function checkSocietaEsiste($conn, $codice){
		
        if ($stmt = $conn->prepare("SELECT id FROM societa WHERE codicestudio = ? LIMIT 1")) { 
            $stmt->bind_param('s', $codice); // esegue il bind del parametro '$email'.
            if($stmt->execute()){ // esegue la query appena creata.
				$stmt->store_result();
				$stmt->fetch();
				if($stmt->num_rows == 1){ // se il codice esiste
					return true;
				}else{
					return false;
				}
			}else{
            	error(403, mysqli_error($conn));
				return false;
			}
        } else {
            error(403, mysqli_error($conn));
            return false;
        }
    
	}


	//FINE FUNZIONI DI CONTROLLO



    if(checkValidate($array_info, $conn)) {
		$codicesocieta = $_POST['codicesocieta'];
		if(checkSocietaEsiste($conn, $codicesocieta)){
			_success();
		}		
	}
		
?>