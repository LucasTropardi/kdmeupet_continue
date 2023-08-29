<?php
include_once "conexao.php";

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['g_id'])) {
    $g_id = filter_input(INPUT_GET, 'g_id', FILTER_VALIDATE_INT);

    if ($g_id !== false && $g_id !== null) {
        try {
            $query = "DELETE FROM cadastro_gerenciador WHERE g_id = :g_id";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':g_id', $g_id, PDO::PARAM_INT);
            $stmt->execute();

            echo "<script> location.href='gerenciamento.php';</script>";
        } catch (PDOException $e) {
            echo "<script> alert('Não foi possível remover'); location.href='gerenciamento.php';</script>";
        }
    } else {
        echo "<script> alert('Parâmetro inválido'); location.href='gerenciamento.php';</script>";
    }
}
?>
