<?php

	if(!(isset($paginaIntegra) && $paginaIntegra === true)) exit();

	include "action/gestisci-medico.php";

?>	
<?php

	if(!isset($_GET['id_medico'])){
		include 'parti/seleziona_medico.php';
	}else{
		$id_medico = $_GET['id_medico'];
		$medico = new Medico($conn);
		$medico->selectMedicoById($id_medico);
?>


<div id="form_container">
   <form id="form_aggiungimedico" class="form-style-7">
	 <h2 class="title testo-grande">Anagrafica Medico
		 <i class="delete fas fa-edit" style="float: right" title="Modifica" id="modifica_anagrafica"></i></h2>
      <ul id="form_info">		  
		<!-- RIGA 1 -->
		  
		<li class="fill" style="width: 5%;">
		   <label class="description" for="element_1">Sesso</label>
		   <input name="id" type="text" class="form-control" value="<?php echo $medico->tipo; ?>" readonly/>    
		</li>
		  
		<li class="fill" style="width: 40%;">
		   <label class="description" for="element_1">Cognome</label>
		   <input name="cognome" type="text" class="form-control" value="<?php echo $medico->cognome; ?>" readonly/>      
		</li>	
		<li class="fill" style="width: 40%; padding-right: 10px; padding-left: 10px; ">
		   <label class="description" for="element_1">Nome</label>
		   <input name="nome" type="text" class="form-control" value="<?php echo $medico->nome; ?>" readonly/>   
		</li>
		<li class="fill" style="width: 10%; padding-right: 10px; padding-left: 10px;">
		   <label class="description" for="element_1">Titolo</label>
		   <input name="nome" type="text" class="form-control" value="<?php echo $medico->titolo; ?>" readonly/>      
		</li>
		<li class="fill" style="width: 5%;">
		   <label class="description" for="element_1">ID</label>
		   <input name="id" type="text" class="form-control" value="<?php echo $medico->id; ?>" readonly/>      
		</li>	 
		 		  
		  
		  <!-- RIGA 3 -->
		  
		<li class="fill" style="width: 80%">
		   <label class="description" for="element_1">Indirizzo</label>
		   <input name="indirizzo" type="text" value="<?php echo $medico->indirizzo; ?>" readonly/>      
		  </li>
		  
		<li class="fill" style="width: 20%">
		   <label class="description" for="element_1">Provincia</label>
		   <input name="prov" type="text" value="<?php echo $medico->prov; ?>" readonly/> 
		</li>
		  
		  <!-- RIGA 3 -->

		<li class="fill" style="width: 70%">
		   <label class="description" for="element_1">Città</label>
		   <input name="citta" type="text" value="<?php echo $medico->citta; ?>" readonly/> 
		</li>
		<li class="fill" style="width: 30%">
		   <label class="description" for="element_1">CAP</label>
		   <input name="cap" type="text" value="<?php echo $medico->cap; ?>" readonly/> 
		</li>
		
		    <!-- RIGA 5 -->
		  
		<li class="left">
		   <label class="description" for="element_1">Codice Fiscale</label>
		   <input name="cod_fiscale" type="text" value="<?php echo $medico->cod_fiscale; ?>" readonly/> 
		</li>
	
	
		<li class="right">
		   <label class="description">Partita IVA</label>
			<input name="p_iva" type="text" value="<?php echo $medico->p_iva; ?>" readonly/>			
	   </li>
	
		    <!-- RIGA 6 -->
	
		<li class="left">
		   <label class="description" for="element_1">1° Telefono</label>
		   <input name="tel_1" type="text" value="<?php echo $medico->tel_1; ?>" readonly/> 
		</li>
	
	
		<li class="right">
		   <label class="description">Fattura</label>
			<input name="tel_2" type="text" value="<?php echo $medico->fattura; ?>" readonly/>			
	   </li>
		  
		  <li class="buttons">
			<input id="bn_modifica" class="btn btn-light" type="submit" name="submit" value="Salva Anagrafica" style="display: none"/>
		 </li>
      </ul>
   </form>
	
	<script>
	$('#modifica_anagrafica').on("click", function(){

		<?php
		
		$query = $_GET;
		// replace parameter(s)
		$query['page'] = 'modifica-medico';
		$query['id_medico'] = $_GET['id_medico'];
		// rebuild url
		$query_result = http_build_query($query);

		?>
		window.location.replace("?<?php echo $query_result; ?>");

	});
	
</script>
	
</div>

<?php } ?>
