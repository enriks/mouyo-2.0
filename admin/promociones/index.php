<?php
ob_start();
require("../lib/page.php");
require("../../lib/database.php");
require("../lib/verificador.php");
Page::header();

if(!empty($_POST))
{
	$search = trim($_POST['buscar']);
	$sql = "SELECT * FROM promociones WHERE titulo LIKE ? ORDER BY titulo";
	$params = array("%$search%");
}
else
{
	$sql = "SELECT * FROM promociones where estado=0 ORDER BY titulo";
	$params = null;
}
$data=Database::getRows($sql,$params);
if($data != null)
{
     $tabla="<div class='container'>
    <div class='row'>
            <div class='col-lg-12'>
                <h1 class='page-header'>Promociones
                    <small>Mouyo</small>
                </h1>
                <ol class='breadcrumb'>
                    <li><a href='../main/index.php'>Home</a>
                    </li>
                    <li class='active'>Promociones</li>
                </ol>
            </div>
        </div>
        <div class='row'>
        <div class='col-md-9'>";
    foreach($data as $row)
		{
			$tabla.="<div class='row'>
            <div class='col-md-7'>
                <a href='save.php?id=".base64_encode($row['id_promocion'])."'>
                    <img class='img-responsive img-hover' src='data:image/*;base64,$row[imagen]' alt=''>
                </a>
            </div>
            <div class='col-md-5'>
                <h3>$row[titulo]</h3>
                <h4>$row[fecha_limite]</h3>
                <p>$row[descripcion]</p>
                <a class='btn btn-primary' href='save.php?id=".base64_encode($row['id_promocion'])."'>Editar</i></a>
                <a class='btn btn-primary' href='delete.php?id=".base64_encode($row['id_promocion'])."'>Eliminar</i></a>
            </div>
        </div><hr>";
		}
		$tabla.="</div><div class='col-md-3'><div class='well'>
                    <h4>Busqueda</h4>
                    <div class='input-group'>
                    	<form class='form-inline'>
                    		<div class='form-group'>
							    <label class='sr-only' for='search'>Busqueda</label>
							    <input type='text' class='form-control' id='search' placeholder='Busqueda'>
							</div>
                        <span class='input-group-btn'>
                            <button class='btn btn-default' type='sumbit'><i class='fa fa-search'></i></button>
                        </span>
                    </div>
                    <!-- /.input-group -->
                </div>
</div>";
    print($tabla);
}
else
{
    print("<h3>No hay registros.</h3>");
}
Page::footer();
?>
 

