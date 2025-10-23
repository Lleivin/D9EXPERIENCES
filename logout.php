<?php
session_start();
// Llamada a la conexión a la BBDD
require_once "conexion.php";
require_once "cronActualizarPartidas.php"; // Asegúrate de que el nombre y la ruta sean correctos
// Llamar a la función para actualizar el estado de las partidas
$partidasActualizadas = actualizarEstadoPartidas($conexion);

// Vaciar el array de sesión
$_SESSION = array();

// Si se desea destruir la sesión completamente, también se debe borrar la cookie de sesión.
// Nota: Esto destruirá la sesión, y no la información de la sesión.
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finalmente, destruir la sesión.
session_destroy();

// Redirigir al usuario a la página de inicio u otra página
header("Location: index.php");
exit;
?>
