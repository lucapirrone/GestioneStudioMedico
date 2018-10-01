<?php

	if(!(isset($paginaIntegra) && $paginaIntegra === true)) exit();

	include "action/gestisci-medico.php";

?>	

<div id="form_container">
	   <h2 class="title testo-grande">Registra Movimento</h2>
   <form id="form_aggiungimedico" class="form-style-7" action="" method="post">
      <ul id="form_info">
		  
		  <?php createInputToken(); ?>
		
		  