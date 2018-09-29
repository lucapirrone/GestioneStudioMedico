<?php 
	$data_upload = array();
	$data_download = array();


	$times  = array();
	for($month = 1; $month <= 12; $month++) {
		$timestamp_from = mktime(0, 0, 0, $month, 1);
		$timestamp_to = mktime(23, 59, 59, $month, date('t', $timestamp_from));


		if ($fetchall_report = $conn->prepare("select upload_time from report_upload_referti where upload_time > ? and upload_time < ?")) { 
			$fetchall_report->bind_param('ss', $timestamp_from, $timestamp_to); 

			if($fetchall_report->execute()){ 
				$fetchall_report->store_result();
				$fetchall_report->bind_result($upload_time);
				$fetchall_report->fetch();
				array_push($data_upload, $fetchall_report->num_rows);
			}else{
				echo mysqli_error($conn);
			}
		}else{
			echo mysqli_error($conn);
		}
	

		if ($fetchall_reportd = $conn->prepare("select download_time from report_download_referti where download_time > ? and download_time < ?")) { 
			$fetchall_reportd->bind_param('ss', $timestamp_from, $timestamp_to); 

			if($fetchall_reportd->execute()){ 
				$fetchall_reportd->store_result();
				$fetchall_reportd->bind_result($download_time);
				$fetchall_reportd->fetch();
				array_push($data_download, $fetchall_reportd->num_rows);
			}else{
				echo mysqli_error($conn);
			}
		}else{
			echo mysqli_error($conn);
		}
	}

?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.js"></script>
<div class="container-table100">
	
	<canvas id="report-referti-full" width="800" height="450"></canvas>
	
</div>


<script>

var labels = ['Gen', 'Feb', 'Mar', 'Apr', 'Mag', 'Giu', 'Lug', 'Aug', 'Sep', 'Oct', 'Nov', 'Dic'];
var data_upload = <?php echo json_encode($data_upload); ?>;
var data_download = <?php echo json_encode($data_download); ?>;

console.log(data_download);
new Chart(document.getElementById("report-referti-full"), {
  type: 'line',
  data: {
    labels: labels,
    datasets: [{ 
        data: data_upload,
        label: "Referti Caricati",
        borderColor: "#3e95cd",
        fill: false
      }, { 
        data: data_download,
        label: "Referti Scaricati",
        borderColor: "#8e5ea2",
        fill: false
      }
    ]
  },
  options: {
    title: {
      display: true,
      text: 'Report Referti'
    }
  }
});
	

</script>