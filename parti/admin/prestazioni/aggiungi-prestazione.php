<?php

	if(!(isset($paginaIntegra) && $paginaIntegra === true)) exit();

	include "action/gestisci-prestazione.php";

?>

<div id="form_container">
   <form id="form_aggiungipaziente" class="form-style-7" action="" method="post">
	 				  
		<!-- RIGA 1 -->
			   
	   <li class="fill" style="width: 50%; float: left;">
		   	<label class="description">Prestazione</label>
			<input name="nome" type="text" id="nome"/> 
	   </li>
	   
	   <li class="fill" style="width: 30%; float: left;">
		   <label class="description">Fattura</label>
			<select name="fatturato" type="text" class="form-control">
				<option value="ARTEMIDE">ARTEMIDE</option>
				<option value="MEDICO">MEDICO</option>
			</select>  
		  
	  </li>
	   
	   <li class="fill" style="width:20%; float:left;">
		   <label class="description" for="element_1">Importo</label>
		   <input name="importo" type="text" id="importo"/> 
		</li>
	   
	   	   
	   <div id="box_medici_prev" class="fill" style="width: 70%; float: left">
		   	<label class="description" for="element_1">Figure Previste</label>
			
			<li class="fill hidden">
				<select type="text" class="form-control" name="medico_1">
					<option value="">NESSUNO</option>
					<option value="ARTEMIDE">ARTEMIDE</option>
					<option value="MEDICO">MEDICO</option>
					<option value="COLLABORATORE">COLLABORATORE</option>
				</select>     
			</li>
			<li class="fill hidden">
				<select type="text" class="form-control" name="medico_2">
					<option value="">NESSUNO</option>
					<option value="ARTEMIDE">ARTEMIDE</option>
					<option value="MEDICO">MEDICO</option>
					<option value="COLLABORATORE">COLLABORATORE</option>
				</select>  
			</li>
			<li class="fill hidden">
				<select type="text" class="form-control" name="medico_3">
					<option value="">NESSUNO</option>
					<option value="ARTEMIDE">ARTEMIDE</option>
					<option value="MEDICO">MEDICO</option>
					<option value="COLLABORATORE">COLLABORATORE</option>
				</select>     
			</li>
			<li class="fill hidden">
				<select type="text" class="form-control" name="medico_4">
					<option value="">NESSUNO</option>
					<option value="ARTEMIDE">ARTEMIDE</option>
					<option value="MEDICO">MEDICO</option>
					<option value="COLLABORATORE">COLLABORATORE</option>
				</select>     
			</li>
			<li class="fill hidden">
				<select type="text" class="form-control" name="medico_5">
					<option value="">NESSUNO</option>
					<option value="ARTEMIDE">ARTEMIDE</option>
					<option value="MEDICO">MEDICO</option>
					<option value="COLLABORATORE">COLLABORATORE</option>
				</select>     
			</li>
		</div>
	   
	   <div id="box_perc_prev" class="fill" style="width: 30%; float: left">
		   	<label class="description" for="element_1">Percentuale</label>
			
			<li class="fill hidden">
				<input type="text" class="view" name="perc_medico_1"/>
			</li>
			<li class="fill hidden">
				<input type="text" class="view" name="perc_medico_2"/>
			</li>
			<li class="fill hidden">
				<input type="text" class="view" name="perc_medico_3"/>
			</li>
			<li class="fill hidden">
				<input type="text" class="view" name="perc_medico_4"/>
			</li>
			<li class="fill hidden">
				<input type="text" class="view" name="perc_medico_5"/>
			</li>
		</div>

	    <li class="buttons">
			<input id="bn_modifica" class="button_text" type="submit" name="submit" value="Salva Prestazione"/>
		 </li>
	   
      </ul>
   </form>
	
</div>