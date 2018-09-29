<?php

	if(!(isset($paginaIntegra) && $paginaIntegra === true)) exit();

?>
<?php


//Questa pagina permette di cambiare password di un paziente identificato tramite codicefiscale pazzato come parametro GET.
//Questa pagina è accessibile solamente da utente amministratore

if(login_check_admin($conn) == true && $_SESSION['type']!=1){
      header('Location: login_admin.php');
}

?>


<div class="form-style-7">
	<input type="button" id="changePassword_Email" value="Invia password per Email"/>
	<input type="button" id="changePassword_Print" value="Stampa foglio"/>
</div>


<script type="text/javascript">
	$("#changePassword_Email").click(function(e){
		makeRequest("email");
	});
	$("#changePassword_Print").click(function(e){
		makeRequest("print");
	});
	function makeRequest(action){
		//var data = new FormData();
		//data.append("codicefiscale", "<?php echo $_GET['codicefiscale']; ?>");
		//data.append("action", action);
		$.ajax({
			dataType: "json",
			url:'/action/reset_password.php',
			type:'post',
			data:{
				codicefiscale : "<?php echo $_GET['codicefiscale']; ?>",
				action : action
			},
			success:function(data){
				if(data.code===200){
					alert("Password cambiata correttamente");
					window.open("/template/credenziali/template_credenziali.php?password="+data.credenziali.password);
				}else{
					alert("Si è verificato un errore nel cambiamento della password\n"+data['code']+": "+data['message']);
				}
			}
		});
	}
</script>