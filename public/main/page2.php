<?php
session_start();
    class page2
    {
        public static function header()
        {
            #si se necesita la hora :v
            ini_set("date.timezone","America/El_Salvador");
            
            /*Arreglo que tiene informacio del header, rutas y ubicaciones que se mandan a llamar*/
            
            $session=false;
            $filename=basename($_SERVER['PHP_SELF']);
            $header2="<!DOCTYPE html>
                        <html lang='es'>
                        <head>
                            <meta charset='UTF-8'>
                            <title>Jugos Mouyo</title>
                             <meta name='viewport' content='width=device-width, initial-scale=1.0'/>
                            <link rel='stylesheet' href='../css/materialize.min.css' media='screen,projection'>
                            <link rel='stylesheet' href='../css/ghpages-materialize.css'>
                            <link rel='stylesheet' href='../css/icons.css'>
                            <link rel='stylesheet' href='../css/prism.css'>
                            <link rel='stylesheet' href='../css/hover.css'>
                            <link rel='stylesheet' href='../css/slider.css' media='screen,projection'>
                            <link rel='stylesheet' href='../css/style.css'>
							<link rel='stylesheet' type='text/css' href='../css/jquery.fullPage.js' />
                            <link rel='stylesheet' type='text/css' href='../css/page_scroll.css' />
                        </head>
                        <body class='light-blue lighten-5' >
						<div class='progress' id='divprogress'>
						<div class='indeterminate'></div>
						</div>
                            "; 
            
            /*Variable de sesion que consulta si hay un usuario activo para ver las siguentes páginas*/
            
            if(isset($_SESSION['nombre_apellido_usuario']))
            {
                
                $session=true;
                $header2.="	<ul id='slide-out' class='side-nav teal'>
		                         <li><div class='userView blue-grey lighten-5'>
								 <a class='dropdown-button' href='#user' data-activates='dropdown'>
                                 <div class='left'>
                                    <img width='100' height='100' id='foto_perfil imagen_video'
                                    src='data:image/*;base64,$_SESSION[img]'
                                    class='circle'>
                                  </div>
                                 </a>
								 <a href='#!name'><span class='teal-text name'>$_SESSION[nombre_apellido_usuario]</span></a>
								 </div></li>
								 <li><a class='white-text' href='index.php'><i class='material-icons'>navigation</i>Pagina Principal</a></li>
								 <li><a class='white-text' href='jugos.php'><i class='material-icons'>grade</i>Jugos</a></li>
								 <li><a class='white-text' href='ingredientes.php'><i class='material-icons'>description</i>Ingredientes</a></li>
								 <li><a class='white-text' href='acercade.php'><i class='material-icons'>info</i>Acerca de</a></li>
								 <li><a class='white-text' href='faq.php'><i class='material-icons'>question_answer</i>Preguntas Frecuentes</a></li>
		        				<ul id='dropdown' class='dropdown-content'>
									<li><a href='usuarios.php?id=$_SESSION[id_usuario]'><i class='material-icons'>mode_edit</i>Editar perfil</a></li>
                                    <li><a href='cotizacion.php'><i class='material-icons'>assignment</i>Cotizacion</a></li>
									<li><a href='main/logout.php'><i class='material-icons'>close</i>Salir</a></li>
								</ul>
			        			<!--ul class='side-nav' id='mobile'>
	        						<li><a href='index.php'>Pagina Principal</a></li>
                                    <li><a href='jugos.php'>Jugos</a></li>
                                    <li><a href='ingredientes.php'>Ingredientes</a></li>
                                    <li><a href='acercade.php'>Acerca de</a></li>
                                    <li><a href='faq.php'>Preguntas Frecuentes</a></li>
			          				<li><a class='dropdown-button' href='#' data-activates='dropdown-mobile'>$_SESSION[nombre_apellido_usuario]</a></li>
	      						</ul-->
	      						<ul id='dropdown-mobile' class='dropdown-content'>
									<li><a href='../admin/usuario/save.php?id=$_SESSION[id_usuario] '>Editar perfil</a></li>
                                    <li><a href='cotizacion.php'>Cotizacion</a></li>
									<li><a href='main/logout.php'>Salir</a></li>
								</ul> 
							</ul>" ;
            }
            else
            {
                $header2.="<ul id='slide-out' class='side-nav teal'>
					<li class='white'><div class='userView'>
					<img class='background responsive-img' src='img/mouyo.png'>
                    </div></li>
                    <li><a class='dropdown-button white-text' href='#' data-activates='dropdown-mobile'><i class='material-icons'>perm_identity</i>Sesion</a></li>
                    <li><a class='white-text' href='index.php' id='lnkprogress'><i class='material-icons'>navigation</i>Pagina Principal</a></li>
                    <li><a class='white-text' href='jugos.php' id='lnkprogress'><i class='material-icons'>grade</i>Jugos</a></li>
                    <li><a class='white-text' href='ingredientes.php'><i class='material-icons'>description</i>Ingredientes</a></li>
                    <li><a class='white-text' href='acercade.php'><i class='material-icons'>info</i>Acerca de</a></li>
                    <li><a class='white-text' href='faq.php'><i class='material-icons'>question_answer</i>Preguntas Frecuentes</a></li>
                    </ul>
                    <ul id='dropdown-mobile' class='dropdown-content'>
                    <li><a class='modal-trigger' href='#modal1'><i class='material-icons'>settings_power</i>Iniciar Sesion</a></li>
                    <li><a href='register.php'><i class='material-icons'>note_add</i>Registrarse</a></li>
                    </ul>";
            }
            $header2 .= "
                    <div id='modal1' class='modal'>
                    <div class='modal-content'>
                    <div class='card bordered z-depth-2' style='margin:0% auto; max-width:400px;'>
        <div class='card-header'>
           <i class='material-icons medium white-text'>verified_user</i>
        </div>
        <div class='card-content'>
          <form method='post' name='pene2' action='login.php' enctype='multipart/form-data'>
            <div class='input-field col s12'>
              <input name='alias' id='alias' autocomplete='off' type='text' class='validate'>
              <label for='alias'>Nombre de Usuario</label>
           </div>
            <div class='input-field col s12'>
              <input name='clave' id='clave' autocomplete='off' type='password' class='validate'>
              <label for='clave'>Contraseña</label>
            </div>
            <br>
              <button type='submit' name='enviar' class='btn blue'><i class='material-icons right'>verified_user</i>Iniciar Sesion</button>
          </form> 
        </div>
        <div class='card-action clearfix'>
          <div class='row'>
            <div class='col s12 right-align text-p'>
              <a href='register.php' class='orange-text tooltipped' data-position='top' data-delay='50' data-tooltip='Registrate ahora'>REGÍSTRATE AHORA</a>
            </div>
          </div>
        </div>
      </div>
                    </div>
                    <div class='modal-footer'>
                      <a href='#!' class=' modal-action modal-close waves-effect waves-green btn-flat'>Cerrar</a>
                    </div>
                  </div>
	  				";
            print($header2);
        }
        
        /* se establecen funciones de nombre, valor y consulta al siguiente combobox*/
        
         public static function setCombo($name, $value, $query)
        {
            $data =Database::getRows($query,null);
            $combo="<select name='$name' requeried>";
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
                    <label style='text-transform:capitalize;'>$name</label>";
            print($combo);
        }
         public static function setCombo_texto($name, $value, $query)
        {
            $data =Database::getRows($query,null);
            $combo="<select name='$name' requeried>";
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
                    <label style='text-transform:capitalize;'>$name</label>";
            return $combo;
        }
        
public static function footer()
{
    $footer="<script src='https://www.google.com/recaptcha/api.js'></script><script src='../js/jquery-2.2.3.min.js'></script>
	<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js'></script>
    <script src='http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/jquery-ui.min.js'></script>
   <script src='../js/materialize.min.js'></script>
   <script src='../bin/materialize.js'></script>
   <script src='../jade/lunr.min.js'></script>
   <script src='../js/init.js'></script>
   <script src='../js/prism.js'></script>
    <script src='../js/app.js'></script> 
    <script>
	    				$(document).ready(function() { $('.button-collapse').sideNav(); });
	    				$(document).ready(function() { $('.materialboxed').materialbox(); });
	    				$(document).ready(function() { $('select').material_select(); });
                        $(document).ready(function(){ $('.modal-trigger').leanModal();
                        $('.collapsible').collapsible({
                        accordion : false }); });
                        $('.datepicker').pickadate({ selectMonths: true,  selectYears: 1000, format: 'yyyy-mm-dd' });
                        var options = [ {selector: '#staggered-test', offset: 50, callback: function() { Materialize.toast('This is our ScrollFire Demo!', 1500 ); } }, {selector: '#staggered-test', offset: 205, callback: function() { Materialize.toast('Please continue scrolling!', 1500 ); } }, {selector: '#staggered-test', offset: 400, callback: function() { Materialize.showStaggeredList('#staggered-test'); } }, {selector: '#image-test', offset: 500, callback: function() { Materialize.fadeInImage('#image-test'); } } ]; Materialize.scrollFire(options); 
	    			</script>
</body>
</html>";
    print $footer;
}
    }
        ?>

