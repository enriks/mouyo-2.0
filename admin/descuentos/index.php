<?php
ob_start();
require("../../lib/database.php");
require("../lib/verificador.php");
require("../lib/page.php");
Page::header();
$tabla="";
if(!empty($_POST))
{
    $search = trim($_POST['buscar']);
    $sql="select descuentos.id_jugo,descuentos.id_descuento,descuentos.fecha_inicio, descuentos.fecha_limite,jugos.imagen,jugos.nombre nombre_jugo,descuentos.nombre,jugos.precio, descuentos.descuento from jugos, descuentos where descuentos.id_jugo = jugos.id_jugo and descuentos.nombre LIKE ? and descuentos.estado=0";
    $params = array("%$search%");
    $tabla="<div class='container'>
    <div class='row'>
            <div class='col-lg-12'>
                <h1 class='page-header'>Descuentos
                    <small>Mantenimiento a los Descuentos</small>
                </h1>
                <ol class='breadcrumb'>
                    <li><a href='../main/index.php'>Home</a>
                    </li>
                    <li><a href='index.php'>Descuentos</a></li>
                     <li class='active'>Busqueda de '$search'</li>
                     <li><button type='button' class='btn'>Agregar un nuevo 
                     Descuento</button></li>
                </ol>
            </div>
        </div>
        <div class='row'>
        <div class='col-md-8'>";
}
else
{
    $sql="select descuentos.id_jugo,descuentos.id_descuento,descuentos.fecha_inicio, descuentos.fecha_limite,jugos.imagen,jugos.nombre nombre_jugo,descuentos.nombre,jugos.precio, descuentos.descuento from jugos, descuentos where descuentos.id_jugo = jugos.id_jugo and descuentos.estado=0";
    $params = null;
    $tabla="<div class='container'>
    <div class='row'>
            <div class='col-lg-12'>
                <h1 class='page-header'>Descuentos
                    <small>Mantenimiento de Descuentos</small>
                </h1>
                <ol class='breadcrumb'>
                    <li><a href='../main/index.php'>Home</a>
                    </li>
                    <li class='active'>Descuentos</li>
                     <li><button type='button' class='btn'>Agregar un nuevo 
                     Descuento</button></li>
                </ol>
            </div>
        </div>
        <div class='row'>
        <div class='col-md-8'>";
}
$data = Database::getRows($sql, $params);
if($data != null)
{
    foreach($data as $row)
		{
			$tabla.="<div class='row'>
            <div class='col-md-4'>
                <a href='save.php?id=".base64_encode($row['id_jugo'])."'>
                    <img class='img-responsive img-hover' src='data:image/*;base64,$row[imagen]' alt=''>
                </a>
            </div>
            <div class='col-md-8'>
                <h3>$row[nombre]</h3>
                <h4>Aplicado al jugo</h4>
                <ul>
                    <li>$row[nombre_jugo]</li>
                </ul>
                <p><strong>Fecha de Inicio:</strong> $row[fecha_inicio] <strong>Fecha limite:</strong> $row[fecha_limite]</p>
                <p><strong>Descuento (%):</strong> $row[descuento]%</p>
                <a class='btn btn-primary' href='save.php?id=".base64_encode($row['id_descuento'])."'>Editar</i></a>
                <a class='btn btn-primary' href='delete.php?id=".base64_encode($row['id_descuento'])."'>Eliminar</i></a>
            </div>
        </div><hr>";
		}
		$tabla.="</div><div class='col-md-4'><div class='well'>
                    <h4>Busqueda</h4>
                    	<form method='post' class='form-inline'>
                    		<div class='form-group'>
							    <label class='sr-only' for='search'>Busqueda</label>
							    <input type='text' class='form-control' id='search' name='buscar' placeholder='Busqueda'>
							</div>
	                        <span class='input-group-btn'>
	                            <button class='btn btn-default' type='sumbit'><i class='fa fa-search'></i></button>
	                        </span>
                        </form>
                    <!-- /.input-group -->
                </div>
</div>";
		
}
else
{
	$tabla.="<h2>No se encuentra ningun descuento con ese nombre <a href='index.php'>Volver</a>                    
                </h2>";
}
print $tabla;
page::footer();
?>