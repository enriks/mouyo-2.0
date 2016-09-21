<?php
ob_start();
require("../lib/page.php");
require("../../lib/database.php");
require("../lib/verificador.php");
Page::header();
$tabla="";
if(!empty($_POST))
{
	$search = trim($_POST['buscar']);
	$sql = "SELECT * FROM promociones WHERE titulo LIKE ? ORDER BY titulo";
	$params = array("%$search%");
    $tabla.="<div class='container'>
    <div class='row'>
            <div class='col-lg-12'>
                <h1 class='page-header'>Promociones
                    <small>Mouyo</small>
                </h1>
                <ol class='breadcrumb'>
                    <li><a href='../main/index.php'>Home</a>
                    </li>
                    <li><a href='index.php'>Promociones</a></li>
                    <li class='active'>Busqueda de '$search'</li>
                    <li><button type='button' class='btn'>Agregar Promocion</button></li>
                </ol>
            </div>
        </div>
        <div class='row'>
        <div class='col-md-9'>";
}
else
{
	$sql = "SELECT * FROM promociones where estado=0 ORDER BY titulo";
	$params = null;
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
                    <li><button type='button' class='btn'>Agregar Promocion</button></li>
                </ol>
            </div>
        </div>
        <div class='row'>
        <div class='col-md-9'>";
}
$activo="";
$data=Database::getRows($sql,$params);
if($data != null)
{
    foreach($data as $row)
		{
            if($row['activo']==0)
            {
                $activo="Vigente (Activo)";
            }
            else
            {
                $activo="Inactivo";
            }
			$tabla.="<div class='row'>
            <div class='col-md-7'>
                <a href='save.php?id=".base64_encode($row['id_promocion'])."'>
                    <img class='img-responsive img-hover' src='data:image/*;base64,$row[imagen]' alt=''>
                </a>
            </div>
            <div class='col-md-5'>
                <h3>$row[titulo]</h3>
                <p>$row[descripcion]</p>
                <p><strong>Estado:</strong>$activo</p>";
                $tabla.="<a class='btn btn-primary' href='save.php?id=".base64_encode($row['id_promocion'])."'>Editar</i></a>
                <a class='btn btn-primary' href='delete.php?id=".base64_encode($row['id_promocion'])."'>Eliminar</i></a>
            </div>
        </div><hr>";
		}
		$tabla.="</div><div class='col-md-3'><div class='well'>
                    <h4>Busqueda</h4>
                    <div class='input-group'>
                    	<form class='form-inline' method='post'>
                    		<div class='form-group'>
							    <label class='sr-only' for='search'>Busqueda</label>
							    <input type='text' class='form-control' id='search' placeholder='Busqueda' name='buscar'>
							</div>
                        <span class='input-group-btn'>
                            <button class='btn btn-default' type='sumbit'><i class='fa fa-search'></i></button>
                        </span>
                    </div>
                    <!-- /.input-group -->
                    <a class='btn btn-success' type='button' href='../highcharts/grafpromociones.php'><i class='fa fa-pie-chart' aria-hidden='true'>Ver gráfico de Promociones</i></a>
                </div>
</div>";
    print($tabla);
}
else
{
    print("<div class='container'>
    <div class='row'>
            <div class='col-lg-12'>
                <h1 class='page-header'>Promociones
                    <small>Mouyo</small>
                </h1>
                <ol class='breadcrumb'>
                    <li><a href='../main/index.php'>Home</a>
                    </li>
                    <li><a href='index.php'>Promociones</a></li>
                    <li class='active'>Busqueda de '$search'</li>
                    <li><button type='button' class='btn'>Agregar Promocion</button></li>
                </ol>
            </div>
        </div>
        <div class='row'>
        <div class='col-md-9'><h2>No se encuentra ninguna promocion con ese nombre <a href='index.php'>Volver</a>                    
                </h2>");
}

Page::footer();
?>
 

