<?php
require_once './Venta.php';

$email = $_POST['email'];
$nombre = $_POST['nombre'];
$tipo = $_POST['tipo'];
$aderezo = $_POST['aderezo'];
$cantidad = $_POST['cantidad'];


$venta = new Venta($email,$nombre,$tipo,$aderezo,$cantidad);
$venta->CargarVenta($tipo, $aderezo, $cantidad);






?>