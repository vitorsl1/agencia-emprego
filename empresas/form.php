<?php
require_once '../db.php';
require_once '../includes/header.php';

$empresa  = ['cnpj'=>'','razao_social'=>'','endereco'=>''];
$editando = false;

if (isset($_GET['cnpj'])) {
    $cnpj = $conn->real_escape_string($_GET['cnpj']);
    $res  = $conn->query("SELECT * FROM empresa WHERE cnpj='$cnpj'");
    if ($res->num_rows > 0) {
        $empresa  = $res->fetch_assoc();
        $editando = true;
    }
}
?>

<div class="card">
    <h2><?php echo $editando ? '✏️ Editar Empresa' : '+ Nova Empresa'; ?></h2>
    <form action="salvar.php" method="POST">
        <input type="hidden" name="editando" value="<?php echo $editando ? '1' : '0'; ?>">
        <div class="form-row">
            <div class="form-group">
                <label>CNPJ *</label>
                <input type="text" name="cnpj" maxlength="18" placeholder="00.000.000/0000-00"
                    value="<?php echo htmlspecialchars($empresa['cnpj']); ?>"
                    <?php echo $editando ? 'readonly' : ''; ?> required>
            </div>
            <div class="form-group">
                <label>Razão Social *</label>
                <input type="text" name="razao_social" placeholder="Nome da empresa"
                    value="<?php echo htmlspecialchars($empresa['razao_social']); ?>" required>
            </div>
        </div>
        <div class="form-group">
            <label>Endereço *</label>
            <input type="text" name="endereco" placeholder="Rua, número, bairro, cidade"
                value="<?php echo htmlspecialchars($empresa['endereco']); ?>" required>
        </div>
        <div style="display:flex; gap:10px;">
            <button type="submit" class="btn btn-success">💾 Salvar</button>
            <a href="listar.php" class="btn btn-danger">Cancelar</a>
        </div>
    </form>
</div>

<?php require_once '../includes/footer.php'; ?>