
<form id="form_filtri" class="section" action="" method="post">
	<ul>
		

	
		<?php 
		if(!isset($action_token))	$action_token = $_SESSION['action_token'] = md5(uniqid(mt_rand(), true)); 

		
		$sm = new SearchMedico($conn);
		$medici = $sm->selezionaTutto();
		
		$sp = new SearchPrestazioni($conn);
		$prestazioni = $sp->selezionaTutto();		
		
		?>
	
		
		<input name="array_medici" id="array_medici" type="hidden"/>
		<input name="array_prestazioni" id="array_prestazioni" type="hidden"/>

		<li class="fill"style="width: 30%;">
			<legend>Seleziona i medici</legend>
			<select id="select_medico" multiple style="width: 100%;">      
  				
			</select> 
		</li>
		
		<li class="fill"style="width: 30%;">
			<legend>Seleziona le prestazioni</legend>          
			<select id="select_prestazione" multiple style="width: 100%;">      

			</select>    
		</li>
		
		
		<li class="fill" style="width: 15%;">
			<legend>Data Inizio</legend>
			<input type="date" class="form-control" id="input_data" name="data_inizio" value="<?php echo date('Y-m-d'); ?>" step="1" required/>
			
		</li>
				
		<li class="fill" style="width: 15%;">
			<legend>Data Fine</legend>
			<input type="date" class="form-control" id="input_data" name="data_fine" value="<?php echo date('Y-m-d'); ?>" step="1" required/>
			
		</li>	
		
		<li class="fill" style="width: 10%; padding-top: 60px; text-align: center;">
            <button id="id_filtra_fatture" class="btn btn-light" onclick="submitForm();"><i class="fa fa-bolt fa-fw"></i>Filtra</button>
        </li>
		

	</ul>

<script>

	var list_medici = [];
	var list_prestazioni = [];

	<?php



	$build_medici = array();
	foreach($medici as $m){
		$build_medici[] = array(
			"id"=>$m['id'],
			"text"=>$m['nome']
		);  
	}
	
	
	$arr_medici[] = array(
		"text"=>"Medici",
		"children"=>$build_medici
	);

	$build_prestazioni = array();
	foreach($prestazioni as $p){
		$build_prestazioni[] = array(
			"id"=>$p['id'],
			"text"=>$p['nome']
		);  
	}
	
	
	$arr_prestazioni[] = array(
		"text"=>"Prestazioni",
		"children"=>$build_prestazioni
	);

	echo "var arr_medici=".json_encode($arr_medici).";";
	echo "var arr_prestazioni=".json_encode($arr_prestazioni).";";


	?>

		
	function formatResult(item) {
		if(!item.id) {
		   return item.text;
		}
		// return item template
		return '<i style="color:#ff0000">' + item.text + '</i>';
	}

	function formatSelection(item) {
		// return selection template
		return '<b>' + item.text + '</b>';
	}
	$('#select_medico').select2({
		data: arr_medici,			
		// Specify format function for dropdown item
		formatResult: formatResult,
		// Specify format function for selected item
		formatSelection: formatSelection,
	});
		
	$('#select_medico').change(function() {
		//var theID = $(test).val(); // works
		//var theSelection = $(test).filter(':selected').text(); // doesn't work
		var items = $('#select_medico').select2('data');
		list_medici=[];
		items.forEach(function(item){
			list_medici.push(item.id);
		});
	});
	
	$('#select_prestazione').select2({
		data: arr_prestazioni,			
		// Specify format function for dropdown item
		formatResult: formatResult,
		// Specify format function for selected item
		formatSelection: formatSelection,
	});
		
	$('#select_prestazione').change(function() {
		//var theID = $(test).val(); // works
		//var theSelection = $(test).filter(':selected').text(); // doesn't work
		var items = $('#select_prestazione').select2('data');
		list_prestazioni=[];
		items.forEach(function(item){
			list_prestazioni.push(item.id);
		});
	});

	

	function submitForm(){
		console.log(list_medici);
		console.log(list_prestazioni);
		$('#array_medici').val(list_medici);
		$('#array_prestazioni').val(list_prestazioni);

		$('#form_filtri').submit();

	}
	
	$(document).on("keypress","#select_prestazione",function(event){
    if (event.ctrlKey || event.metaKey) {
        var id =$(this).parents("div[id*='select_prestazione']").attr("id").replace("s2id_","");
        var element =$("#"+id);
        if (event.which == 97){
            var selected = [];
            element.find("option").each(function(i,e){
                selected[selected.length]=$(e).attr("value");
            });
            element.select2("val", selected);
        } else if (event.which == 100){
            element.select2("val", "");
        }
    }
});

	
</script>
	
</form>