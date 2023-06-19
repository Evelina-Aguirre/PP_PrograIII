<?php
require_once 'Devolucion.php';
require_once 'Cupon.php';


if (isset($_GET['consulta'])) {
    
    $consulta = $_GET['consulta'];

    if ($consulta === 'devolucionesConCupones') {
        
        Devolucion::ImprimirDevolucionesConCupones();
        echo "<br>";

    } elseif ($consulta === 'cupones') {
        
        Cupon::ImprimirCupones();
        echo "<br>";

    } elseif ($consulta === 'devolucionesYCupones') {
        
        Devolucion::ListarDevolucionesYCupones();
        echo "<br>";

    } else {
        echo "Consulta no válida.";
    }
} else {
    echo "Parámetro 'consulta' no especificado.";
}

