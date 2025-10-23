<?php


// ------------------------------------------------ --------------- -------------------------------
// ------------------------------------------------ OTRAS FUNCIONES -------------------------------
// ------------------------------------------------ --------------- -------------------------------

//FUNCION PARA ENMASCARAR CONTRASEÑAS EN PERFIL JUGADOR/ADMIN

function enmascararContrasena($contrasena) {
    $longitud = strlen($contrasena);
    if ($longitud > 4) {
        $visibleInicio = substr($contrasena, 0, 2);  // Muestra los primeros 2 caracteres
        $visibleFin = substr($contrasena, -2);      // Muestra los últimos 2 caracteres
        $oculto = str_repeat('*', $longitud - 4);   // Oculta los caracteres del medio

        return $visibleInicio . $oculto . $visibleFin;
    } else if ($longitud > 1) {
        // Si la contraseña tiene entre 2 y 4 caracteres, muestra el primer y el último, y oculta el resto
        return substr($contrasena, 0, 1) . str_repeat('*', $longitud - 2) . substr($contrasena, -1);
    } else {
        // Si la contraseña tiene 1 carácter, simplemente muestra ese carácter
        return $contrasena;
    }
}




?>