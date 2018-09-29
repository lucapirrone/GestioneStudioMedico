<?php

class SearchPrestazioni{
	
	//SET
	private $conn;
	
	//Pazienti
	private $ids = array();
	private $nomi = array();
	
	public function __construct($conn){
		$this->conn = $conn;
	}
	
	public function selezionaTutto(){
		
		if($stmt = $this->conn->prepare("SELECT ID, NOME FROM PRESTAZIONI")) {
            if($stmt->execute()){
				
				if(!$stmt->bind_result($id, $nome)) echo mysqli_error($conn);

				while($stmt->fetch()){
					$nomi[] = array(
						"id"=>$id,
						"nome"=>$nome
					);
				}

				return $nomi;
				
			}else{
				return false;
			}
		}
		
	}
	
}



