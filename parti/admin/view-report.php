<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="report-table/vendor/perfect-scrollbar/perfect-scrollbar.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="report-table/css/main.css">
<!--===============================================================================================-->
	
	<div class="limiter">
		<?php include 'parti/admin/report-modules/report-linechart-total-referti.php'; ?>
		<?php include 'parti/admin/report-modules/report-total-referti.php'; ?>
	</div>


<!--===============================================================================================-->	
	<script src="report-table/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="report-table/vendor/bootstrap/js/popper.js"></script>
	<script src="report-table/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="report-table/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="report-table/vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
	<script>
		$('.js-pscroll').each(function(){
			var ps = new PerfectScrollbar(this);

			$(window).on('resize', function(){
				ps.update();
			})
		});
			
		
	</script>
<!--===============================================================================================-->
	<script src="report-table/js/main.js"></script>