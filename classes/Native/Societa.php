<?php

class Company{
	
	//SET
	private $conn;
	
	//ANAGRAFICA PAZIENTE
	public $id;
	public $nome;
	public $logo;
	public $indirizzo;
	public $cap;
	public $citta;
	public $p_iva;
	
	public function __construct($conn) {
        $this->conn = $conn;
		$this->selectSocietaById($_SESSION['company_id']);
    }
	
	public function selectSocietaById($id){
		if($stmt = $this->conn->prepare("SELECT ID, NOME, LOGO, INDIRIZZO, CAP, CITTA, P_IVA FROM COMPANY WHERE ID = ?")) {
            $stmt->bind_param('i', $id); // esegue il bind del parametro '$user_id'.
            $stmt->execute(); // Esegue la query creata.
            $stmt->store_result();
			
            if($stmt->num_rows == 1) { // se l'utente esiste
				$this->id = $id;

				$stmt->bind_result($this->id, $this->nome, $this->logo, $this->indirizzo, $this->cap, $this->citta, $this->p_iva);
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
	public function modificaSocieta($id, $nome, $logo){
		if($stmt = $this->conn->prepare("UPDATE COMPANY SET NOME=?, LOGO=? WHERE ID = ?")){
			$stmt->bind_param("ssi", $nome, $logo, $id);
			if(!$stmt->execute()){
				echo("Errore: ".mysqli_error($this->conn));
				return false;
				}
		}
	}
	public function aggiungiSocieta($nome, $logo){
		if($stmt = $this->conn->prepare("INSERT INTO COMPANY SET NOME=?, LOGO=?")){
			$stmt->bind_param("ss",$nome, $logo);
			if(!$stmt->execute()){
				echo("Errore: ".mysqli_error($this->conn));
				return false;
			}
		}
	}
}

?>
