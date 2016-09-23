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
	$sql = "SELECT * FROM tamanio WHERE tamanio LIKE ? ORDER BY tamanio";
	$params = array("%$search%");
	$tabla.="<div class='container'>
	 <div class='row'>
            <div class='col-lg-12'>
                <h1 class='page-header'>Tamaños de Vasos
                    <small>Mouyo</small>
                </h1>
                <ol class='breadcrumb'>
                    <li><a href='../main/index.php'>Home</a>
                    </li>
                    <li><a href='index.php'>Tamaños</a></li>
                    <li class='active'>Busqueda de '$search'</li>
                    <li><button type='button' class='btn'>Agregar Tamaños</button></li>
                </ol>
            </div>
        </div>
        <div class='row'>
        <div class='col-md-9'>";
}
else
{
	$sql = "SELECT * FROM tamanio where estado=0 ORDER BY tamanio";
	$params = null;
    $tabla="<div class='container'>
    <div class='row'>
            <div class='col-lg-12'>
                <h1 class='page-header'>Tamaño de Vasos
                    <small>Mouyo</small>
                </h1>
                <ol class='breadcrumb'>
                    <li><a href='../main/index.php'>Página Principal</a>
                    </li>
                    <li class='active'>Tamaños</li>
                    <li><a type='button' href='save.php' class='btn btn-info'>Agregar Tamaños</a></li>
                </ol>
            </div>
        </div>
        <div class='row'>
        <div class='col-md-9'>";
}
$data = Database::getRows($sql, $params);
if($data != null)
{
    foreach($data as $row)
		{
			$tabla.="<div class='row'>
            <div class='col-md-6'>
                <a href='save.php?id=".base64_encode($row['id_tamanio'])."'>
               
                </a>
            </div>
            <div class='col-md-8'>
                <h3>$row[tamanio]</h3>
                <h4>Tamaño del Vaso</h4>
                <ul>
                    <li>$row[tamanio]</li>
                </ul>
                <h4>Precio del Vaso</h4>
                <ul>
                    <li>$row[precio]</li>
                </ul>
                <a class='btn btn-primary' href='save.php?id=".base64_encode($row['id_tamanio'])."'>Editar</i></a>
                <a class='btn btn-primary' href='delete.php?id=".base64_encode($row['id_tamanio'])."'>Eliminar</i></a>
            </div>
        </div><hr>";
		}
		$tabla.="</div><div class='col-md-4'><div class='well'>
        <a class='btn btn-success' type='button' href='repjugos.php'><i class='fa fa-pie-chart' aria-hidden='true'>Ver gráfico de Tamaños</i></a>
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
	$tabla.="<h2>No se encuentra ningun tamaño con ese nombre <a href='index.php'>Volver</a>                    
                </h2>";
}
print $tabla;
page::footer();
?>