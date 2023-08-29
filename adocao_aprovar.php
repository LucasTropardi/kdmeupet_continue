<?php

if (!isset($_SESSION)) session_start();
date_default_timezone_set('America/Sao_Paulo');

if (!isset($_SESSION['gerenciadorId'])) {
    session_destroy();
    header("Location: admin.php");
    exit;
}

require_once "conexao.php";

if (!isset($_GET['p_id']) || $_GET['p_id'] == null || $_GET['p_id'] <= 0) {
    $_SESSION['msgContent'] = '<div class="alert alert-danger" role="alert">
    Adoção inválida ou não informada!</div>';
    header("Location: ../adminadocoes.php");
    exit;
}

$p_id = $_GET['p_id'];

try {
    $query = "SELECT * FROM cadastro_adocao WHERE p_id = :p_id AND p_status = 0";
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':p_id', $p_id);
    $stmt->execute();
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
    die();
}

if ($stmt->rowCount() == 0) {
    $_SESSION['msgContent'] = '<div class="alert alert-danger" role="alert">
    Adoção não encontrada ou já está aprovada!</div>';
    header("Location: ../adminadocoes.php");
    exit;
}

$adocao = $stmt->fetch(PDO::FETCH_ASSOC);

try {
    $updateQuery = "UPDATE cadastro_adocao SET p_status = 1 WHERE p_id = :p_id";
    $updateStmt = $pdo->prepare($updateQuery);
    $updateStmt->bindValue(':p_id', $adocao['p_id']);
    $updateResult = $updateStmt->execute();
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
    die();
}

if ($updateResult) {
    $_SESSION['msgContent'] = '<div class="alert alert-success" role="alert">
    Adoção aprovada com sucesso!</div>';
} else {
    $msg_erro = 'Query: <code>' . $updateQuery . '</code><br>Erro: <code>' . $pdo->errorInfo()[2] . '</code>';

    $_SESSION['msgContent'] = '<div class="alert alert-danger" role="alert">
    Ocorreu um erro ao aprovar a adoção. Por favor, tente novamente!<br>' .
    $msg_erro . '</div>';
}

header("Location: ../adminadocoes.php");
exit;
