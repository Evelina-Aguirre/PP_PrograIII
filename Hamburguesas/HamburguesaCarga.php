<?php
include_once 'Hamburguesa.php';

$nombre = $_POST['nombre'];
$precio = $_POST['precio'];
$tipo = $_POST['tipo'];
$aderezo = $_POST['aderezo'];
$cantidad = $_POST['cantidad'];
$imagen = $_FILES['imagen'];

'./Hamburguesas/ImagenesDeHasmburguesas/2023';

$hamburguesa=new Hamburguesa();
$hamburguesa->Cargar($nombre,$tipo,$precio,$aderezo,$cantidad);
$hamburguesa->GuardaImagen($nombre, $tipo);
echo 'Hamburguesa cargada correctamente';



?>