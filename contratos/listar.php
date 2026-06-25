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
    <div class="alert alert-success">
        <?php if ($_GET['msg'] == 'salvo') echo '✅ Contrato salvo com sucesso!'; ?>
        <?php if ($_GET['msg'] == 'excluido') echo '✅ Contrato excluído com sucesso!'; ?>
    </div>
<?php endif; ?>

<div class="card">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
        <h2 style="margin:0; border:none;">📋 Contratos</h2>
        <a href="form.php" class="btn btn-warning">+ Novo Contrato</a>
    </div>
    <table>
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
            <tr><td colspan="7" style="text-align:center; color:#aaa;">Nenhum contrato cadastrado.</td></tr>
        <?php else: ?>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><span class="badge badge-blue">#<?php echo $row['numero']; ?></span></td>
                <td><?php echo htmlspecialchars($row['profissional']); ?><br><small style="color:#aaa"><?php echo $row['cpf']; ?></small></td>
                <td><?php echo htmlspecialchars($row['empresa']); ?><br><small style="color:#aaa"><?php echo $row['cnpj']; ?></small></td>
                <td><?php echo date('d/m/Y', strtotime($row['data_inicio'])); ?></td>
                <td><?php echo date('d/m/Y', strtotime($row['data_termino'])); ?></td>
                <td style="color:#2e7d32; font-weight:bold;">R$ <?php echo number_format($row['valor_hora'], 2, ',', '.'); ?></td>
                <td>
                    <a href="form.php?id=<?php echo $row['numero']; ?>" class="btn btn-warning btn-sm">✏️ Editar</a>
                    <a href="listar.php?excluir=<?php echo $row['numero']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Excluir este contrato?')">🗑️ Excluir</a>
                </td>
            </tr>
            <?php endwhile; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once '../includes/footer.php'; ?>