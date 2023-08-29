<?php 

include_once"conexao.php";

?>

<html>   
    <body>  
    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nome = $_POST["nome"];

            try {
                $query = "INSERT INTO cadastro_cor (c_cor) VALUES (:nome)";
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(':nome', $nome);
                $stmt->execute();

                echo "<script>alert('Cadastrado com sucesso!'); window.location = 'cores.php';</script>";
            } catch (PDOException $e) {
                echo "Deu erro: " . $e->getMessage();
            }
        }
    ?>    
    </body>    
</html>