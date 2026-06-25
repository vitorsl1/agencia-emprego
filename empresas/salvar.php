<?php
require_once '../db.php';

$cnpj        = $conn->real_escape_string(trim($_POST['cnpj']));
$razao_social= $conn->real_escape_string(trim($_POST['razao_social']));
$endereco    = $conn->real_escape_string(trim($_POST['endereco']));
$editando    = $_POST['editando'] == '1';

if ($editando) {
    $conn->query("UPDATE empresa SET razao_social='$razao_social', endereco='$endereco' WHERE cnpj='$cnpj'");
} else {
    $conn->query("INSERT INTO empresa (cnpj, razao_social, endereco) VALUES ('$cnpj','$razao_social','$endereco')");
}

header('Location: listar.php?msg=salvo');
exit;
?>