

<!-- FUNCIONES -->
// FUNCION PARA  ELIMINAR JUGADOR DESDE ADMIN

function admineliminarjugadorSelec($conexion) {
    $dni = mysqli_real_escape_string($conexion, $_POST['dni']);

    // Consultar y eliminar en la tabla jugadores
    $queryJugadores = "SELECT * FROM jugadores WHERE dniJugador = '$dni'";
    $resultadoJugadores = mysqli_query($conexion, $queryJugadores);
    $jugador = mysqli_fetch_assoc($resultadoJugadores);

    if ($jugador) {
        $deleteQuery = "DELETE FROM jugadores WHERE dniJugador = '$dni'";
        if (mysqli_query($conexion, $deleteQuery)) {
            echo json_encode(array('mensajeError' => false, 'mensaje' => 'Jugador eliminado por admin correctamente.'));
        } else {
            echo json_encode(array('mensajeError' => true, 'mensaje' => 'Error al eliminar al jugador.'));
        }
    } else {
        echo json_encode(array('mensajeError' => true, 'mensaje' => 'Jugador no encontrado.'));
    }
}


<!-- ADMINISTRACION -->
// Eliminar Jugador como admin
      document.querySelectorAll('.adminEliminarJugadorSelec').forEach(function(button) {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            var dni = this.getAttribute('data-dni'); // Obtener el DNI del atributo data-dni
            if (dni) {
                console.log('Intentando eliminar por admin jugador con DNI:', dni);
                admineliminarjugador(dni);
            } else {
                console.log('El campo dni no tiene valor.');
            }
        });
      });