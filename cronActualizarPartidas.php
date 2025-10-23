<?php
require_once "conexion.php"; // Llamada a la conexión a la BBDD

function actualizarEstadoPartidas($conexion) {
    // Obtener la fecha y hora actual
    $fechaActual = date('Y-m-d H:i:s');

    // Consulta para actualizar el estado de las partidas
    $queryActualizarPartidasPendientesPasadas = "
        UPDATE partidas 
        SET estadoPartida = 'Finalizada' 
        WHERE fecha < '$fechaActual' 
        AND estadoPartida = 'Pendiente'";

    
}
?>

