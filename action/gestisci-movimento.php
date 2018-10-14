<?php

    $array_info = [
        "num_fat",
        "intestatario",
		"descrizione",
		"data_mov",
		"tipo_pagamento",
		"verso",
		"importo"
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
		
		$data_mov = strtotime($data_mov);
		$data_reg = time();
		$avere = $dare = "";
		
		if($verso=="ENTRATA") $avere = $importo;
		if($verso=="USCITA") $dare = $importo;
		
		$cassa = $avere-$dare;
				
		$pn = new Movimento($conn);
		
		if(isset($_POST['id'])){
			$id = $_POST['id'];
			$pn->selectMovimentoById($id);
			$pn->modificaMovimento($id, $data_reg, $data_mov, $intestatario, $descrizione, $tipo_pagamento, $dare, $avere, $cassa);
			
			echo "<script>alert('Salvataggio Movimento Completato');</script>";
		}else{
			$pn->aggiungiMovimento($num_fat, $data_reg, $data_mov, $intestatario, $descrizione, $tipo_pagamento, $dare, $avere, $cassa);
			echo "<script>alert('Salvataggio Nuovo Movimento Completato');</script>";
		}
		
    }



?>