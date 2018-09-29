<?php

	if(!(isset($paginaIntegra) && $paginaIntegra === true)) exit();

?>	
<?php

	

	T_ECHO "<script type=\"text/javascript\"> var requestPage=\"".$_GET['page']."\"; </script>";

	if(isset($_GET['id_paziente'])){
		$id_paziente = $_GET['id_paziente'];
		$p = new Paziente($conn);
		$p->selezionaPazienteId($id_paziente);
	}

	

	require 'action/gestiscipaziente.php';

		
?>


<div id="form_container">
   <form id="form_aggiungipaziente" class="form-style-7" method="post" action="">
	 <h2 class="title testo-grande">Anagrafica Paziente</h2>
      <ul id="form_info">
		
		 <?php createInputToken(); 	?>
		  
		  		
		<h2 class="title testo-grande">Informazioni Paziente Selezionato</h2>
	
		<li class="fill" style="width: 10%;">
		   <label class="description" for="element_1">ID</label>
		   <input name="id" type="text" class="form-control" value="<?php echo $paziente->id; ?>" readonly/>      
		</li>
		<li class="fill" style="width: 40%; padding-right: 10px; padding-left: 10px;">
		   <label class="description" for="element_1">Nome</label>
		   <input name="nome" type="text" class="form-control" value="<?php echo $paziente->nome; ?>" readonly/>      
		</li>		
		<li class="fill" style="width: 40%;">
		   <label class="description" for="element_1">Cognome</label>
		   <input name="cognome" type="text" class="form-control" value="<?php echo $paziente->cognome; ?>" readonly/>      
		</li>	
		  
		  
		<li class="fill" style="width: 10%;">
		   <label class="description" for="element_1">Sesso</label>
		   <input name="id" type="text" class="form-control" value="<?php echo $paziente->sesso; ?>" readonly/>      
		</li>
		<li class="fill" style="width: 40%; padding-right: 10px; padding-left: 10px;">
		   <label class="description" for="element_1">Titolo</label>
		   <input name="nome" type="text" class="form-control" value="<?php echo $paziente->titolo; ?>" readonly/>      
		</li>
		
		  
		<li class="fill" style="width: 40%">
		   <label class="description" for="element_1">Indirizzo</label>
		   <input type="text" value="<?php echo $paziente->indirizzo; ?>" readonly/>      
		</li>
		  
		<li class="fill" style="width: 60%">
		   <label class="description" for="element_1">Stato</label>
		   <input type="text" value="<?php echo $paziente->stato; ?>" readonly/> 
		</li>
		<li class="fill">
		   <label class="description" for="element_1">Provincia</label>
		   <input type="text" value="<?php echo $paziente->provincia; ?>" readonly/> 
		</li>
		  
		  
		<li class="fill" style="width: 60%">
		   <label class="description" for="element_1">Città</label>
		   <input type="text" value="<?php echo $paziente->citta; ?>" readonly/> 
		</li>
		<li class="fill" style="width: 20%">
		   <label class="description" for="element_1">CAP</label>
		   <input type="text" value="<?php echo $paziente->cap; ?>" readonly/> 
		</li>
		
		<li class="left">
		   <label class="description" for="element_1">Codice Fiscale</label>
		   <input type="text" value="<?php echo $paziente->cod_fisc; ?>" readonly/> 
		</li>
	
	
		<li class="right">
		   <label class="description">Partita IVA</label>
			<input type="text" value="<?php echo $paziente->p_iva; ?>" readonly/>			
	   </li>
	
	
		<li class="left">
		   <label class="description" for="element_1">1° Telefono</label>
		   <input type="text" value="<?php echo $paziente->tel_1; ?>" readonly/> 
		</li>
	
	
		<li class="right">
		   <label class="description">2° Telefono</label>
			<input type="text" value="<?php echo $paziente->tel_2; ?>" readonly/>			
	   </li>
		  
		  <li class="buttons">
			<input type="hidden" name="form_id" value="12719" />
			<?php if($modifica){ ?><input id="saveForm" class="button_text" type="submit" name="submit" value="Modifica Paziente" />
			<?php }else{ ?> <input id="saveForm" class="button_text" type="submit" name="submit" value="Aggiungi Paziente" />
			 <?php } ?>
		 </li>
      </ul>
   </form>
</div>
