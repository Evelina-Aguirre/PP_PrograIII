<?php
include_once '_Json.php';

class Busqueda
{

    public static function inicializarBusqueda()
    {
        $instancia = new self();
    }


    //Informa si el array posee algún objeto con la característica buscada
    public static function BuscarObjetoEnArray($nombProp, $caracteristica, $array)
    {
        foreach ($array as $objebArray) {
            if (self::BuscaCaracteristica($nombProp, $caracteristica, $objebArray)) {
                return true;
            }
        }
        return false;
    }
    //informa si existe o no una carac. en un objeto 
    public static function BuscaCaracteristica($nombProp, $caracteristica, $obj)
    {
        foreach ($obj as $clave => $valor) {
            if (strtolower($clave) == strtolower($nombProp) && strtolower($valor) == strtolower($caracteristica)) {
                    return true;
            }
        }

        return false;
    }


}