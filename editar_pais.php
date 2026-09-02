<?php
/**
 * Formulário de Edição: editar_pais.php
 * Sistema: Países da América do Sul
 */

require_once 'conexao.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

$stmt = $pdo->prepare("SELECT * FROM paises WHERE id = :id");
$stmt->execute(['id' => $id]);
$pais = $stmt->fetch();

if (!$pais) {
    header("Location: listar_paises.php?erro=" . urlencode("País não encontrado."));
    exit;
}

$page_title = "Editar - " . $pais['nome'];

include 'includes/header.php';
?>

<div style="margin-bottom: 32px;">
  <a href="listar_paises.php" class="btn btn-secondary btn-sm" style="margin-bottom: 16px;">&larr; Voltar para a Listagem</a>
  <h1>Editar Dados do País: <?php echo htmlspecialchars($pais['nome']); ?></h1>
  <p style="color: var(--text-muted);">Atualize os campos necessários abaixo. Caso não deseje alterar a bandeira, deixe o campo de upload em branco.</p>
</div>

<div class="form-container">
  <form action="atualizar_pais.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo $pais['id']; ?>">
    <input type="hidden" name="bandeira_atual" value="<?php echo htmlspecialchars($pais['bandeira']); ?>">

    <div class="form-grid">
      
      <!-- Nome do País -->
      <div class="form-group">
        <label for="nome" class="form-label">Nome do País *</label>
        <input type="text" id="nome" name="nome" class="form-control" value="<?php echo htmlspecialchars($pais['nome']); ?>" required>
      </div>

      <!-- Capital -->
      <div class="form-group">
        <label for="capital" class="form-label">Capital *</label>
        <input type="text" id="capital" name="capital" class="form-control" value="<?php echo htmlspecialchars($pais['capital']); ?>" required>
      </div>

      <!-- Idioma Oficial -->
      <div class="form-group">
        <label for="idioma" class="form-label">Idioma Oficial *</label>
        <input type="text" id="idioma" name="idioma" class="form-control" value="<?php echo htmlspecialchars($pais['idioma']); ?>" required>
      </div>

      <!-- Moeda -->
      <div class="form-group">
        <label for="moeda" class="form-label">Moeda Oficial *</label>
        <input type="text" id="moeda" name="moeda" class="form-control" value="<?php echo htmlspecialchars($pais['moeda']); ?>" required>
      </div>

      <!-- População -->
      <div class="form-group">
        <label for="populacao" class="form-label">População *</label>
        <input type="text" id="populacao" name="populacao" class="form-control" value="<?php echo htmlspecialchars($pais['populacao']); ?>" required>
      </div>

      <!-- Área Territorial -->
      <div class="form-group">
        <label for="area" class="form-label">Área Territorial *</label>
        <input type="text" id="area" name="area" class="form-control" value="<?php echo htmlspecialchars($pais['area']); ?>" required>
      </div>

      <!-- Presidente -->
      <div class="form-group">
        <label for="presidente" class="form-label">Presidente / Chefe de Estado *</label>
        <input type="text" id="presidente" name="presidente" class="form-control" value="<?php echo htmlspecialchars($pais['presidente']); ?>" required>
      </div>

      <!-- IDH -->
      <div class="form-group">
        <label for="idh" class="form-label">IDH *</label>
        <input type="number" step="0.001" min="0" max="1" id="idh" name="idh" class="form-control" value="<?php echo htmlspecialchars($pais['idh']); ?>" required>
      </div>

      <!-- PIB -->
      <div class="form-group">
        <label for="pib" class="form-label">PIB *</label>
        <input type="text" id="pib" name="pib" class="form-control" value="<?php echo htmlspecialchars($pais['pib']); ?>" required>
      </div>

      <!-- Educação -->
      <div class="form-group">
        <label for="educacao" class="form-label">Nível de Educação *</label>
        <select id="educacao" name="educacao" class="form-control" required>
          <option value="Alta" <?php echo $pais['educacao'] == 'Alta' ? 'selected' : ''; ?>>Alta</option>
          <option value="Média" <?php echo $pais['educacao'] == 'Média' ? 'selected' : ''; ?>>Média</option>
          <option value="Baixa" <?php echo $pais['educacao'] == 'Baixa' ? 'selected' : ''; ?>>Baixa</option>
        </select>
      </div>

      <!-- Segurança -->
      <div class="form-group">
        <label for="seguranca" class="form-label">Nível de Segurança *</label>
        <select id="seguranca" name="seguranca" class="form-control" required>
          <option value="Alta" <?php echo $pais['seguranca'] == 'Alta' ? 'selected' : ''; ?>>Alta</option>
          <option value="Moderada" <?php echo $pais['seguranca'] == 'Moderada' ? 'selected' : ''; ?>>Moderada</option>
          <option value="Baixa" <?php echo $pais['seguranca'] == 'Baixa' ? 'selected' : ''; ?>>Baixa</option>
        </select>
      </div>

      <!-- Saúde -->
      <div class="form-group">
        <label for="saude" class="form-label">Nível de Saúde *</label>
        <select id="saude" name="saude" class="form-control" required>
          <option value="Alta" <?php echo $pais['saude'] == 'Alta' ? 'selected' : ''; ?>>Alta</option>
          <option value="Média" <?php echo $pais['saude'] == 'Média' ? 'selected' : ''; ?>>Média</option>
          <option value="Baixa" <?php echo $pais['saude'] == 'Baixa' ? 'selected' : ''; ?>>Baixa</option>
        </select>
      </div>

      <!-- Latitude & Longitude -->
      <div class="form-group">
        <label for="latitude" class="form-label">Latitude</label>
        <input type="number" step="0.000001" id="latitude" name="latitude" class="form-control" value="<?php echo htmlspecialchars($pais['latitude']); ?>">
      </div>

      <div class="form-group">
        <label for="longitude" class="form-label">Longitude</label>
        <input type="number" step="0.000001" id="longitude" name="longitude" class="form-control" value="<?php echo htmlspecialchars($pais['longitude']); ?>">
      </div>

      <!-- Bandeira Atual + Novo Upload -->
      <div class="form-group full-width">
        <label class="form-label">Bandeira Atual</label>
        <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 12px; background: rgba(15,23,42,0.6); padding: 12px; border-radius: var(--radius-md); border: 1px solid var(--border-color);">
          <img src="uploads/<?php echo htmlspecialchars($pais['bandeira']); ?>" alt="Bandeira" style="width: 100px; height: 60px; object-fit: cover; border-radius: 6px; border: 1px solid #334155;">
          <div>
            <p style="font-weight: 600; font-size: 0.9rem; color: var(--text-main);"><?php echo htmlspecialchars($pais['bandeira']); ?></p>
            <p style="font-size: 0.8rem; color: var(--text-muted);">Envie um novo arquivo caso deseje substituir esta bandeira.</p>
          </div>
        </div>

        <label for="bandeira" class="form-label">Nova Bandeira (Opcional)</label>
        <div class="file-upload-box" onclick="document.getElementById('bandeira').click();">
          <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#06b6d4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 8px;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
          <p style="font-size: 0.9rem; font-weight: 600;">Clique para escolher um novo arquivo de imagem</p>
          <input type="file" id="bandeira" name="bandeira" accept="image/*" style="display: none;" onchange="previewFileName(this)">
          <div id="file-name-display" style="margin-top: 12px; font-weight: 600; color: var(--primary-cyan);"></div>
        </div>
      </div>

      <!-- Descrição -->
      <div class="form-group full-width">
        <label for="descricao" class="form-label">Descrição *</label>
        <textarea id="descricao" name="descricao" class="form-control" required><?php echo htmlspecialchars($pais['descricao']); ?></textarea>
      </div>

    </div>

    <div style="display: flex; gap: 16px; justify-content: flex-end; margin-top: 32px; border-top: 1px solid var(--border-color); padding-top: 24px;">
      <a href="listar_paises.php" class="btn btn-secondary">Cancelar</a>
      <button type="submit" class="btn btn-primary">Atualizar País</button>
    </div>
  </form>
</div>

<script>
function previewFileName(input) {
  var display = document.getElementById('file-name-display');
  if (input.files && input.files[0]) {
    display.textContent = "📄 Novo arquivo selecionado: " + input.files[0].name;
  } else {
    display.textContent = "";
  }
}
</script>

<?php include 'includes/footer.php'; ?>