<?php

	if(!(isset($paginaIntegra) && $paginaIntegra === true)) exit();
		

?>
	<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>


<form id="form_filtri" class="" action="" method="post">
	<ul>
		
		<h2 class="title testo-grande">Visualizza Fatture</h2>

	
		<?php 
		$action_token = $_SESSION['action_token'] = md5(uniqid(mt_rand(), true)); 

		
		$sm = new SearchMedico($conn);
		$medici = $sm->selezionaTutto();
		
		$sp = new SearchPrestazioni($conn);
		$prestazioni = $sp->selezionaTutto();		
		
		?>
		
		<li class="fill buttons" style="width: 10%;">
            <input id="id_filtra_fatture" class="button_text" type="button" value="Salva Prestazione" onclick="submitForm(this);"/>
        </li>
		
		<li class="fill" style="width: 15%;">
			<label class="description" for="element_1">Data Fine</label>
			<input type="date" class="form-control" id="input_data" name="data_fine" value="<?php echo date('Y-m-d'); ?>" step="1" required/>
			
		</li>
		<li class="fill" style="width: 15%;">
			<label class="description" for="element_1">Data Inizio</label>
			<input type="date" class="form-control" id="input_data" name="data_inizio" value="<?php echo date('Y-m-d'); ?>" step="1" required/>
			
		</li>		
		
		<input name="array_medici" id="array_medici" type="hidden"/>
		<input name="array_prestazioni" id="array_prestazioni" type="hidden"/>

		<li class="fill"style="width: 30%;">
			<fieldset>      
					<legend>Seleziona i medici</legend>          
					 <?php
						foreach($medici as $m){
							echo ' 
								<input type="checkbox" id="cb_medico" id_medico="'.$m['id'].'" onclick="onMediciSelection(this);">'.$m['nome'].'<br> 
							';
						}
					?>
			</fieldset>      
		</li>
		
		
		<li class="fill"style="width: 30%;">
			<fieldset>      
					<legend>Seleziona le prestazioni</legend>          
					 <?php
						foreach($prestazioni as $p){
							echo ' 
								<input type="checkbox" id="cb_prestazioni" id_prestazione="'.$p['id'].'" onclick="onPrestSelection(this);">'.$p['nome'].'<br> 
							';
						}
					?>
			</fieldset>      
		</li>

	</ul>

<script>

var list_medici = [];
var list_prestazioni = [];

function onPrestSelection(input){
	list_prestazioni.push($(input).attr('id_prestazione'));
}

function onMediciSelection(input){
	list_medici.push($(input).attr('id_medico'));
}

function submitForm(b){
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

		?>

