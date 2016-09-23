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
    $titulo=null;
    $descripcion=null;
    $archivo=null;
}
else
{
    $id = base64_decode($_GET['id']);
    $sql = "SELECT * FROM promociones WHERE id_promocion = ?";
    $params = array($id);
    $data = Database::getRow($sql, $params);
    $titulo =  htmlentities($data['titulo']);
    $descripcion =  htmlentities($data['descripcion']);
    $archivo= $data['imagen'];
    $activo=$data['activo'];
    if($activo==0)
    {
    	$actcheck="checked";
    	$inaccheck='';
    }
    else
    {
    	$inaccheck="checked";
    	$actcheck="";
    }
}

if(!empty($_POST))
{
     $_POST = Validator::validateForm($_POST);
     $titulo= htmlentities($_POST['titulo']);
     $descripcion= htmlentities($_POST['descripcion']);
     $archivo=$_FILES['imagen'];
     $activo=$_POST['activo'];
    
    try
    {
        if($titulo == null || $descripcion == null)
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
        $params2=array($fecha,"Inserto la promocion $titulo",$_SESSION['id_admin']);
        Database::executeRow($sql2, $params2);
            $sql = "INSERT INTO promociones(titulo,descripcion,imagen,activo) VALUES(?,?,?,?,?)";
            $params = array($titulo, $descripcion,$imagen,$activo);
            Database::executeRow($sql, $params);
        @header("location: index.php");
        }
        else
        {
        	if($archivo['name']!=null)
            {
            	$sql2 = "INSERT INTO `historial` (`fecha`, `accion`, `id_admin`) VALUES(?, ?,?)";
                    $params2=array($fecha,"Modifico la promocion $titulo",$_SESSION['id_admin']);
                    Database::executeRow($sql2, $params2);
                        $sql = "update promociones set titulo=?, descripcion=?,imagen=?,activo=? where id_promocion=?";
                        $params = array($titulo, $descripcion,$imagen,$activo,$id);
                        Database::executeRow($sql, $params);
                    @header("location: index.php");
            }
            else
            {
            	$sql2 = "INSERT INTO `historial` (`fecha`, `accion`, `id_admin`) VALUES(?, ?,?)";
                   $params2=array($fecha,"Modifico la promocion $titulo",$_SESSION['id_admin']);
                  Database::executeRow($sql2, $params2);
                        $sql = "update promociones set titulo=?, descripcion=?,activo=? where id_promocion=?";
                        $params = array($titulo, $descripcion,$activo,$id);
                        Database::executeRow($sql, $params);
                    @header("location: index.php");
            }
        }
         
    }
    catch (Exception $error)
    {
        print("<br><br><div class='card-panel red'><br><br><i class='material-icons left'>error</i>".$error->getMessage()."</div>");
    }
}
?>
<br><br><div class="main-content">

        <!-- You only need this form and the form-basic.css -->

        <form class="form-labels-on-top" enctype='multipart/form-data' name="nada" onkeyup="calcLong('titulo','label',this,30); calcLong('descripcion','label',this,10)" method="post">

            <div class="form-title-row">
                <h1>Promociones</h1>
            </div>

            <div class="form-row">
                <label>
                    <span>Titulo:</span>
                    <input type="text" name="titulo" required value="<?php print($titulo);?>">
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
                <input type="file" name="imagen" onclick="comprueba_extension(this.form, this.form.imagen.value)">
            </div>
            <div class="form-row">
                <button type="submit">Guardar</button>
                <button type="button"><a href="index.php" style="color:#fff;">Cancelar</a></button>
            </div>

        </form>

    </div>
    <script type="text/javascript">

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