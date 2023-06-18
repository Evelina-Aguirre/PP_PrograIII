<?php

class Devolucion{

    public static function inicializarDevolucion()
    {
        $instancia = new self();
    }


public static function generarDevolucion($numPedido,$causaDevolucion,$fotoClienteEnojado,$cuponDescuento)
{
    $devolucion = array(
        'numPedido' => $numPedido,
        'causaDevolucion' => $causaDevolucion,
        'fotoClienteEnojado' => $fotoClienteEnojado,
        'cuponGenerado'=>$cuponDescuento
    );
    return $devolucion;
}


public static function GuardarDevolucion($devolucion){
    $devoluciones = Archivos_Json::LeerJson('devoluciones.json');
    $devoluciones[] = $devolucion;
    Archivos_Json::GuardarArrayJson('devoluciones.json', $devoluciones);
}

    







}