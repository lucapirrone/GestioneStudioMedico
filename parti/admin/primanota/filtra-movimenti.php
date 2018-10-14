<?php

	if(!(isset($paginaIntegra) && $paginaIntegra === true)) exit();
		

?>

<?php
	date_default_timezone_set('EUROPE/ROME');
 	$data_inizio = "";
	$data_fine = "";
	$startDay = "";
	$endDay = "";

	$spn = new SearchPrimaNota($conn);
	if(isset($_POST['data_inizio'],$_POST['data_fine']) || isset($_POST['filter_day'])){


		if(isset($_POST['filter_day']) && $_POST['filter_day']!=""){
			if($_POST['filter_day']==="today"){
				$startDay = strtotime("midnight", time());
				$endDay  = strtotime("tomorrow", $startDay) - 1;
			}else if($_POST['filter_day']==="yesterday"){
				$startDay = strtotime("midnight", strtotime("-1 day", time()));
				$endDay  = strtotime("tomorrow", $startDay) - 1;
			}
		}else{
			if(isset($_POST['data_inizio']))
				$startDay = strtotime("midnight", strtotime($_POST['data_inizio']));
			if(isset($_POST['data_fine']))
				$endDay  = strtotime("tomorrow", strtotime($_POST['data_fine'])) - 1;
		}
		
		$data_fine = $endDay;
		$data_inizio = $startDay;
				
			
		$spn->filtraMovimenti($data_inizio, $data_fine);
	
	}
	
?>


<h2 class="title">Filtra Movimenti</h2>

<form id="form_filtri" class="section" action="" method="post">
	<ul>
		
		<?php 
		if(!isset($_SESSION['action_token']) || !isset($action_token))	$action_token = $_SESSION['action_token'] = md5(uniqid(mt_rand(), true)); 		
		?>
		<li style="float: left; padding-top: 40px; text-align: center;">
            <button id="id_filtra_fatture" class="btn btn-light" onclick="submitForm('yesterday');">Ieri</button>
        </li>
		
		<li style="float: left; padding-top: 40px; text-align: center;">
            <button id="id_filtra_fatture" class="btn btn-light" onclick="submitForm('today');">Oggi</button>
        </li>
		
		<input id="filter_day" name="filter_day" type="hidden"/>
		
		<?php
		if($data_inizio!="")	$data_inizio_v = date("Y-m-d", $data_inizio);
		else	$data_inizio_v = date("Y-m-d", time());
		if($data_fine!="")	$data_fine_v = date("Y-m-d", $data_fine);
		else	$data_fine_v = date("Y-m-d", time());
		?>
		<li class="fill" style="width: 15%;">
			<legend>Data Inizio</legend>
			<input type="date" class="form-control" id="data_inizio" name="data_inizio" value="<?php echo $data_inizio_v ?>" step="1" required/>
			
		</li>
				
		<li class="fill" style="width: 15%;">
			<legend>Data Fine</legend>
			<input type="date" class="form-control" id="data_fine" name="data_fine" value="<?php echo $data_fine_v ?>" step="1" required/>
			
		</li>	
		
		<li class="fill" style="width: 10%; padding-top: 40px; text-align: center;">
            <button id="id_filtra_fatture" class="btn btn-light"><i class="fa fa-bolt fa-fw"></i>Filtra</button>
        </li>
		
		<li class="fill" style="width: 10%; padding-top: 40px; text-align: center;">
            <button type="button" id="stampa_movimenti" onClick="printPrimaNota()" class="btn btn-light"><i class="fa fa-print"></i>Stampa</button>
        </li>
		

	</ul>
	
</form>

<?php

	
		echo '		
		<div class="panel panel-default" style="margin-top: 20px;">
		<div class="panel-heading">
			Lista Movimenti
		</div>
		<div class="panel-body">
		'; 
		
		$spn->buildTable();
		echo '</div>';
		echo '</div>';

?>


<script>
	<?php if(!isset($_SESSION['action_token']) || !isset($action_token))	$action_token = $_SESSION['action_token'] = md5(uniqid(mt_rand(), true)); ?>
	
	function printPrimaNota(){
		window.location.replace("?action=request&action_code=2&action_token=<?php echo $action_token; ?>&data_inizio="+$("#data_inizio").val()+"&data_fine="+$("#data_fine").val());
	};

	function submitForm(day){
		$('#filter_day').val(day);
		$('#form_filtri').submit;
	}

	function editMov(id){
		window.location.replace("?page=modifica-movimento&id_movimento="+id);
	}

</script>
	