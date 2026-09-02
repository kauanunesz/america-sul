<?php
/**
 * Página Inicial: index.php
 * Sistema: Países da América do Sul
 */

require_once 'conexao.php';

$page_title = "Página Inicial";

// Buscar estatísticas gerais do banco de dados
$stmtStats = $pdo->query("SELECT COUNT(*) AS total, MAX(idh) AS max_idh FROM paises");
$stats = $stmtStats->fetch();

// Buscar todos os países para os marcadores do Mapa Leaflet
$stmtPaises = $pdo->query("SELECT id, nome, capital, latitude, longitude, bandeira FROM paises");
$paisesMapa = $stmtPaises->fetchAll();

// Buscar os 3 primeiros países em destaque para o grid inicial
$stmtDestaques = $pdo->query("SELECT * FROM paises ORDER BY id ASC LIMIT 3");
$destaques = $stmtDestaques->fetchAll();

include 'includes/header.php';
?>

<!-- Hero Card Principal -->
<section class="hero-card">
  <h1 class="hero-title">Países da América do Sul</h1>
  <p class="hero-subtitle">
    Exploração completa de dados geográficos, indicadores socioeconômicos, mapas interativos e upload de bandeiras dos 12 países sul-americanos.
  </p>
  
  <!-- BOTÕES OBRIGATÓRIOS DESTACADOS NA TELA INICIAL -->
  <div class="hero-buttons">
    <a href="listar_paises.php" class="btn btn-primary">
      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
      PAÍSES CADASTRADOS
    </a>
    
    <a href="cadastrar_pais.php" class="btn btn-success">
      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
      CADASTRAR PAÍS
    </a>
  </div>
</section>

<!-- Painel Estatístico -->
<section class="stats-grid">
  <div class="stat-card">
    <div class="stat-icon">🌎</div>
    <div class="stat-info">
      <h3><?php echo $stats['total']; ?></h3>
      <p>Países Cadastrados</p>
    </div>
  </div>
  
  <div class="stat-card">
    <div class="stat-icon">👥</div>
    <div class="stat-info">
      <h3>~434 mi</h3>
      <p>População Total Estimada</p>
    </div>
  </div>
  
  <div class="stat-card">
    <div class="stat-icon">📈</div>
    <div class="stat-info">
      <h3><?php echo number_format($stats['max_idh'] ?? 0.855, 3); ?></h3>
      <p>Maior IDH (Chile)</p>
    </div>
  </div>

  <div class="stat-card">
    <div class="stat-icon">📐</div>
    <div class="stat-info">
      <h3>17.8 mi Km²</h3>
      <p>Área Territorial da Região</p>
    </div>
  </div>
</section>

<!-- Mapa da América do Sul (Plain Leaflet) -->
<section class="map-section">
  <div class="map-header">
    <h2>Visão Geográfica no Mapa (Leaflet.js)</h2>
    <span class="capital-tag">Clique nos marcadores para ver a capital e bandeira</span>
  </div>
  <div id="leaflet-map"></div>
</section>

<!-- Países em Destaque -->
<section style="margin-top: 40px;">
  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
    <h2>Destaques da Região</h2>
    <a href="listar_paises.php" class="btn btn-secondary btn-sm">Ver Todos os Países &rarr;</a>
  </div>
  
  <div class="cards-grid">
    <?php foreach ($destaques as $p): ?>
      <div class="country-card">
        <div class="flag-wrapper">
          <img src="uploads/<?php echo htmlspecialchars($p['bandeira']); ?>" alt="Bandeira <?php echo htmlspecialchars($p['nome']); ?>" class="flag-img" onerror="this.src='https://via.placeholder.com/600x400?text=Sem+Bandeira'">
        </div>
        <div class="country-body">
          <div class="country-header">
            <h3 class="country-name"><?php echo htmlspecialchars($p['nome']); ?></h3>
            <span class="capital-tag"><?php echo htmlspecialchars($p['capital']); ?></span>
          </div>
          
          <ul class="specs-list">
            <li class="specs-item"><span>Presidente:</span> <strong><?php echo htmlspecialchars($p['presidente']); ?></strong></li>
            <li class="specs-item"><span>População:</span> <strong><?php echo htmlspecialchars($p['populacao']); ?></strong></li>
            <li class="specs-item"><span>IDH:</span> <strong><?php echo htmlspecialchars($p['idh']); ?></strong></li>
          </ul>

          <div class="card-actions">
            <a href="detalhes.php?id=<?php echo $p['id']; ?>" class="btn btn-primary btn-sm">Ver Detalhes</a>
            <a href="editar_pais.php?id=<?php echo $p['id']; ?>" class="btn btn-secondary btn-sm">Editar</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</section>

<!-- Script de Inicialização do Mapa Leaflet da América do Sul -->
<script>
document.addEventListener("DOMContentLoaded", function() {
  // Centro da América do Sul: Latitude ~ -15.0, Longitude ~ -60.0
  var map = L.map('leaflet-map').setView([-15.0, -60.0], 3);

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 18,
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
  }).addTo(map);

  // Adicionar marcadores com base no banco de dados
  var paises = <?php echo json_encode($paisesMapa); ?>;
  
  paises.forEach(function(p) {
    if (parseFloat(p.latitude) !== 0 && parseFloat(p.longitude) !== 0) {
      var popupContent = `
        <div style="text-align: center; font-family: sans-serif; padding: 4px;">
          <img src="uploads/${p.bandeira}" style="width: 80px; height: 50px; object-fit: cover; border-radius: 4px; margin-bottom: 6px; border: 1px solid #334155;">
          <h4 style="margin: 0; font-size: 1rem; color: #38bdf8;">${p.nome}</h4>
          <p style="margin: 4px 0 8px 0; font-size: 0.85rem; color: #cbd5e1;">Capital: <strong>${p.capital}</strong></p>
          <a href="detalhes.php?id=${p.id}" style="display: inline-block; background: #06b6d4; color: #fff; padding: 4px 10px; border-radius: 4px; text-decoration: none; font-size: 0.8rem; font-weight: bold;">Ver Ficha Técnica</a>
        </div>
      `;
      L.marker([p.latitude, p.longitude]).addTo(map).bindPopup(popupContent);
    }
  });
});
</script>

<?php include 'includes/footer.php'; ?>