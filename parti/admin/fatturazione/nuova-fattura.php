<?php

	if(!(isset($paginaIntegra) && $paginaIntegra === true)) exit();


	if(!isset($_GET['id_paziente'])){
		include 'parti/seleziona_paziente.php';
	}else{
		
	$paziente = new Paziente($conn);
	$paziente->selectPazienteById($_GET['id_paziente']);
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

		
<h2 class="title testo-grande">Informazioni Paziente Selezionato<i class="delete fas fa-edit" style="float: right" title="Modifica" id="modifica_anagrafica"></i></h2></h2>

<form id="info_paziente" class="form-style-7" action="" method="post">
	<ul>		
		<script>
		$('#modifica_anagrafica').on("click", function(){

			<?php

			$query = $_GET;
			// replace parameter(s)
			$query['page'] = 'modifica-paziente';
			$query['id_paziente'] = $_GET['id_paziente'];
			// rebuild url
			$query_result = http_build_query($query);

			?>
			window.location.replace("?<?php echo $query_result; ?>");

		});

	</script>
	
		<?php 
		$action_token = $_SESSION['action_token'] = md5(uniqid(mt_rand(), true));
		?>
			  
		<input type="hidden" name="action_token" value="<?php echo $action_token; ?>"/> 
	
		<input type="hidden" name="action_code" value="6"/> 
		
		<input type="hidden" name="action" value="request"/> 
	
		<li class="fill" style="width: 90%;">
		   <label class="description" for="element_1">Paziente</label>
		   <input type="text" value="<?php echo $paziente->nome." ".$paziente->cognome; ?>" readonly/>      
		</li>
		<li class="fill" style="width: 10%;">
		   <label class="description" for="element_1">ID Paziente</label>
		   <input name="id_paziente" type="text" value="<?php echo $paziente->id; ?>" readonly/>      
		</li>
		
		<li class="fill">
		   <label class="description" for="element_1">Indirizzo</label>
		   <input type="text" value="<?php echo $paziente->indirizzo; ?>" readonly/>      
		</li>
		
		<li class="fill" style="width: 20%">
		   <label class="description" for="element_1">Provincia</label>
		   <input type="text" value="<?php echo $paziente->provincia; ?>" readonly/> 
		</li>
		<li class="fill" style="width: 60%">
		   <label class="description" for="element_1">Città</label>
		   <input type="text" value="<?php echo $paziente->citta; ?>" readonly/> 
		</li>
		<li class="fill" style="width: 20%">
		   <label class="description" for="element_1">CAP</label>
		   <input type="text" value="<?php echo $paziente->cap; ?>" readonly/> 
		</li>
		
		<li class="left">
		   <label class="description" for="element_1">Codice Fiscale</label>
		   <input type="text" value="<?php echo $paziente->cod_fiscale; ?>" readonly/> 
		</li>
	
	
		<li class="right">
		   <label class="description">Partita IVA</label>
			<input type="text" value="<?php echo $paziente->p_iva; ?>" readonly/>			
	   </li>
	
	
		<li class="left">
		   <label class="description" for="element_1">1° Telefono</label>
		   <input type="text" value="<?php echo $paziente->tel_1; ?>" readonly/> 
		</li>
	
	
		<li class="right">
		   <label class="description">2° Telefono</label>
			<input type="text" value="<?php echo $paziente->tel_2; ?>" readonly/>			
	   </li>
		
		
		
		<h2 class="title testo-grande">Informazioni Fattura</h2>

		<li class="fill" style="width: 50%; float: right;">
		   	<label class="description">Prestazione</label>
			<select class="element select big" name="id_prestazione" id="prestazione">
				<option></option>
				<?php 
					$sp = new SearchPrestazioni($conn);
					$prestazioni = $sp->selezionaTutto();
					foreach($prestazioni as $p){
						echo '<option value="'.$p['id'].'">'.$p['nome'].'</option>';
					}
				?>
			</select>
	   	</li>
		
		<li class="fill" style="width:20%; float:left;">
		   <label class="description" for="element_1">Importo</label>
		   <input name="importo" type="text" id="importo"/> 
		</li>
	
			
	
			<li class="left" style="width: 15%">
				<label class="description" for="element_1">IVA</label>
				<select class="element select big" name="flag_iva">
					<option value="NO">No</option>
					<option value="SI">Si</option>
				</select>
			</li>
	
			<li class="left" style="width: 15%">
				<label class="description" for="element_1">Ritenuta D'acconto</label>
				<select class="element select big" name="flag_ritenuta">
					<option value="NO">No</option>
					<option value="SI">Si</option>
				</select>
			</li>
		
		
		<?php
		
		$sm = new SearchMedico($conn);
		$medici = $sm->selezionaTutto();
		
		?>
		
		<div id="box_medici_scelti" class="fill" style="width: 70%; float: right; display: none">
		   	<label class="description" for="element_1">Figure Selezionate</label>
			<li class="fill hidden">
				<select class="element select big" name="id_medico_1" id="id_medico_1">
					<option value="null">SELEZIONA FIGURA</option>
					<?php
						foreach($medici as $m){
							echo '<option value="'.$m['id'].'">'.$m['nome'].'</option>';
						}
					?>
				</select>
			</li>
			<li class="fill hidden">
				<select class="element select big" name="id_medico_2" id="id_medico_2">
					<option value="">SELEZIONA FIGURA</option>
					<?php
						foreach($medici as $m){
							echo '<option value="'.$m['id'].'">'.$m['nome'].'</option>';
						}
					?>
				</select>
			</li>
			<li class="fill hidden">
				<select class="element select big" name="id_medico_3" id="id_medico_3">
					<option value="">SELEZIONA FIGURA</option>
					<?php
						foreach($medici as $m){
							echo '<option value="'.$m['id'].'">'.$m['nome'].'</option>';
						}
					?>
				</select>
			</li>
			<li class="fill hidden">
				<select class="element select big" name="id_medico_4" id="id_medico_4">
					<option value="">SELEZIONA FIGURA</option>
					<?php
						foreach($medici as $m){
							echo '<option value="'.$m['id'].'">'.$m['nome'].'</option>';
						}
					?>
				</select>
			</li>
			<li class="fill hidden">
				<select class="element select big" name="id_medico_5" id="id_medico_5">
					<option value="">SELEZIONA FIGURA</option>
					<?php
						foreach($medici as $m){
							echo '<option value="'.$m['id'].'">'.$m['nome'].'</option>';
						}
					?>
				</select>
			</li>
		</div>
	
		<div id="box_medici_prev" class="fill" style="width: 30%; float: left; display: none">
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

		
		 <li class="buttons">
            <input id="salva_prestazione" class="button_text" type="submit" name="submit" value="Salva Prestazione" />
         </li>
	</ul>
		
</form> 
<script>
	
	$('#prestazione').on('change', function (e) {		
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
						$('#box_medici_scelti').show();
						$('#importo').val(response.info.importo);
						$('#prev_medico_1').val(response.info.medico_1);
						$('#prev_medico_2').val(response.info.medico_2);
						$('#prev_medico_3').val(response.info.medico_3);
						$('#prev_medico_4').val(response.info.medico_4);
						$('#prev_medico_5').val(response.info.medico_5);
					}
				}
		});
						

	});

</script>

<?php } ?>
