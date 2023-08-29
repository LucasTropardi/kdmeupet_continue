<?php 

require_once"conexao.php";

?>

<html>   
    <body>  
        <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $nome = $_POST["nome"];
                $tipo = $_REQUEST['tipo'];

                try {
                    $query = "INSERT INTO cadastro_raca (r_nome, r_tipos) VALUES (:nome, :tipo)";
                    $stmt = $pdo->prepare($query);
                    $stmt->bindParam(':nome', $nome);
                    $stmt->bindParam(':tipo', $tipo);
                    $stmt->execute();

                    echo "<script>alert('Cadastrado com sucesso!'); window.location = 'racas.php';</script>";
                } catch (PDOException $e) {
                    echo "Deu erro: " . $e->getMessage();
                }
            }
        ?>
    </body>    
</html>