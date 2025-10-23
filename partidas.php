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
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- LINK ESTILOS -->
  <link rel="stylesheet" href="estilos/estilo.css" />
  <!-- Enlace con FONTAWESOME -->
  <script src="https://kit.fontawesome.com/ea7d8023a5.js" crossorigin="anonymous"></script>
  <!-- BOOSTRAP-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous" />

  <!-- JAVASCRIPT -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">

  <title>HOME</title>
</head>

<body>
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



  <!-- --------------------------CUERPO -->

  <!-- PARTIDAS PARA DISTRITO 9 -->
  <section class="sectionPartidasDistrito9">

    <div class="tituloPartidas">
      <h3>Partidas Distrito 9</h3>
    </div>

    <article class="partidasTipo">

        <?php
        // FUNCION OBTENER PARTIDAS DEL DISTRITO 9
        $partidasDistrito9 = obtenerPartidasD9($conexion); // Usamos la función correcta que obtendrá las partidas del distrito 9
      
        // Comprobar si hay partidas pendientes o canceladas
        if(mysqli_num_rows($partidasDistrito9) > 0) {
            // Recorrer las partidas y mostrarlas en formato de tarjeta (card)
            while($partida = mysqli_fetch_assoc($partidasDistrito9)) {

              // LLAMADA A FUNCION PARA CONTAR NUMERO JUGADORES POR PARTIDA
              $numeroIdPartida = $partida['idPartida'];  // Asume que el idPartida está en el array de cada partida
              $numeroJugadoresApuntados = obtenerNumeroJugadoresPorPartida($conexion, $numeroIdPartida);

              // Máximo de jugadores para esa partida
              $jugadoresMaximoPartida = $partida['numeroJugadores'];

            
              // Determina si el botón debe estar deshabilitado
              $esPartidaCompleta = $numeroJugadoresApuntados >= $jugadoresMaximoPartida;


                // Añadir clase "cancelada" si el estado es "Cancelada"
                $claseCancelada = ($partida['estadoPartida'] == 'Cancelada') ? 'cancelada' : '';
                ?>
                <div id="card-<?php echo $partida['idPartida']; ?>" class="cardPartida col-12 col-sm-6 col-md-3 col-lg-2 col-xl-2  <?php echo $claseCancelada; ?>">
                    <!-- Tarjeta con información inicial -->
                    <div class="card-content">
                        <p class="text-left"> <strong>Partida:</strong>  <br> </p>
                        <p class="text-center"> <?php echo $partida['nombrePartida']; ?></p>
                        <p><strong>Campo:</strong> <?php echo $partida['nombreCampo']; ?></p>
                        <p><strong>Fecha:</strong> <?php $fecha = new DateTime($partida['fecha']);echo $fecha->format('d-m-Y');?></p>
                        <p><strong>Precio:</strong> <?php echo $partida['precioPartida']; ?>€</p>
                        <p><strong>Plazas:</strong> <?= htmlspecialchars($numeroJugadoresApuntados) ?><?= $jugadoresMaximoPartida ? " / " . htmlspecialchars($jugadoresMaximoPartida) : '' ?></p>
                        <button class="btninforPartida" onclick="mostrarInformacion(<?php echo $partida['idPartida']; ?>)"><strong><i class="fa-solid fa-circle-info"></i>&nbsp;Info</strong></button>


                        <a class="btnformApuntarsePartida" href="formPartida.php?idPartida=<?= urlencode($partida['idPartida']) ?>">
    <button type="submit"
        <?php
            // Deshabilitar si la partida está cancelada o si ya está completa
            echo ($partida['estadoPartida'] == 'Cancelada' || $esPartidaCompleta) ? 'disabled' : '';
        ?>
        class="<?php
            // Añadir una clase 'completada' si la partida está llena para que se muestre en rojo
            echo $esPartidaCompleta ? 'completada' : '';
        ?>">
        <?php
            // Mostrar el texto "Cancelada" si la partida está cancelada, "Completada" si ya está llena, o "Apuntarse" en caso contrario
            echo ($partida['estadoPartida'] == 'Cancelada') ? 'Cancelada' :
                ($esPartidaCompleta ? 'Completada' : 'Apuntarse');
        ?>
    </button>
</a>    
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
            <div class="row justify-content-center cajaMensajeSinPartidas">
                <div class="col-12 col-md-8 col-lg-12 width:100%">
                    <div class="message">
                        <p>No hay partidas disponibles en este momento. <br> <span>¡Revisa más tarde!</span></p>
                    </div>
                </div>
            </div>';
        }
        ?>
    </article>

</section>



  <!-- PARTIDAS PARA ENCLAVE -->
  <section class="sectionPartidasEnclave">

    <div class="tituloPartidas">
      <h3>Partidas El Enclave</h3>
    </div>
    <article class="partidasTipo">

<?php
//Seleccionar Partidas de ID 1 Distrito9 cuando sea Pendiente o Cancelada
// FUNCION OBTENER PARTIDAS DEL DISTRITO 9
$partidasEnclave = obtenerPartidasEnclave($conexion); // Usamos la función correcta que obtendrá las partidas del distrito 9

// Comprobar si hay partidas pendientes o canceladas
if (mysqli_num_rows($partidasEnclave) > 0) {
    // Recorrer las partidas y mostrarlas en formato de tarjeta (card)
    while ($partida = mysqli_fetch_assoc($partidasEnclave)) {

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

        // Añadir el HTML de cada card con el fondo como la imagen
        ?>
        <div id="card-<?php echo $partida['idPartida']; ?>" 
             class="cardPartida col-12 col-sm-6 col-md-3 col-lg-3 col-xl-2 <?php echo $claseCancelada; ?>"
             style="background-image: url('<?php echo htmlspecialchars($imagenPartida); ?>'); background-size: cover; background-position: center;">
            <!-- Tarjeta con información inicial -->
            <div class="card-content">
                <p class="text-left"><strong>Partida:</strong><br></p>
                <p class="text-center"><?php echo $partida['nombrePartida']; ?></p>
                <p><strong>Campo:</strong> <?php echo $partida['nombreCampo']; ?></p>
                <p><strong>Fecha:</strong> <?php $fecha = new DateTime($partida['fecha']); echo $fecha->format('d-m-Y'); ?></p>
                <p><strong>Precio:</strong> <?php echo $partida['precioPartida']; ?>€</p>
                <p><strong>Plazas:</strong> <?= htmlspecialchars($numeroJugadoresApuntados) ?><?= $jugadoresMaximoPartida ? " / " . htmlspecialchars($jugadoresMaximoPartida) : '' ?></p>
                <button class="btninforPartida" onclick="mostrarInformacion(<?php echo $partida['idPartida']; ?>)">
                    <strong><i class="fa-solid fa-circle-info"></i>&nbsp;Info</strong>
                </button>

                <a class="btnformApuntarsePartida" href="formPartida.php?idPartida=<?= urlencode($partida['idPartida']) ?>">
                    <button class="d-flex m-3" type="submit"
                        <?php
                        // Deshabilitar si la partida está cancelada o si ya está completa
                        echo ($partida['estadoPartida'] == 'Cancelada' || $esPartidaCompleta) ? 'disabled' : '';
                        ?>
                        class="<?php
                        // Añadir una clase 'completada' si la partida está llena para que se muestre en rojo
                        echo $esPartidaCompleta ? 'completada' : '';
                        ?>">
                        <?php
                        // Mostrar el texto "Cancelada" si la partida está cancelada, "Completada" si ya está llena, o "Apuntarse" en caso contrario
                        echo ($partida['estadoPartida'] == 'Cancelada') ? 'Cancelada' :
                            ($esPartidaCompleta ? 'Completada' : 'Apuntarse');
                        ?>
                    </button>
                </a>

            </div>

            <!-- Información adicional (oculta inicialmente) -->
            <div class="extra-info" style="display:none;">
                <p><strong>Descripción:</strong></p>
                <p class="d-flex flex-wrap infoPartida"><?php echo $partida['descripcionPartida']; ?></p>
                <button class="btninforPartida" onclick="ocultarInformacion(<?php echo $partida['idPartida']; ?>)">
                    <strong><i class="fa-solid fa-arrow-rotate-left"></i></strong>
                </button>
            </div>
        </div>
        <?php
    }
} else {
    echo '
    <div class="row justify-content-center cajaMensajeSinPartidas">
        <div class="col-12 col-md-8 col-lg-12 width:100%">
            <div class="message">
                <p>No hay partidas disponibles en este momento. <br> <span>¡Revisa más tarde!</span></p>
            </div>
        </div>
    </div>';
}
?>
</article>


</section>



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
            <!-- al hacer click ejecutara la funcion procesarNewsleeter (recuerda inyectar abajo el scrip de enlace con ajax) -->
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

<script>
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
  
</body>

</html>