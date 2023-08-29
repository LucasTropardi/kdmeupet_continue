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
            $nivel = $_POST["nivel"];

            // Verificar se o email já existe na tabela
            $query_verifica_email = "SELECT COUNT(*) FROM cadastro_gerenciador WHERE g_email = :email";
            $stmt_verifica_email = $pdo->prepare($query_verifica_email);
            $stmt_verifica_email->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt_verifica_email->execute();
            $email_exists = $stmt_verifica_email->fetchColumn();

            if ($email_exists) {
                echo "<script>alert('O email já está cadastrado!'); window.location = 'gerenciamento.php';</script>";
            } else {
                try {
                    $query = "INSERT INTO cadastro_gerenciador (g_email, g_senha, g_nivel, g_nome) VALUES (:email, :senha, :nivel, :nome)";
                    $stmt = $pdo->prepare($query);
                    $stmt->bindParam(':email', $email);
                    $stmt->bindParam(':senha', $senha);
                    $stmt->bindParam(':nivel', $nivel);
                    $stmt->bindParam(':nome', $nome);
                    $stmt->execute();

                    echo "<script>alert('Usuário cadastrado com sucesso!'); window.location = 'gerenciamento.php';</script>";
                } catch (PDOException $e) {
                    echo "Deu erro: " . $e->getMessage();
                }
            }
        }

    ?>
    
    </body>    

</html>