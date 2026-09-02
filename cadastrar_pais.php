<?php
/**
 * Formulário de Cadastro: cadastrar_pais.php
 * Sistema: Países da América do Sul
 */

require_once 'conexao.php';

$page_title = "Cadastrar País";

include 'includes/header.php';
?>

<div style="margin-bottom: 32px;">
  <a href="listar_paises.php" class="btn btn-secondary btn-sm" style="margin-bottom: 16px;">&larr; Voltar para a Listagem</a>
  <h1>Cadastrar Novo País</h1>
  <p style="color: var(--text-muted);">Preencha as informações detalhadas do país sul-americano e faça o upload da bandeira.</p>
</div>

<div class="form-container">
  <form action="salvar_pais.php" method="POST" enctype="multipart/form-data">
    <div class="form-grid">
      
      <!-- Nome do País -->
      <div class="form-group">
        <label for="nome" class="form-label">Nome do País *</label>
        <input type="text" id="nome" name="nome" class="form-control" placeholder="Ex: Argentina" required>
      </div>

      <!-- Capital -->
      <div class="form-group">
        <label for="capital" class="form-label">Capital *</label>
        <input type="text" id="capital" name="capital" class="form-control" placeholder="Ex: Buenos Aires" required>
      </div>

      <!-- Idioma Oficial -->
      <div class="form-group">
        <label for="idioma" class="form-label">Idioma Oficial *</label>
        <input type="text" id="idioma" name="idioma" class="form-control" placeholder="Ex: Espanhol" required>
      </div>

      <!-- Moeda -->
      <div class="form-group">
        <label for="moeda" class="form-label">Moeda Oficial *</label>
        <input type="text" id="moeda" name="moeda" class="form-control" placeholder="Ex: Peso Argentino" required>
      </div>

      <!-- População -->
      <div class="form-group">
        <label for="populacao" class="form-label">População *</label>
        <input type="text" id="populacao" name="populacao" class="form-control" placeholder="Ex: 46.000.000 ou 46 milhões" required>
      </div>

      <!-- Área Territorial -->
      <div class="form-group">
        <label for="area" class="form-label">Área Territorial *</label>
        <input type="text" id="area" name="area" class="form-control" placeholder="Ex: 2.780.400 Km²" required>
      </div>

      <!-- Presidente -->
      <div class="form-group">
        <label for="presidente" class="form-label">Presidente / Chefe de Estado *</label>
        <input type="text" id="presidente" name="presidente" class="form-control" placeholder="Ex: Javier Milei" required>
      </div>

      <!-- IDH -->
      <div class="form-group">
        <label for="idh" class="form-label">Índice de Desenv. Humano (IDH) *</label>
        <input type="number" step="0.001" min="0" max="1" id="idh" name="idh" class="form-control" placeholder="Ex: 0.845" required>
      </div>

      <!-- PIB -->
      <div class="form-group">
        <label for="pib" class="form-label">Produto Interno Bruto (PIB) *</label>
        <input type="text" id="pib" name="pib" class="form-control" placeholder="Ex: USD 1.1 Trilhões" required>
      </div>

      <!-- Educação -->
      <div class="form-group">
        <label for="educacao" class="form-label">Nível de Educação *</label>
        <select id="educacao" name="educacao" class="form-control" required>
          <option value="Alta">Alta</option>
          <option value="Média" selected>Média</option>
          <option value="Baixa">Baixa</option>
        </select>
      </div>

      <!-- Segurança -->
      <div class="form-group">
        <label for="seguranca" class="form-label">Nível de Segurança *</label>
        <select id="seguranca" name="seguranca" class="form-control" required>
          <option value="Alta">Alta</option>
          <option value="Moderada" selected>Moderada</option>
          <option value="Baixa">Baixa</option>
        </select>
      </div>

      <!-- Saúde -->
      <div class="form-group">
        <label for="saude" class="form-label">Nível de Saúde *</label>
        <select id="saude" name="saude" class="form-control" required>
          <option value="Alta">Alta</option>
          <option value="Média" selected>Média</option>
          <option value="Baixa">Baixa</option>
        </select>
      </div>

      <!-- Coordenadas Geográficas para o Mapa Leaflet -->
      <div class="form-group">
        <label for="latitude" class="form-label">Latitude (para o Mapa Leaflet)</label>
        <input type="number" step="0.000001" id="latitude" name="latitude" class="form-control" placeholder="Ex: -34.603722">
      </div>

      <div class="form-group">
        <label for="longitude" class="form-label">Longitude (para o Mapa Leaflet)</label>
        <input type="number" step="0.000001" id="longitude" name="longitude" class="form-control" placeholder="Ex: -58.381592">
      </div>

      <!-- Bandeira do País (Upload) -->
      <div class="form-group full-width">
        <label for="bandeira" class="form-label">Bandeira do País (Upload de Imagem PNG, JPG, SVG ou WEBP) *</label>
        <div class="file-upload-box" onclick="document.getElementById('bandeira').click();">
          <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="#06b6d4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 8px;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
          <p style="font-weight: 600; color: var(--text-main);">Clique para escolher a imagem da bandeira</p>
          <p style="font-size: 0.8rem; color: var(--text-dim); margin-top: 4px;">Formatos suportados: PNG, JPG, JPEG, SVG, WEBP (Máx: 5MB)</p>
          <input type="file" id="bandeira" name="bandeira" accept="image/*" style="display: none;" onchange="previewFileName(this)" required>
          <div id="file-name-display" style="margin-top: 12px; font-weight: 600; color: var(--primary-cyan);"></div>
        </div>
      </div>

      <!-- Descrição -->
      <div class="form-group full-width">
        <label for="descricao" class="form-label">Descrição Histórica e Geográfica *</label>
        <textarea id="descricao" name="descricao" class="form-control" placeholder="Descreva os principais aspectos econômicos, culturais e geográficos do país..." required></textarea>
      </div>

    </div> <!-- /.form-grid -->

    <div style="display: flex; gap: 16px; justify-content: flex-end; margin-top: 32px; border-top: 1px solid var(--border-color); padding-top: 24px;">
      <a href="listar_paises.php" class="btn btn-secondary">Cancelar</a>
      <button type="submit" class="btn btn-success">Salvar País</button>
    </div>
  </form>
</div>

<script>
function previewFileName(input) {
  var display = document.getElementById('file-name-display');
  if (input.files && input.files[0]) {
    display.textContent = "📄 Arquivo selecionado: " + input.files[0].name;
  } else {
    display.textContent = "";
  }
}
</script>

<?php include 'includes/footer.php'; ?>