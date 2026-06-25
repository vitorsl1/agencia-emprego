<?php
require_once '../db.php';
require_once '../includes/header.php';

$profissional = ['cpf'=>'','nome'=>'','endereco'=>'','data_nascimento'=>'','profissao'=>''];
$editando = false;

if (isset($_GET['cpf'])) {
    $cpf = $conn->real_escape_string($_GET['cpf']);
    $res = $conn->query("SELECT * FROM profissional WHERE cpf='$cpf'");
    if ($res->num_rows > 0) {
        $profissional = $res->fetch_assoc();
        $editando = true;
    }
}
?>

<div class="card">
    <h2><?php echo $editando ? '✏️ Editar Profissional' : '+ Novo Profissional'; ?></h2>
    <form action="salvar.php" method="POST">
        <input type="hidden" name="editando" value="<?php echo $editando ? '1' : '0'; ?>">
        <div class="form-row">
            <div class="form-group">
                <label>CPF *</label>
                <input type="text" name="cpf" maxlength="14" placeholder="000.000.000-00"
                    value="<?php echo htmlspecialchars($profissional['cpf']); ?>"
                    <?php echo $editando ? 'readonly' : ''; ?> required>
            </div>
            <div class="form-group">
                <label>Nome Completo *</label>
                <input type="text" name="nome" placeholder="Nome completo"
                    value="<?php echo htmlspecialchars($profissional['nome']); ?>" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>Profissão *</label>
                <input type="text" name="profissao" placeholder="Ex: Eletricista"
                    value="<?php echo htmlspecialchars($profissional['profissao']); ?>" required>
            </div>
            <div class="form-group">
                <label>Data de Nascimento *</label>
                <input type="date" name="data_nascimento"
                    value="<?php echo htmlspecialchars($profissional['data_nascimento']); ?>" required>
            </div>
        </div>
        <div class="form-group">
            <label>Endereço *</label>
            <input type="text" name="endereco" placeholder="Rua, número, bairro, cidade"
                value="<?php echo htmlspecialchars($profissional['endereco']); ?>" required>
        </div>
        <div style="display:flex; gap:10px;">
            <button type="submit" class="btn btn-primary">💾 Salvar</button>
            <a href="listar.php" class="btn btn-danger">Cancelar</a>
        </div>
    </form>
</div>

<?php require_once '../includes/footer.php'; ?>