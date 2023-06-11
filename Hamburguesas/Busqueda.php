<?php
include_once '_Json.php';

class Busqueda
{

    public static function inicializarBusqueda()
    {
        $instancia = new self();
    }


    //informa si un objeto con determinada característica en un array
    public static function BuscarObjetoEnArray($nombProp, $caracteristica, $array)
    {
        foreach ($array as $objebArray) {
            if (self::BuscaCaracteristica($nombProp, $caracteristica, $objebArray)) {
                return true;
            }
        }
        return false;
    }
    //informa si existe o no una carac. en un objeto particular
    public static function BuscaCaracteristica($nombProp, $caracteristica, $obj)
    {
        foreach ($obj as $clave => $valor) {

            if (strtolower($clave) == strtolower($nombProp)) {

                if ($valor == $caracteristica) {
                    return true;
                }
            }
        }

        return false;
    }


    //////////////////////////////////NO USO///////////////////////////////////////////////////////////////////////////////////////////////////

    //si los objetos son iguales de acuerdo a dos carácterísticas, actualiza en precio (true/false)
    public static function ActualizarPrecio($nombProp1, $caract1, $nombProp2, $caract2, $precioNuevo)
    {
        $indiceEncontrado = null;
        if (self::InformaIndiceObjeto($nombProp1, $caract1, $nombProp2, $caract2) != null) {
            $indiceEncontrado = self::InformaIndiceObjeto($nombProp1, $caract1, $nombProp2, $caract2);
            Archivos_Json::$_arrayObj[$indiceEncontrado]->_precio = $precioNuevo; //falta guardar********************
            return true;
        }
        return false;
    }

    //si los objetos son iguales deacuerdo a dos carácterísticas, suma la cantidad (true/false)
    public static function ActualizarCantidad($nombProp1, $caract1, $nombProp2, $caract2, $cantidad)
    {
        $indiceEncontrado = null;
        if (self::InformaIndiceObjeto($nombProp1, $caract1, $nombProp2, $caract2) != null) {
            $indiceEncontrado = self::InformaIndiceObjeto($nombProp1, $caract1, $nombProp2, $caract2);
            Archivos_Json::$_arrayObj[$indiceEncontrado]->_cantidad += $cantidad; //****************************guardar  */
            return true;
        }
        return false;
    }

    //Retorna el INDICE del objeto encontrado si se encontró ser igual que otro
    public static function InformaIndiceObjeto($nombProp1, $caract1, $nombProp2, $caract2)
    {
        foreach (Archivos_Json::$_arrayObj as $indice => $obj) {
            if (self::Equals($nombProp1, $caract1, $nombProp2, $caract2)) {
                return $indice;
            }
        }
        return Null;
    }
}
