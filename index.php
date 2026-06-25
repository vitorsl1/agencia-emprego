<?php require_once 'db.php'; require_once 'includes/header.php'; ?>

<?php
$base = rtrim(dirname($_SERVER['PHP_SELF']), '/');
$totalProf = $conn->query("SELECT COUNT(*) as t FROM profissional")->fetch_assoc()['t'];
$totalEmp  = $conn->query("SELECT COUNT(*) as t FROM empresa")->fetch_assoc()['t'];
$totalCont = $conn->query("SELECT COUNT(*) as t FROM contrato")->fetch_assoc()['t'];
?>

<div class="card mb-4">
    <div class="card-body text-center py-5">
        <h1 class="fw-bold text-primary mb-2"><i class="bi bi-building"></i> Bem-vindo ao Sistema de Gestão</h1>
        <p class="text-muted mb-4">Agência de Emprego Temporário — Gerencie profissionais, empresas e contratos.</p>
        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <a href="<?php echo $base; ?>/profissionais/listar.php" class="btn btn-primary btn-lg px-4">
                <i class="bi bi-person-badge-fill"></i> Profissionais
            </a>
            <a href="<?php echo $base; ?>/empresas/listar.php" class="btn btn-success btn-lg px-4">
                <i class="bi bi-building-fill"></i> Empresas
            </a>
            <a href="<?php echo $base; ?>/contratos/listar.php" class="btn btn-warning btn-lg px-4">
                <i class="bi bi-file-text-fill"></i> Contratos
            </a>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card text-center h-100">
            <div class="card-body py-4">
                <i class="bi bi-person-badge-fill text-primary" style="font-size:2.5em;"></i>
                <div class="display-5 fw-bold text-primary mt-2"><?php echo $totalProf; ?></div>
                <div class="text-muted">Profissionais</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center h-100">
            <div class="card-body py-4">
                <i class="bi bi-building-fill text-success" style="font-size:2.5em;"></i>
                <div class="display-5 fw-bold text-success mt-2"><?php echo $totalEmp; ?></div>
                <div class="text-muted">Empresas</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center h-100">
            <div class="card-body py-4">
                <i class="bi bi-file-text-fill text-warning" style="font-size:2.5em;"></i>
                <div class="display-5 fw-bold text-warning mt-2"><?php echo $totalCont; ?></div>
                <div class="text-muted">Contratos</div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>