<?php
require('../../fpdf/fpdf.php');
require("../../lib/database.php");

    $sql = "SELECT jugos.id_jugo,jugos.nombre nombre_jugo,jugos.descripcion descripcion_jugo,jugos.imagen,jugos.precio,tipo_jugo.nombre nombre_tipojugo FROM jugos,tipo_jugo where jugos.id_tipojugo=tipo_jugo.id_tipojugo and jugos.estado=0  ORDER BY jugos.nombre";
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
$pdf->Cell(100, 8, 'LISTADO DE JUGOS', 0);
$pdf->Ln(30);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(25, 8,'ID', 0);
$pdf->Cell(65, 8, 'Nombre', 0);
$pdf->Cell(100, 8, 'Tipo de Jugo', 0);
$pdf->Ln(8);
foreach($data as $row)
    {
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(25,8,$row['id_jugo'],0);
    $pdf->Cell(65,8,$row['nombre_jugo'],0);
    $pdf->Cell(100,8,$row['nombre_tipojugo'],0);
    
    $pdf->Ln();
        
    }
$pdf->SetY(-31);
$pdf->SetFont('Arial', 'I', 8);
$pdf->Cell(0,10,'Page '.$pdf->PageNo(),0,0,'C');
/*$pdf->Output('reporte.pdf','D');*/
$pdf-> Output();
?>