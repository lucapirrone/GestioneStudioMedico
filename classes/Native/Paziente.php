<?php

class Paziente{
	
	//SET
	private $conn;
	
	//ANAGRAFICA PAZIENTE
	public $id;
	public $nome;
	public $cognome;
	public $sesso;
	public $data;
	public $titolo;
	public $indirizzo;
	public $citta;
	public $cap;
	public $provincia;
	public $stato;
	public $tel_1;
	public $tel_2;
	public $cod_fiscale;
	public $p_iva;
	public $note;
	public $privacy;
	public $email;
	
	public function __construct($conn) {
        $this->conn = $conn;
    }
	
	public function selectPazienteById($id){
		if($stmt = $this->conn->prepare("SELECT ID, NOME, COGNOME, SESSO, DATA, TITOLO, INDIRIZZO, CITTA, CAP, PROV, STATO, TEL_1, TEL_2, COD_FISCALE, P_IVA, NOTE, PRIVACY, EMAIL FROM PAZIENTI WHERE ID = ? AND KCO = ?")) {
            $stmt->bind_param('ii', $id, $_SESSION['company_id']); // esegue il bind del parametro '$user_id'.
            $stmt->execute(); // Esegue la query creata.
            $stmt->store_result();
			
            if($stmt->num_rows == 1) { // se l'utente esiste
				$this->id = $id;

				$stmt->bind_result($this->id, $this->nome, $this->cognome, $this->sesso, $this->data, $this->titolo, $this->indirizzo, $this->citta, $this->cap, $this->provincia, $this->stato, $this->tel_1, $this->tel_2, $this->cod_fiscale, $this->p_iva, $this->note, $this->privacy, $this->email);
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
	public function modificaPaziente($id, $nome, $cognome, $sesso, $data, $titolo, $indirizzo, $citta, $cap, $prov, $stato, $tel_1, $tel_2, $cod_fiscale, $p_iva, $note, $privacy, $email){
		if($stmt = $this->conn->prepare("UPDATE PAZIENTI SET NOME=?, COGNOME=?, SESSO=?, DATA=?, TITOLO=?, INDIRIZZO=?, CITTA=?, CAP=?, PROV=?, STATO=?, TEL_1=?, TEL_2=?, COD_FISCALE=?, P_IVA=?, NOTE=?, PRIVACY=?, EMAIL=? WHERE ID = ? AND KCO = ?")){
			$stmt->bind_param("sssssssssssssssssii", $nome, $cognome, $sesso, $data, $titolo, $indirizzo, $citta, $cap, $prov, $stato, $tel_1, $tel_2, $cod_fiscale, $p_iva, $note, $privacy, $email, $this->id, $_SESSION['company_id']);
			if(!$stmt->execute()){
				echo("Errore: ".mysqli_error($this->conn));
				return false;
				}
		}
	}
	public function rimuoviPaziente(){
		if($stmt = $this->conn->prepare("UPDATE PAZIENTI SET ELIMINATO = NOW() WHERE ID = ? AND KCO = ?")){
			$stmt->bind_param("ii", $this->id, $_SESSION['company_id']);
			if(!$stmt->execute()){
				echo("Errore: ".mysqli_error($this->conn));
				return false;
				}
		}
	}
	public function aggiungiPaziente($nome, $cognome, $sesso, $data, $titolo, $indirizzo, $citta, $cap, $prov, $stato, $tel_1, $tel_2, $cod_fiscale, $p_iva, $note, $privacy, $email){
		if($stmt = $this->conn->prepare("INSERT INTO PAZIENTI SET NOME=?, COGNOME=?, SESSO=?, DATA=?, TITOLO=?, INDIRIZZO=?, CITTA=?, CAP=?, PROV=?, STATO=?, TEL_1=?, TEL_2=?, COD_FISCALE=?, P_IVA=?, NOTE=?, PRIVACY=?, EMAIL=?, KCO=?"))
			$stmt->bind_param("sssssssssssssssssi",$nome, $cognome, $sesso, $data, $titolo, $indirizzo, $citta, $cap, $prov, $stato, $tel_1, $tel_2, $cod_fiscale, $p_iva, $note, $privacy, $email, $_SESSION['company_id']);
			if(!$stmt->execute()){
				echo("Errore: ".mysqli_error($this->conn));
				return false;
				}
	}
	
}

?>
