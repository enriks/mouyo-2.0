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
            $filename=basename($_SERVER['PHP_SELF']); ?>
            <!DOCTYPE html>
			<html lang="es" >
				<head>
					<?php require 'inc/emeral_links.php'; ?>
					<?php require 'inc/emeral_inc.php'; ?>
			
			
				</head>
				<body class="home page page-id-9 page-template-default wpb-js-composer js-comp-ver-4.6.2 vc_responsive">
					<div class="material-emerald-loader-wrapper">
						<div class="material-emerald-loader-nested-circles"></div>
					</div>
					
		
            
            <!--Variable de sesion que consulta si hay un usuario activo para ver las siguentes páginas -->
            <?php 
            if(isset($_SESSION['nombre_apellido_usuario']))
            {
				$session=true;
                if( $session ){
					
					 require 'inc/menu_sesion.php';
				} 
                
 
			}
			else
			{ 
            	    	
				require 'inc/menu.php';
				
			} ?>
			
			  <div id='modal1' class='modal center'>
                    <div class='modal-content'>
                    
        <div class='card-header small-header-color-bg small-header-color center'>
           <i class='material-icons medium white-text'>verified_user</i>
        </div>
        <div class='card-content'>
          <form method='post' action='login.php' enctype='multipart/form-data'>
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
			  <br>
            <div class='col s12 center right-align text-p'>
              <a href='register.php' class='orange-text tooltipped' data-position='top' data-delay='50' data-tooltip='Registrate ahora'>REGÍSTRATE AHORA</a>
            </div>
          </div>
        </div>
     
                    </div>
                    <div class='modal-footer'>
                      <a href='#!' class=' modal-action modal-close waves-effect waves-green btn-flat'>Cerrar</a>
                    </div>
					</div>
			

	  		
        <?php   
		}
		
        /* se establecen funciones de nombre, valor y consulta al siguiente combobox*/
        
         public static function setCombo($name, $value, $query)
        {
            $data =Database::getRows($query,null);
            $combo="<select class='' name='$name' requeried>";
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
{ ?>
    <script src='https://www.google.com/recaptcha/api.js'></script>
	<!--script src='../js/jquery-2.2.3.min.js'></script>
	<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js'></script>
    <script src='http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/jquery-ui.min.js'></script>
	<script src='../js/materialize.min.js'></script-->
	<script src='../bin/materialize.js'></script>
	<!--script src='../jade/lunr.min.js'></script-->
	<script src='../js/init.js'></script>
	<!--script src='../js/prism.js'></script-->
    <!--script src='../js/app.js'></script--> 
    <script>
	    				//$(document).ready(function() { $('.button-collapse').sideNav(); });
	    				//$(document).ready(function() { $('.materialboxed').materialbox(); });
	    				//$(document).ready(function() { $('select').material_select(); });
                        //$(document).ready(function(){ $('.modal-trigger').leanModal();
                       // $('.collapsible').collapsible({
                       // accordion : false }); });
                       /* $('.datepicker').pickadate({ selectMonths: true,  selectYears: 1000, format: 'yyyy-mm-dd' });
                        var options = [ {selector: '#staggered-test', offset: 50, callback: function() { Materialize.toast('This is our ScrollFire Demo!', 1500 ); } }, {selector: '#staggered-test', offset: 205, callback: function() { Materialize.toast('Please continue scrolling!', 1500 ); } }, {selector: '#staggered-test', offset: 400, callback: function() { Materialize.showStaggeredList('#staggered-test'); } }, {selector: '#image-test', offset: 500, callback: function() { Materialize.fadeInImage('#image-test'); } } ]; Materialize.scrollFire(options); */
	    			</script>
					
					<?php require 'inc/palette.php'; ?>	
				<?php require 'inc/script.php'; ?>
			<script src="inc/main.js"></script>
					
		</body>
</html>
</body>
</html>
    
<?php  }
		
	}
?>
