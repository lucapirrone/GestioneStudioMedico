<?php

	/*
	Questo script eseguibile solamente da amministratore, permette di gestire le informazioni di un paziente, effettuando due tipi di operazioni:
	- Aggiunta di un paziente passando come parametro post "action"=>"aggiungi";
	- Modifica di un paziente passando come parametro post "action"=>"modifica";
	
	
	passando come paremetri di tipo POST:
	 - generalità paziente
	 - oldcodicefiscale solamente se l'azione è MODIFICA in quanto, in caso di modifica del codice fiscale, deve essere salvato il codice fiscale usato precedentemente.
	 
	 
	*/

	

    $array_info = [
        "id"
    ];

	function _success($data){

        $json_return = array(
            "code"=>200,
			"info"=>$data
        );

        echo json_encode($json_return);
        die();
    }

	function _error($code, $addmsg){
		global $errors;

		$message="Si e' verificato un errore sconosciuto";

		foreach($errors as $error){
			if($error['code']==$code)
				$message = $error['message'];
		}

		if($addmsg!=null)	$message = $message.": ".$addmsg;

		echo '<script>alert("'.$message.'");</script>';
	}

  	function checkValidate($array_info, $conn){

        $valido=true;
        for($i=0; $i<=count($array_info)-1; $i++){
            if(!isset($_POST[$array_info[$i]])){
                $valido = false;
                return $valido;
            }
        }
		
		//Questo script può essere eseguito soltanto da un amministratore
        if(login_check_admin($conn) == false ){
            $valido = false;    
            _error(400, null); 
            return $valido;       
        }		

        return $valido;

    }

    if(checkValidate($array_info, $conn)) { 

				
		//Dichiarazione variabili prese da parametri post e trasformati in MAIUSCOLO
        $id = strtoupper($_POST['id']);
		
		$p = new Prestazione($conn);
		$p->selectPrestazioneById($id);
		
		$info = array(
			"nome"=>$p->nome,
			"importo"=>$p->importo,
			"fatturato"=>$p->fatturato,
			"medico_1"=>$p->medico_1,
			"medico_2"=>$p->medico_2,
			"medico_3"=>$p->medico_3,
			"medico_4"=>$p->medico_4,
			"medico_5"=>$p->medico_5,
			"perc_1"=>$p->perc_medico_1,
			"perc_2"=>$p->perc_medico_2,
			"perc_3"=>$p->perc_medico_3,
			"perc_4"=>$p->perc_medico_4,
			"perc_5"=>$p->perc_medico_5,
		);
		
		_success($info);
		
		
    }



?>