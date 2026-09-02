<?php
/**
 * Componente: Rodapé Global (Footer)
 * Sistema: Países da América do Sul
 */
?>
    </div> <!-- /.container -->
  </main> <!-- /.main-content -->

  <!-- Rodapé -->
  <footer class="footer">
    <div class="container footer-wrapper">
      <div>
        <p>&copy; <?php echo date('Y'); ?> <strong>América do Sul Explorer</strong>. Sistema de Desenvolvimento de Sistemas.</p>
        <p style="font-size: 0.8rem; margin-top: 4px; color: var(--text-dim);">Tecnologias: PHP + MySQL + HTML5 + CSS3 + Leaflet Maps</p>
      </div>
      <div>
        <a href="index.php" style="color: var(--text-muted); margin-right: 15px;">Início</a>
        <a href="listar_paises.php" style="color: var(--text-muted); margin-right: 15px;">Países Cadastrados</a>
        <a href="cadastrar_pais.php" class="color: var(--text-muted);">Cadastrar País</a>
      </div>
    </div>
  </footer>

  <!-- Leaflet JS (Mapas Interativos) -->
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
</body>
</html>
