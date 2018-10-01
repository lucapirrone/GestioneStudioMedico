<?php

	if(!(isset($paginaIntegra) && $paginaIntegra === true)) exit();
		

?>

<h2 class="title">Visualizza Fatture</h2>

	
<?php
	
	require 'parti/admin/fatturazione/includes/filtra-fatture.php';
	
 
	$array_medici = "";
	$array_prestazioni = "";
	$data_inizio = "";
	$data_fine = "";

	if(isset($_POST['array_medici'],$_POST['array_prestazioni'],$_POST['data_inizio'],$_POST['data_fine'])){

		if(isset($_POST['array_medici']))
			$array_medici = $_POST['array_medici'];
		if(isset($_POST['array_prestazioni']))
			$array_prestazioni = $_POST['array_prestazioni'];
		if(isset($_POST['data_inizio']))
			$data_inizio = $_POST['data_inizio'];
		if(isset($_POST['data_fine']))
			$data_fine = $_POST['data_fine'];

		$sf = new SearchFatture($conn);
		$sf->filtraFatture($array_medici, $array_prestazioni, $data_inizio, $data_fine);
		
		echo '		
		<div class="panel panel-default" style="margin-top: 20px;">
		<div class="panel-heading">
			Lista Fatture
		</div>
		<div class="panel-body">

		
		'; 
		
		$sf->buildTable();
		echo '</div>';
		echo '</div>';

	}
	
?>

