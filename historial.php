<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

$usuarioActual = $_SESSION['usuario'];
$esAdmin = $_SESSION['rol'] === 'admin';

echo "<h2>Historial de Resultados</h2>";
echo "<a href='index.php' class='btn-volver'>Volver al cuestionario</a><hr>";

$archivo = "resultados.txt";
if (file_exists($archivo)) {
    $lineas = file($archivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach (array_reverse($lineas) as $linea) {
        if ($esAdmin || strpos($linea, "Usuario: $usuarioActual") !== false) {
            echo "<li>" . htmlspecialchars($linea) . "</li>";
        }
    }
} else {
    echo "<p>No hay resultados registrados todavía.</p>";
}
?>

