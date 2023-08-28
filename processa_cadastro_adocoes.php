<?php

  if (!isset($_SESSION)) session_start();
  date_default_timezone_set('America/Sao_Paulo');

  include_once"conexao.php";

  if (!isset($_SESSION['gerenciadorId'])) {
    session_destroy();      
    header("Location: admin.php"); exit;
  }

  if ($_FILES['foto']['name'] != ""){
    $anexo = pathinfo($_FILES['foto']['name']);
    $extensao = strtolower($anexo['extension']);

    $ext_validas = array("jpeg", "jpg", "png");
    if (!in_array($extensao, $ext_validas)) { //se extensao nao for valida retorna
        $_SESSION["cadastro_adocao"] = -3;   //a tela de cadastro animais com alerta erro
        header('Location: adminadocoes.php'); exit;    }

    $novo_nome = md5(time()) . "." . $extensao;
    $diretorio = "upload/";
  }

  $nome = $_POST['nome'];
  $foto = $novo_nome ?? Null;
  $descricao = $_POST['descricao'];
  $contato = $_POST['contato'] ?? Null;
  $idade = $_POST['idade'];
  $tipo = $_POST['tipo'];
  $raca = $_POST['raca'];
  $tamanho = $_POST['tamanho'];
  $cor = $_POST['cor'];
  $status = 0; 

  if ($_FILES['foto']['name'] != ""){
    if (!move_uploaded_file($_FILES['foto']['tmp_name'], $diretorio.$novo_nome)) {
      $_SESSION['cadastro_adocao'] = -2; //erro ao mover arquivo
      header('Location: adminadocoes.php'); exit;
    }
  }
  
  $query = "INSERT INTO `cadastro_adocao` (`p_nome`, `p_foto`, `p_descricao`, `p_contato`, `p_idade`, `p_tipo`, 
  `p_raca`, `p_tamanho`, `p_cor`, `p_status`) VALUES ('$nome' , '$foto' , '$descricao' , '$contato', '$idade', '$tipo', '$raca', 
  '$tamanho', '$cor', '$status')";
  $insert = $mysqli -> query($query);

  if ($insert){
      $_SESSION['cadastro_adocao'] = 1; //arquivo e registro banco executado com sucesso
  } else {
      $_SESSION['cadastro_adocao'] = -1; // erro ao inserir registro
      $_SESSION['msg'] = 'Query: <code>' . $query . '</code><br>Erro: <code>' . $mysqli->error . '</code>';
      unlink($diretorio.$novo_nome);
  }

header('Location: adminadocoes.php');
