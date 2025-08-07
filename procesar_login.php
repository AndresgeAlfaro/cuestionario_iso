<?php
session_start();
include 'usuarios.php';

$usuario = $_POST['usuario'];
$password = $_POST['password'];

if (isset($usuarios[$usuario]) && $usuarios[$usuario]['password'] === $password) {
    $_SESSION['usuario'] = $usuario;
    $_SESSION['rol'] = $usuarios[$usuario]['rol'];
    header("Location: index.php");
    exit;
} else {
    echo "<p>Usuario o contraseña incorrectos. <a href='login.php'>Intentar de nuevo</a></p>";
}
?>
