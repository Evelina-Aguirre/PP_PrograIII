<?php
include_once 'Venta.php';
include_once 'Busqueda.php';
include_once '_Json.php';

$numPedido = $_GET['numPedido'];


$arrayaux = Archivos_Json::LeerJson(Venta::archivo);

if (Busqueda::BuscarObjetoEnArray('numPedido', $numPedido, $arrayaux)) {

    $indiceVentaABorrar = Busqueda::ObtenerIndice('numPedido', $numPedido, $arrayaux);
    $rutaOrigen = $arrayaux[$indiceVentaABorrar]['ubicacionImagen'];

    $rutaDestino = str_replace("ImagenesDeHamburguesas/2023/VentasRealizadas/", "BACKUPVENTAS/2023/", $rutaOrigen);

    if (copy($rutaOrigen, $rutaDestino)) {

        $borrado = Venta::BorrarVenta($numPedido);

        if ($borrado) {
            echo "La venta $numPedido ha sido borrada y la foto se ha movido a la carpeta /BACKUPVENTAS/2023.";
        } else {
            echo "No se encontró el Número de Pedido $numPedido";
        }

    } else {
        echo "Error al mover la foto a la carpeta /BACKUPVENTAS/2023.";
    }
}else
{
    echo "No se encontró el Número de Pedido $numPedido";
}
