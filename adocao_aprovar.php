<?php

if (!isset($_SESSION)) session_start();
date_default_timezone_set('America/Sao_Paulo');

if (!isset($_SESSION['gerenciadorId'])) {
    session_destroy();      
    header("Location: admin.php"); exit;
}

include_once"conexao.php";

if (!isset($_GET['p_id']) || $_GET['p_id'] == null || $_GET['p_id'] <= 0) {
    $_SESSION['msgContent'] = '<div class="alert alert-danger" role="alert">
    Adoção inválida ou não informada!</div>';
    header("Location: ../adminadocoes.php"); exit;
}

$p_id = $_GET['p_id'];

$query = "SELECT * FROM `cadastro_adocao` WHERE `p_id` = $p_id and `p_status` = 0";
$select = $mysqli -> query($query);

if (mysqli_num_rows($select) == 0) {
    $_SESSION['msgContent'] = '<div class="alert alert-danger" role="alert">
    Adoção não encontrada ou já está aprovada!</div>';
    header("Location: ../adminadocoes.php"); exit;    
} 

$adocao = $select->fetch_array();

$query = "UPDATE `cadastro_adocao` SET `p_status` = 1 WHERE `p_id` = " . $adocao['p_id'];
$update = $mysqli -> query($query);

if ($update){
    $_SESSION['msgContent'] = '<div class="alert alert-success" role="alert">
    Adoção aprovada com sucesso!</div>';
} else {
    $msg_erro = 'Query: <code>' . $query . '</code><br>Erro: <code>' . $mysqli->error . '</code>';

    $_SESSION['msgContent'] = '<div class="alert alert-danger" role="alert">
    Ocorreu um erro aprovar a adoção. Por favor, tente novamente!<br>' .
    $msg_erro . '</div>';
}
header("Location: ../adminadocoes.php"); exit; 

