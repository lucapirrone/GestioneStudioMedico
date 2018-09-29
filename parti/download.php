<?php

	if(!(isset($paginaIntegra) && $paginaIntegra === true)) exit();

?>
<?php


if(isset($_GET['id_referto'], $_GET['codicefiscale'], $_GET['action']) && $_SESSION['type']>=1){ //AMMINISTRATORE

	

	if($_GET['action']=="download" || $_GET['action']=="open"){
		$id_referto = $_GET['id_referto'];
		$codicefiscale = $_GET['codicefiscale'];
		$action = $_GET['action'];

		if ($stmt = $conn->prepare("SELECT filepdf FROM referti WHERE id = ? AND codicefiscale = ? and company_id = ?")) { 

			$stmt->bind_param('iss', $id_referto, $codicefiscale, $_SESSION['company_id']); // esegue il bind del parametro '$email'.

			executeOperation($stmt);

		}else{

			error(403, mysqli_error($conn));

		}	
	}

}else if(isset($_SESSION['id_referto'], $_SESSION['codicefiscale'], $_SESSION['company_id'])){ //UTENTE

		
	saveReportDownload($conn);

	$id_referto = $_SESSION['id_referto'];
	$codicefiscale = $_SESSION['codicefiscale'];
	$company_id = $_SESSION['company_id'];
	if(isset($_GET['action']))	$action = $_GET['action'];
	else $action = null;
	$time = time();

	if ($stmt = $conn->prepare("SELECT filepdf FROM referti WHERE id = ? AND codicefiscale = ? and company_id = ? and datascadenza>?")) { 

		$stmt->bind_param('isss', $id_referto, $codicefiscale, $company_id, $time);

		executeOperation($stmt);

	}else{

		error(403, mysqli_error($conn));

	}

	

}

function visualizzaFileDaAreaRiservata($conn){
	$id_referto = $_SESSION['id_referto'];
	$codicefiscale = $_SESSION['codicefiscale'];
	$company_id = $_SESSION['company_id'];
	$action = null;
	$time = time();

	if ($stmt = $conn->prepare("SELECT filepdf FROM referti WHERE id = ? AND codicefiscale = ? and company_id = ? and datascadenza>?")) { 

		$stmt->bind_param('isss', $id_referto, $codicefiscale, $company_id, $time);

		executeOperation($stmt);

	}else{

		error(403, mysqli_error($conn));

	}

	
}



function executeOperation($stmt){
	
	global $action;
	global $control_areariservata;
		
	if($stmt->execute()){

		$stmt->store_result();

		$stmt->bind_result($filepdf);

		$stmt->fetch();

		if($stmt->num_rows == 1){ // se il codice esiste

			/*	DA USARE PER SCARICARE DA S3
			// Bucket Name
			$bucket = 's3-bucket-refertionline';

			//AWS access info
			$awsAccessKey = 'AKIAJY2VGBZWME56NULA';
			$awsSecretKey = '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';

			//instantiate the class
			$s3 = S3Client::factory(
				array(
					'credentials' => array(
						'key' => $awsAccessKey,
						'secret' => $awsSecretKey
					),
					'version' => 'latest',
					'region'  => 'us-east-2',
					'http'    => [
						'verify' => false
					]
				)
			);
			*/


			if($action==="download"){
				
				/*	DOWNLOAD DA S3 FUNZIONANTE
				try {
					// Get the object.
					$result = $s3->getObject([
						'Bucket' => $bucket,
						'Key'    => $filepdf
					]);

					// Display the object in the browser.
					header('Content-Disposition: inline; filename="' . basename($filepdf) . '"');
					header("Content-Type: {$result['ContentType']}");
					echo $result['Body'];
				} catch (S3Exception $e) {
					echo $e->getMessage() . PHP_EOL;
				}*/

				if (!headers_sent()) {
				  foreach (headers_list() as $header)
					header_remove($header);
				}

				header('Content-type: application/force-download');
				header('Content-Disposition: attachment; filename="' . basename($filepdf) . '"');
				header('Content-Transfer-Encoding: binary');
				header('Accept-Ranges: bytes');
				readfile($filepdf);

			}else if($action==="open"){

				if (!headers_sent()) {
				  foreach (headers_list() as $header)
					header_remove($header);
				}

				header('Content-type: application/pdf');
				header('Content-Disposition: inline; filename="' . basename($filepdf) . '"');
				header('Content-Transfer-Encoding: binary');
				header('Content-Length: ' . filesize($filepdf));
				header('Accept-Ranges: bytes');
				readfile($filepdf);
			}else if($action===null && isset($control_areariservata) && $control_areariservata){
				if (!headers_sent()) {
				  foreach (headers_list() as $header)
					header_remove($header);
				}
				
				header('Content-type: application/pdf');
				header('Content-Disposition: inline; filename="' . basename($filepdf) . '"');
				header('Content-Transfer-Encoding: binary');
				header('Content-Length: ' . filesize($filepdf));
				header('Accept-Ranges: bytes');
				readfile($filepdf);
			}

		}else{

			error(403, mysqli_error($conn));

		}


	}else{

		error(403, mysqli_error($conn));

	}
}
	
?>