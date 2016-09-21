<?php
ob_start();
require("/main/page2.php");
require("../lib/database.php");
Page2::header("Ya haz iniciado sesion rufian");
?>
<div class="row center-align">
	<p>Hemos descubierto que tienes una sesion activa, vuelva a esa sesion y termine sus cambios.</p>
	<a href="login.php" class=" red darken-4 waves-effect waves-light btn">Volver al login</a>
</div>
<?php
Page2::footer();
?>