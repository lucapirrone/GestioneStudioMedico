<?php

	if(!(isset($paginaIntegra) && $paginaIntegra === true)) exit();

	include "action/gestisci-societa-esterna.php";

?>	

<div id="form_container">
	   <h2 class="title testo-grande">Nuovo Societa Esterna</h2>
   <form id="form_aggiungisocieta" class="form-style-7" action="" method="post">
      <ul id="form_info">
		  
		  <?php createInputToken(); ?>
				  
		<!-- RIGA 1 -->
  
		<li class="fill">
		   <label class="description" for="element_1">Nome</label>
		   <input name="nome" type="text"/>      
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

		<li class="fill" style="width: 20%">
		   <label class="description" for="element_1">Città</label>
		   <input name="citta" type="text"/> 
		</li>
		<li class="fill" style="width: 20%">
		   <label class="description" for="element_1">CAP</label>
		   <input name="cap" type="text"/> 
		</li>
		
		    <!-- RIGA 5 -->
		  
		<li class="fill" style="width: 50%;">
		   <label class="description" for="element_1">Codice Fiscale</label>
		   <input name="cod_fiscale" type="text"/> 
		</li>
	
	
		<li class="fill" style="width: 50%;">
		   <label class="description">Partita IVA</label>
		  <input name="p_iva" type="text"/>
	   </li>
		  
		  <li class="buttons">
			<input id="bn_modifica" class="button_text" type="submit" name="submit" value="Aggiungi Societa"/>
		 </li>
      </ul>
   </form>
	
</div>