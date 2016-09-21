<?php
require('../../fpdf/fpdf.php');
require("../../lib/database.php");

    $sql = "SELECT admin.alias nombre_admin, admin.foto foto, historial.accion,historial.fecha, historial.id_historial FROM historial,admin WHERE historial.id_admin=admin.id_admin order by historial.fecha";
	$params = null;
    $permiso='';
    ini_set("date.timezone","America/El_Salvador");
    setlocale(LC_TIME, 'es_SV.UTF-8');
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
$pdf->Cell(50, 16, ''.date('d-m-Y g:i A ').'', 0);
#$pdf->Cell(50, 16, ''.date('l jS \of F Y h:i A').'', 0);
#$pdf->Cell(50, 16, ''.strftime('%A, %d de %B de %Y').'',0);
$pdf->Ln(25);
$pdf->SetFont('Arial', 'B', 11);
#$pdf->Cell(70, 8, '', 0);
$pdf->SetFillColor(255,255,153);
$pdf->Cell(190, 8, 'HISTORIAL DE ACCIONES',1,0,'C',1);
$pdf->Ln(8);
$pdf->SetFillColor(255,255,204);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(15, 8,' ID',1,0,'L',1);
$pdf->Cell(45, 8, ' Usuario', 1,0,'L',1);
$pdf->Cell(40, 8, ' Fecha',1,0,'L',1);
$pdf->Cell(90, 8,utf8_decode(' Acción'),1,0,'L',1);
$pdf->Ln(8);
foreach($data as $row)
    {
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(15,8,$row['id_historial'],0);
    $pdf->Cell(45,8,$row['nombre_admin'],0);
    $pdf->Cell(40,8,$row['fecha'],0);
    $pdf->Cell(90,8,$row['accion'],0);
    
    $pdf->Ln();
        
    }
$pdf->SetY(-31);
$pdf->SetFont('Arial', 'I', 8);
$pdf->Cell(0,10,utf8_decode('Página ').$pdf->PageNo(),0,0,'C');
/*$pdf->Output('reporte.pdf','D');*/
$pdf-> Output();
?>