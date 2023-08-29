<?php 

require_once"conexao.php";

?>

<html>   

    <body>  
    <?php
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $nome = $_POST["nome"];
            $email = $_POST["email"];
            $senha = md5($_POST["senha"]);
            $endereco = $_POST["endereco"];
            $telefone = $_POST["telefone"];
        
            try {
                // Verifica se o email já está cadastrado
                $query_verifica_email = "SELECT COUNT(*) FROM cadastro_usuario WHERE u_email = :email";
                $stmt_verifica_email = $pdo->prepare($query_verifica_email);
                $stmt_verifica_email->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt_verifica_email->execute();
                $email_exists = $stmt_verifica_email->fetchColumn();
        
                if ($email_exists) {
                    echo "<script>alert('O email já está cadastrado!'); window.location = 'cadastrousuario.php';</script>";
                } else {
                    // Insere o novo usuário caso o email não exista
                    $query = "INSERT INTO cadastro_usuario (u_nomecompleto, u_email, u_senha, u_endereco, u_telefone) 
                              VALUES (:nome, :email, :senha, :endereco, :telefone)";
                    $stmt = $pdo->prepare($query);
                    $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
                    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                    $stmt->bindParam(':senha', $senha, PDO::PARAM_STR);
                    $stmt->bindParam(':endereco', $endereco, PDO::PARAM_STR);
                    $stmt->bindParam(':telefone', $telefone, PDO::PARAM_STR);
        
                    if ($stmt->execute()) {
                        echo "<script>alert('Usuário cadastrado com sucesso!'); window.location = 'usuario.php';</script>";
                    } else {
                        echo "Deu erro: " . $stmt->errorInfo()[2];
                    }
                }
            } catch (PDOException $e) {
                echo "Erro: " . $e->getMessage();
                die();
            }
        }    
    ?>
    </body>    
</html>