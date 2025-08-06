<!DOCTYPE html>
<html>
<head>
    <title>Historial de Resultados</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <div class="container">
        <h2>Historial de Cuestionarios</h2>
        <a href="index.php" class="btn-volver">Volver al Cuestionario</a>
        <hr>
        <ul>
            <?php
            $archivo = "resultados.txt";
            if (file_exists($archivo)) {
                $lineas = file($archivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                foreach (array_reverse($lineas) as $linea) {
                    echo "<li>" . htmlspecialchars($linea) . "</li>";
                }
            } else {
                echo "<p>No hay resultados registrados todavía.</p>";
            }
            ?>
        </ul>
    </div>
</body>
</html>
