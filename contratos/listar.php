<?php
require_once '../db.php';
require_once '../includes/header.php';

if (isset($_GET['excluir'])) {
    $id = (int)$_GET['excluir'];
    $conn->query("DELETE FROM contrato WHERE numero=$id");
    header('Location: listar.php?msg=excluido');
    exit;
}

$result = $conn->query("
    SELECT c.numero, p.nome AS profissional, p.cpf, e.razao_social AS empresa, e.cnpj,
           c.data_inicio, c.data_termino, c.valor_hora
    FROM contrato c
    JOIN profissional p ON c.cpf_profissional = p.cpf
    JOIN empresa e ON c.cnpj_empresa = e.cnpj
    ORDER BY c.numero DESC
");
?>

<?php if (isset($_GET['msg'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill"></i>
        <?php if ($_GET['msg'] == 'salvo') echo ' Contrato salvo com sucesso!'; ?>
        <?php if ($_GET['msg'] == 'excluido') echo ' Contrato excluído com sucesso!'; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center py-3">
        <h5 class="mb-0"><i class="bi bi-file-text-fill"></i> Contratos</h5>
        <a href="form.php" class="btn btn-light btn-sm"><i class="bi bi-plus-lg"></i> Novo Contrato</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Profissional</th>
                        <th>Empresa</th>
                        <th>Início</th>
                        <th>Término</th>
                        <th>Valor/Hora</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                <?php if ($result->num_rows == 0): ?>
                    <tr><td colspan="7" class="text-center text-muted py-4">Nenhum contrato cadastrado.</td></tr>
                <?php else: ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><span class="badge bg-primary">#<?php echo $row['numero']; ?></span></td>
                        <td>
                            <?php echo htmlspecialchars($row['profissional']); ?><br>
                            <small class="text-muted"><?php echo $row['cpf']; ?></small>
                        </td>
                        <td>
                            <?php echo htmlspecialchars($row['empresa']); ?><br>
                            <small class="text-muted"><?php echo $row['cnpj']; ?></small>
                        </td>
                        <td><?php echo date('d/m/Y', strtotime($row['data_inicio'])); ?></td>
                        <td><?php echo date('d/m/Y', strtotime($row['data_termino'])); ?></td>
                        <td class="text-success fw-bold">R$ <?php echo number_format($row['valor_hora'], 2, ',', '.'); ?></td>
                        <td>
                            <a href="form.php?id=<?php echo $row['numero']; ?>" class="btn btn-warning btn-sm"><i class="bi bi-pencil-fill"></i></a>
                            <a href="listar.php?excluir=<?php echo $row['numero']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Excluir este contrato?')"><i class="bi bi-trash-fill"></i></a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>