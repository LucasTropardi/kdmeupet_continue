<?php 

include_once"conexao.php";

?>

<html>   

    <body>  
    <?php
        $u_id = intval($_GET['u_id']);

        $nome = $_POST["nome"];
        $email = $_POST["email"];
        $endereco = $_POST["endereco"];
        $telefone = $_POST["telefone"];

        $query = "SELECT * FROM `cadastro_usuario` WHERE `u_id` = :u_id LIMIT 1";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':u_id', $u_id, PDO::PARAM_INT);
        $stmt->execute();
        $usuario_atual = $stmt->fetch(PDO::FETCH_ASSOC);

        $senha = empty($_POST["senha"]) ? $usuario_atual["u_senha"] : md5($_POST["senha"]);

        try {
            $usuario = "UPDATE cadastro_usuario SET u_email = :email, u_nomecompleto = :nome, u_senha = :senha,
            u_endereco = :endereco, u_telefone = :telefone WHERE u_id = :u_id";
            $stmt = $pdo->prepare($usuario);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
            $stmt->bindParam(':senha', $senha, PDO::PARAM_STR);
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
    ?>

    
    </body>    
</html>