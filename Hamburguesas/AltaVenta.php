<?php
require_once './Venta.php';
require_once 'cupon.php';
require_once '_JSON.php';
require_once 'Hamburguesa.php';

$cuponEncontrado = null;
$cupon = null;

$email = $_POST['email'];
$nombre = $_POST['nombre'];
$tipo = $_POST['tipo'];
$aderezo = $_POST['aderezo'];
$cantidad = $_POST['cantidad'];
if (isset($_POST['cupon'])) {
    $cupon = $_POST['cupon'];
    $cuponEncontrado=Cupon::BuscarCupon(Archivos_Json::LeerJson('cupones.json'),$cupon);

}

    $venta = new Venta($email,$nombre,$tipo,$aderezo,$cantidad,$cuponEncontrado);
    $venta->CargarVenta($tipo, $aderezo, $cantidad);



?>