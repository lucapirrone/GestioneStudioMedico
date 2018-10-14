<?php

class GDoc{
	
	//SET
	private $conn;
	
	//VARIABILI
	public $id;
	public $id_doc;
	public $autore;
	public $natura;
	public $dt_mem;
	public $link_doc_s3;
	public $key_doc_s3;
	
	public function __construct($conn){
		$this->conn = $conn;

	}
	
	public function aggiungiGDoc($id_doc, $autore, $natura, $dt_mem, $link_doc_s3, $key_doc_s3){ //Aggiunge Fattura
		if($stmt = $this->conn->prepare("INSERT INTO G_DOC SET ID_DOC = ?, AUTORE=?, NATURA=?, DT_MEM=?, LINK_DOC_S3=?, KEY_DOC_S3=?, KCO=?")){
			if($stmt->bind_param("iissssi",$id_doc, $autore, $natura, $dt_mem, $link_doc_s3, $key_doc_s3, $_SESSION['company_id'])){
				if($stmt->execute()){
					return $this->conn->insert_id;
				}else{
					echo("Errore: ".mysqli_error($this->conn));
					return false;
				}
			}else{
				echo("Errore: ".mysqli_error($this->conn));
			}
		}else{
			echo("Errore: ".mysqli_error($this->conn));
			return false;
		}		
	}
	
	public function selectGDocByIdAndType($id, $type){ //Aggiunge Fattura
		if($stmt = $this->conn->prepare("SELECT ID ,ID_DOC, AUTORE, NATURA, DT_MEM, LINK_DOC_S3, KEY_DOC_S3 FROM G_DOC WHERE ID_DOC = ? AND NATURA = ? AND KCO = ?")){
			if($stmt->bind_param("isi", $id, $type, $_SESSION['company_id'])){
				if($stmt->execute()){
					if($stmt->store_result()){
						if($stmt->num_rows == 1){ // se l'utente esiste
							if($stmt->bind_result($this->id, $this->id_doc, $this->autore, $this->natura, $this->dt_mem, $this->link_doc_s3, $this->key_doc_s3)){
								if($stmt->fetch()){
									return true;
								}else{
									echo("Errore: ".mysqli_error($this->conn));
									return false;
								}
							}else{
								echo("Errore: ".mysqli_error($this->conn));
								return true;
							}
						}else{
							echo("Errore: ".mysqli_error($this->conn));
							return false;
							}
					}else{
						echo("Errore: ".mysqli_error($this->conn));
						return false;
						}
				}else{
					echo("Errore: ".mysqli_error($this->conn));
					return false;
					}
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

