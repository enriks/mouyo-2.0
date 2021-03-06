<?php
require('../../fpdf/fpdf.php');
require('../../lib/database.php');
require('../lib/page.php');
ini_set("date.timezone","America/El_Salvador");
$usuario=$_SESSION['usuario_admin'];

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
$pdf->Cell(190, 8, 'LISTADO DE ADMINISTRADORES',1,0,'C',1);
$pdf->Ln(8);
$pdf->SetFillColor(255,255,204);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(15, 8,' ID',1,0,'L',1);
$pdf->Cell(45, 8, ' Alias',1,0,'L',1);
$pdf->Cell(70, 8, ' Correo',1,0,'L',1);
$pdf->Cell(60, 8, ' Permisos',1,0,'L',1);
$pdf->Ln(8);


    $sql = "SELECT admin.id_admin, admin.alias, admin.correo, admin.permiso, admin.estado, permisos.id_permiso, permisos.nombre permisito FROM admin, permisos where admin.estado=0 AND admin.permiso = permisos.id_permiso ORDER BY id_admin";
	$params = null;
    $data = Database::getRows($sql, $params);

foreach($data as $row)
    {
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(15,8,$row['id_admin'],0);
    $pdf->Cell(45,8,$row['alias'],0);
    $pdf->Cell(70,8,$row['correo'],0);
    $pdf->Cell(60,8,$row['permisito'],0);
    
    $pdf->Ln();
        
    }
$pdf->SetY(-31);
$pdf->SetFont('Arial', 'I', 8);
$pdf->Cell(0,10,utf8_decode('Página ').$pdf->PageNo(),0,0,'C');
/*$pdf->Output('reporte.pdf','D');
Sigue el mismo método que utilizarías para una página HTML o algo similar. Añade: target=”_blank” a tu link o form.
*/
$pdf-> Output();
?>