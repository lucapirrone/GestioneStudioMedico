<?php

	if(!(isset($paginaIntegra) && $paginaIntegra === true)) exit();

	include "action/gestisci-movimento.php";

	if(isset($_GET['id_movimento'])){
		
		$mov = new Movimento($conn);
		$mov->selectMovimentoById($_GET['id_movimento']);

		if($mov->dare>$mov->avere){
			$verso = "USCITA";
			$importo = $mov->dare;
		}else{
			$verso = "ENTRATA";
			$importo = $mov->avere;
		}
		
?>	

<div id="form_container">
	   <h2 class="title testo-grande">Modifica Movimento</h2>
   <form id="form_aggiungimedico" class="form-style-7" action="" method="post">
      <ul id="form_info">
		  
		  <?php createInputToken(); ?>
		
		  <input name="id" value="<?php echo $_GET['id_movimento']; ?>" type="hidden"/>
		  
		<li class="fill" style="width: 50%;">
		   <label class="description" for="element_1">Intestatario</label>
		   <input name="intestatario" type="text" value="<?php echo $mov->intestatario; ?>" required/>      
		</li>	
		  		
		<li class="fill" style="width: 50%;">
		   <label class="description" for="element_1">Descrizione</label>
		   <input name="descrizione" type="text" value="<?php echo $mov->descrizione; ?>" required/>      
		</li>	
		  
	    <li class="fill" style="width: 30%;">
		   <label class="description" for="element_1">Data Movimento</label>
			<input type="date" name="data_mov" value="<?php echo date('d/m/Y', $mov->data_mov); ?>" step="1" required/>
			
		</li>
		  
		<li class="fill" style="width:40%;">
		   <label class="description" for="element_1">Tipo di Pagamento</label>
			<input type="text" name="tipo_pagamento" value="<?php echo $mov->tipo_pagamento; ?>" required/>
		</li> 
		  
		<li class="fill" style="width: 20%;">
		   <label class="description" for="element_1">Movimento in</label>
		  	<select name="verso" type="text required">
				<option value="<?php echo $verso; ?>"><?php echo $verso; ?></option>
				<option value="ENTRATA">Entrata</option>
				<option value="USCITA">Uscita</option>
			</select>  		
		</li>	
		  
		<li class="fill" style="width:10%;">
		   <label class="description" for="element_1">Importo</label>
			<input type="text" name="importo" value="<?php echo $importo; ?>" required/>
		</li> 
		  
		   
		  <li class="buttons">
			<input id="bn_modifica" class="btn btn-light" type="submit" name="submit" value="Salva Movimento"/>
		 </li>
		  
		</ul>
   </form>
	
</div>

<?php } ?>