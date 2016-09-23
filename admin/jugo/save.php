<?php
ob_start();
require("../../lib/database.php");
require("../../lib/validator.php");
require("../lib/page.php");

page::header();
$fecha=date('Y-m-d H:i:s');
if(empty($_GET['id'])) 
{
    $id=null;
    $nombre=null;
    $tipo=null;
    $archivo=null;
    $precio=null;
    $descripcion=null;
}
else
{
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
        print("<br><br><br> <div class='card-panel red'><i class='material-icons left'>error</i>".$error->getMessage()."</div>");
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
                    <span>Titulo del jugo:</span>
                    <input type="text" name="nombre" required value="<?php print($nombre);?>">
                </label>
            </div>

            <div class="form-row">
                <label>
                    <span>Descripcion</span>
                    <textarea name="descripcion" cols="35" rows="6"><?php print($descripcion); ?></textarea>
                </label>
            </div>

            <div class="form-row">
                <label><span>Tipo de jugo</span></label>
                <?php
                    $sql = "SELECT id_tipojugo,nombre FROM tipo_jugo";
                    Page::setCombo("tipo", $tipo, $sql);
                ?>
            </div>
            <div class="form-row">
               <label><span>Seleccione la imagen</span>
                <input type="file" name="imagen">
               </label>
            </div>
            <div class="form-row">
                <div class="input-group">
                    <label class="sr-only" for="exampleInputAmount">Amount (in dollars)</label>
                  <div class="input-group-addon">$</div>
                      <input type="number" name="precio" max="999" min='0' class="form-control" value="<?php print($precio);?>" placeholder="Precio">
                      <div class="input-group-addon">.00</div>
                </div>
            </div>
            <div class="form-row">
                <button type="submit">Guardar</button>
                <button type="button"><a href="index.php" style="color:#fff;">Cancelar</a></button>
            </div>

        </form>

    </div>
    <?php page::footer();?>