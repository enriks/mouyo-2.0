<?php<?php
ob_start();
require("../../lib/database.php");
require("../lib/verificador.php");
require("../lib/page.php");
Page::header();
$tabla="";
if(!empty($_POST))
{
    $search = trim($_POST['buscar']);
    $sql = "select * from cotizacion where pedido=2 and nombre like ? order by nombre";
    $params = array("%$search%");
    $tabla="<div class='container'>
    <hr>
    <div class='row'>
            <div class='col-lg-12'>
                <h1 class='page-header'>Pedidos
                    <small>Listado de pedidos</small>
                </h1>
                <ol class='breadcrumb'>
                    <li><a href='../main/index.php'>Página Principal</a>
                    </li>
                    <li><a href='index.php'>Pedidos</a></li>
                    <li><a href='descartados.php'>Descartados</a></li>
                     <li class='active'>Busqueda de '$search'</li>
                </ol>
            </div>
        </div>
        <div class='row'>
        <div class='col-md-8'>";
}
else
{
    $sql = "SELECT cotizacion.id_cotizacion,cotizacion.nombre nombre_cotizacion,usuario.nombre nombre_usuario,cotizacion.fecha,cotizacion.total FROM cotizacion,usuario WHERE cotizacion.id_usuario = usuario.id_usuario and pedido=2 order by cotizacion.nombre";
    $params = null;
    $tabla="<div class='container'>
    <hr>
    <div class='row'>
            <div class='col-lg-12'>
                <h1 class='page-header'>Pedidos
                    <small>Listado de pedidos</small>
                </h1>
                <ol class='breadcrumb'>
                    <li><a href='../main/index.php'>Página Principal</a>
                    </li>
                    <li class='active'>Procesados</li>
                    <li><a href='index.php'>Pedidos</a></li>
                    <li><a href='descartados.php'>Descartados</a></li>
                </ol>
            </div>
        </div>
        <div class='row'>
        <div class='col-md-8'>";
}
$tabla.="<div class='row'>
            <div class='col-sm-12'>
                <table class='table table-stripped'>
                    <thead>
                        <tr>
                            <th>Nombre de cotizacion</th>
                            <th>Total</th>
                            <th>Fecha</th>
                            <th>Nombre de usuario</th>
                        </tr>
                    </thead>
                    <thbody>";
$data = Database::getRows($sql, $params);
if($data != null)
{
    foreach($data as $row)
    {
        $tabla.="        
                        <tr>
                            <td>$row[nombre_cotizacion]</td>
                            <td>$row[total]</td>
                            <td>$row[fecha]</td>
                            <td>$row[nombre_usuario]</td>
                        </tr>";
    }
}
$tabla.="</thbody>
</table>
            </div>
        </div></div><div class='col-md-4'><div class='well'>
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
print $tabla;
page::footer();?>