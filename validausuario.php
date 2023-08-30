<?php
session_start();

require_once("conexao.php");

if (isset($_POST['u_email']) && isset($_POST['u_senha'])) {
    $usuario = $_POST['u_email'];
    $senha = $_POST['u_senha'];

    try {
        $query = "SELECT * FROM cadastro_usuario WHERE u_email = :usuario LIMIT 1";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':usuario', $usuario);
        $stmt->execute();

        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($resultado && password_verify($senha, $resultado['u_senha'])) {
            $_SESSION['usuarioId'] = $resultado['u_id'];
            $_SESSION['usuarioEmail'] = $resultado['u_email'];
            $_SESSION['usuarioNome'] = $resultado['u_nomecompleto'];
            $_SESSION['usuarioSenha'] = $resultado['u_senha'];
            $_SESSION['usuarioTelefone'] = $resultado['u_telefone'];
            $_SESSION['usuarioEndereco'] = $resultado['u_endereco'];

            header("Location: user.php");
            exit;
        } else {
            $_SESSION['loginErro'] = "Usuário ou senha Inválido";
            header("Location: usuario.php");
            exit;
        }
    } catch (PDOException $e) {
        $_SESSION['loginErro'] = "Erro ao realizar o login.";
        header("Location: usuario.php");
        exit;
    }
} else {
    $_SESSION['loginErro'] = "Usuário ou senha Inválido";
    header("Location: usuario.php");
    exit;
}
?>
