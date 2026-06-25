<?php
require_once '../db.php';

$numero      = (int)$_POST['numero'];
$cpf         = $conn->real_escape_string(trim($_POST['cpf_profissional']));
$cnpj        = $conn->real_escape_string(trim($_POST['cnpj_empresa']));
$data_inicio = $conn->real_escape_string(trim($_POST['data_inicio']));
$data_term   = $conn->real_escape_string(trim($_POST['data_termino']));
$valor_hora  = (float)$_POST['valor_hora'];
$editando    = $_POST['editando'] == '1';

if ($editando) {
    $conn->query("UPDATE contrato SET cpf_profissional='$cpf', cnpj_empresa='$cnpj', data_inicio='$data_inicio', data_termino='$data_term', valor_hora=$valor_hora WHERE numero=$numero");
} else {
    $conn->query("INSERT INTO contrato (cpf_profissional, cnpj_empresa, data_inicio, data_termino, valor_hora) VALUES ('$cpf','$cnpj','$data_inicio','$data_term',$valor_hora)");
}

header('Location: listar.php?msg=salvo');
exit;
?>