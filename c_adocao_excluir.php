<?php

if (!isset($_SESSION)) session_start();
date_default_timezone_set('America/Sao_Paulo');

if (!isset($_SESSION['gerenciadorId'])) {
     session_destroy();      
     header("Location: index.php");
     exit;
}

include_once"conexao.php";

// verifica se ID passado é válido
if (!isset($_GET['p_id']) || $_GET['p_id'] == null || $_GET['p_id'] <= 0) {
    $_SESSION['msgContent'] = '<div class="alert alert-danger" role="alert">
    Não é possível excluir!</div>';
    header("Location: ../adminadocoes.php"); exit;
}

$p_id = $_GET['p_id'];

// verifica se existe
$query = "SELECT * FROM `cadastro_adocao` WHERE `p_id` = $p_id";
$select = $mysqli -> query($query);

if (mysqli_num_rows($select) == 0) {
    $_SESSION['msgContent'] = '<div class="alert alert-danger" role="alert">
    Cadastro não encontrado!</div>';
    header("Location: ../adminadocoes.php"); exit;    
} 

$adocao = $select->fetch_array();

// exclui
$query = "DELETE FROM `cadastro_adocao` WHERE `p_id` = " . $adocao['p_id'];
$delete = $mysqli -> query($query);

if ($delete){
    $_SESSION['msgContent'] = '<div class="alert alert-success" role="alert">
    Cadastro excluído com sucesso!</div>';
    unlink('upload/' . $adocao['imagem']);
} else {
    $msg_erro = 'Query: <code>' . $query . '</code><br>Erro: <code>' . $mysqli->error . '</code>';

    $_SESSION['msgContent'] = '<div class="alert alert-danger" role="alert">
    Ocorreu um erro excluir. Por favor, tente novamente!<br>' .
    $msg_erro . '</div>';
}
header("Location: ../adminadocoes.php"); exit; 

