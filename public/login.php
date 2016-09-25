<?php 
ob_start();
if(isset($_SESSION['id_usuario']))
{
    header("location: index.php");
}

require("../lib/database.php");
require("../lib/validator.php");
require("main/page2.php");
Page2::header();

/* Funcion de PHP para iniciar sesion*/

if(isset($_POST['enviar'])||!empty($_POST))
{
    $_POST=validator::validateForm($_POST);
    $alias=$_POST['alias'];
    $clave=$_POST['clave'];
    try
    {
        if($alias != "" && $clave!="")
        {
            $sql="select * from usuario where alias=?";
            $param = array($alias);
            $data=Database::getRow($sql,$param);
            if($data != null)
            {
                $hash=$data['clave'];
                if(password_verify($clave,$hash))
                {
                    if($data['sesion']==1)
                        {    
                            @header("location: activesesion.php");
                        }
                        else
                        {
                            if($data['estado']!=0)
                            {
                                @header("location: ban.php");
                            }
                            else
                            {
                                
                            $_SESSION['img']=$data['foto_perfil'];
                            $_SESSION['id_usuario'] = $data['id_usuario'];
                            $_SESSION['nombre_apellido_usuario'] = $data['nombre']." ".$data['apellido'];
                            $sql="update usuario set sesion=1 where id_usuario=?";
                            $params=array($data['id_admin']);
                            Database::executeRow($sql,$params);
                            @header("location: index.php");
                               $cabeceras = 'From: mouyosv.ricaldone@gmail.com' . "\r\n" .
                            'Reply-To: mouyosv.ricaldone@gmail.com' . "\r\n" .
                            'X-Mailer: PHP/' . phpversion(); mail("nelo.coto@gmail.com","puto","haz ingresado",$cabeceras);
                            }
                        }
                }
                else
                {
                    throw new Exception("Laclave ingresada es incorrecata wey.");
                }
            }
            else
            {
                throw new Exception("El alias ingresado no existe wey.");
            }
        }
        else
        {
            throw new Exception("Debes ingresar un alias y una clave we");
        }
    }
    catch (Exception $error)
    {
        print("<div class='card-panel red'><i class='material-icons left'>error</i>".$error->getMessage()."</div>");
    }
}
if(isset($_POST['enviar2']))
{
    try
    {
        $_POST=validator::validateForm($_POST);
        $correo=$_POST['correo'];
        if($correo !=null)
        {
            $sql="select id_usuario from usuario where correo=?";
            $params=array($correo);
            $data=Database::getRow($sql,$params);
            if($data != null)
            {
                @header("location: restaurar.php?id=$data[id_usuario]");
            }
            else
            {
                throw new Exception("No hay un usuario con ese correo.");
            }
        }
        else
        {
            throw new Exception("Escribe un correo");
        }
    }
    catch (Exception $error)
    {
        print("<div class='card-panel red'><i class='material-icons left'>error</i>".$error->getMessage()."</div>");
    }
}
    
    //Page2::header("");

?>

<!-- Seccion para ingresar datos e iniciar sesion con un usario-->

        <div class="center" id="divLogin">
			<br>
      <div class="card bordered z-depth-2" style="margin:0% auto; max-width:400px;">
        <div class="card-header small-header-color-bg small-header-color">
           <i class="material-icons medium white-text">perm_identity</i>
        </div>
        <div class="card-content">
          <form method="post" enctype="multipart/form-data">
            <div class="input-field col s12">
              <input name="alias" id="alias" autocomplete="off" type="text" class="validate">
              <label for="alias">Nombre de Usuario</label>
           </div>
            <div class="input-field col s12">
              <input name="clave" id="clave" autocomplete="off" type="password" class="validate">
              <label for="clave">Contraseña</label>
            </div>
            <br>
              <button type='submit' name="enviar" class='btn blue'><i class='material-icons right'>verified_user</i>Iniciar Sesion</button>
          </form> 
        </div>
		  <div class="divider"></div>
        <div class="card-action clearfix">
          <div class="row">
				<a href="register.php" class="orange-text tooltipped" data-position="top" data-delay="50" data-tooltip="Registrate ahora">Registrarme ahora</a>
          </div>
			<div class="row">
				<a class="modal-trigger orange-text tooltipped" data-position="top" data-delay="50" href="#modal11" data-tooltip="recuperar contraseña" >Restaurar contraseña</a>
			</div>
        </div>
      </div>
      <div id="modal11" class="modal">
    <div class="modal-content">
        <form method='post' name="lul" class='row center-align' enctype='multipart/form-data' >
        <div class="row">
                <h4 class="center">Correo</h4>
                <div class="input-field col s12">
                    <i class='material-icons prefix'>add</i>
                    <input id='correo' type='text' name='correo' class='validate' length='100' maxlenght='100'   required/>
                    <label for='nombre'>Correo</label>
                </div>
            </div>
             <button type='submit' name="enviar2" class='btn'><i class='material-icons right'>save</i>Recuperar</button>
        </form>
      </div>
    </div>
    </div><br>

<script src='../bin/materialize.js'></script>
<script src='../js/init.js'></script>


    <?php page2::footer(); ?>

<?php require 'inc/faq.php'; ?> 
<?php require 'inc/acercade.php'; ?>	 
<?php require 'inc/footer.php'; ?>