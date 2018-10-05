<?php

	if(!(isset($paginaIntegra) && $paginaIntegra === true)) exit();

?>

<h2 class="title">Seleziona Paziente
	<i class="delete fas fa-plus" style="float: right" title="Aggiungi Paziente" onClick="window.location.replace('?page=aggiungi-paziente')"></i>
</h2>
<form id="form_selezionapaziente" class="form-style-7" action="" method="get">

	<ul>
		
		<?php require 'modules/autocomplete_codicefiscale.php' ?>
		
		 <li class="buttons">
            <input id="select_paz" class="btn btn-light" type="button" value="Seleziona Paziente" />
         </li>
		
    </ul>
</form>

<?php 
	if(!isset($token)) $token = $_SESSION['token'] = md5(uniqid(mt_rand(), true)); 
?>

<script>
$('#select_paz').on("click", function(){
	
	window.location.replace("?<?php echo http_build_query($_GET); ?>&id_paziente="+$("#id_paziente").val());

});
	
</script>
