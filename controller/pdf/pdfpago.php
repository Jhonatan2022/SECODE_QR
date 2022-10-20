<?php
session_start();

require_once "../../models/database/database.php";
require_once "../../vendor/autoload.php";
require_once "../../models/user.php";

#$plan = $_GET['plan'];
#$plan = 'Plan 1';
#$id_factura = $_GET['id_factura'];
#$precio= $_GET['precio'];
#$fecha = $_GET['fecha'];
#$tipo = $_GET['tipo'];

$user = getUser($_SESSION['user_id']);


	use setasign\Fpdi\Fpdi;

	# Creación del objeto de la clase heredada #


	$pdf = new FPDF('P','mm','Letter');
	$pdf->SetMargins(17,17,17);
	$pdf->AddPage();

	# Logo de la empresa formato png #
	$pdf->Image('../../views/assets/img/logo.png',165,12,35,35,'PNG');

	# Encabezado y datos de la empresa #
	$pdf->SetFont('Arial','B',16);
	$pdf->SetTextColor(75,12,75);
	$pdf->Cell(150,10,utf8_decode(strtoupper("SECODE_QR")),0,0,'L');

	$pdf->Ln(9);

	$pdf->SetFont('Arial','',10);
	$pdf->SetTextColor(39,39,51);
	$pdf->Cell(150,9,utf8_decode("NIT: 999999999"),0,0,'L');

	$pdf->Ln(5);

	$pdf->Cell(150,9,utf8_decode("Dirección: Bogotá D.C, Colombia"),0,0,'L');

	$pdf->Ln(5);

	$pdf->Cell(150,9,utf8_decode("Teléfono: 0101010101"),0,0,'L');

	$pdf->Ln(5);

	$pdf->Cell(150,9,utf8_decode("Email: team.secode@gmail.com"),0,0,'L');

	$pdf->Ln(10);

	$pdf->SetFont('Arial','',10);
	$pdf->Cell(30,7,utf8_decode("Fecha de emisión:"),0,0);
	$pdf->SetTextColor(97,97,97);
	$pdf->Cell(116,7,utf8_decode(date("d/m/Y", strtotime("13-09-2022"))." ".date("h:s A")),0,0,'L');
	$pdf->SetFont('Arial','B',10);
	$pdf->SetTextColor(75,12,75);
	$pdf->Cell(35,7,utf8_decode(strtoupper("Factura Nro.")),0,0,'C');

	$pdf->Ln(10);

	$pdf->SetFont('Arial','',10);
	$pdf->SetTextColor(75,12,75);
	$pdf->Cell(13,7,utf8_decode("Cliente:"),0,0);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(60,7,utf8_decode($user['Nombre']),0,0,'L');
	$pdf->SetTextColor(75,12,75);
	$pdf->Cell(60,7,utf8_decode("ID: ".$user['Ndocumento']),0,0,'L');
	$pdf->SetTextColor(75,12,75);
	$pdf->Cell(7,7,utf8_decode("Tel:"),0,0,'L');
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(35,7,utf8_decode($user['Telefono']),0,0);
	$pdf->SetTextColor(0,0,0);

	$pdf->Ln(7);

	$pdf->SetTextColor(75,12,75);
	$pdf->Cell(6,7,utf8_decode("Dir:"),0,0);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(109,7,utf8_decode($user['Direccion']),0,0);

	$pdf->Ln(9);

	# Tabla de productos #
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(91, 229, 243);
	$pdf->SetDrawColor(91, 229, 243);
	$pdf->SetTextColor(0, 0, 0);
	$pdf->Cell(90,8,utf8_decode("Descripción"),1,0,'C',true);
	$pdf->Cell(15,8,utf8_decode("Cant."),1,0,'C',true);
	$pdf->Cell(25,8,utf8_decode("Precio"),1,0,'C',true);
	$pdf->Cell(19,8,utf8_decode("Desc."),1,0,'C',true);
	$pdf->Cell(32,8,utf8_decode("Subtotal"),1,0,'C',true);

	$pdf->Ln(8);

	
	$pdf->SetTextColor(39,39,51);



	/*----------  Detalles de la tabla  ----------*/
$pdf->Cell(90,7,utf8_decode("Suscripcion en la plataforma SECODE_QR con el plan:"/*.$plan*/),'L',0,'C');
	$pdf->Cell(15,7,utf8_decode("7"),'L',0,'C');
	$pdf->Cell(25,7,utf8_decode(''),'L',0,'C');
	$pdf->Cell(19,7,utf8_decode("$0.00 USD"),'L',0,'C');
	$pdf->Cell(32,7,utf8_decode("$70.00 USD"),'LR',0,'C');
	$pdf->Ln(7);
	/*----------  Fin Detalles de la tabla  ----------*/


	
	$pdf->SetFont('Arial','B',9);
	
	# Impuestos & totales #
	$pdf->Cell(100,7,utf8_decode(''),'T',0,'C');
	$pdf->Cell(15,7,utf8_decode(''),'T',0,'C');
	$pdf->Cell(32,7,utf8_decode("SUBTOTAL"),'T',0,'C');
	$pdf->Cell(34,7,utf8_decode("+ $70.00 USD"),'T',0,'C');

	$pdf->Ln(7);

	$pdf->Cell(100,7,utf8_decode(''),'',0,'C');
	$pdf->Cell(15,7,utf8_decode(''),'',0,'C');


	$pdf->Cell(32,7,utf8_decode("TOTAL A PAGAR"),'T',0,'C');
	$pdf->Cell(34,7,utf8_decode("$70.00 USD"),'T',0,'C');

	$pdf->Ln(12);

	$pdf->SetFont('Arial','',9);

	$pdf->SetTextColor(39,39,51);
	$pdf->MultiCell(0,9,utf8_decode("*** Precios de productos incluyen impuestos. Para poder realizar un reclamo o devolución debe de presentar esta factura ***"),0,'C',false);

	$pdf->Ln(9);


	# Nombre del archivo PDF #
	$pdf->Output("I","ReciboSecode_Qr.pdf",true);