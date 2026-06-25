<?php
require_once '../db.php';
require_once '../includes/header.php';

$contrato = ['numero'=>'','cpf_profissional'=>'','cnpj_empresa'=>'','data_inicio'=>'','data_termino'=>'','valor_hora'=>''];
$editando = false;

if (isset($_GET['id'])) {
    $id  = (int)$_GET['id'];
    $res = $conn->query("SELECT * FROM contrato WHERE numero=$id");
    if ($res->num_rows > 0) {
        $contrato = $res->fetch_assoc();
        $editando = true;
    }
}

$profissionais = $conn->query("SELECT cpf, nome FROM profissional ORDER BY nome");
$empresas      = $conn->query("SELECT cnpj, razao_social FROM empresa ORDER BY razao_social");
?>

<div class="card">
    <h2><?php echo $editando ? '✏️ Editar Contrato' : '+ Novo Contrato'; ?></h2>
    <form action="salvar.php" method="POST">
        <input type="hidden" name="editando" value="<?php echo $editando ? '1' : '0'; ?>">
        <input type="hidden" name="numero" value="<?php echo $contrato['numero']; ?>">
        <div class="form-row">
            <div class="form-group">
                <label>Profissional *</label>
                <select name="cpf_profissional" required>
                    <option value="">-- Selecione --</option>
                    <?php while ($p = $profissionais->fetch_assoc()): ?>
                    <option value="<?php echo $p['cpf']; ?>" <?php echo ($contrato['cpf_profissional']==$p['cpf']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($p['nome']); ?> (<?php echo $p['cpf']; ?>)
                    </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Empresa *</label>
                <select name="cnpj_empresa" required>
                    <option value="">-- Selecione --</option>
                    <?php while ($e = $empresas->fetch_assoc()): ?>
                    <option value="<?php echo $e['cnpj']; ?>" <?php echo ($contrato['cnpj_empresa']==$e['cnpj']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($e['razao_social']); ?> (<?php echo $e['cnpj']; ?>)
                    </option>
                    <?php endwhile; ?>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>Data de Início *</label>
                <input type="date" name="data_inicio" value="<?php echo $contrato['data_inicio']; ?>" required>
            </div>
            <div class="form-group">
                <label>Data de Término *</label>
                <input type="date" name="data_termino" value="<?php echo $contrato['data_termino']; ?>" required>
            </div>
            <div class="form-group">
                <label>Valor por Hora (R$) *</label>
                <input type="number" name="valor_hora" step="0.01" min="0" placeholder="0,00"
                    value="<?php echo $contrato['valor_hora']; ?>" required>
            </div>
        </div>
        <div style="display:flex; gap:10px;">
            <button type="submit" class="btn btn-warning">💾 Salvar</button>
            <a href="listar.php" class="btn btn-danger">Cancelar</a>
        </div>
    </form>
</div>

<?php require_once '../includes/footer.php'; ?>