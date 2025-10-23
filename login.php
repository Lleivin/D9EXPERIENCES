<?php
session_start();
// Llamada a la conexión a la BBDD
require_once "conexion.php";
require_once "cronActualizarPartidas.php"; // Asegúrate de que el nombre y la ruta sean correctos
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
// Inicializar variables
$sesionDNIJugador = $_SESSION["sesionJugador"] ?? "";
$sesionDNIAdmin = $_SESSION["sesionAdmin"] ?? "";

// Variables para almacenar datos del usuario
$dniJugador = $nickJugador = $nombreJugador = $apellido1Jugador = $apellido2Jugador = $contrasenaJugador = $telefonoJugador = $email = $estadoJugador = $fechaNacimiento = "";
$dniAdmin = $nickAdmin = $nombreAdmin = $apellido1Admin = $apellido2Admin = $contrasenaAdmin = $telefonoAdmin = $emailAdmin = "";

// Comprobar sesión y obtener datos del usuario para su uso
if ($sesionDNIJugador) {
    $datosJugador = obtenerJugadorPorDNI($conexion, $sesionDNIJugador);
    if ($datosJugador) {
        // Asignar datos del jugador
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
} elseif ($sesionDNIAdmin) {
    $datosAdmin = obtenerAdministradorPorDNI($conexion, $sesionDNIAdmin);
    if ($datosAdmin) {
        // Asignar datos del administrador
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
          <div class="parteburger"><a href="#">D9Experiences</a></div>
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


      <section class="sectionLogin sectionLogin" >

              <!-- -----------LOGEARSE----------- -->

      <div class="cajaLogin" id="cajaLogin">
        
        <form id="formLoginUsuario" class="formLogin" action="" method="POST">
            <h4 class="d-flex m-auto col-12 col-sm-12">Accede a tu cuenta</h4>

          <div class="cajaformulario">
            <label for="">Correo: </label>
            <input class="usuario" type="email" id="usuarioJugador" name="usuarioJugador"
                placeholder="Correo@ejemplo.com">
          </div>

          <div class="cajaformulario">
            <label for="">Contraseña: </label>
            <input class="passwordProfe usuario" type="password" id="passwordUsuario" name="passwordUsuario" placeholder="Contraseña">
          </div>

          <div id="cajaMensajeErrorNewsletter">
            <!-- //Menjsae de error validacion (DOM) -->
          </div>

          <div class="cajaBotonForm">
            <input class="boton" type="submit" id="btn_entrar" name="entrar" value="Entrar" onclick="logearUsuario()"
                >
          </div>

          <div id="cajaMensajeErrorLogearUsuario" class="d-flex flex-wrap col-12 col-sm-12 text-center pl-3 pr-3">
          </div>

          <div class="cambiarLogin">
            <p>Si aun no tienes cuenta, <br> puedes <span id="mostrarCajaAlta">crear una cuenta</span> </p>
          </div>

        </form>

        
      </div>


      <!-- ------------------DARSE DE ALTA----------------- -->
      <div class="cajaLogin" id="cajaAlta">
        
        <form id="formCrearUsario" class="formLogin" action="" method="POST">
            <h4 class="d-flex m-auto col-12 col-sm-12">Darse de alta</h4>

          <div class="cajaformulario">
            <label for="">DNI<span>*</span>: </label>
            <input id="AltaDNI" class="usuario" type="text" id="nuevoDNIJugador" name="nuevoDNIJugador"
                placeholder="********X o X*******X">
          </div>

          <div class="cajaformulario">
            <label for="">Nombre<span>*</span>: </label>
            <input id="AltaNombre" class="usuario" type="text" id="nuevoNombreJugador" name="nuevoNombreJugador"
                placeholder="Juan">
          </div>

          <div class="cajaformulario">
            <label for="">Primer Apellido: </label>
            <input id="AltaApellido" class="usuario" type="text" id="nuevoApellido1Jugador" name="nuevoApellido1Jugador"
                placeholder="López">
          </div>

          <div class="cajaformulario">
            <label for="">Segundo Apellido: </label>
            <input id="AltaApellido2" class="usuario" type="text" id="nuevoApellido2Jugador" name="nuevoApellido2Jugador"
                placeholder="García">
          </div>

          <div class="cajaformulario">
            <label for="">Fecha de Nacimiento: </label>
            <input id="AltaFechaNacimiento" class="usuario" type="date" id="nuevoFechaNacimiento" name="nuevoFechaNacimiento"
                placeholder="García">
          </div>

          <div class="cajaformulario">
            <label for="">Nick<span>*</span>: </label>
            <input id="AltaNick" class="usuario" type="text" id="nuevoNickJugador" name="nuevoNickJugador"
                placeholder="NickJugador001">
          </div>

          <div class="cajaformulario">
            <label for="">Correo electrónico<span>*</span>: </label>
            <input id="AltaEmail" class="usuario" type="email" id="nuevoEmailJugador" name="nuevoEmailJugador"
                placeholder="Correo@ejemplo.com">
          </div>

          <div class="cajaformulario">
            <label for="">Teléfono<span>*</span>: </label>
            <input id="AltaTelefono" class="usuario" type="tel" id="nuevoTelefonoJugador" name="nuevoTelefonoJugador"
                placeholder="(+34) 66****617">
          </div>

          <div class="cajaformulario">
            <label for="">Contraseña<span>*</span>: </label>
            <input id="AltaPassword" class="passwordProfe usuario" type="password" id="nuevaContrasenaJugador" name="nuevaContrasenaJugador" placeholder="XXXXX1234!">
            <!-- <button id="togglePassword">Mostrar</button> -->
          </div>

          <div class="cajaformulario">
            <label for="">Repetir Contraseña<span>*</span>: </label>
            <input id="AltaRepetirPassword" class="passwordProfe usuario" type="password" id="nuevaContrasenaJugador" name="nuevaContrasenaJugador" placeholder="XXXXX1234!">
            <!-- <button id="toggleRepetirPassword">Mostrar</button> -->
          </div>

          <div class="cajaBotonForm">
            <input class="boton" type="submit" id="btn_crearUsuario" name="entrar" value="Crear cuenta">
          </div>

          <div id="cajaMensajeErrorAltaUsuario" class="d-flex flex-wrap col-12 col-sm-12 justify-content-center text-center pl-3 pr-3">
          </div>

          <div class="cambiarLogin">
            <p>Si ya tienes cuenta, <br> <span id="mostrarCajalogin">accede a tu cuenta</span> </p>
          </div>

        </form>
      </div>


      </section>

    </div>
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
</script>

  </body>
</html>
