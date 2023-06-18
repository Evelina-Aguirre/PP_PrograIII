<?php

class Cupon
{


    public static function inicializarCupon()
    {
        $instancia = new self();
    }

    public static function GenerarCuponDescuento($porcentajeDescuento, $diasVencimiento, $estado)
    {
        $cupon = array(
            'codigo' => self::generarCodigoCupon(),
            'descuento' => $porcentajeDescuento,
            'vencimiento' => self::calcularFechaVencimiento($diasVencimiento),
            'usado' => $estado //true , false
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

    public static function BuscarCupon($jsonCupones, $codigoCupon)
    {
        $cuponEncontrado = null;
        $cupones = $jsonCupones;

        foreach ($cupones as $cupon) {
            if ($cupon['codigo'] === $codigoCupon) {
                $cuponEncontrado = $cupon;
                break;
            }
        }
        return $cuponEncontrado;
    }

    public static function GuardarCupon($cuponDescuento)
    {
        $cupones = Archivos_Json::LeerJson('cupones.json');
        $cupones[] = $cuponDescuento;
        Archivos_Json::GuardarArrayJson('cupones.json', $cupones);
    }
}
