<?php 

include_once"conexao.php";

?>
<html>   

    <body>  

    <?php        

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $nome = $_POST["nome"];
            $email = $_POST["email"];
            $senha = md5($_POST["senha"]);
            $nivel = $_POST["nivel"];

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

    ?>
    
    </body>    

</html>