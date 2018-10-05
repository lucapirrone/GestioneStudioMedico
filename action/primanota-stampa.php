<?php
	include("parti/css_includes.php");
	include("parti/js_includes.php");
		
	if(!(isset($paginaIntegra) && $paginaIntegra === true)) exit();
?>

<h2 class="title">Prima Nota dal <?php echo $_GET['data_inizio']; ?> al <?php echo $_GET['data_fine']; ?></h2>


<?php
	date_default_timezone_set('EUROPE/ROME');
 	$data_inizio = "";
	$data_fine = "";
	$startDay = "";
	$endDay = "";

	if(isset($_GET['data_inizio'],$_GET['data_fine']) || isset($_GET['filter_day'])){


		if(isset($_GET['filter_day']) && $_GET['filter_day']!=""){
			if($_GET['filter_day']==="today"){
				$startDay = strtotime("midnight", time());
				$endDay  = strtotime("tomorrow", $startDay) - 1;
			}else if($_GET['filter_day']==="yesterday"){
				$startDay = strtotime("midnight", strtotime("-1 day", time()));
				$endDay  = strtotime("tomorrow", $startDay) - 1;
			}
		}else{
			if(isset($_GET['data_inizio']))
				$startDay = strtotime("midnight", strtotime($_GET['data_inizio']));
			if(isset($_GET['data_fine']))
				$endDay  = strtotime("tomorrow", strtotime($_GET['data_fine'])) - 1;
		}
		
		$data_fine = $endDay;
		$data_inizio = $startDay;
				
		$spn = new SearchPrimaNota($conn);
		$spn->filtraMovimenti($data_inizio, $data_fine);
		
		echo '		
		'; 
		
		$spn->buildTableForPrint();

	}
	
?>

