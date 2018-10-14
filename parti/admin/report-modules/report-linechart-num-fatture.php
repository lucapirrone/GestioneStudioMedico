<?php 
	$n_fatture = array();


	$times  = array();
	for($month = 1; $month <= 12; $month++) {
		$timestamp_from = mktime(0, 0, 0, $month, 1);
		$timestamp_to = mktime(23, 59, 59, $month, date('t', $timestamp_from));


		if ($fetchall_report = $conn->prepare("SELECT ID FROM FATTURE WHERE DATA_FAT > ? AND DATA_FAT < ?")) { 
			$fetchall_report->bind_param('ss', $timestamp_from, $timestamp_to); 

			if($fetchall_report->execute()){ 
				$fetchall_report->store_result();
				$fetchall_report->bind_result($upload_time);
				$fetchall_report->fetch();
				array_push($n_fatture, $fetchall_report->num_rows);
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
	
	<canvas id="report-num-fatture" width="800" height="450"></canvas>
	
</div>


<script>

var labels = ['Gen', 'Feb', 'Mar', 'Apr', 'Mag', 'Giu', 'Lug', 'Aug', 'Sep', 'Oct', 'Nov', 'Dic'];
var n_fatture = <?php echo json_encode($n_fatture); ?>;

new Chart(document.getElementById("report-num-fatture"), {
  type: 'line',
  data: {
    labels: labels,
    datasets: [{ 
        data: n_fatture,
        label: "Fatture",
        borderColor: "#3e95cd",
        fill: false
      }
    ]
  },
  options: {
    title: {
      display: true,
      text: 'Rapporto Fatture Mensili'
    }
  }
});
	

</script>