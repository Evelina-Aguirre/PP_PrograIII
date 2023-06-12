<?php

include_once 'Busqueda.php';
include_once '_Json.php';
include_once 'Venta.php';
$fecha = isset($_POST['fecha']) ? $_POST['fecha'] : date('d-m-Y', strtotime('-1 day'));

$arrayVentas = Archivos_Json::LeerJson(Venta::archivo);

$cantidad = 0;


foreach ($arrayVentas as $venta) {

    $fechaHora = $venta['fecha'];
    $parts = explode("_", $fechaHora);
    $soloFecha = $parts[0];
    
    if ($soloFecha == $fecha) {
        echo "SE VENDIO : ", $venta['fecha'];
        $cantidad += $venta['cantidadPedido'];
    }
}

echo "Cantidad de hamburguesas vendidas el $fecha: $cantidad";
