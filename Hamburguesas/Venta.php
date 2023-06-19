<?php
include_once 'Busqueda.php';
include_once '_Json.php';
include_once 'Hamburguesa.php';
include_once 'cupon.php';
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
    public $_ubicacionImagen;
    public $_totalVenta;
    public $_cupon;

    const archivo = "Ventas.Json";

    public function __construct($email = '', $nombreCliente = '', $tipoPedido = '', $aderezoPedido = '', $cantidPedido = 0, $cupon = [])
    {
        $this->_idVenta = $this->ObtenerUltimoElemento() + 1;
        $this->_numPedido = $this->_idVenta + 100;
        $this->_fecha = date('Y-m-d_H-i-s');
        $this->_email = $email;
        $this->_nombreCliente = $nombreCliente;
        $this->_tipoPedido = $tipoPedido;
        $this->_aderezoPedido = $aderezoPedido;
        $this->_cantidadPedido = $cantidPedido;
        $this->_cupon = $cupon;
    }

    public function ObtenerUltimoElemento()
    {
        $array = Archivos_Json::LeerJson(Venta::archivo);
        $ultimoElemento = end($array);
        return $ultimoElemento['idVenta'];
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
                    $this->_totalVenta = ($hamburguesa['precio'] * $cantidadPedido);
                    $this->_totalVenta = $this->CalcularPrecioConCupon();
                    $rutaImagen = $hamburguesa['imagen'];
                }
            }
        }

        if ($hay) {

            $destino = $this->GuardaImagen($tipoPedido, $this->_email, $this->_fecha, $rutaImagen);
            $nuevaVenta = $this->toArray($destino);
            array_push($arrayVentas, $nuevaVenta);
            Archivos_Json::GuardarArrayJson(Hamburguesa::archivo, $listaHamburguesas);
            echo "Se realizó la venta con exito";
        } else {
            echo "No hay stock suficiente para realizar la venta";
        }
        Archivos_Json::GuardarArrayJson(Venta::archivo, $arrayVentas);
    }


    public function toArray($ubicacionImagen)
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
            'ubicacionImagen' => $ubicacionImagen,
            'cupon' => $this->_cupon,
            'precioTotal' => $this->_totalVenta
        ];
    }

    public function GuardaImagen($tipoPedido, $email, $fecha, $rutaImagen)
    {
        $usuario = explode('@', $email)[0];
        $tipoArchivo = pathinfo($rutaImagen, PATHINFO_EXTENSION);
        $destino = "ImagenesDeHamburguesas/2023/VentasRealizadas/" . $tipoPedido . '-' . $usuario . '-' . $fecha . '.' . $tipoArchivo;
        copy($rutaImagen, $destino);
        return $destino;
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
            if ($venta['cupon'] != null) {
                echo "Cupón: ", $venta['cupon'], "</br>";
            }
            echo  "-----------------</br></br>";
        }
    }

    public static function ModificarVenta($numPedido, $email, $nombre, $tipo, $aderezo, $cantidad)
    {
        $arrayVentas = Archivos_Json::LeerJson(Venta::archivo);
        foreach ($arrayVentas as &$venta) {
            if ($venta['numPedido'] == $numPedido) {

                $venta['email'] = $email;
                $venta['nombreCliente'] = $nombre;
                $venta['tipoPedido'] = $tipo;
                $venta['aderezoPedido'] = $aderezo;
                $venta['cantidadPedido'] = $cantidad;

                break;
            }
        }
        Archivos_Json::GuardarArrayJson(Venta::archivo, $arrayVentas);
    }

    public function ModificarCuponVenta($cupon)
    {
        $this->_cupon = $cupon;
    }

    public static function BorrarVenta($numPedido)
    {
        $arrayAux = Archivos_Json::LeerJson(Venta::archivo);
        $indice = Busqueda::ObtenerIndice('numPedido', $numPedido, $arrayAux);
        if ($indice != null) {
            unset($arrayAux[$indice]);
            Archivos_Json::GuardarArrayJson(Venta::archivo, $arrayAux);
            return true;
        }
        return false;
    }

    public function CalcularPrecioConCupon()
    {
        if ($this->_cupon != null) {
            
            if (!$this->_cupon['usado'] && !Cupon::verificarCuponVencido($this->_cupon['codigo'])) {

                $this->_totalVenta -= $this->_totalVenta * $this->_cupon['descuento'];
                $cupon = Cupon::BuscarCupon(Archivos_Json::LeerJson('cupones.json'), $this->_cupon['codigo']);
                $cupon['usado'] = true;
                cupon::ModificarCupon($cupon);

            } else if (Cupon::verificarCuponVencido($this->_cupon['codigo'])) {

                echo '</br> Aviso ! El cupón ', $this->_cupon['codigo'], ' expiró el : ', $this->_cupon['vencimiento'], ' No se aplicará el descuento</br></br>';
            } else {

                echo '</br> Aviso ! El cupón ',  $this->_cupon['codigo'], ' ya fue utilizado. No se aplicará el descuento.</br> </br>';
            }
        }
    }
}
