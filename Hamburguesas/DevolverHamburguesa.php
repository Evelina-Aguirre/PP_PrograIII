<?php
include_once 'Venta.php';
include_once 'Busqueda.php';
include_once '_Json.php';
include_once 'Cupon.php';
Cupon::inicializarCupon();

$numPedido = $_POST['numPedido'];
$causaDevolucion = $_POST['causaDevolucion'];
$fotoClienteEnojado = $_FILES['fotoClienteEnojado'];


if (Busqueda::BuscarObjetoEnArray('numPedido', $numPedido, Archivos_Json::LeerJson(Venta::archivo))) {
   
    $cuponDescuento = Cupon::GenerarCuponDescuento(0.1, 3);
    $devolucion = array(
        'numPedido' => $numPedido,
        'causaDevolucion' => $causaDevolucion,
        'fotoClienteEnojado' => $fotoClienteEnojado['name'] // Guardar el nombre de la foto
    );

    $devoluciones = Archivos_Json::LeerJson('devoluciones.json');
    $devoluciones[] = $devolucion;
    Archivos_Json::GuardarArrayJson('devoluciones.json', $devoluciones);


    $cupones = Archivos_Json::LeerJson('cupones.json');
    $cupones[] = $cuponDescuento;
    Archivos_Json::GuardarArrayJson('cupones.json', $cupones);

    $rutaOrigen = $fotoClienteEnojado['tmp_name'];
    $rutaDestino = 'ImagenesClientesEnojados/2023' . $fotoClienteEnojado['name'];
    move_uploaded_file($rutaOrigen, $rutaDestino);

    echo 'Devolución registrada correctamente. Se generó un cupón de descuento para la próxima compra.';
} else {
    echo 'El número de pedido no existe.';
}
?>