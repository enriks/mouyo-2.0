<?php
require("main/page2.php");
require("../lib/database.php");
Page2::header();
$tamanio="";
$cotizacion="";
$id=base64_decode($_GET['id']);
if(isset($_POST['enviar1']))
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
        else
        {
            
            $selecto="select id_jugo from detalle_cotizacion where id_jugo=? and id_cotizacion = ?";
            $parametros=array($id,$cotizacion);
            $elif=Database::getRows($selecto,$parametros);
            if($elif == null)
            {
                $sql="insert into detalle_cotizacion(id_jugo,id_cotizacion,id_tamanio,cantidad) values(?,?,?,?)";
                $params=array($id,$cotizacion,$tamanio,$cantidad);
                Database::executeRow($sql,$params);
                @header("location: cotizacion.php");
            }
            else
            {
                throw new Exception("Ya esta cotizado");
            }
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
        $comentario=$_POST['comentario'];
        if($comentario == "")
        {
            throw new Exception("Escribe un comentario, si vas a comentar.");
        }
        else
        {
            $sql="insert into comentarios(id_jugo,id_usuario,comentario) values(?,?,?)";
            $params=array($id,$_SESSION['id_usuario'],$comentario);
            Database::executeRow($sql,$params);
        }
    }
    catch (Exception $error)
    {
        print("<div class='card-panel red'><i class='material-icons left'>error</i>".$error->getMessage()."</div>");
    }
}
if(empty($id))
{
    $todo="no hay datos en id";
    print($todo);
     @header("location: login.php");
     
}
else
{
    $sql = "SELECT jugos.id_jugo,jugos.nombre nombre_jugo,jugos.descripcion descripcion_jugo,jugos.imagen,jugos.precio,tipo_jugo.nombre nombre_tipojugo FROM jugos,tipo_jugo where jugos.id_tipojugo=tipo_jugo.id_tipojugo AND jugos.id_jugo= ? and jugos.estado=0 ORDER BY jugos.nombre";
	$params = array($id);
    $ingre="SELECT ingrediente.nombre nombre_ingrediente from ingrediente,detalle_bebida,jugos WHERE jugos.id_jugo = detalle_bebida.id_jugo and jugos.id_jugo=? and ingrediente.id_ingrediente = detalle_bebida.id_ingrediente";
    $data = Database::getRows($sql, $params);
    $data2 =Database::getRows($ingre, $params);
    if($data != null)
{
    $tabla="";
        $disabled="";
        $texto_tooltip="Cotizacion";
        $comentario_tooltip="Seccion de comentarios";
        if(isset($_SESSION['id_usuario'])==null)
        {
            $disabled="disabled";
            $texto_tooltip="Debes iniciar sesion para cotizar";
            $comentario_tooltip="Debes iniciar sesion antes de comentar";
            $cotisasion="<a $disabled class='waves-effect waves-light btn blue modal-trigger tooltipped white-text' data-position='right' data-delay='150' data-tooltip='$texto_tooltip' href='#modal3'><i class='material-icons right'>add_shopping_cart</i>Agregar a la cotizacion</a>";
        }
        else
        {
            $cotisasion="<a $disabled class='waves-effect waves-light btn blue modal-trigger tooltipped white-text' data-position='right' data-delay='150' data-tooltip='$texto_tooltip' href='#modal3'><i class='material-icons right'>add_shopping_cart</i>Agregar a la cotizacion</a>";
        }
    foreach($data as $row)
		{
        
            $tabla="<br>
    <div class='container' id='divJugo'>
        <div class='row card-panel'>
            <div class='col m8 center'>
                <span><h5 class='teal-text'>$row[nombre_jugo]</h5></span>
                <p class='flow-text'>$row[descripcion_jugo]</p>
                <p>
                <strong>Precio:</strong>$$row[precio] &nbsp;<strong> Tipo de jugo: </strong>$row[nombre_tipojugo]
                </p><br>
                <form method='post' name='nada' enctype='multipart/form-data'>
                $cotisasion
                </form>
                <div id='modal3' class='modal'>
    <div class='modal-content'>
     <form method='post' name='frmCotizacion' class='center-align'>
        <fieldset>
            <div class='row'>
                <div class='input-field col s6 m6'>
                    <i class='material-icons prefix'>format_list_numbered</i>
                    <input id='cantidad' type='text' name='cantidad' class='validate'/>
                    <label for='cantidad'>Cantidad</label>
                </div>
                <div class='input-field col s6 m6'>";
       //print($_SESSION['id_usuario']);
        if(isset($_SESSION['id_usuario'])){
        $skl="SELECT id_tamanio, tamanio FROM tamanio";
        $skl2="SELECT id_cotizacion, nombre FROM cotizacion where pedido=0 and id_usuario=$_SESSION[id_usuario]";
                    	$tabla.=page2::setCombo_texto("tamanio",$tamanio,$skl);
                    	$tabla.=page2::setCombo_texto("cotizacion",$cotizacion,$skl2);
           }
        $tabla.="
                </div>
            </div>
            <button $disabled type='submit' name='enviar1' class='btn grey left tooltipped' data-position='bottom' data-delay='50' data-tooltip='I am tooltip'><i class='material-icons right'>add</i></button> 
            </fieldset>
            </form>
    </div>
    <div class='modal-footer'>
      <a href='#!' class=' modal-action modal-close waves-effect waves-green btn-flat'>Cerrar</a>
    </div>
  </div>";
                
        foreach($data2 as $row2)
		      {
                $tabla .="
                <ul class='collapsible' data-collapsible='accordion'>
                    <li>
                        <div class='collapsible-header'><i class='material-icons'></i>Ingredientes</div>
                        <div class='collapsible-body'>
                  <p>-$row2[nombre_ingrediente]</p>
                  </div>
                    </li>
                </ul>
            </div>
            <div class='col m4 s12 center'>
                <img src='data:image/*;base64,$row[imagen]' class='responsive-img z-depth-2'>
            </div>
        </div>
    </div>  
                ";
            }
                          
        }
        
        $tabla.="<div class='fixed-action-btn horizontal click-to-toggle' style='bottom: 45px; right: 24px;'>
<a class='btn-floating btn-large red modal-trigger tooltipped' data-position='left' data-delay='50' data-tooltip='$comentario_tooltip' href='#modal2'><i class='material-icons right'>chat</i></a>
</div>
<div class=''>
    <div class='row'>
        <div class=''>
            <div id='modal2' class='modal'>
<div class='modal-content'>
<ul class='collection'>"; 

        $sqll="SELECT  comentarios.id_comentario,comentarios.id_usuario,usuario.nombre,usuario.foto_perfil,comentarios.comentario from usuario,comentarios where comentarios.estado=0 and usuario.id_usuario = comentarios.id_usuario and comentarios.id_jugo = ?  order by comentarios.id_comentario";
        $paramss=array($id);
        $dati=Database::getRows($sqll,$paramss);
        foreach($dati as $date)
        { $tabla.="
            <li class='collection-item avatar'>
            <img src='data:image/*;base64,$date[foto_perfil]' alt='' class='circle'>
            <span class='title'>$date[nombre]</span>
                <p>$date[comentario]</p>";
         if(isset($_SESSION['id_usuario'])){
                $tabla.= "<a href='eliminar_comentario.php?id=                                                      ".base64_encode($date['id_comentario'])."'>Eliminar comentario</a>";
         }
                  
                
        $tabla.="</li>";    
        }
        
        $tabla.="
</ul>
<form method='post' name='frmComentario' class='center-align'>
        <fieldset>
            <div class=''>
                <div class='input-field'>
          <textarea name='comentario' id='comentario' class='materialize-textarea'></textarea>
          <label for='comentario'>Nuevo Comentario</label>
        </div>
                <div class='input-field'>
                    <button $disabled type='submit' name='enviar2' class='btn  left'><i class='material-icons right'>chat</i>Comentar</button> 	
                </div>
                <div class='modal-footer'>
                    <a href='#!' class=' modal-action modal-close waves-effect waves-green btn-flat'>Cerrar</a>
                </div>
            </div>
            </fieldset>
            </form>
</div>
</div>
        </div>
    </div>
</div>";
        print($tabla);
       
    }
}
?>


<script src='../bin/materialize.js'></script>
<script src='../js/init.js'></script>

<?php require 'inc/faq.php'; ?> 
<?php require 'inc/acercade.php'; ?>	 
<?php require 'inc/footer.php'; ?>

<?php Page2::footer();?>