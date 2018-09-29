<?php

	if(!(isset($paginaIntegra) && $paginaIntegra === true)) exit();

	$action_token = $_SESSION['action_token'] = md5(uniqid(mt_rand(), true));

	?>


<div id="form_container">
   <form id="form_aggiungipaziente" class="form-style-7">
	 				  
		<!-- RIGA 1 -->
	   
	   <li class="fill hidden" style="width: unset;"> 
	   		<i class="delete fas fa-edit" style="float: right; display: none" title="Modifica" id="modifica_prestazione"></i>
	   </li>
		
	   <li class="fill" style="width: 50%; float: right;">
		   	<label class="description">Prestazione</label>
			<select class="element select big" name="id_prestazione" id="prestazione">
				<option value="">SELEZIONA LA PRESTAZIONE</option>
				<?php 
					$sp = new SearchPrestazioni($conn);
					$prestazioni = $sp->selezionaTutto();
					foreach($prestazioni as $p){
						echo '<option value="'.$p['id'].'">'.$p['nome'].'</option>';
					}
				?>
			</select>
	   	</li>
	   
	    <li class="fill" style="30%">
		   <label class="description">Fattura</label>
			<input name="fatturato" type="text" id="fatturato"/> 
		  
	  </li>
	   
	   <li class="fill" style="width:20%; float:left;">
		   <label class="description" for="element_1">Importo</label>
		   <input name="importo" type="text" id="importo"/> 
		</li>
	   
	   <div id="box_medici_prev" class="fill" style="width: 70%; float: left; display: none">
		   	<label class="description" for="element_1">Figure Previste</label>
			
			<li class="fill hidden">
				<input type="text" readonly class="view" id="prev_medico_1"/>
			</li>
			<li class="fill hidden">
				<input type="text" readonly class="view" id="prev_medico_2"/>
			</li>
			<li class="fill hidden">
				<input type="text" readonly class="view" id="prev_medico_3"/>
			</li>
			<li class="fill hidden">
				<input type="text" readonly class="view" id="prev_medico_4"/>
			</li>
			<li class="fill hidden">
				<input type="text" readonly class="view" id="prev_medico_5"/>
			</li>
		</div>
	   
	   <div id="box_perc_prev" class="fill" style="width: 30%; float: left; display: none">
		   	<label class="description" for="element_1">Percentuale</label>
			
			<li class="fill hidden">
				<input type="text" readonly class="view" id="prev_perc_1"/>
			</li>
			<li class="fill hidden">
				<input type="text" readonly class="view" id="prev_perc_2"/>
			</li>
			<li class="fill hidden">
				<input type="text" readonly class="view" id="prev_perc_3"/>
			</li>
			<li class="fill hidden">
				<input type="text" readonly class="view" id="prev_perc_4"/>
			</li>
			<li class="fill hidden">
				<input type="text" readonly class="view" id="prev_perc_5"/>
			</li>
		</div>

	   
      </ul>
   </form>
	
	
<script>
	
	$('#modifica_prestazione').on("click", function(){

		window.location.replace("?page=modifica-prestazione&id_prestazione="+$("#prestazione").val());

	});
	
	
	$('#prestazione').on('change', function (e) {	
		console.log("asd");
		$.ajax({
				dataType: "json",
				url:'index.php',
				type:'post',
				data: {
					id: $("#prestazione").val(),
					action_token: '<?php echo $action_token; ?>',
					action_code: 1,
					action: 'request'
				},
				success:function(response){
					if(response.code===200){
						$('#box_medici_prev').show();
						$('#box_perc_prev').show();
						$('#box_medici_scelti').show();
						$('#modifica_prestazione').show();
						$('#importo').val(response.info.importo);
						$('#fatturato').val(response.info.fatturato);
						$('#prev_medico_1').val(response.info.medico_1);
						$('#prev_medico_2').val(response.info.medico_2);
						$('#prev_medico_3').val(response.info.medico_3);
						$('#prev_medico_4').val(response.info.medico_4);
						$('#prev_medico_5').val(response.info.medico_5);
						$('#prev_perc_1').val(response.info.perc_1);
						$('#prev_perc_2').val(response.info.perc_2);
						$('#prev_perc_3').val(response.info.perc_3);
						$('#prev_perc_4').val(response.info.perc_4);
						$('#prev_perc_5').val(response.info.perc_5);
					}
				}
		});
						

	});
	
</script>
	
	
</div>

