<?php

	if(!(isset($paginaIntegra) && $paginaIntegra === true)) exit();
		

?>

<h2 class="title">Visualizza Fatture</h2>

<form id="form_filtri" class="section" action="" method="post">
	<ul>
		
		<?php 
		$action_token = $_SESSION['action_token'] = md5(uniqid(mt_rand(), true)); 		
		?>
		<li style="float: left; padding-top: 60px; text-align: center;">
            <button id="id_filtra_fatture" class="btn btn-light" onclick="submitForm('yesterday');">Ieri</button>
        </li>
		
		<li style="float: left; padding-top: 60px; text-align: center;">
            <button id="id_filtra_fatture" class="btn btn-light" onclick="submitForm('today');">Oggi</button>
        </li>
		
		<input id="filter_day" name="filter_day" type="hidden"/>
		
		<li class="fill" style="width: 15%;">
			<legend>Data Inizio</legend>
			<input type="date" class="form-control" id="input_data" name="data_inizio" value="<?php echo date('Y-m-d'); ?>" step="1" required/>
			
		</li>
				
		<li class="fill" style="width: 15%;">
			<legend>Data Fine</legend>
			<input type="date" class="form-control" id="input_data" name="data_fine" value="<?php echo date('Y-m-d'); ?>" step="1" required/>
			
		</li>	
		
		<li class="fill" style="width: 10%; padding-top: 60px; text-align: center;">
            <button id="id_filtra_fatture" class="btn btn-light"><i class="fa fa-bolt fa-fw"></i>Filtra</button>
        </li>
		

	</ul>
	
</form>


<script>

	function submitForm(day){
		$('#filter_day').val(day);
		$('#form_filtri').submit;
	}

</script>
	
<?php
	date_default_timezone_set('EUROPE/ROME');
 	$data_inizio = "";
	$data_fine = "";
	$startDay = "";
	$endDay = "";

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
				
		$spn = new SearchPrimaNota($conn);
		$spn->filtraMovimenti($data_inizio, $data_fine);
		
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

	}
	
?>

