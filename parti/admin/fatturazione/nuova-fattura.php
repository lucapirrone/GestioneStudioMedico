<?php

	if(!(isset($paginaIntegra) && $paginaIntegra === true)) exit();

	if(
		!((isset($_GET['id_paziente']) && $_GET['id_paziente']!="") || 
	   	(isset($_GET['id_medico']) && $_GET['id_medico']!="") || 
	   	(isset($_GET['id_societa']) && $_GET['id_societa']!=""))
	  ){
		include 'parti/seleziona_emittente_fattura.php';
	}else{
		
	if(isset($_GET['id_paziente'])){
		$paziente = new Paziente($conn);
		$paziente->selectPazienteById($_GET['id_paziente']);
		$tipo_dest = "id_paziente";
		$id_dest = $_GET['id_paziente'];
		$dest_fattura = new DestinatarioFattura($paziente->nome, $paziente->cognome, $paziente->data, $paziente->titolo, $paziente->indirizzo, $paziente->citta, $paziente->cap, $paziente->provincia,	$paziente->stato,	$paziente->tel_1,	$paziente->tel_2,	$paziente->cod_fiscale, $paziente->p_iva, $paziente->note, $paziente->email);
	}	
	if(isset($_GET['id_medico'])){
		$medico = new Medico($conn);
		$medico->selectMedicoById($_GET['id_medico']);
		$tipo_dest = "id_medico";
		$id_dest = $_GET['id_medico'];
		$dest_fattura = new DestinatarioFattura($medico->nome, $medico->cognome, null, $medico->titolo, $medico->indirizzo, $medico->citta, $medico->cap, $medico->prov, null, null, null,	$medico->cod_fiscale, $medico->p_iva, null, null);
	}	
	if(isset($_GET['id_societa'])){
		$societaesterna = new SocietaEsterna($conn);
		$societaesterna->selectSocietaEsternaById($_GET['id_societa']);
		$tipo_dest = "id_societa";
		$id_dest = $_GET['id_societa'];
		$dest_fattura = new DestinatarioFattura($societaesterna->nome, null, null, null, $societaesterna->indirizzo, $societaesterna->citta, $societaesterna->cap, $societaesterna->provincia,	null,	null, null,	$societaesterna->cod_fiscale, $societaesterna->p_iva, null, null);
	}
		
		
	if(!isset($_SESSION['action_token']) || !isset($action_token))	$action_token = $_SESSION['action_token'] = md5(uniqid(mt_rand(), true));
		
	if(!isset($_SESSION['token']) || !isset($token))	$token = $_SESSION['token'] = md5(uniqid(mt_rand(), true));
	
?>


		
<h2 class="title">Nuova Fattura</h2>

<form id="info_paziente" class="form-style-7 section" action="" method="post">
	
	<h2 class="title">Informazioni Destinatario Selezionato</h2>

	<ul>				
		<input type="hidden" name="<?php echo $tipo_dest; ?>" value="<?php echo $id_dest; ?>"/> 
	
		<li class="fill">
		   <label class="description" for="element_1">Paziente</label>
		   <input type="text" value="<?php echo $dest_fattura->nome." ".$dest_fattura->cognome; ?>" readonly/>      
		</li>
				
		<li class="fill">
		   <label class="description" for="element_1">Indirizzo</label>
		   <input type="text" value="<?php echo $dest_fattura->indirizzo; ?>" readonly/>      
		</li>
		
		<li class="fill" style="width: 20%">
		   <label class="description" for="element_1">Provincia</label>
		   <input type="text" value="<?php echo $dest_fattura->provincia; ?>" readonly/> 
		</li>
		<li class="fill" style="width: 60%">
		   <label class="description" for="element_1">Città</label>
		   <input type="text" value="<?php echo $dest_fattura->citta; ?>" readonly/> 
		</li>
		<li class="fill" style="width: 20%">
		   <label class="description" for="element_1">CAP</label>
		   <input type="text" value="<?php echo $dest_fattura->cap; ?>" readonly/> 
		</li>
		
		<li class="left">
		   <label class="description" for="element_1">Codice Fiscale</label>
		   <input type="text" value="<?php echo $dest_fattura->cod_fiscale; ?>" readonly/> 
		</li>
	
	
		<li class="right">
		   <label class="description">Partita IVA</label>
			<input type="text" value="<?php echo $dest_fattura->p_iva; ?>" readonly/>			
	   </li>
	
	
		<li class="left">
		   <label class="description" for="element_1">1° Telefono</label>
		   <input type="text" value="<?php echo $dest_fattura->tel_1; ?>" readonly/> 
		</li>
	
	
		<li class="right">
		   <label class="description">2° Telefono</label>
			<input type="text" value="<?php echo $dest_fattura->tel_2; ?>" readonly/>			
	   </li>
		
		
		<!-- INFORMAZIONI FATTURA FORM AGGIUNGI FATTURA -->
		
		
		<h2 class="title testo-grande">Informazioni Fattura</h2>

		<li class="fill" style="width: 50%; float: left;">
		   	<label class="description">Prestazione</label>
			<select class="element select big form-control" name="id_prestazione" id="prestazione">
				<option value="">SELEZIONA UNA PRESTAZIONE</option>
				<?php 
					$sp = new SearchPrestazioni($conn);
					$prestazioni = $sp->selezionaTutto();
					foreach($prestazioni as $p){
						echo '<option value="'.$p['id'].'">'.$p['nome'].'</option>';
					}
				?>
			</select>
	   	</li>
		<li class="left" style="width: 15%">
			<label class="description" for="element_1">IVA</label>
			<select class="element select big form-control" name="flag_iva" id="flag_iva">
				<option value="NO">No</option>
				<option value="SI">Si</option>
			</select>
		</li>
		<li class="left" style="width: 15%">
			<label class="description" for="element_1">Ritenuta D'acconto</label>
			<select class="element select big form-control" name="flag_ritenuta" id="flag_ritenuta">
				<option value="NO">No</option>
				<option value="SI">Si</option>
			</select>
		</li>
		<li class="fill" style="width:20%; float:left;">
		   <label class="description" for="element_1">Importo</label>
		   <input name="importo" type="text" id="importo"/> 
		</li>
		
		
		<li class="fill" style="width:80%; float:left;">
		   <label class="description" for="element_1">Descrizione (Viene visualizzato sulla fattura)</label>
		   <textarea name="descrizione" id="descrizione" class="form-control" style="width: 100%;"></textarea> 
		</li>
		<li class="fill" style="width:20%; float:left;">
		   <label class="description" for="element_1">Data Fattura</label>
		   <input type="date" class="form-control" id="data_fat" name="data_fat" value="<?php echo date('Y-m-d'); ?>" step="1" required/>
		</li>

		
		<?php
		
		$sm = new SearchMedico($conn);
		$medici = $sm->selezionaTutto();
		
		?>
		
		<div id="box_medici_scelti" class="fill" style="width: 70%; float: right; display: none">
		   	<label class="description" for="element_1">Figure Selezionate</label>
			<li class="fill hidden">
				<select class="element select big form-control" name="id_medico_1" id="id_medico_1">
					<option value="-1">SELEZIONA FIGURA</option>
					<?php
						foreach($medici as $m){
							echo '<option value="'.$m['id'].'">'.$m['nome'].'</option>';
						}
					?>
				</select>
			</li>
			<li class="fill hidden">
				<select class="element select big form-control" name="id_medico_2" id="id_medico_2">
					<option value="-1">SELEZIONA FIGURA</option>
					<?php
						foreach($medici as $m){
							echo '<option value="'.$m['id'].'">'.$m['nome'].'</option>';
						}
					?>
				</select>
			</li>
			<li class="fill hidden">
				<select class="element select big form-control" name="id_medico_3" id="id_medico_3">
					<option value="-1">SELEZIONA FIGURA</option>
					<?php
						foreach($medici as $m){
							echo '<option value="'.$m['id'].'">'.$m['nome'].'</option>';
						}
					?>
				</select>
			</li>
			<li class="fill hidden">
				<select class="element select big form-control" name="id_medico_4" id="id_medico_4">
					<option value="-1">SELEZIONA FIGURA</option>
					<?php
						foreach($medici as $m){
							echo '<option value="'.$m['id'].'">'.$m['nome'].'</option>';
						}
					?>
				</select>
			</li>
			<li class="fill hidden">
				<select class="element select big form-control" name="id_medico_5" id="id_medico_5">
					<option value="-1">SELEZIONA FIGURA</option>
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
				<input type="text" readonly class="view form-control" id="prev_medico_1" style="text-align: center"/>
			</li>
			<li class="fill hidden">
				<input type="text" readonly class="view form-control" id="prev_medico_2" style="text-align: center"/>
			</li>
			<li class="fill hidden">
				<input type="text" readonly class="view form-control" id="prev_medico_3" style="text-align: center"/>
			</li>
			<li class="fill hidden">
				<input type="text" readonly class="view form-control" id="prev_medico_4" style="text-align: center"/>
			</li>
			<li class="fill hidden">
				<input type="text" readonly class="view form-control" id="prev_medico_5" style="text-align: center"/>
			</li>
		</div>

		
		 <li class="buttons">
            <input id="aggiungi_prest" class="btn btn-light" type="button" name="add_prest" value="Aggungi Prestazione" />
         </li>
		
		
		
				<!-- INFORMAZIONI FATTURA FORM AGGIUNGI FATTURA -->
		
		
		<h2 class="title testo-grande">Lista Fatture</h2>

		<li class="fill">
			
			<div class="table-responsive">
				<table id="table" class="table table-striped table-bordered table-hover">
				 	<thead>
						<tr>
							<th>Prestazione</th>
							<th>Descrizione</th>
						  	<th>Data</th>
						  	<th>Importo</th>
						  	<th>Opzioni</th>
						</tr>
					</thead>
					<tbody id="tbody">
					
					</tbody>
				</table>
			</div>
			
		</li>
		
		 <li class="buttons">
            <input id="salva_prest" class="btn btn-light" type="button" name="salva_prest" value="Salva Fatture" />
         </li>
		
	</ul>
		
</form> 
<script>
	
	var num_fatture = 0;
	var array_descrizione = [];
	var array_id_prestazione = [];
	var array_flag_iva = [];
	var array_flag_ritenuta = [];
	var array_importo = [];
	var array_data_fat = [];
	var array_id_medico_1 = [];
	var array_id_medico_2 = [];
	var array_id_medico_3 = [];
	var array_id_medico_4 = [];
	var array_id_medico_5 = [];
	
	function deleteRow(i){
		$("#row_"+i).remove();
		
		array_descrizione.splice(i, 1);
		array_id_prestazione.splice(i, 1);
		array_flag_iva.splice(i, 1);
		array_flag_ritenuta.splice(i, 1);
		array_importo.splice(i, 1);
		array_data_fat.splice(i, 1);
		array_id_medico_1.splice(i, 1);
		array_id_medico_2.splice(i, 1);
		array_id_medico_3.splice(i, 1);
		array_id_medico_4.splice(i, 1);
		array_id_medico_5.splice(i, 1);
		
		num_fatture -= 1;
	}

	$("#salva_prest").on("click", function(){
		
		for(var i = 0; i<=num_fatture-1; i++){
			console.log("ciclo: "+i);
			
			$.ajax({
				async: false,
				dataType: "json",
				url:'index.php',
				type:'post',
				data: {
					action_token: '<?php echo $action_token; ?>',
					action_code: 6,
					action: 'request',
					token: '<?php echo $token; ?>',
					<?php echo $tipo_dest.": ".$id_dest; ?>,
					num_fatture: num_fatture[i],
					descrizione: array_descrizione[i],
					id_prestazione: array_id_prestazione[i],
					id_medico_1: array_id_medico_1[i],
					id_medico_2: array_id_medico_2[i],
					id_medico_3: array_id_medico_3[i],
					id_medico_4: array_id_medico_4[i],
					id_medico_5: array_id_medico_5[i],
					importo: array_importo[i],
					flag_iva: array_flag_iva[i],
					flag_ritenuta: array_flag_ritenuta[i],
					data_fat: array_data_fat[i]
				},
				success:function(response){
					console.log("success: "+i);
					if(response.code==200){
						var url = "<?php echo $url = "?action=request&action_code=3&action_token=".$action_token."&id_fattura=";?>"+response.id_fattura;
						var btn_open =
							"<a href=\""+url+"\" target=\"_href\" style=\"color:#333;font-size:14px;\">"+
							"<i class=\"far fa-eye\" style=\"margin:0 5px 0 20px;\"></i>"+
							"Visualizza Fattura"+
							"</a>";

						$("#open_"+i).append(btn_open);
						$("#open_"+i).attr('id', "open_"+i+"_completed");
						$("#row_"+i).attr('id', "row_"+i+"_completed");
					}
				}
			});
		}
		
		num_fatture = 0;
		array_descrizione = [];
		array_id_prestazione = [];
		array_flag_iva = [];
		array_flag_ritenuta = [];
		array_importo = [];
		array_data_fat = [];
		array_id_medico_1 = [];
		array_id_medico_2 = [];
		array_id_medico_3 = [];
		array_id_medico_4 = [];
		array_id_medico_5 = [];

	});
	
	$("#aggiungi_prest").on("click", function(){
		array_descrizione.push($("#descrizione").val());
		array_id_prestazione.push($("#prestazione").val());
		array_flag_iva.push($("#flag_iva").val());
		array_flag_ritenuta.push($("#flag_ritenuta").val());
		array_importo.push($("#importo").val());
		array_data_fat.push($("#data_fat").val());
		array_id_medico_1.push($("#id_medico_1").val());
		array_id_medico_2.push($("#id_medico_2").val());
		array_id_medico_3.push($("#id_medico_3").val());
		array_id_medico_4.push($("#id_medico_4").val());
		array_id_medico_5.push($("#id_medico_5").val());
		
		
		var newElement = 
			"<tr id=\"row_"+num_fatture+"\">"+
			"<td>"+$("#prestazione option:selected").text()+"</td>"+
			"<td>"+$("#descrizione").val()+"</td>"+
			"<td>"+$("#data_fat").val()+"</td>"+
			"<td>"+$("#importo").val()+"</td>"+
			"<td id=\"open_"+num_fatture+"\"><i class=\"fas fa-trash\" onclick=\"deleteRow("+num_fatture+")\"></i></td>"+
			"</tr>";
		
		$('#tbody').append(newElement);
		
		var now = new Date();

		var day = ("0" + now.getDate()).slice(-2);
		var month = ("0" + (now.getMonth() + 1)).slice(-2);

		var today = now.getFullYear()+"-"+(month)+"-"+(day) ;

		
		$("#descrizione").val("");
		$("#prestazione").val("");
		$("#flag_iva").val("NO");
		$("#flag_ritenuta").val("NO");
		$("#importo").val("");
		$("#data_fat").val(today);
		$("#id_medico_1").val("-1");
		$("#id_medico_2").val("-1");
		$("#id_medico_3").val("-1");
		$("#id_medico_4").val("-1");
		$("#id_medico_5").val("-1");
		
		num_fatture += 1;
	});
	
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
						$('#descrizione').val($("#prestazione option:selected").text());
						if(response.info.medico_1!=null){
							$('#prev_medico_1').show();
							$('#id_medico_1').show();
							$('#prev_medico_1').val(response.info.medico_1);
						}else{
							$('#prev_medico_1').hide();
							$('#id_medico_1').hide();
						}
						if(response.info.medico_2!=null){
							$('#prev_medico_2').show();
							$('#id_medico_2').show();
							$('#prev_medico_2').val(response.info.medico_2);
						}else{
							$('#prev_medico_2').hide();
							$('#id_medico_2').hide();
						}
						if(response.info.medico_3!=null){
							$('#prev_medico_3').show();
							$('#id_medico_3').show();
							$('#prev_medico_3').val(response.info.medico_3);
						}else{
							$('#prev_medico_3').hide();
							$('#id_medico_3').hide();
						}
						if(response.info.medico_4!=null){
							$('#prev_medico_4').show();
							$('#id_medico_4').show();
							$('#prev_medico_4').val(response.info.medico_4);
						}else{
							$('#prev_medico_4').hide();
							$('#id_medico_4').hide();
						}
						if(response.info.medico_5!=null){
							$('#prev_medico_5').show();
							$('#id_medico_5').show();
							$('#prev_medico_5').val(response.info.medico_5);
						}else{
							$('#prev_medico_5').hide();
							$('#id_medico_5').hide();
						}
					}
				}
		});
						

	});

</script>

<?php } ?>
