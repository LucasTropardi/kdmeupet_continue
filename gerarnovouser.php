<?php 

include_once"conexao.php";

?>

<html>   

    <body>  
    <?php
        $nome = $_POST["nome"];
        $email = $_POST["email"];
        $senha = md5($_POST["senha"]);
        $endereco = $_POST["endereco"];
        $telefone = $_POST["telefone"];

        try {
            $query = "INSERT INTO cadastro_usuario (u_nomecompleto, u_email, u_senha, u_endereco, u_telefone) 
                    VALUES (:nome, :email, :senha, :endereco, :telefone)";

            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':senha', $senha, PDO::PARAM_STR);
            $stmt->bindParam(':endereco', $endereco, PDO::PARAM_STR);
            $stmt->bindParam(':telefone', $telefone, PDO::PARAM_STR);
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
            die();
        }

        if ($stmt->execute()) {
            echo "<script>alert('Usuário cadastrado com sucesso!'); window.location = 'usuario.php';</script>";
        } else {
            echo "Deu erro: " . $stmt->errorInfo()[2];
        }
    ?>
    </body>    
</html>