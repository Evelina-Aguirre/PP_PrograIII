<?php

class Devolucion{

    public static function inicializarDevolucion()
    {
        $instancia = new self();
    }


public static function generarDevolucion($numPedido,$causaDevolucion,$fotoClienteEnojado)
{
    $devolucion = array(
        'numPedido' => $numPedido,
        'causaDevolucion' => $causaDevolucion,
        'fotoClienteEnojado' => $fotoClienteEnojado['name'] // Guardar el nombre de la foto
    );
    return $devolucion;
}

    







}