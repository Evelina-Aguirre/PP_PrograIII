<?php
include_once 'Busqueda.php';
include_once '_Json.php';
include_once 'Venta.php';

$data = json_decode(file_get_contents("php://input"), true);

$numPedido = $data['numPedido'];
$email = $data['email'];
$nombre = $data['nombre'];
$tipo = $data['tipo'];
$aderezo = $data['aderezo'];
$cantidad = $data['cantidad'];


if (Busqueda::BuscarObjetoEnArray('numPedido',$numPedido,Archivos_Json::LeerJson(Venta::archivo))) {

    Venta::modificarVenta($numPedido, $email, $nombre, $tipo, $aderezo, $cantidad);
    
 echo "La venta con número de pedido $numPedido ha sido modificada correctamente.";
} else {

    echo "La venta con número de pedido $numPedido no existe.";
}

?>