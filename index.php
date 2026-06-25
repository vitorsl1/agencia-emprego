<?php require_once 'db.php'; require_once 'includes/header.php'; ?>

<div class="card" style="text-align:center; padding: 40px;">
    <h2 style="border:none; font-size:1.8em;">🏢 Bem-vindo ao Sistema de Gestão</h2>
    <p style="color:#666; margin: 10px 0 30px;">Agência de Emprego Temporário — Gerencie profissionais, empresas e contratos.</p>
    <div style="display:flex; justify-content:center; gap:20px; flex-wrap:wrap;">
        <a href="/profissionais/listar.php" class="btn btn-primary" style="padding:18px 30px; font-size:1em;">👷 Profissionais</a>
        <a href="/empresas/listar.php" class="btn btn-success" style="padding:18px 30px; font-size:1em;">🏭 Empresas</a>
        <a href="/contratos/listar.php" class="btn btn-warning" style="padding:18px 30px; font-size:1em;">📋 Contratos</a>
    </div>
</div>

<?php
$totalProf = $conn->query("SELECT COUNT(*) as t FROM profissional")->fetch_assoc()['t'];
$totalEmp  = $conn->query("SELECT COUNT(*) as t FROM empresa")->fetch_assoc()['t'];
$totalCont = $conn->query("SELECT COUNT(*) as t FROM contrato")->fetch_assoc()['t'];
?>

<div style="display:flex; gap:20px; flex-wrap:wrap;">
    <div class="card" style="flex:1; min-width:180px; text-align:center;">
        <div style="font-size:2.5em;">👷</div>
        <div style="font-size:2em; font-weight:bold; color:#1a237e;"><?php echo $totalProf; ?></div>
        <div style="color:#666;">Profissionais</div>
    </div>
    <div class="card" style="flex:1; min-width:180px; text-align:center;">
        <div style="font-size:2.5em;">🏭</div>
        <div style="font-size:2em; font-weight:bold; color:#2e7d32;"><?php echo $totalEmp; ?></div>
        <div style="color:#666;">Empresas</div>
    </div>
    <div class="card" style="flex:1; min-width:180px; text-align:center;">
        <div style="font-size:2.5em;">📋</div>
        <div style="font-size:2em; font-weight:bold; color:#f57f17;"><?php echo $totalCont; ?></div>
        <div style="color:#666;">Contratos</div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>