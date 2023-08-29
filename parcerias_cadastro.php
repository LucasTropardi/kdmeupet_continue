<?php
  if (!isset($_SESSION)) session_start();
  date_default_timezone_set('America/Sao_Paulo');

  require_once "conexao.php";

  if ($_FILES['formFile']['name'] != "") {
      $anexo = pathinfo($_FILES['formFile']['name']);
      $extensao = strtolower($anexo['extension']);

      $ext_validas = array("jpeg", "jpg", "png");
      if (!in_array($extensao, $ext_validas)) { //se extensao nao for valida retorna
          $_SESSION["msgContent"] = '<div class="alert alert-danger" role="alert">
          Formato de Arquivo não suportado. Por favor, tente novamente!
          ' . $extensao . '</div>'; // conteudo da mensagem
          header('Location: index.php');
          exit;
      }

      $novo_nome = md5(time()) . "." . $extensao;
      $diretorio = "upload/parcerias/";
  }

  $nome = $_POST['nome'];
  $email = $_POST['email'];
  $telefone = $_POST['telefone'];
  $title = $_POST['title'];
  $msg = $_POST['msg'];
  $contato_organizacao = $_POST['contatoOrganizacao'];
  $imagem = isset($novo_nome) ? $novo_nome : null;

  if ($_FILES['formFile']['name'] != "") {
      if (!move_uploaded_file($_FILES['formFile']['tmp_name'], $diretorio.$novo_nome)) {
          $_SESSION['msgContent'] = '<div class="alert alert-danger" role="alert">
          Erro ao Salvar Arquivo. Por favor, tente novamente!
          </div>'; // conteudo da mensagem
          header('Location: index.php');
          exit;
      }
  }

  $query = "INSERT INTO `contacts_msg`(`nome`, `email`, `telefone`, `titulo`, `msg`, `contato_organizacao`, `imagem`) VALUES (:nome, :email, :telefone, :title, :msg, :contato_organizacao, :imagem)";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
  $stmt->bindParam(':email', $email, PDO::PARAM_STR);
  $stmt->bindParam(':telefone', $telefone, PDO::PARAM_STR);
  $stmt->bindParam(':title', $title, PDO::PARAM_STR);
  $stmt->bindParam(':msg', $msg, PDO::PARAM_STR);
  $stmt->bindParam(':contato_organizacao', $contato_organizacao, PDO::PARAM_STR);
  $stmt->bindParam(':imagem', $imagem, PDO::PARAM_STR);
  $insertResult = $stmt->execute();

  if ($insertResult) {
      $_SESSION['msgContent'] = '<div class="alert alert-success" role="alert">
      Informações enviadas com sucesso! Antes elas serão analizadas para então serem publicadas!
      </div>'; // conteudo da mensagem
  } else {
      $msg_erro = 'Query: <code>' . $query . '</code><br>Erro: <code>' . $pdo->errorInfo()[2] . '</code>';

      $_SESSION['msgContent'] = '<div class="alert alert-danger" role="alert">
      Ocorreu um erro ao cadastrar o animal. Por favor, tente novamente!<br>' .
      $msg_erro . '</div>'; // conteudo da mensagem
      
      unlink($diretorio.$novo_nome);
  }

  header('Location: index.php');
  exit;
?>
