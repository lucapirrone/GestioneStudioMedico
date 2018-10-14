<?php

	if(!(isset($paginaIntegra) && $paginaIntegra === true)) exit();

	include "action/gestisci-medico.php";

?>	
<?php

	if(!isset($_GET['id_medico']) || $_GET['id_medico']==""){
		include 'parti/seleziona_medico.php';
	}else{
		$id_medico = $_GET['id_medico'];
		$medico = new Medico($conn);
		$medico->selectMedicoById($id_medico);
?>

<div id="form_container">
	   <h2 class="title testo-grande">Modifica Anagrafica Medico</h2>
   <form id="form_aggiungimedico" class="form-style-7" action="" method="post">
      <ul id="form_info">
		  
		   <?php createInputToken(); 	?>

		  <!-- RIGA 1 -->
		<li class="fill" style="width: 5%;">
		   <label class="description" for="element_1">ID</label>
		   <input name="id" type="text"  value="<?php echo $medico->id; ?>" readonly/>      
		</li>	   
		<li class="fill" style="width: 10%; padding-right: 10px; padding-left: 10px;">
		   <label class="description" for="element_1">Titolo</label>
			<select name="titolo" type="text" class="form-control">
				<option value="<?php echo $medico->titolo; ?>"><?php echo $medico->titolo; ?></option>
				<option value="SIG">Sig</option>
				<option value="SIG.RA">Sig.ra</option>
			</select>      
		</li>  
		<li class="fill" style="width: 35%;">
		   <label class="description" for="element_1">Cognome</label>
		   <input name="cognome" type="text" value="<?php echo $medico->cognome;?>"/>      
		</li>	
		<li class="fill" style="width: 35%; padding-right: 10px; padding-left: 10px; ">
		   <label class="description" for="element_1">Nome</label>
		   <input name="nome" type="text" value="<?php echo $medico->nome;?>"/>   
		</li>
		<li class="fill" style="width: 15%; padding-right: 10px; padding-left: 10px;">
		   <label class="description" for="element_1">Tipo</label>
			<select name="tipo" type="text" class="form-control">
				<option value="<?php echo $medico->tipo; ?>"><?php echo $medico->tipo; ?></option>
				<option value="MEDICO">Medico</option>
				<option value="COLLABORATORE">Collaboratore</option>
			</select>      
		</li> 
		  <!-- RIGA 3 -->
		  
		 <li class="fill" style="width: 40%">
		   <label class="description" for="element_1">Specializzazione</label>
		   <input name="spec" type="text" value="<?php echo $medico->spec; ?>"/>      
	  </li>
		<li class="fill" style="width: 40%">
		   <label class="description" for="element_1">Indirizzo</label>
		   <input name="indirizzo" type="text" value="<?php echo $medico->indirizzo;?>"/>      
		  </li>
		  
		<li class="fill" style="width: 20%">
		   <label class="description" for="element_1">Provincia</label>
		   <input name="prov" type="text" value="<?php echo $medico->prov;?>"/> 
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
		  
		<li class="fill" style="width: 40%;">
		   <label class="description" for="element_1">Codice Fiscale</label>
		   <input name="cod_fiscale" type="text" value="<?php echo $medico->cod_fiscale;?>"/> 
		</li>
	
	
		<li class="fill" style="width: 40%;">
		   <label class="description">Partita IVA</label>
		   <input name="p_iva" type="text" value="<?php echo $medico->p_iva;?>"/> 

	   </li>
		
		<li class="fill" style="width: 20%;">
		   <label class="description">Fattura</label>
			<select name="fattura" type="text" class="form-control">
				<option selected="selected" value="<?php echo $medico->fattura;?>"><?php echo $medico->fattura;?></option>
				<option value="SI">Si</option>
				<option value="NO">No</option>
			</select>  
		  
		  </li>
		  
		  <li class="buttons">
			<input id="bn_modifica" class="button_text" type="submit" name="submit" value="Salva Anagrafica"/>
		 </li>
      </ul>
   </form>
	
</div>

<?php } ?>