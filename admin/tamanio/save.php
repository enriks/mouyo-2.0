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
    $tamanio= htmlentities($data['tamanio']);
}

if(!empty($_POST))
{
     $_POST = Validator::validateForm($_POST);
     $tamanio=htmlentities($_POST['tamanio']);
    
    try
    {
        if( $tamanio == null)
        {
            throw new Exception("Datos incompletos");
        }
        elseif($id==null)
        {
            $sql2 = "INSERT INTO `historial` (`fecha`, `accion`, `id_admin`) VALUES(?, ?,?)";
        $params2=array($fecha,"Inserto el tamaño de $tamanio",$_SESSION['id_admin']);
        Database::executeRow($sql2, $params2);
            $sql = "INSERT INTO tamanio(tamanio) VALUES(?)";
            $params = array( $tamanio);
             Database::executeRow($sql, $params);
        @header("location: index.php");
        }
        else
        {
            $sql2 = "INSERT INTO `historial` (`fecha`, `accion`, `id_admin`) VALUES(?, ?,?)";
        $params2=array($fecha,"Modifico el tamaño de $tamanio",$_SESSION['id_admin']);
        Database::executeRow($sql2, $params2);
            $sql = "update tamanio set  tamanio=? where id_tamanio=?";
            $params = array( $tamanio, $id);
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

        <form class="form-labels-on-top" enctype='multipart/form-data' name="nada" onkeyup="calcLongtitulo('tamaño','label',this,30)" onkeydown="calcLongprec('precio', 'label', this,2)" method="post" onsubmit="return Valida(this);">

            <div class="form-title-row">
                <h1>Tamaños</h1>
            </div>

            <div class="form-row">
                <label>
                    <span>Titulo del Tamaño:</span>
                    <input type="text" name="tamanio" required value="<?php print($tamanio);?>">
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
                if ((formulario.tamaño.value.length == 0) || (formulario.precio.value.length ==0)) {
                    alert('Debe completar todos los campos.');
                    return false;
                } 

                else if(formulario.tamaño.value.match(/[a-zA-Z]/)){
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

      function calcLongprec(txt, dst, formul, maximo)

      {

      var largo

      largo = formul[txt].value.length

      if (largo > maximo)

      formul[txt].value = formul[txt].value.substring(0,maximo)

      formul[dst].value = formul[txt].value.length

      }
      </script>
    <?php page::footer();?>