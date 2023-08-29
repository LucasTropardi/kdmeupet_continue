<?php 
    require_once "conexao.php";

    $re_id = intval($_GET['c_id']);
    
    $query = "UPDATE cadastro_animal SET c_finalizado = 1 WHERE c_id = :re_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':re_id', $re_id);
    
    if ($stmt->execute()) {
        echo "<script> location.href='user.php';</script>";
    } else {
        echo "<script> alert('Não foi possível finalizar'); location.href='user.php';</script>";
    }
    
?>