<?php

class Cupon{


    public static function inicializarCupon()
    {
        $instancia = new self();
    }

    public static function GenerarCuponDescuento($porcentajeDescuento, $diasVencimiento)
    {
        $cupon = array(
            'codigo' => self::generarCodigoCupon(),
            'descuento' => $porcentajeDescuento,
            'vencimiento' => self::calcularFechaVencimiento($diasVencimiento)
        );
    
        return $cupon;
    }
    
    public static function generarCodigoCupon() 
    {
        $codigo = uniqid();
        return $codigo;
    }
    
    public static function calcularFechaVencimiento($diasVencimiento) 
    {
        $fechaActual = new DateTime();
        $fechaActual->add(new DateInterval('P' . $diasVencimiento . 'D'));
        $fechaVencimiento = $fechaActual->format('Y-m-d');
    
        return $fechaVencimiento;
    }

























}






?>