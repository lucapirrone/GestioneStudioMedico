<?php

	require "lib/plugins/aws/vendor/autoload.php";
	use Aws\S3\S3Client;

    $array_info = [
		"descrizione",
        "id_prestazione",
        "id_medico_1",
        "id_medico_2",
        "id_medico_3",
        "id_medico_4",
        "id_medico_5",
        "importo",
        "data_fat",
        "flag_iva",
        "flag_ritenuta"
    ];

	// Bucket Name
	$bucket = 'gestionestudiomedico';

	//instantiate the class
	$sharedConfig = [
		'version' => 'latest',
		'region'  => 'us-east-2',
		'signature' => 'v4',
	];

	$s3Client = S3Client::factory($sharedConfig);


	function uploadToS3($path_file, $date, $id_fattura){
		global $conn;
		
		$year = date("Y", $date);
		$month = date("m", $date);
		$day = date("d", $date);
		 
		$target_path = "fatture/".$_SESSION['company_id']."/".$year."/".$month."/".$day."/".basename($path_file);
		
		try{
			global $s3Client;
			global $bucket;
			
			$result = $s3Client ->putObject(
				array(
					'Bucket'=>$bucket,
					'Key' =>  $target_path,
					'SourceFile' => $path_file,
					'StorageClass' => 'STANDARD'
				)
			);
			
			$gdoc = new GDoc($conn);
			if(!$id_doc_gest = $gdoc->aggiungiGDoc($id_fattura, $_SESSION['id_utente'], "FATTURA", time(), $result['ObjectURL'], $target_path)){
				_error(500, "Si è verificato un errore nell'aggiunta del documento nel sistema documentale");
			}
			
			
			//if(!isset($_SESSION['action_token']) || !isset($action_token))	$action_token = $_SESSION['action_token'] = md5(uniqid(mt_rand(), true));
			
			//$url = "?action=request&action_code=3&action_token=".$action_token."&id_fattura=".$id_fattura;
						
			/*echo '
			<script>
			
				if(confirm("Prestazione Salvata Correttamente! Vuoi visualizzare la fattura?")){
					window.open("'.$url.'", "_blank");
				}
			</script>';*/
						
			return true;

		}catch(Exception $e){
			console_log($e->getMessage());
			_error(405, "Impossibile caricare il file: ".$e->getMessage());
		}
	}
	

	function _error($code, $addmsg){
		global $errors;
		global $conn;

		$message="Si e' verificato un errore sconosciuto";

		foreach($errors as $error){
			if($error['code']==$code)
				$message = $error['message'];
		}

		if($addmsg!=null)	$message = $message.": ".$addmsg;

		echo '<script>alert("'.$message.'");</script>';
		if (!$conn->rollback()) {
			echo "Operazione non andata a buon fine: Errore rollback";
			$conn->autocommit(true);
			exit();
		}
		exit();
		$conn->autocommit(true);
	}

	function visualizzaFattura($id_fattura){

		/*header("Content-Type: ".mime_content_type($s3_link)); 
		header('Content-Disposition: inline; filename="'.basename($s3_link).'"');
		header('Content-Length: ' . filesize($s3_link));	

		// Register the stream wrapper from an S3Client object
		$s3Client->registerStreamWrapper();

		// Download the body of the "key" object in the "bucket" bucket
		$data = file_get_contents($s3_link);

		// Open a stream in read-only mode
		if ($stream = fopen($s3_link, 'r')) {
			// While the stream is still open
			while (!feof($stream)) {
				// Read 1024 bytes from the stream

				echo fread($stream, 1024);
			}
			// Be sure to close the stream resource when you're done with it
			fclose($stream);
		}*/
		
		// Bucket Name
		global $conn;
		$bucket = 'gestionestudiomedico';

		//instantiate the class
		$sharedConfig = [
			'version' => 'latest',
			'region'  => 'us-east-2',
			'signature' => 'v4',
		];

		$s3Client = S3Client::factory($sharedConfig);

		$gdoc = new GDoc($conn);
		$gdoc->selectGDocByIdAndType($id_fattura, "FATTURA");

		$s3_link = $gdoc->link_doc_s3;
		$s3_key = $gdoc->key_doc_s3;

		$result = $s3Client->getObject([
			'Bucket' => $bucket,
			'Key'    => $s3_key
		]);

		// Display the object in the browser.
		header("Content-Type: {$result['ContentType']}");
		echo $result['Body'];
	}

  	function checkValidate($array_info, $conn){

        $valido=true;
        for($i=0; $i<=count($array_info)-1; $i++){
            if(!isset($_POST[$array_info[$i]])){
                $valido = false;
                return $valido;
            }
        }
		
		//Questo script può essere eseguito soltanto da un amministratore
        if(login_check_admin($conn) == false){
            $valido = false;    
            _error(400, null); 
            return $valido;       
        }		

		if(!checkToken()){
			$valido = false; 
			return $valido;
		}
		
        return $valido;

    }

    if(checkValidate($array_info, $conn)) { 

				
		//Dichiarazione variabili prese da parametri post e trasformati in MAIUSCOLO
        foreach($array_info as $item){
			if($_POST[$item]!=="" && $_POST[$item]!=="-1"){
				${$item} = $_POST[$item]; //explode
			}else
				${$item} = null;
		}
		

		//Impostazione del Destinatario

		if(isset($_POST['id_paziente'])){
			$id_paziente_dest = $_POST['id_paziente'];
		}else{
			$id_paziente_dest = null;
		}
		if(isset($_POST['id_medico'])){
			$id_medico_dest = $_POST['id_medico'];
		}else{
			$id_medico_dest = null;
		}
		if(isset($_POST['id_societa'])){
			$id_societa_dest = $_POST['id_societa'];
		}else{
			$id_societa_dest = null;
		}


		if($id_paziente_dest!=null){
			$paz = new Paziente($conn);
			$paz->selectPazienteById($id_paziente_dest);

			$dest_fatt = new DestinatarioFattura($paz->nome, $paz->cognome, $paz->data, $paz->titolo, $paz->indirizzo, $paz->citta, $paz->cap, $paz->provincia,	$paz->stato,	$paz->tel_1,	$paz->tel_2,	$paz->cod_fiscale, $paz->p_iva, $paz->note, $paz->email);
		}
		if($id_medico_dest!=null){
			$medico = new Medico($conn);
			$medico->selectMedicoById($id_medico_dest);

			$dest_fatt = new DestinatarioFattura($medico->nome, $medico->cognome, null, $medico->titolo, $medico->indirizzo, $medico->citta, $medico->cap, $medico->prov,	null,	null,	null,	$medico->cod_fiscale, $medico->p_iva, null, null);
		}
		if($id_societa_dest!=null){
			$se = new SocietaEsterna($conn);
			$se->selectSocietaEsternaById($id_societa_dest);

			$dest_fatt = new DestinatarioFattura($se->nome, null, null, null, $se->indirizzo, $se->citta, $se->cap, $se->provincia,	null,	null,	null,	null, $se->p_iva, null, null);
		}		

		$conn->autocommit(false);

		$f = new Fattura($conn);
		$pn = new Movimento($conn);
		$co = new Company($conn);
		$medico = new Medico($conn);
		$prest = new Prestazione($conn);
		$pe = new PrestEff($conn);


		$data_reg = time();
		$data_fat = strtotime($data_fat);

		if(!$prest->selectPrestazioneById($id_prestazione)){
			error(500, "Si è verificato un errore nella selezione della prestazione");
		}


		if(!$id_prest_eff = $pe->aggiungiPrestEff($id_paziente_dest, $id_medico_dest, $id_societa_dest, $id_prestazione, $id_medico_1, $id_medico_2, $id_medico_3, $id_medico_4, $id_medico_5, $data_reg, $data_fat, $importo)){
			error(500, "Si è verificato un errore nell'aggiunta della prestazione effettuata");
		}


		//CALCOLO IMPORTI
		$importo_tot = $importo;
		$bollo = 0;
		$perc_iva = 0;
		$imp_iva = 0;
		$perc_rit = 0;
		$imp_rit = 0;

		if($flag_iva=="SI")		$perc_iva = 22;
		if($flag_ritenuta=="SI")	$perc_rit = 20;

		if($flag_iva=="SI"){
			$imp_iva = ($importo/100)*$perc_iva;
			$importo_tot = $importo_tot + $imp_iva;
		}	
		if($flag_ritenuta=="SI"){
			$imp_rit = ($importo/100)*$perc_rit;
			$importo_tot = $importo_tot - $imp_rit;
		}	
		if($flag_iva!="SI"){
			if($importo_tot>77){
				$bollo = 2;
				$importo_tot = $importo_tot + $bollo;
			}else{
				$bollo = 0;
			}
		}

		if(!$id_fattura = $f->aggiungiFattura($descrizione, $data_reg, $data_fat, $importo,$flag_iva,$id_prest_eff,$flag_ritenuta, $bollo, $importo_tot)){
			error(500, "Si è verificato un errore nell'aggiunta della fattura");
		}


		if(!$pn->aggiungiMovimento($data_reg, $data_fat, $dest_fatt->cognome." ".$dest_fatt->nome, $prest->nome, "CONTANTI", 0, $importo, $importo)){
			error(500, "Si è verificato un errore nell'aggiunta del movimento");
		}


		$iva = null;
		$ritenuta = null;
		$path_fattura = null;

		require 'lib/fpdf/generatepdf.php';

		$path_fattura = generaFattura($id_fattura);
		if($path_fattura==false){
			error(500, "Si è verificato un errore nella stampa della fattura emessa dalla società");
		}


		if(!uploadToS3($path_fattura, $data_fat, $id_fattura)){
			error(500, "Si è verificato un errore nel caricamento del file su cloud");
		}		

		if (!$conn->commit()) {
			echo "<script>alert('Si è verificato un errore nel commit!');</script>";
			$conn->autocommit(true);
			exit();
		}
		//visualizzaFattura($id_fattura);
		echo json_encode(array(
			"code"=>200,
			"id_fattura"=>$id_fattura
		));
		$conn->autocommit(true);
		die();
	}

?>