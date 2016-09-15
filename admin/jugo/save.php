<?php
ob_start();
require("../../lib/database.php");
require("../../lib/validator.php");
require("../lib/page.php");

page::header();
$fecha=date('Y-m-d H:i:s');
if(empty($_GET['id'])) 
{
    Page::header("Agregar Jugo");
    $id=null;
    $nombre=null;
    $tipo=null;
    $archivo=null;
    $precio=null;
    $descripcion=null;
}
else
{
    Page::header("Modificar Jugo");
    $id = base64_decode($_GET['id']);
    $sql = "SELECT * FROM jugos WHERE id_jugo = ?";
    $params = array($id);
    $data = Database::getRow($sql, $params);
    $nombre = htmlentities($data['nombre']);
    $tipo =  htmlentities($data['id_tipojugo']);
    $archivo=$data['imagen'];
    $precio= htmlentities($data['precio']);
    $descripcion= htmlentities($data['descripcion']);
}

if(!empty($_POST))
{
     $_POST = Validator::validateForm($_POST);
     $nombre= htmlentities($_POST['nombre']);
     $tipo= htmlentities($_POST['tipo']);
     $archivo=$_FILES['imagen'];
     $precio= htmlentities($_POST['precio']);
     $descripcion= htmlentities($_POST['descripcion']);
    
    try
    {
        if($nombre == null || $tipo == null || $precio == null)
        {
            throw new Exception("Datos incompletos");
        }
        elseif($precio < 1)
        {
            throw new Exception("El precio debe ser mayor a 1");
        }
        elseif( $archivo['name'] != null)
        {
            $base64 = Validator::validateImage($archivo);
            if($base64 != false)
            {
                $imagen = $base64;
            }
            else
            {
                throw new Exception("La imagen seleccionada no es valida.");
            }
        }
        
        if($id==null)
        {
            if(isset($imagen) != null)
            {
            $sql = "INSERT INTO jugos (nombre, id_tipojugo,precio,imagen,descripcion) VALUES(?,?,?,?,?)";
            $params = array($nombre, $tipo,$precio,$imagen,$descripcion);
                Database::executeRow($sql, $params);
                $sql2 = "INSERT INTO `historial` (`fecha`, `accion`, `id_admin`) VALUES(?, ?,?)";
        $params2=array($fecha,"Inserto el jugo $nombre",$_SESSION['id_admin']);
        Database::executeRow($sql2, $params2);
                @header("location: index.php");
            }
            else
            {
                throw new Exception("Selecccione una imagen.");
            }
        }
        else
        {
            if(isset($imagen) != null)
            {    
                $sql = "update jugos set nombre=?, id_tipojugo=?,precio=?,imagen=?,descripcion=? where id_jugo=?";
                $params = array($nombre, $tipo,$precio,$imagen,$descripcion,$id);
                Database::executeRow($sql, $params);
                 $sql2 = "INSERT INTO `historial` (`fecha`, `accion`, `id_admin`) VALUES(?, ?,?)";
        $params2=array($fecha,"Modifico el jugo $nombre",$_SESSION['id_admin']);
        Database::executeRow($sql2, $params2);
                @header("location: index.php");
            }
            else
            {
                $sql = "update jugos set nombre=?, id_tipojugo=?,precio=?,descripcion=? where id_jugo=?";
                $params = array($nombre, $tipo,$precio,$descripcion,$id);
                Database::executeRow($sql, $params);
                 $sql2 = "INSERT INTO `historial` (`fecha`, `accion`, `id_admin`) VALUES(?, ?,?)";
        $params2=array($fecha,"Modifico el jugo $nombre",$_SESSION['id_admin']);
        Database::executeRow($sql2, $params2);
                @header("location: index.php");
            }
        }
         
    }
    catch (Exception $error)
    {
        print("<div class='card-panel red'><i class='material-icons left'>error</i>".$error->getMessage()."</div>");
    }
}
?>
<div class="main-content">

        <!-- You only need this form and the form-basic.css -->

        <form class="form-labels-on-top" enctype='multipart/form-data' name="nada" method="post">

            <div class="form-title-row">
                <h1>Jugos</h1>
            </div>

            <div class="form-row">
                <label>
                    <span>Titulo del jugo:</span>
                    <input type="text" name="nombre" required value="<?php print($nombre);?>">
                </label>
            </div>

            <div class="form-row">
                <label>
                    <span>Descripcion</span>
                    <textarea name="descripcion" rows="5"><?php print($descripcion); ?></textarea>
                </label>
            </div>

            <div class="form-row">
                <label><span>Promocion</span></label>
                <div class="form-radio-buttons">

                    <div>
                        <label>
                            <input type="radio" name="activo" value="0" <?php print $actcheck;?>>
                            <span>Activa</span>
                        </label>
                    </div>

                    <div>
                        <label>
                            <input type="radio" name="activo" value="1" <?php print $inaccheck;?>>
                            <span>Inactiva</span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group form-row" style="background-color:white;">
                <input type="file" name="imagen">
            </div>
            <div class="form-row">
                <button type="button"><a href="index.php">Cancelar</a></button>
                <button type="submit">Guardar</button>
            </div>

        </form>

    </div>
    <?php page::footer();?>