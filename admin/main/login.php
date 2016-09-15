<?php ob_start();
require('../../lib/validator.php');
require("../../lib/database.php");
require("../lib/page.php");
$sql="select * from admin";
$data=Database::getRows($sql,null);
if($data==null)
{
    @header("location:register.php");
}

Page::header("Iniciar sesion");

if(!empty($_POST))
{
    $_POST=validator::validateForm($_POST);
    $alias=$_POST['alias'];
    $clave=$_POST['clave'];
    try
    {
        if($alias != "" && $clave!="")
        {
            $sql="select * from admin where alias=?";
            $param = array($alias);
            $data=Database::getRow($sql,$param);
            if($data != null)
            {
                $hash=$data['clave'];
                if(password_verify($clave,$hash))
                {
                    $sql2="select sesion from admin where id_admin=?";
                    $params2=array($data['id_admin']);
                    $dat=Database::getRow($sql2,$params2);
                    if($dat != null)
                    {
                        if($dat['sesion']==1)
                        {    
                        @header("location: activesesion.php");
                        }
                        else
                        {
                            $_SESSION['id_admin'] = $data['id_admin'];
                            $_SESSION['usuario_admin'] = $data['alias'];
                            $_SESSION['permisos']=$data['permiso'];
                            $_SESSION['tiempo']=time();
                            $sql="update admin set sesion=1 where id_admin=?";
                            $params=array($data['id_admin']);
                            Database::executeRow($sql,$params);
                            $_SESSION['img_admin']=$data['foto'];
                            @header("location: index.php");
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
    }
    catch (Exception $error)
    {
        print("<div class='card-panel red'><i class='material-icons left'>error</i>".$error->getMessage()."</div>");
    }
}?>
<!DOCTYPE html>
<html lang="es">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Bootstrap Login Form Template</title>

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
        <link rel="shortcut icon" href="../../ico/favicon.png">
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../../ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../../ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../../ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="../../ico/apple-touch-icon-57-precomposed.png">

    </head>

    <body>

        <!-- Top content -->
        <div class="top-content">
        	
            <div class="inner-bg">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2 text">
                            <h1><strong>Mouyo</strong> Inicio Sesion</h1>
                            <div class="description">
                            	<p>
	                            	Pagina administrativa de Mouyo, aqui controlaras la escencia de Mouyo.
                            	</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3 form-box">
                        	<div class="form-top">
                        		<div class="form-top-left">
                        			<h3>Iniciar Sesion como Administrador</h3>
                            		<p>Ingresa tu alias de Administrador para entrar a Mouyo-Administration</p>
                        		</div>
                        		<div class="form-top-right">
                        			<i class="fa fa-lock"></i>
                        		</div>
                            </div>
                            <div class="form-bottom">
			                    <form role="form" autocomplete="off" action="" method="post" name="nonono" class="login-form">
			                    	<div class="form-group">
			                    		<label class="sr-only" for="form-username">Alias</label>
			                        	<input type="text" name="alias" placeholder="Alias..." class="form-username form-control" id="form-username">
			                        </div>
			                        <div class="form-group">
			                        	<label class="sr-only" for="form-password">Contraseña</label>
			                        	<input type="password" name="clave" placeholder="Contraseña..." class="form-password form-control" id="form-password">
			                        </div>
			                        <button type="submit" class="btn">Entrar</button>
			                    </form>
		                    </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>


        <!-- Javascript -->
        <script src="../../js/jquery-1.11.1.min.js"></script>
        <script src="../../bootstrap/js/bootstrap.min.js"></script>
        <script src="../../js/jquery.backstretch.min.js"></script>
        <script src="../../js/scripts.js"></script>
        
        <!--[if lt IE 10]>
            <script src="assets/js/placeholder.js"></script>
        <![endif]-->

    </body>

</html>