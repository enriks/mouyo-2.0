<?php
	session_start();
	require("../../lib/database.php");
    $sql2="select sesion from usuario where id_usuario=?";
    $params2=array($_SESSION['id_usuario']);
    $dat=Database::getRow($sql2,$params2);
    if($dat != null)
    {
        if($dat['sesion']==1)
        {    
        $sql="update usuario set sesion=0 where id_usuario=?";
            $params=array($_SESSION['id_admin']);
            Database::executeRow($sql,$params);
            @header("location: index.php");
        }   
    }
	session_destroy();
	header("location: ../login.php");
?>