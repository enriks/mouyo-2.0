<?php
ob_start();
require("../lib/page.php");
require("../../lib/database.php");
require("../../lib/validator.php");
$fecha=date('Y-m-d H:i:s');
page::header();
/*Condiciones para relizar operaciones en jugos.php*/
if(empty($_GET['id'])) 
{
    $id = null;
    $nombre = null;
    $descripcion = null;
}
else
{
    $id = base64_decode($_GET['id']);
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

        <form class="form-labels-on-top" enctype='multipart/form-data' onkeyup="calcLongtitulo('nombre5','label',this,30)" onkeydown="calcLongdesc('descripcion', 'label', this,40)" name="nada" method="post" onsubmit="return Valida(this);">

            <div class="form-title-row">
                <h1>Tipos de Jugos</h1>
            </div>

            <div class="form-row">
                <label>
                    <span>Nombre del tipo de Jugo:</span>
                    <input type="text" name="nombre" required value="<?php print($nombre);?>">
                </label>
            </div>

            <div class="form-row">
                <label>
                    <span>Descripción:</span>
                    <textarea name="descripcion" cols="35" rows="6"><?php print($descripcion); ?></textarea>
                </label>
            </div>
            <div class="form-row">
                <button type="submit">Guardar</button>
                <button type="button"><a href="index.php" style="color:#fff;">Cancelar</a></button>
            </div>

        </form>

    </div>
     <script type="text/javascript">

     function Valida(formulario) {
                /* Validación de campos NO VACÍOS */
                if ((formulario.nombre5.value.length == 0) || (formulario.descripcion.value.length == 0)) {
                    alert('Debe completar todos los campos.');
                    return false;
                }    

                else if ((formulario.nombre5.value.length <= 5)) {
                    alert('El campo de Titulo debe contener al menos 10 Caracteres');
                    return false;
                }   

                 else if ((formulario.descripcion.value.length <= 5)) {
                    alert('El campo de descripcion debe contener al menos 5 Caracteres');
                    return false;
                } 

                else if(formulario.nombre5.value.match(/[a-zA-Z]/)){
                    alert('Solo se permiten letras en el Titulo.');
                    return false;
                } 
                /* si no hemos detectado fallo devolvemos TRUE */
                return true;
            }

      function calcLongtitulo(txt, dst, formul, maximo)

      {

      var largo

      largo = formul[txt].value.length

      if (largo > maximo)

      formul[txt].value = formul[txt].value.substring(0,maximo)

      formul[dst].value = formul[txt].value.length

      }

      function calcLongdesc(txt, dst, formul, maximo)

      {

      var largo

      largo = formul[txt].value.length

      if (largo > maximo)

      formul[txt].value = formul[txt].value.substring(0,maximo)

      formul[dst].value = formul[txt].value.length

      }
      </script>
    <?php page::footer();?>