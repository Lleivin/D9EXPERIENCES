<?php
session_start();
// Llamada a la conexión a la BBDD
require_once "conexion.php";
require_once "otrasFunciones.php"; // Asegúrate de que el nombre y la ruta sean correctos
require_once "cronActualizarPartidas.php"; // Asegúrate de que el nombre y la ruta sean correctos

// Llamar a la función para actualizar el estado de las partidas
$partidasActualizadas = actualizarEstadoPartidas($conexion);

// Verificar si la sesión activa no es de administrador
if (!isset($_SESSION["sesionAdmin"]) || empty($_SESSION["sesionAdmin"])) {
    // Mostrar un mensaje en la pantalla antes de redirigir
    echo "<div style='color: red; font-size: 20px; margin-top: 20px; text-align: center;'>No tienes permiso de administrador. Logéate como administrador para acceder.</div>";

    // Añadir un tiempo de espera de 5 segundos antes de la redirección
    echo "<meta http-equiv='refresh' content='5;url=login.php' />";

    exit; // Termina el script para asegurar que no se ejecute más código
}


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
  
  // Enmascarar contraseñas
  $contrasenaJugadorEnmascarada = enmascararContrasena($contrasenaJugador);
  $contrasenaAdminEnmascarada = enmascararContrasena($contrasenaAdmin);
  


  //--------------------------- PAGINACION JUGADORES
// Valores de paginación
$recordsPerPage = 5; // Número de registros por página
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Página actual
$offset = ($page - 1) * $recordsPerPage; // Calcular el offset

//PAGINACION JUGADORES
// Obtener los registros de la página actual con ordenación
// Contar total de registros
$totalRecords = contarTotalPartidas($conexion); // Total de registros como un número
$totalPages = ceil($totalRecords / $recordsPerPage); // Calcular el total de páginas
// Obtener los registros de la página actual con ordenación
$todasPartidas = obtenerTotalPartidas($conexion, $offset, $recordsPerPage);


//PAGINACION JUGADORES
// Contar el total de registros
$totalRecordsJugadores = contarTotalJugadores($conexion); // Total de registros como un número
$totalPagesJugadores = ceil($totalRecordsJugadores / $recordsPerPage); // Calcular el total de páginas

// Obtener los registros de la página actual
$todosJugadores = obtenerTotalJugadores($conexion, $offset, $recordsPerPage);
  //--------------------------- FIN PAGINACION

?>

<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- LINK ESTILOS -->
    <link rel="stylesheet" href="estilos/estilo
.css"/>
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

  

    <!-- ----------------------------- -->

    <section class="seccionlistaJugadores">

      <!-- ----------------------------- -->
    
                    <!-- contenedorDesplegable principal para partidas -->
    <!-- Contenedor Principal -->
    <div class="contenedorDesplegable">
        <div class="tituloListaJugadores">
            <h3>LISTA DE PARTIDAS</h3>
            <button class="toggle-btn" onclick="toggleContent(this)">+</button>
        </div>
        <div class="contenido">


            <div class="btnNuevaPartida">
                <a href="crearPartida.php" class="btn btn-primary "><i class="fa-solid fa-square-plus"></i>&nbsp Nueva Partida</a>
            </div>


            <article>
                <div class="table-responsive">
                    <table id="admintablaPartidas" class="table">
                        <thead class="bg-info">
                            <tr>
                                <th class="cabeceraTable" scope="col">Estado</th>
                                <th class="cabeceraTable" scope="col">idPartida</th>
                                <th class="cabeceraTable" scope="col">idCampo</th>
                                <th class="cabeceraTable" scope="col">nombreCampo</th>
                                <th class="cabeceraTable" scope="col">nombrePartida</th>
                                <th class="cabeceraTable" scope="col">fecha</th>
                                <th class="cabeceraTable" scope="col">hora</th>
                                <th class="cabeceraTable" scope="col">precioPartida</th>
                                <th class="cabeceraTable" scope="col">numeroJugadores</th>
                                <th class="cabeceraTable" scope="col">descripcionPartida</th>
                                <th class="cabeceraTable" scope="col">estadoPartida</th>
                                <th class="cabeceraTable" scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($partida = mysqli_fetch_assoc($todasPartidas)) {
                                
                                //sacamos el IDPartida actual
                                $numeroIdPartida = $partida['idPartida'];  // Asume que el idPartida está en el array de cada partida
                                // LLAMADA A FUNCION PARA CONTAR NUMERO JUGADORES POR PARTIDA
                                $numeroJugadoresApuntados = obtenerNumeroJugadoresPorPartida($conexion, $numeroIdPartida);

                                // Máximo de jugadores para esa partida
                                $jugadoresMaximoPartida = $partida['numeroJugadores'];

                                // Formatear la fecha y la hora
                                $fechaPartida = $partida['fecha'];
                                $fecha = new DateTime($fechaPartida);
                                $fechaFormateada = $fecha->format('d-m-Y');

                                $horaPartida = $partida['horaPartida'];
                                $horaPartidaFormateada = $horaPartida ? (new DateTime($horaPartida))->format('H:i') : 'No disponible';
                            ?>
                                <tr>
                                    <td class="linea">
                                        
                                    <!-- MOSTRAR ESTADO: Pendiente/finalizada/Cancelada -->
                                    <?php  
                                        if ($partida['estadoPartida'] === 'Finalizada') { ?>
                                            <div class="btn btn-small btn-success " data-idPartida="<?= htmlspecialchars($partida['idPartida']) ?>">
                                            <i class="fa-solid fa-calendar-check" style="color: #ffffff;"></i>
                                            </div>
                                        <?php } elseif ($partida['estadoPartida'] === 'Cancelada') { ?>
                                            <div class="btn btn-small btn-danger " data-idPartida="<?= htmlspecialchars($partida['idPartida']) ?>">
                                            <i class="fa-solid fa-ban" style="color: #fafafa;"></i>
                                            </div>
                                        <?php } elseif ($partida['estadoPartida'] === 'Pendiente') { ?>
                                            <div class="btn btn-small btn-warning " data-idPartida="<?= htmlspecialchars($partida['idPartida']) ?>">
                                            <i class="fa-regular fa-hourglass" style="color: #ffffff;"></i>
                                            </div>
                                        <?php } ?>
                                    </td>
                                    <td class="linea"><?= htmlspecialchars($partida['idPartida']) ?></td>
                                    <td class="linea"><?= htmlspecialchars($partida['idCampo']) ?></td>
                                    <td class="linea"><?= htmlspecialchars($partida['nombreCampo']) ?></td>
                                    <td class="linea"><?= htmlspecialchars($partida['nombrePartida']) ?></td>
                                    <td class="linea"><?= htmlspecialchars($fechaFormateada) ?></td>
                                    <td class="linea"><?= htmlspecialchars($horaPartidaFormateada) ?></td>
                                    <td class="linea"><?= htmlspecialchars($partida['precioPartida']) ?> €</td>
                                    <td class="linea"><?= htmlspecialchars($numeroJugadoresApuntados) ?><?= $jugadoresMaximoPartida ? " / " . htmlspecialchars($jugadoresMaximoPartida) : '' ?></td>
                                    <td class="linea"><?= htmlspecialchars($partida['descripcionPartida']) ?></td>
                                    <td class="linea"><?= htmlspecialchars($partida['estadoPartida']) ?></td>
                                    <td class="linea">
                                        <!-- Editar -->
                                        <a href="editarPartida.php?idPartida=<?= urlencode($partida['idPartida']) ?>" class="btn btn-small btn-secondary"><i class="fa-solid fa-pencil"></i></a>

                                        <!-- *****CANCELAR / REANUDAR la PARTIDA****** -->
                                        <!-- Si es Cancelada aparecerá play para reanudar, si es pendiente, aparecerá pause para detener -->
                                        <?php if ($partida['estadoPartida'] === 'Pendiente') { ?>
                                            <button class="btn btn-small btn-secondary  cancelarPartida" data-idPartida="<?= htmlspecialchars($partida['idPartida']) ?>" data-estadoPartida="<?= htmlspecialchars($partida['estadoPartida']) ?>">
                                                <i class="fa-solid fa-circle-pause" style="color: #ffffff;"></i>
                                            </button>
                                        <?php } elseif ($partida['estadoPartida'] === 'Cancelada') { ?>
                                            <button class="btn btn-small btn-success desCancelarPartida" data-idPartida="<?= htmlspecialchars($partida['idPartida']) ?>" data-estadoPartida="<?= htmlspecialchars($partida['estadoPartida']) ?>">
                                                <i class="fa-solid fa-play" style="color: #ffffff;"></i>
                                            </button>
                                        <?php } ?>

                                        <!-- EliminarPartida -->
                                        <button class="btn btn-small btn-danger adminEliminarPartidabtn" data-idPartida="<?= htmlspecialchars($partida['idPartida']) ?>"><i class="fa-solid fa-trash-can"></i></button>
                                        
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </article>

            <!-- Paginación -->
            <div class="pagination paginacion">
                <?php if ($page > 1): ?>
                    <a href="?page=<?= $page - 1 ?>">Anterior</a>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <?php if ($i == $page): ?>
                        <span><?= $i ?></span>
                    <?php else: ?>
                        <a href="?page=<?= $i ?>"><?= $i ?></a>
                    <?php endif; ?>
                <?php endfor; ?>

                <?php if ($page < $totalPages): ?>
                    <a href="?page=<?= $page + 1 ?>">Siguiente</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

<!-- ---------------------------------------------------------------------- -->
<!-- contenedorDesplegable principal para jugadores -->
<div class="contenedorDesplegable">
    <div class="tituloListaJugadores">
        <h3>LISTA DE JUGADORES REGISTRADOS</h3>
        <button class="toggle-btn" onclick="toggleContent(this)">+</button>
    </div>
    <div class="contenido">
        <article>
            <div class="table-responsive">
                <table id="admintablaJugadores" class="table">
                    <thead class="bg-info">
                        <tr>
                            <th class="cabeceraTable" scope="col">DNI/NIF</th>
                            <th class="cabeceraTable" scope="col">Nombre</th>
                            <th class="cabeceraTable" scope="col">Apellido1</th>
                            <th class="cabeceraTable" scope="col">Apellido2</th>
                            <th class="cabeceraTable" scope="col">Teléfono</th>
                            <th class="cabeceraTable" scope="col">Correo</th>
                            <th class="cabeceraTable" scope="col">Fecha Nacimiento</th>
                            <th class="cabeceraTable" scope="col">Estado</th>
                            <th class="cabeceraTable" scope="col">Contraseña</th>
                            <th class="cabeceraTable" scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($jugador = mysqli_fetch_assoc($todosJugadores)) {
                            // Enmascarar la contraseña del jugador
                            $contrasenaJugadorEnmascarada = enmascararContrasena($jugador['contrasenaJugador']);
                        ?>
                            <tr>
                                <td class="linea"><?= htmlspecialchars($jugador['dniJugador']) ?></td>
                                <td class="linea"><?= htmlspecialchars($jugador['nombreJugador']) ?></td>
                                <td class="linea"><?= htmlspecialchars($jugador['apellido1Jugador']) ?></td>
                                <td class="linea"><?= htmlspecialchars($jugador['apellido2Jugador']) ?></td>
                                <td class="linea"><?= htmlspecialchars($jugador['telefonoJugador']) ?></td>
                                <td class="linea"><?= htmlspecialchars($jugador['email']) ?></td>
                                <td class="linea"><?= htmlspecialchars($jugador['fechaNacimiento']) ?></td>
                                <td class="linea"><?= htmlspecialchars($jugador['estadoJugador']) ?></td>
                                <td class="linea"><?= htmlspecialchars($contrasenaJugadorEnmascarada) ?></td>
                                <td class="linea">
                                    <!-- Editar -->
                                    <a href="editarJugador.php?dni=<?= urlencode($jugador['dniJugador']) ?>" class="btn btn-small btn-secondary"><i class="fa-solid fa-pencil"></i></a>
                                    <!-- Bloquear/Desbloquear -->
                                    <?php if ($jugador['estadoJugador'] === 'Activo') { ?>
                                        <button class="btn btn-small btn-success bloquearJugador" data-dni="<?= htmlspecialchars($jugador['dniJugador']) ?>"><i class="fa-solid fa-unlock"></i></button>
                                    <?php } else { ?>
                                        <button class="btn btn-small btn-warning  desbloquearJugador" data-dni="<?= htmlspecialchars($jugador['dniJugador']) ?>"><i class="fa-solid fa-lock "></i></button>
                                    <?php } ?>
                                    <!-- eliminarUsuario -->
                                    <button class="btn btn-small btn-danger adminEliminarJugadorbtn" data-dni="<?= htmlspecialchars($jugador['dniJugador']) ?>"><i class="fa-solid fa-trash-can"></i></button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </article>
        <!-- Paginación -->
        <div class="pagination paginacion">
            <?php if ($page > 1): ?>
                <a href="?page=<?= $page - 1 ?>">Anterior</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPagesJugadores; $i++): ?>
                <?php if ($i == $page): ?>
                    <span><?= $i ?></span>
                <?php else: ?>
                    <a href="?page=<?= $i ?>"><?= $i ?></a>
                <?php endif; ?>
            <?php endfor; ?>

            <?php if ($page < $totalPagesJugadores): ?>
                <a href="?page=<?= $page + 1 ?>">Siguiente</a>
            <?php endif; ?>
        </div>
    </div>
</div>


</section>

<!-- //-----------------MENSAJE PARA ELIMINAR JUGADOR -->

<!-- Overlay para difuminar el resto del HTML -->
<div id="adminoverlay" class="d-none"></div>
<section class="cajaEliminarPerfil d-none" id="admineliminarPerfilCaja">
    <div class="tituloBorrarPerfil">
        <h3>Eliminar Perfil</h3>
        <p>*Una vez eliminado el perfil de jugador, este deberá crear una cuenta nueva para poder registrarse a las partidas.</p>
    </div>
    <div class="seleccionOpciones">
        <button class="boton adminEliminarJugadorSelec" id="adminaceptarEliminar" data-dni="<?= htmlspecialchars($jugador['dniJugador']) ?>">Sí</button>
        <button class="boton" id="admincancelarEliminar">No</button>
    </div>
    <div id="cajaMensajeErroradminEliminarPerfil" class="d-flex flex-wrap col-12 col-sm-12 text-center pl-3 pr-3"></div>
</section>



<!-- //-----------------MENSAJE PARA ELIMINAR PARTIDAS -->

<!-- Overlay para difuminar el resto del HTML -->
<div id="adminoverlayPartida" class="d-none"></div>
<section class="cajaEliminarPerfil d-none" id="admineliminarPartidaCaja">
    <div class="tituloBorrarPerfil">
        <h3>Eliminar Partida</h3>
        <p>*Una vez eliminada la partida, no podrá recuperarse ni visualizarse en el historial.</p>
    </div>
    <div class="seleccionOpciones">
        <button class="boton adminEliminarPartidaSelec" id="adminaceptarEliminarPartida" data-idPartida="<?= htmlspecialchars($partida['idPartida']) ?>">Sí</button>
        <button class="boton" id="admincancelarEliminarPartida">No</button>
    </div>
    <div id="cajaMensajeErroradminEliminarPartida" class="d-flex flex-wrap col-12 col-sm-12 text-center pl-3 pr-3"></div>
</section>


<!-- //-----------------MENSAJE PARA CANCELAR PARTIDA    -->

<!-- Overlay para difuminar el resto del HTML -->
<div id="adminoverlayCancelarPartida" class="d-none"></div>
<!-- Caja para confirmar la cancelación de la partida -->
<section class="cajaEliminarPerfil d-none" id="adminCancelarPartidaCaja">
    <div class="tituloBorrarPerfil">
        <h3>Cancelar Partida</h3>
        <p>*¿Estás seguro de que quieres cancelar la partida seleccionada?</p>
    </div>
    <div class="seleccionOpciones">
        <button class="boton adminCancelarPartidaSelec" id="adminAceptarCancelarPartida" data-idPartida="<?= htmlspecialchars($partida['idPartida']) ?>">Sí</button>
        <button class="boton" id="adminCancelarCancelarPartida">No</button>
    </div>
    <div id="cajaMensajeErroradminCancelarPartida" class="d-flex flex-wrap col-12 col-sm-12 text-center pl-3 pr-3"></div>
</section>

<!-- //-----------------MENSAJE PARA DESCANCELAR PARTIDA    -->

<!-- Overlay para difuminar el resto del HTML -->
<div id="adminoverlaydesCancelarPartida" class="d-none"></div>
<!-- Caja para confirmar la cancelación de la partida -->
<section class="cajaEliminarPerfil d-none" id="admindesCancelarPartidaCaja">
    <div class="tituloBorrarPerfil">
        <h3>Activar Partida</h3>
        <p>*¿Estás seguro de que quieres Activar la partida seleccionada?</p>
    </div>
    <div class="seleccionOpciones">
        <button class="boton admindesCancelarPartidaSelec" id="adminAceptardesCancelarPartida" data-idPartida="<?= htmlspecialchars($partida['idPartida']) ?>">Sí</button>
        <button class="boton" id="admindesCancelarCancelarPartida">No</button>
    </div>
    <div id="cajaMensajeErroradmindesCancelarPartida" class="d-flex flex-wrap col-12 col-sm-12 text-center pl-3 pr-3"></div>
</section>

    

<!-- //-----------------MENSAJE: BLOQUEADO/DESBLOQUEADO -->
<div id="adminoverlay" class="d-none"></div>
<section class="cajaEliminarPerfil d-none" id="mensajeJugadorbloqueado">
    <div class="tituloBorrarPerfil">
        <h3>Modificación del Estado</h3>
        <p id="mensajeBloqueo"></p>
</div>


<!-- //-----------------MENSAJE: JUGADOR ELIMINADO -->
<div id="adminoverlay2" class="d-none"></div>
<section class="cajaEliminarPerfil d-none" id="mensajeJugadorbEliminadoAdmin">
    <div class="tituloBorrarPerfil">
        <h3>Jugador eliminado con éxito</h3>
        <p id="mensajeEliminadoAdmin"></p>
    </div>
</section>

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


<!-- SCRIPT PARA ELIMINAR JUGADOR -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Selecciona todos los botones con la clase 'adminEliminarJugadorbtn'.
    const adminEliminarJugadorBtns = document.querySelectorAll('.adminEliminarJugadorbtn');
    // 2. Selecciona el botón de confirmación de eliminación.
    const adminaceptarEliminar = document.getElementById('adminaceptarEliminar');
    // 3. Selecciona el botón de cancelación de eliminación.
    const admincancelarEliminar = document.getElementById('admincancelarEliminar');
    // 4. Selecciona el contenedor de la caja de confirmación de eliminación de perfil.
    const admineliminarPerfilCaja = document.getElementById('admineliminarPerfilCaja');
    // 5. Selecciona el overlay (fondo) que aparece detrás de la caja de confirmación.
    const adminoverlay = document.getElementById('adminoverlay');
    // 6. Declara una variable para almacenar el DNI (identificador) del jugador a eliminar.
    let dniParaEliminar = '';
    // 7. Recorre cada botón de eliminación de jugador y agrega un evento 'click' a cada uno.
    adminEliminarJugadorBtns.forEach(function(btn) {
        btn.addEventListener('click', function () {
            // 8. Cuando se hace clic en un botón, guarda el DNI del jugador a eliminar.
            dniParaEliminar = this.getAttribute('data-dni');
            
            // 9. Muestra la caja de confirmación y el overlay quitando la clase 'd-none'.
            admineliminarPerfilCaja.classList.remove('d-none');
            adminoverlay.classList.remove('d-none');
        });
    });

    // 10. Evento para confirmar la eliminación: al hacer clic, llama a la función de eliminación.
    adminaceptarEliminar.addEventListener('click', function() {
        // 11. Llama a la función de eliminación con el DNI del jugador a eliminar.
        admineliminarjugador(dniParaEliminar);
        
        // 12. Oculta la caja de confirmación y el overlay añadiendo la clase 'd-none'.
        admineliminarPerfilCaja.classList.add('d-none');
        adminoverlay.classList.add('d-none');
    });

    // 13. Evento para cancelar la eliminación: al hacer clic, oculta la caja y el overlay.
    admincancelarEliminar.addEventListener('click', function() {
        admineliminarPerfilCaja.classList.add('d-none');
        adminoverlay.classList.add('d-none');
    });

    // 14. Si se hace clic en el overlay, también se ocultarán la caja y el overlay.
    if (adminoverlay) {
      adminoverlay.addEventListener('click', function() {
        admineliminarPerfilCaja.classList.add('d-none');
        adminoverlay.classList.add('d-none');
    });
    }
});
</script>


<!-- SCRIPT PARA ELIMINAR PARTIDA ADMIN -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Selecciona todos los botones con la clase 'adminEliminarPartidabtn'.
    const adminEliminarPartidaBtn = document.querySelectorAll('.adminEliminarPartidabtn');
    // 2. Selecciona el botón de confirmación de eliminación de partida.
    const adminaceptarEliminarPartida = document.getElementById('adminaceptarEliminarPartida');
    // 3. Selecciona el botón de cancelación de eliminación de partida.
    const admincancelarEliminarPartida = document.getElementById('admincancelarEliminarPartida');
    // 4. Selecciona el contenedor de la caja de confirmación de eliminación.
    const admineliminarPartidaCaja = document.getElementById('admineliminarPartidaCaja');
    // 5. Selecciona el overlay (fondo) que aparece detrás de la caja de confirmación.
    const adminoverlayPartida = document.getElementById('adminoverlayPartida');
    // 6. Declara una variable para almacenar el ID de la partida a eliminar.
    let idPartidaParaEliminar = '';

    // 7. Recorre cada botón de eliminación de partida y agrega un evento 'click' a cada uno.
    adminEliminarPartidaBtn.forEach(function(btn) {
        btn.addEventListener('click', function () {
            // 8. Cuando se hace clic en un botón, guarda el ID de la partida a eliminar.
            idPartidaParaEliminar = this.getAttribute('data-idPartida');
            // Imprimir el ID en la consola
        console.log("ID de la partida a eliminar:", idPartidaParaEliminar);
            
            // 9. Muestra la caja de confirmación y el overlay quitando la clase 'd-none'.
            admineliminarPartidaCaja.classList.remove('d-none');
            adminoverlayPartida.classList.remove('d-none');
        });
    });

    // 10. Evento para confirmar la eliminación: al hacer clic, llama a la función de eliminación.
    adminaceptarEliminarPartida.addEventListener('click', function() {
        console.log('ID de la partida a eliminar:', idPartidaParaEliminar); // Añade esta línea
        // 11. Llama a la función de eliminación con el ID de la partida a eliminar.
        admineliminarPartida(idPartidaParaEliminar);
        
        // 12. Oculta la caja de confirmación y el overlay añadiendo la clase 'd-none'.
        admineliminarPartidaCaja.classList.add('d-none');
        adminoverlayPartida.classList.add('d-none');
    });

    // 13. Evento para cancelar la eliminación: al hacer clic, oculta la caja y el overlay.
    admincancelarEliminarPartida.addEventListener('click', function() {
        admineliminarPartidaCaja.classList.add('d-none');
        adminoverlayPartida.classList.add('d-none');
    });

    // 14. Si se hace clic en el overlay, también se ocultarán la caja y el overlay.
    if (adminoverlayPartida) {
        adminoverlayPartida.addEventListener('click', function() {
            admineliminarPartidaCaja.classList.add('d-none');
            adminoverlayPartida.classList.add('d-none');
        });
    }
});
</script>

<!-- SCRIPT PARA CANCELAR PARTIDA ADMIN -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Selecciona todos los botones con la clase 'cancelarPartida'.
    const cancelarPartidaBtn = document.querySelectorAll('.cancelarPartida');
    // 2. Selecciona el botón de confirmación de cancelación de partida.
    const adminAceptarCancelarPartida = document.getElementById('adminAceptarCancelarPartida');
    // 3. Selecciona el botón de cancelación de la confirmación de cancelación de partida.
    const adminCancelarCancelarPartida = document.getElementById('adminCancelarCancelarPartida');
    // 4. Selecciona el contenedor de la caja de confirmación de cancelación.
    const adminCancelarPartidaCaja = document.getElementById('adminCancelarPartidaCaja');
    // 5. Selecciona el overlay (fondo) que aparece detrás de la caja de confirmación.
    const adminoverlayCancelarPartida = document.getElementById('adminoverlayCancelarPartida');
    // 6. Declara una variable para almacenar el ID de la partida a cancelar.
    let idPartidaParaCancelar = '';
    
    // 7. Recorre cada botón de cancelación de partida y agrega un evento 'click' a cada uno.
    cancelarPartidaBtn.forEach(function(btn) {
        btn.addEventListener('click', function () {
            // 8. Cuando se hace clic en un botón, guarda el ID de la partida a cancelar.
            idPartidaParaCancelar = this.getAttribute('data-idPartida');
            // Imprimir el ID en la consola
            console.log("ID de la partida a cancelar:", idPartidaParaCancelar);
            
            // 9. Muestra la caja de confirmación y el overlay quitando la clase 'd-none'.
            adminCancelarPartidaCaja.classList.remove('d-none');
            adminoverlayCancelarPartida.classList.remove('d-none');
        });
    });

    // 10. Evento para confirmar la cancelación: al hacer clic, llama a la función de cancelación.
    adminAceptarCancelarPartida.addEventListener('click', function() {
        console.log('ID de la partida a cancelar:', idPartidaParaCancelar); // Añade esta línea
        // 11. Llama a la función de cancelación con el ID de la partida a cancelar.
        adminCancelarPartida(idPartidaParaCancelar);
        
        // 12. Oculta la caja de confirmación y el overlay añadiendo la clase 'd-none'.
        adminCancelarPartidaCaja.classList.add('d-none');
        adminoverlayCancelarPartida.classList.add('d-none');
    });

    // 13. Evento para cancelar la confirmación de cancelación: al hacer clic, oculta la caja y el overlay.
    adminCancelarCancelarPartida.addEventListener('click', function() {
        adminCancelarPartidaCaja.classList.add('d-none');
        adminoverlayCancelarPartida.classList.add('d-none');
    });

    // 14. Si se hace clic en el overlay, también se ocultarán la caja y el overlay.
    if (adminoverlayCancelarPartida) {
        adminoverlayCancelarPartida.addEventListener('click', function() {
            adminCancelarPartidaCaja.classList.add('d-none');
            adminoverlayCancelarPartida.classList.add('d-none');
        });
    }
});
</script>



<!-- SCRIPT PARA DESCANCELAR PARTIDA ADMIN -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Selecciona todos los botones con la clase 'desCancelarPartida'.
    const desCancelarPartidaBtn = document.querySelectorAll('.desCancelarPartida');
    // 2. Selecciona el botón de confirmación de descancelación de partida.
    const adminAceptardesCancelarPartida = document.getElementById('adminAceptardesCancelarPartida');
    // 3. Selecciona el botón de cancelación de la confirmación de descancelación de partida.
    const admindesCancelarCancelarPartida = document.getElementById('admindesCancelarCancelarPartida');
    // 4. Selecciona el contenedor de la caja de confirmación de descancelación.
    const admindesCancelarPartidaCaja = document.getElementById('admindesCancelarPartidaCaja');
    // 5. Selecciona el overlay (fondo) que aparece detrás de la caja de confirmación.
    const adminoverlaydesCancelarPartida = document.getElementById('adminoverlaydesCancelarPartida');
    // 6. Declara una variable para almacenar el ID de la partida a descancelar.
    let idPartidaParaDesCancelar = '';
    
    // 7. Recorre cada botón de descancelación de partida y agrega un evento 'click' a cada uno.
    desCancelarPartidaBtn.forEach(function(btn) {
        btn.addEventListener('click', function () {
            // 8. Cuando se hace clic en un botón, guarda el ID de la partida a descancelar.
            idPartidaParaDesCancelar = this.getAttribute('data-idPartida');
            // Imprimir el ID en la consola
            console.log("ID de la partida a descancelar:", idPartidaParaDesCancelar);
            
            // 9. Muestra la caja de confirmación y el overlay quitando la clase 'd-none'.
            admindesCancelarPartidaCaja.classList.remove('d-none');
            adminoverlaydesCancelarPartida.classList.remove('d-none');
        });
    });

    // 10. Evento para confirmar la descancelación: al hacer clic, llama a la función de descancelación.
    adminAceptardesCancelarPartida.addEventListener('click', function() {
        console.log('ID de la partida a descancelar:', idPartidaParaDesCancelar); // Añade esta línea
        // 11. Llama a la función de descancelación con el ID de la partida a descancelar.
        adminDesCancelarPartida(idPartidaParaDesCancelar);
        
        // 12. Oculta la caja de confirmación y el overlay añadiendo la clase 'd-none'.
        admindesCancelarPartidaCaja.classList.add('d-none');
        adminoverlaydesCancelarPartida.classList.add('d-none');
    });

    // 13. Evento para cancelar la confirmación de descancelación: al hacer clic, oculta la caja y el overlay.
    admindesCancelarCancelarPartida.addEventListener('click', function() {
        admindesCancelarPartidaCaja.classList.add('d-none');
        adminoverlaydesCancelarPartida.classList.add('d-none');
    });

    // 14. Si se hace clic en el overlay, también se ocultarán la caja y el overlay.
    if (adminoverlaydesCancelarPartida) {
        adminoverlaydesCancelarPartida.addEventListener('click', function() {
            admindesCancelarPartidaCaja.classList.add('d-none');
            adminoverlaydesCancelarPartida.classList.add('d-none');
        });
    }
});
</script>





<!-- SCRIPT PARA LOS DESPLEGABLES -->
<script>
function toggleContent(button) {
    var contenido = button.closest('.contenedorDesplegable').querySelector('.contenido');
    if (contenido.style.display === "none" || contenido.style.display === "") {
        contenido.style.display = "block";
        button.textContent = "-";
        button.classList.add("active");
    } else {
        contenido.style.display = "none";
        button.textContent = "+";
        button.classList.remove("active");
    }
}
</script>

  </body>
</html>
