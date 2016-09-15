<?php
ob_start();
require("../../lib/database.php");
/*$sql = "SELECT * FROM admin";
$data = Database::getRows($sql, null);
if($data != null)
{
    @header("location: login.php");
}
*/
require("../lib/page.php");
require("../../lib/validator.php");
Page::header("Registrar usuario");

$fecha=date('Y-m-d H:i:s');
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
$permiso="";
if(!empty($_POST))
{
    //$_POST = Validator::validateForm($_POST);
    $alias = htmlentities($_POST['alias']);
    $correo = htmlentities($_POST['correo']);
    $permiso=$_POST['permiso'];
    $archivo=$_FILES['archivo'];

    try 
    {
        if($alias != "" || $correo != "")
        {
            $clave1 = htmlentities($_POST['clave1']);
            $clave2 = htmlentities($_POST['clave2']);
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
                    if( $alias != $clave1 )
                    {
                        $error_encontrado="";
                        
                        if (validar_clave($clave1, $error_encontrado)){
                                    
                            if($clave1 == $clave2)
                            {
                                $clave = password_hash($clave1, PASSWORD_DEFAULT);
                                $sql = "INSERT INTO `admin` (`alias`, `clave`, `correo`,foto,permiso) VALUES(?, ?, ?,?,?)";
                                $param = array($alias,$clave,$correo,$imagen,$permiso);
                                Database::executeRow($sql, $param);
                                @header("location: login.php");
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
            }
            else
            {
                throw new Exception("Debe ingresar todos los datos de autenticación.");
            }
        }
        else
        {
            throw new Exception("Debe ingresar el nombre o el correo.");
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
<!DOCTYPE html>
<html lang="es">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Bootstrap Registration Form Template</title>

        <!-- CSS -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
        <link rel="stylesheet" href="../../css/bootstrap.min.css">
        <link rel="stylesheet" href="../../font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="../../css/form-elements.css">
        <link rel="stylesheet" href="../../css/style.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Favicon and touch icons -->
        <link rel="shortcut icon" href="assets/ico/favicon.png">
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">

    </head>

    <body>


        <!-- Top content -->
        <div class="top-content">
        	
            <div class="inner-bg">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-7 text">
                            <h1><strong>Mouyo-Administration</strong> Eres el primer Administrador.</h1>
                            <div class="description">
                            	<p>
	                            	En este formulario te registraras a Mouyo-Administration como el primer Administrador.
                            	</p>
                            </div>
                        </div>
                        <div class="col-sm-5 form-box">
                        	<div class="form-top">
                        		<div class="form-top-left">
                        			<h3>Registrate Primer Administrador</h3>
                            		<p>Llena todos los campos para tener acceso a Mouyo-Administration</p>
                        		</div>
                        		<div class="form-top-right">
                        			<i class="fa fa-pencil"></i>
                        		</div>
                            </div>
                            <div class="form-bottom">
			                    <form autocomplete="off" action="" method="post" enctype='multipart/form-data' class="registration-form">
			                    	<div class="form-group">
			                    		<label class="sr-only" for="form-first-name">Alias</label>
			                        	<input type="text" name="alias" placeholder="Alias..." class="form-first-name form-control" id="form-first-name">
			                        </div>
                                    <div class="form-group">
                                        <label class="sr-only" for="form-password">Contraseña</label>
                                        <input type="password" name="clave1" placeholder="Contraseña..." class="form-password form-control" id="form-password">
                                    </div>
                                    <div class="form-group">
                                        <label class="sr-only" for="form-password">Confirme la contraseña</label>
                                        <input type="password" name="clave2" placeholder="Confirmacion..." class="form-password form-control" id="form-password">
                                    </div>
			                        <div class="form-group">
			                        	<label class="sr-only" for="correo">Correo Email</label>
			                        	<input type="text" name="correo" placeholder="Correo..." class="form-email form-control" id="correo">
			                        </div>
                                	<div class="form-group img-rounded" style="background-color:white;">
                                        <input type="file" name="archivo">
                                    </div>
                                    <div class="form-group">
                                        <?php
                                            $sql = "SELECT id_permiso,nombre FROM permisos";
                                            Page::setCombo("permiso", $permiso, $sql);
                                        ?>
                                    </div>
			                        <button type="submit" class="btn">Registrarme</button>
			                    </form>
		                    </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>


        <!-- Javascript -->
        <script src="../../js/register/jquery-1.11.1.min.js"></script>
        <script src="../../js/bootstrap.min.js"></script>
        <script src="../../js/register/jquery.backstretch.min.js"></script>
        <script src="../../js/retina-1.1.0.min.js"></script>
        <script src="../../js/scripts.js"></script>
        
        <!--[if lt IE 10]>
            <script src="assets/js/placeholder.js"></script>
        <![endif]-->

    </body>

</html>