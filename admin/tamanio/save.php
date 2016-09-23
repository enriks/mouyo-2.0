<?php
ob_start();
require("../lib/page.php");
require("../../lib/database.php");
require("../../lib/validator.php");
$fecha=date('Y-m-d H:i:s');
/*operaciones para tamañio*/

if(empty($_GET['id'])) 
{
    Page::header("Agregar Tamaño de Bebida");
    $id=null;
    $precio=null;
    $tamanio=null;
}
else
{
    Page::header("Modificar Tamaño de Bebida");
    $id = $_GET['id'];
    $sql = "SELECT * FROM tamanio WHERE id_tamanio = ?";
    $params = array($id);
    $data = Database::getRow($sql, $params);
    $precio = htmlentities($data['precio']);
    $tamanio= htmlentities($data['tamanio']);
}

if(!empty($_POST))
{
     $_POST = Validator::validateForm($_POST);
     $precio=htmlentities($_POST['precio']);
     $tamanio=htmlentities($_POST['tamanio']);
    
    try
    {
        if($precio == null || $tamanio == null)
        {
            throw new Exception("Datos incompletos");
        }
        elseif($id==null)
        {
            $sql2 = "INSERT INTO `historial` (`fecha`, `accion`, `id_admin`) VALUES(?, ?,?)";
        $params2=array($fecha,"Inserto el tamaño de $tamanio",$_SESSION['id_admin']);
        Database::executeRow($sql2, $params2);
            $sql = "INSERT INTO tamanio(precio,tamanio) VALUES(?,?)";
            $params = array($precio, $tamanio);
             Database::executeRow($sql, $params);
        @header("location: index.php");
        }
        else
        {
            $sql2 = "INSERT INTO `historial` (`fecha`, `accion`, `id_admin`) VALUES(?, ?,?)";
        $params2=array($fecha,"Modifico el tamaño de $tamanio",$_SESSION['id_admin']);
        Database::executeRow($sql2, $params2);
            $sql = "update tamanio set precio=?, tamanio=? where id_tamanio=?";
            $params = array($precio, $tamanio, $id);
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
                <h1>Tamaños</h1>
            </div>

            <div class="form-row">
                <label>
                    <span>Titulo del Tamaño:</span>
                    <input type="text" name="tamaño" required value="<?php print($tamanio);?>">
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