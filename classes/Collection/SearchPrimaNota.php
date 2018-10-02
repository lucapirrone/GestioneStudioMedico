<?php

class SearchPrimaNota{
	
	//SET
	private $conn;
	
	//Pazienti
	private $ids = array();
	private $movimenti = array();
	
	public function __construct($conn){
		$this->conn = $conn;
	}
	
	public function filtraMovimenti($from, $to){
		
		if($stmt = $this->conn->prepare("SELECT ID FROM PRIMA_NOTA WHERE DATA_MOV >= ? AND DATA_MOV <= ?")) {
			
			if($stmt->bind_param("ii", $from, $to)){
				if($stmt->execute()){
					if($stmt->store_result()){
						if($stmt->bind_result($id)){ 

							while($stmt->fetch()){
								$pn = new Movimento($this->conn);
								$pn->selectMovimentoById($id);
								$this->movimenti[] = $pn;
							}

							return $this->movimenti;
							
						}else{
							echo mysqli_error($conn);
						}
					}
				}else{
					return false;
				}
				
			}
		}
		
	}
	
	public function buildTable(){
		$array_keys = [
			"ID", 
			"Data Registrazione", 
			"Data Movimento", 
			"Intestatario", 
			"Descrizione", 
			"Pagaemnto", 
			"Entrata", 
			"Uscita", 
			"Cassa"
		];

		
		if($this->movimenti==null){
			echo "Non ci sono movimenti per questa ricerca";
		}else{
						
			$tabella = new Table($array_keys);
			$tabella->designKeys();
			foreach($this->movimenti as $movimento){

				$array_body = [
					$movimento->id,
					date('m/d/Y', $movimento->data_reg),
					date('m/d/Y', $movimento->data_mov),
					$movimento->intestatario,
					$movimento->descrizione,
					$movimento->tipo_pagamento,
					$movimento->avere,
					$movimento->dare,
					$movimento->cassa		
				];

				$tabella->designBody($array_body);

			}
			$tabella->designFooter();
		}
		
	}
	
}



