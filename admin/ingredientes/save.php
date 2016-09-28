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


        <form class="form-labels-on-top" autocomplete="off" enctype='multipart/form-data' onkeyup="calcLong('nombre','label',this,30)" onkeydown="calcLong('descripcion','label',this,40)" name="nada" method="post" onsubmit="return Valida(this);">


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
    <script type="text/javascript">


    function Valida(formulario) {
                /* Validación de campos NO VACÍOS */
                if ((formulario.nombre.value.length == 0) || (formulario.descripcion.value.length == 0)) {
                    alert('Debe completar todos los campos.');
                    return false;
                } 

                else if ((formulario.nombre.value.length <= 3)) {
                    alert('El campo de Titulo debe contener al menos 3 Caracteres');
                    return false;
                } 

                else if ((formulario.descripcion.value.length <= 3)) {
                    alert('El campo de Titulo debe contener al menos 3 Caracteres');
                    return false;
                } 
 

               else if(formulario.nombre.value.match(/[a-zA-Z]/)){
                    alert('Solo se permiten letras en el Titulo.');
                    return false;
                }

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
         alert ("La extension de la imagen es correcta"); 
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