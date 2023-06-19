<?php

include_once 'Busqueda.php';
include_once '_Json.php';
include_once 'Venta.php';

$arrayVentas = Archivos_Json::LeerJson(Venta::archivo);


$fecha = isset($_POST['fecha']) ? $_POST['fecha'] : date('Y-m-d', strtotime('-1 day'));
$cantidad = Busqueda::BuscarPorFecha($arrayVentas,$fecha);
echo "Cantidad de hamburguesas vendidas el $fecha: $cantidad </br>";

if (isset($_POST['fechaInicio']) && isset($_POST['fechaFin']))
{
    $fechaInicio = $_POST['fechaInicio'];
    $fechaFin = $_POST['fechaFin'];
    echo "</BR>VENTAS REALIZADAS ENTRE LAS FECHAS ",$fechaInicio," y ",$fechaFin,":</BR></br>";
    $arrayOrdenado=Busqueda::filtrarYOrdenarVentas($arrayVentas, $fechaInicio, $fechaFin);
    Venta::ImprimirVenta($arrayOrdenado);
}

if (isset($_POST['usuario']))
{
    $usuario = $_POST['usuario'];
    echo "</BR></BR>COMPRAS DEL USUARIO --> ",$usuario,":</BR></BR>";
    $arrayPedidosDeUnUsuario=Busqueda::BuscarObjetoEnArrayYCargarLista('nombreCliente',$usuario,$arrayVentas);
    Venta::ImprimirVenta($arrayPedidosDeUnUsuario);
}

if (isset($_POST['tipo']))
{
    $tipo = $_POST['tipo'];
    echo "</BR></BR>COMPRAS DEL TIPO --> ",$tipo,":</BR></BR>";
    $arrayPorTipo=Busqueda::BuscarObjetoEnArrayYCargarLista('tipoPedido',$tipo,$arrayVentas);
    Venta::ImprimirVenta($arrayPorTipo);

}

echo "</BR></BR>COMPRAS ADEREZO --> KETCHUP:</BR></BR>";
$arrayPorAderezo=Busqueda::BuscarObjetoEnArrayYCargarLista('aderezoPedido','ketchup',$arrayVentas);
Venta::ImprimirVenta($arrayPorAderezo);
