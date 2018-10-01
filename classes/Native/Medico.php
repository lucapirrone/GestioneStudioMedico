<?php

class Medico{
	
	//VARIABILI
	public $id;
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
	
	
	public function selectMedicoById($id){
		
		if($stmt = $this->conn->prepare("SELECT ID, TIPO, NOME, COGNOME, TITOLO, SPEC, INDIRIZZO, CITTA, CAP, PROV, COD_FISCALE, P_IVA, FATTURA FROM MEDICI WHERE ID = ? AND KCO = ?")) {
            $stmt->bind_param('ii', $id, $_SESSION['company_id']); // esegue il bind del parametro '$user_id'.
			$stmt->execute(); // Esegue la query creata.
            $stmt->store_result();
			
            if($stmt->num_rows == 1) { // se l'utente esiste
				$stmt->bind_result($this->id, $this->tipo, $this->nome, $this->cognome, $this->titolo, $this->spec, $this->indirizzo, $this->citta, $this->cap, $this->prov, $this->cod_fiscale, $this->p_iva, $this->fattura);
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
	
	public function modificaMedico($tipo, $nome, $cognome, $titolo, $spec, $indirizzo, $citta, $cap, $prov, $cod_fiscale, $p_iva, $fattura){
	if($stmt = $this->conn->prepare("UPDATE MEDICI SET TIPO=?, NOME=?, COGNOME=?, TITOLO=?, SPEC =?, INDIRIZZO=?, CITTA=?, CAP=?, PROV=?, COD_FISCALE=?, P_IVA=?, FATTURA=? WHERE ID = ? AND KCO = ?")){
		$stmt->bind_param("sssssssssssiii", $tipo, $nome, $cognome, $titolo, $spec, $indirizzo, $citta, $cap, $prov, $cod_fiscale, $p_iva, $fattura, $this->id, $_SESSION['company_id']);
		if(!$stmt->execute()){
			echo("Errore: ".mysqli_error($this->conn));
			return false;
			}
	}
}
	public function rimuoviMedico($id){
		if($stmt = $this->conn->prepare("UPDATE MEDICO SET ELIMINATO = NOW() WHERE ID = ? AND KCO = ?")){
			$stmt->bind_param("ii", $this->id, $_SESSION['company_id']);
			if(!$stmt->execute()){
				echo("Errore: ".mysqli_error($this->conn));
				return false;
				}
		}
	}
	public function aggiungiMedico($tipo, $nome, $cognome, $titolo, $spec, $indirizzo, $citta, $cap, $prov, $cod_fiscale, $p_iva, $fattura){
		if($stmt = $this->conn->prepare("INSERT INTO MEDICI SET TIPO=?, NOME=?, COGNOME=?, TITOLO=?, SPEC =?, INDIRIZZO=?, CITTA=?, CAP=?, PROV=?, COD_FISCALE=?, P_IVA=?, FATTURA=?, KCO=?"))
			$stmt->bind_param("sssssssssssii",$tipo, $nome, $cognome, $titolo, $spec, $indirizzo, $citta, $cap, $prov, $cod_fiscale, $p_iva, $fattura, $_SESSION['company_id']);
			if(!$stmt->execute()){
				echo("Errore: ".mysqli_error($this->conn));
				return false;
				}
	}

}
?>