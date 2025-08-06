<?php include 'preguntas.php'; ?>
<?php
// Cargar historial de resultados desde archivo
$historial = [];
$ultimo = null;
$archivo = "resultados.txt";
if (file_exists($archivo)) {
    $lineas = file($archivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $historial = array_reverse($lineas);
    $ultimo = $historial[0] ?? null;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Cuestionario ISO / COBIT 4.1</title>
    <link rel="stylesheet" href="estilo.css">
    <script>
        function toggleCategorias() {
            const checkboxes = document.querySelectorAll('.chk-categoria');
            checkboxes.forEach(chk => {
                const div = document.getElementById('div_' + chk.value);
                if (chk.checked) {
                    div.style.display = 'block';
                } else {
                    div.style.display = 'none';
                }
            });
        }

        function resetForm() {
            document.querySelector("form").reset();
            toggleCategorias();
        }
    </script>
</head>
<body>
    <div class="container">
        <h2>Cuestionario sobre Normas ISO / COBIT 4.1</h2>

        <form action="resultado.php" method="POST">
            <div class="selector-norma">
                <label><strong>Selecciona la norma:</strong></label><br>
                <input type="radio" name="norma" value="ISO" required> ISO<br>
                <input type="radio" name="norma" value="COBIT 4.1" required> COBIT 4.1
            </div>

            <div class="selector-categorias">
                <p><strong>Selecciona una o más categorías:</strong></p>
                <?php foreach ($cuestionario as $categoria => $preguntas): ?>
                    <label>
                        <input type="checkbox" name="categorias[]" value="<?= $categoria ?>" class="chk-categoria" onclick="toggleCategorias()"> <?= $categoria ?>
                    </label><br>
                <?php endforeach; ?>
            </div>

            <?php foreach ($cuestionario as $categoria => $preguntas): ?>
                <div class="categoria" id="div_<?= $categoria ?>" style="display:none;">
                    <h3><?= $categoria ?></h3>
                    <?php foreach ($preguntas as $index => $preg): ?>
                        <div class="pregunta">
                            <strong><?= $preg[0] ?>:</strong> <?= $preg[1] ?><br>
                            <input type="radio" name="<?= $categoria ?>_<?= $index ?>" value="si"> Sí
                            <input type="radio" name="<?= $categoria ?>_<?= $index ?>" value="no"> No
                            <input type="radio" name="<?= $categoria ?>_<?= $index ?>" value="no_implementa"> No implementa
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>

            <br>
            <input type="submit" value="Enviar Cuestionario">
        </form>

        <hr>

        <!-- Mostrar el último resultado -->
        <h3>Último Resultado Registrado</h3>
        <?php if ($ultimo): ?>
            <p><?= htmlspecialchars($ultimo) ?></p>
            <?php
                // Extraer partes del último registro
                preg_match('/^(.*?)\s+\|\s+Norma: (.*?)\s+\|\s+Resultado General: (.*?)$/', $ultimo, $partes);
                $fecha = $partes[1] ?? '';
                $norma = $partes[2] ?? '';
                $resultado = $partes[3] ?? '';
                $url_pdf = "generar_pdf.php?fecha=" . urlencode($fecha) . "&norma=" . urlencode($norma) . "&resultado=" . urlencode($resultado);
            ?>
            <a href="<?= $url_pdf ?>" target="_blank" class="btn-volver">Generar PDF de este resultado</a>
        <?php else: ?>
            <p>No hay resultados disponibles aún.</p>
        <?php endif; ?>

        <hr>

        <!-- Mostrar historial -->
        <h3>Historial de Resultados</h3>
        <ul>
            <?php if (!empty($historial)): ?>
                <?php foreach ($historial as $linea): ?>
                    <li><?= htmlspecialchars($linea) ?></li>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No hay resultados registrados todavía.</p>
            <?php endif; ?>
        </ul>
    </div>
</body>
</html>

