<?php	
	require("../../lib/database.php");
	require('../../fpdf/fpdf.php');

    $sql = "SELECT ingrediente.id_ingrediente,ingrediente.nombre nombre_ingrediente,ingrediente.imagen,ingrediente.descripcion,tipo_ingrediente.id_tipo,tipo_ingrediente.nombre nombre_tipo,tipo_ingrediente.precio from ingrediente,tipo_ingrediente where ingrediente.tipo=tipo_ingrediente.id_tipo and ingrediente.estado=0  ORDER BY ingrediente.nombre";
	$params = null;

    $data = Database::getRows($sql, $params);
    $pdf = new FPDF();
    $pdf-> Addpage();
			// Logo
			$pdf->Image('../../img/mouyo.png',10,8,33);
			// Arial bold 15
			$pdf->SetFont('Arial','B',15);
			// Movernos a la derecha
			$pdf->Cell(60);
			// Título
			$pdf->Cell(70,10,'Reporte de Promociones',1,0,'C');
			// Salto de línea
			$pdf->Ln(20);
	
		

	



    
    $pdf->SetFillColor(232,232,232);
    $pdf->SetFont('Arial','B',12);
    $pdf->SetX(10);
    $pdf->Cell(40,6,'Precio',1,0,'C',1);
    $pdf->SetX(50);
    $pdf->Cell(40,6,'Tipo',1,0,'C',1);
    $pdf->SetX(90);
    $pdf->Cell(40,6,'Nombre',1,0,'C',1);
    $pdf->Ln();

    foreach($data as $row)
    {
    $pdf->SetFont('Arial','',12);
    $pdf->SetX(10);
    $pdf->Cell(40,6,$row['precio'],1,0,'C',1);
    $pdf->SetX(50);
    $pdf->Cell(40,6,$row['nombre_tipo'],1,0,'C',1);
    $pdf->SetX(90);
    $pdf->Cell(40,6,$row['nombre_ingrediente'],1,0,'C',1);
    $pdf->Ln();
        
    }
     
			// Posición: a 1,5 cm del final
			$pdf->SetY(-38);
			// Arial italic 8
			$pdf->SetFont('Arial','I',8);
			// Número de página
			$pdf->Cell(0,10,'Page '.$pdf->PageNo().'/{nb}',0,0,'C');
	

    $pdf-> Output();
?>