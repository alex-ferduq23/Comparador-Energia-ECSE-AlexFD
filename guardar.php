<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 
    $fichero = 'respuestas.csv';
 
    // Todos los campos posibles del formulario
    $campos = [
        'fecha',
        'tipo_cliente',
        'conoce_consumo',
        'tipo_tarifa',
        'potencia',
        'consumo',
        'potenciaPnt',
        'potenciaVll',
        'consumoPnt',
        'consumoLln',
        'consumoVll',
        'periodicidad',
        'tipo_vivienda',
        'metros',
        'personas',
        'calefaccion',
        'calefaccion_otro',
        'cocina',
        'cocina_otro',
        'agua',
        'agua_otro',
        'nombre',
        'telefono',
        'email',
        'codigo_postal'
    ];
 
    // Si el fichero no existe, escribir la cabecera
    if (!file_exists($fichero)) {
        $cabecera = implode(';', $campos) . PHP_EOL;
        file_put_contents($fichero, $cabecera, LOCK_EX);
    }
 
    // Recoger los valores (campo vacío si no viene en el POST)
    $_POST['fecha'] = date('Y-m-d H:i:s');
 
    $valores = [];
    foreach ($campos as $campo) {
        $valor = isset($_POST[$campo]) ? trim($_POST[$campo]) : '';
        // Escapar comillas dobles para CSV
        $valor = '"' . str_replace('"', '""', $valor) . '"';
        $valores[] = $valor;
    }
 
    $linea = implode(';', $valores) . PHP_EOL;
    file_put_contents($fichero, $linea, FILE_APPEND | LOCK_EX);
 
    // Redirigir de vuelta al formulario con aviso de éxito
    header('Location: comparador.html?enviado=1');
    exit;
}
?>