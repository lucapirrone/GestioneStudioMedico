<?php

	if(!(isset($paginaIntegra) && $paginaIntegra === true)) exit();
		

?>
	<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

<h2 class="title testo-grande">Visualizza Fatture</h2>

<form id="form_filtri" action="" method="post">
	<ul>
		

	
		<?php 
		$action_token = $_SESSION['action_token'] = md5(uniqid(mt_rand(), true)); 

		
		$sm = new SearchMedico($conn);
		$medici = $sm->selezionaTutto();
		
		$sp = new SearchPrestazioni($conn);
		$prestazioni = $sp->selezionaTutto();		
		
		?>
		
		<li class="fill buttons" style="width: 10%;">
            <input id="id_filtra_fatture" class="btn btn-light" type="button" value="Cerca" onclick="submitForm();"/>
        </li>
		
		<li class="fill" style="width: 15%;">
			<legend>Data Fine</legend>
			<input type="date" class="form-control" id="input_data" name="data_fine" value="<?php echo date('Y-m-d'); ?>" step="1" required/>
			
		</li>
		<li class="fill" style="width: 15%;">
			<legend>Data Inizio</legend>
			<input type="date" class="form-control" id="input_data" name="data_inizio" value="<?php echo date('Y-m-d'); ?>" step="1" required/>
			
		</li>		
		
		<input name="array_medici" id="array_medici" type="hidden"/>
		<input name="array_prestazioni" id="array_prestazioni" type="hidden"/>

		<li class="fill"style="width: 30%;">
			<legend>Seleziona i medici</legend>
			<select id="select_medico" multiple style="width: 100%;">      
  				
			</select> 
		</li>
		<li class="fill"style="width: 30%;">
			<legend>Seleziona le prestazioni</legend>          
			<select id="select_prestazione" multiple style="width: 100%;">      

			</select>    
		</li>

	</ul>

<script>

	var list_medici = [];
	var list_prestazioni = [];

	<?php



	$build_medici = array();
	foreach($medici as $m){
		$build_medici[] = array(
			"id"=>$m['id'],
			"text"=>$m['nome']
		);  
	}
	
	
	$arr_medici[] = array(
		"text"=>"Medici",
		"children"=>$build_medici
	);

	$build_prestazioni = array();
	foreach($prestazioni as $p){
		$build_prestazioni[] = array(
			"id"=>$p['id'],
			"text"=>$p['nome']
		);  
	}
	
	
	$arr_prestazioni[] = array(
		"text"=>"Prestazioni",
		"children"=>$build_prestazioni
	);

	echo "var arr_medici=".json_encode($arr_medici).";";
	echo "var arr_prestazioni=".json_encode($arr_prestazioni).";";


	?>

		
	function formatResult(item) {
		if(!item.id) {
		   return item.text;
		}
		// return item template
		return '<i style="color:#ff0000">' + item.text + '</i>';
	}

	function formatSelection(item) {
		// return selection template
		return '<b>' + item.text + '</b>';
	}
	$('#select_medico').select2({
		data: arr_medici,			
		// Specify format function for dropdown item
		formatResult: formatResult,
		// Specify format function for selected item
		formatSelection: formatSelection,
	});
		
	$('#select_medico').change(function() {
		//var theID = $(test).val(); // works
		//var theSelection = $(test).filter(':selected').text(); // doesn't work
		var items = $('#select_medico').select2('data');
		list_medici=[];
		items.forEach(function(item){
			list_medici.push(item.id);
		});
	});
	
	$('#select_prestazione').select2({
		data: arr_prestazioni,			
		// Specify format function for dropdown item
		formatResult: formatResult,
		// Specify format function for selected item
		formatSelection: formatSelection,
	});
		
	$('#select_prestazione').change(function() {
		//var theID = $(test).val(); // works
		//var theSelection = $(test).filter(':selected').text(); // doesn't work
		var items = $('#select_prestazione').select2('data');
		arr_prestazioni=[];
		items.forEach(function(item){
			arr_prestazioni.push(item.id);
		});
	});

	

	function submitForm(){
		console.log(list_medici);
		console.log(list_prestazioni);
		$('#array_medici').val(list_medici);
		$('#array_prestazioni').val(list_prestazioni);

		$('#form_filtri').submit();

	}
	
</script>
	
<?php
 
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
		$sf->buildTable();

	}
	
?>

