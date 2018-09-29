<?php

class Prestazione{
	
	//SET
	private $conn;
  //VARIABILI
  public $nome;
  public $importo;
  public $fatturato;
  public $medico_1;
  public $medico_2;
  public $medico_3;
  public $medico_4;
  public $medico_5;
  public $perc_medico_1;
  public $perc_medico_2;
  public $perc_medico_3;
  public $perc_medico_4;
  public $perc_medico_5;
  public $kco;
	

	public function __construct($conn) {
        $this->conn = $conn;
    }
	
	public function selectPrestazioneById($id){
		if($stmt = $this->conn->prepare("SELECT ID, NOME, IMPORTO, FATTURATO, MEDICO_1, MEDICO_2, MEDICO_3, MEDICO_4, MEDICO_5, PERC_MEDICO_1, PERC_MEDICO_2, PERC_MEDICO_3, PERC_MEDICO_4, PERC_MEDICO_5 FROM PRESTAZIONI WHERE ID = ? AND KCO = ?")) {
            $stmt->bind_param('ii', $id, $_SESSION['company_id']); // esegue il bind del parametro '$user_id'.
            $stmt->execute(); // Esegue la query creata.
            $stmt->store_result();
			
            if($stmt->num_rows == 1) { // se l'utente esiste
				$this->id = $id;
				$stmt->bind_result($this->id, $this->nome, $this->importo, $this->fatturato, $this->medico_1, $this->medico_2, $this->medico_3, $this->medico_4, $this->medico_5, $this->perc_medico_1, $this->perc_medico_2, $this->perc_medico_3, $this->perc_medico_4, $this->perc_medico_5);
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
	public function modificaPrestazione($id, $nome, $importo, $fatturato, $medico_1, $medico_2, $medico_3, $medico_4, $medico_5, $perc_medico_1, $perc_medico_2, $perc_medico_3, $perc_medico_4, $perc_medico_5){
		if($stmt = $this->conn->prepare("UPDATE PRESTAZIONI SET NOME=?, IMPORTO=?, FATTURATO=?, MEDICO_1=?, MEDICO_2=?, MEDICO_3=?, MEDICO_4=?, MEDICO_5=?, PERC_MEDICO_1=?, PERC_MEDICO_2=?, PERC_MEDICO_3=?, PERC_MEDICO_4=?, PERC_MEDICO_5=? WHERE ID = ? AND KCO = ?")){
			$stmt->bind_param("sissssssiiiiiii", $nome, $importo, $fatturato, $medico_1, $medico_2, $medico_3, $medico_4, $medico_5, $perc_medico_1, $perc_medico_2, $perc_medico_3, $perc_medico_4, $perc_medico_5, $this->id, $_SESSION['company_id']);
			if(!$stmt->execute()){
				echo("Errore: ".mysqli_error($this->conn));
				return false;
				}
		}
	}
	public function rimuoviPrestazione(){
		if($stmt = $this->conn->prepare("UPDATE PRESTAZIONI SET ELIMINATO = NOW() WHERE ID = ? AND KCO = ?")){
			$stmt->bind_param("ii", $this->id, $_SESSION['company_id']);
			if(!$stmt->execute()){
				echo("Errore: ".mysqli_error($this->conn));
				return false;
				}
		}
	}
	public function aggiungiPrestazione($nome, $importo, $fatturato, $medico_1, $medico_2, $medico_3, $medico_4, $medico_5, $perc_medico_1, $perc_medico_2, $perc_medico_3, $perc_medico_4, $perc_medico_5){
		if($stmt = $this->conn->prepare("INSERT INTO PRESTAZIONI SET NOME=?, IMPORTO=?, FATTURATO=?, MEDICO_1=?, MEDICO_2=?, MEDICO_3=?, MEDICO_4=?, MEDICO_5=?, PERC_MEDICO_1=?, PERC_MEDICO_2=?, PERC_MEDICO_3=?, PERC_MEDICO_4=?, PERC_MEDICO_5=?, KCO=?"))
			$stmt->bind_param("sissssssiiiiii",$nome, $importo, $fatturato, $medico_1, $medico_2, $medico_3, $medico_4, $medico_5, $perc_medico_1, $perc_medico_2, $perc_medico_3, $perc_medico_4, $perc_medico_5, $_SESSION['company_id']);
			if(!$stmt->execute()){
				echo("Errore: ".mysqli_error($this->conn));
				return false;
				}
	}
	
}



?>
