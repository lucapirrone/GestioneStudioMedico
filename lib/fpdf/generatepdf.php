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

	function stampaFatturaMedico($nome_emitt, $specialista_in, $abitante_in, $sede_emitt, $cod_fiscale_emitt, $p_iva_emitt, $nome_dest, $data_nascita, $residenza, $sede_dest, $p_iva_dest, $cod_fiscale_dest, $prestazione, $imponibile, $iva, $rit_acc, $bollo, $totale){


		//Define
		define('EURO',chr(128));
		define('è',chr(232));

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
		$pdf->Cell(34 ,5,date("d/m/Y"),0,1);//Fine Linea

		$pdf->Cell(130 ,5,'Tel 06 70476220',0,0);
		$pdf->Cell(25 ,5,'Fattura #',0,0);
		$pdf->Cell(34 ,5,'NUMERO FATTURA',0,1);//Fine Linea

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
		$pdf->Cell(70 ,5,'SEDE',0,1);
		}
		if($p_iva_dest){
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(40 ,5,'Codice Fiscale',0,0);
		$pdf->SetFont('Arial','',12);
		$pdf->Cell(70 ,5,$p_iva_dest,0,1);
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
		if($imponibile){
		$pdf->Cell(130 ,5,'',0,0);
		$pdf->Cell(25 ,5,'Imponibile',0,0);
		$pdf->Cell(4 ,5,EURO,1,0);
		$pdf->Cell(30 ,5,$imponibile,1,1,'R');//Fine Linea
		}
		if($iva){
		$pdf->Cell(130 ,5,'',0,0);
		$pdf->Cell(25 ,5,'Iva',0,0);
		$pdf->Cell(4 ,5,EURO,1,0);
		$pdf->Cell(30 ,5,$iva,1,1,'R');//Fine Linea
		}
		if($rit_acc){
		$pdf->Cell(130 ,5,'',0,0);
		$pdf->Cell(25 ,5,'Rit. acconto',0,0);
		$pdf->Cell(4 ,5,EURO,1,0);
		$pdf->Cell(30 ,5,$rit_acc,1,1,'R');//Fine Linea
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
		if($iva==null){
		$pdf->Cell(40 ,3,'La ricevuta rilasciata per prestazioni sanitarie',0,1);
		$pdf->Cell(130 ,5,'',0,0);
		$pdf->Cell(140 ,3,è.' esente da IVA ai sensi dell\'Art. 10, c. 1, n.18',0,1);
		$pdf->Cell(130 ,5,'',0,0);
		$pdf->Cell(140 ,3,'del D.P.R. 633/1972 e successive modificiazioni.',0,1);
		}


		$pdf->Output();
		
	}

?>