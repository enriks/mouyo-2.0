<?php
ob_start();
require("../lib/page.php");
require("../../lib/database.php");
require("../lib/verificador.php");
Page::header();

if(!empty($_POST))
{
    $id = $_POST['id'];
	try 
	{
        $data=Database::getRow("select titulo from promociones where id_promocion=?",array($id));
        $alias=$data['titulo'];
		$sql2 = "INSERT INTO `historial` (`fecha`, `accion`, `id_admin`) VALUES(?, ?,?)";
        $params2=array($fecha,"Elimino la promocion $alias",$_SESSION['id_admin']);
        Database::executeRow($sql2, $params2);
		$sql = "update promociones set estado=1 WHERE id_promocion = ?";
	    $params = array($id);
	    Database::executeRow($sql, $params);
	    @header("location: index.php");
	} 
	catch (Exception $error) 
	{
		print("<div class='card-panel red'><i class='material-icons left'>error</i>".$error->getMessage()."</div>");
	}
}
$id=base64_decode($_GET['id']);
	$sql = "SELECT * FROM promociones where estado=0 and id_promocion=? ORDER BY titulo";
	$params = array($id);

$activo="";
$data=Database::getRow($sql,$params);
if($data != null)
{
     $tabla="<div class='container'>
    <div class='row'>
            <div class='col-lg-12'>
                <h1 class='page-header'>Eliminar
                    <small>Promocion</small>
                </h1>
                <ol class='breadcrumb'>
                    <li><a href='../../main/index.php'>Página Principal</a>
                    </li>
                     <li><a href='index.php'>Promociones</a>
                    </li>
                    <li class='active'>Eliminar</li>
                </ol>
            </div>
        </div>
        <div class='row'>
        <div class='col-md-8'>";
            if($data['activo']==0)
            {
                $activo="Vigente (Activo)";
            }
            else
            {
                $activo="Inactivo";
            }
			$tabla.="
            <div class='col-md-8'>
                    <img class='img-responsive img-hover' src='data:image/*;base64,$data[imagen]' alt=''>
            </div>
            <div class='col-md-4'>
                <h2><strong>$data[titulo]</strong></h2>
                <h3>Descripcion</h3>
                <ul>
                    <li>$data[descripcion]</li>
                </ul>
                <p><strong>Estado:</strong>$activo</p>
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
 