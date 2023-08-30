<?php 

require_once"conexao.php";

?>

<html>   
    <body>  
        <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $g_id = intval($_GET['g_id']);
                $nome = $_POST["nome"];
                $email = $_POST["email"];
                $nivel = $_POST["nivel"];
                $senha = $_POST["senha"]; // Senha nova ou existente

                // Verificar se o novo email já existe na tabela
                $query_verifica_email = "SELECT COUNT(*) FROM cadastro_gerenciador WHERE g_email = :email AND g_id <> :g_id";
                $stmt_verifica_email = $pdo->prepare($query_verifica_email);
                $stmt_verifica_email->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt_verifica_email->bindParam(':g_id', $g_id, PDO::PARAM_INT);
                $stmt_verifica_email->execute();
                $email_exists = $stmt_verifica_email->fetchColumn();

                if ($email_exists) {
                    echo "<script>alert('O email já está cadastrado!'); location.href='gerenciamento.php';</script>";
                } else {
                    try {
                        // Verificar se uma nova senha foi fornecida
                        if (!empty($senha)) {
                            $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
                            $query = "UPDATE cadastro_gerenciador SET g_email = :email, g_senha = :senha, g_nivel = :nivel, g_nome = :nome WHERE g_id = :g_id";
                        } else {
                            $query = "UPDATE cadastro_gerenciador SET g_email = :email, g_nivel = :nivel, g_nome = :nome WHERE g_id = :g_id";
                        }

                        $stmt = $pdo->prepare($query);
                        $stmt->bindParam(':email', $email);
                        if (!empty($senha)) {
                            $stmt->bindParam(':senha', $senha_hash);
                        }
                        $stmt->bindParam(':nivel', $nivel);
                        $stmt->bindParam(':nome', $nome);
                        $stmt->bindParam(':g_id', $g_id);
                        $stmt->execute();

                        echo "<script> location.href='gerenciamento.php';</script>";
                    } catch (PDOException $e) {
                        echo "<script> alert('Não foi possível editar o usuário'); location.href='gerenciamento.php';</script>";
                    }
                }
            }
        ?>
    </body>    
</html>