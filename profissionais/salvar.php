<?php
require_once '../db.php';

$cpf       = $conn->real_escape_string(trim($_POST['cpf']));
$nome      = $conn->real_escape_string(trim($_POST['nome']));
$endereco  = $conn->real_escape_string(trim($_POST['endereco']));
$nascimento= $conn->real_escape_string(trim($_POST['data_nascimento']));
$profissao = $conn->real_escape_string(trim($_POST['profissao']));
$editando  = $_POST['editando'] == '1';

if ($editando) {
    $conn->query("UPDATE profissional SET nome='$nome', endereco='$endereco', data_nascimento='$nascimento', profissao='$profissao' WHERE cpf='$cpf'");
} else {
    $conn->query("INSERT INTO profissional (cpf, nome, endereco, data_nascimento, profissao) VALUES ('$cpf','$nome','$endereco','$nascimento','$profissao')");
}

header('Location: listar.php?msg=salvo');
exit;
?>