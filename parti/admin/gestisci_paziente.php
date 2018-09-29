<?php

	if(!(isset($paginaIntegra) && $paginaIntegra === true)) exit();

?>
<?php

checkAdminSession($conn);

if(!isset($_GET['codicefiscale'])){
	include 'parti/seleziona_paziente.php';
}else{	//Se è stato selezionato l'utente mostra tutto il contenuto (menu laterale e relativo box selezionato)
	foreach($menu_laterale as $menu){
		if($menu['code']==$_GET['page']){	//prende gli elementi selezionati riguardo la pagina gestisci-paziente
			foreach($menu['items'] as $voce){
				if($voce['default'])
					if (file_exists($voce['url'])) 
						$content = $voce['url'];

				if(isset($_GET['code']) && $voce['code']==$_GET['code'])
					if (file_exists($voce['url']))
						$content = $voce['url'];
			}
		}
	}

	echo "<div class=\"content-right\">";
	include $content;
	echo "</div>";
	include 'parti/menu_laterale.php';


?>
<?php

}
?>
