<?php
ob_start();
require("../lib/page.php");
require("../../lib/database.php");
require("../../lib/validator.php");
$fecha=date('Y-m-d H:i:s');
/*Condiciones para relizar operaciones en jugos.php*/
if(empty($_GET['id'])) 
{
    Page::header("Agregar Tipo de Jugo");
    $id = null;
    $nombre = null;
    $descripcion = null;
}
else
{
    Page::header("Modificar Tipo de Jugo");
    $id = $_GET['id'];
    $sql = "SELECT * FROM tipo_jugo WHERE id_tipojugo = ?";
    $params = array($id);
    $data = Database::getRow($sql, $params);
    $nombre = htmlentities($data['nombre']);
    $descripcion = htmlentities($data['descripcion']);
}

if(!empty($_POST))
{
    $_POST = Validator::validateForm($_POST);
  	$nombre = htmlentities($_POST['nombre']);
  	$descripcion = htmlentities($_POST['descripcion']);
    if($descripcion == "")
    {
        $descripcion = null;
    }

    try 
    {
      	if($nombre == "")
        {
            throw new Exception("Datos incompletos.");
        }
        elseif($id == null)
        {
            $sql2 = "INSERT INTO `historial` (`fecha`, `accion`, `id_admin`) VALUES(?, ?,?)";
        $params2=array($fecha,"Inserto el tipo de jugo $nombre",$_SESSION['id_admin']);
        Database::executeRow($sql2, $params2);
        	$sql = "INSERT INTO tipo_jugo(nombre, descripcion) VALUES(?, ?)";
            $params = array($nombre, $descripcion);
            Database::executeRow($sql, $params);
        @header("location: index.php");
        }
        else
        {
            $sql2 = "INSERT INTO `historial` (`fecha`, `accion`, `id_admin`) VALUES(?, ?,?)";
        $params2=array($fecha,"Modifico el tipo de jugo $nombre",$_SESSION['id_admin']);
        Database::executeRow($sql2, $params2);
            $sql = "UPDATE tipo_jugo SET nombre = ?, descripcion = ? WHERE id_tipojugo = ?";
            $params = array($nombre, $descripcion, $id);
            Database::executeRow($sql, $params);
        @header("location: index.php");
        }
        
    }
    catch (Exception $error)
    {
        print("<div class='card-panel red'><i class='material-icons left'>error</i>".$error->getMessage()."</div>");
    }
}
?>
<br><br>
<div class="main-content">

        <!-- You only need this form and the form-basic.css -->

        <form class="form-labels-on-top" enctype='multipart/form-data' name="nada" method="post">

            <div class="form-title-row">
                <h1>Jugos</h1>
            </div>

            <div class="form-row">
                <label>
                    <span>Nombre del tipo de Jugo:</span>
                    <input type="text" name="nombre5" required value="<?php print($nombre);?>">
                </label>
            </div>

            <div class="form-row">
                <label>
                    <span>Descripción:</span>
                    <textarea name="descripcion" cols="35" rows="6"><?php print($descripcion); ?></textarea>
                </label>
            </div>
            <div class="form-row">
                <button type="button"><a href="index.php" style="color:#fff;">Cancelar</a></button>
                <button type="submit">Guardar</button>
            </div>

        </form>

    </div>
    <?php page::footer();?>