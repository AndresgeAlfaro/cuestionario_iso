<?php
// archivo: generar_pdf.php
require_once('vendor/autoload.php');
use Dompdf\Dompdf;

function colorHex($color) {
    return match ($color) {
        'verde' => 'green',
        'amarillo' => 'orange',
        'rojo' => 'red',
        default => 'black',
    };
}

$fecha = $_GET['fecha'] ?? date('Y-m-d H:i:s');
$norma = $_GET['norma'] ?? 'No especificada';
$resultado = $_GET['resultado'] ?? 'sin_resultado';

$dompdf = new Dompdf();
$dompdf->loadHtml("
    <h1>Reporte de Cuestionario</h1>
    <p><strong>Fecha:</strong> $fecha</p>
    <p><strong>Norma Seleccionada:</strong> $norma</p>
    <p><strong>Resultado General:</strong> <span style='color: " . colorHex($resultado) . "; font-weight:bold;'>●</span></p>
");
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("reporte_$fecha.pdf", ["Attachment" => false]);
?>

