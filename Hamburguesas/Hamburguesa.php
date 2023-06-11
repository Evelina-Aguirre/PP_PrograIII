<?php

include_once 'Busqueda.php';
include_once '_Json.php';

Busqueda::inicializarBusqueda();

class Hamburguesa{
    
    public $_id;
    public $_nombre;
    public $_precio;
    public $_tipo;
    public $_aderezo;
    public $_cantidad;
    
    public $_directorioImagenes = "ImagenesDeHamburguesas/2023/";
    
public function __construct($nombre="",$precio=0,$tipo="",$aderezo="",$cantidad=0)
{
     Archivos_Json::$_arrayObj=array();
    $this->_id=count(Archivos_Json::$_arrayObj)+1;
    $this->_nombre=$nombre;
    $this->_precio=$precio;
    $this->_tipo=$tipo;
    $this->_aderezo=$aderezo;
    $this->_cantidad=$cantidad;
    
}


public function Cargar($nombre,$tipo,$precio,$aderezo,$cantidad)
{
    $hamburguesas=array();
    $hamburguesas= Archivos_Json::LeerJson();
    $id=count($hamburguesas)+1;

    $existe= false;
    foreach($hamburguesas as &$hamburguesa)
    {
        if ($hamburguesa['nombre'] == $nombre && $hamburguesa['tipo'] == $tipo) {
            $hamburguesa['precio'] = $precio;
            $hamburguesa['cantidad'] += $cantidad;
            $existe = true;
            break;
        }
    }

    if(!$existe)
    {  
        $nuevaHamburguesa = array(
        'id' => $id,
        'nombre' => $nombre,
        'precio' => $precio,
        'tipo' => $tipo,
        'aderezo'=>$aderezo,
        'cantidad' => $cantidad
        );     
    array_push($hamburguesas,$nuevaHamburguesa);
}
Archivos_Json::GuardarArrayJson($hamburguesas);

}


public function GuardaImagen($nombre, $tipo)
{
    $tipoArchivo = pathinfo($_FILES["imagen"]["name"],PATHINFO_EXTENSION);
    $destino = "ImagenesDeHamburguesas/2023/".$nombre.'-'.$tipo.'.'.$tipoArchivo;
    move_uploaded_file($_FILES["imagen"]["tmp_name"],$destino);
}

}
?>