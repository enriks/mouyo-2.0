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
	$sql = "SELECT * FROM usuario WHERE alias like ? ORDER BY alias";
	$params = array("%$search%");
    $tabla.="<div class='container'>
    <hr>
    <div class='row'>
            <div class='col-lg-12'>
                <h1 class='page-header'>Usuarios
                    <small>Mouyo</small>
                </h1>
                <ol class='breadcrumb'>
                    <li><a href='../main/index.php'>Home</a>
                    </li>
                    <li><a href='index.php'>Usuarios</a></li>
                    <li class='active'>Busqueda del usuario '$search'</li>
                </ol>
            </div>
        </div>
        <div class='row'>
        <div class='col-md-9'>";
}
else
{
	$sql = "SELECT * FROM usuario ORDER BY alias";
	$params = null;
    $tabla="<div class='container'>
    <hr>
    <div class='row'>
            <div class='col-lg-12'>
                <h1 class='page-header'>Usuarios
                    <small>Mouyo</small>
                </h1>
                <ol class='breadcrumb'>
                    <li><a href='../main/index.php'>Página Principal</a>
                    </li>
                    <li class='active'>Usuarios</li>
                    <li><a type='button' href='save.php' class='btn btn-info'>Agregar un Usuario</a></li>
                </ol>
            </div>
        </div>
        <div class='row'>
        <div class='col-md-8'>";
}
$activo="";
$data=Database::getRows($sql,$params);
if($data != null)
{
    if($data['estado']==0)
    {
    	$act="Activo";
    }
    else
    {
    	$act="Inactivo";
    }
    $tabla.="<div class='row'>";
    foreach($data as $row)
		{
			$tabla.="
            <div class='col-md-4 text-center'>
                <div class='thumbnail'>
                    <img class='img-responsive' src='data:image/*;base64,$row[foto_perfil]' alt=''>
                    <div class='caption'>
                        <h3>$row[alias]<br>
                            <small>$row[nombre] $row[apellido]</small>
                        </h3>
                        <p>$row[correo]</p>

                        <p><strong>Estado:</strong>$act</p>
                        <a class='btn btn-primary' href='save.php?id=".base64_encode($row['id_usuario'])."'>Cambiar estado del usuario</i></a>

                        <ul class='list-inline'>
                            <li><a href='#'><i class='fa fa-2x fa-facebook-square'></i></a>
                            </li>
                            <li><a href='#'><i class='fa fa-2x fa-linkedin-square'></i></a>
                            </li>
                            <li><a href='#'><i class='fa fa-2x fa-twitter-square'></i></a>
                            </li>
                            
                        </ul>
                        <a class='btn btn-primary' href='save.php?id=".base64_encode($row['id_usuario'])."'>Editar</i></a>
                    

                    </div>
                </div>
            </div>
            
            ";
		}
		$tabla.="</div></div><div class='col-md-3'><div class='well'>
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
                    <a class='btn btn-success' type='button' href='../graficos/grafico_users.php'><i class='fa fa-pie-chart' aria-hidden='true'>Ver grafico de Usuarios</i></a>
                    <br>
                    <br>
                    <a class='btn btn-success' type='button' href='../pdf/pdfusuarios.php'><i class='fa fa-file-pdf-o' aria-hidden='true'> Ver lista en PDF</i></a>
                </div>
                
</div>";
    print($tabla);
}
else
{
    print("<div class='container'>
    <div class='row'>
            <div class='col-lg-12'>
                <h1 class='page-header'>Usuario
                    <small>Mouyo</small>
                </h1>
                <ol class='breadcrumb'>
                    <li><a href='../main/index.php'>Home</a>
                    </li>
                    <li><a href='index.php'>Usuario</a></li>
                    <li class='active'>Busqueda de '$search'</li>
                </ol>
            </div>
        </div>
        <div class='row'>
        <div class='col-md-9'><h2>No se encuentra ningun usuario con ese nombre.<a href='index.php'>Volver</a>                    
                </h2>");
}

Page::footer();
?>
 

