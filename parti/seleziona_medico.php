<?php

	if(!(isset($paginaIntegra) && $paginaIntegra === true)) exit();

?>

<h2 class="title testo-grande">Seleziona Medico
	<i class="delete fas fa-plus" style="float: right" title="Aggiungi Medico" onClick="window.location.replace('?page=aggiungi-medico')"></i>
</h2>
<form id="form_selezionapaziente" class="form-style-7" action="" method="get">

	<ul>
		
		<?php require 'modules/autocomplete_medico.php' ?>
		
		 <li class="buttons">
            <input id="select_medico" class="btn btn-light" type="button" value="Seleziona Medico" />
         </li>
		
    </ul>
</form>

<?php 
	if(!isset($token)) $token = $_SESSION['token'] = md5(uniqid(mt_rand(), true)); 
?>

<script>
$('#select_medico').on("click", function(){
	console.log($("#id_medico").val());
	window.location.replace("?<?php echo http_build_query($_GET); ?>&id_medico="+$("#id_medico").val());

});
	
</script>
