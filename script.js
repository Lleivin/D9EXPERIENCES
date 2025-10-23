

// -----------------------------------------------------------------
// ----------------------------------ESTABLECEMOS EL ORDEN AL CARGAR EL DOC
// -----------------------------------------------------------------
document.addEventListener('DOMContentLoaded', function() {
           // Verificar si el formulario 'formularioNewsletter' existe antes de agregar el event listener
    var formularioNewsletter = document.getElementById('formularioNewsletter');
    if (formularioNewsletter) {
        formularioNewsletter.addEventListener('submit', function(event) {
            event.preventDefault(); // Evitar que el formulario se envíe de manera convencional
            procesarNewsletter(); // Llamar a la función para procesar la baja de la newsletter
        });
    }

    // Verificar si el formulario 'formularioBajaNewsletter' existe antes de agregar el event listener
    var formularioBajaNewsletter = document.getElementById('formularioBajaNewsletter');
    if (formularioBajaNewsletter) {
        formularioBajaNewsletter.addEventListener('submit', function(event) {
            event.preventDefault(); // Evitar que el formulario se envíe de manera convencional
            procesarBajaNewsletter(); // Llamar a la función para procesar la baja de la newsletter
        });
    }

    // Verificar si el formulario 'formCrearUsario' existe antes de agregar el event listener
    var formCrearUsario = document.getElementById('formCrearUsario');
    if (formCrearUsario) {
        formCrearUsario.addEventListener('submit', function(event) {
            event.preventDefault(); // Evitar que el formulario se envíe de manera convencional
            crearUsuario(); // Llamar a la función para procesar la baja de la newsletter
        });
    }

    // Verificar si el formulario 'formLoginUsuario' existe antes de agregar el event listener
    var formLoginUsuario = document.getElementById('formLoginUsuario');
    if (formLoginUsuario) {
      formLoginUsuario.addEventListener('submit', function(event) {
            event.preventDefault(); // Evitar que el formulario se envíe de manera convencional
            logearUsuario(); // Llamar a la función para procesar la baja de la newsletter
        });
    }

    // Verificar si el formulario 'formLoginAdmin' existe antes de agregar el event listener
    var formLoginAdmin = document.getElementById('formLoginAdmin');
    if (formLoginAdmin) {
      formLoginAdmin.addEventListener('submit', function(event) {
            event.preventDefault(); // Evitar que el formulario se envíe de manera convencional
            logearAdmin(); // Llamar a la función para procesar la baja de la newsletter
        });
    }

    var formModificarJugador = document.getElementById('formModificarJugador');
    if (formModificarJugador) {
        formModificarJugador.addEventListener('submit', function(event) {
            event.preventDefault();
            actualizarUsuario();
        });
    }

    var aceptarEliminar = document.getElementById('aceptarEliminar');
    if (aceptarEliminar) {
        aceptarEliminar.addEventListener('click', function(event) {
            event.preventDefault();
            console.log('Botón clickeado');
            eliminarPerfil();
        });
    } else {
        console.log('El botón Aceptar Eliminar no se encontró');
    }

    var AdministradorCambiarJugadores = document.getElementById('formAdministradorCambiarJugadores');
    if (AdministradorCambiarJugadores) {
        AdministradorCambiarJugadores.addEventListener('submit', function(event) {
            event.preventDefault();
            console.log('Entra formulario admin cambio de jugador');
            AdministradorModificarJugadores();
        });
    } else {
        console.log('El formulario de cambio de jugador admin no se encontró');
    }

    document.querySelectorAll('.bloquearJugador').forEach(function(button) {
      button.addEventListener('click', function(event) {
          event.preventDefault();
          var dni = this.getAttribute('data-dni'); // Obtener el DNI del atributo data-dni
          bloquearJugador(dni);
      });
    });

    document.querySelectorAll('.desbloquearJugador').forEach(function(button) {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            var dni = this.getAttribute('data-dni'); // Obtener el DNI del atributo data-dni
            desbloquearJugador(dni);
        });
    });

    // Eliminar Jugador como admin
    document.querySelectorAll('.adminEliminarJugadorSelec').forEach(function(button) {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            var dni = this.getAttribute('data-dni');
            if (dni) {
                console.log('Guardando DNI en el botón aceptar:', dni);
                document.getElementById('adminaceptarEliminar').setAttribute('data-dni', dni);
                document.getElementById('adminoverlay').classList.remove('d-none');
                document.getElementById('admineliminarPerfilCaja').classList.remove('d-none');
            } else {
                console.log('El campo dni no tiene valor.');
            }
        });
    });

    // Eliminar partida como admin
    document.querySelectorAll('.adminEliminarPartidaSelec').forEach(function(button) {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            var idPartida = this.getAttribute('data-idPartida'); // Obtener el IdPartida del atributo data-IdPartida
            if (idPartida) {
                console.log('Intentando eliminar en Admin una Partida:', idPartida);
                admineliminarPartida(idPartida);
            } else {
                console.log('El campo idPartida no tiene valor.');
            }
        });
    });

    // Cancelar partida como admin
    document.querySelectorAll('.adminCancelarrPartidaSelec').forEach(function(button) {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            var idPartida = this.getAttribute('data-idPartida'); // Obtener el IdPartida del atributo data-IdPartida
            if (idPartida) {
                console.log('Intentando Cancelar en Admin una Partida:', idPartida);
                adminCancelarPartida(idPartida);
            } else {
                console.log('El campo idPartida no tiene valor.');
            }
        });
    });

    // Descancelar partida como admin
    document.querySelectorAll('.admindesCancelarrPartidaSelec').forEach(function(button) {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            var idPartida = this.getAttribute('data-idPartida'); // Obtener el IdPartida del atributo data-IdPartida
            if (idPartida) {
                console.log('Intentando Reactivar en Admin una Partida:', idPartida);
                adminDesCancelarPartida(idPartida);
            } else {
                console.log('El campo idPartida no tiene valor.');
            }
        });
    });

    // Crear partida como admin
    var formCrearPartida = document.getElementById('formCrearPartida');
    if (formCrearPartida) {
        formCrearPartida.addEventListener('submit', function(event) {
              event.preventDefault(); // Evitar que el formulario se envíe de manera convencional
              crearPartida(); // Llamar a la función para procesar la baja de la newsletter
          });
    }

    // Modificar partida como admin
    var formAdministradorCambiarPartidas = document.getElementById('formAdministradorCambiarPartidas');
    if (formAdministradorCambiarPartidas) {
        formAdministradorCambiarPartidas.addEventListener('submit', function (event) {
              event.preventDefault();
              console.log('Entra formulario admin cambio de partida');
              AdministradorModificarPartidas(); // Asegúrate de llamar la función con el nombre correcto
          });
    } else {
        console.log('El formulario de cambio de partida admin no se encontró');
    }

    // INSCRIBIRSE EN LA PARTIDA INDIVIDUAL
    var formApuntarsePartidas = document.getElementById('formApuntarsePartidas');
    if (formApuntarsePartidas) {
        formApuntarsePartidas.addEventListener('submit', function(event) {
              event.preventDefault(); // Evitar que el formulario se envíe de manera convencional
              apuntarsePartidaIndividual(); // Llamar a la función para procesar la baja de la newsletter
          });
    }

    // INSCRIBIRSE EN LA PARTIDA GRUPAL
    var formApuntarsePartidasGrupal = document.getElementById('formApuntarsePartidasGrupal');
    if (formApuntarsePartidasGrupal) {
        formApuntarsePartidasGrupal.addEventListener('submit', function(event) {
              event.preventDefault(); // Evitar que el formulario se envíe de manera convencional
              ApuntarsePartidasGrupal(); // Llamar a la función para procesar la baja de la newsletter
          });
    }

    // Eliminar reserva por jugador
    document.querySelectorAll('.jugadorDesapuntarPartidaSelec').forEach(function(button) {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            var idReserva = this.getAttribute('data-reserva'); // Obtener el IdPartida del atributo data-IdPartida
            if (idReserva) {
                console.log('Intentando desapuntar jugador partida:', idReserva);
                jugadorEliminarReserva(idReserva);
            } else {
                console.log('El campo idReserva no tiene valor.');
            }
        });
    });

        // --//cierre
      }
);

// -----------------------------------------------------------------
// ----------------------------------SCRIP PARA MENU DESPLEGABLE
// -----------------------------------------------------------------
function toggleSubMenu() {
    var submenu = document.getElementById("submenu");
    submenu.classList.toggle("show");
  }
  // -----------------------------------------------------------------
  // ------------------------------SUBMENU: Función para mostrar u ocultar el nuevo submenú al hacer hover sobre el submenú principal
  function toggleSubSubMenu() {
    var subSubMenu = document.getElementById("subsubmenu");
    subSubMenu.classList.toggle("show");
  }

// -----------------------------------------------------------------
  //  ------------------------------ PROCESAR NEWSLETTER CON FETCH
// -----------------------------------------------------------------

  function procesarNewsletter() {
    // Obtener el correo electrónico y el estado del checkbox
    var email = document.getElementById("emailAltaBajaNewsletter").value;
    var aceptoTerminos = document.getElementById("aceptoTerminos").checked;

    var tipoFuncion ="funcionAltaNewsletter"

    // Crear un nuevo objeto FormData
    var formData = new FormData();
    
    // Agregar el correo electrónico al objeto FormData
    formData.append('emailAltaBajaNewsletter', email);
    // Agregar el estado de aceptoTerminos al objeto FormData
    formData.append('aceptoTerminos', aceptoTerminos ? '1' : '0');
    //agregar para validar tipo de funcion a llamar
    formData.append('tipoFuncion', tipoFuncion);
  
    // Enviar los datos del formulario al servidor
    fetch("funciones.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        mensajeError = data.mensajeError;
        mensaje = data.mensaje;
        console.log(mensajeError);
        console.log(mensaje);
         if (mensajeError === false) {
             // Si mensajeError es false, mostrar mensaje de error
             mostrarMensajeError(mensaje);
         } else{
          mostrarMensajeCorrecto(mensaje);
         }
         document.getElementById("formularioNewsletter").reset();
    })
    .catch(error => {
        console.error("Error de fetch:", error);
    });
  }
  
// -----------------------------------------------------------------
  //  PROCESAR DARSE DE BAJA NEWSLETTER
// -----------------------------------------------------------------

  function procesarBajaNewsletter() {
    // Obtener el correo electrónico
    var emailBajaNewsletter = document.getElementById("emailBajaNewsletter").value;

    // Agregar el tipo de función para validar
    var tipoFuncion = "funcionBajaNewsletter";

    // Crear un nuevo objeto FormData
    var formDataBaja = new FormData();
    formDataBaja.append('emailBajaNewsletter', emailBajaNewsletter);
    formDataBaja.append('tipoFuncion', tipoFuncion);

    // Enviar los datos del formulario al servidor
    fetch("funciones.php", {
        method: "POST",
        body: formDataBaja
    })
    .then(response => response.json())
    .then(data => {
        mensajeError = data.mensajeError;
    mensaje = data.mensaje;
    console.log(mensajeError);
    console.log(mensaje);
        // Verificar el resultado de la validación
        if (data.mensajeError === false) {
            mostrarMensajeErrorBajaNewsletter(mensaje);
        } else {
            mostrarMensajeCorrectoBajaNewsletter(mensaje);
            // Redirige a login.php después de mostrar el mensaje correcto
        setTimeout(() => {
          window.location.href = 'index.php';
      }, 3000); // 2 segundos de retraso para que el mensaje se muestre

        }
        document.getElementById("formularioBajaNewsletter").reset();
    })
    .catch(error => {
        console.error("Error de fetch:", error);
    });
}


// -----------------------------------------------------------------
  //  PROCESAR DARSE DE ALTA USUARIO
// -----------------------------------------------------------------

function crearUsuario(){
  var AltaDNI = document.getElementById("AltaDNI").value;
  var AltaNombre = document.getElementById("AltaNombre").value;
  var AltaNick = document.getElementById("AltaNick").value;
  var AltaApellido = document.getElementById("AltaApellido").value;
  var AltaApellido2 = document.getElementById("AltaApellido2").value;
  var AltaFechaNacimiento = document.getElementById("AltaFechaNacimiento").value;
  var AltaTelefono = document.getElementById("AltaTelefono").value;
  var AltaEmail = document.getElementById("AltaEmail").value;
  var AltaPassword = document.getElementById("AltaPassword").value;
  var AltaRepetirPassword = document.getElementById("AltaRepetirPassword").value;

  // Agregar el tipo de función para validar
  var tipoFuncion = "funcionAltaUsuario";

    // Crear un nuevo objeto FormData
    var formDataAltaUsario = new FormData();
    //agregamos el tipo de funcion
    formDataAltaUsario.append('tipoFuncion', tipoFuncion);
    // Agregar el correo electrónico al objeto FormData
    formDataAltaUsario.append('AltaDNI', AltaDNI);
    formDataAltaUsario.append('AltaNombre', AltaNombre);
    formDataAltaUsario.append('AltaNick', AltaNick);
    formDataAltaUsario.append('AltaApellido', AltaApellido);
    formDataAltaUsario.append('AltaApellido2', AltaApellido2);
    formDataAltaUsario.append('AltaFechaNacimiento', AltaFechaNacimiento);
    formDataAltaUsario.append('AltaTelefono', AltaTelefono);
    formDataAltaUsario.append('AltaEmail', AltaEmail);
    formDataAltaUsario.append('AltaPassword', AltaPassword);
    formDataAltaUsario.append('AltaRepetirPassword', AltaRepetirPassword);
    
    // Enviar los datos del formulario al servidor
    fetch("funciones.php", {
      method: "POST",
      body: formDataAltaUsario
  })
  .then(response => response.text()) // Cambia a .text() para ver qué devuelve el servidor
  .then(data => {
      console.log("Respuesta del servidor:", data); // Mostrar la respuesta completa en el log
      try {
          var jsonResponse = JSON.parse(data); // Intentar convertir a JSON manualmente
          if (jsonResponse.mensajeError === false) {
              mostrarMensajeErrorAltaUsuario(jsonResponse.mensaje);
          } else {
              mostrarMensajeCorrectoAltaUsuario(jsonResponse.mensaje);
              setTimeout(() => {
                  window.location.href = 'login.php';
              }, 2000);
          }
      } catch (e) {
          console.error("No es un JSON válido:", e, data);
          mostrarMensajeErrorAltaUsuario("Error en la respuesta del servidor.");
      }
  })
  .catch(error => {
      console.error("Error de red:", error);
      mostrarMensajeErrorAltaUsuario("Error de red o servidor.");
  });
}



// -----------------------------------------------------------------
  //  PROCESAR LOGEAR USUARIO
// -----------------------------------------------------------------

function logearUsuario(){
  var usuarioJugador = document.getElementById("usuarioJugador").value;
  var passwordUsuario = document.getElementById("passwordUsuario").value;
  
  // Agregar el tipo de función para validar
  var tipoFuncion = "funcionlogearUsuario";

    // Crear un nuevo objeto FormData
    var formDataLogearUsario = new FormData();
    //agregamos el tipo de funcion
    formDataLogearUsario.append('tipoFuncion', tipoFuncion);
    // Agregar el correo electrónico al objeto FormData
    formDataLogearUsario.append('usuarioJugador', usuarioJugador);
    formDataLogearUsario.append('passwordUsuario', passwordUsuario);
    
    
    // Enviar los datos del formulario al servidor
    fetch("funciones.php", {
      method: "POST",
      body: formDataLogearUsario
    })
    .then(response => response.json())
    .then(data => {
      mensajeError = data.mensajeError;
      mensaje = data.mensaje;
        console.log(mensajeError);
        console.log(mensaje);
      // Verificar el resultado de la validación
      if (mensajeError == false) {
        mostrarMensajeErrorLogearUsuario(mensaje);
      } else {
        mostrarMensajeCorrectoLogearUsuario(mensaje);
        // Redirige a login.php después de mostrar el mensaje correcto
        setTimeout(() => {
          window.location.href = 'index.php';
      }, 1000); // 2 segundos de retraso para que el mensaje se muestre

      }
      document.getElementById("formLoginUsuario").reset();
    })
    .catch(error => {
      console.error("Error de fetch:", error);
    });
}

// -----------------------------------------------------------------
  //  PROCESAR LOGEAR ADMIN
// -----------------------------------------------------------------
function logearAdmin(){
  var usuarioAdmin = document.getElementById("usuarioAdmin").value;
  var passwordAdmin = document.getElementById("passwordAdmin").value;
  
  // Agregar el tipo de función para validar
  var tipoFuncion = "funcionlogearAdmin";

    // Crear un nuevo objeto FormData
    var formDataLogearAdmin= new FormData();
    //agregamos el tipo de funcion
    formDataLogearAdmin.append('tipoFuncion', tipoFuncion);
    // Agregar el correo electrónico al objeto FormData
    formDataLogearAdmin.append('usuarioAdmin', usuarioAdmin);
    formDataLogearAdmin.append('passwordAdmin', passwordAdmin);
    
    
    // Enviar los datos del formulario al servidor
    fetch("funciones.php", {
      method: "POST",
      body: formDataLogearAdmin
    })
    .then(response => response.json())
    .then(data => {
      mensajeError = data.mensajeError;
      mensaje = data.mensaje;
        console.log(mensajeError);
        console.log(mensaje);
      // Verificar el resultado de la validación
      if (mensajeError == false) {
        mostrarMensajeErrorLogearAdmin(mensaje);
        
      } else {
        mostrarMensajeCorrectoLogearAdmin(mensaje);
        // Redirige a login.php después de mostrar el mensaje correcto
        setTimeout(() => {
          window.location.href = 'index.php';
      }, 1000); // 2 segundos de retraso para que el mensaje se muestre

      }
      document.getElementById("formLoginAdmin").reset();
    })
    .catch(error => {
      console.error("Error de fetch:", error);
    });
} 
// -----------------------------------------------------------------
  //  modificarJugador
// -----------------------------------------------------------------

function actualizarUsuario() {
  var dniSesionActivaJugadormodificar = document.getElementById("dniSesionActivaJugadormodificar").value;
  var actualizaNombre = document.getElementById("actualizaNombre").value;
  var actualizaApellido = document.getElementById("actualizaApellido").value;
  var actualizaApellido2 = document.getElementById("actualizaApellido2").value;
  // var actualizaFecha = document.getElementById("actualizaFecha").value;
  var actualizaTelefono = document.getElementById("actualizaTelefono").value;
  var actualizaNick = document.getElementById("actualizaNick").value;
  var actualizaContrasena = document.getElementById("nuevaContrasenaJugador").value;
  var actualizaContrasena2 = document.getElementById("nuevaContrasenaJugador2").value;

  console.log(dniSesionActivaJugadormodificar);
  console.log(actualizaNombre);
  console.log(actualizaApellido);
  console.log(actualizaApellido2);
  //console.log(actualizaFecha);
  console.log(actualizaTelefono);
  console.log(actualizaNick);
  console.log(actualizaContrasena);
  console.log(actualizaContrasena2);

  // Agregar el tipo de función para validar
  var tipoFuncion = "funcionModificarJugador";

  // Crear un nuevo objeto FormData
  var formDataModificarJugador = new FormData();
  //Agregar el tipo de función y los datos al objeto FormData
  formDataModificarJugador.append('tipoFuncion', tipoFuncion);
  formDataModificarJugador.append('dniSesionActivaJugadormodificar', dniSesionActivaJugadormodificar);
  formDataModificarJugador.append('actualizaNombre', actualizaNombre);
  formDataModificarJugador.append('actualizaApellido', actualizaApellido);
  formDataModificarJugador.append('actualizaApellido2', actualizaApellido2);
  // formDataModificarJugador.append('actualizaFecha', actualizaFecha);
  formDataModificarJugador.append('actualizaTelefono', actualizaTelefono);
  formDataModificarJugador.append('actualizaNick', actualizaNick);
  formDataModificarJugador.append('actualizaContrasena', actualizaContrasena);
  formDataModificarJugador.append('actualizaContrasena2', actualizaContrasena2);

  // Enviar los datos del formulario al servidor
  fetch("funciones.php", {
    method: "POST",
    body: formDataModificarJugador
  })
  .then(response => response.text())  // Cambiar a text() para obtener la respuesta cruda
  .then(text => {
    console.log("Respuesta del servidor:", text);  // Imprimir la respuesta cruda

    try {
      const data = JSON.parse(text);  // Intentar analizar como JSON
      console.log("Datos analizados:", data);

      // Verificar el resultado de la validación
      if (data.mensajeError == false) {
        mostrarMensajeCorrectoModificarJugador(data.mensaje);
                      // Redirige a login.php después de mostrar el mensaje correcto
                      setTimeout(() => {
                        window.location.href = 'perfil.php';
                    }, 800); // 2 segundos de retraso para que el mensaje se muestre
        
      } else {
        mostrarMensajeErrorModificarJugador(data.mensaje);
      }
      document.getElementById("formModificarJugador").reset();
    } catch (e) {
      console.error("Error al analizar JSON:", e);
      mostrarMensajeErrorModificarJugador("Error al procesar la respuesta del servidor.");
    }
  })
  .catch(error => {
    console.error("Error de fetch:", error);
    mostrarMensajeErrorModificarJugador("Error de red o servidor.");
  });
}

// -----------------------------------------------------------------
  //  PROCESAR ELIMINAR PERFIL desde Usuario
// -----------------------------------------------------------------

function eliminarPerfil() {
  console.log('Eliminar Perfil llamado');

  var dniSesionActivaJugadormodificar = document.getElementById("dniSesionActivaJugadormodificar")?.value;

  if (!dniSesionActivaJugadormodificar) {
      console.error('El campo dniSesionActivaJugadormodificar no tiene valor.');
      return;
  }

  var tipoFuncion = "funcionEliminarPerfil";

  var formDataEliminarPerfil = new FormData();
  formDataEliminarPerfil.append('tipoFuncion', tipoFuncion);
  formDataEliminarPerfil.append('dniSesionActivaJugadormodificar', dniSesionActivaJugadormodificar);

  fetch("funciones.php", {
      method: "POST",
      body: formDataEliminarPerfil
  })
  .then(response => response.text())
  .then(text => {
      console.log("Respuesta del servidor:", text);

      try {
          const data = JSON.parse(text);
          console.log("Datos analizados:", data);

          if (data.mensajeError === false) {
              mostrarMensajeCorrectoEliminarPerfil(data.mensaje);
              // Redirige a login.php después de mostrar el mensaje correcto
              setTimeout(() => {
                window.location.href = 'login.php';
            }, 3000); // 2 segundos de retraso para que el mensaje se muestre
          } else {
              mostrarMensajeErrorEliminarPerfil(data.mensaje);
          }
      } catch (e) {
          console.error("Error al analizar JSON:", e);
          mostrarMensajeErrorEliminarPerfil("Error al procesar la respuesta del servidor.");
      }
  })
  .catch(error => {
      console.error("Error de fetch:", error);
      mostrarMensajeErrorEliminarPerfil("Error de red o servidor.");
  });
}

// -----------------------------------------------------------------
  //  PROCESAR MODIFICAR JUGADORES DESDE ADMIN
// -----------------------------------------------------------------


              function AdministradorModificarJugadores() {
                var dniJugadorSeleccionadoAdmin = document.getElementById("dniJugadorSeleccionadoAdmin").value;
                var actualizaNombre = document.getElementById("actualizaNombre").value;
                var actualizaApellido = document.getElementById("actualizaApellido").value;
                var actualizaApellido2 = document.getElementById("actualizaApellido2").value;
                var actualizaTelefono = document.getElementById("actualizaTelefono").value;
                var actualizaNick = document.getElementById("actualizaNick").value;
                var actualizaContrasena = document.getElementById("nuevaContrasenaJugador").value;
                var actualizaContrasena2 = document.getElementById("nuevaContrasenaJugador2").value;

                var tipoFuncion = "funcionModificarJugadorAdmin";

                var funcionModificarJugadorAdmin = new FormData();
                funcionModificarJugadorAdmin.append('tipoFuncion', tipoFuncion);
                funcionModificarJugadorAdmin.append('dniJugadorSeleccionadoAdmin', dniJugadorSeleccionadoAdmin);
                funcionModificarJugadorAdmin.append('actualizaNombre', actualizaNombre);
                funcionModificarJugadorAdmin.append('actualizaApellido', actualizaApellido);
                funcionModificarJugadorAdmin.append('actualizaApellido2', actualizaApellido2);
                funcionModificarJugadorAdmin.append('actualizaTelefono', actualizaTelefono);
                funcionModificarJugadorAdmin.append('actualizaNick', actualizaNick);
                funcionModificarJugadorAdmin.append('actualizaContrasena', actualizaContrasena);
                funcionModificarJugadorAdmin.append('actualizaContrasena2', actualizaContrasena2);

                fetch("funciones.php", {
                    method: "POST",
                    body: funcionModificarJugadorAdmin
                })
                .then(response => response.text())
                .then(text => {
                    console.log("Respuesta del servidor:", text);
                    try {
                        const data = JSON.parse(text);
                        console.log("Datos analizados:", data);
                        if (data.mensajeError == false) {
                            mostrarMensajeCorrectoModificarJugadorAdmin(data.mensaje);
                            setTimeout(() => {
                                window.location.href = 'administracion.php';
                            }, 2000); 
                        } else {
                            mostrarMensajeErrorModificarJugadorAdmin(data.mensaje);
                        }
                        document.getElementById("formAdministradorCambiarJugadores").reset();
                    } catch (e) {
                        console.error("Error al analizar JSON:", e);
                        mostrarMensajeErrorModificarJugadorAdmin("Error al procesar la respuesta del servidor.");
                    }
                })
                .catch(error => {
                    console.error("Error de fetch:", error);
                    mostrarMensajeErrorModificarJugadorAdmin("Error de red o servidor.");
                });
              }


// -----------------------------------------------------------------
  //  BLOQUEAR JUGADOR DESDE ADMIN
// -----------------------------------------------------------------


            // Definición de la función bloquearJugador
            function bloquearJugador(dni) {
              console.log('Intentando bloquear jugador con DNI:', dni);
              $.ajax({
                  url: 'funciones.php',
                  type: 'POST',
                  data: { dni: dni, tipoFuncion: 'funcionBloquearJugador' },
                  success: function(response) {
                      console.log('Respuesta del servidor:', response);
                      var jsonResponse = JSON.parse(response);
                      if (jsonResponse.mensajeError) {
                          alert('Error: ' + jsonResponse.mensaje);
                      } else {
                          // Insertar mensaje de bloqueo con formato HTML
                          var mensajeBloqueo = 'El jugador <b>' + dni + '</b> ha sido <strong>bloqueado</strong>';
                          $('#mensajeBloqueo').html(mensajeBloqueo);
                          $('#adminoverlay').removeClass('d-none');
                          $('#mensajeJugadorbloqueado').removeClass('d-none');
                          // Recargar la página para ver los cambios después de un breve retraso
                          setTimeout(function() {
                              location.reload();
                          }, 2000);
                      }
                  },
                  error: function() {
                      alert('Error al intentar bloquear al jugador.');
                  }
              });
            }

// -----------------------------------------------------------------
  //  PROCESAR DESBLOQUEAR JUGADOR DESDE ADMIN
// -----------------------------------------------------------------

// Definición de la función desbloquearJugador
            function desbloquearJugador(dni) {
              console.log('Intentando desbloquear jugador con DNI:', dni);
              $.ajax({
                  url: 'funciones.php',
                  type: 'POST',
                  data: { dni: dni, tipoFuncion: 'funciondesBloquearJugador' },
                  success: function(response) {
                      console.log('Respuesta del servidor:', response);
                      var jsonResponse = JSON.parse(response);
                      if (jsonResponse.mensajeError) {
                          alert('Error: ' + jsonResponse.mensaje);
                      } else {
                        // Insertar mensaje de bloqueo con formato HTML
                        var mensajeBloqueo = 'El jugador <b>' + dni + '</b> ha sido <strong>desbloqueado</strong>';
                        $('#mensajeBloqueo').html(mensajeBloqueo);
                        $('#adminoverlay').removeClass('d-none');
                        $('#mensajeJugadorbloqueado').removeClass('d-none');
                        // Recargar la página para ver los cambios después de un breve retraso
                        setTimeout(function() {
                            location.reload();
                        }, 2000);          }
                  },
                  error: function() {
                      alert('Error al intentar desbloquear al jugador.');
                  }
              });
            }

// -----------------------------------------------------------------
  //  PROCESAR ELIMINAR JUGADOR DESDE ADMIN
// -----------------------------------------------------------------

            function admineliminarjugador(dni) {
              $.ajax({
                url: 'funciones.php',
                type: 'POST',
                data: { dni: dni, tipoFuncion: 'funcionadmineliminarjugador' },
                success: function(response) {
                    console.log('Respuesta del servidor:', response);
                    var jsonResponse = JSON.parse(response);
                    if (jsonResponse.mensajeError) {
                        alert('Error: ' + jsonResponse.mensaje);
                    } else {
                        // Insertar mensaje de jugador eliminado con formato HTML
                        var mensajeEliminadoAdmin = 'El jugador <b>' + dni + '</b> ha sido <strong>eliminado</strong>';
                        $('#mensajeEliminadoAdmin').html(mensajeEliminadoAdmin);
                        $('#adminoverlay2').removeClass('d-none');
                        $('#mensajeJugadorbEliminadoAdmin').removeClass('d-none'); // Cambia aquí el ID
                        // Recargar la página para ver los cambios después de un breve retraso
                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    }
                },
                error: function() {
                    alert('Error al intentar eliminar al jugador.');
                }
            });
            }

// -----------------------------------------------------------------
  //  PROCESAR CREAR PARTIDA COMO ADMIN
// -----------------------------------------------------------------

          function crearPartida(){
            //valores extraidos del formulario
            var idCampoJuego = document.getElementById("campoJuego").value;
            var nombrePartida = document.getElementById("nombrePartida").value;
            var fechaPartida = document.getElementById("fechaPartida").value;
            var horaPartida = document.getElementById("horaPartida").value;
            var precioPartida = document.getElementById("precioPartida").value;
            var maximoJugadoresPartida = document.getElementById("maximoJugadoresPartida").value;
            var portadaPartida = document.getElementById("portadaPartida").value;
            var descripcionPartida = document.getElementById("descripcionPartida").value;
            //resto de valores necesarios


            // Agregar el tipo de función para validar
            var tipoFuncion = "funcionNuevaPartida";

              // Crear un nuevo objeto FormData
              var formDatanuevaPartida = new FormData();
              //agregamos el tipo de funcion
              formDatanuevaPartida.append('tipoFuncion', tipoFuncion);
              // Agregar el correo electrónico al objeto FormData
              formDatanuevaPartida.append('idCampoJuego', idCampoJuego);
              formDatanuevaPartida.append('nombrePartida', nombrePartida);
              formDatanuevaPartida.append('fechaPartida', fechaPartida);
              formDatanuevaPartida.append('horaPartida', horaPartida);
              formDatanuevaPartida.append('precioPartida', precioPartida);
              formDatanuevaPartida.append('maximoJugadoresPartida', maximoJugadoresPartida);
              formDatanuevaPartida.append('portadaPartida', portadaPartida);
              formDatanuevaPartida.append('descripcionPartida', descripcionPartida);
              
              
              // Enviar los datos del formulario al servidor
              fetch("funciones.php", {
                method: "POST",
                body: formDatanuevaPartida
              })
              .then(response => response.json())
              .then(data => {
                let mensajeError = data.mensajeError; // Capturar el valor de mensajeError del servidor
                let mensaje = data.mensaje;

                console.log(mensajeError);
                console.log(mensaje);

                // Verificar el resultado de la validación
                if (!mensajeError) {  // Si mensajeError es false, la operación fue exitosa
                  mostrarMensajeCorrectoCrearPartida(mensaje);
                  document.getElementById("formCrearPartida").reset();
                  setTimeout(() => {
                    window.location.href = 'administracion.php';
                  }, 3000);
                } else {  // Si mensajeError es true, hubo un error
                  mostrarMensajeErrorCrearPartida(mensaje);
                }
              })
              .catch(error => {
                console.error("Error de fetch:", error);
              });

          }


          
// -----------------------------------------------------------------
  //  PROCESO DE VER PARTIDAS EN CUADRO ADMIN
// -----------------------------------------------------------------

function buscarPartida() {
  document.getElementById('BuscarPartida').addEventListener('input', function() {
    const query = this.value;
    
      // Verifica que el campo no esté vacío
      if (query.length > 0) {
          fetch('funciones.php', {
              method: 'POST',
              headers: {
                  'Content-Type': 'application/x-www-form-urlencoded'
              },
              body: new URLSearchParams({
                  'BuscarPartida': query
              })
          })
          .then(response => response.text())
          .then(data => {
              document.getElementById('resultadosPartidas').innerHTML = data;
          })
          .catch(error => console.error('Error:', error));
      } else {
          // Si el campo está vacío, limpia la tabla
          document.getElementById('resultadosPartidas').innerHTML = '';
      }
  });


}


// -----------------------------------------------------------------
  //  PROCESO DE MODIFFICAR PARTIDA
// -----------------------------------------------------------------
function AdministradorModificarPartidas(idPartida) {
  var idPartida = document.getElementById("idPartida").value;
  var idCampo = document.getElementById("campoJuego").value;
  var nombrePartida = document.getElementById("nombrePartida").value;
  var fecha = document.getElementById("fechaPartida").value;
  var horaPartida = document.getElementById("horaPartida").value;
  var precioPartida = document.getElementById("precioPartida").value;
  var numeroJugadores = document.getElementById("maximoJugadoresPartida").value;
  var descripcionPartida = document.getElementById("descripcionPartida").value;

  var tipoFuncion = "funcionModificarPartidaAdmin";

  var funcionModificarPartidaAdmin = new FormData();
  funcionModificarPartidaAdmin.append('tipoFuncion', tipoFuncion);
  funcionModificarPartidaAdmin.append('idPartida', idPartida);
  funcionModificarPartidaAdmin.append('idCampo', idCampo);
  funcionModificarPartidaAdmin.append('nombrePartida', nombrePartida);
  funcionModificarPartidaAdmin.append('fecha', fecha);
  funcionModificarPartidaAdmin.append('horaPartida', horaPartida);
  funcionModificarPartidaAdmin.append('precioPartida', precioPartida);
  funcionModificarPartidaAdmin.append('numeroJugadores', numeroJugadores);
  funcionModificarPartidaAdmin.append('descripcionPartida', descripcionPartida);

  fetch("funciones.php", {
      method: "POST",
      body: funcionModificarPartidaAdmin
  })
  .then(response => response.text())
  .then(text => {
      console.log("Respuesta del servidor:", text);
      try {
          const data = JSON.parse(text);
          console.log("Datos analizados:", data);
          if (data.mensajeError == false) {
              // Mostrar mensaje de éxito
              mostrarMensajeCorrectoModificarPartidaAdmin(data.mensaje);

              // Aquí puedes redirigir si todo fue exitoso
              setTimeout(() => {
                  window.location.href = 'administracion.php';
              }, 2000);

          } else {
              // Mostrar mensaje de error sin recargar la página
              mostrarMensajeErrorModificarPartidaAdmin(data.mensaje);

              // Si se indica un campo vacío, lo enfocas
              if (data.campoVacio) {
                  document.getElementById(data.campoVacio).focus();
              }
          }
      } catch (e) {
          console.error("Error al analizar JSON:", e);
          mostrarMensajeErrorModificarPartidaAdmin("Error al procesar la respuesta del servidor.");
      }
  })
  .catch(error => {
      console.error("Error de fetch:", error);
      mostrarMensajeErrorModificarPartidaAdmin("Error de red o servidor.");
  });

}


// -----------------------------------------------------------------
  //  PROCESAR ELIMINAR Partida DESDE ADMIN
// -----------------------------------------------------------------

function admineliminarPartida(idPartida) {
  $.ajax({
      url: 'funciones.php',
      type: 'POST',
      data: { idPartida: idPartida, tipoFuncion: 'funcionadmineliminarPartida' },
      success: function(response) {
          console.log('Respuesta del servidor:', response);
          var jsonResponse = JSON.parse(response);
          if (jsonResponse.mensajeError) {
          } else {
              // Insertar mensaje de partida eliminada con formato HTML
              var mensajeEliminadoAdmin = 'La partida <b>' + idPartida + '</b> ha sido <strong>eliminada</strong>';
              $('#mensajeEliminadoAdmin').html(mensajeEliminadoAdmin);
              $('#adminoverlay2').removeClass('d-none');
              $('#mensajePartidaEliminadaAdmin').removeClass('d-none'); 
              // Recargar la página para ver los cambios después de un breve retraso
              setTimeout(function() {
                  location.reload();
              }, 2000);
          }
      },
      error: function() {
          alert('Error al intentar eliminar la partida.');
      }
  });
}



// -----------------------------------------------------------------
  //  PROCESAR CANCELAR Partida DESDE ADMIN
// -----------------------------------------------------------------

function adminCancelarPartida(idPartida) {
  $.ajax({
      url: 'funciones.php',
      type: 'POST',
      data: { idPartida: idPartida, tipoFuncion: 'funcionadminCancelarPartida' },
      success: function(response) {
          console.log('Respuesta del servidor:', response);
          var jsonResponse = JSON.parse(response);
          if (jsonResponse.mensajeError) {
              // Aquí puedes manejar el caso de error.
          } else {
              // Insertar mensaje de partida eliminada con formato HTML
              var mensajeCanceladodoAdmin = 'La partida <b>' + idPartida + '</b> ha sido <strong>Cancelada</strong>';
              $('#mensajeCanceladodoAdmin').html(mensajeCanceladodoAdmin);
              $('#adminoverlayCancelarPartida').removeClass('d-none');
              $('#mensajePartidaCanceladaAdmin').removeClass('d-none'); 
              // Recargar la página para ver los cambios después de un breve retraso
              setTimeout(function() {
                  location.reload();
              }, 2000);
          }
      },
      error: function() {
          alert('Error al intentar Cancelar la partida.');
      }
  });
}

// -----------------------------------------------------------------
  //  PROCESAR DESCANCELAR Partida DESDE ADMIN
// -----------------------------------------------------------------

function adminDesCancelarPartida(idPartida) {
  $.ajax({
      url: 'funciones.php',
      type: 'POST',
      data: { idPartida: idPartida, tipoFuncion: 'funcionadminDesCancelarPartida' },
      success: function(response) {
          console.log('Respuesta del servidor:', response);
          var jsonResponse = JSON.parse(response);
          if (jsonResponse.mensajeError) {
              // Aquí puedes manejar el caso de error.
          } else {
              // Insertar mensaje de partida eliminada con formato HTML
              var mensajeDesCanceladodoAdmin = 'La partida <b>' + idPartida + '</b> ha sido <strong>Activada</strong>';
              $('#mensajeDesCanceladodoAdmin').html(mensajeDesCanceladodoAdmin);
              $('#adminoverlayDesCancelarPartida').removeClass('d-none');
              $('#mensajePartidaDesCanceladaAdmin').removeClass('d-none'); 
              // Recargar la página para ver los cambios después de un breve retraso
              setTimeout(function() {
                  location.reload();
              }, 2000);
          }
      },
      error: function() {
          alert('Error al intentar Activar la partida.');
      }
  });
}




// -----------------------------------------------------------------
  //  PROCESAR APUNTARSE PARTIDA INDIVIFDUAL
// -----------------------------------------------------------------

function apuntarsePartidaIndividual(){
  //valores extraidos del formulario de la partida
  var idPartida = document.getElementById("idPartida").value;
  var nombrePartida = document.getElementById("nombrePartida").value;
  var fecha = document.getElementById("fecha").value;
  var precioPartida = document.getElementById("precioPartida").value;
  var horaPartida = document.getElementById("horaPartida").value;
  var numeroJugadores = document.getElementById("numeroJugadores").value;
  //valores extraidos del formulario del jugador
  var nombreJugador = document.getElementById("nombreJugador").value;
  var apellido1Jugador = document.getElementById("apellido1Jugador").value;
  var apellido2Jugador = document.getElementById("apellido2Jugador").value;
  var nickJugador = document.getElementById("nickJugador").value;
  var dniJugador = document.getElementById("dniJugador").value;
  var telefonoJugador = document.getElementById("telefonoJugador").value;
  var email = document.getElementById("email").value;


  // Agregar el tipo de función para validar
  var tipoFuncion = "funcionApuntarsePartidaIndividual";

    // Crear un nuevo objeto FormData
    var formDataApuntarsePartidaIndividual = new FormData();
    //agregamos el tipo de funcion
    formDataApuntarsePartidaIndividual.append('tipoFuncion', tipoFuncion);
    // Agregar el correo electrónico al objeto FormData
    formDataApuntarsePartidaIndividual.append('idPartida', idPartida);
    formDataApuntarsePartidaIndividual.append('nombrePartida', nombrePartida);
    formDataApuntarsePartidaIndividual.append('fecha', fecha);
    formDataApuntarsePartidaIndividual.append('horaPartida', horaPartida);
    formDataApuntarsePartidaIndividual.append('precioPartida', precioPartida);
    formDataApuntarsePartidaIndividual.append('numeroJugadores', numeroJugadores);

    formDataApuntarsePartidaIndividual.append('nombreJugador', nombreJugador);
    formDataApuntarsePartidaIndividual.append('apellido1Jugador', apellido1Jugador);
    formDataApuntarsePartidaIndividual.append('apellido2Jugador', apellido2Jugador);
    formDataApuntarsePartidaIndividual.append('nickJugador', nickJugador);

    formDataApuntarsePartidaIndividual.append('dniJugador', dniJugador);
    formDataApuntarsePartidaIndividual.append('telefonoJugador', telefonoJugador);
    formDataApuntarsePartidaIndividual.append('email', email);
    
    
    // Enviar los datos del formulario al servidor
    fetch("funciones.php", {
      method: "POST",
      body: formDataApuntarsePartidaIndividual
    })
    .then(response => response.json())
    .then(data => {
      let mensajeError = data.mensajeError; // Capturar el valor de mensajeError del servidor
      let mensaje = data.mensaje;
      console.log(mensajeError);
      console.log(mensaje);
      // Verificar el resultado de la validación
      if (!mensajeError) {  // Si mensajeError es false, la operación fue exitosa
        mostrarMensajeCorrectoApuntarsePartidaIndividual(mensaje);
        document.getElementById("formApuntarsePartidas").reset();
        setTimeout(() => {
          window.location.href = 'partidas.php';
        }, 6000);
      } else {  // Si mensajeError es true, hubo un error
        mostrarMensajeErrorApuntarsePartidaIndividual(mensaje);
        document.getElementById("formApuntarsePartidas").reset();
        // setTimeout(() => {
        //   window.location.href = 'formPartida.php';
        // }, 6000);
      }
    })
    .catch(error => {
      console.error("Error de fetch:", error);
    });

}




// -----------------------------------------------------------------
  //  PROCESAR APUNTARSE PARTIDA GRUPAL
// -----------------------------------------------------------------
function ApuntarsePartidasGrupal() {
  // Valores extraídos del formulario de la partida
  var idPartidaGrupal = document.getElementById("idPartidaGrupal").value;
  var nombrePartidaGrupal = document.getElementById("nombrePartidaGrupal").value;
  var fechaGrupal = document.getElementById("fechaGrupal").value;
  var precioPartidaGrupal = document.getElementById("precioPartidaGrupal").value;
  var horaPartidaGrupal = document.getElementById("horaPartidaGrupal").value;
  var numeroJugadores = document.getElementById("numeroJugadores").value;

  // Valores extraídos del formulario del jugador principal
  var nickJugadorGrupalprincipal = document.getElementById("nickJugadorGrupalprincipal").value;
  var nombreJugadorGrupalprincipal = document.getElementById("nombreJugadorGrupalprincipal").value;
  var apellido1JugadorGrupalprincipal = document.getElementById("apellido1JugadorGrupalprincipal").value;
  var apellido2JugadorGrupalprincipal = document.getElementById("apellido2JugadorGrupalprincipal").value;
  var dniJugadorGrupalprincipal = document.getElementById("dniJugadorGrupalprincipal").value;
  var telefonoJugadorGrupalprincipal = document.getElementById("telefonoJugadorGrupalprincipal").value;
  var emailGrupalprincipal = document.getElementById("emailGrupalprincipal").value;

  // Crear un nuevo objeto FormData
  var formDataApuntarsePartidaGrupal = new FormData();
  formDataApuntarsePartidaGrupal.append('tipoFuncion', "formDataApuntarsePartidaGrupal");
  formDataApuntarsePartidaGrupal.append('idPartidaGrupal', idPartidaGrupal);
  formDataApuntarsePartidaGrupal.append('nombrePartidaGrupal', nombrePartidaGrupal);
  formDataApuntarsePartidaGrupal.append('fechaGrupal', fechaGrupal);
  formDataApuntarsePartidaGrupal.append('precioPartidaGrupal', precioPartidaGrupal);
  formDataApuntarsePartidaGrupal.append('horaPartidaGrupal', horaPartidaGrupal);
  formDataApuntarsePartidaGrupal.append('numeroJugadores', numeroJugadores);

  // Añadir los datos del jugador principal
  formDataApuntarsePartidaGrupal.append('nickJugadorGrupalprincipal', nickJugadorGrupalprincipal);
  formDataApuntarsePartidaGrupal.append('nombreJugadorGrupalprincipal', nombreJugadorGrupalprincipal);
  formDataApuntarsePartidaGrupal.append('apellido1JugadorGrupalprincipal', apellido1JugadorGrupalprincipal);
  formDataApuntarsePartidaGrupal.append('apellido2JugadorGrupalprincipal', apellido2JugadorGrupalprincipal);
  formDataApuntarsePartidaGrupal.append('dniJugadorGrupalprincipal', dniJugadorGrupalprincipal);
  formDataApuntarsePartidaGrupal.append('telefonoJugadorGrupalprincipal', telefonoJugadorGrupalprincipal);
  formDataApuntarsePartidaGrupal.append('emailGrupalprincipal', emailGrupalprincipal);

  // Añadir jugadores adicionales
  for (let i = 1; i < jugadorCounter; i++) {
    var nickJugador = document.getElementById(`nickJugadorGrupal${i}`).value;
    var dniJugador = document.getElementById(`dniJugadorGrupal${i}`).value;
    var telefonoJugador = document.getElementById(`telefonoJugadorGrupal${i}`).value;
    var emailJugador = document.getElementById(`emailGrupal${i}`).value;

    // Crear un objeto para el jugador adicional
    let jugador = {
      'nick': nickJugador,
      'dni': dniJugador,
      'telefono': telefonoJugador,
      'email': emailJugador
    };

    // Convertir a JSON antes de añadir
    formDataApuntarsePartidaGrupal.append('jugadores[]', JSON.stringify(jugador));
   
  }

  // Depurar el contenido de FormData
  console.log("Contenido de FormData antes de enviarlo:");
  for (let [key, value] of formDataApuntarsePartidaGrupal.entries()) {
    console.log(`${key}: ${value}`);
  }

  // Enviar datos al servidor
  fetch("funciones.php", {
    method: "POST",
    body: formDataApuntarsePartidaGrupal
  })
    .then(response => {
      if (!response.ok) {
        throw new Error(`HTTP error! Status: ${response.status}`);
      }
      return response.json();
    })
    .then(data => {
      console.log("Respuesta del servidor:", data);
      if (data.mensajeError) {
        mostrarMensajeErrorApuntarsePartidaGrupal(data.errores || "Error desconocido");
      } else {
        mostrarMensajeCorrectoApuntarsePartidaGrupal(data.mensaje);
        setTimeout(() => {
          window.location.href = 'partidas.php';
        }, 6000);
      }
    })
    .catch(error => console.error("Error de fetch:", error));
}



// -----------------------------------------------------------------
  //  PROCESAR DESAPUNTARSE PARTIDA COMO JUGADOR
// -----------------------------------------------------------------

function jugadorEliminarReserva(idReserva) {
  $.ajax({
    url: 'funciones.php',
    type: 'POST',
    data: { idReserva: idReserva, tipoFuncion: 'funcionjugadorEliminarReserva' }, // Cambiar idPartida a idReserva
    success: function(response) {
        console.log('Respuesta del servidor:', response);
        try {
            var jsonResponse = JSON.parse(response);
            if (jsonResponse.mensajeError) {
                console.error('Error del servidor:', jsonResponse.mensaje);
            } else {
                var mensajeDesapuntadoJugador = 'El jugador ha sido desapuntado de la partida ' + idReserva;
                $('#mensajeDesapuntadoJugador').html(mensajeDesapuntadoJugador);
                $('#adminoverlay2').removeClass('d-none');
                $('#mensajePartidaDesapuntada').removeClass('d-none'); 
                setTimeout(() => {
                  window.location.href = 'perfil.php';
                }, 4000);
            }
        } catch (e) {
            console.error('Error al procesar la respuesta del servidor:', e.message, response);
        }
    },
    error: function() {
        alert('Error al intentar desapuntarse de la partida.');
    }
});

}