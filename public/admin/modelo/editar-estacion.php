<?php
session_start();

if (isset($_POST['ValEstacion'])) {
    // Validar y sanitizar el valor
    $valEstacion = htmlspecialchars(trim($_POST['ValEstacion']));

    // Actualizar el valor de la sesión
    $_SESSION["id_gas_usuario"] = $valEstacion;

    // Respuesta en formato JSON
    echo json_encode([
        'status' => 'success',
        'message' => 'Valor de la sesión actualizado.',
        'id_gas_usuario' => $_SESSION["id_gas_usuario"]
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'No se proporcionó un valor para actualizar.'
    ]);
}
