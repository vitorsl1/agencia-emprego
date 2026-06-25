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
    <div class="card-header py-3">
        <h5 class="mb-0">
            <i class="bi bi-<?php echo $editando ? 'pencil-fill' : 'plus-lg'; ?>"></i>
            <?php echo $editando ? ' Editar Profissional' : ' Novo Profissional'; ?>
        </h5>
    </div>
    <div class="card-body">
        <form action="salvar.php" method="POST">
            <input type="hidden" name="editando" value="<?php echo $editando ? '1' : '0'; ?>">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">CPF *</label>
                    <input type="text" name="cpf" class="form-control" maxlength="14" placeholder="000.000.000-00"
                        value="<?php echo htmlspecialchars($profissional['cpf']); ?>"
                        <?php echo $editando ? 'readonly' : ''; ?> required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Nome Completo *</label>
                    <input type="text" name="nome" class="form-control" placeholder="Nome completo"
                        value="<?php echo htmlspecialchars($profissional['nome']); ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Profissão *</label>
                    <input type="text" name="profissao" class="form-control" placeholder="Ex: Eletricista"
                        value="<?php echo htmlspecialchars($profissional['profissao']); ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Data de Nascimento *</label>
                    <input type="date" name="data_nascimento" class="form-control"
                        value="<?php echo htmlspecialchars($profissional['data_nascimento']); ?>" required>
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Endereço *</label>
                    <input type="text" name="endereco" class="form-control" placeholder="Rua, número, bairro, cidade"
                        value="<?php echo htmlspecialchars($profissional['endereco']); ?>" required>
                </div>
            </div>
            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-floppy-fill"></i> Salvar</button>
                <a href="listar.php" class="btn btn-secondary"><i class="bi bi-x-lg"></i> Cancelar</a>
            </div>
        </form>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>