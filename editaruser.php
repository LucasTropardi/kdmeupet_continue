<?php 

require_once"conexao.php";

?>

<html>   
    <body>  
    <?php
        $u_id = intval($_GET['u_id']);

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $nome = $_POST["nome"];
            $email = $_POST["email"];
            $endereco = $_POST["endereco"];
            $telefone = $_POST["telefone"];

            $query_verifica_email = "SELECT COUNT(*) FROM cadastro_usuario WHERE u_email = :email AND u_id != :u_id";
            $stmt_verifica_email = $pdo->prepare($query_verifica_email);
            $stmt_verifica_email->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt_verifica_email->bindParam(':u_id', $u_id, PDO::PARAM_INT);
            $stmt_verifica_email->execute();
            $email_exists = $stmt_verifica_email->fetchColumn();

            if ($email_exists) {
                echo "<script>alert('O email já está cadastrado!'); window.location = 'usereditar.php?u_id=$u_id';</script>";
            } else {
                $query = "SELECT * FROM `cadastro_usuario` WHERE `u_id` = :u_id LIMIT 1";
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(':u_id', $u_id, PDO::PARAM_INT);
                $stmt->execute();
                $usuario_atual = $stmt->fetch(PDO::FETCH_ASSOC);

                $senha = empty($_POST["senha"]) ? $usuario_atual["u_senha"] : $_POST["senha"]; 

                try {
                    // Verificar se uma nova senha foi fornecida
                    if (!empty($_POST["senha"])) {
                        $senha_hash = password_hash($_POST["senha"], PASSWORD_DEFAULT);
                        $query = "UPDATE cadastro_usuario SET u_email = :email, u_nomecompleto = :nome, u_senha = :senha,
                        u_endereco = :endereco, u_telefone = :telefone WHERE u_id = :u_id";
                    } else {
                        $query = "UPDATE cadastro_usuario SET u_email = :email, u_nomecompleto = :nome,
                        u_endereco = :endereco, u_telefone = :telefone WHERE u_id = :u_id";
                    }

                    $stmt = $pdo->prepare($query);
                    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                    $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
                    if (!empty($_POST["senha"])) {
                        $stmt->bindParam(':senha', $senha_hash);
                    }
                    $stmt->bindParam(':endereco', $endereco, PDO::PARAM_STR);
                    $stmt->bindParam(':telefone', $telefone, PDO::PARAM_STR);
                    $stmt->bindParam(':u_id', $u_id, PDO::PARAM_INT);
                    $sql_query = $stmt->execute();
                } catch (PDOException $e) {
                    echo "Erro: " . $e->getMessage();
                    die();
                }

                if ($sql_query) {
                    echo "<script> location.href='sairuser.php';</script>";
                } else {
                    echo "<script> alert('Não foi possível editar o usuário'); location.href='sairuser.php';</script>";
                }
            }
        }
    ?>
    </body>    
</html>