<?php
define('API_URL', 'http://localhost:8080/productos');

function peticionAPI($metodo, $ruta = '', $datos = null) {
    $ch = curl_init(API_URL . $ruta);
    
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $metodo);
    
    if ($datos !== null) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($datos));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen(json_encode($datos))
        ]);
    }
    
    $respuesta = curl_exec($ch);
    $codigo = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    return [json_decode($respuesta, true), $codigo];
}
?>