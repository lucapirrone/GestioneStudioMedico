<?php

    $array_info = [
        "nome",
		"cognome",
		"sesso",
		"data",
		"titolo",
		"indirizzo",
		"citta",
		"cap",
		"provincia",
		"stato",
		"tel_1",
		"tel_2",
		"cod_fisc",
		"p_iva",
		"note",
		"privacy",
		"email"
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

        return $valido;

    }

    if(checkValidate($array_info, $conn)) { 

				
		//Dichiarazione variabili prese da parametri post e trasformati in MAIUSCOLO
        foreach($array_info as $item){
			${$item} = $item;
		}
		
		$p = new Paziente($conn);
		
		if(isset($_POST['id'])){
			$id = $_POST['id'];
			$p->selectPazienteById($id);
			$p->modificaPaziente($nome, $cognome, $sesso, $data, $titolo, $indirizzo, $citta, $cap, $provincia, $stato, $tel_1, $tel_2, $cod_fisc, $p_iva, $note, $provacy, $email);
		}else{
			$p->aggiungiPaziente($nome, $cognome, $sesso, $data, $titolo, $indirizzo, $citta, $cap, $provincia, $stato, $tel_1, $tel_2, $cod_fisc, $p_iva, $note, $provacy, $email);
		}
		
		
		success($info);
		
		
    }



?>