<?php

	if(!(isset($paginaIntegra) && $paginaIntegra === true)) exit();

	include "action/gestisci-medico.php";

?>	

<div id="form_container">
	   <h2 class="title testo-grande">Nuovo Medico</h2>
   <form id="form_aggiungimedico" class="form-style-7" action="" method="post">
      <ul id="form_info">
		  
		  <?php createInputToken(); ?>
		
		  
		  
		<!-- RIGA 1 -->
		  
		<li class="fill" style="width: 10%; padding-right: 10px; padding-left: 10px;">
		   <label class="description" for="element_1">Titolo</label>
			<select name="titolo" type="text">
				<option value="SIG">Sig</option>
				<option value="SIG.RA">Sig.ra</option>
			</select>      
		</li>  
		<li class="fill" style="width: 35%;">
		   <label class="description" for="element_1">Cognome</label>
		   <input name="cognome" type="text"/>      
		</li>	
		<li class="fill" style="width: 35%; padding-right: 10px; padding-left: 10px; ">
		   <label class="description" for="element_1">Nome</label>
		   <input name="nome" type="text"/>   
		</li>
		  		  
		<li class="fill" style="width: 20%; padding-right: 10px; padding-left: 10px;">
		   <label class="description" for="element_1">Tipo</label>
			<select name="tipo" type="text">
				<option value="MEDICO">Medico</option>
				<option value="COLLABORATORE">Collaboratore</option>
			</select>      
		</li> 

		  <!-- RIGA 3 -->

		<li class="fill" style="width: 40%">
		   <label class="description" for="element_1">Specializzazione</label>
		   <input name="spec" type="text"/>      
	  </li>
	   <li class="fill" style="width: 40%">
		   <label class="description" for="element_1">Indirizzo</label>
		   <input name="indirizzo" type="text"/>      
	   </li>
		  
		<li class="fill" style="width: 20%">
		   <label class="description" for="element_1">Provincia</label>
		   <input name="prov" type="text"/> 
		</li>
		  
		  <!-- RIGA 3 -->

		<li class="fill" style="width: 70%">
		   <label class="description" for="element_1">Città</label>
		   <input name="citta" type="text"/> 
		</li>
		<li class="fill" style="width: 30%">
		   <label class="description" for="element_1">CAP</label>
		   <input name="cap" type="text"/> 
		</li>
		
		    <!-- RIGA 5 -->
		  
		<li class="fill" style="width: 40%;">
		   <label class="description" for="element_1">Codice Fiscale</label>
		   <input name="cod_fiscale" type="text"/> 
		</li>
	
	
		<li class="fill" style="width: 40%;">
		   <label class="description">Partita IVA</label>
		  <input name="p_iva" type="text"/>
	   </li>
	
		<li class="fill" style="width: 20%;">
		   <label class="description">Fattura</label>
		  	<select name="fattura" type="text">
				<option value="SI">Si</option>
				<option value="NO">No</option>
			</select>	   
		  </li>
		  
		  <li class="buttons">
			<input id="bn_modifica" class="button_text" type="submit" name="submit" value="Aggiungi Medico"/>
		 </li>
      </ul>
   </form>
	
</div>