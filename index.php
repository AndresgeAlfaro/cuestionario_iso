<?php include 'preguntas.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Cuestionario ISO / COBIT 4.1</title>
    <style>
        body { font-family: Arial; }
        .categoria { margin-top: 20px; }
        .pregunta { margin-bottom: 10px; }
    </style>
</head>
<body>
    <h2>Cuestionario sobre Normas ISO / COBIT 4.1</h2>
    <form action="resultado.php" method="POST">
        <?php foreach ($cuestionario as $categoria => $preguntas): ?>
            <div class="categoria">
                <h3><?= $categoria ?></h3>
                <?php foreach ($preguntas as $index => $preg): ?>
                    <div class="pregunta">
                        <strong><?= $preg[0] ?>:</strong> <?= $preg[1] ?><br>
                        <input type="radio" name="<?= $categoria ?>_<?= $index ?>" value="si" required> Sí
                        <input type="radio" name="<?= $categoria ?>_<?= $index ?>" value="no"> No
                        <input type="radio" name="<?= $categoria ?>_<?= $index ?>" value="no_implementa"> No implementa
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
        <br>
        <input type="submit" value="Enviar Cuestionario">
    </form>
</body>
</html>
