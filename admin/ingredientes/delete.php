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
         $data=Database::getRow("select nombre from ingrediente where id_ingrediente=?",array($id));
        $alias=$data['nombre'];
		$sql2 = "INSERT INTO `historial` (`fecha`, `accion`, `id_admin`) VALUES(?, ?,?)";
        $params2=array($fecha,"Elimino el ingrediente $alias",$_SESSION['id_admin']);
        Database::executeRow($sql2, $params2);
		$sql = "update ingrediente set estado=1 WHERE id_ingrediente = ?";
	    $params = array($id);
	    Database::executeRow($sql, $params);
	    @header("location: index.php");
	} 
	catch (Exception $error) 
	{
		print("<div class='card-panel red'><i class='material-icons left'>error</i>".$error->getMessage()."</div>");
	}
}
	$sql = "SELECT * FROM ingrediente where estado=0 and id_ingrediente=? ORDER BY nombre";
	$params = array($id);

$data=Database::getRow($sql,$params);
if($data != null)
{
     $tabla="<div class='container'>
    <div class='row'>
            <div class='col-lg-12'>
                <h1 class='page-header'>Eliminar
                    <small>Ingredientes</small>
                </h1>
                <ol class='breadcrumb'>
                    <li><a href='../../main/index.php'>Página Principal</a>
                    </li>
                     <li><a href='index.php'>Ingredientes</a>
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
                <p>&nbsp;&nbsp;&nbsp;<strong>Eliminar?</strong></p>
                <form enctype='multipart/form-data' name='nada' method='post'>
                <input type='hidden' name='id' value='$id'/>
                <button type='sumbit' class='btn btn-danger'>Si</i></button>
                <a href='index.php' class='btn btn-danger'>No</i></a>
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
                    <small>Mantenimiento de los ingredientes</small>
                </h1>
                <ol class='breadcrumb'>
                    <li><a href='../main/index.php'>Home</a>
                    </li>
                    <li class='active'>Ingredientes</li>
                </ol>
            </div><h2>No se encuentra ninguna promocion con ese nombre <a href='index.php'>Volver</a>                    
                </h2>");
}

Page::footer();
?>