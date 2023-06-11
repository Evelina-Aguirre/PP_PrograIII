<?php
include_once 'Hamburguesa.php';

$nombre= $_POST['nombre'];
$tipo = $_POST['tipo'];

$arrayHamburguesas=Archivos_Json::LeerJson();

$nombreExiste=Busqueda::BuscarObjetoEnArray('nombre',$nombre,$arrayHamburguesas);
$tipoExiste=Busqueda::BuscarObjetoEnArray('tipo',$tipo,$arrayHamburguesas);

if(!$nombreExiste || !$tipoExiste)
{
    if(!$nombreExiste)
    {
      echo "</br>No se encontró el nombre: ",$nombre,"</br>";
    }
    if(!$tipoExiste)
    {
        echo "</br> No se encontró el tipo : ",$tipo,"</br>";;
    }
}else
{
  echo "Sí hay";
}






?>