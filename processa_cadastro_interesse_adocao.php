<?php

  if (!isset($_SESSION)) session_start();
  date_default_timezone_set('America/Sao_Paulo');

  include_once"conexao.php";

  if (!isset($_SESSION['usuarioId'])) {
    session_destroy();    
    header("Location: usuario.php"); exit;
  }

  $animal = $_POST['i_adocao'];
  $usuario = $_SESSION['usuarioId'];
  $msg = $_POST['msg'];

  // VERIFICA SE JA EXISTE REGISTRO (ANIMAL, USUARIO)
  $query = "SELECT * FROM  `cadastro_adocao_interesse` WHERE `i_adocao` = $animal AND `i_usuario` = $usuario LIMIT 1";
  $sql = $mysqli->query($query) or die($mysqli->error);
  $result = $sql->fetch_array(MYSQLI_ASSOC);

  if ($result) {
    $_SESSION['alert_type'] = 'danger';
    $_SESSION['alert_msg'] = 'Você já demonstrou interesse por este animal.';
    header('Location: adocao.php#alert_msg');exit;
  }

  // INSERE REGISTRO NO BANCO DE DADOS
  $query = "INSERT INTO `cadastro_adocao_interesse` (`i_adocao`, `i_usuario`, `i_mensagem`) VALUES ($animal , $usuario , '$msg')";
  $insert = $mysqli -> query($query);

  if ($insert){
    $_SESSION['alert_type'] = 'success';
    $_SESSION['alert_msg'] = 'Interesse registrado com sucesso!';
  } else {
    $_SESSION['alert_type'] = 'danger';
    $_SESSION['alert_msg'] = 'Erro ao inserir registro!';
  }

header('Location: adocao.php#alert_msg');
