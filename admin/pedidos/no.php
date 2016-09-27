<?php
ob_start();
require("../../lib/database.php");
require("../../lib/validator.php");
require("../lib/page.php");
$fecha=date('Y-m-d H:i:s');
if(empty($_GET['id'])) 
{
    @header("location:index.php");
}
else
{
    $id = base64_decode($_GET['id']);
    $sql="update cotizacion set pedido=3 where id_cotizacion=?";
    $params=array($id);
    Database::executeRow($sql,$params);
    @header("location:index.php");
}
?>