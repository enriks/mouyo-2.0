<?php
    require("../main/page2.php");
	require("../../lib/database.php");
?>

<!--Contenido principal de jugos-->
    <div class="">
        <form method="post" name="JUGOS" enctype='multipart/form-data'>
       <div class="row ">
          <div class="col s10 l10">
             
              <?php
			  $tipo=null;
			  $sql="select * from tipo_jugo ";
			  Page2::setCombo("tipo",$tipo,$sql);
       	       
			  ?>
          </div>
        <div class="input-field col s2 ">
            <button type='submit' class='btn blue'><i class="material-icons">search</i></button>
        </div>
       </div>
    </form>
    </div>

    <div class="row">
        
        <!-- Cargamos los datos de la pagina -->
       <?php
        
            $sql='select * from jugos order by nombre';
            $data2=Database::getRows($sql,null);
            foreach($data2 as $row)
            {
			?>	
                <div class='col s12 m4 l4 '>
					<div class='card center'>
						<div class='card-image waves-effect waves-block waves-light'>
							<img class='col l6 offset-l3 hover effect activator' src='data:image/*;base64,<?php print $row['imagen'] ?>'>
						</div>
						<div class='card-content'>
							<span class='card-title activator grey-text text-darken-4'><?php echo $row['nombre'] ?><i class='material-icons right'>more_vert</i></span>
							<p><a href='jugo.php?id=".base64_encode(<?php echo $row['id_jugo'] ?>)." '>Ver jugo</a></p>
						</div>
						<div class='card-reveal'>
							<span class='card-title grey-text text-darken-4'><?php echo $row['nombre'] ?><i class='material-icons right'>close</i></span>
							<p><?php echo $row['descripcion'] ?></p>
						</div>
					</div>
				
				</div>
			<?php
			}
		?>
</div>
 
