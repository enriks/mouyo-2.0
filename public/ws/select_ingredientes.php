<?php
	require("../main/page2.php");
	require("../../lib/database.php");
?>

    <div class="row">
        <?php
       
            $sql='select * from ingrediente order by nombre';
            $data2=Database::getRows($sql,null);
            foreach($data2 as $row)
            {
				?>
		<div class='col s12 l4 '>
			<div class='card large'>
				<div class='card-image waves-effect waves-block waves-light'>
					<img class='activator hovereffect responsive-img' src='data:image/*;base64,<?php print $row['imagen']?>'>
				</div>
				<div class='card-content'>
					<span class='card-title activator grey-text text-darken-4'><?php echo $row['nombre'] ?><i class='material-icons right'>more_vert</i></span>
				</div>
				<div class='card-reveal'>
					<span class='card-title grey-text text-darken-4'><?php echo $row['nombre'] ?><i class='material-icons right'>close</i></span>
					<p><?php echo $row['descripcion']?></p>
				</div>
			</div>
		</div>
            <?php
			}
        ?>
    </div>
