<?php 
if(!(isset($paginaIntegra) && $paginaIntegra === true)) exit();

$codicefiscale = $_SESSION['codicefiscale'];
$id_referto = $_SESSION['id_referto'];
$company_id = $_SESSION['company_id'];
if ($stmt = $conn->prepare("SELECT data, note, scaricato, datapubblicazione, datascadenza, tipo, filepdf FROM referti WHERE codicefiscale = ? and filepdf is not null and id = ? and company_id = ?")) { 
	$stmt->bind_param('sii', $codicefiscale, $id_referto, $company_id); 
	if($stmt->execute()){
		$stmt->store_result();
		if ($stmt->num_rows >= 1) { //Uses the stored result and counts the rows.
			$stmt->bind_result($data, $note, $scaricato, $datapubblicazione, $datascadenza, $tipo, $filepdf);
			$array_referti = array();
			
			$stmt->fetch();
			
			$params_download = array_merge($_GET, array("action" => "download"));
			$download_q = http_build_query($params_download);

			$params_open = array_merge($_GET, array("action" => "open"));
			$open_q = http_build_query($params_open);
			
		}else{
			echo "Referto non trovato";
		}
	}else{
		echo mysqli_error($conn);
	}
}else{
	echo mysqli_error($conn);
}

//Dato che viene incluso download.php anche nell'head, e che lo script apre il pdf anche senza passare nulla, bisogna fargli capire che lo deve aprire solamente in questo punto in cui la variabile control_areariservata è true

//$control_areariservata = true; 
//visualizzaFileDaAreaRiservata($conn);


header("content-type: ".mime_content_type($filepdf)); 
header('Content-Length: ' . filesize($filepdf));	

	/*
$c = file_get_contents(__DIR__  ."/../".$filepdf);

echo $c;*/
	
readfile(__DIR__  ."/../".$filepdf);


?>
