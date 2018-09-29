<?php
/*

  Connessione al DBMS e selezione del dataabse.

*/

# blocco dei parametri di connessione

// nome di host

$host = "gestionestudiomedico.c50low5ifooj.us-east-2.rds.amazonaws.com:3306";

// username dell'utente in connessione

$user = "gestionestudio";

// password dell'utente

$password = "Cisco,123";

// nome del database

$db = "gsmdb";

$conn = mysqli_connect($host, $user ,$password,$db);

if (mysqli_connect_errno())
{
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
	exit;
}

?>