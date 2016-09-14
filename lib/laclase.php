<?php 
class Laclase
{
    public static function descuento($descuento, $precio)
    {
        $descuento_porcent=$descuento / 100;
        $descuento_total=($descuento_porcento * $precio) - $precio;
        return $descuento_total;
    }
}