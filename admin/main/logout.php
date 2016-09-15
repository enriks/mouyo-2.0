<?php
	session_start();
require("../../lib/database.php");
    $sql2="select sesion from admin where id_admin=?";
    $params2=array($_SESSION['id_admin']);
    $dat=Database::getRow($sql2,$params2);
    if($dat != null)
    {
        if($dat['sesion']==1)
        {    
        $sql="update admin set sesion=0 where id_admin=?";
            $params=array($_SESSION['id_admin']);
            Database::executeRow($sql,$params);
            @header("location: index.php");
        }   
    }
	session_destroy();
	header("location: ../main/login.php");
?>