<?php

	if(!(isset($paginaIntegra) && $paginaIntegra === true)) exit();

?>


		
<h2 class="title">Filtra Fatture</h2>
<?php
require 'parti/admin/fatturazione/includes/filtra-fatture.php';
?>
<script>$('#form_filtri').attr('action', '?page=lista-fatture');</script>

<div class="limiter" style="width: 50%;float: left;padding-right: 10px;">
<h2 class="title">Rapporto Fatturate Mensili</h2>
	<?php require 'parti/admin/report-modules/report-linechart-num-fatture.php'; ?>
</div>

<div class="limiter" style="width: 50%;float: right;padding-left: 10px;">
<h2 class="title">Rapporto Entrate Mensili</h2>
	<?php require 'parti/admin/report-modules/report-linechart-entrate.php'; ?>
</div>
