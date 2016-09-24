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
    $actcheck="";
    	$inaccheck="";
}
else
{
    $id = base64_decode($_GET['id']);
    $sql = "SELECT * FROM usuario WHERE id_usuario = ?";
    $params = array($id);
    $data = Database::getRow($sql, $params);
    $alias=$data['alias'];
    $activo=$data['estado'];
    if($activo==0)
    {
    	$actcheck="checked";
    	$inaccheck="";
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
    $activo=$_POST['activo'];
    try
    {
        if($activo == null)
        {
            throw new Exception("Escoja una opcion please");
        }
        else
        {
            $slq="update usuario set estado =? where id_usuario = ?";
            $params=array($activo,$id);
            Database::executeRow($slq,$params);
            header("location:index.php");
            $sql2 = "INSERT INTO `historial` (`fecha`, `accion`, `id_admin`) VALUES(?, ?,?)";
        $params2=array($fecha,"Modifico el estado del usuario $alias",$_SESSION['id_admin']);
        Database::executeRow($sql2, $params2);
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

        <form class="form-labels-on-top" enctype='multipart/form-data' name="nada" method="post" onsubmit="returnValida(this);">

            <div class="form-title-row">
                <h1>Cambiar estado del usuario</h1>
            </div>

            <div class="form-row">
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
            <div class="form-row">
                <button type="submit">Guardar</button>
                <button type="button"><a href="index.php" style="color:#fff;">Cancelar</a></button>
            </div>

        </form>

    </div>
    <script type="text/javascript">

    function Valida(formulario) {
                /* Validación de campos NO VACÍOS */
                if ((formulario.titulo.value.length == 0) || (formulario.descripcion.value.length ==0)) {
                    alert('Debe completar todos los campos.');
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