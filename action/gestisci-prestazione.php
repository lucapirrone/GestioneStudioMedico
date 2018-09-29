<?php

    $array_info = [
        "nome",
        "importo",
        "fatturato",
        "medico_1",
        "medico_2",
        "medico_3",
        "medico_4",
        "medico_5",
        "perc_medico_1",
        "perc_medico_2",
        "perc_medico_3",
        "perc_medico_4",
        "perc_medico_5"
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
			${$item} = $_POST[$item];
		}
		
		$p = new Prestazione($conn);
		
		if(isset($_POST['id'])){
			$id = $_POST['id'];
			$p->selectPrestazioneById($id);
			$p->modificaPrestazione($id, $nome, $importo, $fatturato, $medico_1, $medico_2, $medico_3, $medico_4, $medico_5, $perc_medico_1, $perc_medico_2, $perc_medico_3, $perc_medico_4, $perc_medico_5);
		
			echo "<script>alert('Salvataggio prestazione completato');</script>";
			echo "<script>window.location.replace('?page=visualizza-prestazione&id_prestazione=".$_POST['id']."');</script>";
		}else{
			$p->aggiungiPrestazione($nome, $importo, $fatturato, $medico_1, $medico_2, $medico_3, $medico_4, $medico_5, $perc_medico_1, $perc_medico_2, $perc_medico_3, $perc_medico_4, $perc_medico_5);
					
		
			echo "<script>alert('Aggiunta prestazione completata');</script>";
		}

		
		
    }



?>