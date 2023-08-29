<?php
    session_start(); 
       
    require_once("conexao.php");

    if((isset($_POST['g_email'])) && (isset($_POST['g_senha']))){
        $usuario = $_POST['g_email']; 
        $senha = $_POST['g_senha'];
        $senha = md5($senha);
            
        try {
            $query = "SELECT * FROM cadastro_gerenciador WHERE g_email = :usuario AND g_senha = :senha LIMIT 1";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':usuario', $usuario);
            $stmt->bindParam(':senha', $senha);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($resultado !== false) {
                $_SESSION['gerenciadorId'] = $resultado['g_id'];
                $_SESSION['gerenciadorNome'] = $resultado['g_nome'];
                $_SESSION['gerenciadorEmail'] = $resultado['g_email'];
                header("Location: gerenciamento.php");
            } else {
                $_SESSION['loginErro'] = "Usuário ou senha inválidos.";
                header("Location: admin.php");
            }
        } catch (PDOException $e) {
            $_SESSION['loginErro'] = "Erro ao realizar o login.";
            header("Location: admin.php");
        }
    } else {
        $_SESSION['loginErro'] = "Usuário ou senha inválidos.";
        header("Location: admin.php");
    }
    
?>