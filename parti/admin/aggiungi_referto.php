<?php


	//------- EMAIL CONFIG LIB

	
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	//Load Composer's autoloader
	require 'lib/plugins/aws/phpmailer/src/Exception.php';
	require 'lib/plugins/aws/phpmailer/src/PHPMailer.php';
	require 'lib/plugins/aws/phpmailer/src/SMTP.php';


	//------- END EMAIL CONFIG LIB

	define('KB', 1024);
	define('MB', 1048576);
	define('GB', 1073741824);
	define('TB', 1099511627776);

	//require ('lib/plugins/aws/aws-autoloader.php');
	//require_once('lib/plugins/aws/S3.php');

	
	/*use Aws\S3\S3Client;
	use Aws\S3\Exception\S3Exception;*/

	if(!(isset($paginaIntegra) && $paginaIntegra === true)) exit();

?>
<?php

//Questa pagina permette di aggiungere un referto associato ad un paziente identificato tramite codice fiscale. Al click del bottone per aggiungere, si controlla la validità dei dati inseriti (nome, file, tipo...) e si inviano allo script aggiungireferto.php




require 'lib/recaptchalib.php';
$site_key = "6LdAImwUAAAAAJDz4q9hOlwn__aokU4ZGAITD9Vw";
$secret_key = "6LdAImwUAAAAAGjbUeh-In56bGbHRGNqck9QWSrN";

$target_dir;
$target_file;
$target_path;
$temp_file;


//Dopo la richiesta a se stessa controlla i vari parametri
if(isset($_POST['id'], $_POST['codicefiscale'], $_POST['submit'], $_POST['token']) && checkValidate() && checkFileValidate()) {
	if(checkReCaptcha()===true){
		
		if(checkToken() === false){
			echo "TOKEN NON VALIDO";
			exit();
		}

		$id = $_POST['id'];
		$codicefiscale = $_POST['codicefiscale'];


		// Bucket Name
		$bucket = 's3-bucket-refertionline';

		//AWS access info
		$awsAccessKey = 'AKIAJY2VGBZWME56NULA';
		$awsSecretKey = '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';

		
		//instantiate the class
		/*$s3 = S3Client::factory(
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
		);*/


		try{

			
			/*$s3->putObject(
				array(
					'Bucket'=>$bucket,
					'Key' =>  $target_path,
					'SourceFile' => $temp_file,
					'StorageClass' => 'STANDARD'
				)
			);*/

			$scadenza = time()+3888000;
			
			if (!file_exists($target_dir)) {
				mkdir($target_dir, 0777, true);
			}
			
			if(move_uploaded_file($temp_file, $target_path)){
				if($insert_stmt = $conn->prepare("UPDATE referti SET filepdf = '$target_path',  datapubblicazione = ".time().", `datascadenza` = '$scadenza' where id = '$id'")){


					if($insert_stmt->execute()){
						log_admin_action($conn, "referto caricato", $id);
						saveReportUpload($conn, $id);
						
						echo '<script>alert("Caricamento referto completato");';
						
						if ($tmp_fetch = $conn->prepare("SELECT codicefiscale FROM referti where id = ?")) { 
							$tmp_fetch->bind_param('i', $id); 
							if($tmp_fetch->execute()){
								if(!$tmp_fetch->store_result()) echo mysqli_error($conn);
								if ($tmp_fetch->num_rows >= 1) { //Uses the stored result and counts the rows.
									if(!$tmp_fetch->bind_result($codicefiscale)) echo mysqli_error($conn);
									while($tmp_fetch->fetch()){
						
										if ($tmp_fetch = $conn->prepare("SELECT email FROM utenti where codicefiscale = ?")) { 
											$tmp_fetch->bind_param('s', $codicefiscale); 
											if($tmp_fetch->execute()){
												if(!$tmp_fetch->store_result()) echo mysqli_error($conn);
												if ($tmp_fetch->num_rows >= 1) { //Uses the stored result and counts the rows.
													if(!$tmp_fetch->bind_result($email)) echo mysqli_error($conn);
													while($tmp_fetch->fetch()){
														
														sendEmail($email, $codicefiscale, $scadenza);
														
													}
												}
											}
										}
									}
								}
							}
						}
						
						echo 'window.location.replace("?page=gestisci-paziente&codicefiscale='.$_GET['codicefiscale'].'&code=listareferti");</script>';

						
						die();
					}


				}else{
					//_errore db
					_error(403, mysqli_error($conn));
				}
			}else{
				_error(405, "Impossibile salvare il file");
			}

		}catch(Exception $e){
			console_log($e->getMessage());
			_error(405, "Impossibile caricare il file: ".$e->getMessage());
		}
	}else{
		_error(409, "ReCaptcha non valido!");
	}

}



/* ---------------------------------------------------------------------------------------------- */



if(checkValidate()) { 
	$codicefiscale = $_GET['codicefiscale'];
	$id = $_GET['id'];
	
	if ($stmt = $conn->prepare("SELECT data, tipo, note FROM referti WHERE `codicefiscale` = ? AND id=? and company_id = ? and filepdf is null LIMIT 1")) { 
		$stmt->bind_param('sii', $codicefiscale, $id, $GLOBALS['company_id']); // esegue il bind del parametro '$email'.
		if($stmt->execute()){ 
			$stmt->store_result();
			$stmt->bind_result($data, $tipo, $note);
			$stmt->fetch();
			if($stmt->num_rows<1){
				echo "<script>alert('Referto già aggiunto.'); window.history.go(-1);</script>";
				die();
			}
		}else{
			die();
		}
	}else{
		
		die();
	}
	
}else{
	die();
}




?>
<script src='https://www.google.com/recaptcha/api.js'></script>

<form id="form_aggiungipratica" class="form-style-7" action="" method="post" enctype="multipart/form-data">
	<div class="form_description">
	 	<h2>Carica Referto</h2>
        </div>
	<ul>
		
		<?php createInputToken(); ?>

		 <li class="left">
			   <label class="description" for="element_1">ID Referto</label>
			   <input type="text" name="id"class="form-control" maxlength="100" value="<?php echo $id; ?>" readonly/> 
			   <span>ID Referto</span>         
		 </li>

		 <li class="right fb-autocomplete form-group field-nome">
			   <label class="description" for="element_1">Codice Fiscale Paziente</label>
			   <input type="text" name="codicefiscale" id="input_nome" class="form-control" maxlength="100" value="<?php echo $codicefiscale; ?>" readonly/> 
			   <span>Codice Fiscale Paziente</span>         
		 </li>

		 <li class="right">
			   <label class="description" for="element_1">Aggiungi File <a style="color: red;">*</a></label>
			   <input type="file" name="file" class="form-control" id="uploadfile">
			   <span>Inserisci il file pdf</span>         
		 </li>
		<li class="left">
			   <label class="description" for="element_1">Data Visita</label>
			   <input type="date" name="data" class="form-control" id="input_data" value="<?php echo date('Y-m-d', $data); ?>" readonly/>
			   <span>Data Visita</span>         
		 </li>
		<li class="left">
		   <label class="description">Tipo di Visita</label>
		   <select class="element select medium" name="tipo" id="tiporeferto">
			<option value="<?php echo $tipo; ?>"><?php echo $tipo; ?></option>';
		   </select>
			<span>Tipo di Visita</span>

	   </li>

		<li class="right">
			   <label class="description" for="element_1">Note</label>
			   <textarea type="text" class="form-control" id="input_note"  readonly><?php echo $note; ?></textarea>
			   <span>Note</span>         
		 </li>
		
		<li class="fill hidden">
			<div class="g-recaptcha" data-sitekey="<?php echo $site_key; ?>"></div>
		</li>
		
		 <li class="buttons">
			<input id="saveForm" class="button_text" type="submit" name="submit" value="Aggiungi Referto" />
		 </li>
		
	</ul>
		
</form> 



<?php

function checkReCaptcha(){

	global $secret_key;

	$response = null;

	$reCaptcha = new ReCaptcha($secret_key);

	if ($_POST["g-recaptcha-response"]) {
		$response = $reCaptcha->verifyResponse(
			$_SERVER["REMOTE_ADDR"],
			$_POST["g-recaptcha-response"]
		);
		if ($response != null && $response->success) return true;
		else return false;
	}
}

function checkFileValidate(){
	global $conn;
	
	$valido = true;
	
	//Passaggio del file
	if(!(!empty($_FILES["file"])) && ($_FILES['file']['error'] == 0)){
		$valido = false;
		_error(406, $_FILES['file']['error']);
		return $valido;
	}
	
	//Dimensione file
	if($_FILES["file"]["size"] > 1*GB){
		$valido = false;
		_error(406, mysqli_error($conn));
	}
	
	global $target_dir;
	global $target_file;
	global $target_path;
	global $temp_file;
	
	
	$codicefiscale = $_POST['codicefiscale'];
	$target_dir = "../../uploads/"  .  "referti/".$_SESSION['company_id']."/".$codicefiscale."/";
	$target_file = basename($_FILES["file"]["name"]);
	$target_path = $target_dir.$target_file;						 
	$temp_file = $_FILES['file']['tmp_name'];
	
	if (file_exists($target_path)) {
    	$valido = false;
		_error(406, "File già esistente");
		return $valido;
	}
	
	//Controllo estensione
	$estenzioni = ["png", "PNG", "jpg", "JPG", "pdf", "PDF"];
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

	$checkExt = false;
	foreach($estenzioni as $item){
		if($imageFileType==$item){ 
			$checkExt = true;
		}
	}


	if(!$checkExt){	//Controllo estensioni
		$valido = false;
		_error(407, mysqli_error($conn));
	}
	
	return $valido;
	
}


function _error($code, $addmsg){
	global $errors;

	$message="Si e' verificato un errore sconosciuto";

	foreach($errors as $error){
		if($error['code']==$code)
			$message = $error['message'];
	}

	if($addmsg!=null)	$message = $message.": ".$addmsg;

	echo '<script>alert("'.$message.'");</script>';
}

$array_info = [
	"codicefiscale",
	"id"
];


function checkValidate(){
	
	global $array_info;
	global $conn;
	
	$valido=true;

	//Controllo che tutti i parametri passati via post siano validi
	for($i=0; $i<=count($array_info)-1; $i++){
		if(!isset($_GET[$array_info[$i]])){
			$valido = false;
			_error(402, null);
			return $valido;
		}
	}

	//Controlla che la sessione è loggata e che è di tipo AMMINISTRATORE
	if(login_check_admin($conn) == false || $_SESSION['type']==0){
		$valido = false;    
      	header('Location: login_admin.php');
		return $valido;       
	}
	

	return $valido;

}




// INVIO EMAIL DI NOTIFICA
function sendEmail($email, $codicefiscale, $scadenza){
	
	$mail = new PHPMailer;
	$mail->isSMTP();

	$mail->setFrom('no-reply@refertoincloud.it', 'Referto in Cloud');
	$mail->addAddress($email, $codicefiscale);

	$mail->Username = 'AKIAJ7KSXZUKBDEGFDTA';
	$mail->Password = 'At6G0c8ri7UTMxe7R7A4naRJhSJwuFSSsZe3eq1GkUCE';

	$mail->Host = 'email-smtp.eu-west-1.amazonaws.com';

	$mail->Subject = 'Il tuo esito &#232; pronto!';
	
	$body = file_get_contents("http://18.223.228.50/email/email-referto-pronto.php");
	
	$body = str_replace("{CODICEFISCALE}", $codicefiscale, $body);
	$body = str_replace("{SCADENZA}", date('d/m/Y', $scadenza), $body);
	
	$mail->Body = $body;

	$mail->SMTPAuth = true;
	$mail->SMTPSecure = 'tls';
	$mail->Port = 587;
	$mail->isHTML(true);
	$mail->AltBody = 'Il tuo esito è pronto!\r\Il tuo esito è stato appena caricato online! Collegati ora a <a href="https://18.223.228.50/">Referto in Cloud</a>, esegui l\'accesso tramite il tuo codice fiscale e la password che ti è stata fornita in fase di accettazione ed scarica il tuo referto.';

	$mail->send();

}

?>