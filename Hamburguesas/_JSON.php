<?php
class Archivos_Json{

    //public static $_arrayObj;

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
        //self::$_arrayObj = $contenido;
    }

    /*public static function GuardarArrayJson($array) {
        self::LeerJson();
        $contenidoArray = self::$_arrayObj;

        if ($contenidoArray === null) {
            $contenidoArray = [];
        }

        $contenidoArray = array_merge($contenidoArray, $array);

        $contenidoFinal = json_encode($contenidoArray, JSON_PRETTY_PRINT);
        file_put_contents(self::$_archivo, $contenidoFinal);
        self::$_arrayObj = $contenidoArray;
    }*/
   /* public static function inicializarArrayObj(){
        if (!file_exists(self::$_archivo)) {
            file_put_contents(self::$_archivo, json_encode([]));
        }

        $contenido = file_get_contents(self::$_archivo);
        self::$_arrayObj = json_decode($contenido, true);

        if (self::$_arrayObj === null) {
            self::$_arrayObj = [];
        }
    }

    public static function LeerJson() {
        $contenido = file_get_contents(self::$_archivo);
        self::$_arrayObj = json_decode($contenido, true);
        return self::$_arrayObj ? self::$_arrayObj : array();
    }

    public static function GuardarArrayJson($array) {
        $contenido = json_encode($array, JSON_PRETTY_PRINT);
        file_put_contents(self::$_archivo, $contenido);
    }*/
 

}

?>