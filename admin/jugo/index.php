<?php
ob_start();
require("../../lib/database.php");
require("../lib/verificador.php");
require("../lib/page.php");
Page::header();

if(!empty($_POST))
{
    $search = trim($_POST['buscar']);
    $sql = "SELECT jugos.id_jugo,jugos.nombre nombre_jugo,jugos.descripcion descripcion_jugo,jugos.imagen,jugos.precio, jugos.tamanio,tamanio.tamanio nombre_tamanio,tipo_jugo.nombre nombre_tipojugo FROM jugos,tipo_jugo,tamanio where jugos.id_tipojugo=tipo_jugo.id_tipojugo and jugos.tamanio=tamanio.id_tamanio AND jugos.nombre LIKE ? and jugos.estado=0 ORDER BY jugos.nombre";
    $params = array("%$search%");
    $ingre="SELECT ingrediente.nombre nombre_ingrediente from ingrediente,detalle_bebida,jugos WHERE jugos.id_jugo = detalle_bebida.id_jugo and ingrediente.id_ingrediente = detalle_bebida.id_ingrediente and ingrediente.estado=0";
}
else
{
    $sql = "SELECT jugos.id_jugo,jugos.nombre nombre_jugo,jugos.descripcion descripcion_jugo,jugos.imagen,jugos.precio,tipo_jugo.nombre nombre_tipojugo FROM jugos,tipo_jugo where jugos.id_tipojugo=tipo_jugo.id_tipojugo and jugos.estado=0  ORDER BY jugos.nombre";
    $params = null;
}

$data = Database::getRows($sql, $params);
if($data != null)
{
    $tabla="<div class='container'>
    <div class='row'>
            <div class='col-lg-12'>
                <h1 class='page-header'>Jugos
                    <small>Mantenimiento de los jugos</small>
                </h1>
                <ol class='breadcrumb'>
                    <li><a href='../main/index.php'>Home</a>
                    </li>
                    <li class='active'>Jugos</li>
                </ol>
            </div>
        </div>
        <div class='row'>
        <div class='col-md-8'>";
    foreach($data as $row)
		{
			$tabla.="<div class='row'>
            <div class='col-md-4'>
                <a href='save.php?id=".base64_encode($row['id_jugo'])."'>
                    <img class='img-responsive img-hover' src='data:image/*;base64,$row[imagen]' alt=''>
                </a>
            </div>
            <div class='col-md-8'>
                <h3>$row[nombre_jugo]</h3>
                <p>$row[descripcion_jugo]</p>
                <a class='btn btn-primary' href='save.php?id=".base64_encode($row['id_jugo'])."'>Editar</i></a>
                <a class='btn btn-primary' href='delete.php?id=".base64_encode($row['id_jugo'])."'>Eliminar</i></a>
            </div>
        </div><hr>";
		}
		$tabla.="</div><div class='col-md-4'><div class='well'>
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
		print $tabla;
}
page::footer();
?>