<?php
// Estructura de datos (arreglo asociativo)
$preguntas = [
    [
        'pregunta' => '¿Cuál es la capital de Francia?',
        'opciones' => ['A' => 'Roma', 'B' => 'París', 'C' => 'Londres'],
        'opcion_correcta' => 'B'
    ],
    // Agrega más preguntas aquí
];

// Obtener una pregunta aleatoria
$indicePregunta = array_rand($preguntas);
$preguntaActual = $preguntas[$indicePregunta];

// Procesar respuesta
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $opcionSeleccionada = $_POST['opcion'];

    // Verificar respuesta
    if ($opcionSeleccionada === $preguntaActual['opcion_correcta']) {
        $resultado = 'Correcto';
    } else {
        $resultado = 'Incorrecto';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Preguntas y respuestas</title>
</head>
<body>
<h1>Pregunta:</h1>
<p><?php echo $preguntaActual['pregunta']; ?></p>

<form method="post" action="">
    <?php foreach ($preguntaActual['opciones'] as $opcion => $texto) { ?>
        <label>
            <input type="radio" name="opcion" value="<?php echo $opcion; ?>">
            <?php echo $texto; ?>
        </label>
        <br>
    <?php } ?>
    <br>
    <input type="submit" value="Responder">
</form>

<?php if (isset($resultado)) { ?>
    <h2>Respuesta: <?php echo $resultado; ?></h2>
<?php } ?>
</body>
</html>