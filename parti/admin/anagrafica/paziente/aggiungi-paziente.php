<?php

	if(!(isset($paginaIntegra) && $paginaIntegra === true)) exit();

	include "action/gestisci-paziente.php";

?>	


<div id="form_container">
   <h2 class="title testo-grande">Nuovo Paziente</h2>

   <form id="form_aggiungipaziente" class="form-style-7" method="post" action="">
      <ul id="form_info">
		
	 	<?php createInputToken(); 	?>
		  
		<!-- RIGA 1 -->
		  
		<li class="fill" style="width: 10%; padding-right: 10px; padding-left: 10px;">
		   <label class="description" for="element_1">Titolo</label>
		  	<select name="titolo" type="text">
				<option value="SIG">Sig</option>
				<option value="SIG.RA">Sig.ra</option>
			</select> 
		  </li>
		  
		<li class="fill" style="width: 30%;">
		   <label class="description" for="element_1">Cognome</label>
		   <input name="cognome" type="text"/>      
		</li>	
		<li class="fill" style="width: 30%; padding-right: 10px; padding-left: 10px; ">
		   <label class="description" for="element_1">Nome</label>
		   <input name="nome" type="text"/>   
		</li>
		 		  
		  
		<li class="fill" style="width: 10%;">
		   <label class="description" for="element_1">Sesso</label>
		  	<select name="sesso" type="text">
				<option value="M">Uomo</option>
				<option value="F">Donna</option>
				<option value="A">Altro</option>
			</select>     
		</li>
		  
	  <li class="fill" style="width: 20%;">
		   <label class="description" for="element_1">Data di nascita</label>
			<input type="date"  name="data" step="1" required/>
			
		</li>
		  <!-- RIGA 3 -->
		  
		  		  
		<li class="fill" style="width: 10%">
		   <label class="description" for="element_1">Privacy</label>
		  	<select name="privacy" type="text">
				<option value="SI">Si</option>
				<option value="NO">No</option>
			</select>	   
		</li>
		  
		<li class="fill" style="width: 55%">
		   <label class="description" for="element_1">Indirizzo</label>
		   <input name="indirizzo" type="text"/>      
		</li>
		  
		<li class="fill" style="width: 35%">
		   <label class="description" for="element_1">Stato</label>
		   <input name="stato" type="text"/> 
		</li>
		  
		  <!-- RIGA 4 -->

		  
		<li class="fill" style="width: 20%">
		   <label class="description" for="element_1">Provincia</label>
		   <input name="provincia" type="text"/> 
		</li>
		  
		  
		<li class="fill" style="width: 60%">
		   <label class="description" for="element_1">Città</label>
		   <input name="citta" type="text"/> 
		</li>
		<li class="fill" style="width: 20%">
		   <label class="description" for="element_1">CAP</label>
		   <input name="cap" type="text"/> 
		</li>
		
		    <!-- RIGA 5 -->
		  
		<li class="left">
		   <label class="description" for="element_1">Codice Fiscale</label>
		   <input name="cod_fisc" type="text"/> 
		</li>
	
	
		<li class="right">
		   <label class="description">Partita IVA</label>
			<input name="p_iva" type="text"/>			
	   </li>
	
		    <!-- RIGA 6 -->
	<li class="fill" style="width: 33%;">
		   <label class="description" for="element_1">1° Telefono</label>
		   <input name="tel_1" type="text"/> 
		</li>
	
	
		<li class="fill" style="width: 33%;">
		   <label class="description">Email</label>
			<input name="email" type="text"/>			
	   </li>
		  
		<li class="fill" style="width: 33%;">
		   <label class="description">2° Telefono</label>
			<input name="tel_2" type="text"/>			
	   </li>	
		  
		<li class="fill">
		   <label class="description">Note</label>
			<input name="note" type="text"/>			
	   </li>
		  
		  
		  <li class="buttons">
			<input id="bn_modifica" class="button_text" type="submit" name="submit" value="Salva Anagrafica"/>
		 </li>
      </ul>
   </form>
	
</div>