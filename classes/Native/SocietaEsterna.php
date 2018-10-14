<?php
class SocietaEsterna{
	//SET
	private $conn;
	
	//VARIABILI
	public $id;
	public $nome;
	public $indirizzo;
	public $provincia;
	public $citta;
	public $cap;
	public $cod_fiscale;
	public $p_iva;
	
	
	public function __construct($conn) {
        $this->conn = $conn;
    }
	
	public function selectSocietaEsternaById($id){
		if($stmt = $this->conn->prepare("SELECT ID, NOME, INDIRIZZO, PROVINCIA, CITTA, CAP, COD_FISCALE, P_IVA FROM SOCIETA_ESTERNA WHERE ID = ? AND KCO = ?")) {
            $stmt->bind_param('ii', $id, $_SESSION['company_id']); // esegue il bind del parametro '$user_id'.
            $stmt->execute(); // Esegue la query creata.
            $stmt->store_result();
			
            if($stmt->num_rows == 1) { // se l'utente esiste
				$this->id = $id;

				$stmt->bind_result($this->id, $this->nome, $this->indirizzo, $this->provincia, $this->citta, $this->cap, $this->cod_fiscale, $this->p_iva);
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
	public function modificaSocietaEsterna($nome, $indirizzo, $provincia, $citta, $cap, $cod_fiscale, $p_iva){
		if($stmt = $this->conn->prepare("UPDATE SOCIETA_ESTERNA SET NOME=?, INDIRIZZO=?, PROVINCIA=?, CITTA=?, CAP=?, COD_FISCALE?, P_IVA=? WHERE ID = ? AND KCO = ?")){
			$stmt->bind_param("sssssssii", $nome, $indirizzo, $provincia, $citta, $cap, $cod_fiscale, $p_iva, $this->id, $_SESSION['company_id']);
			if(!$stmt->execute()){
				echo("Errore: ".mysqli_error($this->conn));
				return false;
			}
			else{
				return true;
			}
		}
	}
	public function rimuoviSocietaEsterna(){
		if($stmt = $this->conn->prepare("UPDATE SOCIETA_ESTERNA SET ELIMINATO = NOW() WHERE ID = ? AND KCO = ?")){
			$stmt->bind_param("ii", $this->id, $_SESSION['company_id']);
			if(!$stmt->execute()){
				echo("Errore: ".mysqli_error($this->conn));
				return false;
				}
		}
	}
	public function aggiungiSocietaEsterna($nome, $indirizzo, $prov, $citta, $cap, $cod_fiscale, $p_iva){
		if($stmt = $this->conn->prepare("INSERT INTO SOCIETA_ESTERNA SET NOME=?, INDIRIZZO=?, PROVINCIA=?, CITTA=?, CAP=?, COD_FISCALE = ?, P_IVA = ?, KCO = ?")){
			$stmt->bind_param("sssssssi",$nome, $indirizzo, $prov, $citta, $cap, $cod_fiscale, $p_iva, $_SESSION['company_id']);
			if(!$stmt->execute()){
				echo("Errore: ".mysqli_error($this->conn));
				return false;
			}else{
				return $this->conn->insert_id;
			}
		}
	}
}

?>