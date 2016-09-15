<?php 
class Database
{
    /* Se declara la funcion de conexion a la bse*/
    
    private static $connection;
    
    private static function connect()
    
    /* Datos del usuario, nombre de la base, contraseña para especificar y hacer conexion*/
        
    {
        $server='localhost';
        $database='mouyo';
        $username='neto';
        $password='123456';
        $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => "set names utf8");
        self::$connection=null;
        try
        {
            self::$connection= new PDO("mysql:host=".$server."; 
            dbname=".$database, $username, $password, $options);
           self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $exception)
        {
            die($exception->getMessage());
        }
    }
    
    private static function disconnect()
    {
        self::$connection = null;
    }
    
    /* Funcion para ejecutar una fila*/
    
    public static function executeRow($query,$values)
    {
        self::connect();
        $statement = self::$connection->prepare($query);
        $statement->execute($values);
        self::disconnect();
    }
    
    /* Funcion para ejecutar diferentes filas y consultar a la base con los valores "FetchAll"*/
    
    public static function getRows($query,$values)
    {
        self::connect();
        $statement=self::$connection->prepare($query);
        $statement->execute($values);
        return $statement->fetchAll(PDO::FETCH_BOTH);
    }
    
    /* Funcion para ejecutar una fila y consultar a la base "fetch"*/
    
    public static function getRow($query, $values)
    {
        self::connect();
        $statement = self::$connection->prepare($query);
        $statement->execute($values);
        self::disconnect();
        return $statement->fetch(PDO::FETCH_BOTH);
    }
}