<?php
if(login_check_admin($conn)){
?>	


<nav class="navbar-default navbar-side" role="navigation">
	<div class="sidebar-collapse">
<ul id="main-menu" class="nav">

	<li>
		<div class="user-img-div">
			<img src="assets/img/user.png" class="img-thumbnail" />

			<div class="inner-text">
				<?php echo $_SESSION['utente']; ?>
			<br />
			</div>
		</div>

	</li>
	<?php
	foreach($pagine as $item){
		$active = false;

		if($active) $class_active = "active-menu";//"class=\"active\"";
		else $class_active = "";
		  echo '
		  <li '.$class_active.'>
			<a href="#"><i class="fa fa-fatture"></i><span>'.$item['nome'].'</span><span class="fa arrow"></span></a>
			<ul class="nav nav-second-level collapse">
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
	</div>
</nav>

<?php
	
}

?>