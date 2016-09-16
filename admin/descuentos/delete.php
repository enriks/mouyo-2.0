<?php
ob_start();
require("../../lib/database.php");
require("../lib/verificador.php");
require("../lib/page.php");
Page::header();
$fecha=date('Y-m-d H:i:s');
if(!empty($_GET['id'])) 
{
    $id = base64_decode($_GET['id']);
}
else
{
    @header("location: index.php");
}
if(!empty($_POST))
{
	$id = $_POST['id'];
	try 
	{
        $data=Database::getRow("select nombre from descuentos where id_descuento=?",array($id));
        $alias=$data['nombre'];
		$sql2 = "INSERT INTO `historial` (`fecha`, `accion`, `id_admin`) VALUES(?, ?,?)";
        $params2=array($fecha,"Elimino el descuento $alias",$_SESSION['id_admin']);
        Database::executeRow($sql2, $params2);
		$sql = "update descuentos set estado=1 WHERE id_descuento = ?";
	    $params = array($id);
	    Database::executeRow($sql, $params);
	    @header("location: index.php");
	} 
	catch (Exception $error) 
	{
		print("<div class='card-panel red'><i class='material-icons left'>error</i>".$error->getMessage()."</div>");
	}
}
$tabla="";

    $sql="select descuentos.id_jugo,descuentos.id_descuento,descuentos.fecha_inicio, descuentos.fecha_limite,jugos.imagen,jugos.nombre nombre_jugo,descuentos.nombre,jugos.precio, descuentos.descuento from jugos, descuentos where descuentos.id_jugo = jugos.id_jugo and descuentos.estado=0";
    $params = null;
    $tabla="<div class='container'>
    <div class='row'>
            <div class='col-lg-12'>
                <h1 class='page-header'>Jugos
                    <small>Mantenimiento de los jugos</small>
                </h1>
                <ol class='breadcrumb'>
                    <li><a href='../main/index.php'>Home</a>
                    </li>
                    <li><a href='index.php'>Descuentos</a></li>
                    <li class='active'>Eliminar</li>
                     <li><button type='button' class='btn'>Agregar un nuevo 
                     Descuento</button></li>
                </ol>
            </div>
        </div>
        <div class='row'>
        <div class='col-md-8'>";
$data = Database::getRow($sql, $params);
if($data != null)
{
    $tabla.="<div class='row'>
    <div class='col-md-4'>
            <img class='img-responsive img-hover' src='data:image/*;base64,$data[imagen]' alt=''>
    </div>
    <div class='col-md-8'>
        <h3>$data[nombre]</h3>
        <h4>Aplicado al jugo</h4>
        <ul>
            <li>$data[nombre_jugo]</li>
        </ul>
        <p><strong>Fecha de Inicio:</strong> $data[fecha_inicio] <strong>Fecha limite:</strong> $data[fecha_limite]</p>
        <p><strong>Descuento (%):</strong> $data[descuento]%</p>
        <p>&nbsp;&nbsp;&nbsp;<strong>Eliminar?</strong></p>
        <form enctype='multipart/form-data' name='nada' method='post'>
        <input type='hidden' name='id' value='<?php print($id); ?>'/>
        <button type='sumbit' class='btn btn-primary'>Si</i></button>
        <a href='index.php' class='btn btn-primary'>No</i></a>
    </div>
</div><hr>";
		}
    $tabla.="</div>
</div>";
		

print $tabla;
page::footer();
?>