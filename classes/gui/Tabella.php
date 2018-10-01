<?php 

class Table{

	public $keys;

	public function __construct(array $keys){
		$this->keys = $keys;
	}

	public function designKeys(){
		echo '
		<div class="table-responsive">
		<table id="table" class="table table-striped table-bordered table-hover">
		  <thead>
			<tr>';

		foreach($this->keys as $key){
			echo '<th>'.$key.'</th>';
		}

		echo'
			</tr>
		</thead>
		<tbody>
			<tr>';
	}


	public function designBody(array $values){

		foreach($values as $value){
			echo '<th>'.$value.'</th>';
		}
		
		echo '</tr><tr>';

	}
	
	public function designFooter(){
		echo'
				</tr>
			</tbody>
		</table>
		</div>';
	}
	
}