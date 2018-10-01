<?php

class medici{
	//VARIABILI
	public $tipo;
	public $nome;
	public $cognome;
	public $titolo;
	public $spec;
	public $indirizzo;
	public $citta;
	public $cap;
	public $prov;
	public $cod_fiscale;
	public $p_iva;
	public $fattura;
	public $kco;
	
	//Fatture
	private $ids = array();
	
	public function __construct($conn){
		$this->conn = $conn;
	}
	
	
	public function medicoFromID($id){
		
		if($stmt = $this->conn->prepare("SELECT TIPO, NOME, COGNOME, TITOLO, SPEC, INDIRIZZO, CITTA, CAP, PROV, COD_FISCALE, P_IVA, FATTURA, KCO FROM MEDICI WHERE ID = ?")) {
            $stmt->execute(); // Esegue la query creata.
            $stmt->store_result();
			
            if($stmt->num_rows == 1) { // se l'utente esiste
				$stmt->bind_result($this->tipo, $this->nome, $this->cognome, $this->titolo, $this->spec, $this->indirizzo, $this->citta, $this->cap, $this->prov, $this->cod_fiscale, $this->p_iva, $this->fattura, $this->kco);
				$stmt->fetch();
				
				return true;
			}else{
				echo("Errore: ".mysqli_error($this->conn));
				return false;
			}
			
		}else{
			echo("Errore: ".mysqli_error($this->conn));
			return false;
		}
	}
	
		
	public function selezionaFatture($datainizio, $datafine){
		$sp = new SearchFatture();
		$this->fatture = $sp->cercaMedicoInizioFine($this->id, $datainizio, $datafine);
	}
}
?>