<?php

	if(!(isset($paginaIntegra) && $paginaIntegra === true)) exit();

	include "action/gestisci-paziente.php";

?>	
<?php

	if(!isset($_GET['id_paziente'])){
		include 'parti/seleziona_paziente.php';
	}else{
		$id_paziente = $_GET['id_paziente'];
		$paziente = new Paziente($conn);
		$paziente->selectPazienteById($id_paziente);
?>


<div id="form_container">
   <form id="form_aggiungipaziente" class="form-style-7">
	 <h2 class="title testo-grande">Anagrafica Paziente
		 <i class="delete fas fa-edit" style="float: right" title="Modifica" id="modifica_anagrafica"></i></h2>
      <ul id="form_info">
				  
		<!-- RIGA 1 -->
		  
		<li class="fill" style="width: 5%;">
		   <label class="description" for="element_1">Sesso</label>
		   <input name="id" type="text" class="form-control" value="<?php echo $paziente->sesso; ?>" readonly/>    
		</li>
		  
		<li class="fill" style="width: 40%;">
		   <label class="description" for="element_1">Cognome</label>
		   <input name="cognome" type="text" class="form-control" value="<?php echo $paziente->cognome; ?>" readonly/>      
		</li>	
		<li class="fill" style="width: 40%; padding-right: 10px; padding-left: 10px; ">
		   <label class="description" for="element_1">Nome</label>
		   <input name="nome" type="text" class="form-control" value="<?php echo $paziente->nome; ?>" readonly/>   
		</li>
		<li class="fill" style="width: 10%; padding-right: 10px; padding-left: 10px;">
		   <label class="description" for="element_1">Titolo</label>
		   <input name="nome" type="text" class="form-control" value="<?php echo $paziente->titolo; ?>" readonly/>      
		</li>
		<li class="fill" style="width: 5%;">
		   <label class="description" for="element_1">ID</label>
		   <input name="id" type="text" class="form-control" value="<?php echo $paziente->id; ?>" readonly/>      
		</li>	 
		 		  
		  
		  <!-- RIGA 3 -->
		  
		  		  
		<li class="fill" style="width: 10%">
		   <label class="description" for="element_1">Privacy</label>
		   <input name="indirizzo" type="text" value="<?php echo $paziente->privacy; ?>" readonly/>      
		</li>
		  
		<li class="fill" style="width: 55%">
		   <label class="description" for="element_1">Indirizzo</label>
		   <input name="indirizzo" type="text" value="<?php echo $paziente->indirizzo; ?>" readonly/>      
		</li>
		  
		<li class="fill" style="width: 35%">
		   <label class="description" for="element_1">Stato</label>
		   <input name="stato" type="text" value="<?php echo $paziente->stato; ?>" readonly/> 
		</li>
		  
		  <!-- RIGA 4 -->

		  
		<li class="fill" style="width: 20%">
		   <label class="description" for="element_1">Provincia</label>
		   <input name="provincia" type="text" value="<?php echo $paziente->provincia; ?>" readonly/> 
		</li>
		  
		  
		<li class="fill" style="width: 60%">
		   <label class="description" for="element_1">Città</label>
		   <input name="citta" type="text" value="<?php echo $paziente->citta; ?>" readonly/> 
		</li>
		<li class="fill" style="width: 20%">
		   <label class="description" for="element_1">CAP</label>
		   <input name="cap" type="text" value="<?php echo $paziente->cap; ?>" readonly/> 
		</li>
		
		    <!-- RIGA 5 -->
		  
		<li class="left">
		   <label class="description" for="element_1">Codice Fiscale</label>
		   <input name="cod_fisc" type="text" value="<?php echo $paziente->cod_fiscale; ?>" readonly/> 
		</li>
	
	
		<li class="right">
		   <label class="description">Partita IVA</label>
			<input name="p_iva" type="text" value="<?php echo $paziente->p_iva; ?>" readonly/>			
	   </li>
	
		    <!-- RIGA 6 -->
	
		<li class="left">
		   <label class="description" for="element_1">1° Telefono</label>
		   <input name="tel_1" type="text" value="<?php echo $paziente->tel_1; ?>" readonly/> 
		</li>
	
	
		<li class="right">
		   <label class="description">2° Telefono</label>
			<input name="tel_2" type="text" value="<?php echo $paziente->tel_2; ?>" readonly/>			
	   </li>
		  
		  <li class="buttons">
			<input id="bn_modifica" class="button_text" type="submit" name="submit" value="Salva Anagrafica" style="display: none"/>
		 </li>
      </ul>
   </form>
	
	
	<script>
	$('#modifica_anagrafica').on("click", function(){

		<?php
		
		$query = $_GET;
		// replace parameter(s)
		$query['page'] = 'modifica-paziente';
		$query['id_paziente'] = $_GET['id_paziente'];
		// rebuild url
		$query_result = http_build_query($query);

		?>
		window.location.replace("?<?php echo $query_result; ?>");

	});
	
</script>
	
	
</div>

<?php } ?>
