<?php

class Fattura{
	
	//SET
	private $conn;
	
	//VARIABILI
	public $id;
	public $id_doc;
	public $autore;
	public $natura;
	public $dt_mem;
	public $link_doc_s3;
	
	public function __construct($conn){
		$this->conn = $conn;

	}
	
	public function aggiungiGDoc($id_doc, $autore, $natura, $dt_mov, $link_doc_s3){ //Aggiunge Fattura
		if($stmt = $this->conn->prepare("INSERT INTO G_DOC SET AUTORE=?, NATURA=?, DT_MOV=?, LINK_DOC_S3=?, KCO=?")){
			$stmt->bind_param("iisssi",$id_doc, $autore, $natura, $dt_mov, $link_doc_s3, $_SESSION['company_id']);
			if($stmt->execute()){
				return true;
			}else{
				echo("Errore: ".mysqli_error($this->conn));
				return false;
			}
		}else{
			echo("Errore: ".mysqli_error($this->conn));
		}
			
	}
	
}
