<?php

if(!(isset($paginaIntegra) && $paginaIntegra === true))
    exit();

?>
<?php

define('SITE_ROOT', realpath(dirname(__FILE__)));
$target_dir = SITE_ROOT . "/referti/";

function sec_session_start()
{
    $session_name = 'sec_session_id'; // Imposta un nome di sessione
    $secure       = false; // Imposta il parametro a true se vuoi usare il protocollo 'https'.
    $httponly     = true; // Questo impedirà ad un javascript di essere in grado di accedere all'id di sessione.
    ini_set('session.use_only_cookies', 1); // Forza la sessione ad utilizzare solo i cookie.
    $cookieParams = session_get_cookie_params(); // Legge i parametri correnti relativi ai cookie.
    session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly);
    session_name($session_name); // Imposta il nome di sessione con quello prescelto all'inizio della funzione.
    session_start(); // Avvia la sessione php.
    session_regenerate_id(); // Rigenera la sessione e cancella quella creata in precedenza.
}

function console_log($data)
{
    echo '<script>';
    echo 'console.log(' . json_encode($data) . ')';
    echo '</script>';
}

function get_client_ip()
{
    $ipaddress = '';
    if(getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

function logout($conn)
{
   log_admin_access($conn, "logout");
    
    $_SESSION = array();
    // Recupera i parametri di sessione.
    $params   = session_get_cookie_params();
    // Cancella i cookie attuali.
    setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
    // Cancella la sessione.
    session_unset();
    session_destroy();
}

function login_check_admin($mysqli)
{
    // Verifica che tutte le variabili di sessione siano impostate correttamente
    if(isset($_SESSION['id_utente'], $_SESSION['utente'], $_SESSION['login_string'])) {
        $login_string = $_SESSION['login_string'];
        $id_utente    = $_SESSION['id_utente'];
        $utente       = $_SESSION['utente'];
        $company_id   = $_SESSION['company_id'];
        $user_browser = $_SERVER['HTTP_USER_AGENT']; // reperisce la stringa 'user-agent' dell'utente.
        if($stmt = $mysqli->prepare("SELECT PASSWORD FROM ACL WHERE ID = ? and UTENTE = ? and KCO = ? LIMIT 1")) {
            $stmt->bind_param('isi', $id_utente, $utente, $company_id); // esegue il bind del parametro '$user_id'.
            $stmt->execute(); // Esegue la query creata.
            $stmt->store_result();
            
            if($stmt->num_rows == 1) { // se l'utente esiste
                $stmt->bind_result($password); // recupera le variabili dal risultato ottenuto.
                $stmt->fetch();
                $login_check = hash('sha512', $password . $user_browser);
                if($login_check == $login_string) {
                    // Login eseguito!!!!
                    return true;
                } else {
                    //  Login non eseguito
                    return false;
                }
            } else {
                // Login non eseguito
                return false;
            }
        } else {
            // Login non eseguito
            return false;
        }
    } else {
        // Login non eseguito
        return false;
    }
}

function checkbrute($user, $mysqli)
{
    // Recupero il timestamp
    $now            = time();
    // Vengono analizzati tutti i tentativi di login a partire dalle ultime due ore.
    $valid_attempts = $now - (2 * 60 * 60);
    if($stmt = $mysqli->prepare("SELECT time FROM LOGIN_ATTEMPS WHERE user = ? AND time > ? and unlocked = 0")) {
        $stmt->bind_param('ii', $user, $valid_attempts);
        // Eseguo la query creata.
        if($stmt->execute()) {
            $stmt->store_result();
            // Verifico l'esistenza di più di 5 tentativi di login falliti.
            if($stmt->num_rows > 5) {
                return true;
            } else {
                return false;
            }
        } else {
            echo mysqli_error($mysqli);
        }
    } else {
        echo mysqli_error($mysqli);
    }
}

function unlockBrute($id_utente, $conn)
{
    $time_now = time();
    if($stmt = $conn->prepare("UPDATE LOGIN_ATTEMPS SET unlocked = 1 where user = ? and time < ?")) {
        $stmt->bind_param('ii', $id_utente, $time_now); // esegue il bind del parametro '$email'.
        if($stmt->execute()) { // esegue la query appena creata.
            $stmt->store_result();
            $stmt->fetch();
            if($stmt->num_rows == 1) { // se il codice esiste
                return true;
            } else {
                return false;
            }
        } else {
            echo mysqli_error($mysqli);
            return false;
        }
    } else {
        echo mysqli_error($mysqli);
        return false;
    }
}


function error($code, $addmsg)
{
    
    global $errors;
    global $conn;
    
    $message = "Si e' verificato un errore sconosciuto";
    
    foreach($errors as $error) {
        if($error['code'] == $code)
            $message = $error['message'];
    }
    
    if($addmsg != null)
        $message = $message . ": " . $addmsg;
    
    $json_return = array(
        "code" => $code,
        "message" => $message
    );
	
	$query = "INSERT INTO LOG_ERROR_GENERAL (user_logged, code, error, admin) VALUES (?, ?, ?, ?)";
        
	$timestamp = time();
	$user_logged = $_SESSION['id_utente'];

	if($ins_log = $conn->prepare($query)) {
		$ins_log->bind_param("iisi", $user_logged, $code, $message, $_SESSION['type']);

		if($ins_log->execute()) {
			$ins_log->close();
		}
	}

    echo json_encode($json_return);
    die();
}



function success()
{
    
    $json_return = array(
        "code" => 200,
        "message" => "Operazione avvenuta con successo"
    );
    
    echo json_encode($json_return);
    die();
}

function log_admin_action($conn, $action, $user)
{
    
    if(isset($_SESSION['id_utente'])) {
        
        $query = "INSERT INTO LOG_ADMIN_ACTION (timestamp, utente, action, user) VALUES (?, ?, ?, ?)";
        
        $timestamp = time();
        $id_utente = $_SESSION['utente'];
        
        if($ins_log = $conn->prepare($query)) {
            $ins_log->bind_param("siss", $timestamp, $id_utente, $action, $user);
            
            if($ins_log->execute()) {
                $ins_log->close();
            } else {
                error(502, mysqli_error($conn));
            }
            
        } else {
            error(502, mysqli_error($conn));
        }
        
    }
    
}

function log_admin_access($conn, $type)
{
    
    if(isset($_SESSION['id_utente'])) {
        
        $query = "INSERT INTO LOG_ADMIN_ACCESS (utente, timestamp, type) VALUES (?, ?, ?)";
        
        $timestamp = time();
        $id_utente = $_SESSION['id_utente'];
        
        if($ins_log = $conn->prepare($query)) {
            $ins_log->bind_param("iss", $id_utente, $timestamp, $type);
            
            if($ins_log->execute()) {
                $ins_log->close();
            } else {
                error(502, mysqli_error($conn));
            }
            
        } else {
            error(502, mysqli_error($conn));
        }
        
    }
}


function createInputToken()
{
    
    if(!isset($_SESSION['token']) || !isset($token))	$token = $_SESSION['token'] = md5(uniqid(mt_rand(), true));
    
    echo '<input type="hidden" name="token" value="' . $token . '"/>';
}

function createRequestToken()
{
    
    if(!isset($_SESSION['action_token']) || !isset($action_token))	$action_token = $_SESSION['action_token'] = md5(uniqid(mt_rand(), true));
    
    echo '<input type="hidden" name="action_token" value="' . $action_token . '"/>';
}

function checkToken()
{
	if(isset($_SESSION['token'])){
		if(isset($_POST['token']))
    	if($_POST['token'] === $_SESSION['token']){
			return true;
		}
		
		if(isset($_GET['token']))
    	if($_GET['token'] === $_SESSION['token']){
			return true;
		}
	}if(isset($_SESSION['action_token'])){
		if(isset($_POST['action_token']))
		if($_POST['action_token'] === $_SESSION['action_token']){
			return true;
		} 
		
		
		if(isset($_GET['action_token']))
		if($_GET['action_token'] === $_SESSION['action_token']){
			return true;
		}
	}else{
		return false;
	}
}

?>