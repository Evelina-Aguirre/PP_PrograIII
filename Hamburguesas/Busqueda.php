<?php
include_once '_Json.php';

class Busqueda
{

    public static function inicializarBusqueda()
    {
        $instancia = new self();
    }


    public static function BuscarObjetoEnArray($nombProp, $caracteristica, $array)
    {
        foreach ($array as $objebArray) {
            if (self::BuscaCaracteristica($nombProp, $caracteristica, $objebArray)) {
                return true;
            }
        }
        return false;
    }

    public static function BuscarObjetoEnArrayYCargarLista($nombProp, $caracteristica, $array)
    {
        $nuevoArray=array();
        foreach ($array as $objebArray) {
            if (self::BuscaCaracteristica($nombProp, $caracteristica, $objebArray)) {
                $nuevoArray[]=$objebArray;
            }
        }
        return $nuevoArray;
    }

    public static function BuscaCaracteristica($nombProp, $caracteristica, $obj)
    {
        foreach ($obj as $clave => $valor) {
            if (strtolower($clave) == strtolower($nombProp) && strtolower($valor) == strtolower($caracteristica)) {
                return true;
            }
        }

        return false;
    }

    public static function BuscarPorFecha($array, $fecha)
    {
        $cantidad = 0;
        foreach ($array as $venta) {

            $fechaHora = $venta['fecha'];
            $parts = explode("_", $fechaHora);
            $soloFecha = $parts[0];

            if ($soloFecha == $fecha) {
                $cantidad += $venta['cantidadPedido'];
            }
        }
        return $cantidad;
    }

    public static function filtrarPorFecha($fechaInicio, $fechaFin)
    {     
        $fechaInicio = new DateTime($fechaInicio);
        $fechaFin = new DateTime($fechaFin);

        $fechas = array();

        while ($fechaInicio <= $fechaFin) {
            $fechas[] = $fechaInicio->format('d-m-Y');
            $fechaInicio->modify('+1 day');
        }
        return $fechas;

    }

    /* public function ordenarPorNombre($venta1, $venta2)
    {
        return strcmp($venta1['nombreCliente'], $venta2['nombreCliente']);
    }*/

    public static function filtrarYOrdenarVentas($arrayVentas, $fechaInicio, $fechaFin)
    {
        $ventasEntreFechas = array();
        $arrayFechas=self::filtrarPorFecha($fechaInicio, $fechaFin);
    
        foreach ($arrayVentas as $venta) {
            $fechaHora = $venta['fecha'];
            $parts = explode("_", $fechaHora);
            $soloFecha = $parts[0];
          
            foreach($arrayFechas as $fecha)
            {
                if($soloFecha == $fecha)
                {
                    $ventasEntreFechas[]=$venta;
                }
            }
        }
       

       usort($ventasEntreFechas, function ($venta1, $venta2) {
            return strcmp($venta1['nombreCliente'], $venta2['nombreCliente']);
        });

        return $ventasEntreFechas;
    }
}
