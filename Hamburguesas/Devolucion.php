<?php
require_once "_JSON.php";
class Devolucion
{

    public static function inicializarDevolucion()
    {
        $instancia = new self();
    }


    public static function generarDevolucion($numPedido, $causaDevolucion, $fotoClienteEnojado, $cuponDescuento)
    {
        $devolucion = array(
            'numPedido' => $numPedido,
            'causaDevolucion' => $causaDevolucion,
            'fotoClienteEnojado' => $fotoClienteEnojado,
            'cuponGenerado' => $cuponDescuento
        );
        return $devolucion;
    }


    public static function GuardarDevolucion($devolucion)
    {
        $devoluciones = Archivos_Json::LeerJson('devoluciones.json');
        $devoluciones[] = $devolucion;
        Archivos_Json::GuardarArrayJson('devoluciones.json', $devoluciones);
    }

    public static function DevolucionesConCupones()
    {
        $devoluciones = Archivos_Json::LeerJson('devoluciones.json');
        $devolucionesConCupones = array();
        foreach ($devoluciones as $devolucion) {
            if (isset($devolucion['cuponGenerado'])) {
                $devolucionesConCupones[] = $devolucion;
            }
        }

        return $devolucionesConCupones;
    }


    public static function ImprimirDevolucionesConCupones()
    {
        $devolucionesConCupones = Devolucion::DevolucionesConCupones();
        echo "Devoluciones con cupones:<br>";
        foreach ($devolucionesConCupones as $devolucion) {
            echo "Devolución: " . $devolucion['numPedido'] . " - Cupón: " . $devolucion['cuponGenerado'] . "<br>";
        }
    }

   
public static function ListarDevolucionesYCupones()
{
     $devolucionesConCupones = Devolucion::DevolucionesConCupones();
     $cont=count($devolucionesConCupones);

    echo "Devoluciones y sus cupones:<br><br>";
    foreach ($devolucionesConCupones as $devolucion) {
        $cupon = Cupon::BuscarCupon(Archivos_Json::LeerJson('cupones.json'), $devolucion['cuponGenerado']);
        $cupon_usado = isset($cupon) ? $cupon['usado'] : false;

        echo "Devolución: " . $devolucion['numPedido'] . " - Cupón: " . $devolucion['cuponGenerado'] . " - Estado: " . ($cupon_usado ? "Usado" : "No usado") . "<br>";
    }
    if($cont>0)
    {
        echo "</br></br>Se encontraron ",$cont, " a las que se les brindó un cupón.</br></br>";
    }else{
        echo "No se realizaron devoluciones con cupones";
    }
}
}
