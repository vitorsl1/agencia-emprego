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
    <div class="alert alert-success">
        <?php if ($_GET['msg'] == 'salvo') echo '✅ Profissional salvo com sucesso!'; ?>
        <?php if ($_GET['msg'] == 'excluido') echo '✅ Profissional excluído com sucesso!'; ?>
    </div>
<?php endif; ?>

<div class="card">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
        <h2 style="margin:0; border:none;">👷 Profissionais</h2>
        <a href="form.php" class="btn btn-primary">+ Novo Profissional</a>
    </div>
    <table>
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
            <tr><td colspan="6" style="text-align:center; color:#aaa;">Nenhum profissional cadastrado.</td></tr>
        <?php else: ?>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><span class="badge badge-blue"><?php echo htmlspecialchars($row['cpf']); ?></span></td>
                <td><?php echo htmlspecialchars($row['nome']); ?></td>
                <td><?php echo htmlspecialchars($row['profissao']); ?></td>
                <td><?php echo date('d/m/Y', strtotime($row['data_nascimento'])); ?></td>
                <td><?php echo htmlspecialchars($row['endereco']); ?></td>
                <td>
                    <a href="form.php?cpf=<?php echo urlencode($row['cpf']); ?>" class="btn btn-warning btn-sm">✏️ Editar</a>
                    <a href="listar.php?excluir=<?php echo urlencode($row['cpf']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Excluir este profissional?')">🗑️ Excluir</a>
                </td>
            </tr>
            <?php endwhile; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once '../includes/footer.php'; ?>