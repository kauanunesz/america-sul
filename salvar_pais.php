<?php
/**
 * Processamento de Cadastro: salvar_pais.php
 * Sistema: Países da América do Sul
 */

require_once 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recebe e sanitiza dados
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

    // Validação básica
    if (empty($nome) || empty($capital) || empty($idioma) || empty($moeda)) {
        header("Location: cadastrar_pais.php?erro=" . urlencode("Preencha todos os campos obrigatórios."));
        exit;
    }

    // Processamento do Upload da Bandeira
    $nomeBandeira = 'default.png';

    if (isset($_FILES['bandeira']) && $_FILES['bandeira']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['bandeira']['tmp_name'];
        $fileName    = $_FILES['bandeira']['name'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        $extensionsPermitidas = ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp'];

        if (in_array($fileExtension, $extensionsPermitidas)) {
            // Gera nome limpo do arquivo com base no nome do país e timestamp
            $nomeSanitizado = preg_replace('/[^a-zA-Z0-9_-]/', '', strtolower(str_replace(' ', '_', $nome)));
            $novoNomeArquivo = $nomeSanitizado . '_' . time() . '.' . $fileExtension;

            $diretorioUpload = __DIR__ . '/uploads/';

            // Cria a pasta uploads se não existir
            if (!is_dir($diretorioUpload)) {
                mkdir($diretorioUpload, 0755, true);
            }

            $destinoFinal = $diretorioUpload . $novoNomeArquivo;

            if (move_uploaded_file($fileTmpPath, $destinoFinal)) {
                $nomeBandeira = $novoNomeArquivo;
            } else {
                header("Location: cadastrar_pais.php?erro=" . urlencode("Falha ao mover a imagem para a pasta uploads."));
                exit;
            }
        } else {
            header("Location: cadastrar_pais.php?erro=" . urlencode("Formato de imagem não permitido. Use PNG, JPG, SVG ou WEBP."));
            exit;
        }
    } else {
        header("Location: cadastrar_pais.php?erro=" . urlencode("É necessário selecionar uma imagem para a bandeira."));
        exit;
    }

    // Inserção no Banco de Dados MySQL via PDO
    try {
        $sql = "INSERT INTO paises 
                (nome, capital, idioma, moeda, populacao, area, presidente, idh, pib, educacao, seguranca, saude, latitude, longitude, descricao, bandeira) 
                VALUES 
                (:nome, :capital, :idioma, :moeda, :populacao, :area, :presidente, :idh, :pib, :educacao, :seguranca, :saude, :latitude, :longitude, :descricao, :bandeira)";
        
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
            ':bandeira'   => $nomeBandeira
        ]);

        header("Location: listar_paises.php?msg=" . urlencode("País '{$nome}' cadastrado com sucesso!"));
        exit;

    } catch (PDOException $e) {
        header("Location: cadastrar_pais.php?erro=" . urlencode("Erro no banco de dados: " . $e->getMessage()));
        exit;
    }
} else {
    header("Location: listar_paises.php");
    exit;
}