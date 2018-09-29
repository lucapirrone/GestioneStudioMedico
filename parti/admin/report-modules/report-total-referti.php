<div class="container-table100">
	<div class="wrap-table100">
		<div class="table100 ver1 m-b-0">
			<div class="table100-head">
				<table>
					<thead>
						<tr class="row100 head">
							<th class="cell100 column1">Amministratore</th>
							<th class="cell100 column4">Referti</th>
						</tr>
					</thead>
				</table>
			</div>

			<div class="table100-body js-pscroll">
				<table>
					<tbody>
							<?php 
							if ($fetch_admin = $conn->prepare("SELECT id, utente FROM amministratori")) { 
								if($fetch_admin->execute()){
									if(!$fetch_admin->store_result()) echo mysqli_error($conn);
									if ($fetch_admin->num_rows >= 1) { //Uses the stored result and counts the rows.
										if(!$fetch_admin->bind_result($id, $utente)) echo mysqli_error($conn);
										while($fetch_admin->fetch()){


											$timestamp_from = mktime(0, 0, 0, date("n"), 1);
											$timestamp_to = mktime(23, 59, 59, date("n"), date("t"));

											if ($fetch_report = $conn->prepare("select id from report_upload_referti where id_admin = ? and upload_time > ? and upload_time < ?")) { 
												$fetch_report->bind_param('iss', $id, $timestamp_from, $timestamp_to); 

												if($fetch_report->execute()){ 
													$fetch_report->store_result();
													$fetch_report->bind_result($id);
													$fetch_report->fetch();
													if($fetch_report->num_rows > 0){ // se l'amministratore ha caricato qualche referto
														echo '<tr class="row100 body">';

														echo '<td class="cell100 column1">'.$utente.'</td>';
														echo '<td class="cell100 column4">'.date($fetch_report->num_rows).'</td>';

														echo '</tr>';
													}else{
														//Nessun referto caricato dall'amministratore
													}
												}else{
													echo mysqli_error($conn);
												}
											}else{
												echo mysqli_error($conn);
											}
										}
									}
								}else{
									echo mysqli_error($conn);
								}
							}else{
								echo mysqli_error($conn);
							}



							if ($fetchall_report = $conn->prepare("select id from report_upload_referti where upload_time > ? and upload_time < ?")) { 
								$fetchall_report->bind_param('ss', $timestamp_from, $timestamp_to); 

								if($fetchall_report->execute()){ 
									$fetchall_report->store_result();
									$fetchall_report->bind_result($id);
									$fetchall_report->fetch();
									if($fetchall_report->num_rows > 0){ // se l'amministratore ha caricato qualche referto
										echo '<tr class="row100 body">';

										echo '<td class="cell100 column1">TOTALE</td>';
										echo '<td class="cell100 column4">'.date($fetchall_report->num_rows).'</td>';

										echo '</tr>';
									}else{
										//Nessun referto caricato dall'amministratore
									}
								}else{
									echo mysqli_error($conn);
								}
							}else{
								echo mysqli_error($conn);
							}									


							?>

						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>