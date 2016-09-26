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
    <hr>
	 <div class='row'>
            <div class='col-lg-12'>
                <h1 class='page-header'>Tipo de Jugos
                    <small>Mouyo</small>
                </h1>
                <ol class='breadcrumb'>
                    <li><a href='../main/index.php'>Home</a>
                    </li>
                    <li><a href='index.php'>Tipos</a></li>
                    <li class='active'>Busqueda de '$search'</li>
                    <li><button type='button' class='btn'>Agregar Tipos de Jugos</button></li>
                </ol>
            </div>
        </div>
        <div class='row'>
        <div class='col-md-8'>";
}
else
{
    
	$sql = "SELECT * FROM tipo_jugo where estado=0 ORDER BY id_tipojugo";
	$params = null;
    $tabla="<div class='container'>
    <hr>
    <div class='row'>
            <div class='col-lg-12'>
                <h1 class='page-header'>Tipo de Jugos
                    <small>Mouyo</small>
                </h1>
                <ol class='breadcrumb'>
                    <li><a href='../main/index.php'>Página Principal</a>
                    </li>
                    <li class='active'>Tipos</li>
                    <li><a type='button' href='save.php' class='btn btn-info'>Agregar Tipos de Jugo</a></li>
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
            <div class='col-md-6'>
                <a href='save.php?id=".base64_encode($row['id_tipojugo'])."'>
               
                </a>
            </div>
            <div class='col-md-8'>
                <h3>$row[nombre]</h3>
                <h4>Descripción del Jugo</h4>
                <ul>
                    <li>$row[descripcion]</li>
                </ul>
                
                <a class='btn btn-primary' href='save.php?id=".base64_encode($row['id_tipojugo'])."'>Editar</i></a>
                <a class='btn btn-primary' href='delete.php?id=".base64_encode($row['id_tipojugo'])."'>Eliminar</i></a>
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

        <a class='btn btn-success' type='button' href='../pdf/pdftiposdejugos.php'><i class='fa fa-file-pdf-o' aria-hidden='true'> Ver lista en PDF</i></a>
</div>";
		
}
else
{
	$tabla.="<h2>No se encuentra ningun tipo de jugo con ese nombre <a href='index.php'>Volver</a>                    
                </h2>";
}
print $tabla;
page::footer();
?>