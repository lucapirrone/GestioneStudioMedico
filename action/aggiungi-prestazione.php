<?php

    $array_info = [
        "id_paziente_dest",
        "id_medico_dest",
        "id_societa_dest",
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
		
		//Impostazione del Destinatario
		if($_POST['id_paziente_dest']){
			$paz = new Paziente($conn);
			$paz->selectPazienteById($_POST['id_paziente_dest']);
			
			$dest_fatt = new DestinatarioFattura($paz->nome, $paz->cognome, $paz->data, $paz->titolo, $paz->indirizzo, $paz->citta, $paz->cap, $paz->provincia,	$paz->stato,	$paz->tel_1,	$paz->tel_2,	$paz->cod_fiscale, $paz->p_iva, $paz->note, $paz->email);
		}
		if($_POST['id_medico_dest']){
			$medico = new Medico($conn);
			$medico->selectMedicoById($_POST['id_medico_dest']);
			
			$dest_fatt = new DestinatarioFattura($medico->nome, $medico->cognome, null, $paz->titolo, $paz->indirizzo, $paz->citta, $paz->cap, $paz->provincia,	null,	null,	null,	$medico->cod_fiscale, $medico->p_iva, null, null);
		}
		if($_POST['id_societa_dest']){
			$se = new SocietaEsterna($conn);
			$se->selectSocietaEsternaById($_POST['id_societa_dest']);
			
			$dest_fatt = new DestinatarioFattura($se->nome, null, null, null, $paz->indirizzo, $paz->citta, $paz->cap, $paz->provincia,	null,	null,	null,	null, $se->p_iva, null, null);
		}		
		
		$prest = new Prestazione($conn);
		$prest->selectPrestazioneById($id_prestazione);
		
		$pe = new PrestEff($conn);
		
		if($id_prest_eff = $pe->aggiungiPrestEff($id_paziente, $id_medico, $id_societa, $id_prestazione, $id_medico_1, $id_medico_2, $id_medico_3, $id_medico_4, $id_medico_5, time(), $importo))
			echo '<script>alert("Prestazione Salvata Correttamente!")</script>';
		else
			echo '<script>alert("Si è verificato un errore!")</script>';
		
	
		$f = new Fattura($conn);
		if($flag_iva)	$importo_tot = $importo_tot + (($importo/100)*22);
		if($flag_ritenuta){
			$importo_tot = $importo_tot - (($importo/100)*20);
			if($importo>77){
				$bollo = 2;
				$importo_tot = $importo_tot + $bollo;
			}
		}	

		
		$f->aggiungiFattura("000000",time(),$importo,$flag_iva,$id_prest_eff,$flag_ritenuta, $bollo, $importo_tot);
		
		
		$pn = new Movimento($conn);
		$pn->aggiungiMovimento(time(), time(), $dest_fatt->cognome." ".$dest_fatt->nome, $prest->nome, "CONTANTI", 0, $importo, $importo);
		
		$co = new Company($conn);

		$iva = null;
		$ritenuta = null;
		if($flag_iva)	$iva = 22;
		if($flag_ritenuta)	$ritenuta = 20;
		
		include '../../lib/fpdf/generatepdf.php';
		
		if($prest->fatturato==$co->id){
			stampaFattura(
				$co->nome,
				null, 
				null, 
				$co->sede, 
				null,
				$co->p_iva,
				$dest_fatt->cognome." ".$dest_fatt->nome, 
				$dest_fatt->data, 
				$dest_fatt->indirizzo.", ".$dest_fatt->cap.", ".$dest_fatt->citta, 
				$dest_fatt->cod_fiscale, 
				$prest->nome, 
				$pe->importo, 
				$iva, 
				$ritenuta,
				$f->bollo, 
				$f->totale
			);
			
		}else{
			
			stampaFattura(
				$medico->cognome." ".$medico->nome,
				$medico->spec, 
				$medico->indirizzo.", ".$medico->cap.", ".$medico->citta, 
				null, 
				$medico->cod_fiscale, 
				$medico->p_iva, 
				$dest_fatt->cognome." ".$dest_fatt->nome, 
				$dest_fatt->data, 
				$dest_fatt->indirizzo.", ".$dest_fatt->cap.", ".$dest_fatt->citta, 
				$dest_fatt->cod_fiscale, 
				$prest->nome, 
				$pe->importo, 
				$iva, 
				$ritenuta,
				$f->bollo, 
				$f->totale
			);
    	}
		
	}

?>