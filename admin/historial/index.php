<?php
ob_start();
require("../../lib/database.php");
require("../lib/verificador.php");
require("../lib/page.php");
Page::header();


    $sql = "SELECT admin.alias nombre_admin, admin.foto foto, historial.accion,historial.fecha FROM historial,admin WHERE historial.id_admin=admin.id_admin order by historial.fecha";
	$params = null;

$data = Database::getRows($sql, $params);
if($data != null)
{
    $tabla="<div class='container'>
    <div class='row'>
            <div class='col-lg-12'>
                <h1 class='page-header'>Historial
                    <small>Mouyo</small>
                </h1>
                <ol class='breadcrumb'>
                    <li><a href='../main/index.php'>Home</a>
                    </li>
                    <li class='active'>Historial</li>
                </ol>
            </div>
    </div>";
    foreach($data as $row)
		{
			$tabla.="<div class='row'>
            <div class='col-md-2 text-center'>
                <a href='save.php?id=".base64_encode($row['foto'])."'>
                    <img class='img-responsive img-hover' src='data:image/*;base64,$row[foto]' alt=''>
                </a>
                
            </div>
            <div class='col-md-10'>
                <h2>$row[accion]</h2>
                <p>Por $row[nombre_admin]<p>
                <p>  En la fecha $row[fecha]</p>
            </div>
        </div><hr>";
		}
		
		print $tabla;
}
page::footer();
?>