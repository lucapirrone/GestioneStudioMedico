<?php

	if(!isset($_GET['id_medico'])){
		include 'parti/seleziona_societa_esterna.php';
	}else{
		$id_societa = $_GET['id_societa'];
		$medico = new Medico($conn);
		$medico->selectMedicoById($id_medico);
?>


<div id="form_container">
	   <h2 class="title testo-grande">Visualizza Societa Esterna</h2>
	 <i class="delete fas fa-edit" style="float: right" title="Modifica" id="modifica_societa"></i>
   <form id="form_aggiungisocieta" class="form-style-7">
      <ul id="form_info">
		  
		  <?php createInputToken(); ?>
				  
		<!-- RIGA 1 -->
  
		<li class="fill">
		   <label class="description" for="element_1">Nome</label>
		   <input name="nome" type="text" value="<?php echo $se->$nome; ?>"/>      
		</li>


	   <li class="fill" style="width: 40%">
		   <label class="description" for="element_1">Indirizzo</label>
		   <input name="indirizzo" type="text" value="<?php echo $se->$indirizzo; ?>"/>      
	   </li>
		  
		<li class="fill" style="width: 20%">
		   <label class="description" for="element_1">Provincia</label>
		   <input name="prov" type="text" value="<?php echo $se->$provincia; ?>"/> 
		</li>
		  
		  <!-- RIGA 3 -->

		<li class="fill" style="width: 20%">
		   <label class="description" for="element_1">Città</label>
		   <input name="citta" type="text" value="<?php echo $se->$citta; ?>"/> 
		</li>
		<li class="fill" style="width: 20%">
		   <label class="description" for="element_1">CAP</label>
		   <input name="cap" type="text" value="<?php echo $se->$cap; ?>"/> 
		</li>
		
		    <!-- RIGA 5 -->
		  
		<li class="fill" style="width: 50%;">
		   <label class="description" for="element_1">Codice Fiscale</label>
		   <input name="cod_fiscale" type="text" value="<?php echo $se->$cod_fiscale; ?>"/> 
		</li>
	
	
		<li class="fill" style="width: 50%;">
		   <label class="description">Partita IVA</label>
		  <input name="p_iva" type="text" value="<?php echo $se->$p_iva; ?>"/>
	   </li>
		  
		  <li class="buttons">
			<input id="bn_modifica" class="button_text" type="submit" name="submit" value="Aggiungi Medico"/>
		 </li>
      </ul>
   </form>
	
</div>
	
	<script>
	$('#modifica_societa').on("click", function(){

		<?php
		
		$query = $_GET;
		// replace parameter(s)
		$query['page'] = 'modifica-societa-esterna';
		$query['id_societa'] = $_GET['id_societa'];
		// rebuild url
		$query_result = http_build_query($query);

		?>
		window.location.replace("?<?php echo $query_result; ?>");

	});
	
</script>
	
</div>

<?php } ?>
