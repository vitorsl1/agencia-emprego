<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agência de Emprego Temporário</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f0f2f5; color: #333; }
        header { background: linear-gradient(135deg, #1a237e, #283593); color: white; padding: 15px 0; box-shadow: 0 2px 8px rgba(0,0,0,0.3); }
        header .container { display: flex; align-items: center; justify-content: space-between; max-width: 1100px; margin: 0 auto; padding: 0 20px; }
        header h1 { font-size: 1.4em; letter-spacing: 1px; }
        header h1 span { font-size: 0.7em; display: block; font-weight: 300; opacity: 0.85; }
        nav { display: flex; gap: 8px; flex-wrap: wrap; }
        nav a { color: white; text-decoration: none; padding: 7px 15px; border-radius: 20px; font-size: 0.88em; background: rgba(255,255,255,0.12); transition: background 0.2s; }
        nav a:hover { background: rgba(255,255,255,0.28); }
        .container { max-width: 1100px; margin: 30px auto; padding: 0 20px; }
        .card { background: white; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); padding: 30px; margin-bottom: 25px; }
        h2 { color: #1a237e; margin-bottom: 20px; font-size: 1.3em; border-bottom: 2px solid #e8eaf6; padding-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; font-size: 0.93em; }
        th { background: #1a237e; color: white; padding: 11px 14px; text-align: left; }
        td { padding: 10px 14px; border-bottom: 1px solid #eee; }
        tr:hover td { background: #f5f5ff; }
        .btn { display: inline-block; padding: 8px 18px; border-radius: 6px; text-decoration: none; font-size: 0.88em; cursor: pointer; border: none; transition: opacity 0.2s; }
        .btn:hover { opacity: 0.85; }
        .btn-primary { background: #1a237e; color: white; }
        .btn-success { background: #2e7d32; color: white; }
        .btn-warning { background: #f57f17; color: white; }
        .btn-danger { background: #c62828; color: white; }
        .btn-sm { padding: 5px 12px; font-size: 0.82em; }
        form label { display: block; margin-bottom: 5px; font-weight: 600; font-size: 0.9em; color: #555; }
        form input, form select { width: 100%; padding: 9px 12px; border: 1px solid #ccc; border-radius: 6px; font-size: 0.93em; margin-bottom: 15px; outline: none; transition: border 0.2s; }
        form input:focus, form select:focus { border-color: #1a237e; }
        .form-row { display: flex; gap: 20px; flex-wrap: wrap; }
        .form-row .form-group { flex: 1; min-width: 200px; }
        .alert { padding: 12px 18px; border-radius: 6px; margin-bottom: 18px; font-size: 0.93em; }
        .alert-success { background: #e8f5e9; color: #2e7d32; border-left: 4px solid #2e7d32; }
        .alert-danger { background: #ffebee; color: #c62828; border-left: 4px solid #c62828; }
        .badge { display: inline-block; padding: 3px 10px; border-radius: 12px; font-size: 0.78em; font-weight: 600; }
        .badge-blue { background: #e8eaf6; color: #1a237e; }
    </style>
</head>
<body>
<header>
    <div class="container">
        <h1>🏢 Agência de Emprego <span>Sistema de Gestão</span></h1>
        <nav>
            <a href="/index.php">🏠 Início</a>
            <a href="/profissionais/listar.php">👷 Profissionais</a>
            <a href="/empresas/listar.php">🏭 Empresas</a>
            <a href="/contratos/listar.php">📋 Contratos</a>
        </nav>
    </div>
</header>
<div class="container">
