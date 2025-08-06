<?php include 'preguntas.php'; ?>
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
    </script>
</head>
<body>
    <div class="container">
        <h2>Cuestionario sobre Normas ISO / COBIT 4.1</h2>
        <form action="resultado.php" method="POST">
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
    </div>
</body>
</html>

