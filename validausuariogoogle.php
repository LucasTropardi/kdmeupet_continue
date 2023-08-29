<?php
  if (!isset($_SESSION)) session_start();
  date_default_timezone_set('America/Sao_Paulo');

  // autoload
  require_once './google_api/vendor/autoload.php';
  use Google\Client as Google_Client;

  // verifica campos obrigatorios
  if (!isset($_POST['credential']) || !isset($_POST['g_csrf_token'])) {
      header('location: index.php');
      exit;
  }

  // cookie
  $cookie = $_COOKIE['g_csrf_token'] ?? '';

  // verifica valor do cookie e post csrf
  if ($_POST['g_csrf_token'] != $cookie) {
      header('location: index.php');
      exit;
  }

  // validacao token
  $CLIENT_ID = "580738356507-aippluacp00orvercqnlshsgo6fo2sok.apps.googleusercontent.com";
  $client = new Google_Client(['client_id' => $CLIENT_ID]);  // Specify the CLIENT_ID of the app that accesses the backend

  // valida dados do usuario
  $payload = $client->verifyIdToken($_POST['credential']);
  if (isset($payload['email'])) {
      $nome = $payload['name'];
      $email = $payload['email'];
      $sub = $payload['sub'];

      $senha = md5(time());

      // verificar se existe usuario com sub
      include_once("conexao.php");

      $query = "SELECT * FROM `cadastro_usuario` WHERE `id_google` = :sub LIMIT 1";
      $stmt = $pdo->prepare($query);
      $stmt->bindParam(':sub', $sub, PDO::PARAM_STR);
      $stmt->execute();
      $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

      // verifica se usuario google ja existe 
      if (!isset($resultado)) {
          $query = "SELECT * FROM `cadastro_usuario` WHERE `u_email` = :email LIMIT 1";
          $stmt = $pdo->prepare($query);
          $stmt->bindParam(':email', $email, PDO::PARAM_STR);
          $stmt->execute();
          $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

          // verifica se email foi utilizado
          if (isset($resultado)) {
              // atualizar cadastro com sub
              $query = "UPDATE `cadastro_usuario` SET `id_google` = :sub WHERE `u_email` = :email";
              $stmt = $pdo->prepare($query);
              $stmt->bindParam(':sub', $sub, PDO::PARAM_STR);
              $stmt->bindParam(':email', $email, PDO::PARAM_STR);
              $updateResult = $stmt->execute();

              // se erro
              if (!$updateResult) {
                  $msg_erro = 'Query: <code>' . $query . '</code><br>Erro: <code>' . implode(' ', $stmt->errorInfo()) . '</code>';

                  $_SESSION['msgContent'] = '<div class="alert alert-danger" role="alert">
                  Erro ao fazer Login<br>' .
                  $msg_erro . '</div>'; // conteudo da mensagem 
                  header("Location: usuario.php");
                  exit;
              } else {
                  $query = "SELECT * FROM `cadastro_usuario` WHERE `id_google` = :sub LIMIT 1";
                  $stmt = $pdo->prepare($query);
                  $stmt->bindParam(':sub', $sub, PDO::PARAM_STR);
                  $stmt->execute();
                  $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
              }
          } else {
              // criar usuario
              $query = "INSERT INTO `cadastro_usuario`(`u_email`, `u_nomecompleto`, `u_senha`, `id_google`) VALUES (:email, :nome, :senha, :sub)";
              $stmt = $pdo->prepare($query);
              $stmt->bindParam(':email', $email, PDO::PARAM_STR);
              $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
              $stmt->bindParam(':senha', $senha, PDO::PARAM_STR);
              $stmt->bindParam(':sub', $sub, PDO::PARAM_STR);
              $insertResult = $stmt->execute();

              // se erro
              if (!$insertResult) {
                  $msg_erro = 'Query: <code>' . $query . '</code><br>Erro: <code>' . implode(' ', $stmt->errorInfo()) . '</code>';

                  $_SESSION['msgContent'] = '<div class="alert alert-danger" role="alert">
                  Erro ao fazer Login<br>' .
                  $msg_erro . '</div>'; // conteudo da mensagem
                  header("Location: usuario.php");
                  exit;
              } else {
                  $query = "SELECT * FROM `cadastro_usuario` WHERE `id_google` = :sub LIMIT 1";
                  $stmt = $pdo->prepare($query);
                  $stmt->bindParam(':sub', $sub, PDO::PARAM_STR);
                  $stmt->execute();
                  $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
              }
          }
      }

      $_SESSION['usuarioId'] = $resultado['u_id'];
      $_SESSION['usuarioEmail'] = $resultado['u_email'];
      $_SESSION['usuarioNome'] = $resultado['u_nomecompleto'];
      $_SESSION['usuarioSenha'] = $resultado['u_senha'];

      header("Location: user.php");
      exit;
  } else {
      header("Location: index.php");
      exit;
  }
?>
