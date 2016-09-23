<?php
ob_start();
require("../../lib/database.php");
require("../../lib/validator.php");
require("../lib/page.php");

page::header();
$fecha=date('Y-m-d H:i:s');
if(empty($_GET['id'])) 
{
    Page::header("Agregar Descuento");
    $id=null;
    $nombre=null;
    $jugo=null;
    $descuento=null;
    $fecha_inicio=null;
    $fecha_limite=null;
    $descripcion=null;
    
}
else
{
    Page::header("Modificar Descuento");
    $id = base64_decode($_GET['id']);
    $sql = "SELECT * FROM descuentos WHERE id_descuento = ?";
    $params = array($id);
    $data = Database::getRow($sql, $params);
    $nombre=htmlentities($data['nombre']);
    $jugo=htmlentities($data['id_jugo']);
    $descuento=htmlentities($data['descuento']);
    $fecha_inicio=htmlentities($data['fecha_inicio']);
    $originalDate = "$fecha_inicio";
    $newDate = date("Y-m-d", strtotime($originalDate));
    $fecha_inicio=$newDate;
    $fecha_limite=htmlentities($data['fecha_limite']);
    $originalDate = "$fecha_limite";
    $newDate = date("Y-m-d", strtotime($originalDate));
    $fecha_inicio=$newDate;
}

if(!empty($_POST))
{
     $_POST = Validator::validateForm($_POST);
     $nombre=$_POST['nombre'];
     $jugo=htmlentities($_POST['jugo']);
     $descuento=htmlentities($_POST['descuento']);
     $fecha_inicio=htmlentities($_POST['fecha_inicio']);
    $originalDate = $fecha_inicio;
    $newDate = date("Y-m-d", strtotime($originalDate));
    $fecha_inicio=$newDate;
     $fecha_limite=htmlentities($_POST['fecha_limite']);
    $originalDate = $fecha_limite;
    $newDate = date("Y-m-d", strtotime($originalDate));
    $fecha_inicio=$newDate;
    try
    {
        if($nombre == null || $jugo == null || $descuento == null || $fecha_inicio == null || $fecha_limite == null )
        {
            throw new Exception("Datos incompletos");
        }
        
        if($id==null)
        {
            
                $sql = "INSERT INTO descuentos(nombre,id_jugo,descuento,fecha_inicio,fecha_limite) VALUES(?,?,?,?,?)";
                $params = array($nombre,$jugo,$descuento,$fecha_inicio,$fecha_limite);
            $sql2 = "INSERT INTO `historial` (`fecha`, `accion`, `id_admin`) VALUES(?, ?,?)";
        $params2=array($fecha,"Inserto el descuento $nombre",$_SESSION['id_admin']);
        Database::executeRow($sql2, $params2);
            Database::executeRow($sql, $params);
        @header("location: index.php");
        }
        else
        {
            $sql = "update descuentos set nombre=?, id_jugo=?,descuento=?,fecha_inicio=?,fecha_limite=? where id_descuento=?";
            $params = array($nombre,$jugo,$descuento,$fecha_inicio,$fecha_limite,$id);
            Database::executeRow($sql, $params);
            $sql2 = "INSERT INTO `historial` (`fecha`, `accion`, `id_admin`) VALUES(?, ?,?)";
        $params2=array($fecha,"Modifico el descuento $nombre",$_SESSION['id_admin']);
        Database::executeRow($sql2, $params2);
        @header("location: index.php");
        }
         
    }
    catch (Exception $error)
    {
        print("<br><br><br><br><div class='card-panel red'><i class='material-icons left'>error</i>".$error->getMessage()."</div>");
    }
}
?>
<br><br>
<div class="main-content">

        <!-- You only need this form and the form-basic.css -->

        <form class="form-labels-on-top" enctype='multipart/form-data' name="nada" method="post">

            <div class="form-title-row">
                <h1>Descuento</h1>
            </div>

            <div class="form-row">
                <label>
                    <span>Titulo del descuento:</span>
                    <input type="text" name="nombre" required value="<?php print($nombre);?>">
                </label>
            </div>

            <div class="form-row">
                <label><span>Selecciona el jugo para descuento</span></label>
                <?php
                    $sql = "SELECT id_jugo,nombre FROM jugos where estado=0";
                    Page::setCombo("jugo", $jugo, $sql);
                ?>
            </div>
            
            <div class="form-row">
                <label>
                    <span>Fecha incio</span>
                    <input type="date" name="fecha_inicio" required value="<?php print($fecha_inicio);?>">
                </label>
            </div>

            <div class="form-row">
                <label>
                    <span>Fecha limite</span>
                    <input type="date" name="fecha_limite" required value="<?php print($fecha_limite);?>">
                </label>
            </div>

            <div class="form-row">
                <div class="input-group">
                    <label class="sr-only" for="exampleInputAmount">Descuento (en porcentaje)</label>
                  <div class="input-group-addon">%</div>
                      <input type="number" name="descuento" max="99" min='0' class="form-control" value="<?php print($descuento);?>" placeholder="Descuento">
                </div>
            </div>
            <div class="form-row">
                <button type="submit">Guardar</button>
                <button type="button"><a href="index.php" style="color:#fff;">Cancelar</a></button>
            </div>

        </form>

    </div>
    <?php page::footer();?>