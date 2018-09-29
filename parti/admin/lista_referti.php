<?php

	if(!(isset($paginaIntegra) && $paginaIntegra === true)) exit();

?>
<?php

//Questa pagina permette di gestire i referti di un paziente identificato tramite codicefiscale pazzato come parametro GET.
//Questa pagina è accessibile solamente da utente amministratore



require 'action/cancella_referto.php';

?>

<div id="lista">
	<div class="form-style-7">
		<h2 class="title testo-grande">
			Lista Referti
			<i class="delete fas fa-plus" style="float: right" title="Nuova Visita" onClick="window.location.replace('?page=nuova-visita&codicefiscale=<?php echo $_GET['codicefiscale']; ?>')"></i>
		 </h2>


		<table id="table" class="table table-striped table-mc-deep-purple">
			  <thead>
				<tr>
				  <th>Visita</th>
				  <th>Tipo</th>
				  <th>Pubblicazione</th>
				  <th>Scadenza</th>
				  <th>Note</th>
				  <th></th>
				  <th></th>
				  <th></th>
				  <th></th>
						
				</tr>
			  </thead>
			  <tbody>
				  <?php
				  $codicefiscale = $_GET['codicefiscale'];
				  
				  $token = $_SESSION['token'] = md5(uniqid(mt_rand(), true));

				  if ($stmt = $conn->prepare("SELECT id, data, note, scaricato, datapubblicazione, datascadenza, tipo, filepdf FROM referti WHERE codicefiscale = ? and company_id = ? order by id desc")) { 
					$stmt->bind_param('si', $codicefiscale, $GLOBALS['company_id']); // esegue il bind del parametro '$email'.
					if($stmt->execute()){
						$stmt->store_result();
						if ($stmt->num_rows >= 1) { //Uses the stored result and counts the rows.
							$stmt->bind_result($id, $data, $note, $scaricato, $datapubblicazione, $datascadenza, $tipo, $filepdf);
							$array_referti = array();
							while($stmt->fetch()){
								$class_scad = "";
								if($datascadenza != null && time()>$datascadenza) $class_scad= $class_scad."scaduto ";
								if($filepdf==null) $class_scad = $class_scad."dacaricare ";
								
								echo '<tr id="referto_'.$id.'">';
								echo '<td class="'.$class_scad.'">'.date('d/m/Y', $data).'</td>';
								echo '<td class="'.$class_scad.'">'.$tipo.'</td>';
								
								echo '<td class="'.$class_scad.'">';
									if($datapubblicazione!=null) echo date('d/m/Y', $datapubblicazione);
								echo '</td>';
								
								echo '<td class="'.$class_scad.'">';
									if($datascadenza!=null) echo date('d/m/Y', $datascadenza);
								echo '</td>';
																
								echo '<td class="'.$class_scad.'" title="'.$note.'" style="white-space: normal; width: 100%;">'.$note.'</td>';
								
								//Se il referto è stato caricato allora visualizza il bottone per caricarlo
								if($filepdf==null){
									echo '<td class="bn_fill '.$class_scad.'"><a class="bn_fill" href="index.php?page=carica-referto&id='.$id.'&codicefiscale='.$codicefiscale.'">CARICA</a></td>';
									echo '<td class="bn_fill '.$class_scad.'"></td>';
								}else{
									$params_download = array_merge($_GET, array("id_referto" => $id, "codicefiscale" => $codicefiscale, "action" => "download"));
									$download_q = http_build_query($params_download);
									
									$params_open = array_merge($_GET, array("id_referto" => $id, "codicefiscale" => $codicefiscale, "action" => "open"));
									$open_q = http_build_query($params_open);
									
									echo '<td class="bn_fill '.$class_scad.'"><a class="bn_fill" href="?'.$download_q.'">SCARICA</a></td>';
									
									echo '<td class="bn_fill '.$class_scad.'"><a class="bn_fill" href="?'.$open_q.'">APRI</a></td>';
								}
								
								if($scaricato==null)	echo '<td class="'.$class_scad.'"><a class="icona-dark"><i class="fas fa-times"  title="Non scaricato"></i></td>';
								
								else	echo '<td class="'.$class_scad.'"><a class="icona-dark"><i class="fas fa-check" title="Scaricato"></i></td>';
																
								echo '<td class="'.$class_scad.'">
										<nav class="menu">
											<a class="toggle-nav" href="#">&#9776;</a>

											<ul class="active">
												<li><a style="cursor: pointer" onclick="modificaPassword('.$id.')">Modifica Password</a></li>
												<li><a style="cursor: pointer" onclick="cancellaReferto('.$id.', \''.$token.'\')">Elimina</a></li>
											</ul>
										</nav>
									</td>';
								
								echo '</tr>';

							}
						}else{
							//echo "Lista Vuota";
						}
					}else{
						echo mysqli_error($conn);
					}
				}else {
					echo mysqli_error($conn);
				}
				  
			  	?>
				
			  </tbody>
		</table>
	</div>
</div>
<script>


	function cancellaReferto(id, token){

		if (confirm('Vuoi veramente eliminare il referto?')) {

			var url = "?page=gestisci-paziente&codicefiscale="+getParameterByName("codicefiscale")+"&code=listareferti&token="+token+"&id="+id;

			window.location.replace(url);

		}
	}

	function getParameterByName(name, url) {
		if (!url) url = window.location.href;
		name = name.replace(/[\[\]]/g, '\\$&');
		var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
			results = regex.exec(url);
		if (!results) return null;
		if (!results[2]) return '';
		return decodeURIComponent(results[2].replace(/\+/g, ' '));
	}

	function modificaPassword(id){
		<?php 
			$p_show_cred = array_merge($_GET, array("codicefiscale" => $codicefiscale, "action" => "show_cred"));
			$q_show_cred = http_build_query($p_show_cred);

			echo 'alert("Password modificata con successo!");
			window.open("?'.$q_show_cred.'&id_referto="+id);';
		?>		
	}
</script>



<script>
jQuery(document).ready(function() {
	jQuery('.toggle-nav').click(function(e) {
		jQuery(this).toggleClass('active');
		jQuery(this).siblings("ul").toggleClass('active');

		e.preventDefault();
	});
});
</script>

<style>
/*----- Toggle Button -----*/
.toggle-nav {
	display:none;
}

/*----- Menu -----*/
.menu {
	padding:10px 0px;
	border-radius:3px;
}


.menu ul {
	display:inline-block;
}

.menu li {
	margin:0px 50px 0px 0px;
	float:left;
	list-style:none;
	font-size:17px;
    border: none;
	text-align: left !important;
}

.menu li:last-child {
	margin-right:0px;
}

.menu a {
	text-shadow:0px 1px 0px rgba(0,0,0,0.5);
	color:#777;
	transition:color linear 0.15s;
}

.menu a:hover, .menu .current-item a {
	text-decoration:none;
	color:#C0C0C0;
}
.menu {
	position:relative;
	display:inline-block;
    text-align: left;
}

.menu ul.active {
	display:none;
}

.menu ul {
	position:absolute;
	top:120%;
	right: -20px;
	padding:10px 18px;
	box-shadow:0px 1px 1px rgba(0,0,0,0.15);
	border-radius:3px;
	background:#303030;
	z-index: 99;
}

.menu ul:after {
	width:0px;
	height:0px;
	position:absolute;
	top:0%;
	right:22px;
	content:'';
	transform:translate(0%, -100%);
	border-left:7px solid transparent;
	border-right:7px solid transparent;
	border-bottom:7px solid #303030;
}

.menu li {
	margin:5px 0px 5px 0px;
	float:none;
	display:block;
}

.menu a {
	display:block;
}

.toggle-nav {
	float:left;
	display:inline-block;
	border-radius:3px;
	color:#777;
	font-size:20px;
}

.toggle-nav:hover, .toggle-nav.active {
	text-decoration:none;
	color:#C0C0C0;
}

.search-form {
	margin:12px 0px 0px 20px;
	float:left;
}

.search-form input {
	box-shadow:-1px 1px 2px rgba(0,0,0,0.1);
}

</style> 

