<?php
require('../../fpdf/fpdf.php');
require('../../lib/database.php');
require('../lib/page.php');
ini_set("date.timezone","America/El_Salvador");
$usuario=$_SESSION['usuario_admin'];

     $sql = "SELECT * FROM usuario where estado=0 ORDER BY alias";
	$params = null;
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
$pdf->Cell(190, 8, 'LISTADO DE USUARIOS',1,0,'C',1);
$pdf->Ln(8);
$pdf->SetFillColor(255,255,204);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(15, 8,' ID',1,0,'L',1);
$pdf->Cell(75, 8, ' Nombre Completo',1,0,'L',1);
$pdf->Cell(100, 8, utf8_decode(' Correo'),1,0,'L',1);
$pdf->Ln(8);
foreach($data as $row)
    {
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(15,8,$row['id_usuario'],0);
    $pdf->Cell(75,8,$row['nombre'].' '.$row['apellido'],0);
    $pdf->Cell(100,8,$row['correo'],0);
    
    $pdf->Ln();
        
    }
$pdf->SetY(-31);
$pdf->SetFont('Arial', 'I', 8);
$pdf->Cell(0,10,utf8_decode('Página ').$pdf->PageNo(),0,0,'C');
/*$pdf->Output('reporte.pdf','D');*/
$pdf-> Output();
?>