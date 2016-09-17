<?php
ob_start();
require("../lib/page.php");
require("../../lib/database.php");
require("../lib/verificador.php");
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
         $data=Database::getRow("select nombre from jugos where id_jugo=?",array($id));
        $alias=$data['nombre'];
		$sql2 = "INSERT INTO `historial` (`fecha`, `accion`, `id_admin`) VALUES(?, ?,?)";
        $params2=array($fecha,"Elimino el jugo $alias",$_SESSION['id_admin']);
        Database::executeRow($sql2, $params2);
        $sql2="update comentarios set estado=1 where id_jugo=?";
        $params2=array($id);
		$sql3="update detalle_bebida set estado=1 where id_jugo=?";
		$sql = "update jugos set estado=1 WHERE id_jugo = ?";
	    $params = array($id);
        Database::executeRow($sql2,$params);
	    Database::executeRow($sql3,$params);
	    Database::executeRow($sql, $params);
	    @header("location: index.php");
	} 
	catch (Exception $error) 
	{
		print("<div class='card-panel red'><i class='material-icons left'>error</i>".$error->getMessage()."</div>");
	}
}
$id=base64_decode($_GET['id']);
	$sql = "SELECT * FROM jugos where estado=0 and id_jugo=? ORDER BY nombre";
	$params = array($id);

$data=Database::getRow($sql,$params);
if($data != null)
{
     $tabla="<div class='container'>
    <div class='row'>
            <div class='col-lg-12'>
                <h1 class='page-header'>Eliminar
                    <small>Jugo</small>
                </h1>
                <ol class='breadcrumb'>
                    <li><a href='../../main/index.php'>Home</a>
                    </li>
                     <li><a href='index.php'>Promociones</a>
                    </li>
                    <li class='active'>Eliminar</li>
                </ol>
            </div>
        </div>
        <div class='row'>";
			$tabla.="
            <div class='col-md-6'>
                    <img class='img-responsive img-hover' src='data:image/*;base64,$data[imagen]' alt=''>
            </div>
            <div class='col-md-4'>
                <h2><strong>$data[nombre]</strong></h2>
                <h3>Descripcion</h3>
                <ul>
                    <li>$data[descripcion]</li>
                </ul>
                <h3>Precio</h3>
                <ul>
                    <li>$data[precio]</li>
                </ul>
                <p>&nbsp;&nbsp;&nbsp;<strong>Eliminar?</strong></p>
                <form enctype='multipart/form-data' name='nada' method='post'>
                <input type='hidden' name='id' value='<?php print($id); ?>'/>
                <button type='sumbit' class='btn btn-primary'>Si</i></button>
                <a href='index.php' class='btn btn-primary'>No</i></a>
                </form>
            </div>
        <hr>
		</div>
</div>";
    print($tabla);
}
else
{
    print("<div class='col-lg-12'>
                <h1 class='page-header'>Jugos
                    <small>Mantenimiento de los jugos</small>
                </h1>
                <ol class='breadcrumb'>
                    <li><a href='../main/index.php'>Home</a>
                    </li>
                    <li class='active'>Jugos</li>
                </ol>
            </div><h2>No se encuentra ninguna promocion con ese nombre <a href='index.php'>Volver</a>                    
                </h2>");
}

Page::footer();
?>