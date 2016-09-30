<?php ob_start();
require("../lib/database.php");
$id=base64_decode($_GET['id']);
$total=base64_decode($_GET['total']);
if(empty($id) || empty($total))
{
    @header("location:");
}
else
{
    $sql="update cotizacion set total =?,pedido=1 where id_cotizacion=?";
    $params=array($total,$id);
    Database::executeRow($sql,$params);
    @header("location:cotizacion.php");
}
?>