<?php include 'preguntas.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Resultados</title>
    <style>
        .categoria { margin-top: 20px; }
        .semaforo { font-size: 20px; font-weight: bold; }
        .rojo { color: red; }
        .amarillo { color: orange; }
        .verde { color: green; }
    </style>
</head>
<body>
    <h2>Resultado del Cuestionario</h2>

    <?php
    $totales = ['si' => 0, 'no' => 0, 'no_implementa' => 0];
    $resultado_categoria = [];

    foreach ($cuestionario as $categoria => $preguntas) {
        $res = ['si' => 0, 'no' => 0, 'no_implementa' => 0];
        foreach ($preguntas as $index => $p) {
            $valor = $_POST[$categoria . '_' . $index];
            $res[$valor]++;
            $totales[$valor]++;
        }
        $resultado_categoria[$categoria] = $res;
    }

    function obtenerSemaforo($respuestas, $total) {
        $si = $respuestas['si'];
        $porcentaje = ($si / $total) * 100;
        if ($porcentaje >= 70) return 'verde';
        elseif ($porcentaje >= 40) return 'amarillo';
        else return 'rojo';
    }

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
    ?>
</body>
</html>
