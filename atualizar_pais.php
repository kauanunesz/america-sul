<?php
/**
 * Processamento de Edição: atualizar_pais.php
 * Sistema: Países da América do Sul
 */

require_once 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id            = (int) ($_POST['id'] ?? 0);
    $bandeiraAtual = trim($_POST['bandeira_atual'] ?? 'default.png');
    
    $nome       = trim($_POST['nome'] ?? '');
    $capital    = trim($_POST['capital'] ?? '');
    $idioma     = trim($_POST['idioma'] ?? '');
    $moeda      = trim($_POST['moeda'] ?? '');
    $populacao  = trim($_POST['populacao'] ?? '');
    $area       = trim($_POST['area'] ?? '');
    $presidente = trim($_POST['presidente'] ?? '');
    $idh        = (float) ($_POST['idh'] ?? 0);
    $pib        = trim($_POST['pib'] ?? '');
    $educacao   = $_POST['educacao'] ?? 'Média';
    $seguranca  = $_POST['seguranca'] ?? 'Moderada';
    $saude      = $_POST['saude'] ?? 'Média';
    $latitude   = (float) ($_POST['latitude'] ?? 0);
    $longitude  = (float) ($_POST['longitude'] ?? 0);
    $descricao  = trim($_POST['descricao'] ?? '');

    if ($id <= 0 || empty($nome) || empty($capital)) {
        header("Location: listar_paises.php?erro=" . urlencode("Dados inválidos para atualização."));
        exit;
    }

    $nomeBandeira = $bandeiraAtual;

    // Se um novo arquivo de bandeira for enviado
    if (isset($_FILES['bandeira']) && $_FILES['bandeira']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath   = $_FILES['bandeira']['tmp_name'];
        $fileName      = $_FILES['bandeira']['name'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        $extensionsPermitidas = ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp'];

        if (in_array($fileExtension, $extensionsPermitidas)) {
            $nomeSanitizado  = preg_replace('/[^a-zA-Z0-9_-]/', '', strtolower(str_replace(' ', '_', $nome)));
            $novoNomeArquivo = $nomeSanitizado . '_' . time() . '.' . $fileExtension;

            $diretorioUpload = __DIR__ . '/uploads/';
            $destinoFinal    = $diretorioUpload . $novoNomeArquivo;

            if (move_uploaded_file($fileTmpPath, $destinoFinal)) {
                // Se a bandeira antiga não for a default e existir fisicamente, remove para economizar espaço
                $caminhoBandeiraAntiga = $diretorioUpload . $bandeiraAtual;
                if ($bandeiraAtual !== 'default.png' && file_exists($caminhoBandeiraAntiga)) {
                    @unlink($caminhoBandeiraAntiga);
                }

                $nomeBandeira = $novoNomeArquivo;
            }
        }
    }

    // Executa UPDATE no Banco de Dados
    try {
        $sql = "UPDATE paises SET 
                nome = :nome,
                capital = :capital,
                idioma = :idioma,
                moeda = :moeda,
                populacao = :populacao,
                area = :area,
                presidente = :presidente,
                idh = :idh,
                pib = :pib,
                educacao = :educacao,
                seguranca = :seguranca,
                saude = :saude,
                latitude = :latitude,
                longitude = :longitude,
                descricao = :descricao,
                bandeira = :bandeira
                WHERE id = :id";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':nome'       => $nome,
            ':capital'    => $capital,
            ':idioma'     => $idioma,
            ':moeda'      => $moeda,
            ':populacao'  => $populacao,
            ':area'       => $area,
            ':presidente' => $presidente,
            ':idh'        => $idh,
            ':pib'        => $pib,
            ':educacao'   => $educacao,
            ':seguranca'  => $seguranca,
            ':saude'      => $saude,
            ':latitude'   => $latitude,
            ':longitude'  => $longitude,
            ':descricao'  => $descricao,
            ':bandeira'   => $nomeBandeira,
            ':id'         => $id
        ]);

        header("Location: listar_paises.php?msg=" . urlencode("Dados do país '{$nome}' atualizados com sucesso!"));
        exit;

    } catch (PDOException $e) {
        header("Location: editar_pais.php?id={$id}&erro=" . urlencode("Erro ao atualizar: " . $e->getMessage()));
        exit;
    }
} else {
    header("Location: listar_paises.php");
    exit;
}