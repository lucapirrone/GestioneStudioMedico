<?php


	//Imposta la variabile di controllo di integrità della pagina, cosicchè ogni script incluso non può essere raggiunto direttamente
	$paginaIntegra = true;

	require 'lib/head.php';

	include 'action/logout.php';

	if(!(login_check_admin($conn))) header("Location: login.php");
	
	$content = 'parti/404.php';
	foreach($pagine as $main){
		foreach($main['sub'] as $voce){
			if(!(isset($_GET['page'])) && $voce['default']){
				if (file_exists($voce['url'])){
					$content = $voce['url'];
					$title = $voce['nome'];
				}
			}
			if(isset($_GET['page']) && $voce['code']==$_GET['page']){
				if (file_exists($voce['url'])){
					$content = $voce['url'];
					$title = $voce['nome'];
				}
			}
		}
	}
	?>

<!doctype html>
<html>
<head>

<title>Referto in Cloud - <?php echo $title; ?></title>

	<?php include("parti/css_includes.php"); ?>

</head>
	<body>
		
		<?php include("parti/modules_includes.php"); ?>
		
		<div id="wrapper">
						
			<?php 
						
				
				echo "<div class=\"menu-left\">";
				include("parti/main-menu.php");
				echo "</div>"; 
			
				echo "<div class=\"content-right\">";
				if (file_exists($content)) 
				{
					include("parti/header.php");
				  	include($content);
				} 
				echo "</div>";
			
			
				require("parti/footer.php");

			?>
						
		</div>

	</body>
	<?php include("parti/js_includes.php"); ?>
	
	
	
</html>