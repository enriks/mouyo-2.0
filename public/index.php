<?php
require("../lib/database.php");
require("main/page2.php");
Page2::header();
?>
		<!-- Contenido a cargar -->
        <div id="divSlider">
        </div>

        <?php require 'inc/faq.php'; ?>
		<?php require 'inc/acercade.php'; ?>	 
		<?php require 'inc/imagenes.php'; ?>


		<?php require 'inc/footer.php'; ?>
		
		<!--fin del contenido  -->

 <?php Page2::footer();?>
		