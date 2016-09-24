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

        <form class="form-labels-on-top" autocomplete="off" enctype='multipart/form-data' onkeyup="calcLong('nombre', 'label', this,30)" onkeydown="calcLong('descripcion', 'label', this,40)" name="nada" method="post" onsubmit="return Valida(this);">

            <div class="form-title-row">
                <h1>Jugos</h1>
            </div>

            <div class="form-row">
                <label>
                    <span>Titulo:</span>
                    <input type="text" name="nombre" required value="<?php print($nombre);?>">
                </label>
            </div>

            <div class="form-row">
                <label>
                    <span>Descripcion</span>
                    <textarea name="descripcion" cols="35" rows="6"><?php print($descripcion); ?></textarea>
                </label>
            </div>

            <div class="form-row" id="combo">
                <label><span>Tipo de jugo</span></label>
                <?php
                    $sql = "SELECT id_tipojugo,nombre FROM tipo_jugo";
                    Page::setCombo("tipo", $tipo, $sql);
                ?>
            </div>
            <div class="form-row">
               <label><span>Seleccione la imagen</span>
                <input type="file" name="imagen" onchange="comprueba_extension(this.form, this.form.imagen.value)">
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
    <script type="text/javascript">

    function Valida(formulario) {
                /* Validación de campos NO VACÍOS */
                if ((formulario.nombre.value.length == 0) || (formulario.descripcion.value.length ==0) || (formulario.combo.value.length ==0) || (formulario.precio.value.length ==0)) {
                    alert('Debe completar todos los campos y Cajones.');
                    return false;
                }   
                if (isNaN(parseInt(formulario.precio.value))) {
                    alert('El campo de precio debe ser Numerico.');
                    return false;
                }  
                /* validación del e-mail */
                var ercorreo=/^[^@\s]+@[^@\.\s]+(\.[^@\.\s]+)+$/;          
                if (!(ercorreo.test(formulario.email.value))) {  
                    alert('Contenido del email no es CORREO ELECTR&Oacute;NICO v&aacute;lido.');
                    return false; }
                /* si no hemos detectado fallo devolvemos TRUE */
                return true;
            }

    function comprueba_extension(formulario, archivo) { 
   extensiones_permitidas = new Array(".gif", ".jpg", ".doc", ".pdf"); 
   mierror = ""; 
   if (!archivo) { 
      //Si no tengo archivo, es que no se ha seleccionado un archivo en el formulario 
      	mierror = "No has seleccionado ningún archivo"; 
   }else{ 
      //recupero la extensión de este nombre de archivo 
      extension = (archivo.substring(archivo.lastIndexOf("."))).toLowerCase(); 
      //alert (extension); 
      //compruebo si la extensión está entre las permitidas 
      permitida = false; 
      for (var i = 0; i < extensiones_permitidas.length; i++) { 
         if (extensiones_permitidas[i] == extension) { 
         permitida = true; 
         break; 
         } 
      } 
      if (!permitida) { 
         mierror = "Comprueba la extensión de los archivos a subir. \nSólo se pueden subir archivos con extensiones: " + extensiones_permitidas.join(); 
      	}else{ 
         	//submito! 
         alert ("Todo correcto. Voy a submitir el formulario."); 
         formulario.submit(); 
         return 1; 
      	} 
   } 
   //si estoy aqui es que no se ha podido submitir 
   alert (mierror); 
   return 0; 
}

function calcLong(txt, dst, formul, maximo)

      {

      var largo

      largo = formul[txt].value.length

      if (largo > maximo)

      formul[txt].value = formul[txt].value.substring(0,maximo)

      formul[dst].value = formul[txt].value.length

      }

      </script>
    <?php page::footer();?>