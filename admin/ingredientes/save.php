<?php
ob_start();
require("../../lib/database.php");
require("../../lib/validator.php");
require("../lib/page.php");

page::header();
$fecha=date('Y-m-d H:i:s');
if(empty($_GET['id'])) 
{
    Page::header("Agregar Ingrediente");
    $id=null;
    $nombre=null;
    $descripcion=null;
    $archivo=null;
}
else
{
    Page::header("Modificar Ingrediente");
    $id = base64_decode($_GET['id']);
    $sql = "SELECT * FROM ingrediente WHERE id_ingrediente = ?";
    $params = array($id);
    $data = Database::getRow($sql, $params);
    $nombre = htmlentities($data['nombre']);
    $descripcion = htmlentities($data['descripcion']);
    $archivo=$data['imagen'];
}

if(!empty($_POST))
{
     $_POST = Validator::validateForm($_POST);
     $nombre= htmlentities($_POST['nombre']);
     $descripcion= htmlentities($_POST['descripcion']);
     $archivo = $_FILES['imagen'];
    
    try
    {
        if($nombre == null || $descripcion == null )
        {
            throw new Exception("Datos incompletos");
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
            $sql2 = "INSERT INTO `historial` (`fecha`, `accion`, `id_admin`) VALUES(?, ?,?)";
        $params2=array($fecha,"Inserto el ingrediente $nombre",$_SESSION['id_admin']);
        Database::executeRow($sql2, $params2);
            $sql = "INSERT INTO `ingrediente` (`nombre`, `descripcion`,imagen) VALUES(?,?,?)";
            $params = array($nombre, $descripcion,$imagen);
             Database::executeRow($sql, $params);
        header("location: index.php");
        }
        else
        {
            if(isset($imagen))
            {
                
            $sql2 = "INSERT INTO `historial` (`fecha`, `accion`, `id_admin`) VALUES(?, ?,?)";
        $params2=array($fecha,"Modifico el ingrediente $nombre",$_SESSION['id_admin']);
        Database::executeRow($sql2, $params2);
            $sql = "update ingrediente set nombre=?, descripcion=? where id_ingrediente=?";
            $params = array($nombre, $descripcion,$id);
             Database::executeRow($sql, $params);
        header("location: index.php");
            }
            else
            {
                $sql2 = "INSERT INTO `historial` (`fecha`, `accion`, `id_admin`) VALUES(?, ?,?)";
        $params2=array($fecha,"Modifico el ingrediente $nombre",$_SESSION['id_admin']);
        Database::executeRow($sql2, $params2);
            $sql = "update ingrediente set nombre=?, descripcion=?,imagen=? where id_ingrediente=?";
            $params = array($nombre, $descripcion,$imagen,$id);
             Database::executeRow($sql, $params);
        header("location: index.php");
            }
        }
        
    }
    catch (Exception $error)
    {
        print("<br><br><br><div class='card-panel red'><i class='material-icons left'>error</i>".$error->getMessage()."</div>");
    }
}
?>
<br><br>
<div class="main-content">

        <!-- You only need this form and the form-basic.css -->


        <form class="form-labels-on-top" autocomplete="off" enctype='multipart/form-data' onkeyup="calcLong('nombre','label',this,30)" onkeydown="calcLong('descuento','input',this,2)" name="nada" method="post" onsubmit="return Valida(this);">


            <div class="form-title-row">
                <h1>Ingrediente</h1>
            </div>

            <div class="form-row">
                <label>
                    <span>Titulo del ingrediente:</span>
                    <input type="text" name="nombre" minlength="10" required value="<?php print($nombre);?>">
                </label>
            </div>
             
             <div class="form-row">
                <label>
                    <span>Descripcion</span>
                    <textarea name="descripcion" cols="35" rows="6"><?php print($descripcion); ?></textarea>
                </label>
            </div>
            
            <div class="form-row">
               <label><span>Seleccione la imagen</span>
                <input type="file" name="imagen" onchange="comprueba_extension(this.form, this.form.imagen.value)">
               </label>
            </div>

            <div class="form-row">
                <button type="submit">Guardar</button>
                <button type="button"><a href="index.php" style="color:#fff;">Cancelar</a></button>
            </div>

        </form>

    </div>
<?php page::footer();?>