<?php
	require('fpdf.php');

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
	$pdf->Cell(40 ,5,'Medico',0,0);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(70 ,5,'NOME MEDICO',0,1);

	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(40 ,5,'Specialista in',0,0);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(70 ,5,'SPECIALIZZAZIONE',0,1);

	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(40 ,5,'Abitante in',0,0);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(70 ,5,'VIA MEDICO',0,1);

	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(40 ,5,'Codice Fiscale',0,0);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(70 ,5,'CF MEDICO',0,1);

	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(40 ,5,'Partita Iva',0,0);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(70 ,5,'PIVA MEDICO',0,1);

	$pdf->Line(10,78,200,78); //linea

	$pdf->Cell(189 ,10,'',0,1);//Fine Linea

	//invoice contents
	$pdf->SetFont('Arial','B',12);

	$pdf->Cell(130 ,5,'Prestazione',1,0);
	$pdf->Cell(25 ,5,'Tasse',1,0);
	$pdf->Cell(34 ,5,'Importo',1,1);//Fine Linea

	$pdf->SetFont('Arial','',12);

	//Parte Finale Fattura

	$pdf->Cell(130 ,5,'NOME PRESTAZIONE',1,0);
	$pdf->Cell(25 ,5,'IVA',1,0);
	$pdf->Cell(34 ,5,'IMPORTO',1,1,'R');//Fine Linea

	//Sommario
	$pdf->Cell(130 ,5,'',0,0);
	$pdf->Cell(25 ,5,'Imponibile',0,0);
	$pdf->Cell(4 ,5,EURO,1,0);
	$pdf->Cell(30 ,5,'IMPORTO',1,1,'R');//Fine Linea


	$pdf->Cell(130 ,5,'',0,0);
	$pdf->Cell(25 ,5,'Bollo',0,0);
	$pdf->Cell(4 ,5,EURO,1,0);
	$pdf->Cell(30 ,5,'2',1,1,'R');//Fine Linea

	$pdf->Cell(130 ,5,'',0,0);
	$pdf->Cell(25 ,5,'Totale',0,0);
	$pdf->Cell(4 ,5,EURO,1,0);
	$pdf->Cell(30 ,5,'Imp+Bollo',1,1,'R');//Fine Linea

	$pdf->Cell(189 ,10,'',0,1);//Fine Linea
	$pdf->Cell(130 ,5,'',0,0);
	$pdf->SetFont('Arial','',9);

	//Testo finale
	$pdf->Cell(40 ,3,'La ricevuta rilasciata per prestazioni sanitarie',0,1);
	$pdf->Cell(130 ,5,'',0,0);
	$pdf->Cell(140 ,3,è.' esente da IVA ai sensi dell\'Art. 10, c. 1, n.18',0,1);
	$pdf->Cell(130 ,5,'',0,0);
	$pdf->Cell(140 ,3,'del D.P.R. 633/1972 e successive modificiazioni.',0,1);


	
	$pdf->Output();

?>