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

		$idsetted = false;
		$id_item = "";
		foreach($values as $value){
			if(!$idsetted)	{
				$id_item = $value;
				$idsetted = true;
			}
			echo '<th>';
			if(is_array($value)){
				foreach($value as $item){
					if($item=="edit") echo '<i onclick="editMov('.$id_item.')" class="fas fa-edit" style="margin-right: 10px; cursor: pointer;"></i>';
					if($item=="delete") echo '<i onclick="deleteMov('.$id_item.')" class="fas fa-trash" style="cursor: pointer;"></i>';
				}
			}else{
				echo $value;
			}
			echo '</th>';
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