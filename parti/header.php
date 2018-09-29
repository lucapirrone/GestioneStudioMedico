<?php

	if(!(isset($paginaIntegra) && $paginaIntegra === true)) exit();

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<script>
/* When the user clicks on the button, 
toggle between hiding and showing the dropdown content */
function showControlMenu() {
    document.getElementById("controlDropdownMenu").classList.toggle("show");
}

// Close the dropdown menu if the user clicks outside of it
window.onclick = function(event) {
  if (!event.target.matches('.dropbtn')) {

    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}
</script>

<?php

if(isset($_SESSION['codicefiscale'])){
	$codicefiscale = $_SESSION['codicefiscale'];

	if ($stmt = $conn->prepare("SELECT nome, cognome FROM utenti WHERE `codicefiscale` = ? and company_id = ? LIMIT 1")) { 
		$stmt->bind_param('si', $codicefiscale, $_SESSION['company_id']); // esegue il bind del parametro '$email'.
		if($stmt->execute()){ 
			$stmt->store_result();
			$stmt->bind_result($nome, $cognome);
			$stmt->fetch();
			if($stmt->num_rows == 1) // se il codice esiste
				$nome_visualizzato = $nome." ".$cognome;
			else{
				error(407, "Utente non trovato");
			}
		}else{
			error(403, mysqli_error($conn));
		}
	}else{
		error(403, mysqli_error($conn));
		return false;
	}
	if(!isset($nome_visualizzato) || $nome_visualizzato==" "){
		$nome_visualizzato = $codicefiscale;
	}
}
else if(isset($_SESSION['utente'])){
	$utente = $_SESSION['utente'];

	$nome_visualizzato = $utente;
}else{
	$nome_visualizzato = "Benvenuto";
}
    
?>
<header id="banner" role="banner">
   <div id="heading" class="site_header">

	  <img class="site-logo light retina" src="images/logo-white.svg" style="padding: 15px; height: 100%">

	  <div href="javascript:void(0);" id="ic_menu">
			<svg  version="1.1" viewBox="0 0 32 32" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><path d="M4,10h24c1.104,0,2-0.896,2-2s-0.896-2-2-2H4C2.896,6,2,6.896,2,8S2.896,10,4,10z M28,14H4c-1.104,0-2,0.896-2,2  s0.896,2,2,2h24c1.104,0,2-0.896,2-2S29.104,14,28,14z M28,22H4c-1.104,0-2,0.896-2,2s0.896,2,2,2h24c1.104,0,2-0.896,2-2  S29.104,22,28,22z"/></svg>
		</div>

	   <div class="menu_container" id="menu_utente">	   

			<div class="positioning-right">

				<?php
					if(login_check_admin($conn)){
				?>

						<div class="user_menu_block">
							<div class="user_menu">
								<div id="notification_counter_container" data-prop-userid="13886440"></div>
								<div class="username_block">
									<div class="icona-light" style="mask-image: url('images/user-circle.svg'); -webkit-mask-image: url('images/user-circle.svg'); width: 30px; height: 30px; -webkit-mask-repeat: no-repeat; mask-repeate: no-repeat;"></div>
									<div class="username">
										<div>
										<?php 

											if(login_check_admin($conn)){
												echo $nome_visualizzato;
											}


										?>
										</div>
									</div>
									<div>
										<i class="fas fa-angle-down"></i>
									</div>
								</div>
								<ul class="options_user_menu">
									<?php
										  foreach($usercontrol_menu as $item){
											  echo '

												<li>
													<div>
														<a href="?page='.$item['code'].'">
															<div class="icona-light" style="mask-image: url(\'images/'.$item['image'].'\'); -webkit-mask-image: url(\'images/'.$item['image'].'\'); width: 30px; height: 30px; -webkit-mask-repeat: no-repeat; mask-repeate: no-repeat;"></div>
															<span>'.$item['nome'].'</span>
														</a>
													</div>
												</li>

											  ';
										  }

									 ?>


									<li>
										<div>
											<a href="?action=logout">
												<div class="icona-light" style="mask-image: url('images/sign-out-alt.svg'); -webkit-mask-image: url('images/sign-out-alt.svg'); width: 30px; height: 30px; -webkit-mask-repeat: no-repeat; mask-repeate: no-repeat;"></div>
												<span>Esci</span>
											</a>
										</div>
									</li>
								</ul>
							</div>
						</div>
				<?php
					}
				?>

		   </div>
	   </div>
   </div>
	
	
	<script>
$(document).ready(function () {
    $(function() {
        var pull = $('#ic_menu');
        menu = $('#mobilemenu');
        menuHeight = menu.height();
    
        $(pull).on('click', function(e) {
            $("#mobilemenu").toggleClass("show");
        });
    });

    jQuery('ic_menu').each(function(){
        var $img = jQuery(this);
        var imgID = $img.attr('id');
        var imgClass = $img.attr('class');
        var imgURL = $img.attr('src');

        jQuery.get(imgURL, function(data) {
            // Get the SVG tag, ignore the rest
            var $svg = jQuery(data).find('svg');

            // Add replaced image's ID to the new SVG
            if(typeof imgID !== 'undefined') {
                $svg = $svg.attr('id', imgID);
            }
            // Add replaced image's classes to the new SVG
            if(typeof imgClass !== 'undefined') {
                $svg = $svg.attr('class', imgClass+' replaced-svg');
            }

            // Remove any invalid XML tags as per http://validator.w3.org
            $svg = $svg.removeAttr('xmlns:a');

            // Replace image with new SVG
            $img.replaceWith($svg);

        }, 'xml');

    });
});
</script>
</header>