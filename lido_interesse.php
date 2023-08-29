<?php
    if (!isset($_SESSION)) session_start();
    date_default_timezone_set('America/Sao_Paulo');

    if (!isset($_SESSION['gerenciadorId'])) {
        session_destroy();      
        header("Location: admin.php"); exit;
    }

    include_once "conexao.php";

    if (!isset($_GET['i_id']) || $_GET['i_id'] == null || $_GET['i_id'] <= 0) {
        $_SESSION['msgContent'] = '<div class="alert alert-danger" role="alert">
        Adoção inválida ou não informada!</div>';
        header("Location: ../c_adocao_interesses.php"); exit;
    }

    $i_id = $_GET['i_id'];
    
    $query = "SELECT * FROM `cadastro_adocao_interesse` WHERE `i_id` = :i_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':i_id', $i_id, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() == 0) {
        $_SESSION['msgContent'] = '<div class="alert alert-danger" role="alert">
        Interesse verificado!</div>';
        header("Location: ../c_adocao_interesses.php"); exit;    
    } 

    $lido = $stmt->fetch(PDO::FETCH_ASSOC);

    $query = "UPDATE `cadastro_adocao_interesse` SET `i_lida` = 1 WHERE `i_id` = :i_id";
    $updateStmt = $pdo->prepare($query);
    $updateStmt->bindParam(':i_id', $lido['i_id'], PDO::PARAM_INT);
    $updateResult = $updateStmt->execute();

    if ($updateResult) {
        $_SESSION['msgContent'] = '<div class="alert alert-success" role="alert">
        Interesse verificado!</div>';
    } else {
        $msg_erro = 'Query: <code>' . $query . '</code><br>Erro: <code>' . $pdo->errorInfo()[2] . '</code>';

        $_SESSION['msgContent'] = '<div class="alert alert-danger" role="alert">
        Ocorreu um erro. Por favor, tente novamente!<br>' .
        $msg_erro . '</div>';
    }
    header("Location: ../adminadocoes.php"); exit;
?>
