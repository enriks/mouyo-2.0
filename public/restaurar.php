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

if(!empty($_GET['id'])){
    
    $id = $_GET['id'];
    $sql = "SELECT * FROM usuario WHERE id_usuario = ?";
    $params = array($id);
    $data = Database::getRow($sql, $params);
    $alias = $data['alias'];
    $correo= $data['correo'];
}

/*Metodo para ingresar o registrar un usuario con las variables de datos*/

if(!empty($_POST))
{
    try 
    {
            $clave1 = htmlentities ($_POST['clave1']);
            $clave2 = htmlentities ($_POST['clave2']);
        
            if($alias != "" && $clave1 != "" && $clave2 != "")
            {
                //validacion de clave
                            
                if($alias != $clave1)
                {
                                
                    $error_encontrado="";
                            
                    if (validar_clave($clave1, $error_encontrado))
                    {
                        if($clave1 == $clave2)
                        {
                            $clave = password_hash($clave1, PASSWORD_DEFAULT);
                            $sql = "update usuario set clave=? where id_usuario=?";
                            $params = array($clave,$id);
                            Database::executeRow($sql, $params);
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
                else
                {
                                
                    throw new Exception("El Alias no puede ser igual a la contraseña ");
                }

            }
        
        else
        {
            throw new Exception("Debe ingresar todos los datos de autenticación.");
        }
    }
        
    catch (Exception $error)
    {
        print("<div class='card-panel red'><i class='material-icons left'>error</i>".$error->getMessage()."</div>");
    }
}
else
{
    $clave1 = null;
    $clave2 = null;
}
?>

<!-- Se muestra el formulario con los campos que muestarn algun usuario seleccionado a modificar-->

<form method='post' class='row center-align' enctype='multipart/form-data'>
    <div class='container'>
        <h4>Restaurar Contraseña</h4>
        <h5 class="teal-text">Bienvenido <?php print($alias); ?> su correo actual es <?php print($correo); ?></h5><br>
        <h5 class="teal-text">Ingrese una nueva contraseña</h5><br>
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
 	<button type='submit' class='btn blue'><i class='material-icons right'>save</i>Recuperar</button>
</form>

 <script src="../js/jquery-2.2.3.min.js"></script>
   <script src="../js/materialize.min.js"></script>
   <script src="../bin/materialize.js"></script>
   <script src="../jade/lunr.min.js"></script>
   <script src="../js/init.js"></script>
   <script src="../js/prism.js"></script>
   <script src="../sjs/app.js"></script>   
