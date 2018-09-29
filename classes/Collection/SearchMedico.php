<?php

class SearchMedico{
	
	//SET
	private $conn;
	
	//Pazienti
	private $ids = array();
	
	public function __construct($conn){
		$this->conn = $conn;
	}
	
	public function searchByNomeCognome($nominativo){
		
		$nominativo = "%".strtoupper($nominativo)."%";
		
		if($stmt = $this->conn->prepare("SELECT ID FROM MEDICI WHERE CONCAT(NOME, ' ', COGNOME) LIKE ?")) {
            $stmt->bind_param('s', $nominativo); // esegue il bind del parametro '$user_id'.
            if($stmt->execute()){
				
					
				if(!$stmt->bind_result($id)) echo mysqli_error($conn);

				while($stmt->fetch()){
					echo $id;
					$ids[] = $id;
				}

				return $ids;
				
			}else{
				return false;
			}
		}
		
	}
	
	public function selezionaTutto(){
		
		if($stmt = $this->conn->prepare("SELECT ID, NOME, COGNOME FROM MEDICI")) {
            if($stmt->execute()){
				
				if(!$stmt->bind_result($id, $nome, $cognome)) echo mysqli_error($conn);

				while($stmt->fetch()){
					$medici[] = array(
						"id"=>$id,
						"nome"=>$cognome." ".$nome
					);
				}

				return $medici;
				
			}else{
				return false;
			}
		}
		
	}

	
}



