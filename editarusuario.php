<?php 

include_once"conexao.php";

?>

<html>   
    <body>  
        <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $g_id = intval($_GET['g_id']);
                $nome = $_POST["nome"];
                $email = $_POST["email"];
                $senha = md5($_POST["senha"]);
                $nivel = $_POST["nivel"];

                try {
                    $query = "UPDATE cadastro_gerenciador SET g_email = :email, g_senha = :senha, g_nivel = :nivel, g_nome = :nome WHERE g_id = :g_id";
                    $stmt = $pdo->prepare($query);
                    $stmt->bindParam(':email', $email);
                    $stmt->bindParam(':senha', $senha);
                    $stmt->bindParam(':nivel', $nivel);
                    $stmt->bindParam(':nome', $nome);
                    $stmt->bindParam(':g_id', $g_id);
                    $stmt->execute();

                    echo "<script> location.href='gerenciamento.php';</script>";
                } catch (PDOException $e) {
                    echo "<script> alert('Não foi possível editar o usuário'); location.href='gerenciamento.php';</script>";
                }
            }
        ?>
    </body>    
</html>