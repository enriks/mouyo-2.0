
<?php
ob_start();
require("../lib/page2.php");
require("../../lib/database.php");
Page2::header("Haz sido baneado");
?>
<div class="row center-align">
	<p>Debido a tu comportamiento inapropiado un acmon te dio banamex papu, ni modo vayase a legion Holk.</p>
	<a href="porhub.com" class=" red darken-4 waves-effect waves-light btn">Volver al Hoyo</a>
</div>
<?php
Page2::footer();
?>