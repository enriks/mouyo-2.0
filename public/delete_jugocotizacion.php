<?php
ob_start();
require("main/page2.php");
    require("../lib/database.php");
Page2::header();

if(!empty($_GET['id'])) 
{
    $id =base64_decode( $_GET['id']);
}
else
{
    header("location: index.php");
}

if(!empty($_POST))
{
	$id = $_POST['id'];
	try 
	{
		$sql = "DELETE FROM detalle_cotizacion WHERE id_jugo = ?";
	    $params = array($id);
	    Database::executeRow($sql, $params);
	    @header("location: index.php");
	} 
	catch (Exception $error) 
	{
		print("<div class='card-panel red'><i class='material-icons left'>error</i>".$error->getMessage()."</div>");
	}
}
?>
<form method='post' class='row center-align'>
	<input type='hidden' name='id' value='<?php print($id); ?>'/>
	<h4>Eliminar la cotizacion</h4>
	<button type='submit' class='btn red'><i class='material-icons right'>done</i>Si</button>
	<a href='index.php' class='btn grey'><i class='material-icons right'>cancel</i>No</a>
</form>
<?php
Page2::footer();
?>