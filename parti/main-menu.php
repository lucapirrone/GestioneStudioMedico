<?php
if(login_check_admin($conn)){
?>	



<ul id="navigation" class="vertical">

	<?php
	foreach($pagine as $item){
		$active = false;

		if($active) $class_active = "class=\"active\"";
		else $class_active = "";
		  echo '
		  <li '.$class_active.'>
			<a href="#"><span>'.$item['nome'].'</span></a>
			<ul class="flyout-content nav stacked">
			';

			foreach($item['sub'] as $subitem){
				if($subitem['visibility'])
					echo '<li><a href="?page='.$subitem['code'].'">'.$subitem['nome'].'</a></li>';
			}

		echo '</ul>
		  </li>
		  ';
	  }
	
	?>
	
</ul>

<?php
	
}

?>