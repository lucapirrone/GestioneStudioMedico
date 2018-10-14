<?php
class PrestEff{
	//SET
	private $conn;
	
	//VARIABILI
	public $id;
	public $id_paziente_dest;
	public $id_medico_dest;
	public $id_societa_dest;
	public $id_prest;
	public $id_medico_1;
	public $id_medico_2;
	public $id_medico_3;
	public $id_medico_4;
	public $id_medico_5;
	public $data_reg;
	public $data_fat;
	public $imposta;
	
	
	public function __construct($conn) {
        $this->conn = $conn;
    }
	
	public function selectPrestEffById($id){
		if($stmt = $this->conn->prepare("SELECT ID, ID_PAZ, ID_MEDICO, ID_SOCIETA, ID_PREST, ID_MEDICO_1, ID_MEDICO_2, ID_MEDICO_3, ID_MEDICO_4, ID_MEDICO_5, DATA_REG, DATA_FAT, IMPORTO FROM PREST_EFF WHERE ID = ? AND KCO = ?")) {
            $stmt->bind_param('ii', $id, $_SESSION['company_id']); // esegue il bind del parametro '$user_id'.
            $stmt->execute(); // Esegue la query creata.
            $stmt->store_result();
			
            if($stmt->num_rows == 1) { // se l'utente esiste
				$this->id = $id;

				$stmt->bind_result($this->id, $this->id_paziente_dest, $this->id_medico_dest, $this->id_societa_dest, $this->id_prest, $this->id_medico_1, $this->id_medico_2, $this->id_medico_3, $this->id_medico_4, $this->id_medico_5, $this->data_reg, $this->data_fat, $this->imposta);
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
	public function modificaPrestEff($id, $id_paziente, $id_prest, $id_medico_1, $id_medico_2, $id_medico_3, $id_medico_4, $id_medico_5, $data, $imposta){
		if($stmt = $this->conn->prepare("UPDATE PREST_EFF SET ID_PAZ=?, ID_PREST=?, ID_MEDICO_1=?, ID_MEDICO_2=?, ID_MEDICO_3=?, ID_MEDICO_4=?, ID_MEDICO_5=?, DATA=?, IMPORTO=? WHERE ID = ? AND KCO = ?")){
			$stmt->bind_param("iiiiiiisiii", $id_paziente, $id_prest, $id_medico_1, $id_medico_2, $id_medico_3, $id_medico_4, $id_medico_5, $data, $imposta, $this->id, $_SESSION['company_id']);
			if(!$stmt->execute()){
				echo("Errore: ".mysqli_error($this->conn));
				return false;
				}
		}
	}
	public function rimuoviPrestEff(){
		if($stmt = $this->conn->prepare("UPDATE PAZIENTI SET ELIMINATO = NOW() WHERE ID = ? AND KCO = ?")){
			$stmt->bind_param("ii", $this->id, $_SESSION['company_id']);
			if(!$stmt->execute()){
				echo("Errore: ".mysqli_error($this->conn));
				return false;
				}
		}
	}
	public function aggiungiPrestEff($id_paziente, $id_medico, $id_societa, $id_prest, $id_medico_1, $id_medico_2, $id_medico_3, $id_medico_4, $id_medico_5, $data_reg, $data_fat, $imposta){
		if($stmt = $this->conn->prepare("INSERT INTO PREST_EFF SET ID_PAZ=?, ID_MEDICO = ?, ID_SOCIETA = ?, ID_PREST = ?, ID_MEDICO_1 = ?, ID_MEDICO_2 = ?, ID_MEDICO_3 = ?, ID_MEDICO_4 = ?, ID_MEDICO_5 = ?, DATA_REG = ?, DATA_FAT = ?, IMPORTO = ?, KCO = ?")){
 
			$stmt->bind_param("iiiiiiiiissii",$id_paziente, $id_medico, $id_societa, $id_prest, $id_medico_1, $id_medico_2, $id_medico_3, $id_medico_4, $id_medico_5, $data_reg, $data_fat, $imposta, $_SESSION['company_id']);
			if($stmt->execute()){
				return $this->conn->insert_id;
			}else{
				echo("Errore: ".mysqli_error($this->conn));
				return false;
			}
		}else{
			echo("Errore: ".mysqli_error($this->conn));
			return false;
		}
			
	}
}

?>