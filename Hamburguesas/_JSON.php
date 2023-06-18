<?php
class Archivos_Json{

    public static function LeerJson($archivo) {
        if (!file_exists($archivo)) {
            file_put_contents($archivo, json_encode([]));
        }

        $contenido = file_get_contents($archivo);
        $array = json_decode($contenido, true);
        $array = $array ? $array : array();
        return $array;
    }
    
    public static function GuardarArrayJson($archivo, $array) {
        $contenido = json_encode($array, JSON_PRETTY_PRINT);
        file_put_contents($archivo, $contenido);
    }

    

}

?>