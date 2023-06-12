<?php
include_once 'Busqueda.php';
include_once '_Json.php';
include_once 'Hamburguesa.php';
class Venta
{

    public $_idVenta;
    public $_numPedido;
    public $_fecha;
    public $_email;
    public $_nombreCliente;
    public $_tipoPedido;
    public $_aderezoPedido;
    public $_cantidadPedido;

    const archivo = "Ventas.Json";

    public function __construct($email = '', $nombreCliente = '', $tipoPedido = '', $aderezoPedido = '', $cantidPedido = 0)
    {
        $this->_idVenta = count(Archivos_Json::LeerJson(Venta::archivo)) + 1;
        $this->_numPedido = $this->_idVenta + 100;
        $this->_fecha = date('Y-m-d_H-i-s');
        $this->_email = $email;
        $this->_nombreCliente = $nombreCliente;
        $this->_tipoPedido = $tipoPedido;
        $this->_aderezoPedido = $aderezoPedido;
        $this->_cantidadPedido = $cantidPedido;
    }

    public function CargarVenta($tipoPedido, $aderezoPedido, $cantidadPedido)
    {
        $listaHamburguesas = array();
        $listaHamburguesas = Archivos_Json::LeerJson(Hamburguesa::archivo);
        $arrayVentas = Archivos_Json::LeerJson(Venta::archivo);
        $rutaImagen = "";

        $hay = false;
        foreach ($listaHamburguesas as &$hamburguesa) {
            if (
                Busqueda::BuscaCaracteristica('tipo', $tipoPedido, $hamburguesa) &&
                Busqueda::BuscaCaracteristica('aderezo', $aderezoPedido, $hamburguesa)
            ) {
                if ($hamburguesa['cantidad'] > 0 && $cantidadPedido <= $hamburguesa['cantidad']) {
                    $hay = true;
                    $hamburguesa['cantidad'] -= $cantidadPedido;
                    $rutaImagen = $hamburguesa['imagen'];
                }
            }
        }

        if ($hay) {

            $nuevaVenta = $this->toArray();
            array_push($arrayVentas, $nuevaVenta);
            $this->GuardaImagen($tipoPedido, $this->_email, $this->_fecha, $rutaImagen);
            Archivos_Json::GuardarArrayJson(Hamburguesa::archivo, $listaHamburguesas);
            echo "Se realizó la venta con exito";
        } else {
            echo "No hay stock suficiente para realizar la venta";
        }
        Archivos_Json::GuardarArrayJson(Venta::archivo, $arrayVentas);
    }


    public function toArray()
    {
        return [
            'idVenta' => $this->_idVenta,
            'numPedido' => $this->_numPedido,
            'fecha' => $this->_fecha,
            'email' => $this->_email,
            'nombreCliente' => $this->_nombreCliente,
            'tipoPedido' => $this->_tipoPedido,
            'aderezoPedido' => $this->_aderezoPedido,
            'cantidadPedido' => $this->_cantidadPedido,
        ];
    }

    public function GuardaImagen($tipoPedido, $email, $fecha, $rutaImagen)
    {
        $usuario = explode('@', $email)[0];
        echo $usuario;
        $tipoArchivo = pathinfo($rutaImagen, PATHINFO_EXTENSION);
        $destino = "ImagenesDeHamburguesas/2023/VentasRealizadas/" . $tipoPedido . '-' . $usuario . '-' . $fecha . '.' . $tipoArchivo;
        copy($rutaImagen, $destino);
    }

    public static function ImprimirVenta($array)
    {
        foreach ($array as $venta) {
            echo "\nID de venta: ", $venta['idVenta'], "</br>";
            echo "Número de pedido:", $venta['numPedido'], "</br>";
            echo "Fecha: ", $venta['fecha'], "</br>";
            echo "Email: ", $venta['email'], "</br>";
            echo "Nombre del cliente: ", $venta['nombreCliente'], "</br>";
            echo "Tipo de pedido: ", $venta['tipoPedido'], "</br>";
            echo "Aderezo del pedido: ", $venta['aderezoPedido'], "</br>";
            echo "Cantidad de hamburguesas vendidas: ", $venta['cantidadPedido'], "</br>";
            echo  "-----------------</br></br>";
        }
    }
}
