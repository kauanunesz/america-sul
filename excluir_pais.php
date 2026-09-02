<?php
/**
 * Processamento de Exclusão: excluir_pais.php
 * Sistema: Países da América do Sul
 */

require_once 'conexao.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id > 0) {
    try {
        // Buscar o país para obter o nome da bandeira antes de excluir
        $stmtSelect = $pdo->prepare("SELECT nome, bandeira FROM paises WHERE id = :id");
        $stmtSelect->execute(['id' => $id]);
        $pais = $stmtSelect->fetch();

        if ($pais) {
            // Deletar o registro no banco
            $stmtDelete = $pdo->prepare("DELETE FROM paises WHERE id = :id");
            $stmtDelete->execute(['id' => $id]);

            // Remover o arquivo da bandeira se for um upload personalizado
            $caminhoArquivo = __DIR__ . '/uploads/' . $pais['bandeira'];
            if (!empty($pais['bandeira']) && file_exists($caminhoArquivo) && strpos($pais['bandeira'], 'default') === false) {
                @unlink($caminhoArquivo);
            }

            header("Location: listar_paises.php?msg=" . urlencode("País '{$pais['nome']}' excluído com sucesso!"));
            exit;
        } else {
            header("Location: listar_paises.php?erro=" . urlencode("País não encontrado para exclusão."));
            exit;
        }
    } catch (PDOException $e) {
        header("Location: listar_paises.php?erro=" . urlencode("Erro ao excluir registro: " . $e->getMessage()));
        exit;
    }
} else {
    header("Location: listar_paises.php");
    exit;
}