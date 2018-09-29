<?php

	if(!(isset($paginaIntegra) && $paginaIntegra === true)) exit();

?>
<?php

//Questa pagina permette di aggiungere un referto associato ad un paziente identificato tramite codice fiscale. Al click del bottone per aggiungere, si controlla la validità dei dati inseriti (nome, file, tipo...) e si inviano allo script programmareferto.php



?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>


<form id="form_nuovavisita" class="form-style-7" action="" method="post">
	<ul>
		
		<?php createInputToken(); ?>
				
		<input type="hidden" name="action_code" value="1"/> 
		
		<input type="hidden" name="action" value="request"/> 

		
		 <?php require 'modules/autocomplete_codicefiscale.php'; ?>

		<li class="left">
			   <label class="description" for="element_1">Data Visita <a style="color: red;">*</a></label>
			   <input type="date" class="form-control" id="input_data" name="data" value="<?php echo date('Y-m-d'); ?>" required/>
			   <span>Inserisci data visita</span>         
		 </li>
		
		<li class="right">
		   <label class="description">Tipo di Visita <a style="color: red;">*</a></label>
				<input type="text" id="custom_type" name="tipo" class="form-control" maxlength="100" placeholder="Inserisci il tipo di visita" required/>
	   	   <span>Inserisci il Tipo di Visita</span>
			
	   </li>
		
		<li class="fill">
			   <label class="description" for="element_1">Note</label>
			   <textarea type="text" class="form-control" id="input_note" name="note" style="height: 100px;"></textarea>
			   <span>Inserisci Note</span>         
		 </li>
		 <li class="buttons">
            <input id="saveForm" class="button_text" type="button" name="submit" onclick="submitForm();" value="Aggiungi Visita" />
         </li>
	</ul>
		
</form> 
<script>
	
	function submitForm(){
		
		var newWindow = window.open("","_blank");
		var data = $('#form_nuovavisita').serializeArray();
		if($('#input_codicefiscale').val()==""){
			alert("Inerisci il codice fiscale del paziente");
		}else{
			$.ajax({
				dataType: "json",
				url:'index.php',
				type:'post',
				data: data,
				success:function(response){
					if(response.code===200){
						
						newWindow.location.href = ("?"+response.url);

						alert("Visita aggiunta correttamente! Ora verrà aperto il foglio da stampare al paziente per permettergli l'accesso alla piattaforma una volta caricato il referto. Si ricorda che il referto sarà disponibile per 45 giorni dal caricamento del referto.");


					}else if(response.code===300){
						prompt("Il paziente non è presente nel sistema, aggiungerlo automaticamente? \nInserisci l'email del paziente (facoltativo)");

						$("#btn-ok").on("click", function(){
							data[data.length] = { name: "auto_add", value: "ok" };
							data[data.length] = { name: "auto_add_email", value: $("#prompt-textbox").val() };
							$.ajax({
								dataType: "json",
								url:'index.php',
								type:'post',
								data: data,
								success:function(response){
									if(response.code===200){
										newWindow.location.href = ("?"+response.url);

										alert("Visita aggiunta correttamente! Ora verrà aperto il foglio da stampare al paziente per permettergli l'accesso alla piattaforma una volta caricato il referto. Si ricorda che il referto sarà disponibile per 45 giorni dal caricamento del referto.");
									}else{
										alert("Si è verificato un errore nell'aggiunta della visita\n"+response['code']+": "+response['message']);
									}
								}
							});
						});
					}
					else{
						alert("Si è verificato un errore nell'aggiunta della visita\n"+response['code']+": "+response['message']);
					}
				}
			});
		}
		
	};

</script>
