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
            $si = $respuestas['si'];
            $porcentaje = ($si / $total) * 100;
            if ($porcentaje >= 70) return 'verde';
            elseif ($porcentaje >= 40) return 'amarillo';
            else return 'rojo';
        }

        if (empty($resultado_categoria)) {
            echo "<p class='error'>No se respondió ninguna pregunta. Por favor, selecciona al menos una categoría y responde sus preguntas.</p>";
        } else {
            foreach ($resultado_categoria as $cat => $res) {
                $total = array_sum($res);
                $color = obtenerSemaforo($res, $total);
                echo "<div class='categoria'><strong>$cat:</strong> ";
                echo "<span class='semaforo $color'>" . strtoupper($color) . "</span></div>";
            }

            // Semáforo general
            $total_general = array_sum($totales);
            $color_general = obtenerSemaforo($totales, $total_general);
            echo "<hr><h3>Resultado General: <span class='semaforo $color_general'>" . strtoupper($color_general) . "</span></h3>";
        }
        ?>
    </div>
</body>
</html>
