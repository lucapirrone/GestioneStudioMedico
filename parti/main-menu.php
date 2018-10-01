<?php
if(login_check_admin($conn)){
?>	


<nav class="navbar-default navbar-side" role="navigation">
	<div class="sidebar-collapse">
<ul id="main-menu" class="nav">

	<li>
		<div class="user-img-div">
			<img src="<?php echo $_SESSION['company_logo']; ?>" class="img-thumbnail" />

			<div class="inner-text">
				<a class="username"><?php echo $_SESSION['utente']; ?></a>
				</br>
				<a class="companyname"><?php echo $_SESSION['company_name']; ?></a>
				</br>
				<a class="esci"><a href="?action=logout">Esci<i class="fas fa-sign-out-alt" style="float: none; margin-left: 10px;"></i></a></a>
				
			</div>
		</div>

	</li>
	<?php
	foreach($pagine as $item){
		$active = false;
		if(isset($item['code'])) $codepage = "?page=".$item['code'];
		else $codepage = "";

		if($active) $class_active = "active-menu";
		else $class_active = "";
		  echo '
		  <li '.$class_active.'>
			<a href="'.$codepage.'"><i class="'.$item['class-icon'].'"></i>'.$item['nome'];
			if($item['sub']!=null) echo '<span class="fa arrow"></span>';
				
			echo '</a>';
		
			if($item['sub']!=null){
				echo '<ul class="nav nav-second-level collapse">';

				foreach($item['sub'] as $subitem){
					if($subitem['visibility'])
						echo '<li><a href="?page='.$subitem['code'].'"><i class="'.$subitem['class-icon'].'"></i>'.$subitem['nome'].'</a></li>';
				}

				echo '</ul>';
			}
			
		  	echo '</li>';
	  }
	
	?>
	
</ul>
	</div>
</nav>

<?php
	
}

?>