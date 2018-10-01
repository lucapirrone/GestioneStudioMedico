<?php

    $array_info = [
        "nome",
		"cognome",
		"tipo",
		"titolo",
		"spec",
		"indirizzo",
		"citta",
		"cap",
		"prov",
		"cod_fiscale",
		"p_iva",
		"fattura"
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
			${$item} = $_POST[$item];
		}
		
		$m = new Medico($conn);
		
		if(isset($_POST['id'])){
			$id = $_POST['id'];
			$m->selectMedicoById($id);
			$m->modificaMedico($tipo, $nome, $cognome, $titolo, $spec, $indirizzo, $citta, $cap, $prov, $cod_fiscale, $p_iva, $fattura);
			echo "<script>alert('Salvataggio Anagrafica Medico Completato');</script>";

		}else{
			$m->aggiungiMedico($tipo, $nome, $cognome, $titolo, $spec, $indirizzo, $citta, $cap, $prov, $cod_fiscale, $p_iva, $fattura);
			
			echo "<script>alert('Salvataggio Nuovo Medico Completato');</script>";

		}
			
		
    }



?>