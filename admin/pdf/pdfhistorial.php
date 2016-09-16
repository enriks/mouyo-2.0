<?php
require('../../fpdf/fpdf.php');
require("../../lib/database.php");

    $sql = "SELECT admin.alias nombre_admin, admin.foto foto, historial.accion,historial.fecha, historial.id_historial FROM historial,admin WHERE historial.id_admin=admin.id_admin order by historial.fecha";
	$params = null;
    $permiso='';

    $data = Database::getRows($sql, $params);


$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);
$pdf->Image('../../img/mouyo.png' , 10 ,8, 25 , 20,'PNG');
$pdf->Cell(23, 10, '', 0);
$pdf->Cell(150, 16, 'Mouyo Bebidas y Jugos Naturales', 0);
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(50, 10, ''.date('d-m-Y').'', 0);
$pdf->Ln(25);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(70, 8, '', 0);
$pdf->Cell(100, 8, 'HISTORIAL DE ACCIONES', 0);
$pdf->Ln(30);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(15, 8,'ID', 0);
$pdf->Cell(45, 8, 'Usuario', 0);
$pdf->Cell(40, 8, 'Fecha', 0);
$pdf->Cell(100, 8, 'Accion', 0);
$pdf->Ln(8);
foreach($data as $row)
    {
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(15,8,$row['id_historial'],0);
    $pdf->Cell(45,8,$row['nombre_admin'],0);
    $pdf->Cell(40,8,$row['fecha'],0);
    $pdf->Cell(100,8,$row['accion'],0);
    
    $pdf->Ln();
        
    }
$pdf->SetY(-31);
$pdf->SetFont('Arial', 'I', 8);
$pdf->Cell(0,10,'Page '.$pdf->PageNo(),0,0,'C');
/*$pdf->Output('reporte.pdf','D');*/
$pdf-> Output();
?>