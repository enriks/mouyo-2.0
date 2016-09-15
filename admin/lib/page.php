<?php 
   session_start();
    class page
    {
        public static function header()
        {
            $sql="select id_admin,sesion from admin where id_admin=?";
            $params=array(isset($_SESSION['id_admin']));
            $data=Database::getRow($sql,$params);
            if($data['sesion']==0 && isset($_SESSION['id_admin']))
            {
                header("location: ../main/logout.php");
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
                    <link href='../../css/bootstrap.min.css' rel='stylesheet'>

                    <!-- Custom CSS -->
                    <link href='../../css/modern-business.css' rel='stylesheet'>

                    <!-- Custom Fonts -->
                    <link href='../../font-awesome/css/font-awesome.min.css' rel='stylesheet' type='text/css'>

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
                        <a href='../jugos/'>Jugos</a>
                    </li>
                    <li>
                        <a href='../ingredientes/'>Ingredientes</a>
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
                if($_SESSION['permisos']==4)
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
                        <a href='../jugos/'>Jugos</a>
                    </li>
                    <li>
                        <a href='../ingredientes/'>Ingredientes</a>
                    </li>
                    <li>
                        <a href='../descuentos/'>Descuentos</a>
                    </li>
                    <li>
                        <a href='../promociones/'>Promociones</a>
                    </li> 
                    <li>
                        <a href='../admin/'>Administradores</a>
                    </li>
                    <li>
                        <a href='../users/'>Usuarios</a>
                    </li>
                    <li>
                        <a href='../historial/'>Historial</a>
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
            }
            else
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
                        <a href='../main/login.php'>Iniciar sesion</a>
                    </li>
                </ul>
            </div>";
            }
            $header .= "</div></nav>
	  				<div class='container center-align'>";
            print ($header);
            if($session)
            {
                if($filename != "login.php")
                {
                    
                }
                else
                {
                    header("location: index.php");
                }
            }
            else
            {
                if($filename != "login.php" && $filename != "register.php" && $filename != "activesesion.php" && $filename != "404.php"&& $filename != "denied.php")
                {
                    print("<div class='card-panel red'><a href='../main/login.php'><h5>Debe iniciar sesion.</h5></a></div>");
                }
                else
                {
                }
            }
        }

        public static function footer()
        {
            $footer="<script src='js/jquery.js'></script>

            <!-- Bootstrap Core JavaScript -->
            <script src='js/bootstrap.min.js'></script>

            <!-- Script to Activate the Carousel -->
            <script>
            $('.carousel').carousel({
                interval: 5000 //changes the speed
            })
            </script>

        </body>

        </html>";
            print($footer);
        }

        public static function setCombo($name, $value, $query)
        {
            $data =Database::getRows($query,null);
            $combo="<select name='$name' id='$name' class='form-control' requeried>";
            if($value == null)
            {
                $combo .= "<option value='' disabled selected>Selecione una opcion</option>";
            }
            foreach($data as $row)
            {
                $combo .="<option value='$row[0]'";
                if(isset($_POST[$name])==$row[0] || $value == $row[0])
                {
                    $combo.="selected";
                }
                $combo .=">$row[1]</option>";
            }
            $combo.="</select>
                    <label for='$name' class='sr-only' style='text-transform:capitalize;'>$name</label>";
            print($combo);
        }
    }