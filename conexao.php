<?php
/**
 * Conexão com o Banco de Dados MySQL via PDO
 * Sistema: Países da América do Sul
 */

$host = 'localhost';
$dbname = 'america_sul';
$username = 'root';
$password = ''; // Padrão do XAMPP é sem senha

try {
    $pdo = new PDO("mysql:host={$host};dbname={$dbname};charset=utf8mb4", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
    ]);
} catch (PDOException $e) {
    // Exibe mensagem didática de erro caso o MySQL não esteja rodando no XAMPP ou o BD não exista
    die("
        <div style='font-family: Arial, sans-serif; background: #fee2e2; color: #991b1b; padding: 25px; border-radius: 12px; max-width: 650px; margin: 50px auto; border: 1px solid #f87171; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);'>
            <h2 style='margin-top:0;'>⚠️ Erro de Conexão com o Banco de Dados</h2>
            <p><strong>Não foi possível conectar ao banco 'america_sul'.</strong></p>
            <hr style='border:0; border-top:1px solid #fca5a5;'>
            <p><strong>Passos para resolver no XAMPP:</strong></p>
            <ol style='line-height:1.6;'>
                <li>Abra o <strong>XAMPP Control Panel</strong> e inicie os módulos <strong>Apache</strong> e <strong>MySQL</strong>.</li>
                <li>Acesse o <a href='http://localhost/phpmyadmin' target='_blank' style='color:#7f1d1d;'>phpMyAdmin</a>.</li>
                <li>Crie o banco de dados chamado <code>america_sul</code> ou importe o arquivo <code>banco/america_sul.sql</code>.</li>
            </ol>
            <p style='font-size: 13px; color: #7f1d1d; background: #fecaca; padding: 10px; border-radius: 6px;'>
                <strong>Detalhe técnico do erro:</strong> " . htmlspecialchars($e->getMessage()) . "
            </p>
        </div>
    ");
}