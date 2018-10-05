<?php

class SearchFatture{
	
	private $conn;
	
	public $fatture = array();
	
	public function __construct($conn){
		$this->conn = $conn;
	}
	
	public function filtraFatture($id_medico, $id_prestazione, $datainizio, $datafine){
		$datainizio = strtotime($datainizio);
		$datafine = strtotime($datafine);
			
		$id_medico = str_replace(","," OR ",$id_medico);
		
		$q = " 
			SELECT FATTURE.ID
			FROM FATTURE, PREST_EFF, PRESTAZIONI 
			WHERE
			FATTURE.ID_PREST_EFF = PREST_EFF.ID 
			AND PREST_EFF.ID_PREST = PRESTAZIONI.ID
			AND PRESTAZIONI.ID IN ($id_prestazione)
			AND ( $id_medico IN(PREST_EFF.ID_MEDICO_1,PREST_EFF.ID_MEDICO_2,PREST_EFF.ID_MEDICO_3,PREST_EFF.ID_MEDICO_4,PREST_EFF.ID_MEDICO_5))
			AND FATTURE.DATA > $datainizio
			AND FATTURE.DATA < $datafine
			";
		//echo $q;
		
		if ($stmt = $this->conn->prepare("
			SELECT FATTURE.ID
			FROM FATTURE, PREST_EFF, PRESTAZIONI 
			WHERE
			FATTURE.ID_PREST_EFF = PREST_EFF.ID 
			AND PREST_EFF.ID_PREST = PRESTAZIONI.ID
			AND PRESTAZIONI.ID IN (".$id_prestazione.")
			AND ( ".$id_medico." IN(PREST_EFF.ID_MEDICO_1,PREST_EFF.ID_MEDICO_2,PREST_EFF.ID_MEDICO_3,PREST_EFF.ID_MEDICO_4,PREST_EFF.ID_MEDICO_5))
			AND FATTURE.DATA > ?
			AND FATTURE.DATA < ?
			")) { 
			if($stmt->bind_param("ss", $datainizio, $datafine)){
				if($stmt->execute()){
					if(!$stmt->store_result()) echo mysqli_error($conn);
					if ($stmt->num_rows >= 1) { //Uses the stored result and counts the rows.
						if(!$stmt->bind_result($id_fattura)) echo mysqli_error($conn);

						while($stmt->fetch()){
							$f = new Fattura($this->conn);
							$f->selectFatturaById($id_fattura);
							$this->fatture[] = $f;
						}
						return $this->fatture;
					}
				}else{
					echo mysqli_error($this->conn);
				}
			}
		}else{
			//echo mysqli_error($this->conn); 	QUANDO VENGONO PASSATI ELEMENTI NULLI
		}
	}
	

	public function buildTable(){
		$array_keys = [
			"Num", 
			"Prestazione", 
			"Data", 
			"Importo", 
			"IVA", 
			"Ritenuta", 
			"Dest 1", 
			"% 1", 
			"Dest 2", 
			"% 2", 
			"Dest 3", 
			"% 3", 
			"Dest 4", 
			"% 4", 
			"Dest 5", 
			"% 5"
		];

		
		if($this->fatture==null){
			echo "Non ci sono fatture per questa ricerca";
		}else{
						
			$tabella = new Table($array_keys);
			$tabella->designKeys();
			foreach($this->fatture as $fattura){

				$prest_eff = new PrestEff($this->conn);
				$prest_eff->selectPrestEffById($fattura->id_prest_eff);

				$prestazione = new Prestazione($this->conn);
				$prestazione->selectPrestazioneById($prest_eff->id_prestazione);

				$medico1 = new Medico($this->conn);
				$medico1->selectMedicoById($prest_eff->id_medico_1);
				$medico2 = new Medico($this->conn);
				$medico2->selectMedicoById($prest_eff->id_medico_2);
				$medico3 = new Medico($this->conn);
				$medico3->selectMedicoById($prest_eff->id_medico_3);
				$medico4 = new Medico($this->conn);
				$medico4->selectMedicoById($prest_eff->id_medico_4);
				$medico5 = new Medico($this->conn);
				$medico5->selectMedicoById($prest_eff->id_medico_5);

				$array_body = [
					$fattura->numfattura,
					$prestazione->nome,
					date('d/m/Y', $fattura->data),
					$fattura->importo,
					$fattura->flag_iva,
					$fattura->flag_rit,
					$medico1->nome." ".$medico1->cognome,
					$prestazione->perc_medico_1,
					$medico2->nome." ".$medico2->cognome,
					$prestazione->perc_medico_2,
					$medico3->nome." ".$medico3->cognome,
					$prestazione->perc_medico_3,
					$medico4->nome." ".$medico4->cognome,
					$prestazione->perc_medico_4,
					$medico5->nome." ".$medico5->cognome,
					$prestazione->perc_medico_5				
				];

				$tabella->designBody($array_body);

			}
			$tabella->designFooter();
		}
		
	}

}