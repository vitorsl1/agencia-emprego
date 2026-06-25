<?php
require_once '../db.php';
require_once '../includes/header.php';

if (isset($_GET['excluir'])) {
    $cnpj = $conn->real_escape_string($_GET['excluir']);
    $conn->query("DELETE FROM empresa WHERE cnpj='$cnpj'");
    header('Location: listar.php?msg=excluido');
    exit;
}

$result = $conn->query("SELECT * FROM empresa ORDER BY razao_social");
?>

<?php if (isset($_GET['msg'])): ?>
    <div class="alert alert-success">
        <?php if ($_GET['msg'] == 'salvo') echo '✅ Empresa salva com sucesso!'; ?>
        <?php if ($_GET['msg'] == 'excluido') echo '✅ Empresa excluída com sucesso!'; ?>
    </div>
<?php endif; ?>

<div class="card">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
        <h2 style="margin:0; border:none;">🏭 Empresas</h2>
        <a href="form.php" class="btn btn-success">+ Nova Empresa</a>
    </div>
    <table>
        <thead>
            <tr>
                <th>CNPJ</th>
                <th>Razão Social</th>
                <th>Endereço</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
        <?php if ($result->num_rows == 0): ?>
            <tr><td colspan="4" style="text-align:center; color:#aaa;">Nenhuma empresa cadastrada.</td></tr>
        <?php else: ?>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><span class="badge badge-blue"><?php echo htmlspecialchars($row['cnpj']); ?></span></td>
                <td><?php echo htmlspecialchars($row['razao_social']); ?></td>
                <td><?php echo htmlspecialchars($row['endereco']); ?></td>
                <td>
                    <a href="form.php?cnpj=<?php echo urlencode($row['cnpj']); ?>" class="btn btn-warning btn-sm">✏️ Editar</a>
                    <a href="listar.php?excluir=<?php echo urlencode($row['cnpj']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Excluir esta empresa?')">🗑️ Excluir</a>
                </td>
            </tr>
            <?php endwhile; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once '../includes/footer.php'; ?>