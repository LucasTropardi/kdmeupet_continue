<?php
    if (!isset($_SESSION)) session_start();
    date_default_timezone_set('America/Sao_Paulo');

    if (!isset($_SESSION['gerenciadorId'])) {
        session_destroy();
        header("Location: index.php");
        exit;
    }

    include_once "conexao.php";

    // verifica se ID passado é válido
    if (!isset($_GET['id']) || $_GET['id'] == null || $_GET['id'] <= 0) {
        $_SESSION['msgContent'] = '<div class="alert alert-danger" role="alert">
        Parceria inválida ou não informada!</div>';
        header("Location: c_parcerias.php");
        exit;
    }

    $id = $_GET['id'];

    // verifica se parceria existe
    $query = "SELECT * FROM `contacts_msg` WHERE `id` = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $parceria = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$parceria) {
        $_SESSION['msgContent'] = '<div class="alert alert-danger" role="alert">
        Parceria não encontrada!</div>';
        header("Location: c_parcerias.php");
        exit;
    }

    // exclui parceria
    $query = "DELETE FROM `contacts_msg` WHERE `id` = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $parceria['id'], PDO::PARAM_INT);
    $delete = $stmt->execute();

    if ($delete) {
        $_SESSION['msgContent'] = '<div class="alert alert-success" role="alert">
        Parceria excluída com sucesso!</div>';
        unlink('upload/parcerias/' . $parceria['imagem']);
    } else {
        $msg_erro = 'Query: <code>' . $query . '</code><br>Erro: <code>' . implode(" - ", $stmt->errorInfo()) . '</code>';

        $_SESSION['msgContent'] = '<div class="alert alert-danger" role="alert">
        Ocorreu um erro ao excluir a Parceria. Por favor, tente novamente!<br>' .
        $msg_erro . '</div>';
    }
    header("Location: c_parcerias.php");
    exit;
?>
