<?php

	if(!(isset($paginaIntegra) && $paginaIntegra === true)) exit();

?>


<form id="form_selezionapaziente" class="form-style-7" action="" method="get">
 	<h2 class="title testo-grande">Seleziona Paziente
		<i class="delete fas fa-plus" style="float: right" title="Aggiungi Paziente" onClick="window.location.replace('?page=aggiungi-paziente')"></i>
	</h2>
	<ul>
		
		<?php require 'modules/autocomplete_codicefiscale.php' ?>
		
		 <li class="buttons">
            <input id="select_paz" class="button_text" type="button" value="Seleziona Paziente" />
         </li>
		
    </ul>
</form>

<?php 
	$token = $_SESSION['token'] = md5(uniqid(mt_rand(), true)); 
?>

<script>
$('#select_paz').on("click", function(){
	
	window.location.replace("?<?php echo http_build_query($_GET); ?>&id_paziente="+$("#id_paziente").val());

});
	
</script>
