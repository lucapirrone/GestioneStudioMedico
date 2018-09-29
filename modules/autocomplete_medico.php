





<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

<li class="fill fb-autocomplete form-group field-nome">
   <label class="description" for="element_1">Medico</label>
	
	<div class="auto-widget">
		<input type="text" id="input_medico"/>
		
		<input name="id_medico" id="id_medico" hidden>
	</div>
	
   <span>Seleziona Il Medico</span>         
</li>

<?php 
	$action_token = $_SESSION['action_token'] = md5(uniqid(mt_rand(), true));
?>

<script>
	

$(function() {

	$('#input_medico').autocomplete({
		
		source: function(request, response) {
            $.ajax({
				type: "POST",
                url: "index.php",
                data: { 
				    query: request.term,
					action_token: '<?php echo $action_token; ?>',
					action_code: 4,
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
			$("#input_medico").val(ui.item.label);
			$("#id_medico").val(ui.item.id);
		},
		
	});
});
	
</script>
