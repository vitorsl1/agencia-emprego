<?php
// Caminho base fixo — ajuste conforme a estrutura no servidor
// Exemplo: se o site está em /agencia/agencia-emprego-main, defina assim:
if (!defined('BASE')) {
    // Detecta automaticamente a raiz do projeto (onde está o index.php)
    $docRoot = str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']);
    $scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_FILENAME']));

    // Sobe até encontrar o index.php (raiz do projeto)
    $dir = $scriptDir;
    while (!file_exists($dir . '/index.php') && $dir !== $docRoot && strlen($dir) > strlen($docRoot)) {
        $dir = dirname($dir);
    }

    $base = str_replace($docRoot, '', $dir);
    $base = rtrim($base, '/');
    define('BASE', $base);
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agência de Emprego Temporário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: #f0f2f5; }
        .navbar { background: linear-gradient(135deg, #1a237e, #283593) !important; }
        .navbar-brand span { font-size: 0.65em; display: block; font-weight: 300; opacity: 0.85; }
        .card { border: none; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,0.08); }
        .card-header { background: #1a237e; color: white; border-radius: 12px 12px 0 0 !important; }
        .table thead th { background: #1a237e; color: white; border: none; }
        .table tbody tr:hover { background: #f5f5ff; }
        .badge-cpf { background: #e8eaf6; color: #1a237e; font-size: 0.85em; }
        footer { background: white; border-top: 1px solid #e0e0e0; }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold" href="<?php echo BASE; ?>/index.php">
            <i class="bi bi-building"></i> Agência de Emprego
            <span>Sistema de Gestão</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav ms-auto gap-1">
                <li class="nav-item">
                    <a class="nav-link text-white" href="<?php echo BASE; ?>/index.php"><i class="bi bi-house-fill"></i> Início</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="<?php echo BASE; ?>/profissionais/listar.php"><i class="bi bi-person-badge-fill"></i> Profissionais</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="<?php echo BASE; ?>/empresas/listar.php"><i class="bi bi-building-fill"></i> Empresas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="<?php echo BASE; ?>/contratos/listar.php"><i class="bi bi-file-text-fill"></i> Contratos</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="container">
