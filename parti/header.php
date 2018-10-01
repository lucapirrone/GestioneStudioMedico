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

<header class="header">
   <div class="banner-title">

	   <p class="title-header">Benvenuto in GSM</p>
	   <p class="position-page">GSM
	   
		   <?php
		   
		foreach($pagine as $main){
			if($main['sub']!=null){
				foreach($main['sub'] as $voce){
					if(!(isset($_GET['page'])) && $voce['default']){
						if (file_exists($voce['url'])){
							echo " > <a href='?page=".$voce['code']."'>".$voce['nome']."</a>";
						}
					}
					if(isset($_GET['page']) && $voce['code']==$_GET['page']){
						if (file_exists($voce['url'])){
							echo " > <a href='?page=".$voce['code']."'>".$voce['nome']."</a>";
						}
					}
				}
			}else{
				if((isset($_GET['page']) && $_GET['page']==$main['code']) || $voce['default'])
					echo " > <a href='?page=".$main['code']."'>".$main['nome']."</a>";
			}
		}
		   ?>
	   
	   </p>
			
   </div>
	<div class="banner-right">
	      <img class="site-logo light retina" src="images/logo-blue.svg" style="padding: 15px; height: 100%">

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