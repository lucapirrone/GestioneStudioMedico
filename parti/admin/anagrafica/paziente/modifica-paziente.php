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
   <form id="form_aggiungipaziente" class="form-style-7" method="post" action="">
	 <h2 class="title testo-grande">Anagrafica Paziente</h2>
      <ul id="form_info">
		
	 	<?php createInputToken(); 	?>
		  
		<input type="hidden" name="action_code" value="3"/> 
		
		<input type="hidden" name="action" value="request"/> 
		  
		<!-- RIGA 1 -->
		  <li class="fill" style="width: 15%; padding-right: 10px; padding-left: 10px;">
		   <label class="description" for="element_1">Titolo</label>
		   	<select name="sesso" type="text" class="form-control">
				<option selected="true" value="<?php $paziente->titolo; ?>"><?php echo $paziente->titolo; ?></option>
				<option value="SIG">Sig</option>
				<option value="SIG.RA">Sig.ra</option>
			</select> 
		</li>
		<li class="fill" style="width: 40%; padding-right: 10px; padding-left: 10px; ">
		   <label class="description" for="element_1">Nome</label>
		   <input name="nome" type="text" class="form-control" value="<?php echo $paziente->nome; ?>"/>   
		</li> 
		<li class="fill" style="width: 40%;">
		   <label class="description" for="element_1">Cognome</label>
		   <input name="cognome" type="text" class="form-control" value="<?php echo $paziente->cognome; ?>"/>      
		</li>
		 <li class="fill" style="width: 5%;">
		   <label class="description" for="element_1">Sesso</label>
		  	<select name="sesso" type="text" class="form-control">
				<option selected="true" value="<?php echo $paziente->sesso; ?>"><?php echo $paziente->sesso; ?></option>
				<option value="M">Uomo</option>
				<option value="F">Donna</option>
				<option value="A">Altro</option>
			</select>     
		</li>
		 		  
		  
		  <!-- RIGA 3 -->
		 <li class="fill" style="width: 35%">
		   <label class="description" for="element_1">Stato</label>
		   <input name="stato" type="text" value="<?php echo $paziente->stato; ?>"/> 
		</li> 
		  <li class="fill" style="width: 55%">
		   <label class="description" for="element_1">Indirizzo</label>
		   <input name="indirizzo" type="text" value="<?php echo $paziente->indirizzo; ?>"/>      
		</li>
		  		  
		<li class="fill" style="width: 10%">
		   <label class="description" for="element_1">Privacy</label>
		  	<select name="privacy" type="text" class="form-control">
				<option selected="true" value="<?php echo $paziente->privacy; ?>"><?php echo $paziente->privacy; ?></option>
				<option value="SI">Si</option>
				<option value="NO">No</option>
			</select> 	   
		</li>
		  
		  <!-- RIGA 4 -->

		 <li class="fill" style="width: 20%">
		   <label class="description" for="element_1">CAP</label>
		   <input name="cap" type="text" value="<?php echo $paziente->cap; ?>"/> 
		</li>
		 <li class="fill" style="width: 60%">
		   <label class="description" for="element_1">Città</label>
		   <input name="citta" type="text" value="<?php echo $paziente->citta; ?>"/> 
		</li>
		<li class="fill" style="width: 20%">
		   <label class="description" for="element_1">Provincia</label>
		   <input name="provincia" type="text" value="<?php echo $paziente->provincia; ?>"/> 
		</li>

		
		    <!-- RIGA 5 -->
		  
		<li class="left">
		   <label class="description" for="element_1">Codice Fiscale</label>
		   <input name="cod_fisc" type="text" value="<?php echo $paziente->cod_fiscale; ?>"/> 
		</li>
	
	
		<li class="right">
		   <label class="description">Partita IVA</label>
			<input name="p_iva" type="text" value="<?php echo $paziente->p_iva; ?>"/>			
	   </li>
	
		    <!-- RIGA 6 -->
	
		<li class="left">
		   <label class="description" for="element_1">1° Telefono</label>
		   <input name="tel_1" type="text" value="<?php echo $paziente->tel_1; ?>"/> 
		</li>
	
	
		<li class="right">
		   <label class="description">2° Telefono</label>
			<input name="tel_2" type="text" value="<?php echo $paziente->tel_2; ?>"/>			
	   </li>
		  
		  <li class="buttons">
			<input id="bn_modifica" class="btn btn-light" type="submit" name="submit" value="Salva Anagrafica"/>
		 </li>
      </ul>
   </form>
	
</div>

<?php } ?>
