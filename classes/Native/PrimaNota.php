<?php

class Movimento{
	
	private $conn;
	//Attributi
	public $id;
	public $data_reg;
	public $data_mov;
	public $intestatario;
	public $descrizione;
	public $tipo_pagamento;
	public $dare;
	public $avere;
	public $cassa;
	
	
	
	public function __construct($conn) {
        $this->conn = $conn;
    }
	
	public function selectMovimentoById($id){
		if($stmt = $this->conn->prepare("SELECT ID, DATA_REG, DATA_MOV, INTESTATARIO, DESCRIZIONE, TIPO_PAGAMENTO, DARE, AVERE, CASSA FROM PRIMA_NOTA WHERE ID = ? AND KCO = ?")) {
            $stmt->bind_param('ii', $id, $_SESSION['company_id']); // esegue il bind del parametro '$user_id'.
            $stmt->execute(); // Esegue la query creata.
            $stmt->store_result();
			
            if($stmt->num_rows == 1) { // se l'utente esiste
				$this->id = $id;
				$stmt->bind_result($this->id, $this->data_reg, $this->data_mov, $this->intestatario, $this->descrizione, $this->tipo_pagamento, $this->dare, $this->avere, $this->cassa);
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
	
	public function modificaMovimento($id, $data_reg, $data_mov, $intestatario, $descrizione, $tipo_pagamento, $dare, $avere, $cassa){
		if($stmt = $this->conn->prepare("UPDATE PRIMA_NOTA SET DATA_REG = ?, DATA_MOV = ?, INTESTATARIO = ?, DESCRIZIONE = ?, TIPO_PAGAMENTO = ?, DARE = ?, AVERE = ?, CASSA = ? WHERE ID = ? AND KCO = ?")){
			$stmt->bind_param("sssssiiiii", $data_reg, $data_mov, $intestatario, $descrizione, $tipo_pagamento, $dare, $avere, $cassa, $this->id, $_SESSION['company_id']);
			if(!$stmt->execute()){
				echo("Errore: ".mysqli_error($this->conn));
				return false;
				}
		}
	}
	public function rimuoviMovimento(){
		if($stmt = $this->conn->prepare("UPDATE PRIMA_NOTA SET ELIMINATO = NOW() WHERE ID = ? AND KCO = ?")){
			$stmt->bind_param("ii", $this->id, $_SESSION['company_id']);
			if(!$stmt->execute()){
				echo("Errore: ".mysqli_error($this->conn));
				return false;
				}
		}
	}
	
	public function aggiungiMovimento($data_reg, $data_mov, $intestatario, $descrizione, $tipo_pagamento, $dare, $avere, $cassa){
		if($stmt = $this->conn->prepare("INSERT INTO PRIMA_NOTA SET DATA_REG = ?, DATA_MOV = ?, INTESTATARIO = ?, DESCRIZIONE = ?, TIPO_PAGAMENTO = ?, DARE = ?, AVERE = ?, CASSA = ?, KCO=?"))
			$stmt->bind_param("sssssiiii", $data_reg, $data_mov, $intestatario, $descrizione, $tipo_pagamento, $dare, $avere, $cassa, $_SESSION['company_id']);
			if(!$stmt->execute()){
				echo("Errore: ".mysqli_error($this->conn));
				return false;
				}
	}
	
	
}

?>