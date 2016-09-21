<?php
ob_start();
require("main/page2.php");
    require("../lib/database.php");
Page2::header();

if(!empty($_GET['id']) && !empty($_GET['total'])) 
{
    $id =base64_decode( $_GET['id']);
    $total =base64_decode( $_GET['total']);
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
		$sql = "DELETE FROM cotizacion WHERE id_cotizacion= ?";
		$sql2 = "DELETE FROM detalle_cotizacion WHERE id_cotizacion= ?";
	    $params = array($id);
	    Database::executeRow($sql2, $params);
	    Database::executeRow($sql, $params);
	    @header("location: cotizacion.php");
	} 
	catch (Exception $error) 
	{
		print("<div class='card-panel red'><i class='material-icons left'>error</i>".$error->getMessage()."</div>");
	}
}
?>
<form method='post' class='row center-align'>
	<input type='hidden' name='id' value='<?php print($id); ?>'/>
	<?php
        $select="select * from cotizacion where id_cotizacion=?";
        $selectq="select count(*) conta from detalle_cotizacion where id_cotizacion=?";
    $paras=array($id);
    $datra=Database::getRow($select,$paras);
    $datra2=Database::getRow($selectq,$paras);
    $printo="<h4>Eliminar la cotizacion $datra[nombre], con $datra2[conta] jugos, tuvo un total de $$total</h4>
   ";
    print $printo;
    ?>
	
	<button type='submit' class='btn red'><i class='material-icons right'>done</i>Si</button>
	<a href='index.php' class='btn grey'><i class='material-icons right'>cancel</i>No</a>
</form>
<?php
Page2::footer();
?>