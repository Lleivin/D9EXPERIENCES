<?php
session_start();
// Llamada a la conexión a la BBDD
require_once "conexion.php";
require_once "otrasFunciones.php"; // Asegúrate de que el nombre y la ruta sean correctos
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

// Comprobar sesión y obtener datos del usuario
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



// Consultar los datos de la tabla campos
$todosCampos = obtenerTotalCampos($conexion);

// RECIBIR LOS DATOS DE LA PAGINA ANTERIOR
if (isset($_GET['idPartida'])) {
  // Escapar y almacenar el DNI recibido
  $idPartidaSelect = mysqli_real_escape_string($conexion, $_GET['idPartida']);

  // Obtener datos del jugador utilizando la función
  $partidaAmodificar = obtenerPartidaPorIDpartida($conexion, $idPartidaSelect);


}else {
// Mostrar mensaje de error si el DNI no ha sido proporcionado
echo "<p style='color: red;'>No se ha especificado una partida para apuntarse</p> <br> <a href='administracion.php'>Selecciona una partida</a>";
exit;
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
          <div class="parteburger"><a href="index.php">D9Experiences</a></div>
          <!-- Nuevo submenú -->
          <div class="subsubmenu" id="subsubmenu">
            <div class="partesubBurger"><a href="distrito9.php">Distrito 9</a></div>
            <div class="partesubBurger"><a href="enclave.php">El Enclave</a></div>
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
        <div class="enlacesMenuOrde"><a href="ingaleriadex.php"> Galería</a></div>

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



<section class="sectionApuntarsePartida" >

<!-- INICO CAJA APUNTARSE -->
  <div  id="cajaApuntarsePartida" class="cajaApuntarsePartida">

    <!-- ------------------INFO A LA PARTIDA----------------- -->
    <div class="infoApuntarsePartidas ">
    <h4 class="d-flex m-auto mb-3 col-12 col-sm-12">Apuntarse a la Partida</h4>

          <div class="col-12 col-sm-12 col-md-6">
              <div class="infoLabel"><strong>Partida:</strong></div>
              <div class="infoValue"><?=$partidaAmodificar['nombrePartida']?></div>
          </div>

          <div class="col-12 col-sm-12 col-md-6">
              <div class="infoLabel"><strong>Fecha de la partida:</strong></div>
              <div class="infoValue"><?=date("d-m-Y", strtotime($partidaAmodificar['fecha']))?></div>
          </div>

          <div class="col-12 col-sm-12 col-md-6">
              <div class="infoLabel"><strong>Precio de la partida:</strong></div>
              <div class="infoValue"><?=$partidaAmodificar['precioPartida']?>€</div>
          </div>

          <div class="col-12 col-sm-12 col-md-6">
              <div class="infoLabel"><strong>Hora de la partida:</strong></div>
              <div class="infoValue"><?=date("H:i", strtotime($partidaAmodificar['horaPartida']))?></div>
          </div>
  <!-- ------------------FINAL INFO A LA PARTIDA----------------- -->

  <div class="linea-separadora"></div>


  <!-- ------------------FORMULARIO DE PARTIDA INDIVIDUAL----------------- -->

        <form id="formApuntarsePartidas" class="formApuntarsePartidas" action="" method="POST">
            <h4 class="d-flex m-auto col-12 col-sm-12">Inscripción Individual</h4>
        <!-- *****PASAR LOS DATOS DE LA PARTIDA SELECCIONADA**** -->
            <!-- Para saber a cuál IDPAERTIDA has hecho click -->
            <input id="idPartida" class="d-none" type="text" name="idPartida" placeholder="idPartida" value="<?= htmlspecialchars($partidaAmodificar['idPartida']) ?>">
            <!-- Para saber a cuál nombrePartida has hecho click -->
            <input id="nombrePartida" class="d-none" type="text" name="nombrePartida" placeholder="nombrePartida" value="<?= htmlspecialchars($partidaAmodificar['nombrePartida']) ?>">
            <!-- Para saber a cuál fecha has hecho click -->
            <input id="fecha" class="d-none" type="text" name="fecha" placeholder="fecha" value="<?= htmlspecialchars($partidaAmodificar['fecha']) ?>">
            <!-- Para saber a cuál precioPartida has hecho click -->
            <input id="precioPartida" class="d-none" type="text" name="precioPartida" placeholder="precioPartida" value="<?= htmlspecialchars($partidaAmodificar['precioPartida']) ?>">
            <!-- Para saber a cuál horaPartida has hecho click -->
            <input id="horaPartida" class="d-none" type="text" name="horaPartida" placeholder="horaPartida" value="<?= htmlspecialchars($partidaAmodificar['horaPartida']) ?>">
            <!-- Para saber numeromáximoJugadores de esa partida  -->
            <input id="numeroJugadores" class="d-none" type="text" name="numeroJugadores" placeholder="numeroJugadores" value="<?= htmlspecialchars($partidaAmodificar['numeroJugadores']) ?>">
        <!-- *****PASAR LOS DATOS DEL JUGADOR EN CASO DE SESION**** -->

            <!-- Para saber Nombre jugador Partida-->    
          <input id="nombreJugador" class="d-none" type="text" name="nombreJugador" placeholder="Nombre del jugador" 
                  value="<?= isset($nombreJugador) ? $nombreJugador : (isset($nombreAdmin) ? $nombreAdmin : '') ?>">

          <input id="apellido1Jugador" class="d-none" type="text" name="apellido1Jugador" placeholder="Apellido 1" 
                      value="<?= isset($apellido1Jugador) ? $apellido1Jugador : (isset($apellido1Admin) ? $apellido1Admin : '') ?>">

          <input id="apellido2Jugador" class="d-none" type="text" name="apellido2Jugador" placeholder="Apellido 2" 
                      value="<?= isset($apellido2Jugador) ? $apellido2Jugador : (isset($apellido2Admin) ? $apellido2Admin : '') ?>">
                  

        <!-- ------------PROBANDO VALORES DE LA SESION/SIN SESION -->
            <div class="cajaformulario">
            <label for="nickJugador">Nick del jugador<span>*</span></label>
            <input id="nickJugador" class="usuario" type="text" name="nickJugador" placeholder="Nick del jugador" 
                  value="<?= isset($nickJugador) ? $nickJugador : (isset($nickAdmin) ? $nickAdmin : '') ?>">
            </div>
            <div class="cajaformulario">
            <label for="dniJugador">DNI del jugador<span>*</span></label>
            <input id="dniJugador" class="usuario" type="text" name="dniJugador" placeholder="DNI del jugador" 
                  value="<?= isset($dniJugador) ? $dniJugador : (isset($dniAdmin) ? $dniAdmin : '') ?>">
            </div>

            <div class="cajaformulario">
                <label for="telefonoJugador">Teléfono<span>*</span></label>
                <input id="telefonoJugador" class="usuario" type="text" name="telefonoJugador" placeholder="Teléfono" 
                      value="<?= isset($telefonoJugador) ? $telefonoJugador : (isset($telefonoAdmin) ? $telefonoAdmin : '') ?>">
            </div>
    
            <div class="cajaformulario">
                <label for="email">Correo electrónico<span>*</span></label>
                <input id="email" class="usuario" type="email" name="email" placeholder="Correo electrónico" 
                      value="<?= isset($email) ? $email : (isset($emailAdmin) ? $emailAdmin : '') ?>">
            </div>
            <!-- ------------FINAL DE PROBANDO VALORES SESION/SIN SESION -->
            

            <!-- Para enviar -->
            <div class="cajaBotonFormPartida">
                <input class="boton" type="submit" id="btn_apuntarse" name="Apuntarse" value="Apuntarse">
            </div>

            <button id="mostrarInscripcionGrupal" type="button" class="btn btn-primary cambiarInscripcion">
                    Inscripción Grupal
            </button>


        </form>
        <!-- ------------FINAL DE FORMULARIO -->  


 <!-- ---------------------------------------------------- -->
 <!-- ---------------------------------------------------- -->


 <!-- ------------------FORMULARIO GRUPAL----------------- -->

 <form id="formApuntarsePartidasGrupal" class="formApuntarsePartidas" action="" method="POST">
            <h4 class="d-flex m-auto col-12 col-sm-12">Inscripción Grupal</h4>

        <!-- *****PASAR LOS DATOS DE LA PARTIDA SELECCIONADA**** -->
            <!-- Para saber a cuál idPartidaGrupal has hecho click -->
            <input id="idPartidaGrupal" class="d-none" type="text" name="idPartidaGrupal" placeholder="idPartidaGrupal" value="<?= htmlspecialchars($partidaAmodificar['idPartida']) ?>">
            <!-- Para saber a cuál nombrePartidaGrupal has hecho click -->
            <input id="nombrePartidaGrupal" class="d-none" type="text" name="nombrePartidaGrupal" placeholder="nombrePartidaGrupal" value="<?= htmlspecialchars($partidaAmodificar['nombrePartida']) ?>">
            <!-- Para saber a cuál fechaGrupal has hecho click -->
            <input id="fechaGrupal" class="d-none" type="text" name="fechaGrupal" placeholder="fechaGrupal" value="<?= htmlspecialchars($partidaAmodificar['fecha']) ?>">
            <!-- Para saber a cuál precioPartidaGrupal has hecho click -->
            <input id="precioPartidaGrupal" class="d-none" type="text" name="precioPartidaGrupal" placeholder="precioPartidaGrupal" value="<?= htmlspecialchars($partidaAmodificar['precioPartida']) ?>">
            <!-- Para saber a cuál horaPartidaGrupal has hecho click -->
            <input id="horaPartidaGrupal" class="d-none" type="text" name="horaPartidaGrupal" placeholder="horaPartidaGrupal" value="<?= htmlspecialchars($partidaAmodificar['horaPartida']) ?>">
            
        <!-- *****PASAR LOS DATOS DEL JUGADOR EN CASO DE SESION**** -->

            <!-- Para saber Nombre jugador Partida-->    
          <input id="nombreJugadorGrupalprincipal" class="d-none" type="text" name="nombreJugadorGrupal" placeholder="Nombre del jugador" 
                  value="<?= isset($nombreJugador) ? $nombreJugador : (isset($nombreAdmin) ? $nombreAdmin : '') ?>">

          <input id="apellido1JugadorGrupalprincipal" class="d-none" type="text" name="apellido1JugadorGrupal" placeholder="Apellido 1" 
                      value="<?= isset($apellido1Jugador) ? $apellido1Jugador : (isset($apellido1Admin) ? $apellido1Admin : '') ?>">

          <input id="apellido2JugadorGrupalprincipal" class="d-none" type="text" name="apellido2JugadorGrupal" placeholder="Apellido 2" 
                      value="<?= isset($apellido2Jugador) ? $apellido2Jugador : (isset($apellido2Admin) ? $apellido2Admin : '') ?>">
                  

        <!-- ------------PROBANDO VALORES DE LA SESION/SIN SESION -->
        <div id="cajaJugadorPlusGrupal" class="formApuntarsePartidas">
        <div class="d-flex col-12">
          <h4>Jugador 1</h4>
        </div>
       
              <div class="cajaformulario">
              <label for="nickJugadorGrupal">Nick del jugador <span>*</span></label>
              <input id="nickJugadorGrupalprincipal" class="usuario" type="text" name="nickJugadorGrupal" placeholder="Nick del jugador" 
                    value="<?= isset($nickJugador) ? $nickJugador : (isset($nickAdmin) ? $nickAdmin : '') ?>">
              </div>

              <div class="cajaformulario">
              <label for="dniJugadorGrupal">DNI del jugador<span>*</span></label>
              <input id="dniJugadorGrupalprincipal" class="usuario" type="text" name="dniJugadorGrupal" placeholder="DNI del jugador" 
                    value="<?= isset($dniJugador) ? $dniJugador : (isset($dniAdmin) ? $dniAdmin : '') ?>">
              </div>

              <div class="cajaformulario">
                  <label for="telefonoJugadorGrupal">Teléfono<span>*</span></label>
                  <input id="telefonoJugadorGrupalprincipal" class="usuario" type="text" name="telefonoJugadorGrupal" placeholder="Teléfono" 
                        value="<?= isset($telefonoJugador) ? $telefonoJugador : (isset($telefonoAdmin) ? $telefonoAdmin : '') ?>">
              </div>
      
              <div class="cajaformulario">
                  <label for="emailGrupal">Correo electrónico<span>*</span></label>
                  <input id="emailGrupalprincipal" class="usuario" type="email" name="emailGrupal" placeholder="Correo electrónico" 
                        value="<?= isset($email) ? $email : (isset($emailAdmin) ? $emailAdmin : '') ?>">
              </div>

           </div> <!--//fin cajaJugadorPlusGrupal -->
            <!-- ------------FINAL DE PROBANDO VALORES SESION/SIN SESION -->

            
           
            <!-- ------------Aquí se añadirán los nuevos jugadores-->
            
            <div id="contenedorJugadores" class="formApuntarsePartidas">
              <!-- Aquí se añadirán los nuevos jugadores -->
            </div>


            <!-- ------------BOTON PARA AÑADIR GRUAPLES-->
            <button id="btnAddPlayer" type="button" class="btn btn-primary btnAñadirJugador" onclick="addPlayer()">
            + Añadir jugador
            </button>

                    <!-- //-----------------MENSAJE VALIDACIONES -->
        <div id="cajaMensajeErrorMaximoJugadores" class="d-flex flex-wrap col-12 col-sm-12 text-center pl-3 pr-3"></div>



            <!-- ------------BOTON PARA ENVIAR GRUPAL-->
            <!-- Para enviar -->
            <div class="cajaBotonFormPartida">
                <input class="boton" type="submit" id="btn_apuntarseGrupal" name="Apuntarse" value="Apuntarse">
            </div>

            <button id="mostrarInscripcionIndividual" type="button" class="btn btn-primary cambiarInscripcion">
                      Inscripción Individual
            </button>
         

        </form>
        <!-- ------------FINAL DE FORMULARIO GRUPAL-->


       <!-- Overlay para difuminar el resto del HTML -->
<div id="adminoverlayGrupal" class="d-none" onclick="closeMaxPlayersMessage()"></div>



        <!-- //-----------------MENSAJE VALIDACIONES -->
        <div id="cajaMensajeErrorInscripcionPartida" class="d-flex flex-wrap col-12 col-sm-12 text-center pl-3 pr-3"></div>
        <!-- //-----------------MENSAJE VALIDACIONES grupal -->
        <div id="cajaMensajeErrorInscripcionPartidaGrupal" class="d-flex flex-wrap col-12 col-sm-12 text-center pl-3 pr-3"></div>

              <!-- //-----------------MENSAJE para crear cuenta-->
        <div class="pieFormApuntarse col-6">
          <div class="enviarLogin">
              <p>Si aun no tienes cuenta, <br> puedes <a href="login.php" class="enlaceRojo">crear una cuenta</a> </p>
          </div>

        </div>
        

  <!-- </div> -->

   </div> <!--//cierre cajaApuntarse -->
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


<!-- mostarr opcultar formulario gruopal   -->

<!-- //CAMBIAR EL CUADRO DE LOGIN -->
<script>
$(document).ready(function() {
    // Mostrar formulario de inscripción individual al inicio y ocultar el grupal
    $("#formApuntarsePartidas").show();
    $("#formApuntarsePartidasGrupal").hide();

    // Mostrar formulario grupal y ocultar el individual cuando se haga clic en "Inscripción Grupal"
    $("#mostrarInscripcionGrupal").click(function() {
        $("#formApuntarsePartidasGrupal").show();
        $("#formApuntarsePartidas").hide();
    });

    // Mostrar formulario individual y ocultar el grupal cuando se haga clic en "Inscripción Individual"
    $("#mostrarInscripcionIndividual").click(function() {
        $("#formApuntarsePartidas").show();
        $("#formApuntarsePartidasGrupal").hide();
    });
});
</script>




<!-- AÑADIR Y ELIMINAR JUGADORES DEL FORMULARIO GRUPAL   -->
<script>
 // Contador para asignar IDs únicos a cada nuevo jugador
let jugadorCounter = 1;

function addPlayer() {
    // Comprobar si el número de jugadores ya alcanzó el límite de 9 más
    if (jugadorCounter > 9) {
        mostrarMensajeError("Has alcanzado el número máximo de jugadores por grupo"); // Mostrar el mensaje de error
        return; // Salir de la función si ya hay 10 jugadores
    }

    // Crear el contenedor de la caja del jugador con un ID único
    const playerContainer = document.createElement('div');
    playerContainer.classList.add('formApuntarsePartidas');
    playerContainer.id = `cajaJugador${jugadorCounter}`;
    // Calcular el número del jugador a mostrar (empieza desde "Jugador 2")
    const jugadorNumero = jugadorCounter + 1;


    // HTML de la caja con IDs únicos
    playerContainer.innerHTML = `

        <div class="d-flex col-12">
          <h4>Jugador ${jugadorNumero}</h4>
        </div>

        <div class="cajaformulario">
            <label for="nickJugadorGrupal${jugadorCounter}">Nick del jugador<span>*</span></label>
            <input id="nickJugadorGrupal${jugadorCounter}" class="usuario" type="text" name="nickJugadorGrupal" placeholder="Nick del jugador">
        </div>

        <div class="cajaformulario">
            <label for="dniJugadorGrupal${jugadorCounter}">DNI del jugador<span>*</span></label>
            <input id="dniJugadorGrupal${jugadorCounter}" class="usuario" type="text" name="dniJugadorGrupal" placeholder="DNI del jugador">
        </div>

        <div class="cajaformulario">
            <label for="telefonoJugadorGrupal${jugadorCounter}">Teléfono<span>*</span></label>
            <input id="telefonoJugadorGrupal${jugadorCounter}" class="usuario" type="text" name="telefonoJugadorGrupal" placeholder="Teléfono">
        </div>

        <div class="cajaformulario">
            <label for="emailGrupal${jugadorCounter}">Correo electrónico<span>*</span></label>
            <input id="emailGrupal${jugadorCounter}" class="usuario" type="email" name="emailGrupal" placeholder="Correo electrónico">
        </div>

        <!-- Botón para eliminar esta caja de jugador -->
        <button class="btn btn-danger btnEliminarJugador" onclick="removePlayer(${jugadorCounter})">Eliminar</button>
    `;

    // Agregar la nueva caja al contenedor principal
    document.getElementById('contenedorJugadores').appendChild(playerContainer);

    // Incrementar el contador para el siguiente jugador
    jugadorCounter++;
}

function removePlayer(id) {
    // Eliminar la caja específica del jugador
    const playerContainer = document.getElementById(`cajaJugador${id}`);
    if (playerContainer) {
        playerContainer.remove();
        jugadorCounter--; // Decrementar el contador al eliminar un jugador
    }
}

// Función para mostrar mensajes de error
function mostrarMensajeError(mensaje) {
    limpiarcajaMensajeErrorMaximoJugadores();
    var cajaMensajeErrorMaximoJugadores = document.getElementById("cajaMensajeErrorMaximoJugadores");
    let mensajeErrorMaximoJugadores = document.createElement("p");
    mensajeErrorMaximoJugadores.classList.add("incorrecto"); // Añadir clase para el estilo
    mensajeErrorMaximoJugadores.innerText = mensaje;
    cajaMensajeErrorMaximoJugadores.appendChild(mensajeErrorMaximoJugadores);
    setTimeout(() => {
      mensajeErrorMaximoJugadores.remove(); // Eliminar mensaje después de 5 segundos
    }, 5000);
}

// Limpiar el contenedor de mensajes
function limpiarcajaMensajeErrorMaximoJugadores() {
    var cajaMensajeErrorMaximoJugadores = document.getElementById("cajaMensajeErrorMaximoJugadores");
    cajaMensajeErrorMaximoJugadores.innerHTML = ""; // Limpiar contenido
}
</script>



  </body>
</html>
