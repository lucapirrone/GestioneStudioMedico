<?php

	/*
	Questo script eseguibile solamente da amministratore, permette di rimuovere referti nel database, passando come paremetri di tipo POST:
	 - id del referto;
	 
	 Una volta aver controllato che la sessione è di un amministratore, verrà eliminato il relativo referto
	 
	*/
    


    $array_info = [
		"action",
		"delete_user_id",
		"delete_user",
		"token"
	];


	 function checkValidate($array_info, $conn){

		$valido=true;

		 //Vengono controllati che i parametri GET siano validi
		for($i=0; $i<=count($array_info)-1; $i++){
			if(!isset($_GET[$array_info[$i]])){
				$valido = false;
				return $valido;
			}
		}
		 
		//Controlla che la sessione è loggata e che è di tipo AMMINISTRATORE
		if(login_check_admin($conn) == false || $_SESSION['type']==0){
			$valido = false;    
			return $valido;       
		}

		return $valido;

	}

    function _success($id){

        $json_return = array(
            "code"=>200,
			"message"=>"Eliminazione avvenuta con successo.",
			"id"=>$id
        );

        echo "<script>alert('Eliminazione avvenuta con successo!');</script>";
    }

    if(checkValidate($array_info, $conn) && $_GET['token']===$_SESSION['token']) {
		if($_GET['action']=="delete"){
			
			$codicesocieta = $_GET['codicesocieta'];
			if ($stmt = $conn->prepare("SELECT id FROM societa WHERE `codicestudio` = ? LIMIT 1")) { 
				$stmt->bind_param('s', $codicesocieta); // esegue il bind del parametro '$email'.
				if($stmt->execute()){ 
					$stmt->store_result();
					$stmt->bind_result($company_id);
					$stmt->fetch();
				}
			}
			
			$delete_user_id = $_GET['delete_user_id'];
			$delete_user = $_GET['delete_user'];
			if($insert_stmt = $conn->prepare("DELETE FROM amministratori WHERE id = ? and utente = ? and company_id = ?")){

				$insert_stmt->bind_param("isi", $delete_user_id, $delete_user, $company_id);

				if($insert_stmt->execute()){
					log_admin_action($conn, "deleted id:".$delete_user_id.", utente:".$delete_user.", società: ".$company_id, $delete_user_id);
					echo'<script>alert("Amministratore eliminato con successo!");</script>';
				}else{
					echo mysqli_error($conn);
				}


			}else{
				echo mysqli_error($conn);	
			}

		}

		
	}


?>