<?php

class SearchPaziente{
	
	//SET
	private $conn;
	
	//Pazienti
	private $ids = array();
	
	public function __construct($conn){
		$this->conn = $conn;
	}
	
	public function searchByNomeCognome($nominativo){
		
		$nominativo = "%".strtoupper($nominativo)."%";
		
		if($stmt = $this->conn->prepare("SELECT ID FROM PAZIENTI WHERE CONCAT(NOME, ' ', COGNOME) LIKE ?")) {
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
	
}



