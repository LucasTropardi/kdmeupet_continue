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

  include_once"conexao.php";

  // verifica se ID passado é válido
  if (!isset($_GET['p_id']) || $_GET['p_id'] == null || $_GET['p_id'] <= 0) {
    $_SESSION['msgContent'] = '<div class="alert alert-danger" role="alert">
    Pet inválida ou não informada!</div>';
    header("Location: ../adminadocoes.php"); exit;
  }

  $p_id = $_GET['p_id'];

  // verifica se parceria existe
  $query = "SELECT * FROM `cadastro_adocao` WHERE `p_id` = $p_id";
  $select = $mysqli -> query($query);

  if (mysqli_num_rows($select) == 0) {
    $_SESSION['msgContent'] = '<div class="alert alert-danger" role="alert">
    Pet não encontrada!</div>';
    header("Location: ../adminadocoes.php"); exit;    
  } 

  $adocao = $select->fetch_array();

  //verifica se foi enviado imagem logo
  if ($_FILES['foto']['name'] != ""){
     $anexo = pathinfo($_FILES['foto']['name']);
     $extensao = strtolower($anexo['extension']);
 
     $ext_validas = array("jpeg", "jpg", "png");
     if (!in_array($extensao, $ext_validas)) { //se extensao nao for valida retorna
         $_SESSION["msgContent"] = '<div class="alert alert-danger" role="alert">
         Formato de Arquivo não suportado. Por favor, tente novamente!
         '. $extensao . '</div>';   // conteudo da mensagem
         header('Location: index.php'); exit;
     }
 
     $novo_nome = md5(time()) . "." . $extensao;
     $diretorio = "upload/";
   }

    if ($_FILES['foto']['name'] != ""){
      if (!move_uploaded_file($_FILES['foto']['tmp_name'], $diretorio.$novo_nome)) {
        $_SESSION['msgContent'] = '<div class="alert alert-danger" role="alert">
        Erro ao Salvar Arquivo. Por favor, tente novamente!
        </div>'; // conteudo da mensagem
        header('Location: index.php'); exit;
      }

      $imagem_old = $adocao['foto'];
      $imagem = $novo_nome;

      $query = "UPDATE `cadastro_adocao` SET `p_foto` = '$imagem' WHERE `p_id` = " .$adocao['p_id'];
      $update = $mysqli -> query($query);

      if (!$update) {
        $msg_erro = 'Query: <code>' . $query . '</code><br>Erro: <code>' . $mysqli->error . '</code>';

        $_SESSION['msgContent'] = '<div class="alert alert-danger" role="alert">
        Ocorreu um erro ao atualizar a foto. Por favor, tente novamente!<br>' .
        $msg_erro . '</div>'; // conteudo da mensagem
        
        unlink($diretorio.$novo_nome);
        header('Location: adminadocoes.php'); exit;
      } else {
        unlink($diretorio.$imagem_old);
      }
    }

    $nome = $_POST['nome'];
    $idade = $_POST['idade'];
    $descricao = $_POST['descricao'];
    $status = $_POST['status'];

    $query = "UPDATE `cadastro_adocao` SET `p_nome` = '$nome', `p_idade` = '$idade', `p_descricao` = '$descricao', `p_status` = '$status' WHERE `p_id` = " . $adocao['p_id'];
    $update = $mysqli -> query($query);

    if ($update){
      $_SESSION['msgContent'] = '<div class="alert alert-success" role="alert">
      Pet atualizado com Sucesso!
      </div>'; // conteudo da mensagem
    } else {
      $msg_erro = 'Query: <code>' . $query . '</code><br>Erro: <code>' . $mysqli->error . '</code>';

      $_SESSION['msgContent'] = '<div class="alert alert-danger" role="alert">
      Ocorreu um erro ao atualizar. Por favor, tente novamente!<br>' .
      $msg_erro . '</div>'; // conteudo da mensagem
      
      unlink($diretorio.$novo_nome);
    }

    header('Location: adminadocoes.php'); exit;