<?php
// $conexion = mysqli_connect("localhost", "root", "", "prueba_ajax");
// /* Para seleccionar la BASE DATOS*/
// mysqli_select_db($conexion, "prueba_ajax") or die("No se puede seleccionar la BD");


// --------------------------------- ------------------------- ---------------------
// --------------------------------- CONEXION A LA BASE DE DATOS ---------------------
// --------------------------------- ------------------------- ---------------------

// Conectar a la base de datos
     $servername = "localhost";
     $username = "root";
     $password = "";
     $dbname = "nuevo_d9";
     $conexion = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conexion->connect_error) {
    die("Connection failed: " . $conexion->connect_error);
}



// --------------------------------- ------------------------- ---------------------
// --------------------------------- FUNCIONES PARA EXTRAER DATOS [SELECT]  ---------------------
// --------------------------------- ------------------------- ---------------------

// FUNCIÓN PARA OBTENER UN EMAIL YA REGISTRADO EN LA NEWSLETTER
function emailExisteEnNewsletter($conexion, $email) {
    $email = mysqli_real_escape_string($conexion, $email);
    $query = "SELECT * FROM newsletter WHERE email = '$email'";
    $resultado = mysqli_query($conexion, $query);

    return mysqli_num_rows($resultado) > 0;
}


//FUNCION PARA OBTENER DATOS DEL JUGADOR POR DNI
function obtenerJugadorPorDNI($conexion, $dni) {
    $dni = mysqli_real_escape_string($conexion, $dni);
    $query = "SELECT * FROM jugadores WHERE dniJugador = '$dni'";
    $resultado = mysqli_query($conexion, $query);

    if ($resultado) {
        return mysqli_fetch_assoc($resultado);
    } else {
        return null;
    }
}

// FUNCION PARA OBTENER DATOS DEL JUGADOR POR EMAIL
function obtenerJugadorPorEmail($conexion, $email) {
    $email = mysqli_real_escape_string($conexion, $email);
    $query = "SELECT * FROM jugadores WHERE email = '$email'";
    $resultado = mysqli_query($conexion, $query);

    if ($resultado && mysqli_num_rows($resultado) > 0) {
        return mysqli_fetch_assoc($resultado);
    }

    return null; // Retornar null si no existe o hubo error
}


// FUNCION PARA OBTENER DATOS DEL ADMIN POR EMAIL
function obtenerAdminPorEmail($conexion, $email) {
    $email = mysqli_real_escape_string($conexion, $email);
    $query = "SELECT * FROM administrador WHERE emailAdmin = '$email'";
    $resultado = mysqli_query($conexion, $query);

    if ($resultado && mysqli_num_rows($resultado) > 0) {
        return mysqli_fetch_assoc($resultado);
    }

    return null; // No se encontró o error
}


//FUNCION PARA OBTENER DATOS DEL ADMIN
function obtenerAdministradorPorDNI($conexion, $dni) {
    $dni = mysqli_real_escape_string($conexion, $dni);
    $query = "SELECT * FROM administrador WHERE dniAdmin = '$dni'";
    $resultado = mysqli_query($conexion, $query);

    if ($resultado) {
        return mysqli_fetch_assoc($resultado);
    } else {
        return null;
    }
}

// FUNCION PARA OBTENER LA RESERVA POR ID
function obtenerReservaPorID($conexion, $idReserva) {
    $idReserva = mysqli_real_escape_string($conexion, $idReserva);
    $query = "SELECT * FROM reservas WHERE idReserva = '$idReserva'";
    $resultado = mysqli_query($conexion, $query);

    if ($resultado) {
        return mysqli_fetch_assoc($resultado); // Devuelve los datos de la reserva
    } else {
        return null; // Si no se encuentra la reserva, devuelve null
    }
}


// FUNCION PARA OBTENER CONTRASEÑA DE JUGADOR SEGUN SU DNI
function obtenerContrasenaJugadorPorDNI($conexion, $dni) {
    $dni = mysqli_real_escape_string($conexion, $dni);
    $query = "SELECT contrasenaJugador FROM jugadores WHERE dniJugador = ?";
    $stmt = $conexion->prepare($query);
    if ($stmt) {
        $stmt->bind_param("s", $dni);
        $stmt->execute();
        $stmt->bind_result($contrasena);
        $stmt->fetch();
        $stmt->close();
        return $contrasena;
    }
    return null;
}


//FUNCION PARA OBTENER NOMBRECAMPO POR SU idCampoJuego
function obtenerNombreCampoPorID($conexion, $idCampoJuego) {
    $idCampoJuego = mysqli_real_escape_string($conexion, $idCampoJuego);

    $query = "SELECT nombreCampo FROM campos WHERE idCampo = '$idCampoJuego'";
    $resultado = mysqli_query($conexion, $query);

    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $fila = mysqli_fetch_assoc($resultado);
        return $fila['nombreCampo'];
    } else {
        return null; // O puedes lanzar un error o loguearlo según el caso
    }
}


//FUNCION PARA OBTENER PARTIDAS POR SU IDPARTIDALSELECCIONADA
function obtenerPartidaPorIDpartida($conexion, $idPartidaSelect) {
    $idPartidaSelect = mysqli_real_escape_string($conexion, $idPartidaSelect);

    // Cambiar el nombre de la tabla 'partida' a 'partidas'
    $query = "SELECT * FROM partidas WHERE idPartida = '$idPartidaSelect'"; // Corregido el nombre de la tabla

    $resultado = mysqli_query($conexion, $query);

    if ($resultado) {
        return mysqli_fetch_assoc($resultado);
    } else {
        return null;
    }
}



//FUNCION PARA OBTENER TODAS LOS CAMPOS
function obtenerTotalCampos($conexion) {
    $sqlTotalCampos = "SELECT * FROM campos";
    return mysqli_query($conexion, $sqlTotalCampos);
}


//FUNCION PARA OBTENER PARTIDAS RESERVADAS(pendientes/cancelas)
function obtenerPartidasReservadas($conexion, $dni) {
    $dni = mysqli_real_escape_string($conexion, $dni); // Asegúrate de sanitizar el input
    $partidasReservadas = "SELECT p.*, r.* 
        FROM partidas p 
        JOIN reservas r ON p.idPartida = r.idPartida
        WHERE (p.estadoPartida = 'Pendiente' OR p.estadoPartida = 'Cancelada')
        AND r.dniJugador = '$dni'
        ORDER BY 
          CASE 
            WHEN p.estadoPartida = 'Pendiente' THEN 1
            WHEN p.estadoPartida = 'Cancelada' THEN 2
            ELSE 3
          END,
          p.fecha DESC";
    
    // Ejecutar la consulta y devolver el resultado
    return mysqli_query($conexion, $partidasReservadas);
}

//FUNCION PARA OBTENER PARTIDAS DISTRITO 9(pendientes/cancelas) de hace 15 dias
function obtenerPartidasD9($conexion) {
    // Seleccionar partidas de ID 1 Distrito9 cuando esté pendiente o cancelada
    $partidasDistrito9 = "SELECT * 
    FROM partidas 
    WHERE (estadoPartida = 'Pendiente' OR estadoPartida = 'Cancelada') 
      AND idCampo = 1 
      AND fecha >= DATE_SUB(CURDATE(), INTERVAL 15 DAY)
    ORDER BY 
      CASE 
        WHEN estadoPartida = 'Pendiente' THEN 1
        WHEN estadoPartida = 'Cancelada' THEN 2
        ELSE 3
      END,
      fecha DESC";
    
    // Ejecutar la consulta y devolver el resultado
    return mysqli_query($conexion, $partidasDistrito9);
}

//FUNCION PARA OBTENER PARTIDAS DISTRITO 9(pendientes/cancelas) de hace 15 dias
function obtenerPartidasEnclave($conexion) {
    // Seleccionar partidas de ID 1 Distrito9 cuando esté pendiente o cancelada
    $partidasEnclave = "SELECT * 
    FROM partidas 
    WHERE (estadoPartida = 'Pendiente' OR estadoPartida = 'Cancelada') 
      AND idCampo = 2 
      AND fecha >= DATE_SUB(CURDATE(), INTERVAL 15 DAY)
    ORDER BY 
      CASE 
        WHEN estadoPartida = 'Pendiente' THEN 1
        WHEN estadoPartida = 'Cancelada' THEN 2
        ELSE 3
      END,
      fecha DESC";
    
    // Ejecutar la consulta y devolver el resultado
    return mysqli_query($conexion, $partidasEnclave);
}


//FUNCION PARA OBTENER NUMERO DE JUGADORES APUNTADOS POR PARTIDA
function obtenerNumeroJugadoresPorPartida($conexion, $numeroIdPartida) {
    // Asegúrate de sanitizar el input
    $numeroIdPartida = mysqli_real_escape_string($conexion, $numeroIdPartida);

    // Calcular el número de jugadores para cada partida
    $sqlNumeroJugadoresIdPartida = "SELECT COUNT(*) as totalReservas FROM reservas WHERE idPartida = $numeroIdPartida";
    
    // Ejecutar la consulta
    $resultadoNumeroJugadores = mysqli_query($conexion, $sqlNumeroJugadoresIdPartida);

    // Obtener el número de jugadores apuntados
    if ($resultadoNumeroJugadores) {
        $numeroJugadoresApuntados = mysqli_fetch_assoc($resultadoNumeroJugadores)['totalReservas'];
        return $numeroJugadoresApuntados;
    }
    
    return 0;  // En caso de error o no encontrar resultados, devuelve 0
}

// FUNCION PARA VERIFICAR SI UN JUGADOR YA ESTÁ REGISTRADO EN UNA PARTIDA
function verificarJugadorRegistrado($conexion, $idPartida, $dniJugador) {
    // Sanitizar las entradas
    $idPartida = mysqli_real_escape_string($conexion, $idPartida);
    $dniJugador = mysqli_real_escape_string($conexion, $dniJugador);

    // Consulta para verificar si el jugador ya está en la partida
    $queryCheck = "SELECT 1 FROM reservas WHERE idPartida = '$idPartida' AND dniJugador = '$dniJugador'";
    $resCheck = mysqli_query($conexion, $queryCheck);

    if ($resCheck && mysqli_num_rows($resCheck) > 0) {
        return true; // El jugador ya está apuntado
    }

    return false; // El jugador no está apuntado
}


// --------------------------------- ------------------------- ---------------------
// --------------------------------- FUNCIONES PARA ELIMINAR DATOS [DELEte]  ---------------------
// --------------------------------- ------------------------- ---------------------


// FUNCIÓN PARA ELIMINAR JUGADOR POR DNI
function eliminarJugadorPorDNI($conexion, $dni) {
    $dni = mysqli_real_escape_string($conexion, $dni);
    $query = "DELETE FROM jugadores WHERE dniJugador = '$dni'";
    return mysqli_query($conexion, $query);
}

// FUNCIÓN PARA ELIMINAR ADMINISTRADOR POR DNI
function eliminarAdministradorPorDNI($conexion, $dni) {
    $dni = mysqli_real_escape_string($conexion, $dni);
    $query = "DELETE FROM administrador WHERE dniAdmin = '$dni'";
    return mysqli_query($conexion, $query);
}

// FUNCIÓN PARA ELIMINAR PARTIDA POR ID
function eliminarPartidaPorID($conexion, $idPartida) {
    $idPartida = mysqli_real_escape_string($conexion, $idPartida);
    $query = "DELETE FROM partidas WHERE idPartida = '$idPartida'";
    return mysqli_query($conexion, $query);
}

// FUNCION PARA ELIMINAR LA RESERVA
function eliminarReserva($conexion, $idReserva) {
    $idReserva = mysqli_real_escape_string($conexion, $idReserva);
    $queryEliminarReserva = "DELETE FROM reservas WHERE idReserva = '$idReserva'";

    if (mysqli_query($conexion, $queryEliminarReserva)) {
        return ['mensajeError' => false, 'mensaje' => 'Reserva eliminada correctamente.'];
    } else {
        return ['mensajeError' => true, 'mensaje' => 'Error al eliminar la reserva: ' . mysqli_error($conexion)];
    }
}

// FUNCIÓN PARA ELIMINAR UN EMAIL DE LA NEWSLETTER
function eliminarEmailDeNewsletter($conexion, $email) {
    $email = mysqli_real_escape_string($conexion, $email);
    $sql = "DELETE FROM newsletter WHERE email = '$email'";
    return $conexion->query($sql);
}


// FUNCION AUXILIAR PARA CERRAR SESIÓN DE USUARIO
function cerrarSesionActual() {
    $_SESSION = array();

    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    session_destroy();
}




// --------------------------------- ------------------------- ---------------------
// --------------------------------- FUNCIONES PARA ACTUALIZAR DATOS [UPDATE]  ---------------------
// --------------------------------- ------------------------- ---------------------


// FUNCION PARA ACTUALIZAR JUGADOR SEGUN LOS DATOS ELEGIDOS
function actualizarDatosJugador($conexion, $nombre, $apellido1, $apellido2, $telefono, $nick, $contrasena, $dni) {
    $query = "UPDATE jugadores 
              SET nombreJugador = ?, apellido1Jugador = ?, apellido2Jugador = ?, 
                  telefonoJugador = ?, nickJugador = ?, contrasenaJugador = ? 
              WHERE dniJugador = ?";
    $stmt = $conexion->prepare($query);
    if ($stmt) {
        $stmt->bind_param("sssssss", $nombre, $apellido1, $apellido2, $telefono, $nick, $contrasena, $dni);
        $resultado = $stmt->execute();
        $stmt->close();
        return $resultado;
    }
    return false;
}

//Funcion para ctualizar datos de partida
function actualizarDatosPartida($conexion, $idPartida, $idCampo, $nombreCampo, $nombrePartida, $fecha, $horaPartida, $precioPartida, $numeroJugadores, $descripcionPartida) {
    $query = "UPDATE partidas SET 
                idCampo = ?, 
                nombreCampo = ?, 
                nombrePartida = ?, 
                fecha = ?, 
                horaPartida = ?, 
                precioPartida = ?, 
                numeroJugadores = ?, 
                descripcionPartida = ?
              WHERE idPartida = ?";
    
    $stmt = $conexion->prepare($query);
    if ($stmt) {
        $stmt->bind_param("issssdiss", 
            $idCampo, 
            $nombreCampo, 
            $nombrePartida, 
            $fecha, 
            $horaPartida, 
            $precioPartida, 
            $numeroJugadores, 
            $descripcionPartida, 
            $idPartida
        );
        $resultado = $stmt->execute();
        $stmt->close();
        return $resultado;
    }
    return false;
}

// FUNCIÓN PARA ACTUALIZAR ESTADO DE UNA PARTIDA
function actualizarEstadoPartida($conexion, $idPartida, $nuevoEstado) {
    $idPartida = mysqli_real_escape_string($conexion, $idPartida);
    $nuevoEstado = mysqli_real_escape_string($conexion, $nuevoEstado);

    $query = "UPDATE partidas SET estadoPartida = ? WHERE idPartida = ?";
    $stmt = $conexion->prepare($query);

    if ($stmt) {
        $stmt->bind_param("si", $nuevoEstado, $idPartida);
        $resultado = $stmt->execute();
        $stmt->close();
        return $resultado;
    }
    return false;
}

// FUNCION PARA ACTUALIZAR ESTADO DEL JUGADOR (BLOQUEAR/DESBLOQUEAR) desde ADMIN
function actualizarEstadoJugador($conexion, $dni, $estado) {
    $dni = mysqli_real_escape_string($conexion, $dni);
    $estado = mysqli_real_escape_string($conexion, $estado);

    $query = "UPDATE jugadores SET estadoJugador = '$estado' WHERE dniJugador = '$dni'";
    return mysqli_query($conexion, $query);
}







// --------------------------------- ------------------------- ---------------------
// --------------------------------- FUNCIONES PARA CREAR DATOS [INSERT]  ---------------------
// --------------------------------- ------------------------- ---------------------


function crearNuevaPartida($conexion, $idCampoJuego, $nombreCampo, $nombrePartida, $fechaPartida, $horaPartida, $precioPartida, $maximoJugadoresPartida, $descripcionPartida, $estadoPartida, $portadaPartida) {
    // Escapar datos para prevenir inyección SQL
    $idCampoJuego = mysqli_real_escape_string($conexion, $idCampoJuego);
    $nombreCampo = mysqli_real_escape_string($conexion, $nombreCampo);
    $nombrePartida = mysqli_real_escape_string($conexion, $nombrePartida);
    $fechaPartida = mysqli_real_escape_string($conexion, $fechaPartida);
    $horaPartida = mysqli_real_escape_string($conexion, $horaPartida);
    $precioPartida = mysqli_real_escape_string($conexion, $precioPartida);
    $maximoJugadoresPartida = mysqli_real_escape_string($conexion, $maximoJugadoresPartida);
    $descripcionPartida = mysqli_real_escape_string($conexion, $descripcionPartida);
    $estadoPartida = mysqli_real_escape_string($conexion, $estadoPartida);
    $portadaPartida = mysqli_real_escape_string($conexion, $portadaPartida);

    // Consulta de inserción
    $sql = "INSERT INTO partidas (
        idCampo, nombreCampo, nombrePartida, 
        fecha, horaPartida, precioPartida, numeroJugadores, 
        descripcionPartida, estadoPartida, imagenPartida
    ) VALUES (
        '$idCampoJuego', '$nombreCampo', '$nombrePartida', 
        '$fechaPartida', '$horaPartida', '$precioPartida', '$maximoJugadoresPartida', 
        '$descripcionPartida', '$estadoPartida', '$portadaPartida'
    )";

    return mysqli_query($conexion, $sql);
}


// FUNCION PARA INSERTAR UNA RESERVA EN LA BASE DE DATOS (INDIVIDUAL+COLECTIVA)
function insertarReserva($conexion, $idPartida, $dniJugador, $nickJugador, $nombreJugador, $apellido1Jugador, $apellido2Jugador, $telefonoJugador, $precioPartida, $email) {
    // Escapar los datos para evitar inyección SQL
    $idPartida = mysqli_real_escape_string($conexion, $idPartida);
    $dniJugador = mysqli_real_escape_string($conexion, $dniJugador);
    $nickJugador = mysqli_real_escape_string($conexion, $nickJugador);
    $nombreJugador = mysqli_real_escape_string($conexion, $nombreJugador);
    $apellido1Jugador = mysqli_real_escape_string($conexion, $apellido1Jugador);
    $apellido2Jugador = mysqli_real_escape_string($conexion, $apellido2Jugador);
    $telefonoJugador = mysqli_real_escape_string($conexion, $telefonoJugador);
    // Precio no debe ser tratado como string si es un número, se debe dejar sin comillas
    $precioPartida = mysqli_real_escape_string($conexion, $precioPartida);
    $email = mysqli_real_escape_string($conexion, $email);

    // Consulta de inserción
    $queryInsert = "INSERT INTO reservas (
        idPartida, dniJugador, nickJugador, nombreJugador, apellido1Jugador, apellido2Jugador,
        telefonoJugador, precioPartida, email
    ) VALUES (
        '$idPartida', '$dniJugador', '$nickJugador', '$nombreJugador', '$apellido1Jugador', '$apellido2Jugador',
        '$telefonoJugador', '$precioPartida', '$email'
    )";

    // Ejecutar la consulta
    if (mysqli_query($conexion, $queryInsert)) {
        return ['mensajeError' => false, 'mensaje' => 'Partida reservada con éxito'];
    } else {
        return ['mensajeError' => true, 'mensaje' => 'Error al realizar la reserva: ' . mysqli_error($conexion)];
    }
}


// FUNCION PARA INSERTAR UNA CANCELACIÓN
function insertarCancelacion($conexion, $datosCancelacion) {
    // Consulta para insertar la cancelación
    $queryInsertarCancelacion = "
    INSERT INTO cancelaciones (
        idPartida, 
        idReserva, 
        dniJugador, 
        nombreJugador, 
        nickJugador, 
        apellido1Jugador, 
        apellido2Jugador, 
        telefonoJugador, 
        precioPartida, 
        email, 
        fechaReserva, 
        fechaCancelacion
    ) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Preparar la consulta
    $stmt = mysqli_prepare($conexion, $queryInsertarCancelacion);

    if ($stmt === false) {
        return ['mensajeError' => true, 'mensaje' => 'Error al preparar la consulta: ' . mysqli_error($conexion)];
    }

    // Asociar los parámetros
    mysqli_stmt_bind_param($stmt, 'iissssssssss', 
        $datosCancelacion['idPartida'], 
        $datosCancelacion['idReserva'], 
        $datosCancelacion['dniJugador'], 
        $datosCancelacion['nombreJugador'], 
        $datosCancelacion['nickJugador'], 
        $datosCancelacion['apellido1Jugador'], 
        $datosCancelacion['apellido2Jugador'], 
        $datosCancelacion['telefonoJugador'], 
        $datosCancelacion['precioPartida'], 
        $datosCancelacion['email'], 
        $datosCancelacion['fechaReserva'], 
        $datosCancelacion['fechaCancelacion']
    );

    // Ejecutar la consulta
    if (!mysqli_stmt_execute($stmt)) {
        return ['mensajeError' => true, 'mensaje' => 'Error al insertar la cancelación: ' . mysqli_error($conexion)];
    }

    // Cerrar el Prepared Statement
    mysqli_stmt_close($stmt);

    return ['mensajeError' => false, 'mensaje' => 'Cancelación registrada correctamente.'];
}



// FUNCIÓN PARA CREAR NUEVO JUGADOR
function crearNuevoJugador($conexion, $dni, $nick, $nombre, $apellido1, $apellido2, $fechaNacimiento, $email, $password, $telefono) {
    // Escapar datos para prevenir inyección SQL
    $dni = mysqli_real_escape_string($conexion, $dni);
    $nick = mysqli_real_escape_string($conexion, $nick);
    $nombre = mysqli_real_escape_string($conexion, $nombre);
    $apellido1 = mysqli_real_escape_string($conexion, $apellido1);
    $apellido2 = mysqli_real_escape_string($conexion, $apellido2);
    $fechaNacimiento = mysqli_real_escape_string($conexion, $fechaNacimiento);
    $email = mysqli_real_escape_string($conexion, $email);
    $password = mysqli_real_escape_string($conexion, $password);
    $telefono = mysqli_real_escape_string($conexion, $telefono);

    $sql = "INSERT INTO jugadores (
                dniJugador, nickJugador, nombreJugador, apellido1Jugador, apellido2Jugador,
                fechaNacimiento, email, contrasenaJugador, telefonoJugador, estadoJugador
            ) VALUES (
                '$dni', '$nick', '$nombre', '$apellido1', '$apellido2',
                '$fechaNacimiento', '$email', '$password', '$telefono', 'Activo'
            )";

    return mysqli_query($conexion, $sql);
}



// --------------------------------- ------------------------- ---------------------
// --------------------------------- FUNCIONES PARA PAGINACIÓN ---------------------
// --------------------------------- ------------------------- ---------------------

//FUNCION PARA OBTENER TODAS LAS PARTIDAS (pendiente/cancelada/finalizada) Limitadas a la paginacion
function obtenerTotalPartidas($conexion, $offset, $recordsPerPage) {
    $sqlTotalPartidas = "SELECT * FROM partidas 
                         ORDER BY 
                             CASE 
                                 WHEN estadoPartida = 'Pendiente' THEN 1
                                 WHEN estadoPartida = 'Cancelada' THEN 2
                                 WHEN estadoPartida = 'Finalizada' THEN 3
                                 ELSE 4
                             END, fecha ASC, horaPartida ASC
                         LIMIT $offset, $recordsPerPage";
    return mysqli_query($conexion, $sqlTotalPartidas);
}

//FUNCION PARA OBTENER TODAS LOS JUGADORES Limitadas a la paginacion

function obtenerTotalJugadores($conexion, $offset, $recordsPerPage) {
    $sqlTotalJugadores = "SELECT * FROM jugadores LIMIT $offset, $recordsPerPage";
    return mysqli_query($conexion, $sqlTotalJugadores);
}

//FUNCION PARA CONTAR TODAS LAS PARTIDAS (pendiente/cancelada/finalizada)
function contarTotalPartidas($conexion) {
    $sqlTotalPartidas = "SELECT COUNT(*) as total FROM partidas";
    $resultado = mysqli_query($conexion, $sqlTotalPartidas);
    $fila = mysqli_fetch_assoc($resultado);
    return $fila['total']; // Devolver el valor numérico del total
}


//FUNCION PARA CONTAR TODAS LOS JUGADORES (pendiente/cancelada/finalizada)
function contarTotalJugadores($conexion) {
    $sqlTotalJugadores = "SELECT COUNT(*) as total FROM jugadores";
    $resultado = mysqli_query($conexion, $sqlTotalJugadores);
    $fila = mysqli_fetch_assoc($resultado);
    return $fila['total']; // Devolver el valor numérico del total
}





?>