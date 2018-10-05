






<li class="fill fb-autocomplete form-group field-nome">
   <label class="description" for="element_1">Paziente</label>
	
	<div class="auto-widget">
		<input type="text" id="input_paziente"/>
		
		<input name="id_paziente" id="id_paziente" hidden>
	</div>
	
   <span>Seleziona il paziente</span>         
</li>

<?php 
	if(!isset($action_token))	$action_token = $_SESSION['action_token'] = md5(uniqid(mt_rand(), true));
?>

<script>
	

$(function() {

	$('#input_paziente').autocomplete({
		
		source: function(request, response) {
            $.ajax({
				type: "POST",
                url: "index.php",
                data: { 
				    query: request.term,
					action_token: '<?php echo $action_token; ?>',
					action_code: 2,
					action: 'request'
				}, 
                success: function (data) {
				
					var parsed = JSON.parse(data);
					var newArray = new Array(parsed.length);
					var i = 0;

					parsed.forEach(function (entry) {
						
						var newObject = {
							label: entry.label,
							id: entry.id,
							nome: entry.nome,
							cognome: entry.cognome,
							codicefiscale: entry.codicefiscale
						};
						newArray[i] = newObject;
						i++;
					});

					response(newArray);
				
				},
				error: function (message) {
					response([]);
				}
			});
        },
		select: function(event, ui) {
			event.preventDefault();
			console.log(ui);
			$("#input_paziente").val(ui.item.label);
			$("#id_paziente").val(ui.item.id);
		},
		
	});
});
	
</script>
