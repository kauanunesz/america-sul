<?php
/**
 * Página de Detalhes do País: detalhes.php
 * Sistema: Países da América do Sul
 * Funcionalidades: Ficha Técnica + Mapa com Leaflet.js
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

$page_title = "Detalhes - " . $pais['nome'];

include 'includes/header.php';
?>

<div style="margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
  <a href="listar_paises.php" class="btn btn-secondary btn-sm">&larr; Voltar para a Listagem</a>
  
  <div style="display: flex; gap: 8px;">
    <a href="editar_pais.php?id=<?php echo $pais['id']; ?>" class="btn btn-primary btn-sm">Editar País</a>
    <a href="excluir_pais.php?id=<?php echo $pais['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este país?');">Excluir País</a>
  </div>
</div>

<!-- Hero de Detalhes -->
<section class="detail-hero">
  <img src="uploads/<?php echo htmlspecialchars($pais['bandeira']); ?>" alt="Bandeira do(a) <?php echo htmlspecialchars($pais['nome']); ?>" class="detail-flag" onerror="this.src='https://via.placeholder.com/600x400?text=Sem+Bandeira'">
  
  <div class="detail-info">
    <span class="capital-tag" style="margin-bottom: 12px; display: inline-block;">Capital: <?php echo htmlspecialchars($pais['capital']); ?></span>
    <h1><?php echo htmlspecialchars($pais['nome']); ?></h1>
    <p class="detail-desc"><?php echo nl2br(htmlspecialchars($pais['descricao'])); ?></p>

    <div class="badges-group" style="margin-bottom: 0;">
      <span class="badge badge-<?php echo strtolower($pais['educacao']); ?>">Educação: <?php echo $pais['educacao']; ?></span>
      <span class="badge badge-<?php echo strtolower($pais['seguranca']); ?>">Segurança: <?php echo $pais['seguranca']; ?></span>
      <span class="badge badge-<?php echo strtolower($pais['saude']); ?>">Saúde: <?php echo $pais['saude']; ?></span>
    </div>
  </div>
</section>

<!-- Grid de Especificações e Indicadores -->
<section class="details-grid">
  <div class="detail-spec-box">
    <label>Área Territorial</label>
    <span><?php echo htmlspecialchars($pais['area']); ?></span>
  </div>

  <div class="detail-spec-box">
    <label>População Estimada</label>
    <span><?php echo htmlspecialchars($pais['populacao']); ?></span>
  </div>

  <div class="detail-spec-box">
    <label>Presidente / Chefe</label>
    <span><?php echo htmlspecialchars($pais['presidente']); ?></span>
  </div>

  <div class="detail-spec-box">
    <label>Índice IDH</label>
    <span style="color: var(--primary-cyan);"><?php echo htmlspecialchars($pais['idh']); ?></span>
  </div>

  <div class="detail-spec-box">
    <label>Produto Interno Bruto</label>
    <span><?php echo htmlspecialchars($pais['pib']); ?></span>
  </div>

  <div class="detail-spec-box">
    <label>Idioma Oficial</label>
    <span><?php echo htmlspecialchars($pais['idioma']); ?></span>
  </div>

  <div class="detail-spec-box">
    <label>Moeda Oficial</label>
    <span><?php echo htmlspecialchars($pais['moeda']); ?></span>
  </div>
</section>

<!-- Mapa Interativo do País com Leaflet.js -->
<section class="map-section">
  <div class="map-header">
    <h2>Localização Geográfica no Mapa (Leaflet.js)</h2>
    <span style="font-size: 0.85rem; color: var(--text-muted);">Coordenadas: Lat <?php echo $pais['latitude']; ?>, Lng <?php echo $pais['longitude']; ?></span>
  </div>
  <div id="leaflet-map"></div>
</section>

<script>
document.addEventListener("DOMContentLoaded", function() {
  var lat = <?php echo (float) $pais['latitude']; ?>;
  var lng = <?php echo (float) $pais['longitude']; ?>;
  
  // Se as coordenadas forem nulas ou 0, centraliza na América do Sul
  if (lat === 0 && lng === 0) {
    lat = -15.0;
    lng = -60.0;
  }

  var map = L.map('leaflet-map').setView([lat, lng], 5);

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 18,
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
  }).addTo(map);

  var customPopup = `
    <div style="text-align: center; padding: 4px;">
      <h4 style="margin:0; color: #38bdf8; font-size: 1.1rem;"><?php echo htmlspecialchars($pais['nome']); ?></h4>
      <p style="margin: 4px 0 0 0; color: #cbd5e1;">Capital: <strong><?php echo htmlspecialchars($pais['capital']); ?></strong></p>
    </div>
  `;

  L.marker([lat, lng]).addTo(map).bindPopup(customPopup).openPopup();
});
</script>

<?php include 'includes/footer.php'; ?>