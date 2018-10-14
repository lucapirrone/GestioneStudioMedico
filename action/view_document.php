<?php

	require "lib/plugins/aws/vendor/autoload.php";
	use Aws\S3\S3Client;

    $array_info = [
        "id_fattura"
    ];

  	function checkValidate($array_info, $conn){
		
        $valido=true;
        for($i=0; $i<=count($array_info)-1; $i++){
            if(!isset($_GET[$array_info[$i]])){
                $valido = false;
                return $valido;
            }
        }
		
		//Questo script può essere eseguito soltanto da un amministratore
        if(login_check_admin($conn) == false){
            $valido = false;    
            error(400, null); 
            return $valido;       
        }		
		
		
		
        return $valido;
    }


    if(checkValidate($array_info, $conn)) { 

		$id_fattura = $_GET['id_fattura'];
		
		// Bucket Name
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

?>