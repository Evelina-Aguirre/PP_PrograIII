<?php

include_once 'Busqueda.php';
include_once '_Json.php';
include_once 'Venta.php';

$fecha = isset($_POST['fecha']) ? $_POST['fecha'] : date('d-m-Y', strtotime('-1 day'));
$fechaInicio = $_POST['fechaInicio'];
$fechaFin = $_POST['fechaFin'];

$arrayVentas = Archivos_Json::LeerJson(Venta::archivo);

$cantidad = Busqueda::BuscarPorFecha($arrayVentas,$fecha);

$arrayOrdenado=Busqueda::filtrarYOrdenarVentas($arrayVentas, $fechaInicio, $fechaFin);

echo "Cantidad de hamburguesas vendidas el $fecha: $cantidad </br></br>";

foreach($arrayOrdenado as $venta)
{
    
    echo "\nID de venta: ", $venta['idVenta'],"</br>";
    echo "Número de pedido:", $venta['numPedido'],"</br>";
    echo "Fecha: ", $venta['fecha'],"</br>";
    echo "Email: ", $venta['email'],"</br>";
    echo "Nombre del cliente: ", $venta['nombreCliente'],"</br>";
    echo "Tipo de pedido: ", $venta['tipoPedido'],"</br>";
    echo "Aderezo del pedido: ", $venta['aderezoPedido'],"</br>";
    echo "Cantidad de hamburguesas vendidas: ", $venta['cantidadPedido'],"</br>";
    echo  "-----------------</br></br>";
}
