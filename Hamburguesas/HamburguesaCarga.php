<?php
include_once 'Hamburguesa.php';

$nombre = $_POST['nombre'];
$precio = $_POST['precio'];
$tipo = $_POST['tipo'];
$aderezo = $_POST['aderezo'];
$cantidad = $_POST['cantidad'];
$imagen = $_FILES['imagen'];

$tipoArchivo = pathinfo($_FILES["imagen"]["name"],PATHINFO_EXTENSION);
$destino = "ImagenesDeHamburguesas/2023/".$nombre.'-'.$tipo.'.'.$tipoArchivo;

$hamburguesa=new Hamburguesa();
$hamburguesa->Cargar($nombre,$tipo,$precio,$aderezo,$cantidad,$destino);
$hamburguesa->GuardaImagen($nombre, $tipo);
echo ' Hamburguesa cargada correctamente!';



?>