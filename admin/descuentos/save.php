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
    $nombre=null;
    $jugo=null;
    $descuento=null;
    $fecha_inicio=null;
    $fecha_limite=null;
    $descripcion=null;
    
}
else
{
    $id = base64_decode($_GET['id']);
    $sql = "SELECT * FROM descuentos WHERE id_descuento = ?";
    $params = array($id);
    $data = Database::getRow($sql, $params);
    $nombre=htmlentities($data['nombre']);
    $jugo=htmlentities($data['id_jugo']);
    $descuento=htmlentities($data['descuento']);
    $fecha_inicio=htmlentities($data['fecha_inicio']);
    $originalDate = "$fecha_inicio";
    $newDate = date("Y-m-d", strtotime($originalDate));
    $fecha_inicio=$newDate;
    $fecha_limite=htmlentities($data['fecha_limite']);
    $originalDate = "$fecha_limite";
    $newDate = date("Y-m-d", strtotime($originalDate));
    $fecha_inicio=$newDate;
}

if(!empty($_POST))
{
     $_POST = Validator::validateForm($_POST);
     $nombre=$_POST['nombre'];
     $jugo=htmlentities($_POST['jugo']);
     $descuento=htmlentities($_POST['descuento']);
     $fecha_inicio=htmlentities($_POST['fecha_inicio']);
    $originalDate = $fecha_inicio;
    $newDate = date("Y-m-d", strtotime($originalDate));
    $fecha_inicio=$newDate;
     $fecha_limite=htmlentities($_POST['fecha_limite']);
    $originalDate = $fecha_limite;
    $newDate = date("Y-m-d", strtotime($originalDate));
    $fecha_inicio=$newDate;
    try
    {
        if($nombre == null || $jugo == null || $descuento == null || $fecha_inicio == null || $fecha_limite == null )
        {
            throw new Exception("Datos incompletos");
        }
        
        if($id==null)
        {
            
                $sql = "INSERT INTO descuentos(nombre,id_jugo,descuento,fecha_inicio,fecha_limite) VALUES(?,?,?,?,?)";
                $params = array($nombre,$jugo,$descuento,$fecha_inicio,$fecha_limite);
            $sql2 = "INSERT INTO `historial` (`fecha`, `accion`, `id_admin`) VALUES(?, ?,?)";
        $params2=array($fecha,"Inserto el descuento $nombre",$_SESSION['id_admin']);
        Database::executeRow($sql2, $params2);
            Database::executeRow($sql, $params);
        @header("location: index.php");
        }
        else
        {
            $sql = "update descuentos set nombre=?, id_jugo=?,descuento=?,fecha_inicio=?,fecha_limite=? where id_descuento=?";
            $params = array($nombre,$jugo,$descuento,$fecha_inicio,$fecha_limite,$id);
            Database::executeRow($sql, $params);
            $sql2 = "INSERT INTO `historial` (`fecha`, `accion`, `id_admin`) VALUES(?, ?,?)";
        $params2=array($fecha,"Modifico el descuento $nombre",$_SESSION['id_admin']);
        Database::executeRow($sql2, $params2);
        @header("location: index.php");
        }
         
    }
    catch (Exception $error)
    {
        print("<br><br><br><br><div class='card-panel red'><i class='material-icons left'>error</i>".$error->getMessage()."</div>");
    }
}
?>
<br><br>
<div class="main-content">

        <!-- You only need this form and the form-basic.css -->

<<<<<<< HEAD
        <form class="form-labels-on-top" autocomplete="off" enctype='multipart/form-data' onkeyup="calcLong('nombre','label',this,30)" onkeydown="calcLong('descuento','input',this,2)" name="nada" method="post" onsubmit="return Valida(this);">
=======

        <form class="form-labels-on-top" autocomplete="off" enctype='multipart/form-data' onkeyup="calcLong('nombre','label',this,30)" onkeydown="calcLong('descuento','input',this,2)" name="nada" method="post" onsubmit="return Valida(this);">

        <form class="form-labels-on-top" autocomplete="off" enctype='multipart/form-data' onkeyup="calcLong('nombre','label',this,30)" onkeydown="calcLong('descuento','input',this,2)" onkeyup="existeFecha('fecha_inicio', 'label'); existeFecha2('fecha_limite', 'label')" name="nada" method="post">

>>>>>>> ee1203cb596fec3b9bad284e84568be2c4f0c99e

            <div class="form-title-row">
                <h1>Descuento</h1>
            </div>

            <div class="form-row">
                <label>
                    <span>Titulo del descuento:</span>
                    <input type="text" name="nombre" minlength="10" required value="<?php print($nombre);?>">
                </label>
            </div>

<<<<<<< HEAD
            <div class="form-row" name="combo" onchange="ValidarCombo(this.value);">
=======

            <div class="form-row" name="combo" onchange="ValidarCombo(this.value);">

            <div class="form-row" id="combo">

>>>>>>> ee1203cb596fec3b9bad284e84568be2c4f0c99e
                <label><span>Selecciona el jugo para descuento</span></label>
                <?php
                    $sql = "SELECT id_jugo,nombre FROM jugos where estado=0";
                    Page::setCombo("jugo", $jugo, $sql);
                ?>
            </div>
            
            <div class="form-row">
                <label>
                    <span>Fecha incio</span>
                    <input type="date" name="fecha_inicio" id="fecha_i" required value="<?php print($fecha_inicio);?>">
                </label>
            </div>

            <div class="form-row">
                <label>
                    <span>Fecha limite</span>
                    <input type="date" name="fecha_limite" id="fecha_f" onchange="validarfecha(this.value);" required value="<?php print($fecha_limite);?>">
                </label>
            </div>

            <div class="form-row">
                <div class="input-group">
                    <label class="sr-only" for="exampleInputAmount">Descuento (en porcentaje)</label>
                  <div class="input-group-addon">%</div>
<<<<<<< HEAD
                      <input type="number" name="descuento" maxlength="5" min='0' onchange="ValidarSiNumero(this.value);" class="form-control" value="<?php print($descuento);?>" placeholder="Descuento">
=======

                      <input type="number" name="descuento" maxlength="5" min='0' onchange="ValidarSiNumero(this.value);" class="form-control" value="<?php print($descuento);?>" placeholder="Descuento">

                      <input type="number" name="descuento" maxlength="5" min='0' class="form-control" value="<?php print($descuento);?>" placeholder="Descuento">

>>>>>>> ee1203cb596fec3b9bad284e84568be2c4f0c99e
                </div>
            </div>
            <div class="form-row">
                <button type="submit">Guardar</button>
                <button type="button"><a href="index.php" style="color:#fff;">Cancelar</a></button>
            </div>

        </form>

    </div>
    <script type="text/javascript">

<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> ee1203cb596fec3b9bad284e84568be2c4f0c99e
    function Valida(formulario) {
                /* Validación de campos NO VACÍOS */
                if ((formulario.nombre.value.length == 0) || (formulario.combo.value.length ==0)) {
                    alert('Debe completar todos los campos y Cajones.');
                    return false;
                }   
                if (isNaN(parseInt(formulario.descuento.value))) {
                    alert('El campo de precio debe ser Numerico.');
                    return false;
                }  
                /* validación del e-mail */
                var ercorreo=/^[^@\s]+@[^@\.\s]+(\.[^@\.\s]+)+$/;          
                if (!(ercorreo.test(formulario.email.value))) {  
                    alert('Contenido del email no es CORREO ELECTR&Oacute;NICO v&aacute;lido.');
                    return false; }
                /* si no hemos detectado fallo devolvemos TRUE */
                return true;
            }

<<<<<<< HEAD
=======
=======
>>>>>>> origin/master
>>>>>>> ee1203cb596fec3b9bad284e84568be2c4f0c99e
    function comprueba_combo(indice){
          error = "";
          indice = document.getElementById("combo").selectedIndex;
          if( indice == null || indice == 0 ) {
            error = "Elija una opcion en el cajon de Opciones"
          return false;
            }
        }

      function calcLong(txt, dst, formul, maximo)

      {

      var largo

      largo = formul[txt].value.length

      if (largo > maximo)

      formul[txt].value = formul[txt].value.substring(0,maximo)

      formul[dst].value = formul[txt].value.length

      }
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> ee1203cb596fec3b9bad284e84568be2c4f0c99e
function validarfecha() {
        var inicio = document.getElementById('fecha_i').value; 
        var finalq  = document.getElementById('fecha_f').value;
        inicio= new Date(inicio);
        finalq= new Date(finalq);

        if(inicio>finalq){
        alert('La fecha de inicio puede ser mayor que la fecha fin');
        }
<<<<<<< HEAD
=======
=======

      function existeFecha(fecha){
      var fechaf = fecha.split("/");
      var day = fechaf[0];
      var month = fechaf[1];
      var year = fechaf[2];
      var date = new Date(year,month,'0');
      if((day-0)>(date.getDate()-0)){
            return false;
      }
      return true;
}
 
function existeFecha2 (fecha) {
        var fechaf = fecha.split("/");
        var d = fechaf[0];
        var m = fechaf[1];
        var y = fechaf[2];
        return m > 0 && m < 13 && y > 0 && y < 32768 && d > 0 && d <= (new Date(y, m, 0)).getDate();
}
>>>>>>> origin/master
>>>>>>> ee1203cb596fec3b9bad284e84568be2c4f0c99e

      </script>
    <?php page::footer();?>