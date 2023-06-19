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

        echo "Se generò un cupòn de descuento </br>";

        cupon::GuardarCupon($cuponDescuento);

        $rutaOrigen = $fotoClienteEnojado['tmp_name'];
        $rutaDestino = 'ImagenesClientesEnojados/2023' . $fotoClienteEnojado['name'];
        move_uploaded_file($rutaOrigen, $rutaDestino);
    }


    $devolucion = Devolucion::generarDevolucion($numPedido, $causaDevolucion, $nombreFotoClienteEnojado, $CodigoCuponDescuento);

    Devolucion::GuardarDevolucion($devolucion);


    echo 'Devolución registrada correctamente.';
} else {

    echo 'El número de pedido no existe.';
}
