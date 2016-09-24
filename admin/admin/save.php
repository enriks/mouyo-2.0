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
    $alias=null;
    $clave=null;
    $archivo=null;
    $correo=null;
$permiso="";
  $estado=null;
    $actcheck="";
    	$inaccheck='';
}
else
{
    $id = base64_decode($_GET['id']);
    $sql = "SELECT * FROM admin WHERE id_admin = ?";
    $params = array($id);
    $data = Database::getRow($sql, $params);
    $alias = $data['alias'];
    $clave = $data['clave'];
    $archivo=$data['foto'];
    $correo=$data['correo'];
$permiso=$data['permiso'];
    $estado=$data['estado'];
     if($estado==0)
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
     $alias = htmlentities($_POST['alias']);
    $correo = htmlentities($_POST['correo']);
    $permiso=htmlentities($_POST['permiso']);
    $estado=htmlentities($_POST['estado']);
    $archivo=$_FILES['imagen'];
    
    try
    {
        $clave1 = htmlentities($_POST['clave1']);
            $clave2 = htmlentities($_POST['clave2']);
        if($alias == "" || $correo == "")
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
        elseif( $alias != $clave1 )
        {
            if($id==null)
            {
                if( $archivo['name'] != null)
                {
                $clave = password_hash($clave1, PASSWORD_DEFAULT);
                $sql = "INSERT INTO `admin` (`alias`, `clave`, `correo`,foto,permiso,estado) VALUES(?, ?,?, ?,?,?)";
                $sql2 = "INSERT INTO `historial` (`fecha`, `accion`, `id_admin`) VALUES(?, ?,?)";
                $params=array($alias,$clave,$correo,$imagen,$permiso,$estado);
                $params2=array($fecha,"Inserto el administrador $alias",$_SESSION['id_admin']);
                    Database::executeRow($sql, $params);
                    Database::executeRow($sql2, $params2);
            @header("location: index.php");
                }
                else
                {
                 throw new Exception("Seleccione una imagen");   
                }
            }
            else
            {
                if( $archivo['name'] != null)
                {
                    $clave = password_hash($clave1, PASSWORD_DEFAULT);
                    $sql2 = "INSERT INTO `historial` (`fecha`, `accion`, `id_admin`) VALUES(?, ?,?)";
                    $params2=array($fecha,"Modifico el administrador $alias",$_SESSION['id_admin']);
                    Database::executeRow($sql2, $params2);
                    $sql = "update admin set alias=?, clave=?,foto=?,correo=?,permiso=?,estado=? where id_admin=?";
                    $params = array($alias, $clave,$imagen,$correo,$permiso,$estado,$id);
                    Database::executeRow($sql, $params);
            @header("location: index.php");
                }
                else
                {
                    $clave = password_hash($clave1, PASSWORD_DEFAULT);
                    $sql2 = "INSERT INTO `historial` (`fecha`, `accion`, `id_admin`) VALUES(?, ?,?)";
                    $params2=array($fecha,"Modifico el administrador $alias",$_SESSION['id_admin']);
                    Database::executeRow($sql2, $params2);
                    $sql = "update admin set alias=?, clave=?,correo=?,permiso=?,estado=? where id_admin=?";
                    $params = array($alias, $clave,$correo,$permiso,$estado,$id);
                    Database::executeRow($sql, $params);
            @header("location: index.php");
                }

            }
             
        }
        else
        {
            throw new Exception("El Alias no puede ser igual a la contraseña ");
        }
    }
    catch (Exception $error)
    {
        print("<div class='card-panel red'><i class='material-icons left'>error</i>".$error->getMessage()."</div>");
    }
}
?>
<br><br><div class="main-content">

        <!-- You only need this form and the form-basic.css -->

        <form class="form-labels-on-top" enctype='multipart/form-data' name="nada" onkeyup="calcLong('titulo','label',this,30); calcLong('descripcion','label',this,10)" method="post">

            <div class="form-title-row">
                <h1>Administrador</h1>
            </div>

            <div class="form-row">
                <label>
                    <span>Alias:</span>
                    <input type="text" name="alias" required value="<?php print($alias);?>">
                </label>
            </div>

            <div class="form-row">
                <label>
                    <span>Correo</span>
                    <input type="mail" name="correo" required value="<?php print($correo);?>">
                </label>
            </div>
            
            <div class="form-row">
                <label>
                    <span>Contraseña</span>
                    <input type="password" name="clave1" placeholder="Contraseña...">
                </label>
            </div>
                        
            <div class="form-row">
                <label>
                    <span>Confirme la contraseña</span>
                    <input type="password" name="clave2" placeholder="Confirmacion..."  >
                </label>
            </div>
                        
            <div class="form-row">
                <label>
                    <span>Seleccione los permisos</span>
                    <?php
    		    $sql = "SELECT id_permiso,nombre FROM permisos";
    		    Page::setCombo("permiso", $permiso, $sql);
    		    ?>
                </label>
            </div>
            
             <div class="form-row">
                <label><span>Estado</span></label>
                <div class="form-radio-buttons">

                    <div>
                        <label>
                            <input type="radio" name="estado" value="0" <?php print $actcheck;?>>
                            <span>Activa</span>
                        </label>
                    </div>

                    <div>
                        <label>
                            <input type="radio" name="estado" value="1" <?php print $inaccheck;?>>
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
    <?php page::footer();?>