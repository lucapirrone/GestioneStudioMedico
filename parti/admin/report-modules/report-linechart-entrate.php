<?php 
	$importi = array();


	$times  = array();
	for($month = 1; $month <= 12; $month++) {
		$timestamp_from = mktime(0, 0, 0, $month, 1);
		$timestamp_to = mktime(23, 59, 59, $month, date('t', $timestamp_from));


		if ($fetchall_report = $conn->prepare("SELECT SUM(IMPORTO) FROM FATTURE WHERE DATA > ? AND DATA < ?")) { 
			$fetchall_report->bind_param('ss', $timestamp_from, $timestamp_to); 

			if($fetchall_report->execute()){ 
				$fetchall_report->store_result();
				$fetchall_report->bind_result($importo);
				$fetchall_report->fetch();
				if($importo == null) $importo = 0;
				array_push($importi, $importo);
			}else{
				echo mysqli_error($conn);
			}
		}else{
			echo mysqli_error($conn);
		}
	
	}

?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.js"></script>
<div class="container-table100 section">
	
	<canvas id="report-entrate" width="800" height="450"></canvas>
	
</div>


<script>

var labels = ['Gen', 'Feb', 'Mar', 'Apr', 'Mag', 'Giu', 'Lug', 'Aug', 'Sep', 'Oct', 'Nov', 'Dic'];
var importi = <?php echo json_encode($importi); ?>;

new Chart(document.getElementById("report-entrate"), {
  type: 'line',
  data: {
    labels: labels,
    datasets: [{ 
        data: importi,
        label: "Importo",
        borderColor: "#3e95cd",
        fill: false
      }
    ]
  },
  options: {
    title: {
      display: true,
      text: 'Rapporto Entrate Mensili'
    }
  }
});
	

</script>