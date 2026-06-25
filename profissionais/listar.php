<?php
require_once '../db.php';
require_once '../includes/header.php';

if (isset($_GET['excluir'])) {
    $cpf = $conn->real_escape_string($_GET['excluir']);
    $conn->query("DELETE FROM profissional WHERE cpf='$cpf'");
    header('Location: listar.php?msg=excluido');
    exit;
}

$result = $conn->query("SELECT * FROM profissional ORDER BY nome");
?>

<?php if (isset($_GET['msg'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill"></i>
        <?php if ($_GET['msg'] == 'salvo') echo ' Profissional salvo com sucesso!'; ?>
        <?php if ($_GET['msg'] == 'excluido') echo ' Profissional excluído com sucesso!'; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center py-3">
        <h5 class="mb-0"><i class="bi bi-person-badge-fill"></i> Profissionais</h5>
        <a href="form.php" class="btn btn-light btn-sm"><i class="bi bi-plus-lg"></i> Novo Profissional</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>CPF</th>
                        <th>Nome</th>
                        <th>Profissão</th>
                        <th>Data Nasc.</th>
                        <th>Endereço</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                <?php if ($result->num_rows == 0): ?>
                    <tr><td colspan="6" class="text-center text-muted py-4">Nenhum profissional cadastrado.</td></tr>
                <?php else: ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><span class="badge badge-cpf"><?php echo htmlspecialchars($row['cpf']); ?></span></td>
                        <td><?php echo htmlspecialchars($row['nome']); ?></td>
                        <td><?php echo htmlspecialchars($row['profissao']); ?></td>
                        <td><?php echo date('d/m/Y', strtotime($row['data_nascimento'])); ?></td>
                        <td><?php echo htmlspecialchars($row['endereco']); ?></td>
                        <td>
                            <a href="form.php?cpf=<?php echo urlencode($row['cpf']); ?>" class="btn btn-warning btn-sm"><i class="bi bi-pencil-fill"></i></a>
                            <a href="listar.php?excluir=<?php echo urlencode($row['cpf']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Excluir este profissional?')"><i class="bi bi-trash-fill"></i></a>
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