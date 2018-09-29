<?php

	if(!(isset($paginaIntegra) && $paginaIntegra === true)) exit();

?>
<?php 
	


if ($stmt = $conn->prepare("SELECT first_pass_set FROM amministratori WHERE id = ? and utente = ? and company_id = ? LIMIT 1")) { 
	$stmt->bind_param('isi', $_SESSION['id_utente'], $_SESSION['utente'], $_SESSION['company_id']); // esegue il bind del parametro '$email'.
	if($stmt->execute()){ 
		$stmt->store_result();
		$stmt->bind_result($first_pass_set);
		$stmt->fetch();
		if($first_pass_set==0){

			if(isset($_POST['first_p_set'])){
				$sha_pass = $_POST['first_p_set'];
				$random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
				// Crea una password usando la chiave appena creata.
				$password = hash('sha512', $sha_pass.$random_salt);
				if($insert_stmt = $conn->prepare("UPDATE amministratori SET password = ?, salt = ?, first_pass_set = 1 WHERE id = ? and utente = ? and company_id = ?")){

					$insert_stmt->bind_param("ssisi",$password,$random_salt,$_SESSION['id_utente'], $_SESSION['utente'], $_SESSION['company_id']);

					if($insert_stmt->execute()){
						log_admin_action($conn, "change first password", null);
						echo'<script>alert("Password cambiata correttamente");</script>';
						$user_browser = $_SERVER['HTTP_USER_AGENT'];
						$_SESSION['login_string'] = hash('sha512', $password.$user_browser);
					}else{
						echo mysqli_error($conn);
					}

				}else{
					echo mysqli_error($conn);	
				}
			}else{

		

					?>



	<style>
	.overlay {
	  position: absolute;
	  top: 0;
	  left: 0;
	  width: 100%;
	  height: 100%;
	  z-index: 10;
	  background-color: rgba(0,0,0,0.5); /*dim the background*/
	}
	.dialog_center {
		width: 1000px;
		height: 260px;
		position: fixed;
		top: 50%; 
		left: 50%;
		margin-top: -130px;
		margin-left: -500px;
		background-color: #f1c40f;
		border-radius: 5px;
		text-align: center;
		z-index: 11; /* 1px higher than the overlay layer */
	}

	</style>

	<div class="overlay"></div>
	<div id="form_container" class="dialog_center">
			<form id="form_aggiungipaziente" class="form-style-7" action="" method="post">
				<div class="form_description" id="titolo_info">
					<h2>Cambia Password</h2>
				</div>
				<ul id="form_info">

					<li class="left">
						<label class="description" for="element_1">
						   Password
						</label>
						<input class="nouppercase" type="password" name="password" maxlength="100" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Deve contenere almeno un numero, una lettera minuscola ed una maiuscola, e deve essere lunga almeno 8 caratteri" required/> 
						<span>Password</span>         
					</li>

					<li class="right">
						<label class="description" for="element_1">
						   Ripeti Password
						</label>
						<input class="nouppercase" type="password" maxlength="100"/> 
						<span>Ripeti Password</span>         
					</li>

					<li class="buttons">
						<input id="saveForm" class="button_text" type="button" name="btnsubmit" value="Cambia"/>
					</li>

				</ul>
			</form>
		</div>

	<script>


	$(document).ready(function (e) {

		$('#saveForm').click(function(e){
			//Controllo completamento campi 
			if($('input[name=password]').val()!=""){

				//Controllo password uguali
				if($('input[name=password]').val()!=$('input[name=password2]').val()){

					//Controllo correttezza password
					if($('input[name=password]').val()!=$('input[name=password2]').val()){

						var password = document.getElementsByName("password")[0];
						var form = document.getElementById("saveForm").form;
						var p = document.createElement("input");
						// Aggiungi un nuovo elemento al tuo form.
						form.appendChild(p);
						p.name = "first_p_set";
						p.type = "hidden"
						p.value = hex_sha512(password.value);
						// Assicurati che la password non venga inviata in chiaro.
						password.value = "";
						// Come ultimo passaggio, esegui il 'submit' del form.
						form.submit();
					}
				}else{
					alert("Le password non coincidono");
				}
			}else{
				alert("Completa tutti i campi");
			}
		});

	});

	</script>




					<?php

				}
			}else{
				echo mysqli_error($conn);
			}
		}else{
			echo mysqli_error($conn);
		}
	}

?>
	

