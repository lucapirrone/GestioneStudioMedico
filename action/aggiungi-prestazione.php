<?php

    $array_info = [
        "id_paziente",
        "id_prestazione",
        "id_medico_1",
        "id_medico_2",
        "id_medico_3",
        "id_medico_4",
        "id_medico_5",
        "importo",
        "flag_iva",
        "flag_ritenuta"
    ];

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
        if(login_check_admin($conn) == false){
            $valido = false;    
            _error(400, null); 
            return $valido;       
        }		

		if(!checkToken()){
			$valido = false; 
			return $valido;
		}
		
        return $valido;

    }

    if(checkValidate($array_info, $conn)) { 

				
		//Dichiarazione variabili prese da parametri post e trasformati in MAIUSCOLO
        foreach($array_info as $item){
			if($_POST[$item]!==""){
				${$item} = $_POST[$item];
			}else
				${$item} = null;
		}
		
		$pe = new PrestEff($conn);
		
		if($id_prest_eff = $pe->aggiungiPrestEff($id_paziente, $id_prestazione, $id_medico_1, $id_medico_2, $id_medico_3, $id_medico_4, $id_medico_5, time(), $importo))
			echo '<script>alert("Prestazione Salvata Correttamente!")</script>';
		else
			echo '<script>alert("Si è verificato un errore!")</script>';
		
		$f = new Fattura($conn);
		$f->aggiungiFattura("000000",time(),$importo,$flag_iva,$id_prest_eff,$flag_ritenuta);
		
		
    }



?>