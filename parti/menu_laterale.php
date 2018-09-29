<?php

	if(!(isset($paginaIntegra) && $paginaIntegra === true)) exit();

?>
<?php



?>

<ul id="navigation" class="vertical">
	<?php
	   foreach($menu_laterale as $item){
		   if($item['code']===$_GET['page']){
			   echo '<a class="titolo-menu">'.$item['title'].'</a>';
			   foreach($item['items'] as $voce){
					$active = false;
					if(isset($_GET['code'])){
					   if($_GET['code']==$voce['code']) $active=true;
					}else{
					   if($voce['default']) $active = true;
					}

					if($active) $class_active = "class=\"active\"";
					else $class_active = "";
					$params = array_merge($_GET, array("code" => $voce['code']));
					$new_query_string = http_build_query($params);
					echo '<li '.$class_active.'><a href="?'.$new_query_string.'">'.$voce['nome'].'</a></li>';
			   }
		   }
	   }
	?>
</ul>
