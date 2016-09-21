<?php
    require("main/page2.php");
	require("../lib/database.php");
   	Page2::header();
$tamanio='';
$cotizacion='';
    if(isset($_POST['enviar69']))
    {
        try
        {
            $nombre=$_POST['nombre'];
            $fecha=date('Y-m-d');
            if($nombre == "")
            {
                throw new Exception("Escribe un nombre para la cotizacion.");
            }
            else
            {
                $sql="insert into cotizacion(nombre,fecha,id_usuario) values(?,?,?)";
                $params=array($nombre,$fecha,$_SESSION['id_usuario']);
                Database::executeRow($sql,$params);
            }
        }
        catch (Exception $error)
        {
            print("<div class='card-panel red'><i class='material-icons left'>error</i>".$error->getMessage()."</div>");
        }
    }
?>
    <!--formulario de carrito -->
<br>
    <div class="row">
        <div class="col s4 offset-s5">
        <a class="waves-effect waves-light btn modal-trigger" href="#modal2">Nueva cotizacion</a>
        <div id="modal2" class="modal modal-fixed-footer">
            <form method='post' name="nuevaCot" class='row center-align'>
                <div class='row'>
                    <div class='input-field col s12'>
                        <i class='material-icons prefix'>add</i>
                        <input id='nombre' type='text' name='nombre' class='validate' length='100' maxlenght='100' required/>
                        <label for='nombre'>Nombre</label>
                    </div>
                </div>
                <button type='submit' name="enviar69" class='btn blue'><i class='material-icons right'>save</i>Guardar</button>
            </form>
          </div>
        </div>
    </div>
<!--cargamos las tabs -->
         <?php
            $tabs="<div class='col s12'>
      <ul class='tabs'>";
            $select="select * from cotizacion where id_usuario =?";
$params=array($_SESSION['id_usuario']);
            $data=Database::getRows($select,$params);
            foreach($data as $datos)
            {
                $tabs.="<li class='tab col s3'><a href='#test$datos[id_cotizacion]'>$datos[nombre]</a></li>";
            }
        $tabs.="
      </ul>
    </div>";

$elselect="SELECT cotizacion.nombre nombre_cotizacion,jugos.nombre nombre_jugo, jugos.imagen imagen_jugo,jugos.precio,tamanio.tamanio nombre_tamanio,detalle_cotizacion.id_jugo,detalle_cotizacion.cantidad from jugos,tamanio,cotizacion,detalle_cotizacion where detalle_cotizacion.id_cotizacion = ? and detalle_cotizacion.id_jugo = jugos.id_jugo and detalle_cotizacion.id_tamanio = tamanio.id_tamanio and cotizacion.id_usuario=? and detalle_cotizacion.id_cotizacion=cotizacion.id_cotizacion ";

   $contenido=""; 
foreach($data as $datas)
{
    $totaal=0;
    $params=array($datas['id_cotizacion'],$_SESSION['id_usuario']);
    $dats=Database::getRows($elselect,$params);
  $tabs.="<div id='test$datas[id_cotizacion]' class='col s12'><table style='width:100%' class='bordered'>
        <thead>
          <tr>
              <th data-field='imagen'>Imagen</th>
              <th data-field='nombre'>Nombre</th>
              <th data-field='tamanio'>Tamaño</th>
              <th data-field='precio'>Precio</th>
              <th data-field='cantidad'>Cantidad</th>
              <th data-field='total'>Total</th>
              <th data-field='accion'>Accion</th>
          </tr>
        </thead><tbody>";

    $contenido='';
    foreach($dats as $das)
    {
        //$contenido2="";
        $total=$das['precio']*$das['cantidad'];
        $contenido.="
          <tr>
            <td><img class='responsive-img' height='100' width='100' src='data:image/*;base64,$das[imagen_jugo]'></td>
            <td>$das[nombre_jugo]</td>
            <td>$das[nombre_tamanio]</td>
            <td>$das[precio]</td>
            <td>$das[cantidad]</td>
            <td>$total</td>
            <td><a class='waves-effect waves-light btn red modal-trigger' href='#modal$das[id_jugo]'>Eliminar</a>
            <a class='waves-effect waves-light btn blue modal-trigger tooltipped' data-position='right' data-delay='150' data-tooltip='nada' href='#modal3$das[id_jugo]'><i class='material-icons right'>add_shopping_cart</i>Modificar jugo</a></td>
          </tr>";
        $totaal=$total+$totaal;
        
    }
    $tabs.=$contenido;
    $tabs.="</tbody>
      </table>";
    foreach($dats as $dass)
    {
        //$contenido2="";
        $tabs.="<div id='modal$dass[id_jugo]' class='modal'>
    <div class='modal-content'>
      <form method='post' action='delete_jugocotizacion.php' class='row center-align'>
	<input type='hidden' name='id' value='$dass[id_jugo]'/>
	<h4>Eliminar el jugo</h4>
	<button type='submit' class='btn red'><i class='material-icons right'>done</i>Si</button>
	<a href='index.php' class='btn grey'><i class='material-icons right'>cancel</i>No</a>
</form>
    </div>
    <div class='modal-footer'>
      <a href='#!' class=' modal-action modal-close waves-effect waves-green btn-flat'>Cerrar</a>
    </div>
  </div>";
       $tabs.="<div id='modal3$dass[id_jugo]' class='modal'>
    <div class='modal-content'>
     <form method='post' name='frmCotizacion' class='center-align'>
        <fieldset>
            <div class='row'>
                <div class='input-field col s6 m6'>
                    <i class='material-icons prefix'>format_list_numbered</i>
                    <input id='cantidad' type='text' name='cantidad' class='validate' value='$das[cantidad]'/>
                    <label for='cantidad'>Cantidad</label>
                </div>
                <div class='input-field col s6 m6'>";
        $skl="SELECT id_tamanio, tamanio FROM tamanio";
        $skl2="SELECT id_cotizacion, nombre FROM cotizacion where id_usuario = $_SESSION[id_usuario]";
        $tamanio=$das['nombre_tamanio'];
        $cotizacion=$das['nombre_cotizacion'];
                    	$tabs.=page2::setCombo_texto("tamanio",$tamanio,$skl);
                    	$tabs.=page2::setCombo_texto("cotizacion",$cotizacion,$skl2);
       $tabs.="
                </div>
            </div>
            <button type='submit' name='enviar1' class='btn grey left tooltipped' data-position='bottom' data-delay='50' data-tooltip='I am tooltip'><i class='material-icons right'>add</i></button> 
            </fieldset>
            </form>
    </div>
    <div class='modal-footer'>
      <a href='#!' class=' modal-action modal-close waves-effect waves-green btn-flat'>Cerrar</a>
    </div>
  </div>";
    }
   $tabs.="<div class='row'>
    <div class='col s12'>
    <div class='card-panel teal '><p class='card-panel  light-blue accent-3'>Total: $$totaal</p>
    <a class='waves-effect waves-light btn red' href='delete_cotizacion.php?id=".base64_encode($datas['id_cotizacion'])."&total=".base64_encode($totaal)."'>Eliminar</a></div>
        
    </div>
</div></div>";
    
}
//$contenido.=$contenido2;
print $tabs;
//print $contenido;
        ?>
 
<?php require 'inc/footer.php' ?>

 <?php Page2::footer();?>

