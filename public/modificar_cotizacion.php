<?php
ob_start();
require("main/page2.php");
require("../lib/database.php");
$id=base64_decode($_GET['id']);
Page2::header();
$ss="select * from detalle_cotizacion where id_cotizacion=?";
$pp=array($id);
$cot=Database::getRow($ss,$pp);
$tamanio=$cot['id_tamanio'];
$cotizacion=$cot['id_cotizacion'];
$cantidad=$cot['cantidad'];

if(!empty($_POST))
{
    try
    {
        $tamanio=$_POST['tamanio'];
        $cantidad=$_POST['cantidad'];
        $cotizacion=$_POST['cotizacion'];
    if($cantidad == "")
    {
        throw new Exception("Escribe una cantidad si vas a cotizar.");
    }
        elseif(isset($tamanio)=="")
        {
            throw new Exception("Escoge un tamaño si vas a cotizar.");
        }
       elseif(isset($cotizacion)=="")
        {
            throw new Exception("Escoge una Cotizacion,sino que vas a cotizar?.");
        }
        
        
            
            
                $sql="update detalle_cotizacion set cantidad=?,id_tamanio=?,id_cotizacion=? where id_cotizacion=?";
                $params=array($cantidad,$tamanio,$cotizacion,$id);
                Database::executeRow($sql,$params);
                @header("location: cotizacion.php");
            
          
    }
    catch (Exception $error)
    {
        print("<div class='card-panel red'><i class='material-icons left'>error</i>".$error->getMessage()."</div>");
    }
    
}

$elselect="SELECT cotizacion.nombre nombre_cotizacion,jugos.nombre nombre_jugo, jugos.imagen imagen_jugo,jugos.precio,tamanio.tamanio nombre_tamanio,detalle_cotizacion.id_jugo,detalle_cotizacion.cantidad from jugos,tamanio,cotizacion,detalle_cotizacion where detalle_cotizacion.id_cotizacion = ? and detalle_cotizacion.id_jugo = jugos.id_jugo and detalle_cotizacion.id_tamanio = tamanio.id_tamanio and cotizacion.id_usuario=? and detalle_cotizacion.id_cotizacion=cotizacion.id_cotizacion";
$params=array($id,$_SESSION['id_usuario']);
$dats=Database::getRows($elselect,$params);
$tabla = '';


 foreach($dats as $dass)
    {

$tabla.= "<form method='post' name='frmCotizacion' class='container'>
        <fieldset>
            <div class='row'>
            <h2 class='main-theme-color'>$dass[nombre_jugo]</h2>
                <div class='input-field col s6 m6 center'>
                    <i class='material-icons prefix'>format_list_numbered</i>
                    <input id='cantidad' type='text' name='cantidad' value='$cantidad' class='validate'/>
                    <label for='cantidad'>Cantidad</label>
                     <img class='responsive-img' height='100' width='100' src='data:image/*;base64,$dass[imagen_jugo]'/>
                </div>
                <div class='input-field col s6 m6'>";
       //print($_SESSION['id_usuario']);
        if(isset($_SESSION['id_usuario'])){
        $skl="SELECT id_tamanio, tamanio FROM tamanio";
        $skl2="SELECT id_cotizacion, nombre FROM cotizacion where id_usuario=".($_SESSION['id_usuario'])."";
                    	$tabla.=page2::setCombo_texto("tamanio",$tamanio,$skl);
                    	$tabla.=page2::setCombo_texto("cotizacion",$cotizacion,$skl2);
           }
        $tabla.="
                </div>
            </div>
            <button type='submit' name='enviar1' class='btn grey left tooltipped' data-position='bottom' data-delay='50' data-tooltip='I am tooltip'><i class='material-icons right'>add</i>Guardar Cambios</button> 
            </fieldset>
            </form>";
 }
print($tabla);
?>

<?php Page2::footer();?>
 <script src='../bin/materialize.js'></script>
<script src='../js/init.js'></script>

<?php require 'inc/faq.php'; ?> 
<?php require 'inc/acercade.php'; ?>	 
<?php require 'inc/footer.php'; ?>