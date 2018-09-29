<?php

	//Imposta la variabile di controllo di integrità della pagina, cosicchè ogni script incluso non può essere raggiunto direttamente
	$paginaIntegra = true;
    $site_key = "6LcOYWoUAAAAAJ4uMtIKcT7uGWm7F99O7qv2EMmI";
    $secret_key = "6LcOYWoUAAAAAFaQDtl-ELfTUCXiHvN1fivKOFmk";

	require 'lib/head.php';
    require 'lib/recaptchalib.php';


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

	$errors = array(
		array(
			"code"=>0,
			"message"=>"Utente o password errati"
		),
		array(
			"code"=>1,
			"message"=>"Si è riscontrato un errore nel server"
		),
		array(
			"code"=>2,
			"message"=>"L'account è stato disabilitato"
		),
		array(
			"code"=>3,
			"message"=>"ReCaptcha non valido"
		)
	);

	$msg_error = null;

	if(login_check_admin($conn)){
		header('Location: /');
	}

	
	if(isset($_POST['utente'], $_POST['p'], $_SESSION['tenant_login'])) { 
		if(checkReCaptcha()===true || 1){
			if(checkToken()===false){
				echo "TOKEN NON VALIDO";
				exit();
			}

		   $utente = strtoupper($_POST['utente']);
		   $codicestudio = strtoupper($_SESSION['tenant_login']);
		   $password = $_POST['p']; // Recupero la password criptata.

		   $checklogin = login($utente, $password, $codicestudio, $conn);
		   if($checklogin == 100) {
			  // Login eseguito
			  log_admin_action($conn, "login", null);
			  log_admin_access($conn, "login");
			  header('Location: /');

		   } else {
			   $error_code = $checklogin;
		   }
		}else{
			$error_code = 3;
		}
	}
	
	

	if(isset($error_code)){
		foreach($errors as $error){
			if($error['code']==$error_code)	$msg_error = $error['message'];
		}
	} 

	function login($utente, $password, $codicestudio, $mysqli) {
		//Lettura dell'id della compagnia dato il codicestudio
		if ($stmt = $mysqli->prepare("SELECT ID FROM COMPANY WHERE ID = ? LIMIT 1")) { 
		 $stmt->bind_param('i', $codicestudio); // esegue il bind del parametro '$email'.
		 if($stmt->execute()){ // esegue la query appena creata.
			 $stmt->store_result();
			 $stmt->bind_result($company_id); // recupera il risultato della query e lo memorizza nelle relative variabili.
			 $stmt->fetch();
		 }else{
			 echo mysqli_error($mysqli);
		 }
		}else{
			 echo mysqli_error($mysqli);
		 }
				
	  // Usando statement sql 'prepared' non sarà possibile attuare un attacco di tipo SQL injection.
	  if (isset($company_id) && $stmt = $mysqli->prepare("SELECT ID, UTENTE, PASSWORD, SALT, KCO FROM ACL WHERE UTENTE = ? and KCO = ? LIMIT 1")) { 
		 $stmt->bind_param('ss', $utente, $company_id); // esegue il bind del parametro '$email'.
		 if($stmt->execute()){ // esegue la query appena creata.
			 $stmt->store_result();
			 $stmt->bind_result($id_utente, $utente, $db_password, $salt, $company_id); // recupera il risultato della query e lo memorizza nelle relative variabili.
			 $stmt->fetch();
			 $password = strtoupper($password);
			 $password = strtoupper(hash('sha512', $password.$salt)); // codifica la password usando una chiave univoca.
			 if($stmt->num_rows == 1) { // se l'codicefiscale esiste
				// verifichiamo che non sia disabilitato in seguito all'esecuzione di troppi tentativi di accesso errati.
										
				if($db_password == $password) { // Verifica che la password memorizzata nel database corrisponda alla password fornita dall'codicefiscale.
				   // Password corretta!            
					  $user_browser = $_SERVER['HTTP_USER_AGENT']; // Recupero il parametro 'user-agent' relativo all'codicefiscale corrente.

					  $utente = preg_replace("/[^a-zA-Z0-9_\-.]+/", "", $utente); // ci proteggiamo da un attacco XSS
					  $_SESSION['id_utente'] = $id_utente;
					  $_SESSION['utente'] = $utente;
					  $_SESSION['login_string'] = hash('sha512', $password.$user_browser);
					  $_SESSION['company_id'] = $company_id;
					  $_SESSION['company_name'] = $codicestudio;
					  //unlockBrute($id_utente, $mysqli);
					  // Login eseguito con successo.
					  return 100;    
				} else {
				   // Password incorretta.
				   // Registriamo il tentativo fallito nel database.
				   $now = time();
				   $ip = get_client_ip();
				   if($mysqli->query("INSERT INTO LOGIN_ATTEMPS (user, time, ipaddress) VALUES ('$id_utente', '$now', '$ip')")){
						return 0;
				   }else{
						echo mysqli_error($mysqli);
						return 0;
					}
				}


			 } else {
				// L'UTENTE inserito non esiste.
				return 0;
			 }
		 }else{
		   return 1;
		 }
	  }else{
		  echo mysqli_error($mysqli);
		  return 0;
	  }

	}

if(!isset($_GET['codicestudiomedico'])){
	die();
}

$_SESSION['tenant_login'] = $_GET['codicestudiomedico'];

?>
<!DOCTYPE html>
<html lang="it">

<head>
	<script src='https://www.google.com/recaptcha/api.js'></script>
	
	<meta charset="UTF-8">
	<title>Referto in Cloud - Login al Servizio</title>

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">

	<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900'>
	<link rel='stylesheet' href='https://fonts.googleapis.com/icon?family=Material+Icons'>

	<link rel="stylesheet" href="css/loginpage_style.css">
</head>

<body>

<form id="signin" action="" method="post">
	<div class="form-title">Accedi al servizio</div>

	<!-- EMAIL -->
	<div class="input-field">
		<input name="utente" type="utente" id="utente"/>
		<i class="material-icons">email</i>
		<label for="utente">Utente Amministratore</label>
	</div>

	<!-- TOKEN -->
	<?php createInputToken(); ?>
	
	<!-- PASSWORD -->
	<div class="input-field">
		<input name="password" type="password" id="password"/>
		<i class="material-icons">lock</i>
		<label for="password">Password</label>
	</div>
	
	<!-- CAPTCHA -->
	<div class="input-field" style="width: 100%; text-align: center; height: auto; display: none">
		<div class="g-recaptcha" style="display: inline-block;" data-sitekey="<?php echo $site_key; ?>"></div>
	</div>
	
	<!-- ERRORE -->
	<div class="input-field" style="width: 100%; text-align: center; height: auto;">
		<p style="color: red; font-weight: bold"><?php echo($msg_error) ?></p>
	</div>
	
	<!-- BUTTON -->
	<button class="login" onclick="formhash(this.form,this.form.password);">Login</button>
	<div class="check">
		<i class="material-icons">check</i>
	</div>
</form>
<div class="left" id="left">
	<ul class="radio">
		<li class="logininfo">Accedi Ora al servizio Referto Online</li>
		<li class="logininfo">Questa piattaforma ti consente di scaricare i referti gratuitamente</li>
		<li class="logininfo">Il servizio è disponibile da qualunque dispositivo connesso alla rete internet</li>
		<li class="logininfo">Accedi con il tuo Codice Fiscale e la Password che ti è stata fornita</li>
	</ul>
</div>
<script src='https://code.jquery.com/jquery-2.2.4.min.js'></script>

<script  src="js/loginpage_script.js"></script>

<?php include("parti/js_includes.php"); ?>
</body>

</html>
