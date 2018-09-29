
$(document).ready(function () {

	var action_val = null;
	
	if(requestPage=="aggiungi-paziente") action_val = "aggiungi";
	else if (requestPage=="gestisci-paziente") action_val = "modifica";	

    $('#saveForm').click(function(e){
		if($('input[name=codicefiscale]').val()!=""){
			var data = $('#form_aggiungipaziente').serializeArray();
			data.push({'name': 'action', 'value': action_val});

			e.preventDefault();
			$.ajax({
				dataType: "json",
				url:'',
				type:'post',
				data:data,
				success:function(data){
					console.log(data);
					if(data.code===200){
						alert(data.message);
					}else{
						alert("Si è verificato un errore nell'inserimento del paziente: \n" +data.message);
					}
				}
			});
		}else{
			alert("Compila i campi obbligatori.");
		}
    });

});

