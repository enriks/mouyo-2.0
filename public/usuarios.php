<?php

/* Archivos que se mandan a llamar y  son rqueridos*/

    require("../lib/database.php");
	require("main/page2.php");
	require("../lib/validator.php");
    Page2::header();



/* Funcion de PHP para el iniciar con un nuevo usuario si no hay uno ya registrado*/

if(isset($_SESSION['id_usuario']) == "")
{
    header("location: index.php");
}
else
{
    $sql="select * from usuario where id_usuario=?";
    $params=array($_SESSION['id_usuario']);
    $dat=Database::getRow($sql,$params);
    $heder="";
    if($dat != null)
    {
        $heder="<div class='container'>
        <div class='col s12 m8 offset-m2 l6 offset-l3'>
        <div class='card-panel blue lighten-4 z-depth-1'>
          <div class='row valign-wrapper'>
            <div class='col s2'>
              <img src='data:image/*;base64,$dat[foto_perfil]' alt='' class='circle responsive-img'>
            </div>
            <div class='col s10'>
              <span class='grey-text text-darken-3'>
                $dat[nombre] $dat[apellido], $dat[alias]
              </span>
            </div>
          </div>
        </div>
      </div></div>";
    }
    else
    {
        $heder="<span class='grey-text text-darken-3'>Hubo un error al sacar la informacion del usuario.</span>";
    }
    
    /*Se toman las variables de un usuario para poder actualizarlo*/
    
    print $heder;
    if(!empty($_POST))
    {
        $_POST = Validator::validateForm($_POST);
        $nombres = htmlentities($_POST['nombres']);
        $apellidos = htmlentities($_POST['apellidos']);
        $correo = htmlentities($_POST['correo']);
        $alias = htmlentities($_POST['alias']);
        $fecha_nacimiento= htmlentities($_POST['fecha_nacimiento']);
        $archivo= $_FILES['imagen'];
        $clave1 = htmlentities($_POST['clave1']);
        $clave2 = htmlentities($_POST['clave2']);
        
        try
        {
            if($archivo['name'] == "" && $clave1 == "" && $clave2 == "")
            {
                $sql="update usuario set nombre = ?, apellido = ?, alias = ?, correo = ?, fecha_nacimiento = ? where id_usuario =?";
                $params=array($nombres,$apellidos,$alias,$correo,$fecha_nacimiento,$_SESSION['id_usuario']);
            }
            elseif($archivo['name'] != "" && $clave1 == "" && $clave2 == "")
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
                $sql="update usuario set nombre = ?, apellido = ?, alias = ?, correo = ?, fecha_nacimiento = ?, foto_prefil = ? where id_usuario =?";
                $params=array($nombres,$apellidos,$alias,$correo,$fecha_nacimiento,$imagen,$_SESSION['id_usuario']);
                $_SESSION['img']=$imagen;
            }
            elseif($archivo['name'] == "" && $clave1 != "" && $clave2 != "")
            {
                if($clave1 == $clave2)
                {
                    $clave = password_hash($clave1, PASSWORD_DEFAULT);
                    $sql="update usuario set nombre = ?, apellido = ?, alias = ?, correo = ?, fecha_nacimiento = ?, clave =? where id_usuario =?";
                    $params=array($nombres,$apellidos,$alias,$correo,$fecha_nacimiento,$clave,$_SESSION['id_usuario']);
                }
                else
                {
                    throw new Exception("Las claves ingresadas no coinciden.");
                }
                
            }
            elseif($archivo['name'] != "" && $clave1 != "" && $clave2 != "")
            {
                $base64 = Validator::validateImage($archivo);
                if($clave1 == $clave2 && $base64 != false)
                {
                    $imagen=$base64;
                    $clave = password_hash($clave1, PASSWORD_DEFAULT);
                    $sql="update usuario set nombre = ?, apellido = ?, alias = ?, correo = ?, fecha_nacimiento = ?, foto_prefil = ?, clave =? where id_usuario =?";
                    $params=array($nombres,$apellidos,$alias,$correo,$fecha_nacimiento,$imagen,$clave,$_SESSION['id_usuario']);
                    $_SESSION['img']=$imagen;
                }
                else
                {
                    throw new Exception("Las claves ingresadas no coinciden o la imagen seleccionada no es valida");
                }
            }
            
            Database::executeRow($sql,$params);
            $_SESSION['usuario']="".$nombres." ".$apellidos;
            header("location: usuarios.php");
        }
        catch (Exception $error)
    {
        print("<div class='card-panel red'><i class='material-icons left'>error</i>".$error->getMessage()."</div>");
    }
    }
}?>
<!-- Se muestran en el formularios los datos de un usuario a modificar-->

<form method="post"  class="row" enctype="multipart/form-data">
<div class="container center-align">
    <div class="row">
      <form class="col s12">
        <div class="row">
          <div class="input-field col s6">
          <i class="material-icons prefix">account_circle</i> 	
            <input id="nombre" name="nombres" type="text" autocomplete="off" class="validate" value='<?php print $dat['nombre'];?>'>
            <label for="nombre">Nombre</label>
          </div>
          <div class="input-field col s6">
          <i class="material-icons prefix">account_circle</i>
            <input id="apellido" name="apellidos" type="text" autocomplete="off" class="validate" value='<?php print $dat['apellido'];?>'>
            <label for="apellido">Apellido</label>
          </div>
        </div>
         <div class="row">
          <div class="input-field col s6">
          <i class="material-icons prefix">perm_identity</i>
            <input id="alias" type="text" name="alias" autocomplete="off" class="validate" value='<?php print $dat['alias'];?>'>
            <label for="alias">Alias de Usuario</label>
          </div>
          <div class="input-field col s6">
          <i class='material-icons prefix'>contact_mail</i>
            <input id="correo" type="email" name="correo" autocomplete="off"  class="validate" value='<?php print $dat['correo'];?>'>
            <label for="correo">Correo Electronico</label>
          </div>
        </div>
        <ul class="collapsible" data-collapsible="accordion">
         <li>
          <div class="collapsible-header">Cambiar Clave</div>
          <div class="collapsible-body">
        <div class="row">
          <div class="input-field col s6">
          <i class="material-icons prefix">vpn_key</i>
            <input id="password" type="password" name="clave1" autocomplete="off" class="validate">
            <label for="password">Clave</label>
          </div>
          <div class="input-field col s6">
          <i class="material-icons prefix">info_outline</i>
            <input id="password" type="password" name="clave2" autocomplete="off" class="validate">
            <label for="password">Repetir Clave</label>
          </div>
        </div>
          </div>
        </li>
        </ul>
        <div class="row">
          <div class="input-field col s12">
            <i class="material-icons prefix">date_range</i>
            <input id='fecha_nacimiento' name='fecha_nacimiento' autocomplete="off" class='validate datepicker'  value='<?php print $dat['fecha_nacimiento'];?>'>
            <label for="fecha_nacimiento" >Fecha de Nacimiento</label>
          </div>
        </div>
      </form>
    </div>
    <div class='input-field col s12'>
          	<div class='btn'>
            		<span>Foto de Perfil</span>
            		<input type='file' name='imagen'>
      		  </div>
        		<div class='file-path-wrapper'>
          		  <input class='file-path validate' type='text' placeholder='1200x1200px max., 2MB max., PNG/JPG/GIF'>
        		</div>
     </div>
<button type='submit' class='btn blue center-align'><i class='material-icons right'>save</i>Guardar</button>
</div>
</form>

<?php

Page2::footer();

require'inc/footer.php'; ?>