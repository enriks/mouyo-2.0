<?php
require('../../fpdf/fpdf.php');
require('../../lib/database.php');
require('../lib/page.php');
ini_set("date.timezone","America/El_Salvador");
$usuario=$_SESSION['usuario_admin'];

    $sql = "SELECT cotizacion.nombre nombre_cotizacion,jugos.nombre nombre_jugo, jugos.imagen imagen_jugo,jugos.precio,tamanio.tamanio nombre_tamanio,detalle_cotizacion.id_jugo,detalle_cotizacion.cantidad from jugos,tamanio,cotizacion,detalle_cotizacion, usuario where detalle_cotizacion.id_cotizacion = ? and detalle_cotizacion.id_jugo = jugos.id_jugo and detalle_cotizacion.id_tamanio = tamanio.id_tamanio and detalle_cotizacion.id_cotizacion=cotizacion.id_cotizacion and cotizacion.id_usuario=usuario.id_usuario";
	$params = base64_decode($_GET['id']);
    $data = Database::getRows($sql, $params);


$pdf = new FPDF('P','mm','A4');
$pdf->AddPage();
$pdf->SetMargins(10, 10, 10);
$pdf->SetAutoPageBreak(true,10);
$pdf->SetFont('Arial', '', 10);
$pdf->Image('../../img/mouyo.png' , 10 ,8, 25 , 20,'PNG');
$pdf->Cell(23, 10, '', 0);
$pdf->Cell(105, 16, 'Mouyo Bebidas y Jugos Naturales', 0);
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(50, 16, ''.date('d-m-Y g:i A ').'- Usuario: '.$usuario, 0);
$pdf->Ln(25);
$pdf->SetFont('Arial', 'B', 11);
#$pdf->Cell(70, 8, '', 0);
$pdf->SetFillColor(255,255,153);
$pdf->Cell(190, 8, $data['nombre_cotizacion'],1,0,'C',1);
$pdf->Ln(8);
$pdf->SetFillColor(255,255,204);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(15, 8,' ID',1,0,'L',1);
$pdf->Cell(75, 8, ' Jugos',1,0,'L',1);
$pdf->Cell(35, 8, ' Precio',1,0,'L',1);
$pdf->Cell(35, 8, utf8_decode(' Tamaño'),1,0,'L',1);
$pdf->Cell(30, 8, utf8_decode(' Cantidad'),1,0,'L',1);
$pdf->Ln(8);
foreach($data as $row)
    {
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(15,8,$row['id_cotizacion'],0);
    $pdf->Cell(75,8,$row['nombre_jugo'],0);
    $pdf->Cell(35,8,$row['precio'],0);
    $pdf->Cell(35,8,$row['nombre_tamanio'],0);
    $pdf->Cell(30,8,$row['cantidad'],0);
    
    
    $pdf->Ln();
        
    }
$pdf->SetY(-31);
$pdf->SetFont('Arial', 'I', 8);
$pdf->Cell(0,10,utf8_decode('Página ').$pdf->PageNo(),0,0,'C');
/*$pdf->Output('reporte.pdf','D');*/
$pdf-> Output();
?>