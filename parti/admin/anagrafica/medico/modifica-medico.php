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
	   <h2 class="title testo-grande">Anagrafica Medico</h2>
      <ul id="form_info">
		  
		   <?php createInputToken(); 	?>
		  
		<input type="hidden" name="action_code" value="5"/> 
		
		<input type="hidden" name="action" value="request"/> 
		  
		  
		<!-- RIGA 1 -->
		  
		<li class="fill" style="width: 10%;">
		   <label class="description" for="element_1">Sesso</label>
		  	<select name="sesso" type="text" class="form-control">
				<option value="M">Uomo</option>
				<option value="F">Donna</option>
				<option value="A">Altro</option>
			</select>     
		</li>
		  
		<li class="fill" style="width: 40%;">
		   <label class="description" for="element_1">Cognome</label>
		   <input name="cognome" type="text" class="form-control" value="<?php echo $medico->cognome;?>"/>      
		</li>	
		<li class="fill" style="width: 40%; padding-right: 10px; padding-left: 10px; ">
		   <label class="description" for="element_1">Nome</label>
		   <input name="nome" type="text" class="form-control" value="<?php echo $medico->nome;?>"/>   
		</li>
		<li class="fill" style="width: 10%; padding-right: 10px; padding-left: 10px;">
		   <label class="description" for="element_1">Titolo</label>
			<select name="titolo" type="text" class="form-control">
				<option selected="selected" value="<?php echo $medico->titolo;?>"><?php echo $medico->titolo;?></option>
				<option value="SIG">Sig</option>
				<option value="SIG.RA">Sig.ra</option>
			</select>      
		</li>  
		  
		  <!-- RIGA 3 -->
		  
		<li class="fill" style="width: 80%">
		   <label class="description" for="element_1">Indirizzo</label>
		   <input name="indirizzo" type="text" value="<?php echo $medico->indirizzo;?>"/>      
		  </li>
		  
		<li class="fill" style="width: 20%">
		   <label class="description" for="element_1">Provincia</label>
		   <input name="provincia" type="text" value="<?php echo $medico->prov;?>"/> 
		</li>
		  
		  <!-- RIGA 3 -->

		<li class="fill" style="width: 70%">
		   <label class="description" for="element_1">Città</label>
		   <input name="citta" type="text" value="<?php echo $medico->citta;?>"/> 
		</li>
		<li class="fill" style="width: 30%">
		   <label class="description" for="element_1">CAP</label>
		   <input name="cap" type="text" value="<?php echo $medico->cap;?>"/> 
		</li>
		
		    <!-- RIGA 5 -->
		  
		<li class="left">
		   <label class="description" for="element_1">Codice Fiscale</label>
		   <input name="cod_fisc" type="text" value="<?php echo $medico->cod_fiscale;?>"/> 
		</li>
	
	
		<li class="right">
		   <label class="description">Partita IVA</label>
		   <input name="p_iva" type="text" value="<?php echo $medico->p_iva;?>"/> 

	   </li>
	
		    <!-- RIGA 6 -->
	
		<li class="left">
		   <label class="description" for="element_1">1° Telefono</label>
		   <input name="tel_1" type="text"/> 
		</li>
	
	
		<li class="right">
		   <label class="description">Fattura</label>
			<select name="fattura" type="text" class="form-control">
				<option selected="selected" value="<?php echo $medico->fattura;?>"><?php echo $medico->fattura;?></option>
				<option value="SI">Si</option>
				<option value="NO">No</option>
			</select>  
		  
		  </li>
		  
		  <li class="buttons">
			<input id="bn_modifica" class="button_text" type="submit" name="submit" value="Salva Anagrafica" style="display: none"/>
		 </li>
      </ul>
   </form>
	
</div>

<?php } ?>