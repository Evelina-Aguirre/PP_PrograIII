<?php

switch ($_SERVER['REQUEST_METHOD']) {

    case "GET":

        break;
    case "POST":
        $accion = $_POST['accion'];
        switch ($accion) {
            case 'HamburguesaCarga':

                require_once 'HamburguesaCarga.php';
                break;

            case 'HamburguesaConsultar':

                require_once 'HamburguesaConsultar.php';
                break;
            case 'AltaVenta':

                require_once 'AltaVenta.php';
                break;

            case 'ConsultasVentas':
                require_once 'ConsultasVentas.php';
                break;

            default:

                echo "La acción que se menciona no es valida";
                break;
        }
        break;
        case "PUT":
            require_once 'ModificarVenta.php';
                break;
}
