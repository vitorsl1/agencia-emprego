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
    <div class="card-header py-3">
        <h5 class="mb-0">
            <i class="bi bi-<?php echo $editando ? 'pencil-fill' : 'plus-lg'; ?>"></i>
            <?php echo $editando ? ' Editar Empresa' : ' Nova Empresa'; ?>
        </h5>
    </div>
    <div class="card-body">
        <form action="salvar.php" method="POST">
            <input type="hidden" name="editando" value="<?php echo $editando ? '1' : '0'; ?>">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">CNPJ *</label>
                    <input type="text" name="cnpj" class="form-control" maxlength="18" placeholder="00.000.000/0000-00"
                        value="<?php echo htmlspecialchars($empresa['cnpj']); ?>"
                        <?php echo $editando ? 'readonly' : ''; ?> required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Razão Social *</label>
                    <input type="text" name="razao_social" class="form-control" placeholder="Nome da empresa"
                        value="<?php echo htmlspecialchars($empresa['razao_social']); ?>" required>
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Endereço *</label>
                    <input type="text" name="endereco" class="form-control" placeholder="Rua, número, bairro, cidade"
                        value="<?php echo htmlspecialchars($empresa['endereco']); ?>" required>
                </div>
            </div>
            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-success"><i class="bi bi-floppy-fill"></i> Salvar</button>
                <a href="listar.php" class="btn btn-secondary"><i class="bi bi-x-lg"></i> Cancelar</a>
            </div>
        </form>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>