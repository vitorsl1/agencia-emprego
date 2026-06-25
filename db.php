<?php
define('DB_HOST', 'sql300.infinityfree.com');
define('DB_USER', 'if0_42040402');
define('DB_PASS', 'bYadxkBAh6m1zS');
define('DB_NAME', 'if0_42040402_agencia');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$conn->set_charset('utf8');

if ($conn->connect_error) {
    die('<div style="color:red;text-align:center;padding:20px;">Erro ao conectar ao banco de dados: ' . $conn->connect_error . '</div>');
}
?>