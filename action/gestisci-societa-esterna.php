<?php

    $array_info = [
        "nome",
		"indirizzo",
		"prov",
		"citta",
		"cap",
		"cod_fiscale",
		"p_iva"
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
		
		$se = new SocietaEsterna($conn);
		
		if(isset($_POST['id'])){
			$id = $_POST['id'];
			$se->selectSocietaEsternaById($id);
			if($se->modificaSocietaEsterna($nome, $indirizzo, $prov, $citta, $cap, $cod_fiscale, $p_iva))
				echo "<script>alert('Salvataggio Anagrafica Societa Completato');</script>";
			else
				echo "<script>alert('Salvataggio Anagrafica Societa NON Completato');</script>";

		}else{
			if($se->aggiungiSocietaEsterna($nome, $indirizzo, $prov, $citta, $cap, $cod_fiscale, $p_iva))
				echo "<script>alert('Salvataggio Nuova Societa Completato');</script>";
			else
				echo "<script>alert('Salvataggio Nuova Societa NON Completato');</script>";

		}
			
		
    }



?>