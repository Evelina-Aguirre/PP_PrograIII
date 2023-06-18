<?php
include_once 'Venta.php';
include_once 'Busqueda.php';
include_once '_Json.php';
include_once 'Cupon.php';
include_once 'Devolucion.php';
Cupon::inicializarCupon();

$fotoClienteEnojado = null;
$nombreFotoClienteEnojado = null;
$CodigoCuponDescuento = null;

$numPedido = $_POST['numPedido'];
$causaDevolucion = $_POST['causaDevolucion'];

if (Busqueda::BuscarObjetoEnArray('numPedido', $numPedido, Archivos_Json::LeerJson(Venta::archivo))) {
   
    if (isset($_FILES['fotoClienteEnojado'])) {
        $fotoClienteEnojado = $_FILES['fotoClienteEnojado'];
        $nombreFotoClienteEnojado = $fotoClienteEnojado['name'];

        $cuponDescuento = Cupon::GenerarCuponDescuento(0.1, 3, false);
        $CodigoCuponDescuento = $cuponDescuento['codigo'];

        cupon::GuardarCupon($cuponDescuento);
        /*$cupones = Archivos_Json::LeerJson('cupones.json');
        $cupones[] = $cuponDescuento;
        Archivos_Json::GuardarArrayJson('cupones.json', $cupones);*/

        $rutaOrigen = $fotoClienteEnojado['tmp_name'];
        $rutaDestino = 'ImagenesClientesEnojados/2023' . $fotoClienteEnojado['name'];
        move_uploaded_file($rutaOrigen, $rutaDestino);
    }


    $devolucion = Devolucion::generarDevolucion($numPedido, $causaDevolucion, $nombreFotoClienteEnojado, $CodigoCuponDescuento);

    $devoluciones = Archivos_Json::LeerJson('devoluciones.json');
    $devoluciones[] = $devolucion;
    Archivos_Json::GuardarArrayJson('devoluciones.json', $devoluciones);


    echo 'Devolución registrada correctamente. Se generó un cupón de descuento para la próxima compra.';
} else {

    echo 'El número de pedido no existe.';
}
