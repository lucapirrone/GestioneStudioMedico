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

		if(!isset($_SESSION['action_token']) || !isset($action_token))	$action_token = $_SESSION['action_token'] = md5(uniqid(mt_rand(), true));
		
		
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
					$url = "?action=request&action_code=3&action_token=".$action_token."&id_fattura=";
					 
					if($item['action']=="edit") echo '<i onclick="editMov('.$item['id_mov'].')" class="fas fa-edit" style="margin-right: 10px; cursor: pointer;"></i>';
					if($item['action']=="delete") echo '<i onclick="deleteMov('.$item['id_mov'].')" class="fas fa-trash" style="cursor: pointer;"></i>';
					if($item['action']=="view") echo '
						<a href="'.$url.$item['id_fattura'].'" target="_href" style="color:#333;font-size:14px;">
						<i class="far fa-eye" style="margin:0 5px 0 20px;"></i>
						Visualizza Fattura
						</a>
					';
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