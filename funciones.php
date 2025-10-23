<?php
session_start();
// Llamada a la conexión a la BBDD
require_once "conexion.php";
require_once "cronActualizarPartidas.php"; // Asegúrate de que el nombre y la ruta sean correctos

// header('Content-Type: application/json');
$datos = $_POST; // O $_GET, dependiendo de cómo estés enviando los datos

// Llamar a la función para actualizar el estado de las partidas
$partidasActualizadas = actualizarEstadoPartidas($conexion);


// --------------------------------- ------------------------- ---------------------
// ------------------ LLAMADA A LAS FUNCIONES EN BASE A UNA ACCION ---------------------
// --------------------------------- ------------------------- ---------------------

// ---------Verificar si se recibieron los datos del formulario y la acción a realizar
// Este fragmento de código PHP está revisando si se ha enviado una solicitud HTTP POST al servidor y si dentro de esa solicitud existe un parámetro llamado tipoFuncion. Si ambas condiciones se cumplen, entonces guarda el valor de ese parámetro en una variable.

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_REQUEST['tipoFuncion'])) {
    $tipoFuncion = $_REQUEST['tipoFuncion'];

    if ($tipoFuncion === 'funcionAltaNewsletter') {
        validarNewsletter($conexion);
    } elseif ($tipoFuncion === 'funcionBajaNewsletter') {
        validarBajaNewsletter($conexion);
    }elseif ($tipoFuncion === 'funcionAltaUsuario') {
        validarCrearUsuario($conexion);
    }elseif ($tipoFuncion === 'funcionlogearUsuario') {
        logearUsuario($conexion);
    }elseif ($tipoFuncion === 'funcionlogearAdmin') {
        logearAdmin($conexion);
    }elseif ($tipoFuncion === 'funcionModificarJugador') {
        actualizarJugador($conexion);
    }elseif ($tipoFuncion === 'funcionEliminarPerfil') {
        EliminarPerfil($conexion);
    }elseif ($tipoFuncion === 'funcionModificarJugadorAdmin') {
        modificarJugadorAdmin($conexion);
    }elseif ($tipoFuncion === 'funcionBloquearJugador') {
        bloquearJugador($conexion);
    }elseif ($tipoFuncion === 'funciondesBloquearJugador') {
        desbloquearJugador($conexion);
    }elseif ($tipoFuncion === 'funcionadmineliminarjugador') {
        admineliminarjugadorSelec($conexion);
    }elseif ($tipoFuncion === 'funcionNuevaPartida') {
        admincrearNuevaPartida($conexion);
    } elseif ($tipoFuncion === 'funcionModificarPartidaAdmin') {
        adminModificarPartida($conexion);
    } elseif ($tipoFuncion === 'funcionadmineliminarPartida') {
        admineliminarPartidaSelec($conexion);
    }elseif ($tipoFuncion === 'funcionadminCancelarPartida') {
        adminCancelarPartidaSelec($conexion);
    }elseif ($tipoFuncion === 'funcionadminDesCancelarPartida') {
        adminDesCancelarPartidaSelec($conexion);
    }elseif ($tipoFuncion === 'funcionApuntarsePartidaIndividual') {
        ApuntarsePartidaIndividual($conexion);
    }elseif ($tipoFuncion === 'formDataApuntarsePartidaGrupal') {
        ApuntarsePartidaGrupal($conexion, $datos);
    }elseif ($tipoFuncion === 'funcionjugadorEliminarReserva') {
        DesapuntarsePartida($conexion);
    }
     
    else {
        $response = array("mensajeError" => true, "mensaje" => "Acción no válida");
        echo json_encode($response);
    }
} else {
    $response = array("mensajeError" => true, "mensaje" => "Debes completar el formulario");
    echo json_encode($response);
}


// FUNCION PARA VALIDAR LA NEWSLETTER
function validarNewsletter($conexion){
    // Limpiar y validar el correo electrónico
    $email = $_POST["emailAltaBajaNewsletter"];
    $aceptoTerminos = $_POST["aceptoTerminos"];
    //Validar Casillas Vacias y su valor
    $erCorreo = "/^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/";

    // Verificar si se proporcionó un correo electrónico (que no es igual a "")
    if (!$aceptoTerminos || $aceptoTerminos == 0) {
        $mensajeError = false;
        $response = array("mensajeError" => $mensajeError, "mensaje" => "Debes aceptar los términos y condiciones");
        echo json_encode($response);
        return; // Retorna la respuesta
    } elseif (empty($email)) {
        $mensajeError = false;
        $response = array("mensajeError" => $mensajeError, "mensaje" => "EL EMAIL ESTA VACIO");
        echo json_encode($response);
        return; // Retorna la respuesta
    } elseif (!preg_match($erCorreo, $email)) {
        $mensajeError = false;
        $response = array("mensajeError" => $mensajeError, "mensaje" => "Debes introducir un email válido");
        echo json_encode($response);
        return; // Retorna la respuesta
    } else {
        // Seleccionamos los email de newsletter para comprobaciones
        $query = "SELECT * FROM newsletter WHERE email = '$email'";
        $todosEmailNewsletter = mysqli_query($conexion, $query);

        if (emailExisteEnNewsletter($conexion, $email)) {
            $mensajeError = false;
            $response = array("mensajeError" => $mensajeError, "mensaje" => "El email ya existe en nuestra BBDD");
            echo json_encode($response);
            return;
        } else {
            $sql = "INSERT INTO newsletter (email) VALUES ('$email')";
            if ($conexion->query($sql) === TRUE) {
                $mensajeError = true;
                $response = array("mensajeError" => $mensajeError, "mensaje" => "Correo electrónico agregado correctamente");
                echo json_encode($response);
            } else {
                $mensajeError = true;
                $response = array("mensajeError" => $mensajeError, "mensaje" => "Error al agregar correo electrónico: " . $conexion->error);
                echo json_encode($response);
            }
        }
    }
}

// FUNCION PARA VALIDAR BAJA DE LA NEWSLETTER

function validarBajaNewsletter($conexion){
    $emailBajaNewsletter = $_POST["emailBajaNewsletter"];
    $erCorreo2 = "/^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/";

    if (empty($emailBajaNewsletter)) {
        $mensajeError = false;
        $response = array("mensajeError" => $mensajeError, "mensaje" => "No ha indicado ningun correo");
        echo json_encode($response);
        return;
    } elseif (!preg_match($erCorreo2, $emailBajaNewsletter)) {
        $mensajeError = false;
        $response = array("mensajeError" => $mensajeError, "mensaje" => "Debes introducir un correo válido");
        echo json_encode($response);
        return;
    } else {
        if (emailExisteEnNewsletter($conexion, $emailBajaNewsletter)) {
            if (eliminarEmailDeNewsletter($conexion, $emailBajaNewsletter)) {
                $mensajeError = true;
                $response = array("mensajeError" => $mensajeError, "mensaje" => "El email se dio de baja correctamente");
                echo json_encode($response);
            } else {
                $mensajeError = false;
                $response = array("mensajeError" => $mensajeError, "mensaje" => "Error en la query " . $conexion->error);
                echo json_encode($response);
            }
        } else {
            $mensajeError = false;
            $response = array("mensajeError" => $mensajeError, "mensaje" => "El email no se ha encontrado en nuestra newsletter");
            echo json_encode($response);
        }
    }
}


// FUNCION PARA VALIDAR CREAR USUARIO

function validarCrearUsuario($conexion) {
    // recuperar valores de los input
    $AltaDNI = $_POST["AltaDNI"];
    $AltaDNI = trim(strtoupper($AltaDNI));
    $AltaNombre = $_POST["AltaNombre"];
    $AltaNick = $_POST["AltaNick"];
    $AltaApellido = $_POST["AltaApellido"];
    $AltaApellido2 = $_POST["AltaApellido2"];
    $AltaFechaNacimiento = $_POST["AltaFechaNacimiento"];
    $AltaTelefono = $_POST["AltaTelefono"];
    $AltaEmail = $_POST["AltaEmail"];
    $AltaPassword = $_POST["AltaPassword"];
    $AltaRepetirPassword = $_POST["AltaRepetirPassword"];
    
    $erCorreo = "/^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/";
    $erDNI = "/^([0-9]{8}[A-Za-z]$|[XYZ]{1}[0-9]{7}[A-Za-z]{1}$)/";// DNI válido (8 dígitos y una letra)
    $erNIE = "/^[XYZ]\d{7}[a-zA-Z]$/";
    $erTelefono = "/^(?:\+34|0034|34)?[6-9]\d{8}$/";
    $erContrasena = '/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';
    
    $fecha_actual = new DateTime();
    $fechaNacimiento = new DateTime($AltaFechaNacimiento);
    $diferencia = $fechaNacimiento->diff($fecha_actual);

    //Declarar Mensaje Error
    $mensajeError = "";

    //Validacion de los campos
    if (empty($AltaDNI)) {
        $mensajeError = false;
        $response = array("mensajeError" => $mensajeError, "mensaje" => "Necesitamos un documento de identificación.");
        echo json_encode($response);
        return;
    } elseif (!preg_match($erDNI, $AltaDNI) && !preg_match($erNIE, $AltaDNI)) {
         $mensajeError = false;
         $response = array("mensajeError" => $mensajeError, "mensaje" => "El formato o tipo de documento no es válido.");
         echo json_encode($response);
         return;
    } elseif (empty($AltaNombre)) {
        $mensajeError = false;
        $response = array("mensajeError" => $mensajeError, "mensaje" => "El nombre es requerido.");
        echo json_encode($response);
        return;
    } elseif ($diferencia->y < 18) {
        $mensajeError = false;
        $response = array("mensajeError" => $mensajeError, "mensaje" => "Debes ser mayor de edad (+18años).");
        echo json_encode($response);
        return;
    } elseif (empty($AltaNick)) {
        $mensajeError = false;
        $response = array("mensajeError" => $mensajeError, "mensaje" => "El Nick es requerido.");
        echo json_encode($response);
        return;
    } elseif (empty($AltaEmail)) {
        $mensajeError = false;
        $response = array("mensajeError" => $mensajeError, "mensaje" => "El email es requerido.");
        echo json_encode($response);
        return;
    } elseif (!preg_match($erCorreo, $AltaEmail)) {
        $mensajeError = false;
        $response = array("mensajeError" => $mensajeError, "mensaje" => "El formato del correo no es válido.");
        echo json_encode($response);
        return;
    } elseif (empty($AltaTelefono)) {
        $mensajeError = false;
        $response = array("mensajeError" => $mensajeError, "mensaje" => "El telefono es requerido.");
        echo json_encode($response);
        return;
    } elseif (!preg_match($erTelefono, $AltaTelefono)) {
        $mensajeError = false;
        $response = array("mensajeError" => $mensajeError, "mensaje" => "El telefono no es valido. Prueba alguna extensión como: '+34678901234', '0034678901234' o '678901234'.");
        echo json_encode($response);
        return;
    }elseif (!preg_match($erContrasena, $AltaPassword)) {
        $mensajeError = false;
        $response = array("mensajeError" => $mensajeError, "mensaje" => "Debe contener: 
        Al menos 8 caracteres.
        Al menos una letra (mayúscula o minúscula).
        Al menos un número.
        Al menos un caracter especial.");
        echo json_encode($response);
        return;
    } elseif ($AltaPassword !== $AltaRepetirPassword) {
        $mensajeError = false;
        $response = array("mensajeError" => $mensajeError, "mensaje" => "La contraseña no coincide. (Diferencia entre maysuculas y minusculas).");
        echo json_encode($response);
        return;
    } else{
       // Comprobar si el jugador ya existe
       $jugador = obtenerJugadorPorDNI($conexion, $AltaDNI);

        // Comprobar si el DNI ya existe
        if ($jugador) {
            // Mostrar un mensaje de error si el DNI ya está registrado
            $mensajeError = false;
            $response = array("mensajeError" => $mensajeError, "mensaje" => "Este usuario ya está dado de alta.");
            echo json_encode($response);
            return;
        } else {
            // Insertar nuevo usuario usando función externa
            if (crearNuevoJugador($conexion, $AltaDNI, $AltaNick, $AltaNombre, $AltaApellido, $AltaApellido2, $AltaFechaNacimiento, $AltaEmail, $AltaPassword, $AltaTelefono)) {
                $mensajeError = true;
                $response = array("mensajeError" => $mensajeError, "mensaje" => "BIENVENIDO A D9");
                echo json_encode($response);
                return;
            } else {
                $mensajeError = false;
                $response = array("mensajeError" => $mensajeError, "mensaje" => "Error al insertar: " . mysqli_error($conexion));
                echo json_encode($response);
                return;
            }
        }

    }

}



// FUNCION PARA VALIDAR LOGAR USUARIO

function logearUsuario($conexion) {
    $usuarioJugador = $_POST["usuarioJugador"];
    $passwordUsuario = $_POST["passwordUsuario"];

    $erCorreo = "/^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/";

    if (empty($usuarioJugador)) {
        echo json_encode(["mensajeError" => false, "mensaje" => "Es necesario un correo electrónico."]);
        return;
    } elseif (!preg_match($erCorreo, $usuarioJugador)) {
        echo json_encode(["mensajeError" => false, "mensaje" => "El formato del correo no es válido."]);
        return;
    } elseif (empty($passwordUsuario)) {
        echo json_encode(["mensajeError" => false, "mensaje" => "Es necesario una contraseña."]);
        return;
    }

    $usuario = obtenerJugadorPorEmail($conexion, $usuarioJugador);

    if ($usuario) {
        if ($passwordUsuario === $usuario['contrasenaJugador']) {
            if (isset($_SESSION['sesionAdmin'])) {
                unset($_SESSION['sesionAdmin']);
            }

            $_SESSION['sesionJugador'] = $usuario['dniJugador'];
            $_SESSION['sesionJugador_email'] = $usuario['email'];
            echo json_encode(["mensajeCorrecto" => false, "mensaje" => "Bienvenido"]);
        } else {
            echo json_encode(["mensajeError" => false, "mensaje" => "Contraseña incorrecta"]);
        }
    } else {
        echo json_encode(["mensajeError" => false, "mensaje" => "Este Usuario no existe."]);
    }
}


// FUNCION PARA LOGEAR ADMIN

function logearAdmin($conexion) {
    $usuarioAdmin = $_POST["usuarioAdmin"];
    $passwordAdmin = $_POST["passwordAdmin"];

    $erCorreo = "/^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/";
    $erContrasena = '/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';

    if (empty($usuarioAdmin)) {
        echo json_encode(["mensajeError" => false, "mensaje" => "Es necesario un correo electrónico."]);
        return;
    } elseif (!preg_match($erCorreo, $usuarioAdmin)) {
        echo json_encode(["mensajeError" => false, "mensaje" => "El formato del correo no es válido."]);
        return;
    } elseif (empty($passwordAdmin)) {
        echo json_encode(["mensajeError" => false, "mensaje" => "Es necesario una contraseña."]);
        return;
    }

    $administrador = obtenerAdminPorEmail($conexion, $usuarioAdmin);

    if ($administrador) {
        if ($passwordAdmin === $administrador['contrasenaAdmin']) {
            if (isset($_SESSION['sesionJugador'])) {
                unset($_SESSION['sesionJugador']);
            }
            $_SESSION['sesionAdmin'] = $administrador['dniAdmin'];
            $_SESSION['sesionAdmin_email'] = $administrador['emailAdmin'];
            echo json_encode(["mensajeCorrecto" => false, "mensaje" => "Bienvenido"]);
        } else {
            echo json_encode(["mensajeError" => false, "mensaje" => "Contraseña incorrecta"]);
        }
    } else {
        echo json_encode(["mensajeError" => false, "mensaje" => "Este Usuario no existe."]);
    }
}



// FUNCION PARA ACTUALIZAR JUGADOR DESDE PERFILJUGADOR
function actualizarJugador($conexion) {
    require_once("conexion.php");

    $dni = $_POST["dniSesionActivaJugadormodificar"];
    $nombre = $_POST["actualizaNombre"];
    $apellido1 = $_POST["actualizaApellido"];
    $apellido2 = $_POST["actualizaApellido2"];
    $telefono = $_POST["actualizaTelefono"];
    $nick = $_POST["actualizaNick"];
    $contrasena = $_POST["actualizaContrasena"];
    $contrasena2 = $_POST["actualizaContrasena2"];

    $erTelefono = "/^(?:\+34|0034|34)?[6-9]\d{8}$/";
    $erContrasena = '/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';

    if (empty($dni)) {
        echo json_encode(["mensajeError" => true, "mensaje" => "No hay ninguna sesión activa"]);
        return;
    }

    if (!preg_match($erTelefono, $telefono)) {
        echo json_encode(["mensajeError" => true, "mensaje" => "El número de teléfono no es válido."]);
        return;
    }

    if (!empty($contrasena) || !empty($contrasena2)) {
        if (!preg_match($erContrasena, $contrasena2)) {
            echo json_encode(["mensajeError" => true, "mensaje" => "La nueva contraseña debe tener al menos 8 caracteres, una letra, un número y un carácter especial."]);
            return;
        }

        if ($contrasena !== $contrasena2) {
            echo json_encode(["mensajeError" => true, "mensaje" => "La nueva contraseña no coincide."]);
            return;
        }
    } else {
        // Obtener la contraseña actual
        $contrasena = obtenerContrasenaJugadorPorDNI($conexion, $dni);
        if ($contrasena === null) {
            echo json_encode(["mensajeError" => true, "mensaje" => "Error al obtener la contraseña actual"]);
            return;
        }
    }

    // Ejecutar la actualización
    $resultado = actualizarDatosJugador($conexion, $nombre, $apellido1, $apellido2, $telefono, $nick, $contrasena, $dni);
    if ($resultado) {
        echo json_encode(["mensajeError" => false, "mensaje" => "Jugador actualizado correctamente"]);
    } else {
        echo json_encode(["mensajeError" => true, "mensaje" => "Error al actualizar el jugador"]);
    }
}






// FUNCION PARA ELIMINAR PERFIL DESDE JUGADOR
function EliminarPerfil($conexion) {
    $dni = $_POST["dniSesionActivaJugadormodificar"];
    $mensajeError = true;
    $mensaje = "Este Usuario no existe.";

    require_once "conexion.php"; // Asegúrate de que esté incluida la conexión con funciones

    // Buscar en jugadores
    $jugador = obtenerJugadorPorDNI($conexion, $dni);
    if ($jugador) {
        if (eliminarJugadorPorDNI($conexion, $dni)) {
            $mensajeError = false;
            $mensaje = "Jugador eliminado correctamente.";
            cerrarSesionActual();
        } else {
            $mensaje = "Error al eliminar el jugador: " . mysqli_error($conexion);
        }
    } else {
        // Buscar en administradores
        $admin = obtenerAdministradorPorDNI($conexion, $dni);
        if ($admin) {
            if (eliminarAdministradorPorDNI($conexion, $dni)) {
                $mensajeError = false;
                $mensaje = "Administrador eliminado correctamente.";
                cerrarSesionActual();
            } else {
                $mensaje = "Error al eliminar el administrador: " . mysqli_error($conexion);
            }
        }
    }

    echo json_encode(["mensajeError" => $mensajeError, "mensaje" => $mensaje]);
}




// FUNCION PARA  MODIFICAR JUGADOR DESDE ADMIN
function modificarJugadorAdmin($conexion) {
    $dni = mysqli_real_escape_string($conexion, $_POST['dniJugadorSeleccionadoAdmin']);
    $nombre = mysqli_real_escape_string($conexion, $_POST['actualizaNombre']);
    $apellido1 = mysqli_real_escape_string($conexion, $_POST['actualizaApellido']);
    $apellido2 = mysqli_real_escape_string($conexion, $_POST['actualizaApellido2']);
    $nick = mysqli_real_escape_string($conexion, $_POST['actualizaNick']);
    $telefono = mysqli_real_escape_string($conexion, $_POST['actualizaTelefono']);
    $contrasena1 = mysqli_real_escape_string($conexion, $_POST['actualizaContrasena']);
    $contrasena2 = mysqli_real_escape_string($conexion, $_POST['actualizaContrasena2']);

    $erTelefono = "/^(?:\+34|0034|34)?[6-9]\d{8}$/";
    $erContrasena = '/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';

    // Validar teléfono
    if (!preg_match($erTelefono, $telefono)) {
        echo json_encode([
            "mensajeError" => true,
            "mensaje" => "El teléfono no es válido. Prueba con '+34678901234', '0034678901234' o '678901234'."
        ]);
        return;
    }

    // Validar contraseñas si se quiere modificar
    if (!empty($contrasena1) || !empty($contrasena2)) {
        if ($contrasena1 !== $contrasena2) {
            echo json_encode([
                "mensajeError" => true,
                "mensaje" => "Las contraseñas no coinciden."
            ]);
            return;
        }

        if (!preg_match($erContrasena, $contrasena1)) {
            echo json_encode([
                "mensajeError" => true,
                "mensaje" => "La contraseña debe tener al menos 8 caracteres, una letra, un número y un carácter especial."
            ]);
            return;
        }

        $contrasenaFinal = $contrasena1; // SIN encriptar
    } else {
        // Mantener la contraseña actual si no se quiere modificar
        $contrasenaFinal = obtenerContrasenaJugadorPorDNI($conexion, $dni);

        if ($contrasenaFinal === null) {
            echo json_encode([
                "mensajeError" => true,
                "mensaje" => "No se pudo obtener la contraseña actual del jugador."
            ]);
            return;
        }
    }

    // Ejecutar la actualización
    $resultado = actualizarDatosJugador($conexion, $nombre, $apellido1, $apellido2, $telefono, $nick, $contrasenaFinal, $dni);

    if ($resultado) {
        echo json_encode([
            "mensajeError" => false,
            "mensaje" => "Jugador modificado correctamente."
        ]);
    } else {
        echo json_encode([
            "mensajeError" => true,
            "mensaje" => "Error al modificar el jugador."
        ]);
    }
}



// FUNCION PARA  BLOQUEAR JUGADOR DESDE ADMIN

// FUNCION PARA BLOQUEAR JUGADOR DESDE ADMIN
function bloquearJugador($conexion) {
    $dni = $_POST['dni'];
    $resultado = actualizarEstadoJugador($conexion, $dni, 'Bloqueado');

    if ($resultado) {
        echo json_encode(array('mensajeError' => false, 'mensaje' => 'Jugador bloqueado correctamente.'));
    } else {
        echo json_encode(array('mensajeError' => true, 'mensaje' => 'Error al bloquear al jugador.'));
    }
}

// FUNCION PARA DESBLOQUEAR JUGADOR DESDE ADMIN
function desbloquearJugador($conexion) {
    $dni = $_POST['dni'];
    $resultado = actualizarEstadoJugador($conexion, $dni, 'Activo');

    if ($resultado) {
        echo json_encode(array('mensajeError' => false, 'mensaje' => 'Jugador desbloqueado correctamente.'));
    } else {
        echo json_encode(array('mensajeError' => true, 'mensaje' => 'Error al desbloquear al jugador.'));
    }
}






// FUNCION PARA ELIMINAR JUGADOR DESDE ADMIN (USANDO FUNCIONES DE conexion.php)
function admineliminarjugadorSelec($conexion) {
    $dni = mysqli_real_escape_string($conexion, $_POST['dni']);

    // Usar la función ya existente para obtener el jugador
    $jugador = obtenerJugadorPorDNI($conexion, $dni);

    if ($jugador) {
        // Si existe, usar la función que elimina al jugador
        if (eliminarJugadorPorDNI($conexion, $dni)) {
            echo json_encode(array('mensajeError' => false, 'mensaje' => 'Jugador eliminado por admin correctamente.'));
        } else {
            echo json_encode(array('mensajeError' => true, 'mensaje' => 'Error al eliminar al jugador.'));
        }
    } else {
        echo json_encode(array('mensajeError' => true, 'mensaje' => 'Jugador no encontrado.'));
    }
}



// FUNCION PARA CREAR NUEVA PARTIDA DESDE ADMIN

function admincrearNuevaPartida($conexion) {
    // recuperar valores de los input
    $idCampoJuego = intval($_POST["idCampoJuego"]); // Convertir a entero para mayor seguridad
    $nombrePartida = $_POST["nombrePartida"];
    $fechaPartida = $_POST["fechaPartida"];
    $horaPartida = $_POST["horaPartida"];
    $precioPartida = $_POST["precioPartida"];
    $maximoJugadoresPartida = $_POST["maximoJugadoresPartida"];
    $portadaPartida = isset($_POST["portadaPartida"]) ? $_POST["portadaPartida"] : null;
    $descripcionPartida = isset($_POST["descripcionPartida"]) ? $_POST["descripcionPartida"] : null;
    $estadoPartida = "Pendiente";

    // Validaciones de entrada
    if (empty($idCampoJuego)) {
        echo json_encode(["mensajeError" => true, "mensaje" => "Debe elegir un campo de juego"]);
        return;
    }
    if (empty($nombrePartida)) {
        echo json_encode(["mensajeError" => true, "mensaje" => "Debe establecer un nombre de partida"]);
        return;
    }
    if (empty($fechaPartida)) {
        echo json_encode(["mensajeError" => true, "mensaje" => "Debe establecer una fecha para la partida"]);
        return;
    }
    if (strtotime($fechaPartida) < time()) {
        echo json_encode(["mensajeError" => true, "mensaje" => "La fecha seleccionada no es válida."]);
        return;
    }
    if (empty($horaPartida)) {
        echo json_encode(["mensajeError" => true, "mensaje" => "Debe establecer una hora para la partida"]);
        return;
    }
    if (empty($precioPartida)) {
        echo json_encode(["mensajeError" => true, "mensaje" => "Debe establecer un precio para la partida"]);
        return;
    }
    if (empty($maximoJugadoresPartida)) {
        echo json_encode(["mensajeError" => true, "mensaje" => "Debe establecer un número máximo de jugadores para la partida"]);
        return;
    }

    // Llamada a la funcion para saber nombreCampo por IDCAMPO
    $nombreCampo = obtenerNombreCampoPorID($conexion, $idCampoJuego);

    // Validar precio
    if ($precioPartida < 10 || $precioPartida > 100) {
        echo json_encode(['mensajeError' => true, 'mensaje' => 'El precio debe estar entre 10 € y 100 €']);
        return;
    }

    // Validar máximo de jugadores según el campo
    $maximoJugadoresValido = false;
    $errorMensaje = ''; // Variable para almacenar el mensaje de error

    if ($idCampoJuego == 1) {
        if ($maximoJugadoresPartida >= 10 && $maximoJugadoresPartida <= 70) {
            //Distrito9 entre 10 y 70
            $maximoJugadoresValido = true;
        } else {
            $errorMensaje = 'El número máximo de jugadores debe estar entre 10 y 70';
        }
    } elseif ($idCampoJuego == 2) {
        if ($maximoJugadoresPartida >= 10 && $maximoJugadoresPartida <= 30) {
            //Enclave entre 10 y 30
            $maximoJugadoresValido = true;
        } else {
            $errorMensaje = 'El número máximo de jugadores debe estar entre 10 y 30';
        }
    }

// Comprobar si la validación falló
if (!$maximoJugadoresValido) {
    echo json_encode(['mensajeError' => true, 'mensaje' => $errorMensaje]);
    return;
}

    // Inserción en la base de datos
    $resultado = crearNuevaPartida($conexion, $idCampoJuego, $nombreCampo, $nombrePartida, $fechaPartida, $horaPartida, $precioPartida, $maximoJugadoresPartida, $descripcionPartida, $estadoPartida, $portadaPartida);

if ($resultado) {
    echo json_encode(['mensajeError' => false, 'mensaje' => 'Partida creada correctamente']);
} else {
    echo json_encode(['mensajeError' => true, 'mensaje' => 'Error al crear la partida: ' . mysqli_error($conexion)]);
}
}


// FUNCION PARA  MODIFICAR PARTIDA DESDE ADMIN
function adminModificarPartida($conexion) {
    // Escapar las entradas para prevenir inyecciones SQL
    $idPartida = mysqli_real_escape_string($conexion, $_POST['idPartida']);
    $idCampo = mysqli_real_escape_string($conexion, $_POST['idCampo']);
    
    // Nombre del campo
    if ($idCampo == 1) {
        $nombreCampo = "Distrito 9";
    } elseif ($idCampo == 2) {
        $nombreCampo = "El Enclave";
    }

    $nombrePartida = mysqli_real_escape_string($conexion, $_POST['nombrePartida']);
    $fecha = mysqli_real_escape_string($conexion, $_POST['fecha']);
    $horaPartida = mysqli_real_escape_string($conexion, $_POST['horaPartida']);
    $precioPartida = mysqli_real_escape_string($conexion, $_POST['precioPartida']);
    $maximoJugadoresPartida = mysqli_real_escape_string($conexion, $_POST['numeroJugadores']);
    $descripcionPartida = mysqli_real_escape_string($conexion, $_POST['descripcionPartida']);

    // Validaciones
    if (empty($idCampo)) {
        echo json_encode(['mensajeError' => true, 'mensaje' => 'El campo de selección de campo es obligatorio.', 'campoVacio' => 'idCampo']);
        return;
    }
    if (empty($nombrePartida)) {
        echo json_encode(['mensajeError' => true, 'mensaje' => 'El nombre de la partida es obligatorio.', 'campoVacio' => 'nombrePartida']);
        return;
    }
    if (empty($fecha)) {
        echo json_encode(['mensajeError' => true, 'mensaje' => 'La fecha de la partida es obligatoria.', 'campoVacio' => 'fecha']);
        return;
    }
    if (empty($horaPartida)) {
        echo json_encode(['mensajeError' => true, 'mensaje' => 'La hora de la partida es obligatoria.', 'campoVacio' => 'horaPartida']);
        return;
    }
    if (empty($precioPartida)) {
        echo json_encode(['mensajeError' => true, 'mensaje' => 'El precio de la partida es obligatorio.', 'campoVacio' => 'precioPartida']);
        return;
    }
    if (empty($maximoJugadoresPartida)) {
        echo json_encode(['mensajeError' => true, 'mensaje' => 'El número máximo de jugadores es obligatorio.', 'campoVacio' => 'numeroJugadores']);
        return;
    }
    if (empty($descripcionPartida)) {
        echo json_encode(['mensajeError' => true, 'mensaje' => 'La descripción de la partida es obligatoria.', 'campoVacio' => 'descripcionPartida']);
        return;
    }

    if (strtotime($fecha) < time()) {
        echo json_encode(['mensajeError' => true, 'mensaje' => 'La fecha seleccionada no es válida.']);
        return;
    }

    if ($precioPartida < 10 || $precioPartida > 100) {
        echo json_encode(['mensajeError' => true, 'mensaje' => 'El precio debe estar entre 10 € y 100 €']);
        return;
    }

    $maximoJugadoresValido = false;
    $errorMensaje = '';

    if ($idCampo == 1) {
        if ($maximoJugadoresPartida >= 10 && $maximoJugadoresPartida <= 70) {
            $maximoJugadoresValido = true;
        } else {
            $errorMensaje = 'El número máximo de jugadores debe estar entre 10 y 70';
        }
    } elseif ($idCampo == 2) {
        if ($maximoJugadoresPartida >= 10 && $maximoJugadoresPartida <= 30) {
            $maximoJugadoresValido = true;
        } else {
            $errorMensaje = 'El número máximo de jugadores debe estar entre 10 y 30';
        }
    }

    if (!$maximoJugadoresValido) {
        echo json_encode(['mensajeError' => true, 'mensaje' => $errorMensaje]);
        return;
    }

    // Usar función externa para obtener número de reservas actuales
    $numeroApuntadosPartidaSeleccionada = obtenerNumeroJugadoresPorPartida($conexion, $idPartida);

    if ($numeroApuntadosPartidaSeleccionada > $maximoJugadoresPartida) {
        echo json_encode([
            'mensajeError' => true,
            'mensaje' => 'Hay más jugadores que plazas. Reservas actuales: ' . $numeroApuntadosPartidaSeleccionada
        ]);
        return;
    }

    // Actualizar la partida
    $resultado = actualizarDatosPartida(
        $conexion, 
        $idPartida, 
        $idCampo, 
        $nombreCampo, 
        $nombrePartida, 
        $fecha, 
        $horaPartida, 
        $precioPartida, 
        $maximoJugadoresPartida, 
        $descripcionPartida
    );

    if ($resultado) {
        echo json_encode(['mensajeError' => false, 'mensaje' => 'Partida modificada correctamente.']);
    } else {
        echo json_encode(['mensajeError' => true, 'mensaje' => 'Error al modificar la partida.']);
    }
}





// FUNCIÓN PRINCIPAL PARA ELIMINAR PARTIDA DESDE ADMIN
function admineliminarPartidaSelec($conexion) {
    $idPartida = mysqli_real_escape_string($conexion, $_POST['idPartida']);
    
    // Verifica que idPartida no esté vacío
    if (empty($idPartida)) {
        echo json_encode(array('mensajeError' => true, 'mensaje' => 'ID de partida no proporcionado.'));
        return;
    }

    // Obtener la partida usando función externa
    $partida = obtenerPartidaPorIDpartida($conexion, $idPartida);

    // Comprueba si la partida fue encontrada
    if ($partida !== null) {
        // Si la partida se encontró, proceder a eliminarla
        if (eliminarPartidaPorID($conexion, $idPartida)) {
            echo json_encode(array('mensajeError' => false, 'mensaje' => 'Partida eliminada por admin correctamente.'));
        } else {
            echo json_encode(array('mensajeError' => true, 'mensaje' => 'Error al eliminar la partida: ' . mysqli_error($conexion)));
        }
    } else {
        echo json_encode(array('mensajeError' => true, 'mensaje' => 'Partida no encontrada.'));
    }
}



// FUNCIÓN PARA CANCELAR PARTIDA DESDE ADMIN
function adminCancelarPartidaSelec($conexion) {
    $idPartida = mysqli_real_escape_string($conexion, $_POST['idPartida']);

    // Verifica que idPartida no esté vacío
    if (empty($idPartida)) {
        echo json_encode(array('mensajeError' => true, 'mensaje' => 'ID de partida no proporcionado.'));
        return;
    }

    // Obtener la partida usando función reutilizable
    $partida = obtenerPartidaPorIDpartida($conexion, $idPartida);

    if ($partida !== null) {
        // Verificar si el estado es "Pendiente"
        if ($partida['estadoPartida'] === 'Pendiente') {
            // Actualizar el estado de la partida a "Cancelada" usando función reutilizable
            if (actualizarEstadoPartida($conexion, $idPartida, 'Cancelada')) {
                echo json_encode(array('mensajeError' => false, 'mensaje' => 'La partida ha sido cancelada correctamente.'));
            } else {
                echo json_encode(array('mensajeError' => true, 'mensaje' => 'Error al cancelar la partida.'));
            }
        } else {
            echo json_encode(array(
                'mensajeError' => true,
                'mensaje' => 'La partida no está en estado "Pendiente". Estado actual: ' . $partida['estadoPartida']
            ));
        }
    } else {
        echo json_encode(array('mensajeError' => true, 'mensaje' => 'No se encontró la partida con el ID proporcionado.'));
    }
}



// FUNCIÓN PARA REACTIVAR PARTIDA CANCELADA DESDE ADMIN
function adminDesCancelarPartidaSelec($conexion) {
    $idPartida = mysqli_real_escape_string($conexion, $_POST['idPartida']);

    // Verifica que idPartida no esté vacío
    if (empty($idPartida)) {
        echo json_encode(array('mensajeError' => true, 'mensaje' => 'ID de partida no proporcionado.'));
        return;
    }

    // Obtener la partida usando función reutilizable
    $partida = obtenerPartidaPorIDpartida($conexion, $idPartida);

    if ($partida !== null) {
        // Verificar si el estado es "Cancelada"
        if ($partida['estadoPartida'] === 'Cancelada') {
            // Cambiar el estado a "Pendiente" usando función reutilizable
            if (actualizarEstadoPartida($conexion, $idPartida, 'Pendiente')) {
                echo json_encode(array('mensajeError' => false, 'mensaje' => 'La partida ha sido activada correctamente.'));
            } else {
                echo json_encode(array('mensajeError' => true, 'mensaje' => 'Error al activar la partida.'));
            }
        } else {
            echo json_encode(array(
                'mensajeError' => true,
                'mensaje' => 'La partida no está en estado "Cancelada". Estado actual: ' . $partida['estadoPartida']
            ));
        }
    } else {
        echo json_encode(array('mensajeError' => true, 'mensaje' => 'No se encontró la partida con el ID proporcionado.'));
    }
}





// FUNCION PARA APUNTARSE INDIVIDUALMENTE A PARTIDA DESDE JUGADOR
function ApuntarsePartidaIndividual($conexion) {
    // Expresiones regulares
    $erCorreo = "/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\\.,;:\s@\"]+\.)+[^<>()[\]\\.,;:\s@\"]{2,})$/";
    $erDNI = "/^([0-9]{8}[A-Za-z]$|[XYZ]{1}[0-9]{7}[A-Za-z]{1}$)/";
    $erTelefono = "/^(?:\+34|0034|34)?[6-9]\d{8}$/";

    // Validar y obtener jugador
    $dniJugador = $_POST["dniJugador"] ?? null;
    if (!$dniJugador || !preg_match($erDNI, $dniJugador)) {
        echo json_encode(['mensajeError' => true, 'mensaje' => 'DNI no válido o no proporcionado.']);
        return;
    }

    // Obtener jugador por DNI
    $jugador = obtenerJugadorPorDNI($conexion, $dniJugador);
    if (!$jugador) {
        echo json_encode(['mensajeError' => true, 'mensaje' => 'El jugador debe estar registrado.']);
        return;
    }

    // Obtener datos de la partida
    $idPartida = intval($_POST["idPartida"]);
    $nickJugador = $_POST["nickJugador"] ?? $jugador['nickJugador'];
    $nombreJugador = $_POST["nombreJugador"] ?? $jugador['nombreJugador'];
    $apellido1Jugador = $_POST["apellido1Jugador"] ?? $jugador['apellido1Jugador'];
    $apellido2Jugador = $_POST["apellido2Jugador"] ?? $jugador['apellido2Jugador'];
    $telefonoJugador = $_POST["telefonoJugador"] ?? $jugador['telefonoJugador'];
    $precioPartida = $_POST["precioPartida"];
    $email = $_POST["email"] ?? $jugador['email'];
    $numeroJugadores = intval($_POST["numeroJugadores"]);

    // Validaciones adicionales
    $errores = [];
    if (!empty($email) && !preg_match($erCorreo, $email)) {
        $errores['email'] = 'Email no válido';
    }
    if (!empty($telefonoJugador) && !preg_match($erTelefono, $telefonoJugador)) {
        $errores['telefono'] = 'Teléfono no válido';
    }

    if (!empty($errores)) {
        echo json_encode(['mensajeError' => true, 'errores' => $errores]);
        return;
    }

    // Verificar si el jugador ya está registrado en la partida
    if (verificarJugadorRegistrado($conexion, $idPartida, $dniJugador)) {
        echo json_encode(['mensajeError' => true, 'mensaje' => 'El jugador ya está apuntado a esta partida']);
        return;
    }

    // Verificar número de jugadores apuntados
    $totalApuntados = obtenerNumeroJugadoresPorPartida($conexion, $idPartida);
    if ($totalApuntados >= $numeroJugadores) {
        echo json_encode(['mensajeError' => true, 'mensaje' => 'La partida está completa']);
        return;
    }

    // Llamar a la función insertarReserva para insertar los datos
    $resultado = insertarReserva($conexion, $idPartida, $dniJugador, $nickJugador, $nombreJugador, $apellido1Jugador, $apellido2Jugador, $telefonoJugador, $precioPartida, $email);

    // Devolver la respuesta basada en el resultado de insertarReserva
    echo json_encode($resultado);
}



function ApuntarsePartidaGrupal($conexion, $datos) {
    // Expresiones regulares para validaciones de formato:
    $erCorreo = "/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\\.,;:\s@\"]+\.)+[^<>()[\]\\.,;:\s@\"]{2,})$/";
    $erDNI = "/^([0-9]{8}[A-Za-z]|[XYZ]{1}[0-9]{7}[A-Za-z])$/";
    $erTelefono = "/^(?:\+34|0034|34)?[6-9]\d{8}$/";

    // Extraer datos generales de la partida
    $idPartida = intval($datos["idPartidaGrupal"] ?? 0);
    $precioPartida = $datos["precioPartidaGrupal"] ?? '';
    $numeroJugadores = intval($datos["numeroJugadores"] ?? 0);
    $nombrePartida = $datos["nombrePartidaGrupal"] ?? '';
    $fechaGrupal = $datos["fechaGrupal"] ?? '';
    $horaPartidaGrupal = $datos["horaPartidaGrupal"] ?? '';

    // Extraer información del jugador principal
    $jugadores = [[
        'nick' => $datos["nickJugadorGrupalprincipal"] ?? '',
        'dni' => $datos["dniJugadorGrupalprincipal"] ?? '',
        'nombre' => $datos["nombreJugadorGrupalprincipal"] ?? '',
        'apellido1' => $datos["apellido1JugadorGrupalprincipal"] ?? '',
        'apellido2' => $datos["apellido2JugadorGrupalprincipal"] ?? '',
        'telefono' => $datos["telefonoJugadorGrupalprincipal"] ?? '',
        'email' => $datos["emailGrupalprincipal"] ?? ''
    ]];

    // Jugadores adicionales
    if (isset($datos['jugadores']) && is_array($datos['jugadores'])) {
        foreach ($datos['jugadores'] as $jugadorJson) {
            $jugador = json_decode($jugadorJson, true);
            if ($jugador) {
                $jugadores[] = [
                    'nick' => $jugador['nick'] ?? '',
                    'dni' => $jugador['dni'] ?? '',
                    'nombre' => $jugador['nombre'] ?? '',
                    'apellido1' => $jugador['apellido1'] ?? '',
                    'apellido2' => $jugador['apellido2'] ?? '',
                    'telefono' => $jugador['telefono'] ?? '',
                    'email' => $jugador['email'] ?? ''
                ];
            }
        }
    }

    // Validaciones
    $errores = [];

    foreach ($jugadores as $index => $jugador) {
        $num = $index + 1;

        if (empty($jugador['nick'])) {
            $errores[] = "El Nick del jugador nº $num es obligatorio.";
            continue;
        }

        if (empty($jugador['email'])) {
            $errores[] = "El email del jugador nº $num es obligatorio.";
            continue;
        }

        if (!preg_match($erCorreo, $jugador['email'])) {
            $errores[] = "El email del jugador nº $num no es válido.";
            continue;
        }

        if (empty($jugador['telefono'])) {
            $errores[] = "El teléfono del jugador nº $num es obligatorio.";
            continue;
        }

        if (!preg_match($erTelefono, $jugador['telefono'])) {
            $errores[] = "El teléfono del jugador nº $num no es válido.";
            continue;
        }

        if (empty($jugador['dni']) || !preg_match($erDNI, $jugador['dni'])) {
            $errores[] = "El DNI del jugador nº $num no es válido.";
            continue;
        }

        $datosJugador = obtenerJugadorPorDNI($conexion, $jugador['dni']);
        if (!$datosJugador) {
            $errores[] = "El jugador nº $num no está registrado.";
            continue;
        }

        if (verificarJugadorRegistrado($conexion, $idPartida, $jugador['dni'])) {
            $errores[] = "El jugador nº $num ya está inscrito en esta partida.";
            continue;
        }
    }

    // Si hubo errores de validación
    if (!empty($errores)) {
        echo json_encode(['mensajeError' => true, 'errores' => $errores]);
        return;
    }

    // Verificar espacio disponible en la partida
    $totalJugadores = obtenerNumeroJugadoresPorPartida($conexion, $idPartida);
    if (($totalJugadores + count($jugadores)) > $numeroJugadores) {
        echo json_encode([
            'mensajeError' => true,
            'mensaje' => 'No hay espacio suficiente en la partida para todos los jugadores.'
        ]);
        return;
    }

    // Insertar en la base de datos
    foreach ($jugadores as $index => $jugador) {
        $resultado = insertarReserva(
            $conexion,
            $idPartida,
            $jugador['dni'],
            $jugador['nick'],
            $jugador['nombre'],
            $jugador['apellido1'],
            $jugador['apellido2'],
            $jugador['telefono'],
            $precioPartida,
            $jugador['email']
        );
    
        if ($resultado['mensajeError']) {
            $errores[] = "Error al registrar el jugador nº " . ($index + 1) . ": " . $resultado['mensaje'];
        }
    }

    // Si hubo errores en inserción
    if (!empty($errores)) {
        echo json_encode(['mensajeError' => true, 'errores' => $errores]);
        return;
    }

    echo json_encode(['mensajeError' => false, 'mensaje' => 'Partida reservada con éxito.']);
}





// -----------------------------------------------  SEGUIR CORRIGIENDO DESDE AQUI------------------------------
// -----------------------------------------------  SEGUIR CORRIGIENDO DESDE AQUI------------------------------
// -----------------------------------------------  SEGUIR CORRIGIENDO DESDE AQUI------------------------------
// -----------------------------------------------  SEGUIR CORRIGIENDO DESDE AQUI------------------------------
// -----------------------------------------------  SEGUIR CORRIGIENDO DESDE AQUI------------------------------
// -----------------------------------------------  SEGUIR LLEVANDOTE LAS SELECT Y QUERIS AL CONEXION.PHP------------------------------


// FUNCION PARA DESAPUNTARSE DE UNA PARTIDA
function DesapuntarsePartida($conexion) {
    // Validar el ID de la partida recibido
    $idReserva = mysqli_real_escape_string($conexion, $_POST['idReserva']);
    
    // Verificar si existe una reserva para ese jugador y partida
    $reserva = obtenerReservaPorID($conexion, $idReserva);

    if ($reserva === null) {
        echo json_encode(array('mensajeError' => true, 'mensaje' => 'No se encontró la reserva para la partida.'));
        return;
    }

    // Obtener los valores de la reserva
    $datosCancelacion = [
        'idPartida' => $reserva['idPartida'],  // ID de la partida
        'idReserva' => $reserva['idReserva'],  // ID de la reserva
        'dniJugador' => $reserva['dniJugador'],  // DNI del jugador
        'nombreJugador' => $reserva['nombreJugador'],  // Nombre del jugador
        'nickJugador' => $reserva['nickJugador'],  // Nick del jugador
        'apellido1Jugador' => $reserva['apellido1Jugador'],  // Primer apellido del jugador
        'apellido2Jugador' => $reserva['apellido2Jugador'],  // Segundo apellido del jugador
        'telefonoJugador' => $reserva['telefonoJugador'],  // Teléfono del jugador
        'precioPartida' => $reserva['precioPartida'],  // Precio de la partida
        'email' => $reserva['email'],  // Email del jugador
        'fechaReserva' => date('Y-m-d H:i:s', strtotime($reserva['fechaReserva'])),  // Formatear fecha de la reserva
        'fechaCancelacion' => date('Y-m-d H:i:s')  // Fecha y hora actuales
    ];

    // Insertar la cancelación
    $resultadoCancelacion = insertarCancelacion($conexion, $datosCancelacion);

    if ($resultadoCancelacion['mensajeError']) {
        echo json_encode($resultadoCancelacion);
        return;
    }

    // Eliminar la reserva
    $resultadoEliminacion = eliminarReserva($conexion, $idReserva);

    echo json_encode($resultadoEliminacion);
}




?>