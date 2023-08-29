<?php

if (!isset($_SESSION)) session_start();
date_default_timezone_set('America/Sao_Paulo');

include_once "conexao.php";

if (!isset($_SESSION['usuarioId'])) {
    session_destroy();
    header("Location: index.php");
    exit;
}

if ($_FILES['foto']['name'] != "") {
    $anexo = pathinfo($_FILES['foto']['name']);
    $extensao = strtolower($anexo['extension']);

    $ext_validas = array("jpeg", "jpg", "png");
    if (!in_array($extensao, $ext_validas)) {
        $_SESSION["cadastro_animais"] = -3;
        header('Location: cadastro_animais.php');
        exit;
    }

    $novo_nome = md5(time()) . "." . $extensao;
    $diretorio = "upload/";
}

$nome = $_POST['nome'];
$foto = isset($novo_nome) ? $novo_nome : null;
$descricao = $_POST['descricao'];
$usuario = $_SESSION['usuarioId'];
$raca = $_POST['raca'];
$tamanho = $_POST['tamanho'];
$cor = $_POST['cor'];
$situacao = $_POST['situacao'];
$data = date('Y-m-d H:i:s');
$finalizado = 0;
$contato = $_POST['contato'] ?? null;
$latitude = $_POST['latitude'] ?? null;
$longitude = $_POST['longitude'] ?? null;

if ($_FILES['foto']['name'] != "") {
    if (!move_uploaded_file($_FILES['foto']['tmp_name'], $diretorio . $novo_nome)) {
        $_SESSION['cadastro_animais'] = -2;
        header('Location: cadastro_animais.php');
        exit;
    }
}

try {
    $stmt = $pdo->prepare("INSERT INTO `cadastro_animal` (`c_nomeanimal`, `c_foto`, `c_descricao`, `c_usuario`, `c_raca`, `c_tamanho`, `c_data`, 
    `c_finalizado`, `id_cor`, `c_situacao`, `c_contato`, `c_latitude`, `c_longitude`) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bindParam(1, $nome);
    $stmt->bindParam(2, $foto);
    $stmt->bindParam(3, $descricao);
    $stmt->bindParam(4, $usuario);
    $stmt->bindParam(5, $raca);
    $stmt->bindParam(6, $tamanho);
    $stmt->bindParam(7, $data);
    $stmt->bindParam(8, $finalizado);
    $stmt->bindParam(9, $cor);
    $stmt->bindParam(10, $situacao);
    $stmt->bindParam(11, $contato);
    $stmt->bindParam(12, $latitude);
    $stmt->bindParam(13, $longitude);

    if ($stmt->execute()) {
        $_SESSION['cadastro_animais'] = 1;
    } else {
        $_SESSION['cadastro_animais'] = -1;
        $_SESSION['msg'] = 'Erro na inserção: ' . implode(' ', $stmt->errorInfo());
        unlink($diretorio . $novo_nome);
    }
} catch (PDOException $e) {
    $_SESSION['cadastro_animais'] = -1;
    $_SESSION['msg'] = 'Erro: ' . $e->getMessage();
}

header('Location: cadastro_animais.php');
?>
