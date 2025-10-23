// ------------------------------------------MOSTRAR MENSAJES DE ERRORES Y CORRETOS

// -----------------------------------------------------------------
// MENSAJE ERRO Y CORRECTO ALTA NEWSLETTER
// -----------------------------------------------------------------

function mostrarMensajeError(mensaje) {
  // Eliminar cualquier mensaje existente
  limpiarCajaMensajeErrorProcesarNewsletter();
    var respuestaProcesarNewsletter = document.getElementById(
      "respuestaProcesarNewsletter");
    let mensajeErrorNewsletter = document.createElement("p"); //crear el elemento
    mensajeErrorNewsletter.classList.add("incorrecto"); //añadir estilo incorrecto
    mensajeErrorNewsletter.innerText = mensaje; //aplicarle texto
    respuestaProcesarNewsletter.appendChild(mensajeErrorNewsletter); //imprimirlo como hijo
    setTimeout(() => {
      mensajeErrorNewsletter.remove();
    }, 3000);
  }

  function mostrarMensajeCorrecto(mensaje) {
    // Eliminar cualquier mensaje existente
    limpiarCajaMensajeErrorProcesarNewsletter();
    var respuestaProcesarNewsletter = document.getElementById(
      "respuestaProcesarNewsletter"); //seleccionar elemento
    let mensajeCorrectoNewsletter = document.createElement("p"); //crear el elemento
    mensajeCorrectoNewsletter.classList.add("correcto"); //añadir estilo incorrecto
    mensajeCorrectoNewsletter.innerText = mensaje; //aplicarle texto
    respuestaProcesarNewsletter.appendChild(mensajeCorrectoNewsletter); //imprimirlo como hijo
    setTimeout(() => {
      mensajeCorrectoNewsletter.remove();
    }, 5000);
  }
  
function limpiarCajaMensajeErrorProcesarNewsletter() {
  var respuestaProcesarNewsletter = document.getElementById("respuestaProcesarNewsletter");
  // Eliminar todos los hijos de la caja
  while (respuestaProcesarNewsletter.firstChild) {
    respuestaProcesarNewsletter.removeChild(respuestaProcesarNewsletter.firstChild);
  }
}

  // -----------------------------------------------------------------
// MENSAJE ERRO Y CORRECTO BAJA NEWSLETTER
// -----------------------------------------------------------------

  function mostrarMensajeErrorBajaNewsletter(mensaje) {
    // Eliminar cualquier mensaje existente
    limpiarCajaMensajeErrorBajaNewsletter();
    var cajaMensajeErrorBajaNewsletter = document.getElementById("cajaMensajeErrorBajaNewsletter");
    let mensajeErrorBajaNewsletter = document.createElement("p");
    mensajeErrorBajaNewsletter.classList.add("incorrecto");
    mensajeErrorBajaNewsletter.innerText = mensaje;
    cajaMensajeErrorBajaNewsletter.appendChild(mensajeErrorBajaNewsletter);
    setTimeout(() => {
        mensajeErrorBajaNewsletter.remove();
    }, 5000);
}

// Función para mostrar mensaje correcto en la baja de newsletter
function mostrarMensajeCorrectoBajaNewsletter(mensaje) {
    // Eliminar cualquier mensaje existente
    limpiarCajaMensajeErrorBajaNewsletter();
    var cajaMensajeErrorBajaNewsletter = document.getElementById("cajaMensajeErrorBajaNewsletter");
    let mensajeCorrectoBajaNewsletter = document.createElement("p");
    mensajeCorrectoBajaNewsletter.classList.add("correcto");
    mensajeCorrectoBajaNewsletter.innerText = mensaje;
    cajaMensajeErrorBajaNewsletter.appendChild(mensajeCorrectoBajaNewsletter);
    setTimeout(() => {
        mensajeCorrectoBajaNewsletter.remove();
    }, 5000);
}

function limpiarCajaMensajeErrorBajaNewsletter() {
    var cajaMensajeErrorBajaNewsletter = document.getElementById("cajaMensajeErrorBajaNewsletter");
    // Eliminar todos los hijos de la caja
    while (cajaMensajeErrorBajaNewsletter.firstChild) {
        cajaMensajeErrorBajaNewsletter.removeChild(cajaMensajeErrorBajaNewsletter.firstChild);
    }
}


  // -----------------------------------------------------------------
// MENSAJE ERRO Y CORRECTO ALTA USUARIO
// -----------------------------------------------------------------

function mostrarMensajeErrorAltaUsuario(mensaje) {
  limpiarcajaMensajeErrorAltaUsuario();
  var cajaMensajeErrorAltaUsuario = document.getElementById("cajaMensajeErrorAltaUsuario");
  let mensajeErrorAltaUsuario = document.createElement("p");
  mensajeErrorAltaUsuario.classList.add("incorrecto");
  mensajeErrorAltaUsuario.innerText = mensaje;
  cajaMensajeErrorAltaUsuario.appendChild(mensajeErrorAltaUsuario);
  setTimeout(() => {
    mensajeErrorAltaUsuario.remove();
  }, 5000);
}

// Función para mostrar mensaje correcto en la baja de newsletter
function mostrarMensajeCorrectoAltaUsuario(mensaje) {
  limpiarcajaMensajeErrorAltaUsuario();
  var cajaMensajeErrorAltaUsuario = document.getElementById("cajaMensajeErrorAltaUsuario");
  let mensajeCorrectoAltaUsuario = document.createElement("p");
  mensajeCorrectoAltaUsuario.classList.add("correcto");
  mensajeCorrectoAltaUsuario.innerText = mensaje;
  cajaMensajeErrorAltaUsuario.appendChild(mensajeCorrectoAltaUsuario);
  setTimeout(() => {
    mensajeCorrectoAltaUsuario.remove();
  }, 5000);
}

function limpiarcajaMensajeErrorAltaUsuario() {
  var cajaMensajeErrorAltaUsuario = document.getElementById("cajaMensajeErrorAltaUsuario");
  while (cajaMensajeErrorAltaUsuario.firstChild) {
    cajaMensajeErrorAltaUsuario.removeChild(cajaMensajeErrorAltaUsuario.firstChild);
  }
}



 // -----------------------------------------------------------------
// MENSAJE ERROR LOGIN USUARIO
// -----------------------------------------------------------------

function mostrarMensajeErrorLogearUsuario(mensaje) {
  limpiarcajaMensajeErrorLogearUsuario();
  var cajaMensajeErrorLogearUsario = document.getElementById("cajaMensajeErrorLogearUsuario");
  let mensajeErrorLogearUsuario = document.createElement("p");
  mensajeErrorLogearUsuario.classList.add("incorrecto");
  mensajeErrorLogearUsuario.innerText = mensaje;
  cajaMensajeErrorLogearUsario.appendChild(mensajeErrorLogearUsuario);
  setTimeout(() => {
    mensajeErrorLogearUsuario.remove();
  }, 5000);
}

function mostrarMensajeCorrectoLogearUsuario(mensaje) {
  limpiarcajaMensajeErrorLogearUsuario();
  var cajaMensajeCorrectoAltaUsuario = document.getElementById("cajaMensajeErrorLogearUsuario");
  let mensajeCorrectoLogearUsuario = document.createElement("p");
  mensajeCorrectoLogearUsuario.classList.add("correcto");
  mensajeCorrectoLogearUsuario.innerText = mensaje;
  cajaMensajeCorrectoAltaUsuario.appendChild(mensajeCorrectoLogearUsuario);
  setTimeout(() => {
    mensajeCorrectoLogearUsuario.remove();
  }, 5000);
}

function limpiarcajaMensajeErrorLogearUsuario() {
  var cajaMensajeErrorLogearUsuario = document.getElementById("cajaMensajeErrorLogearUsuario");
  while (cajaMensajeErrorLogearUsuario.firstChild) {
    cajaMensajeErrorLogearUsuario.removeChild(cajaMensajeErrorLogearUsuario.firstChild);
  }
}


 // -----------------------------------------------------------------
// MENSAJE ERROR LOGIN ADMIN
// -----------------------------------------------------------------

function mostrarMensajeErrorLogearAdmin(mensaje) {
  limpiarcajaMensajeErrorLogearAdmin();
  var cajaMensajeErrorLogearAdmin = document.getElementById("cajaMensajeErrorLogearAdmin");
  let mensajeErrorLogearAdmin = document.createElement("p");
  mensajeErrorLogearAdmin.classList.add("incorrecto");
  mensajeErrorLogearAdmin.innerText = mensaje;
  cajaMensajeErrorLogearAdmin.appendChild(mensajeErrorLogearAdmin);
  setTimeout(() => {
    mensajeErrorLogearAdmin.remove();
  }, 5000);
}

function mostrarMensajeCorrectoLogearAdmin(mensaje) {
  limpiarcajaMensajeErrorLogearAdmin();
  var cajaMensajeCorrectoAltaAdmin = document.getElementById("cajaMensajeErrorLogearAdmin");
  let mensajeCorrectoLogearAdmin = document.createElement("p");
  mensajeCorrectoLogearAdmin.classList.add("correcto");
  mensajeCorrectoLogearAdmin.innerText = mensaje;
  cajaMensajeCorrectoAltaAdmin.appendChild(mensajeCorrectoLogearAdmin);
  setTimeout(() => {
    mensajeCorrectoLogearAdmin.remove();
  }, 5000);
}

function limpiarcajaMensajeErrorLogearAdmin() {
  var cajaMensajeErrorLogearAdmin = document.getElementById("cajaMensajeErrorLogearAdmin");
  while (cajaMensajeErrorLogearAdmin.firstChild) {
    cajaMensajeErrorLogearAdmin.removeChild(cajaMensajeErrorLogearAdmin.firstChild);
  }
}


 // -----------------------------------------------------------------
// MENSAJE ERROR Actualizar Jugador
// -----------------------------------------------------------------

function mostrarMensajeErrorModificarJugador(mensaje) {
  limpiarcajaMensajeErrorModificarJugador();
  var cajaMensajeErrorActualizarJugador = document.getElementById("cajaMensajeErrorActualizarJugador");
  let mensajeErrorModificarJugador = document.createElement("p");
  mensajeErrorModificarJugador.classList.add("incorrecto");
  mensajeErrorModificarJugador.innerText = mensaje;
  cajaMensajeErrorActualizarJugador.appendChild(mensajeErrorModificarJugador);
  setTimeout(() => {
      mensajeErrorModificarJugador.remove();
  }, 5000);
}

function mostrarMensajeCorrectoModificarJugador(mensaje) {
  limpiarcajaMensajeErrorModificarJugador();
  var cajaMensajeCorrectoModificarJugador = document.getElementById("cajaMensajeErrorActualizarJugador");
  let mensajeCorrectoModificarJugador = document.createElement("p");
  mensajeCorrectoModificarJugador.classList.add("correcto");
  mensajeCorrectoModificarJugador.innerText = mensaje;
  cajaMensajeCorrectoModificarJugador.appendChild(mensajeCorrectoModificarJugador);
  setTimeout(() => {
      mensajeCorrectoModificarJugador.remove();
  }, 5000);
}

function limpiarcajaMensajeErrorModificarJugador() {
  var cajaMensajeErrorActualizarJugador = document.getElementById("cajaMensajeErrorActualizarJugador");
  cajaMensajeErrorActualizarJugador.innerHTML = "";
}

 // -----------------------------------------------------------------
// MENSAJE ERROR ELIMINAR PERFIL
// -----------------------------------------------------------------

function mostrarMensajeErrorEliminarPerfil(mensaje) {
  limpiarcajaMensajeErrorEliminarPerfil();
  var cajaMensajeErrorEliminarPerfil = document.getElementById("cajaMensajeErrorEliminarPerfil");
  let mensajeErrorEliminarPerfil= document.createElement("p");
  mensajeErrorEliminarPerfil.classList.add("incorrecto");
  mensajeErrorEliminarPerfil.innerText = mensaje;
  cajaMensajeErrorEliminarPerfil.appendChild(mensajeErrorEliminarPerfil);
  setTimeout(() => {
    mensajeErrorEliminarPerfil.remove();
  }, 5000);
}

function mostrarMensajeCorrectoEliminarPerfil(mensaje) {
  limpiarcajaMensajeErrorEliminarPerfil();
  var cajaMensajeErrorEliminarPerfil = document.getElementById("cajaMensajeErrorEliminarPerfil");
  let mensajeErrorEliminarPerfil = document.createElement("p");
  mensajeErrorEliminarPerfil.classList.add("correcto");
  mensajeErrorEliminarPerfil.innerText = mensaje;
  cajaMensajeErrorEliminarPerfil.appendChild(mensajeErrorEliminarPerfil);
  setTimeout(() => {
    mensajeErrorEliminarPerfil.remove();
  }, 5000);
}

function limpiarcajaMensajeErrorEliminarPerfil() {
  var cajaMensajeErrorEliminarPerfil = document.getElementById("cajaMensajeErrorEliminarPerfil");
  cajaMensajeErrorEliminarPerfil.innerHTML = "";
}


 // -----------------------------------------------------------------
// MENSAJE ERROR MODIFICAR JUGADOR COMO ADMIN
// -----------------------------------------------------------------

function mostrarMensajeErrorModificarJugadorAdmin(mensaje) {
  limpiarCajaMensajeErrorModificarJugadorAdmin();
  var cajaMensajeErrorModificarJugadorAdmin = document.getElementById("cajaMensajeErrorModificarJugadorAdmin");
  let mensajeErrorModificarJugadorAdmin = document.createElement("p");
  mensajeErrorModificarJugadorAdmin.classList.add("incorrecto");
  mensajeErrorModificarJugadorAdmin.innerText = mensaje;
  cajaMensajeErrorModificarJugadorAdmin.appendChild(mensajeErrorModificarJugadorAdmin);
  setTimeout(() => {
      mensajeErrorModificarJugadorAdmin.remove();
  }, 5000);
}

function mostrarMensajeCorrectoModificarJugadorAdmin(mensaje) {
  limpiarCajaMensajeErrorModificarJugadorAdmin();
  var cajaMensajeErrorModificarJugadorAdmin = document.getElementById("cajaMensajeErrorModificarJugadorAdmin");
  let mensajeCorrectoModificarJugadorAdmin = document.createElement("p");
  mensajeCorrectoModificarJugadorAdmin.classList.add("correcto");
  mensajeCorrectoModificarJugadorAdmin.innerText = mensaje;
  cajaMensajeErrorModificarJugadorAdmin.appendChild(mensajeCorrectoModificarJugadorAdmin);
  setTimeout(() => {
      mensajeCorrectoModificarJugadorAdmin.remove();
  }, 5000);
}

function limpiarCajaMensajeErrorModificarJugadorAdmin() {
  var cajaMensajeErrorModificarJugadorAdmin = document.getElementById("cajaMensajeErrorModificarJugadorAdmin");
  cajaMensajeErrorModificarJugadorAdmin.innerHTML = "";
}

 // -----------------------------------------------------------------
// MENSAJE ERROR CREAR NUEVA PARTIDA
// -----------------------------------------------------------------
// Funciones para mostrar mensajes de error y éxito
function mostrarMensajeErrorCrearPartida(mensaje) {
    limpiarCajaMensajeErrorCrearPartida();
    var cajaMensajeErrorCrearPartida = document.getElementById("cajaMensajeErrorCrearPartida");
    let mensajeErrorCrearPartida = document.createElement("p");
    mensajeErrorCrearPartida.classList.add("incorrecto");
    mensajeErrorCrearPartida.innerText = mensaje;
    cajaMensajeErrorCrearPartida.appendChild(mensajeErrorCrearPartida);
    setTimeout(() => {
        mensajeErrorCrearPartida.remove();
    }, 5000);
}

function mostrarMensajeCorrectoCrearPartida(mensaje) {
    limpiarCajaMensajeErrorCrearPartida();
    var cajaMensajeErrorCrearPartida = document.getElementById("cajaMensajeErrorCrearPartida");
    let mensajeCorrectoCrearPartida = document.createElement("p");
    mensajeCorrectoCrearPartida.classList.add("correcto");
    mensajeCorrectoCrearPartida.innerText = mensaje;
    cajaMensajeErrorCrearPartida.appendChild(mensajeCorrectoCrearPartida);
    setTimeout(() => {
        mensajeCorrectoCrearPartida.remove();
    }, 5000);
}

function limpiarCajaMensajeErrorCrearPartida() {
    var cajaMensajeErrorCrearPartida = document.getElementById("cajaMensajeErrorCrearPartida");
    cajaMensajeErrorCrearPartida.innerHTML = "";
}



 // -----------------------------------------------------------------
// MENSAJE ERROR Actualizar PARTIDA
// -----------------------------------------------------------------

// Función para mostrar mensajes de error
function mostrarMensajeErrorModificarPartidaAdmin(mensaje) {
  limpiarcajaMensajeErrorModificarPartidaAdmin();
  var cajaMensajeErrorActualizarPartida = document.getElementById("cajaMensajeErrorModificarPartida");
  let mensajeErrorModificarPartida = document.createElement("p");
  mensajeErrorModificarPartida.classList.add("incorrecto");
  mensajeErrorModificarPartida.innerText = mensaje;
  cajaMensajeErrorActualizarPartida.appendChild(mensajeErrorModificarPartida);
  setTimeout(() => {
      mensajeErrorModificarPartida.remove();
  }, 5000);
}

// Función para mostrar mensajes correctos
function mostrarMensajeCorrectoModificarPartidaAdmin(mensaje) {
  limpiarcajaMensajeErrorModificarPartidaAdmin();
  var cajaMensajeErrorActualizarPartida = document.getElementById("cajaMensajeErrorModificarPartida");
  let mensajeCorrectoModificarPartida = document.createElement("p");
  mensajeCorrectoModificarPartida.classList.add("correcto");
  mensajeCorrectoModificarPartida.innerText = mensaje;
  cajaMensajeErrorActualizarPartida.appendChild(mensajeCorrectoModificarPartida);
  setTimeout(() => {
      mensajeCorrectoModificarPartida.remove();
  }, 5000);
}

// Limpiar el contenedor de mensajes
function limpiarcajaMensajeErrorModificarPartidaAdmin() {
  var cajaMensajeErrorActualizarPartida = document.getElementById("cajaMensajeErrorModificarPartida");
  cajaMensajeErrorActualizarPartida.innerHTML = "";
}

 // -----------------------------------------------------------------
// MENSAJE ERROR INSCRIPCION PARTIDA
// -----------------------------------------------------------------

// Función para mostrar mensajes de error
function mostrarMensajeErrorApuntarsePartidaIndividual(mensaje) {
  limpiarcajaMensajeErrorApuntarsePartidaIndividual();
  var cajaMensajeErrorInscripcionPartida = document.getElementById("cajaMensajeErrorInscripcionPartida");
  let mensajeErrorInscripcionPartida = document.createElement("p");
  mensajeErrorInscripcionPartida.classList.add("incorrecto");
  mensajeErrorInscripcionPartida.innerText = mensaje;
  cajaMensajeErrorInscripcionPartida.appendChild(mensajeErrorInscripcionPartida);
  console.log(cajaMensajeErrorInscripcionPartida);
  setTimeout(() => {
    mensajeErrorInscripcionPartida.remove();
  }, 8000);
}

// Función para mostrar mensajes correctos
function mostrarMensajeCorrectoApuntarsePartidaIndividual(mensaje) {
  limpiarcajaMensajeErrorApuntarsePartidaIndividual();
  var cajaMensajeErrorInscripcionPartida = document.getElementById("cajaMensajeErrorInscripcionPartida");
  let mensajeCorrectoInscripcionPartida = document.createElement("p");
  mensajeCorrectoInscripcionPartida.classList.add("correcto");
  mensajeCorrectoInscripcionPartida.innerText = mensaje;
  console.log(cajaMensajeErrorInscripcionPartida);
  cajaMensajeErrorInscripcionPartida.appendChild(mensajeCorrectoInscripcionPartida);
  setTimeout(() => {
    mensajeCorrectoInscripcionPartida.remove();
  }, 8000);
}

// Limpiar el contenedor de mensajes
function limpiarcajaMensajeErrorApuntarsePartidaIndividual() {
  var cajaMensajeErrorInscripcionPartida = document.getElementById("cajaMensajeErrorInscripcionPartida");
  cajaMensajeErrorInscripcionPartida.innerHTML = "";
}


 // -----------------------------------------------------------------
// MENSAJE ERROR INSCRIPCION PARTIDA GRUPAL
// -----------------------------------------------------------------

// Función para mostrar mensajes de error
function mostrarMensajeErrorApuntarsePartidaGrupal(mensaje) {
  limpiarcajaMensajeErrorApuntarsePartidaGrupal();
  var cajaMensajeErrorInscripcionPartidaGrupal = document.getElementById("cajaMensajeErrorInscripcionPartidaGrupal");
  let mensajeErrorInscripcionPartidaGrupal = document.createElement("p");
  mensajeErrorInscripcionPartidaGrupal.classList.add("incorrecto");
  mensajeErrorInscripcionPartidaGrupal.innerText = mensaje;
  cajaMensajeErrorInscripcionPartidaGrupal.appendChild(mensajeErrorInscripcionPartidaGrupal);
  console.log(cajaMensajeErrorInscripcionPartidaGrupal);
  setTimeout(() => {
    mensajeErrorInscripcionPartidaGrupal.remove();
  }, 8000);
}

// Función para mostrar mensajes correctos
function mostrarMensajeCorrectoApuntarsePartidaGrupal(mensaje) {
  limpiarcajaMensajeErrorApuntarsePartidaGrupal();
  var cajaMensajeErrorInscripcionPartidaGrupal = document.getElementById("cajaMensajeErrorInscripcionPartidaGrupal");
  let mensajeCorrectoInscripcionPartidaGrupal = document.createElement("p");
  mensajeCorrectoInscripcionPartidaGrupal.classList.add("correcto");
  mensajeCorrectoInscripcionPartidaGrupal.innerText = mensaje;
  console.log(cajaMensajeErrorInscripcionPartidaGrupal);
  cajaMensajeErrorInscripcionPartidaGrupal.appendChild(mensajeCorrectoInscripcionPartidaGrupal);
  setTimeout(() => {
    mensajeCorrectoInscripcionPartidaGrupal.remove();
  }, 8000);
}

// Limpiar el contenedor de mensajes
function limpiarcajaMensajeErrorApuntarsePartidaGrupal() {
  var cajaMensajeErrorInscripcionPartidaGrupal = document.getElementById("cajaMensajeErrorInscripcionPartidaGrupal");
  cajaMensajeErrorInscripcionPartidaGrupal.innerHTML = "";
}

