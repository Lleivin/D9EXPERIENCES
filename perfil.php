<?php
session_start();
// Llamada a la conexión a la BBDD
require_once "conexion.php";
require_once "cronActualizarPartidas.php"; // Asegúrate de que el nombre y la ruta sean correctos
require_once "otrasFunciones.php"; // Asegúrate de que el nombre y la ruta sean correctos
// Llamar a la función para actualizar el estado de las partidas
$partidasActualizadas = actualizarEstadoPartidas($conexion);


// Comprobar si existe la sesión del jugador
if (isset($_SESSION["sesionJugador"]) && !empty($_SESSION["sesionJugador"])) {
    $sesionDNIJugador = $_SESSION["sesionJugador"];
    $datosJugador = obtenerJugadorPorDNI($conexion, $sesionDNIJugador);

    if ($datosJugador) {
        $dniJugador = $datosJugador['dniJugador'];
    } else {
        $dniJugador = null; // Definir por si el jugador no existe en la base de datos
    }
} else {
    $dniJugador = null; // No hay sesión activa para el jugador
}

// Inicializar variables predeterminadas
$sesionDNIJugador = $_SESSION["sesionJugador"] ?? "";
$sesionDNIAdmin = $_SESSION["sesionAdmin"] ?? "";
$contrasenaJugador = $contrasenaAdmin = ""; // Asegurarse de inicializar

// Datos del jugador
if ($sesionDNIJugador) {
    $datosJugador = obtenerJugadorPorDNI($conexion, $sesionDNIJugador);
    if ($datosJugador) {
        $dniJugador = $datosJugador['dniJugador'];
        $nickJugador = $datosJugador['nickJugador'];
        $nombreJugador = $datosJugador['nombreJugador'];
        $apellido1Jugador = $datosJugador['apellido1Jugador'];
        $apellido2Jugador = $datosJugador['apellido2Jugador'];
        $contrasenaJugador = $datosJugador['contrasenaJugador'];
        $telefonoJugador = $datosJugador['telefonoJugador'];
        $email = $datosJugador['email'];
        $estadoJugador = $datosJugador['estadoJugador'];
        $fechaNacimiento = date("d-m-Y", strtotime($datosJugador['fechaNacimiento']));
    }
}

// Datos del administrador
if ($sesionDNIAdmin) {
    $datosAdmin = obtenerAdministradorPorDNI($conexion, $sesionDNIAdmin);
    if ($datosAdmin) {
        $dniAdmin = $datosAdmin['dniAdmin'];
        $nickAdmin = $datosAdmin['nickAdmin'];
        $nombreAdmin = $datosAdmin['nombreAdmin'];
        $apellido1Admin = $datosAdmin['apellido1Admin'];
        $apellido2Admin = $datosAdmin['apellido2Admin'];
        $contrasenaAdmin = $datosAdmin['contrasenaAdmin'];
        $telefonoAdmin = $datosAdmin['telefonoAdmin'];
        $emailAdmin = $datosAdmin['emailAdmin'];
    }
}



// Enmascarar contraseñas
$contrasenaJugadorEnmascarada = enmascararContrasena($contrasenaJugador);
$contrasenaAdminEnmascarada = enmascararContrasena($contrasenaAdmin);

?>

<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- LINK ESTILOS -->
    <link rel="stylesheet" href="estilos/estilo.css" />
    <!-- Enlace con FONTAWESOME -->
    <script
      src="https://kit.fontawesome.com/ea7d8023a5.js"
      crossorigin="anonymous"
    ></script>
    <!-- BOOSTRAP-->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi"
      crossorigin="anonymous"
    />

    <!-- JAVASCRIPT -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">

    <title>HOME</title>
  </head>

  <body>

   
    <div class="contenedor"></div>


<!-- CAJA PARA SESION -->

<?php
if (isset($_SESSION["sesionJugador"])) {
    echo '<div class="cajaSesion">
            <a href="perfil.php">
                <p>JUGADOR:</p> &nbsp;' . htmlspecialchars(ucwords($nickJugador)) . '
            </a>

          </div>';
} elseif(isset($_SESSION["sesionAdmin"])){
  echo '<div class="cajaSesion">
  <a href="perfil.php">
      <p>Administrador:</p> &nbsp;' . htmlspecialchars(ucwords($nickAdmin)) . '
  </a>
</div>';
}
?>
  
  <!-- --------------------------NAVEGADORES RESPONSIVES -->
  <nav>
    <!-- MENU MOVIL -->
    <div class="navegadorMovil">
      <div class="parteNav">
        <a href="index.php"><img src="img/LOGOTIPO.png" alt="logotipo" /></a>
      </div>

      <div class="parteNav" onclick="toggleSubMenu()" onclick="toggleSubMenu()">
        <img src="img/menu.png" alt="burger" />

        <div class="submenu" id="submenu">
          <div class="parteburger"><a href="index.php">D9Experiences</a></div>
          <!-- Nuevo submenú -->
          <div class="subsubmenu" id="subsubmenu">
            <div class="partesubBurger"><a href="distripo9.php">Distrito 9</a></div>
            <div class="partesubBurger"><a href="enlave.php">El Enclave</a></div>
          </div>
          <!-- Fin del nuevo submenú -->
          <div class="parteburger"><a href="partidas.php">Partidas</a></div>
          <div class="parteburger"><a href="galeria.php">Galería</a></div>

          <?php
if (isset($_SESSION["sesionAdmin"])){
  echo '<div class="parteburger">
  <a href="administracion.php">
      Servicios y Gestiones
  </a>
</div>';
}
?>

        </div>
      </div>

      <div class="cajaInfoSesiones">

          <div class="logoSesion">
            <?php if (isset($_SESSION['sesionJugador'])): ?>
                <a href="login.php"><img src="img/soldado.png" alt="Jugador Activo" /></a>
            <?php elseif (isset($_SESSION['sesionAdmin'])): ?>
                <a href="login.php"><img src="img/general.png" alt="Administrador Activo" /></a>
            <?php else: ?>
                <a href="login.php"><img src="img/usuario.png" alt="Usuario" /></a>
            <?php endif; ?>
          </div>

          <div>
          <!-- <div class="logoSesionOrdena"><a href="cerrar"><img src="img/salir.png" alt="burger"></a></div> -->
          <form class="formSalir" method="post" action="logout.php">
            <button class="boton_cerrarSesion" type="submit"><img src="img/salir.png" alt="CerrarSesion"></button>
          </form>
          </div>
        
      </div>

    </div>

    <!-- MENU ORDENADOR -->
    <div class="navegadorOrdenador" id="cajaDesplegableOrdenador">

      <div class="parteNavOrdena d-flex col-md-2 ">
        <a href="index.php"><img src="img/LOGOTIPO.png" width="80px" height="80px" alt="logotipo"></a>
      </div>

      <div class="cajaEnlacesOrdena d-flex col-md-8 ">
        <div class="enlacesMenuOrde" id="enlaceMenuD9experiences"><a href="index.php"> D9Experiences</a></div>
        <!-- Submenú desplegable -->
        <div class="submenuDesplegable" id="submenuDesplegable">
          <div class="enlacesSubMenuOrde"><a href="distrito9.php">Distrito 9</a></div>
          <div class="enlacesSubMenuOrde"><a href="enclave.php">El Enclave</a></div>
        </div>
        <!-- Submenú FIN -->
        <div class="enlacesMenuOrde"><a href="partidas.php"> Partidas</a></div>
        <div class="enlacesMenuOrde"><a href="galeria.php"> Galería</a></div>

        <?php
if (isset($_SESSION["sesionAdmin"])){
  echo '<div class="enlacesMenuOrde">
  <a href="administracion.php">
      Servicios y Gestiones
  </a>
</div>';
}
?>

      </div>

      <div class="cajaInfoSesiones">

          <div class="logoSesion">
            <?php if (isset($_SESSION['sesionJugador'])): ?>
                <a href="login.php"><img src="img/soldado.png" alt="Jugador Activo" /></a>
            <?php elseif (isset($_SESSION['sesionAdmin'])): ?>
                <a href="login.php"><img src="img/general.png" alt="Administrador Activo" /></a>
            <?php else: ?>
                <a href="login.php"><img src="img/usuario.png" alt="Usuario" /></a>
            <?php endif; ?>
          </div>

          <div>
          <!-- <div class="logoSesionOrdena"><a href="cerrar"><img src="img/salir.png" alt="burger"></a></div> -->
          <form class="formSalir" method="post" action="logout.php">
            <button class="boton_cerrarSesion" type="submit"><img src="img/salir.png" alt="CerrarSesion"></button>
          </form>
          </div>
        
      </div>

    </div>

  </nav>


    <main>


<!-- DATOS DE PERFIL -->
    <section class="seccionPerfil">
    <div class="cajaPerfil">
        <?php if ($sesionDNIJugador): ?>
          <div class="tituloPerfil">            
            <h3>Jugador: &nbsp;&nbsp;&nbsp; <?php echo $nickJugador ?></h3>
            <div class="d-flex botoneraEdit">
            <button id="editarPerfil"><i class="fa-regular fa-pen-to-square"></i></button>
            <button id="eliminarPerfilBtn"><i class="fa-solid fa-trash-can"></i></button></div>
                    </div>
          
            <div class="datosJugador">
                <p><b>Nombre</b>:&nbsp;&nbsp;&nbsp; <?php echo $nombreJugador ?></p>
                <p><b>Apellidos</b>:&nbsp;&nbsp;&nbsp; <?php echo $apellido1Jugador . '&nbsp;' . $apellido2Jugador; ?></p>
                <p><b>DNI/NIF</b>:&nbsp;&nbsp;&nbsp; <?php echo $dniJugador ?></p>
                <p><b>Teléfono</b>:&nbsp;&nbsp;&nbsp; <?php echo $telefonoJugador ?></p>
                <p><b>Correo</b>:&nbsp;&nbsp;&nbsp; <?php echo $email ?></p>
                <p><b>Fecha Nacimiento</b>:&nbsp;&nbsp;&nbsp; <?php echo $fechaNacimiento ?></p>
                <p><b>Estado del Jugador</b>:&nbsp;&nbsp;&nbsp; <?php echo $estadoJugador ?></p>
                <p><b>Contraseña</b>:&nbsp;&nbsp;&nbsp; <?php echo $contrasenaJugadorEnmascarada?></p>
            </div>
        <?php elseif ($sesionDNIAdmin): ?>
            <h3>Administrador: &nbsp;&nbsp;&nbsp; <?php echo $nickAdmin ?></h3>
            <div class="datosJugador">
                <p><b>Nombre</b>:&nbsp;&nbsp;&nbsp; <?php echo $nombreAdmin ?></p>
                <p><b>Apellidos</b>:&nbsp;&nbsp;&nbsp; <?php echo $apellido1Admin . '&nbsp;' . $apellido2Admin; ?></p>
                <p><b>DNI/NIF</b>:&nbsp;&nbsp;&nbsp; <?php echo $dniAdmin ?></p>
                <p><b>Teléfono</b>:&nbsp;&nbsp;&nbsp; <?php echo $telefonoAdmin ?></p>
                <p><b>Correo</b>:&nbsp;&nbsp;&nbsp; <?php echo $emailAdmin ?></p>
                <p><b>Contraseña</b>:&nbsp;&nbsp;&nbsp; <?php echo $contrasenaAdminEnmascarada?></p>
                       </div>
        <?php else: ?>
            <p>No hay sesión activa.</p>
        <?php endif; ?>
    </div>




    <!-- FORMULARIO MODIFICAR -->
    <div id="formularioModificar" class="cajaPerfil cajaperfilActualiza d-none">

    <form id="formModificarJugador" class="cajaperfilActualiza" action="perfil.php" method="POST">
    <input class="d-none" id="dniSesionActivaJugadormodificar" name="dniSesionActivaJugadormodificar" value="<?php echo htmlspecialchars($sesionDNIJugador ? $dniJugador : ($sesionDNIAdmin ? $dniAdmin : '')); ?>">

    <h4 class="d-flex m-auto col-12 col-sm-12">Modificar Jugador</h4>

    <div class="cajaformulario">
        <label for="actualizaNombre">Nombre: </label>
        <input id="actualizaNombre" class="usuario" type="text" name="nuevoNombreJugador" value="<?= htmlspecialchars($nombreJugador) ?>">
    </div>

    <div class="cajaformulario">
        <label for="actualizaApellido">Primer Apellido: </label>
        <input id="actualizaApellido" class="usuario" type="text" name="nuevoApellido1Jugador" value="<?= htmlspecialchars($apellido1Jugador) ?>">
    </div>

    <div class="cajaformulario">
        <label for="actualizaApellido2">Segundo Apellido: </label>
        <input id="actualizaApellido2" class="usuario" type="text" name="nuevoApellido2Jugador" value="<?= htmlspecialchars($apellido2Jugador) ?>">
    </div>

    
    <!-- <div class="cajaformulario">
        <label for="actualizaFecha">Fecha de Nacimiento: </label>
        <input id="actualizaFecha" class="usuario" type="date" name="nuevoFechaNacimiento" value="<?= htmlspecialchars($fechaNacimiento) ?>">
    </div> -->

    <div class="cajaformulario">
        <label for="actualizaNick">Nick: </label>
        <input id="actualizaNick" class="usuario" type="text" name="nuevoNickJugador" value="<?= htmlspecialchars($nickJugador) ?>">
    </div>

    <div class="cajaformulario">
        <label for="actualizaTelefono">Teléfono: </label>
        <input id="actualizaTelefono" class="usuario" type="tel" name="nuevoTelefonoJugador" value="<?= htmlspecialchars($telefonoJugador) ?>">
    </div>

    <div class="cajaformulario">
        <label for="nuevaContrasenaJugador">Nueva Contraseña: </label>
        <input id="nuevaContrasenaJugador" class="passwordProfe usuario" type="password" name="nuevaContrasenaJugador">
    </div>

    <div class="cajaformulario">
        <label for="nuevaContrasenaJugador2">Repite Nueva Contraseña: </label>
        <input id="nuevaContrasenaJugador2" class="passwordProfe usuario" type="password" name="nuevaContrasenaJugador2">
    </div>

    <div class="cajaBotonForm">
        <input class="boton" type="submit" id="btn_actualizarUsuario" name="Actualizar" value="Actualizar">
    </div>

    <div id="cajaMensajeErrorActualizarJugador" class="d-flex flex-wrap col-12 col-sm-12 text-center pl-3 pr-3"></div>

    <p class="d-flex m-auto p-4">*El DNI y el Correo Electrónico, son campos de identificación única, y no pueden ser modificados.
        Para realizar un cambio sobre estos datos, cree una cuenta nueva o contacte con el administrador
    </p>
</form>



    </div>




  <!-- Overlay para difuminar el resto del HTML -->
<div id="overlay" class="d-none"></div>
<article class="cajaEliminarPerfil d-none" id="eliminarPerfilCaja">
        <div class="tituloBorrarPerfil">
            <h3>Eliminar Perfil</h3>
            <p>*Una vez eliminado el perfil de jugador, este deberá crear una cuenta nueva para poder registrarse a las partidas.</p>
        </div>
        <div class="seleccionOpciones">
            <button class="boton" id="aceptarEliminar">Sí</button>
            <button class="boton" id="cancelarEliminar">No</button>
        </div>

        <div id="cajaMensajeErrorEliminarPerfil" class="d-flex flex-wrap col-12 col-sm-12 text-center pl-3 pr-3"></div>
    </article>






<!-- MOSTRAR PARTIDAS A LAS QUE SE ESTÁ ISNCRITO si eres jugador -->
<?php
if (!empty($sesionDNIJugador) && empty($sesionDNIAdmin)): // Solo si es sesión de jugador
?>


<article>

<div class="tituloPartidas">
<h3>Mis partidas</h3>
</div>

<article class="partidasTipo">

        <?php
  
        //   FUNCION OBTENER PARTIDAS RESERVADAS(pendientes/cancelas)
        $partidasReservadas = obtenerPartidasReservadas($conexion, $dniJugador);


        // Comprobar si hay partidas pendientes o canceladas
        if($partidasReservadas && mysqli_num_rows($partidasReservadas) > 0) {
            // Recorrer las partidas y mostrarlas en formato de tarjeta (card)
            while($partida = mysqli_fetch_assoc($partidasReservadas)) {

              // LLAMADA A FUNCION PARA CONTAR NUMERO JUGADORES POR PARTIDA
              $numeroIdPartida = $partida['idPartida'];  // Asume que el idPartida está en el array de cada partida
              $numeroJugadoresApuntados = obtenerNumeroJugadoresPorPartida($conexion, $numeroIdPartida);

              // Máximo de jugadores para esa partida
              $jugadoresMaximoPartida = $partida['numeroJugadores'];


              // Determina si el botón debe estar deshabilitado
              $esPartidaCompleta = $numeroJugadoresApuntados >= $jugadoresMaximoPartida;

                // Añadir clase "cancelada" si el estado es "Cancelada"
                $claseCancelada = ($partida['estadoPartida'] == 'Cancelada') ? 'cancelada' : '';

                // Obtener la imagen de DRIVE y convertirla si es de Google Drive
        $imagenPartida = $partida['imagenPartida'];

        // Verificar si es una URL de Google Drive y convertirla a una imagen directa
        if (preg_match('/^https:\/\/drive\.google\.com\/file\/d\/(.*?)\//', $imagenPartida, $matches)) {
            // Convertir la URL de Google Drive a una URL directa de imagen
            $imagenPartida = 'https://drive.google.com/uc?export=view&id=' . $matches[1];
        }

                ?>
                <div id="card-<?php echo $partida['idPartida']; ?>" class="cardPartida col-12 col-sm-6 col-md-3 col-lg-3 col-xl-2  <?php echo $claseCancelada; ?>"
                style="background-image: url('<?php echo htmlspecialchars($imagenPartida); ?>'); background-size: cover; background-position: center;">
                    <!-- Tarjeta con información inicial -->
                    <div class="card-content">
                        <p class="text-left"> <strong>Partida:</strong>  <br> </p>
                        <p class="text-center"> <?php echo $partida['nombrePartida']; ?></p>
                        <p><strong>Campo:</strong> <?php echo $partida['nombreCampo']; ?></p>
                        <p><strong>Fecha:</strong> <?php $fecha = new DateTime($partida['fecha']);echo $fecha->format('d-m-Y');?></p>
                        <p><strong>Precio:</strong> <?php echo $partida['precioPartida']; ?>€</p>
                        <p><strong>Plazas:</strong> <?= htmlspecialchars($numeroJugadoresApuntados) ?><?= $jugadoresMaximoPartida ? " / " . htmlspecialchars($jugadoresMaximoPartida) : '' ?></p>
                        <button class="btninforPartida" onclick="mostrarInformacion(<?php echo $partida['idPartida']; ?>)"><strong><i class="fa-solid fa-circle-info"></i>&nbsp;Info</strong></button>


                        <!-- //BOTON PARA DESAPUNTARSE PARTIDA -->
                    <button  
                        class="btn btn-danger Desapuntarse d-flex m-3" 
                        style="background-color: red; border-color: red;" 
                        data-reserva="<?php echo htmlspecialchars($partida['idReserva'], ENT_QUOTES, 'UTF-8'); ?>"
                        <?php echo ($partida['estadoPartida'] == 'Cancelada') ? 'disabled' : ''; ?>>
                        <?php echo ($partida['estadoPartida'] == 'Cancelada') ? 'Partida Cancelada' : 'Desapuntarse'; ?>
                    </button>


                    </div>

                    <!-- Información adicional (oculta inicialmente) -->
                    <div class="extra-info" style="display:none;">
                        <p><strong>Descripción:</strong></p>
                        <p class="d-flex flex-wrap infoPartida"><?php echo $partida['descripcionPartida'];?></p>
                        <button class="btninforPartida" onclick="ocultarInformacion(<?php echo $partida['idPartida']; ?>)"><strong><i class="fa-solid fa-circle-xmark"></i></strong></button>
                    </div>
                </div>
                <?php
            }
        } else {
          echo '
          <div class="row justify-content-center cajaMensajeSinPartidas col-12 col-md-8">
    <div class="col-12 col-md-8">
        <div class="message text-center">
            <p>
                Aún no te has apuntado a ninguna partida <br> 
                <a class="enlace text-decoration-none mt-4" href="partidas.php">
                    Echa un vistazo a nuestras <span>Partidas</span>
                </a>
            </p>
        </div>
    </div>
</div>
';        }
        ?>

    </article>


</article>
<?php
else:
    echo "<p>*El administrador no puede apuntarse a una partida desde el perfil de administrador.</p>";
endif;
?>

<!-- Overlay para difuminar el resto del HTML -->
<!-- Este es el código HTML para el overlay y el cuadro de confirmación -->
<div id="adminoverlay" class="d-none"></div>
<section class="cajaEliminarPerfil d-none" id="jugadorEliminarReserva">
    <div class="tituloBorrarPerfil">
        <h3>Desapuntarse</h3>
        <p>*Una vez desapuntado de la partida, deberá volver a apuntarse si desea inscribirse. Tenga en cuenta que puede quedarse sin plazas durante el proceso si la demanda es alta.</p>
    </div>
    <div class="seleccionOpciones">
        <button class="boton adminEliminarPartidaSelec jugadorDesapuntarPartidaSelec" id="adminaceptarEliminarReserva">Sí</button>
        <button class="boton" id="jugadorcancelarEliminarReserva">No</button>
    </div>

    <div id="cajaMensajeErrorJugadorEliminarReserva" class="d-flex flex-wrap col-12 col-sm-12 text-center pl-3 pr-3"></div>
</section>



<!-- MENSAJES DE RESERVAS JUGADOR -->
<!-- //-----------------MENSAJE: JUGADOR ELIMINADO -->
<div id="adminoverlay2" class="d-none"></div>
<section class="cajaEliminarPerfil d-none" id="mensajeJugadorDesapuntadoPartida">
    <div class="tituloBorrarPerfil">
        <h3>Jugador desapuntado con éxito</h3>
        <p id="mensajeDesapuntadoJugador"></p>
    </div>
</section>


<!-- FIN DE SECCION PERFIL -->
</section>



    </main>

       <!-- --------------------------FOOTER -->

       <footer class="footer d-flex col-12">

        <div class="enlacesFooter">
            <a href="#">D9Experiences</a>
            <a href="#">Partidas</a>
            <a href="#">Eventos</a>
            <a href="#">Reservar</a>
            <a href="#">Organizadores</a>
            <a href="#">Contacto</a>
            <a href="#">¿Quieres Colaborar?</a>
            <a href="loginAdmin.php">Administrador</a>
        </div>

        <div class="redesSociales">
          <a href="index.php"><img src="img/whatsapp.png" alt="Whatsaap"></a>
          <a href="index.php"><img src="img/youtube.png" alt="youtube"></a>
          <a href="index.php"><img src="img/instagram.png" alt="instagram"></a>
          <a href="index.php"><img src="img/tik-tok.png" alt="tiktok"></a>
        </div>

        <div class="cajanewsLetter">

          <div class="mensajeNewsletter">
            <h3>NEWSLETTER</h3>
            <p>Si quieres recibir información sobre todos nuestros eventos, apuntate a nuestra Newsletter y recibe todas nuestras notificaciones por correo electrónico</p>
          </div>

          <form id="formularioNewsletter" class="formularioNewsletter" action="" method="POST">
            <!-- Checkbox para aceptar los términos y condiciones -->
            <div class="terminosCondiciones">
                <input type="checkbox" id="aceptoTerminos" name="aceptoTerminos" value="1"> Acepto <a href="#">Términos y Condiciones</a>
            </div>
            <!-- Campos para ingresar el correo electrónico y enviar el formulario -->
            <div class="cajaDatosNewsletter">
                <input class="datosNewsletter correoNews d-flex col-8" type="email" id="emailAltaBajaNewsletter" name="emailAltaBajaNewsletter" placeholder="Correo@ejemplo.com">
                <input class="datosNewsletter enviarNewsletter d-flex col-4" id="altaNewslatter" name="altaNewslatter" type="button" onclick="procesarNewsletter()" value="Enviar">
            </div>
        </form>

        <div id="respuestaProcesarNewsletter">
        </div>
  
        <div class="darseBajaNewsletter">
          <p>Para darse de baja de nuestro Newsletter, <a href="bajaNewsletter.php">pinche aquí</a></p>
        </div>

        </div>
          


        <div class="partner d-flex flex-wrap">

          <div class="col-12 col-sm-12 col-md-6">
            <a href="index.php"><img src="img/d9_experiences_fondo_negro.png" alt="LogotipoD9"></a>
          </div>

          <div class="d-flex flex-wrap p-3 col-12 col-sm-12 col-md-6">
            <p>D9Experiences es una organización privada lucrativa registrada en el registro de propiedades intelectuales y convenio de empresas.</p>
            <p>Todas las imágenes y videos son de uso propio y registradas en el registro de propiedad intelectual. El uso indevido de dichas imágenes podrá suponer motivo de delito contra la propiedad intelectual.</p>
            <p>@D9Experiences Registro Territoral</p>

          </div>
        </div>

      </footer>



      

<?php

if (isset($_POST['actualizarJugador'])) {
  $nickJugador = mysqli_real_escape_string($conexion, $_POST['nickJugador']);
  $nombreJugador = mysqli_real_escape_string($conexion, $_POST['nombreJugador']);
  // Aquí debes procesar los demás campos necesarios

  // Ejemplo de consulta SQL para actualizar un jugador
  $query = "UPDATE jugadores SET nickJugador='$nickJugador', nombreJugador='$nombreJugador', ... WHERE dniJugador='$sesionDNIJugador'";
  $result = mysqli_query($conexion, $query);

  if ($result) {
      echo "Jugador actualizado correctamente";
  } else {
      echo "Error al actualizar jugador: " . mysqli_error($conexion);
  }
}

if (isset($_POST['actualizarAdmin'])) {
  $nickAdmin = mysqli_real_escape_string($conexion, $_POST['nickAdmin']);
  $nombreAdmin = mysqli_real_escape_string($conexion, $_POST['nombreAdmin']);
  // Aquí debes procesar los demás campos necesarios

  // Ejemplo de consulta SQL para actualizar un administrador
  $query = "UPDATE administrador SET nickAdmin='$nickAdmin', nombreAdmin='$nombreAdmin', ... WHERE dniAdmin='$sesionDNIAdmin'";
  $result = mysqli_query($conexion, $query);

  if ($result) {
      echo "Administrador actualizado correctamente";
  } else {
      echo "Error al actualizar administrador: " . mysqli_error($conexion);
  }
}

?>






    

<!-- CONEXIONES -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<!-- JAVAESCRIP -->
<script src="script.js"></script>
<script src="funciones.js"></script>

<!-- //CAMBIAR EL CUADRO DE LOGIN -->
<script>
 $(document).ready(function(){
    // Al cargar la página, ocultar la caja de alta
    $("#cajaAlta").hide();

    // Manejar clic en "crear una cuenta"
    $("#mostrarCajaAlta").click(function(){
        $("#cajaLogin").hide();
        $("#cajaAlta").show();
    });

    // Manejar clic en "accede a tu cuenta" en la caja de alta
    $("#mostrarCajalogin").click(function(){
        $("#cajaAlta").hide();
        $("#cajaLogin").show();
    });
});


document.addEventListener('DOMContentLoaded', function() {
    const editarPerfilBtn = document.getElementById('editarPerfil');
    const formularioModificar = document.getElementById('formularioModificar');
    const eliminarPerfilBtn = document.getElementById('eliminarPerfilBtn');
    const eliminarPerfilCaja = document.getElementById('eliminarPerfilCaja');
    const cancelarEliminarBtn = document.getElementById('cancelarEliminar');
    const overlay = document.getElementById('overlay');

    if (editarPerfilBtn && formularioModificar) {
        editarPerfilBtn.addEventListener('click', function () {
            formularioModificar.classList.toggle('d-none');
        });
    }

    if (eliminarPerfilBtn && eliminarPerfilCaja && overlay) {
        eliminarPerfilBtn.addEventListener('click', function() {
            eliminarPerfilCaja.classList.remove('d-none');
            overlay.classList.remove('d-none');
        });
    }

    if (cancelarEliminarBtn && eliminarPerfilCaja && overlay) {
        cancelarEliminarBtn.addEventListener('click', function() {
            eliminarPerfilCaja.classList.add('d-none');
            overlay.classList.add('d-none');
        });
    }
    // Ocultar el eliminarPerfilCaja y el overlay si se hace clic fuera del section
    if (overlay) {
        overlay.addEventListener('click', function() {
            eliminarPerfilCaja.classList.add('d-none');
            overlay.classList.add('d-none');
        });
    }
});



    // Función para mostrar la descripción
    function mostrarInformacion(idPartida) {
        const card = document.getElementById(`card-${idPartida}`);
        const cardContent = card.querySelector('.card-content');
        const extraInfo = card.querySelector('.extra-info');
        
        // Ocultar el contenido inicial y mostrar la información adicional
        cardContent.style.display = 'none';
        extraInfo.style.display = 'block';
    }

    // Función para ocultar la descripción y volver a la vista inicial
    function ocultarInformacion(idPartida) {
        const card = document.getElementById(`card-${idPartida}`);
        const cardContent = card.querySelector('.card-content');
        const extraInfo = card.querySelector('.extra-info');

        // Mostrar el contenido inicial y ocultar la información adicional
        cardContent.style.display = 'block';
        extraInfo.style.display = 'none';
    }

</script>




<!-- FUNCION DE MENSAJE DE ELIMINAR RESERVA -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Selecciona todos los botones con la clase 'Desapuntarse'.
    const desapuntarseBtn = document.querySelectorAll('.Desapuntarse');
    // 2. Selecciona el botón de confirmación de desapuntarse.
    const adminaceptarEliminarReserva = document.getElementById('adminaceptarEliminarReserva');
    // 3. Selecciona el botón de cancelación de desapuntarse.
    const jugadorcancelarEliminarReserva = document.getElementById('jugadorcancelarEliminarReserva');
    // 4. Selecciona el contenedor de la caja de confirmación de desapuntarse.
    const jugadorEliminarReservaCaja = document.getElementById('jugadorEliminarReserva');
    // 5. Selecciona el overlay (fondo) que aparece detrás de la caja de confirmación.
    const adminoverlay = document.getElementById('adminoverlay');
    // 6. Declara una variable para almacenar el ID de la reserva a eliminar.
    let idReservaParaEliminar = '';

    // 7. Recorre cada botón de desapuntarse y agrega un evento 'click' a cada uno.
    desapuntarseBtn.forEach(function(btn) {
        btn.addEventListener('click', function () {
            // 8. Cuando se hace clic en un botón, guarda el ID de la reserva a eliminar.
            idReservaParaEliminar = this.getAttribute('data-reserva');
            // Imprime el ID en la consola para verificar.
            console.log("ID de la reserva a eliminar:", idReservaParaEliminar);

            // 9. Muestra la caja de confirmación y el overlay quitando la clase 'd-none'.
            jugadorEliminarReservaCaja.classList.remove('d-none');
            adminoverlay.classList.remove('d-none');
        });
    });

    // 10. Evento para confirmar la eliminación: al hacer clic, llama a la función de eliminación.
    adminaceptarEliminarReserva.addEventListener('click', function() {
        console.log('ID de la reserva a eliminar:', idReservaParaEliminar); // Añade esta línea
        // 11. Llama a la función de eliminación con el ID de la reserva a eliminar.
        jugadorEliminarReserva(idReservaParaEliminar);
        
        // 12. Oculta la caja de confirmación y el overlay añadiendo la clase 'd-none'.
        jugadorEliminarReservaCaja.classList.add('d-none');
        adminoverlay.classList.add('d-none');
    });

    // 13. Evento para cancelar la desapuntarse: al hacer clic en el botón "No", oculta la caja y el overlay.
    jugadorcancelarEliminarReserva.addEventListener('click', function() {
        jugadorEliminarReservaCaja.classList.add('d-none');
        adminoverlay.classList.add('d-none');
    });

    // 14. Si se hace clic en el overlay, también se ocultarán la caja y el overlay.
    if (adminoverlay) {
        adminoverlay.addEventListener('click', function() {
            jugadorEliminarReservaCaja.classList.add('d-none');
            adminoverlay.classList.add('d-none');
        });
    }
});


</script>

  </body>
</html>
