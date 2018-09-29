<?php

class Fattura{
	
	//SET
	private $conn;
	
	//VARIABILI
	public $id;
	public $numfattura;
	public $data;
	public $importo;
	public $nome_prest;
	public $flag_iva;
	public $flag_rit;
	public $nome_med1;
	public $nome_med2;
	public $nome_med3;
	public $nome_med4;
	public $nome_med5;
	public $perc_med1;
	public $perc_med2;
	public $perc_med3;
	public $perc_med4;
	public $perc_med5;
	public $id_med1;
	public $id_med2;
	public $id_med3;
	public $id_med4;
	public $id_med5;
	public $id_prest_eff;
	public $kco;
	
	
	//Fatture
	private $ids = array();
	
	public function __construct($conn){
		$this->conn = $conn;

	}
	public function fattura($id){
		
		if($stmt = $this->conn->prepare("SELECT FATTURE.ID, FATTURE.NUM_FAT, FATTURE.DATA, FATTURE.IMPORTO, PRESTAZIONI.NOME, FATTURE.FLAG_IVA, FATTURE.FLAG_RITENUTA, 
		PRESTAZIONI.MEDICO_1, PRESTAZIONI.MEDICO_2, PRESTAZIONI.MEDICO_3, PRESTAZIONI.MEDICO_4, PRESTAZIONI.MEDICO_5, PRESTAZIONI.PERC_MEDICO_1, PRESTAZIONI.PERC_MEDICO_2, PRESTAZIONI.PERC_MEDICO_3, PRESTAZIONI.PERC_MEDICO_4, PRESTAZIONI.PERC_MEDICO_5, 
		PREST_EFF.ID_MEDICO_1, PREST_EFF.ID_MEDICO_2, PREST_EFF.ID_MEDICO_3, PREST_EFF.ID_MEDICO_4, PREST_EFF.ID_MEDICO_5 
		FROM FATTURE, PREST_EFF, PRESTAZIONI 
		WHERE FATTURE.ID_PREST_EFF = PREST_EFF.ID AND PREST_EFF.ID_PREST = PRESTAZIONI.ID")) {
            $stmt->execute(); // Esegue la query creata.
            $stmt->store_result();
			
            if($stmt->num_rows == 1) { // se l'utente esiste
				$stmt->bind_result($this->id, $this->numfattura, $this->data, $this->importo, $this->nome_prest, $this->flag_iva, $this->flag_rit, $this->nome_med1, $this->nome_med2, $this->nome_med3, $this->nome_med4, $this->nome_med5, $this->perc_med1, $this->perc_med2, $this->perc_med3, $this->perc_med4, $this->perc_med5, $this->id_med1, $this->id_med2, $this->id_med3, $this->id_med4, $this->id_med5);
				$stmt->fetch();
				
				return true;
			}else{
				return false;
			}
			
		}else{
			echo("Errore: ".mysqli_error($this->conn));
			return false;
		}
	}
	public function selectFatturaById($id){ //Seleziona La Fattura
		if($stmt = $this->conn->prepare("SELECT ID, NUM_FAT, DATA, IMPORTO, FLAG_IVA, ID_PREST_EFF, FLAG_RITENUTA FROM FATTURE WHERE ID = ? AND KCO=?")) {
			$stmt->bind_param("ii", $id, $_SESSION['company_id']);
            $stmt->execute(); // Esegue la query creata.
            $stmt->store_result();
			
            if($stmt->num_rows == 1) { // se l'utente esiste
				$stmt->bind_result($this->id, $this->numfattura, $this->data, $this->importo, $this->flag_iva, $this->id_prest_eff, $this->flag_rit);
				$stmt->fetch();
				
				return true;
			}else{
				return false;
			}
			
		}else{
			echo("Errore: ".mysqli_error($this->conn));
			return false;
		}
	}
	
	
	public function modificaFattura($data,$importo,$flag_iva,$flag_rit,$id){ //Modifica Fattura
		if($stmt = $this->conn->prepare("UPDATE FATTURE SET DATA = ?, IMPORTO = ?, FLAG_IVA = ?, FLAG_RITENUTA = ? WHERE ID = ? AND KCO= ?")) {
				$stmt->bind_param("siiii", $data, $importo, $flag_iva, $flag_rit, $this->id, $_SESSION['company_id']);
				if(!$stmt->execute()){
				echo("Errore: ".mysqli_error($this->conn));
				return false;
				}
		}
	}

	public function rimuoviFattura(){ //Rimuove Fattura
		if($stmt = $this->conn->prepare("UPDATE FATTURE SET ELIMINATO = NOW() WHERE ID = ? AND KCO = ?")){
			$stmt->bind_param("ii", $this->id, $_SESSION['company_id']);
			if(!$stmt->execute()){
				echo("Errore: ".mysqli_error($this->conn));
				return false;
				}
		}
	}
	public function aggiungiFattura($numfattura,$data,$importo,$flag_iva,$id_prest_eff,$flag_rit){ //Aggiunge Fattura
		if($stmt = $this->conn->prepare("INSERT INTO FATTURE SET NUM_FAT=?, DATA=?, IMPORTO=?, FLAG_IVA=?, ID_PREST_EFF=?, FLAG_RITENUTA=?, KCO=?"))
			$stmt->bind_param("ssiiiii",$numfattura,$data,$importo,$flag_iva,$id_prest_eff,$flag_rit,$_SESSION['company_id']);
			if(!$stmt->execute()){
				echo("Errore: ".mysqli_error($this->conn));
				return false;
				}
	}
	
		
		
}
		
		
	

?>