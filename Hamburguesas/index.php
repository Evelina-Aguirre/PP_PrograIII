<?php

switch ($_SERVER['REQUEST_METHOD']) {

    case "GET":
        require_once 'ConsultarDevoluciones.php';
        
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

            case 'DevolverHamburguesa':
                require_once 'DevolverHamburguesa.php';
                break;           

            default:

                echo "La acción que se menciona no es valida";
                break;
        }
        break;
    case "PUT":
        require_once 'ModificarVenta.php';
        break;
    case "DELETE":
        require_once 'BorrarVenta.php';
        break; 
     
        default:
        echo "La acción a realizar no es válida";
}
