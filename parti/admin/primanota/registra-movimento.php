<?php

	if(!(isset($paginaIntegra) && $paginaIntegra === true)) exit();

	include "action/gestisci-movimento.php";

?>	

<div id="form_container">
	   <h2 class="title testo-grande">Registra Movimento</h2>
   <form id="form_aggiungimedico" class="form-style-7" action="" method="post">
      <ul id="form_info">
		  
		  <?php createInputToken(); ?>
		
		  
		<li class="fill" style="width: 50%;">
		   <label class="description" for="element_1">Intestatario</label>
		   <input name="intestatario" type="text" required/>      
		</li>	
		  		
		<li class="fill" style="width: 50%;">
		   <label class="description" for="element_1">Descrizione</label>
		   <input name="descrizione" type="text" required/>      
		</li>	
		 
		  
		  
		  
	    <li class="fill" style="width: 30%;">
		   <label class="description" for="element_1">Data Movimento</label>
			<input type="date" name="data_mov" required/>
			
		</li>
		  
		<li class="fill" style="width:40%;">
		   <label class="description" for="element_1">Tipo di Pagamento</label>
			<input type="text" name="tipo_pagamento" required/>
		</li> 
		  
		<li class="fill" style="width: 20%;">
		   <label class="description" for="element_1">Movimento in</label>
		  	<select name="verso" type="text required">
				<option value="">Seleziona una voce</option>
				<option value="ENTRATA">Entrata</option>
				<option value="USCITA">Uscita</option>
			</select>  		
		</li>	
		  
		<li class="fill" style="width:10%;">
		   <label class="description" for="element_1">Importo</label>
			<input type="text" name="importo" required/>
		</li> 
		  
		   
		  <li class="buttons">
			<input id="bn_modifica" class="btn btn-light" type="submit" name="submit" value="Salva Movimento"/>
		 </li>
		  
		</ul>
   </form>
	
</div>