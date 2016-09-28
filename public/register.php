<?php
require("../lib/database.php");
require("main/page2.php");
require("../lib/validator.php");
Page2::header();

function validar_clave($clave,&$error_clave){
   if(strlen($clave) < 6){
      $error_clave = "La clave debe tener al menos 6 caracteres";
      return false;
   }
   if(strlen($clave) > 25){
      $error_clave = "La clave no puede tener más de 25 caracteres";
      return false;
   }
   if (!preg_match('`[a-z]`',$clave)){
      $error_clave = "La clave debe tener al menos una letra minúscula";
      return false;
   }
   if (!preg_match('`[A-Z]`',$clave)){
      $error_clave = "La clave debe tener al menos una letra mayúscula";
      return false;
   }
   if (!preg_match('`[0-9]`',$clave)){
      $error_clave = "La clave debe tener al menos un caracter numérico";
      return false;
   }
   $error_clave = "";
   return true;
}

/*Metodo para ingresar o registrar un usuario con las variables de datos*/

if(!empty($_POST))
{
    $_POST = Validator::validateForm($_POST);
    
    
  	$nombres = htmlentities ($_POST['nombres']);
  	$apellidos = htmlentities ($_POST['apellidos']);
    $correo = htmlentities ($_POST['correo']);
    $alias = htmlentities ($_POST['alias']);
    //$fecha_nacimiento= htmlentities ($_POST['fecha_nacimiento']);
    $archivo=$_FILES['imagen'];

    try 
    {
        if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response']))
    {
      	if($nombres != "" && $apellidos != "")
        {
            $clave1 = htmlentities ($_POST['clave1']);
            $clave2 = htmlentities ($_POST['clave2']);
            if($alias != "" && $clave1 != "" && $clave2 != "")
            {
                
                    if($archivo['name'] != null)
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
                        
                        //validacion de clave
                        
                        if($alias != $clave1)
                        {
                            
                            $error_encontrado="";
                        
                            if (validar_clave($clave1, $error_encontrado))
                            {
                                if($clave1 == $clave2)
                                {
                                    $clave = password_hash($clave1, PASSWORD_DEFAULT);
                                    $sql = "INSERT INTO usuario(nombre, apellido,alias,clave,correo,foto_perfil) VALUES(?, ?, ?, ?, ?,?)";
                                    $param = array($nombres, $apellidos, $alias,$clave,$correo,$imagen);
                                    Database::executeRow($sql, $param);
                                    header("location: login.php");
                                }
                                
                                else
                                {
                                    throw new Exception("Las claves ingresadas no coinciden.");
                                }
                            
                            }
                            
                            else
                            {
                                
                                throw new Exception("Clave no valida. " . $error_encontrado);
                            }
                        }
                        else{
                            
                            throw new Exception("El Alias no puede ser igual a la contraseña ");
                        }

                    }

            }
            else
            {
                throw new Exception("Debe ingresar todos los datos de autenticación.");
            }
        }
        else
        {
            throw new Exception("Debe ingresar el nombre completo.");
        }
        }
        else
        {
            throw new Exception("haz el captcha");
        }
    }
    catch (Exception $error)
    {
        print("<div class='card-panel red'><i class='material-icons left'>error</i>".$error->getMessage()."</div>");
    }
}
else
{
    $nombres = null;
    $apellidos = null;
    $correo = null;
    $alias = null;
}
?>

<!-- Se muestra el formulario con los campos que muestarn algun usuario seleccionado a modificar-->
<br>
<form method='post' class='container center-align' enctype='multipart/form-data' id="divRegister">
    <div class='row'>
        <div class='input-field col s12 m6'>
          	<i class='material-icons prefix'>assignment_ind</i>
          	<input id='nombres' type='text' name='nombres' class='validate' length='50' maxlenght='50' autocomplete="off" value='<?php print($nombres); ?>' required/>
          	<label for='nombres'>Nombres</label>
        </div>
        <div class='input-field col s12 m6'>
            <i class='material-icons prefix'>assignment_ind</i>
            <input id='apellidos' type='text' name='apellidos' class='validate' length='50' maxlenght='50' autocomplete="off" value='<?php print($apellidos); ?>' required/>
            <label for='apellidos'>Apellidos</label>
        </div>
    </div>
    <div class='row'>
        <div class='input-field col s12 m6'>
            <i class='material-icons prefix'>email</i>
            <input id='correo' type='email' name='correo' class='validate' length='100' maxlenght='100' autocomplete="off" value='<?php print($correo); ?>' required/>
            <label for='correo'>Correo</label>
        </div>
        <div class='input-field col s12 m6'>
            <i class='material-icons prefix'>perm_identity</i>
            <input id='alias' type='text' name='alias' class='validate' length='50' maxlenght='50' autocomplete="off" value='<?php print($alias); ?>' required/>
            <label for='alias'>Alias</label>
        </div>
    </div>
    <div class='row'>
        <div class='input-field col s12 m6'>
            <i class='material-icons prefix'>lock</i>
            <input id='clave1' type='password' name='clave1' class='validate' length='25' maxlenght='25' autocomplete="off" required/>
            <label for='clave1'>Clave</label>
        </div>
        <div class='input-field col s12 m6'>
            <i class='material-icons prefix'>lock</i>
            <input id='clave2' type='password' name='clave2' class='validate' length='25' maxlenght='25' autocomplete="off" required/>
            <label for='clave2'>Confirmar clave</label>
        </div>
    </div>
    <div class='row'>
        <!--div class='input-field col s12 m6'>
            <i class='material-icons prefix'>date_range</i>
            <input id='fecha_nacimiento' type='date' name='fecha_nacimiento' class='validate datepicker' autocomplete="off" required/>
            <label for='fecha_nacimiento'>Fecha de nacimiento</label>
        </div-->
        <div class='file-field input-field col s12 l6 offset-l3'>
          	<div class='btn '>
            		<span>Imagen</span>
            		<input type='file' name='imagen'>
      		  </div>
        		<div class='file-path-wrapper'>
          		  <input disabled class='file-path validate center' type='text' placeholder='1200x1200px máx., 2MB máx., PNG/JPG/GIF'>
        		</div>
        </div>
    </div>
    <div class="row " data-theme="dark">
        <div data-theme="dark" required class="input-field col l4 s12 offset-l4  g-recaptcha" data-sitekey="6LfQ-SUTAAAAAEijTh-xfye-Xj8Be5xPQ0POoMUF"></div>
    </div>
 	<button type='submit' class='btn blue'><i class='material-icons right'>save</i>Guardar</button>
</form>

<script src='../bin/materialize.js'></script>
<script src='../js/init.js'></script>

<?php page2::footer();?>

<?php require 'inc/faq.php'; ?> 
<?php require 'inc/acercade.php'; ?>	 
<?php require 'inc/footer.php'; ?>