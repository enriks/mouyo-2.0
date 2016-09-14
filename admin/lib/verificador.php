<?php 
class verificador
{
    public static function permiso1($permisos)
    {
        if(isset($permisos)!=1)
        {
            header("location: ../main/denied.php");
        }
    }
    public static function permiso2($permisos)
    {
        if(isset($permisos)!=2)
        {
            header("location: ../main/denied.php");
        }
    }
    public static function permiso3($permisos)
    {
        if(isset($permisos)!=3)
        {
            header("location: ../main/denied.php");
        }
    }
    public static function permiso4($permisos)
    {
        if(isset($permisos)!=4)
        {
            header("location: ../main/denied.php");
        }
    }
}
