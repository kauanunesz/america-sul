<?php
/**
 * Listagem de Países: listar_paises.php
 * Sistema: Países da América do Sul
 * Funcionalidades: CRUD Consulta, Pesquisa, Ordenação e Estatísticas
 */

require_once 'conexao.php';

$page_title = "Países Cadastrados";

// Filtros de Pesquisa e Ordenação (Desafio Extra)
$busca = isset($_GET['busca']) ? trim($_GET['busca']) : '';
$ordem = isset($_GET['ordem']) ? $_GET['ordem'] : 'nome_asc';

// Montagem da Query Dinâmica com PDO
$sql = "SELECT * FROM paises WHERE nome LIKE :busca OR capital LIKE :busca";

switch ($ordem) {
    case 'nome_desc':
        $sql .= " ORDER BY nome DESC";
        break;
    case 'idh_desc':
        $sql .= " ORDER BY idh DESC";
        break;
    case 'capital_asc':
        $sql .= " ORDER BY capital ASC";
        break;
    default: // nome_asc
        $sql .= " ORDER BY nome ASC";
        break;
}

$stmt = $pdo->prepare($sql);
$stmt->execute(['busca' => '%' . $busca . '%']);
$paises = $stmt->fetchAll();

// Estatísticas da Pesquisa
$totalPaises = count($paises);

include 'includes/header.php';
?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 16px;">
  <div>
    <h1>Países Cadastrados na América do Sul</h1>
    <p style="color: var(--text-muted);">Gerenciamento de fichas técnicas, indicadores e localização geográfica.</p>
  </div>
  <a href="cadastrar_pais.php" class="btn btn-success">
    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
    CADASTRAR PAÍS
  </a>
</div>

<!-- Alertas de Sucesso / Erro vindos do CRUD -->
<?php if (isset($_GET['msg'])): ?>
  <div class="alert alert-success">
    <span>✅ <?php echo htmlspecialchars($_GET['msg']); ?></span>
  </div>
<?php endif; ?>

<?php if (isset($_GET['erro'])): ?>
  <div class="alert alert-error">
    <span>⚠️ <?php echo htmlspecialchars($_GET['erro']); ?></span>
  </div>
<?php endif; ?>

<!-- Barra de Filtros e Pesquisa (Desafio Extra) -->
<form method="GET" action="listar_paises.php" class="filter-bar">
  <div class="search-box">
    <span class="search-icon">🔍</span>
    <input type="text" name="busca" class="search-input" placeholder="Buscar país ou capital..." value="<?php echo htmlspecialchars($busca); ?>">
  </div>
  
  <div style="display: flex; gap: 12px; align-items: center;">
    <label for="ordem" style="font-size: 0.85rem; color: var(--text-muted);">Ordenar por:</label>
    <select name="ordem" id="ordem" class="sort-select" onchange="this.form.submit()">
      <option value="nome_asc" <?php echo $ordem == 'nome_asc' ? 'selected' : ''; ?>>Nome (A-Z)</option>
      <option value="nome_desc" <?php echo $ordem == 'nome_desc' ? 'selected' : ''; ?>>Nome (Z-A)</option>
      <option value="idh_desc" <?php echo $ordem == 'idh_desc' ? 'selected' : ''; ?>>Maior IDH</option>
      <option value="capital_asc" <?php echo $ordem == 'capital_asc' ? 'selected' : ''; ?>>Capital (A-Z)</option>
    </select>

    <button type="submit" class="btn btn-secondary btn-sm">Filtrar</button>
    <?php if (!empty($busca)): ?>
      <a href="listar_paises.php" class="btn btn-danger btn-sm">Limpar</a>
    <?php endif; ?>
  </div>
</form>

<!-- Estatística da Consulta -->
<div style="margin-bottom: 24px; color: var(--text-muted); font-size: 0.9rem;">
  Exibindo <strong><?php echo $totalPaises; ?></strong> país(es) cadastrado(s)<?php echo !empty($busca) ? ' para a busca "' . htmlspecialchars($busca) . '"' : ''; ?>.
</div>

<!-- Grid de Cards de Países -->
<?php if ($totalPaises > 0): ?>
  <div class="cards-grid">
    <?php foreach ($paises as $p): ?>
      <div class="country-card">
        <div class="flag-wrapper">
          <img src="uploads/<?php echo htmlspecialchars($p['bandeira']); ?>" alt="Bandeira do(a) <?php echo htmlspecialchars($p['nome']); ?>" class="flag-img" onerror="this.src='https://via.placeholder.com/600x400?text=Sem+Bandeira'">
        </div>
        
        <div class="country-body">
          <div class="country-header">
            <h2 class="country-name"><?php echo htmlspecialchars($p['nome']); ?></h2>
            <span class="capital-tag"><?php echo htmlspecialchars($p['capital']); ?></span>
          </div>

          <ul class="specs-list">
            <li class="specs-item"><span>Presidente:</span> <strong><?php echo htmlspecialchars($p['presidente']); ?></strong></li>
            <li class="specs-item"><span>População:</span> <strong><?php echo htmlspecialchars($p['populacao']); ?></strong></li>
            <li class="specs-item"><span>Área:</span> <strong><?php echo htmlspecialchars($p['area']); ?></strong></li>
            <li class="specs-item"><span>IDH:</span> <strong><?php echo htmlspecialchars($p['idh']); ?></strong></li>
            <li class="specs-item"><span>PIB:</span> <strong><?php echo htmlspecialchars($p['pib']); ?></strong></li>
          </ul>

          <div class="badges-group">
            <span class="badge badge-<?php echo strtolower($p['educacao']); ?>">Educação: <?php echo $p['educacao']; ?></span>
            <span class="badge badge-<?php echo strtolower($p['seguranca']); ?>">Segurança: <?php echo $p['seguranca']; ?></span>
            <span class="badge badge-<?php echo strtolower($p['saude']); ?>">Saúde: <?php echo $p['saude']; ?></span>
          </div>

          <div class="card-actions">
            <a href="detalhes.php?id=<?php echo $p['id']; ?>" class="btn btn-primary btn-sm">Ver Detalhes</a>
            <a href="editar_pais.php?id=<?php echo $p['id']; ?>" class="btn btn-secondary btn-sm">Editar</a>
            <a href="excluir_pais.php?id=<?php echo $p['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir o país <?php echo htmlspecialchars($p['nome']); ?>?');">Excluir</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
<?php else: ?>
  <div style="background: var(--bg-card); border: 1px dashed var(--border-color); padding: 48px; text-align: center; border-radius: var(--radius-lg);">
    <h3>Nenhum país encontrado</h3>
    <p style="color: var(--text-muted); margin: 12px 0 24px 0;">Não encontramos nenhum registro correspondente com os critérios informados.</p>
    <a href="cadastrar_pais.php" class="btn btn-success">Cadastrar Novo País</a>
  </div>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>