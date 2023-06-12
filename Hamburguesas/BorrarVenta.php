<?php
include_once 'Venta.php';
include_once 'Busqueda.php';
include_once '_Json.php';

$numPedido = $_GET['numPedido'];

if (Busqueda::BuscarObjetoEnArray('numPedido',$numPedido,Archivos_Json::LeerJson(Venta::archivo))) {
echo "entre al if";
    $borrado=Venta::BorrarVenta($numPedido);
    
    // BACKUPVENTAS/2023
    //$nombreFoto = $venta['foto'];
    //$rutaFoto = 'BACKUPVENTAS/2023/' . $nombreFoto;
   // if (rename($nombreFoto, $rutaFoto)) {
   
      //  Venta::borrarVenta($numPedido);
        echo "La venta con número de pedido $numPedido ha sido borrada y la foto se ha movido a la carpeta /BACKUPVENTAS/2023.";
  //  } else {
      //  echo "Error al mover la foto a la carpeta /BACKUPVENTAS/2023.";
    //}
} else {
    echo "La venta con número de pedido $numPedido no existe.";
}
?>