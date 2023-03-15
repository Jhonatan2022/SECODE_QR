<?php
require_once('../tcpdf/tcpdf.php'); //Llamando a la Libreria TCPDF
require_once('configuracion.php'); //Llamando a la conexión para BD
date_default_timezone_set('America/Bogota');


ob_end_clean(); //limpiar la memoria


class MYPDF extends TCPDF{
      
    	public function Header() {
            $bMargin = $this->getBreakMargin();
            $auto_page_break = $this->AutoPageBreak;
            $this->SetAutoPageBreak(false, 0);
            $img_file = dirname( __FILE__ ) .'../img/logito.svg';
            $this->Image($img_file, 85, 8, 20, 25, '', '', '', false, 30, '', false, false, 0);
            $this->SetAutoPageBreak($auto_page_break, $bMargin);
            $this->setPageMark();
	    }
}


//Iniciando un nuevo pdf
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, 'mm', 'Letter', true, 'UTF-8', false);
 
//Establecer margenes del PDF
$pdf->SetMargins(20, 35, 25);
$pdf->SetHeaderMargin(20);
$pdf->setPrintFooter(false);
$pdf->setPrintHeader(true); //Eliminar la linea superior del PDF por defecto
$pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM); //Activa o desactiva el modo de salto de página automático
 
//Informacion del PDF
$pdf->SetCreator('UrianViera');
$pdf->SetAuthor('UrianViera');
$pdf->SetTitle('Informe de Empleados');
 
$code = random_int(2142314324,8957349578);
//Agregando la primera página
$pdf->AddPage();
$pdf->SetFont('helvetica','B',10); //Tipo de fuente y tamaño de letra
$pdf->SetXY(150, 20);
$pdf->Write(0, 'Código:'.$code);
$pdf->SetXY(150, 25);
$pdf->Write(0, 'Fecha: '. date('d-m-Y'));
$pdf->SetXY(150, 30);
$pdf->Write(0, 'Hora: '. date('h:i A'));

$canal ='0-0-0-0-0';
$pdf->SetFont('helvetica','B',10); //Tipo de fuente y tamaño de letra
$pdf->SetXY(15, 30); //Margen en X y en Y
$pdf->SetTextColor(106, 4, 137 );
$pdf->Write(0, 'Empresa: SECODE_QR');
$pdf->SetTextColor(0, 0, 0); //Color Negrita
$pdf->SetXY(15, 35);
$pdf->Write(0, 'NIT: '. $canal);
$pdf->SetTextColor(0, 0, 0); //Color Negrita
$pdf->SetXY(15, 40);
$pdf->Write(0, 'Correo Electrónico:team.secode@gmail.com');



$pdf->Ln(35); //Salto de Linea
$pdf->Cell(40,26,'',0,0,'C');
/*$pdf->SetDrawColor(50, 0, 0, 0);
$pdf->SetFillColor(100, 0, 0, 0); */
$pdf->SetTextColor(55, 193, 187 );
//$pdf->SetTextColor(255,204,0); //Amarillo
//$pdf->SetTextColor(34,68,136); //Azul
//$pdf->SetTextColor(153,204,0); //Verde
//$pdf->SetTextColor(204,0,0); //Marron
//$pdf->SetTextColor(245,245,205); //Gris claro
//$pdf->SetTextColor(100, 0, 0); //Color Carne
$pdf->SetFont('helvetica','B', 15); 
$pdf->Cell(100,6,'LISTA DE USUARIOS',0,0,'C');


$pdf->Ln(10); //Salto de Linea
$pdf->SetTextColor(0, 0, 0); 

//Almando la cabecera de la Tabla
$pdf->SetFillColor(232,232,232);
$pdf->SetFont('helvetica','B',12); //La B es para letras en Negritas
$pdf->Cell(26,6,'Documento',1,0,'C',1);
$pdf->Cell(26,6,'Nombre',1,0,'C',0);
$pdf->Cell(26,6,'Dirección',1,0,'C',0);
$pdf->Cell(26,6,'Género',1,0,'C',0); 
$pdf->Cell(26,6,'Correo',1,0,'C',0);
$pdf->Cell(26,6,'F-creacion',1,0,'C',0);
$pdf->Cell(26,6,'Telefono',1,0,'C',0);
/*El 1 despues de  Fecha Ingreso indica que hasta alli 
llega la linea */

$pdf->SetFont('helvetica','',10);


//SQL para consultas Empleados
$fechaInit = date("Y-m-d", strtotime($_POST['fechaCreacion']));
$fechaFin  = date("Y-m-d", strtotime($_POST['fechaCreacion']));

$sqlfinalsecode = "SELECT * FROM usuario WHERE (fechaCreacion>='$fechaInit') ORDER BY fechaCreacion ASC";

$query = mysqli_query($con, $sqlfinalsecode);

while ($dataRow = mysqli_fetch_array($query)) {
        $pdf->Cell(60,20,($dataRow['Ndocumento']),0,1,'C');
        $pdf->Cell(26,6,$dataRow['Nombre'],0,1,'C');
        $pdf->Cell(26,6,($dataRow['Direccion']),0,1,'C');
        $pdf->Cell(26,6,$dataRow['Genero'],0,1,'C');
        $pdf->Cell(26,6,$dataRow['Correo'],0,1,'C');
        $pdf->Cell(26,6,(date('m-d-Y', strtotime($dataRow['fechaCreacion']))),0,1,'C');
        $pdf->Cell(26,6,('+57 '. $dataRow['Telefono']),0,0,'C');
    }


//$pdf->AddPage(); //Agregar nueva Pagina

$pdf->Output('Reporte SECODE'.date('d_m_y').'.pdf', 'I'); 
// Output funcion que recibe 2 parameros, el nombre del archivo, ver archivo o descargar,
// La D es para Forzar una descarga
