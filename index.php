<?php


	//Imposta la variabile di controllo di integrità della pagina, cosicchè ogni script incluso non può essere raggiunto direttamente
	$paginaIntegra = true;

	require 'lib/head.php';

	include 'action/logout.php';

	if(!(login_check_admin($conn))) header("Location: login.php");
	
	$content = 'parti/404.php';
	foreach($pagine as $main){
		if($main['sub']!=null){
			foreach($main['sub'] as $voce){
				if($voce['default']){
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
		}else{
			if($main['default']){
				if (file_exists($main['url'])){
					$content = $main['url'];
					$title = $main['nome'];
				}
			}
		}
	}
	?>

<!doctype html>
<html>
<head>

<title>GSM - <?php echo $title; ?></title>

	<?php include("parti/css_includes.php"); ?>

</head>
	<body>
		
		<div id="wrapper">
						
			<?php 
						
				
				echo "<div class=\"menu-left\">";
				include("parti/main-menu.php");
				echo "</div>"; 
			
				echo "<div class=\"content-right\">";
				if (file_exists($content)) 
				{
					include("parti/header.php");
					echo "<div class=\"content\">";
				  	include($content);
					echo "</div>";
				} 
				echo "</div>";
			
			
				//require("parti/footer.php");

			?>
						
		</div>

	</body>
	<?php include("parti/js_includes.php"); ?>
	
	
	
</html>