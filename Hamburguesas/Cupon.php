<?php
include_once "_JSON.php";

class Cupon
{

    public static function inicializarCupon()
    {
        $instancia = new self();
    }

    public static function GenerarCuponDescuento($porcentajeDescuento, $diasVencimiento, $usado)
    {
        $cupon = array(
            'codigo' => self::generarCodigoCupon(),
            'descuento' => $porcentajeDescuento,
            'vencimiento' => self::calcularFechaVencimiento($diasVencimiento),
            'usado' => $usado 
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
            if ($cupon['codigo'] == $codigoCupon) {
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

    public static function ModificarCupon($cuponVenta)
    {
        $cupones = Archivos_Json::LeerJson('cupones.json');
        foreach ($cupones as &$cupon) {
            if ($cupon['codigo'] == $cuponVenta['codigo']) {
                $cupon['descuento'] =  $cuponVenta['descuento'];
                $cupon['vencimiento'] =  $cuponVenta['vencimiento'];
                $cupon['usado'] =  $cuponVenta['usado'];
            }
        }
        Archivos_Json::GuardarArrayJson('cupones.json', $cupones);
    }


    public static function verificarCuponVencido($codigoCupon)
    {
        $rtn = false;
        $cupones = Archivos_Json::LeerJson('cupones.json');
        $cuponEncontrado = self::BuscarCupon($cupones, $codigoCupon);
        if ($cuponEncontrado) {
            $fechaActual = new DateTime();
            $fechaVencimiento = DateTime::createFromFormat('Y-m-d', $cuponEncontrado['vencimiento']);

            $fechaActualStr = $fechaActual->format('Y-m-d');

            if ($fechaActualStr > $fechaVencimiento->format('Y-m-d')) {
                $rtn = true;
            }
        }

        return $rtn;
    }

    public static function ImprimirCupones()
    {
        $cupones = $cupones = Archivos_Json::LeerJson('cupones.json');

        echo "Cupones y su estado:<br>";
        foreach ($cupones as $cupon) {
            echo "Cupón: " . $cupon['codigo'] . " - Estado: " . ($cupon['usado'] ? "Usado" : "No usado") . "<br>";
        }
    }
}
