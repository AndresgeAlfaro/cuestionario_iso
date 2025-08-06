<?php include 'preguntas.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Resultados</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <div class="container">
        <h2>Resultado del Cuestionario</h2>

        <?php
        $totales = ['si' => 0, 'no' => 0, 'no_implementa' => 0];
        $resultado_categoria = [];
        $categoriasRespondidas = [];

        $norma = isset($_POST['norma']) ? $_POST['norma'] : 'No especificada';

        foreach ($cuestionario as $categoria => $preguntas) {
            $res = ['si' => 0, 'no' => 0, 'no_implementa' => 0];
            $respondidas = false;

            foreach ($preguntas as $index => $p) {
                $key = $categoria . '_' . $index;
                if (isset($_POST[$key])) {
                    $valor = $_POST[$key];
                    $res[$valor]++;
                    $totales[$valor]++;
                    $respondidas = true;
                }
            }

            if ($respondidas) {
                $resultado_categoria[$categoria] = $res;
                $categoriasRespondidas[] = $categoria;
            }
        }

        function obtenerSemaforo($respuestas, $total) {
            if ($total === 0) return 'gris';
            $si = $respuestas['si'];
            $porcentaje = ($si / $total) * 100;
            if ($porcentaje >= 70) return 'verde';
            elseif ($porcentaje >= 40) return 'amarillo';
            else return 'rojo';
        }

        if (empty($resultado_categoria)) {
            echo "<p class='error'>No se respondió ninguna pregunta. Por favor, selecciona al menos una categoría y responde sus preguntas.</p>";
        } else {
            echo "<p><strong>Norma seleccionada:</strong> $norma</p>";
            foreach ($resultado_categoria as $cat => $res) {
                $total = array_sum($res);
                $color = obtenerSemaforo($res, $total);
                echo "<div class='categoria'><strong>$cat:</strong> ";
                echo "<span class='semaforo-color $color' title='$color'></span></div>";
            }

            // Semáforo general
            $total_general = array_sum($totales);
            $color_general = obtenerSemaforo($totales, $total_general);
            echo "<hr><h3>Resultado General: <span class='semaforo-color $color_general' title='$color_general'></span></h3>";

            // Guardar en archivo
            $fecha = date('Y-m-d H:i:s');
            $registro = "$fecha | Norma: $norma | Resultado General: $color_general\n";
            file_put_contents("resultados.txt", $registro, FILE_APPEND);

            // Mostrar botones
            echo "<br><br>";
            echo "<a href='index.php' class='btn-volver'>Realizar otro cuestionario</a> ";
            echo "<a href='historial.php' class='btn-volver'>Ver Historial</a> ";
            echo "<a href='generar_pdf.php?fecha=" . urlencode($fecha) . "&norma=" . urlencode($norma) . "&resultado=" . urlencode($color_general) . "' class='btn-volver' target='_blank'>Generar PDF</a>";
        }
        ?>
    </div>
</body>
</html>

