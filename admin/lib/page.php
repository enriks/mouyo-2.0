<?php 
   session_start();
    class page
    {
        public static function header($title)
        {
            $sql="select id_admin,sesion from admin where id_admin=?";
            $params=array(isset($_SESSION['id_admin']));
            $data=Database::getRow($sql,$params);
            if($data['sesion']==0)
            {
                header("location: ../main/logout.php");
            }
            else
            {
                $_SESSION['id_admin']=$data['id_admin'];
            }
            #si se necesita la hora :v
            ini_set("date.timezone","America/El_Salvador");
            $session=false;
            $filename=basename($_SERVER['PHP_SELF']);
            $header="<!DOCTYPE html>
                <html lang='en'>

                <head>

                    <meta charset='utf-8'>
                    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
                    <meta name='viewport' content='width=device-width, initial-scale=1'>
                    <meta name='description' content=''>
                    <meta name='author' content=''>

                    <title>Modern Business - Start Bootstrap Template</title>

                    <!-- Bootstrap Core CSS -->
                    <link href='css/bootstrap.min.css' rel='stylesheet'>

                    <!-- Custom CSS -->
                    <link href='css/modern-business.css' rel='stylesheet'>

                    <!-- Custom Fonts -->
                    <link href='font-awesome/css/font-awesome.min.css' rel='stylesheet' type='text/css'>

                    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
                    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
                    <!--[if lt IE 9]>
                        <script src='https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js'></script>
                        <script src='https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js'></script>
                    <![endif]-->

                </head>

                <body>

                <!-- Navigation -->
                <nav class='navbar navbar-inverse navbar-fixed-top' role='navigation'>
                    <div class='container'>
                        <!-- Brand and toggle get grouped for better mobile display -->
                        ";
            if(isset($_SESSION['usuario_admin']))
            {
                $diff=time() - $_SESSION['tiempo'];
                if($diff > 900)
                {
                    header("location: ../main/logout.php");
                }
                else
                {
                    $_SESSION['tiempo']=time();
                }
                
                $session=true;
                if($_SESSION['permisos']==1)
                {
                   $header.="
                   <div class='navbar-header'>
                            <button type='button' class='navbar-toggle' data-toggle='collapse' data-target='#bs-example-navbar-collapse-1'>
                                <span class='sr-only'>Toggle navigation</span>
                                <span class='icon-bar'></span>
                                <span class='icon-bar'></span>
                                <span class='icon-bar'></span>
                            </button>
                            <a class='navbar-brand' href='index.html'>Start Bootstrap</a>
                        </div>
                        <div class='collapse navbar-collapse' id='bs-example-navbar-collapse-1'>
                <ul class='nav navbar-nav navbar-right'>
                    <li>
                        <a href='../admin/'>Administradores</a>
                    </li>
                    <li>
                        <a href='../users/'>Usuarios</a>
                    </li>
                    <li class='dropdown'>
                        <a href='#' class='dropdown-toggle' data-toggle='dropdown'><div class='chip'>
                              <img src='data:image/*;base64,$_SESSION[img_admin]' alt='Person' width='40' height='40' class='img-circle'>
                              $_SESSION[usuario_admin]
                            </div> <b class='caret'></b></a>
                        <ul class='dropdown-menu'>
                            <li>
                                <a href='../profile/'>Editar Perfil</a>
                            </li>
                            <li>
                                <a href='../main/logout.php'>Salir</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>"; 
                }
                else
                {
                    header("location:../main/denied.php");
                }

                if($_SESSION['permisos']==2)
                {
                    $header.="<div class='navbar-header'>
                            <button type='button' class='navbar-toggle' data-toggle='collapse' data-target='#bs-example-navbar-collapse-1'>
                                <span class='sr-only'>Toggle navigation</span>
                                <span class='icon-bar'></span>
                                <span class='icon-bar'></span>
                                <span class='icon-bar'></span>
                            </button>
                            <a class='navbar-brand' href='index.html'>Start Bootstrap</a>
                        </div>
                        <div class='collapse navbar-collapse' id='bs-example-navbar-collapse-1'>
                <ul class='nav navbar-nav navbar-right'>
                    <li>
                        <a href='../descuentos/'>Descuentos</a>
                    </li>
                    <li>
                        <a href='../promociones/'>Promociones</a>
                    </li>
                    <li class='dropdown'>
                        <a href='#' class='dropdown-toggle' data-toggle='dropdown'><div class='chip'>
                              <img src='data:image/*;base64,$_SESSION[img_admin]' alt='Person' width='40' height='40' class='img-circle'>
                              $_SESSION[usuario_admin]
                            </div> <b class='caret'></b></a>
                        <ul class='dropdown-menu'>
                            <li>
                                <a href='../profile/'>Editar Perfil</a>
                            </li>
                            <li>
                                <a href='../main/logout.php'>Salir</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>";
                }
                else
                {
                   header("location:../main/denied.php"); 
                }
                if($_SESSION['permisos']==3)
                {
                    $header.="<a href='../main/' class='brand-logo'>
                            <i class='material-icons left hide-on-med-and-down'>undo</i>Sitio Privado
		        		</a>
                        <a href='#' data-activates='mobile' class='button-collapse'><i class='material-icons'>menu</i></a>
	        					<ul class='right hide-on-med-and-down'>
		          					<li><a href='../jugos/index.php'>Jugos</a></li>
		          					<li><a href='../ingredientes/index.php'>ingredientes</a></li>
		          					<li><a href='../tamanio/index.php'>Vasos</a></li>
		          					<li><a class='dropdown-button' href='#' data-activates='dropdown'>
                                    <div class='chip'>
                                    <img id='foto_perfil imagen_video'
                                    src='data:image/*;base64,$_SESSION[img_admin]'
                                    class='responsive-img'>
                                    $_SESSION[usuario_admin]
                                  </div></a></li>
		        				</ul>
		        				<ul id='dropdown' class='dropdown-content'>
									<li><a href='../usuario/'>Editar perfil</a></li>
									<li><a href='../main/logout.php'>Salir</a></li>
								</ul>
			        			<ul class='side-nav' id='mobile'>
	        						<li><a href='../jugos/index.php'>Jugos</a></li>
		          					<li><a href='../ingredientes/index.php'>ingredientes</a></li>
		          					<li><a href='../tamanio/index.php'>Vasos</a></li>
		          					<li><a class='dropdown-button' href='#' data-activates='dropdown'>
			          				<li><a class='dropdown-button' href='#' data-activates='dropdown-mobile'>$_SESSION[usuario_admin]</a></li>
	      						</ul>
	      						<ul id='dropdown-mobile' class='dropdown-content'>
									<li><a href='../usuario/'>Editar perfil</a></li>
										<li><a href='../main/logout.php'>Salir</a></li>
								</ul>";
                }
                elseif($_SESSION['permisos']==4)
                {
                    
                $header.="<a href='../main/' class='brand-logo'>
                            <i class='material-icons left hide-on-med-and-down'>undo</i>Sitio Privado
		        		</a>
                        <a href='#' data-activates='mobile' class='button-collapse'><i class='material-icons'>menu</i></a>
	        					<ul class='right hide-on-med-and-down'>
		          					<li><a href='../jugos/index.php'>Jugos</a></li>
		          					<li><a href='../ingredientes/index.php'>ingredientes</a></li>
		          					<li><a href='../promociones/index.php'>Promociones</a></li>
		          					<li><a href='../admin/index.php'>Administradores</a></li>
		          					<li><a href='../usuario/index.php'>Usuario</a></li>
		          					<li><a href='../descuentos/index.php'>Descuentos</a></li>
		          					<li><a href='../tamanio/index.php'>Vasos</a></li>
		          					<li><a class='dropdown-button' href='#' data-activates='dropdown'><div class='chip'>
                                    <img id='foto_perfil imagen_video'
                                    src='data:image/*;base64,$_SESSION[img_admin]'
                                    class='responsive-img'>
                                    $_SESSION[usuario_admin]
                                  </div></a></li>
		        				</ul>
		        				<ul id='dropdown' class='dropdown-content'>
									<li><a href='../usuario/'>Editar perfil</a></li>
									<li><a href='../main/logout.php'>Salir</a></li>
								</ul>
			        			<ul class='side-nav' id='mobile'>
	        						<li><a href='../jugos/index.php'>Jugos</a></li>
		          					<li><a href='../ingredientes/index.php'>ingredientes</a></li>
		          					<li><a href='../promociones/index.php'>Promociones</a></li>
		          					<li><a href='../admin/index.php'>Administradores</a></li>
		          					<li><a href='../descuentos/index.php'>Descuentos</a></li>
		          					<li><a href='../tamanio/index.php'>Vasos</a></li>
			          				<li><a class='dropdown-button' href='#' data-activates='dropdown-mobile'>$_SESSION[usuario_admin]</a></li>
	      						</ul>
	      						<ul id='dropdown-mobile' class='dropdown-content'>
									<li><a href='../usuario/'>Editar perfil</a></li>
										<li><a href='../main/logout.php'>Salir</a></li>
								</ul>";
                }
            }
            else
            {
                $header.="<a href='../../' class='brand-logo'>
	        						<i class='material-icons'>web</i>
	    						</a>";
            }
            $header .= "</div>
		    			</nav>
	  				</div>
	  				<div class='container center-align'>";
            print ($header);
            if($session)
            {
                if($filename != "login.php")
                {
                    
                    print("<h2>$title</h2>");
                }
                else
                {
                    header("location: index.php");
                }
            }
            else
            {
                if($filename != "login.php" && $filename != "register.php" && $filename != "activesesion.php" && $filename != "404.php")
                {
                    print("<div class='card-panel red'><a href='../main/login.php><h5>Debe iniciar sesion.</h5></a></div>");
                }
                else
                {
                    print("<h5>$title</h5>");
                }
            }
        }