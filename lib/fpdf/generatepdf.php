<?php
require('fpdf.php');

/*VARIABILI

$nome_emitt="ciao"; 
$specialista_in=null;
$abitante_in="pau";
$sede_emitt=null;
$cod_fiscale_emitt="jnsbc";
$p_iva_emitt=null;
$nome_dest="psp";
$data_nascita="qkj";
$residenza="lskncla";
$sede_dest="mckl";
$p_iva_dest="dsxds";
$cod_fiscale_dest=null;
$prestazione="Bocchino";
$imponibile=150;
$iva=1600;
$rit_acc=239;
$bollo=2;
$totale=29292;*/

function generaFattura($id_fattura){

	global $conn;
	
	$f = new Fattura($conn);
	$f->selectFatturaById($id_fattura);

	$prest_eff = new PrestEff($conn);
	$prest_eff->selectPrestEffById($f->id_prest_eff);

	$prest = new Prestazione($conn);
	$prest->selectPrestazioneById($prest_eff->id_prest);

	$medico1 = new Medico($conn);
	$medico1->selectMedicoById($prest_eff->id_medico_1);

	$co = new Company($conn);

	/**/$num_fattura = $f->numfattura."-".$f->annofattura;
	/**/$data = date("d/m/Y", $f->data_fat);
	if($prest->fatturato=="SOCIETA"){
		/**/$nome_emitt = $co->nome;
		/**/$specialista_in = null;
		/**/$abitante_in = null;
		/**/$sede_emitt = $co->indirizzo.", ".$co->cap.", ".$co->citta;
		/**/$cod_fiscale_emitt = null;
		/**/$p_iva_emitt = $co->p_iva;
	}
	else{
		/**/$nome_emitt = $medico1->cognome;
		/**/$specialista_in = $medico1->spec;
		/**/$abitante_in = $medico1->indirizzo.", ".$medico1->cap.", ".$medico1->citta;
		/**/$sede_emitt = null;
		/**/$cod_fiscale_emitt = $medico1->cod_fiscale;
		/**/$p_iva_emitt = $medico1->p_iva;
	}
	
	if($prest_eff->id_paziente_dest!=null &&  $prest_eff->id_paziente_dest!=-1 && $prest_eff->id_paziente_dest!=""){
		$paz = new Paziente($conn);
		$paz->selectPazienteById($prest_eff->id_paziente_dest);

		$dest_fatt = new DestinatarioFattura($paz->nome, $paz->cognome, $paz->data, $paz->titolo, $paz->indirizzo, $paz->citta, $paz->cap, $paz->provincia,	$paz->stato,	$paz->tel_1,	$paz->tel_2,	$paz->cod_fiscale, $paz->p_iva, $paz->note, $paz->email);
	}
	if($prest_eff->id_medico_dest!=null &&  $prest_eff->id_medico_dest!=-1 && $prest_eff->id_medico_dest!=""){
		$medico = new Medico($conn);
		$medico->selectMedicoById($prest_eff->id_medico_dest);

		$dest_fatt = new DestinatarioFattura($medico->nome, $medico->cognome, null, $medico->titolo, $medico->indirizzo, $medico->citta, $medico->cap, $medico->prov,	null,	null,	null,	$medico->cod_fiscale, $medico->p_iva, null, null);
	}
	if($prest_eff->id_societa_dest!=null &&  $prest_eff->id_societa_dest!=-1 && $prest_eff->id_societa_dest!=""){
		$se = new SocietaEsterna($conn);
		$se->selectSocietaEsternaById($prest_eff->id_societa_dest);

		$dest_fatt = new DestinatarioFattura($se->nome, null, null, null, $se->indirizzo, $se->citta, $se->cap, $se->provincia,	null,	null,	null,	null, $se->p_iva, null, null);
	}		

	/**/$nome_dest = $dest_fatt->cognome." ".$dest_fatt->nome;
	/**/$data_nascita = date("d/m/Y", $dest_fatt->data);
	/**/$residenza = $dest_fatt->indirizzo.", ".$dest_fatt->cap.", ".$dest_fatt->citta;
	/**/$sede_dest = null;
	/**/$p_iva_dest = null;
	/**/$cod_fiscale_dest = $dest_fatt->cod_fiscale;
	/**/$prestazione = $prest->nome;
	/**/$imponibile = $f->importo;

	/**/$perc_iva = null;
	/**/$imp_iva = null;
	/**/$perc_rit = null;
	/**/$imp_rit = null;
	if($f->flag_iva=="SI")	{
		/**/$perc_iva = 22;
		/**/$imp_iva = ($importo/100)*$perc_iva;
	}	
	if($f->flag_rit=="SI"){
		/**/$perc_rit = 20;
		/**/$imp_rit = ($importo/100)*$perc_rit;
	}	
	/**/$bollo = $f->bollo;
	/**/$totale = $f->importo_tot;


	//Define
	define('EURO',chr(128));
	define('è',chr(232));
	define('PERC',chr(37));

	$pdf = new FPDF();
	$pdf->AddPage();
	//Imposto font arial
	$pdf->SetFont('Arial','B',19);


	$pdf->Cell(130 ,5,'ARTEMIDE95',0,0);
	$pdf->Cell(59 ,5,'FATTURA',0,1);//Fine Linea
	$pdf->Cell(59 ,5,'',0,1);//Fine Linea
	//imposto font
	$pdf->SetFont('Arial','',12);

	$pdf->Cell(130 ,5,'Studio Medico Associato',0,0);
	$pdf->Cell(59 ,5,'',0,1);//Fine Linea

	$pdf->Cell(130 ,5,'Via Sannio, 61',0,0);
	$pdf->Cell(59 ,5,'',0,1);//Fine Linea
	$pdf->Cell(130 ,5,'00183 Roma, RM, Italia',0,0);
	$pdf->Cell(25 ,5,'Data',0,0);
	$pdf->Cell(34 ,5,$data,0,1);//Fine Linea

	$pdf->Cell(130 ,5,'Tel 06 70476220',0,0);
	$pdf->Cell(25 ,5,'Fattura #',0,0);
	$pdf->Cell(34 ,5,$num_fattura,0,1);//Fine Linea

	$pdf->Cell(130 ,5,'Fax 06 7002403',0,0);
	$pdf->Line(10,48,200,48); //linea

	$pdf->Cell(189 ,10,'',0,1);//Fine Linea

	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(40 ,5,'Emittente',0,0);

	$pdf->Cell(189 ,10,'',0,1);//Spazio

	//EMITTENTE
	if($nome_emitt){
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(40 ,5,'Nome',0,0);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(70 ,5,$nome_emitt,0,1);
	}
	if($specialista_in){
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(40 ,5,'Specialista in',0,0);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(70 ,5,$specialista_in,0,1);
	}
	if($abitante_in){
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(40 ,5,'Abitante in',0,0);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(70 ,5,$abitante_in,0,1);
	}
	if($sede_emitt){
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(40 ,5,'Sede',0,0);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(70 ,5,$sede_emitt,0,1);
	}
	if($cod_fiscale_emitt){
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(40 ,5,'Codice Fiscale',0,0);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(70 ,5,$cod_fiscale_emitt,0,1);
	}
	if($p_iva_emitt){
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(40 ,5,'Partita Iva',0,0);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(70 ,5,$p_iva_emitt,0,1);
	}

	$pdf->Cell(189 ,10,'',0,1);//Spazio

	//DESTINATARIO
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(40 ,5,'Destinatario',0,0);

	$pdf->Cell(189 ,10,'',0,1);//Spazio
	if($nome_dest){
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(40 ,5,'Nome',0,0);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(70 ,5,$nome_dest,0,1);
	}
	if($data_nascita){
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(40 ,5,'Data di nascita',0,0);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(70 ,5,$data_nascita,0,1);
	}
	if($residenza){
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(40 ,5,'Residenza',0,0);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(70 ,5,$residenza,0,1);
	}
	if($sede_dest){
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(40 ,5,'Sede',0,0);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(70 ,5,$sede_dest,0,1);
	}
	if($p_iva_dest){
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(40 ,5,'Partita Iva',0,0);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(70 ,5,$p_iva_dest,0,1);
	}
	if($cod_fiscale_dest){
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(40 ,5,'Codice Fiscale',0,0);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(70 ,5,$cod_fiscale_dest,0,1);
	}

	$pdf->Cell(189 ,10,'',0,1);//Spazio

	//invoice contents
	$pdf->SetFont('Arial','B',12);

	$pdf->Cell(155 ,5,'Prestazione',1,0);
	$pdf->Cell(34 ,5,'Importo',1,1);//Fine Linea

	$pdf->SetFont('Arial','',12);

	//Parte Finale Fattura
	if($prestazione){
	$pdf->Cell(155 ,5,$prestazione,1,0);
	}
	if($imponibile){
	$pdf->Cell(34 ,5,$imponibile,1,0,'R');//Fine Linea
	}

	$pdf->Cell(130 ,5,'',0,0);
	$pdf->Cell(30 ,5,'',1,1,'R');//Fine Linea

	//Sommario
	if($perc_iva){
	$pdf->Cell(130 ,5,'',0,0);
	$pdf->Cell(25 ,5,'Perc. Iva',0,0);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(4 ,5,PERC,1,0);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(30 ,5,$perc_iva,1,1,'R');//Fine Linea
	}
	if($imp_iva){
	$pdf->Cell(130 ,5,'',0,0);
	$pdf->Cell(25 ,5,'Iva',0,0);
	$pdf->Cell(4 ,5,EURO,1,0);
	$pdf->Cell(30 ,5,$imp_iva,1,1,'R');//Fine Linea
	}
	if($perc_rit){
	$pdf->Cell(130 ,5,'',0,0);
	$pdf->Cell(25 ,5,PERC . ' Rit. Acc',0,0);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(4 ,5,PERC,1,0);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(30 ,5,$perc_rit,1,1,'R');//Fine Linea
	}
	if($imp_rit){
	$pdf->Cell(130 ,5,'',0,0);
	$pdf->Cell(25 ,5,'Rit. acconto',0,0);
	$pdf->Cell(4 ,5,EURO,1,0);
	$pdf->Cell(30 ,5,$imp_rit,1,1,'R');//Fine Linea
	}
	if($bollo){
	$pdf->Cell(130 ,5,'',0,0);
	$pdf->Cell(25 ,5,'Bollo',0,0);
	$pdf->Cell(4 ,5,EURO,1,0);
	$pdf->Cell(30 ,5,$bollo,1,1,'R');//Fine Linea
	}
	if($totale){
	$pdf->Cell(130 ,5,'',0,0);
	$pdf->Cell(25 ,5,'Totale',0,0);
	$pdf->Cell(4 ,5,EURO,1,0);
	$pdf->Cell(30 ,5,$totale,1,1,'R');//Fine Linea
	}
	$pdf->Cell(189 ,10,'',0,1);//Fine Linea
	$pdf->Cell(130 ,5,'',0,0);
	$pdf->SetFont('Arial','',9);

	//Testo finale
	if($imp_iva==null){
	$pdf->Cell(40 ,3,'La ricevuta rilasciata per prestazioni sanitarie',0,1);
	$pdf->Cell(130 ,5,'',0,0);
	$pdf->Cell(140 ,3,è.' esente da IVA ai sensi dell\'Art. 10, c. 1, n.18',0,1);
	$pdf->Cell(130 ,5,'',0,0);
	$pdf->Cell(140 ,3,'del D.P.R. 633/1972 e successive modificiazioni.',0,1);
	}
	$pathname="/var/www/html/gestionestudiomedico.it/uploads/fattura/".$_SESSION['company_id']."/".date("Y", $f->data_fat)."/".date("m", $f->data_fat)."/".date("d", $f->data_fat)."/";
	
	$filename= $num_fattura.".pdf";
	
	if (!file_exists($pathname)) {
		mkdir($pathname, 0777, true);
	}
	
	$pathfile=$pathname.$filename;
		
	$pdf->Output($pathfile,'F');
	return $pathfile;


}

?>