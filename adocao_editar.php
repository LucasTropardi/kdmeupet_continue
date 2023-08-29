<?php
/*
  if (!isset($_SESSION['usuarioId'])) {
       session_destroy();      
       header("Location: index.php");
       exit;
  }
*/
if (!isset($_SESSION)) session_start();
date_default_timezone_set('America/Sao_Paulo');

include_once "conexao.php";

// verifica se ID passado é válido
if (!isset($_GET['p_id']) || empty($_GET['p_id']) || !is_numeric($_GET['p_id']) || $_GET['p_id'] <= 0) {
    $_SESSION['msgContent'] = '<div class="alert alert-danger" role="alert">
    Pet inválida ou não informada!</div>';
    header("Location: ../adminadocoes.php");
    exit;
}

$p_id = intval($_GET['p_id']);

// verifica se pet existe
$query = "SELECT * FROM cadastro_adocao WHERE p_id = :p_id";
$stmt = $pdo->prepare($query);
$stmt->bindValue(':p_id', $p_id, PDO::PARAM_INT);
$stmt->execute();

if ($stmt->rowCount() == 0) {
    $_SESSION['msgContent'] = '<div class="alert alert-danger" role="alert">
    Pet não encontrada!</div>';
    header("Location: ../adminadocoes.php");
    exit;
}

$adocao = $stmt->fetch(PDO::FETCH_ASSOC);

// verifica se foi enviado imagem
if (!empty($_FILES['foto']['name'])) {
    $anexo = pathinfo($_FILES['foto']['name']);
    $extensao = strtolower($anexo['extension']);

    $ext_validas = array("jpeg", "jpg", "png");
    if (!in_array($extensao, $ext_validas)) {
        $_SESSION["msgContent"] = '<div class="alert alert-danger" role="alert">
        Formato de Arquivo não suportado. Por favor, tente novamente!
        '. $extensao . '</div>';
        header('Location: index.php');
        exit;
    }

    $novo_nome = md5(time()) . "." . $extensao;
    $diretorio = "upload/";

    if (!move_uploaded_file($_FILES['foto']['tmp_name'], $diretorio.$novo_nome)) {
        $_SESSION['msgContent'] = '<div class="alert alert-danger" role="alert">
        Erro ao Salvar Arquivo. Por favor, tente novamente!
        </div>';
        header('Location: index.php');
        exit;
    }

    $imagem_old = $adocao['foto'];
    $imagem = $novo_nome;

    $query = "UPDATE cadastro_adocao SET p_foto = :imagem WHERE p_id = :p_id";
    $update = $pdo->prepare($query);
    $update->bindValue(':imagem', $imagem);
    $update->bindValue(':p_id', $adocao['p_id'], PDO::PARAM_INT);
    if (!$update->execute()) {
        $msg_erro = 'Query: <code>' . $query . '</code><br>Erro: <code>' . $pdo->errorInfo()[2] . '</code>';

        $_SESSION['msgContent'] = '<div class="alert alert-danger" role="alert">
        Ocorreu um erro ao atualizar a foto. Por favor, tente novamente!<br>' .
        $msg_erro . '</div>';
        unlink($diretorio.$novo_nome);
        header('Location: adminadocoes.php');
        exit;
    } else {
        unlink($diretorio.$imagem_old);
    }
}

$nome = $_POST['nome'];
$idade = $_POST['idade'];
$descricao = $_POST['descricao'];
$status = $_POST['status'];

$query = "UPDATE cadastro_adocao SET p_nome = :nome, p_idade = :idade, p_descricao = :descricao, p_status = :status WHERE p_id = :p_id";
$update = $pdo->prepare($query);
$update->bindValue(':nome', $nome);
$update->bindValue(':idade', $idade);
$update->bindValue(':descricao', $descricao);
$update->bindValue(':status', $status);
$update->bindValue(':p_id', $adocao['p_id'], PDO::PARAM_INT);
if ($update->execute()) {
    $_SESSION['msgContent'] = '<div class="alert alert-success" role="alert">
    Pet atualizado com Sucesso!
    </div>';
} else {
    $msg_erro = 'Query: <code>' . $query . '</code><br>Erro: <code>' . $pdo->errorInfo()[2] . '</code>';

    $_SESSION['msgContent'] = '<div class="alert alert-danger" role="alert">
    Ocorreu um erro ao atualizar. Por favor, tente novamente!<br>' .
    $msg_erro . '</div>';
    unlink($diretorio.$novo_nome);
}

header('Location: adminadocoes.php');
exit;