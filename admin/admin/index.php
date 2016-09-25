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
	$sql = "SELECT * FROM admin WHERE estado=0 and alias like ? ORDER BY alias";
	$params = array("%$search%");
    $tabla.="<div class='container'>
    <hr>
    <div class='row'>
            <div class='col-lg-12'>
                <h1 class='page-header'>Administradores
                    <small>Mouyo</small>
                </h1>
                <ol class='breadcrumb'>
                    <li><a href='../main/index.php'>Home</a>
                    </li>
                    <li><a href='index.php'>Administradores</a></li>
                    <li class='active'>Busqueda del administrador '$search'</li>
                    <li><a type='button' href='save.php' class='btn btn-default'>Agregar un administrador</a></li>
                </ol>
            </div>
        </div>
        <div class='row'>
        <div class='col-md-9'>";
}
else
{
	$sql = "SELECT * FROM admin where estado=0 ORDER BY alias";
	$params = null;
    $tabla="<div class='container'>
    <hr>
    <div class='row'>
            <div class='col-lg-12'>
                <h1 class='page-header'>Administradores
                    <small>Mouyo</small>
                </h1>
                <ol class='breadcrumb'>
                    <li><a href='../main/index.php'>Página Principal</a>
                    </li>
                    <li class='active'>Promociones</li>
                    <li><a type='button' href='save.php' class='btn btn-info'>Agregar un administrador</a></li>
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
    $tabla.="";
    foreach($data as $row)
		{
			$tabla.="<div class='row'>
            <div class='col-md-3 col-sm-6'>
                <div class='panel panel-default text-center'>
                    <div class='panel-heading'>
                       <a href='save.php?id=".base64_encode($row['id_admin'])."'>
                    <img class='img-responsive img-hover' src='data:image/*;base64,$row[foto]' alt=''>
                </a> 
                    </div>
                    <div class='panel-body'>
                        <h4>$row[alias]</h4>
                        <a class='btn btn-primary' href='save.php?id=".base64_encode($row['id_admin'])."'>Editar</i></a>
                <a class='btn btn-primary' href='delete.php?id=".base64_encode($row['id_admin'])."'>Eliminar</i></a>
            </div>
        </div><hr>
                    </div>
                </div>
            ";
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
                    </div>
                      <a class='btn btn-success' type='button' href='../pdf/pdfadmins.php'><i class='fa fa-file-pdf-o' aria-hidden='true'> Ver lista en PDF</i></a>
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
 

