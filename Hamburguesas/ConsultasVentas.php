<?php

include_once 'Busqueda.php';
include_once '_Json.php';
include_once 'Venta.php';

$fecha = isset($_POST['fecha']) ? $_POST['fecha'] : date('d-m-Y', strtotime('-1 day'));
$fechaInicio = $_POST['fechaInicio'];
$fechaFin = $_POST['fechaFin'];
$usuario = $_POST['usuario'];
$tipo = $_POST['tipo'];

$arrayVentas = Archivos_Json::LeerJson(Venta::archivo);

$cantidad = Busqueda::BuscarPorFecha($arrayVentas,$fecha);

$arrayOrdenado=Busqueda::filtrarYOrdenarVentas($arrayVentas, $fechaInicio, $fechaFin);

echo "Cantidad de hamburguesas vendidas el $fecha: $cantidad </br></br>";
echo "</BR>VENTAS REALIZADAS ENTRE LAS FECHAS ",$fechaInicio," y ",$fechaFin,":</BR></br>";
Venta::ImprimirVenta($arrayOrdenado);

echo "</BR></BR>COMPRAS DEL USUARIO --> ",$usuario,":</BR></BR>";
$arrayPedidosDeUnUsuario=Busqueda::BuscarObjetoEnArrayYCargarLista('nombreCliente',$usuario,$arrayVentas);
Venta::ImprimirVenta($arrayPedidosDeUnUsuario);

echo "</BR></BR>COMPRAS DEL TIPO --> ",$tipo,":</BR></BR>";
$arrayPorTipo=Busqueda::BuscarObjetoEnArrayYCargarLista('tipoPedido',$tipo,$arrayVentas);
Venta::ImprimirVenta($arrayPorTipo);

echo "</BR></BR>COMPRAS ADEREZO --> KETCHUP:</BR></BR>";
$arrayPorAderezo=Busqueda::BuscarObjetoEnArrayYCargarLista('aderezoPedido','ketchup',$arrayVentas);
Venta::ImprimirVenta($arrayPorAderezo);
