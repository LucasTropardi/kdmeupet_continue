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
    
    $query = "SELECT * FROM `cadastro_usuario` WHERE `u_id` = $u_id LIMIT 1";
    $select = $mysqli -> query($query);
    $usuario_atual = mysqli_fetch_assoc($select);
    
    $senha = empty($_POST["senha"]) ? $usuario_atual["u_senha"] : md5($_POST["senha"]);

$usuario = "UPDATE cadastro_usuario SET u_email = '$email', u_nomecompleto = '$nome', u_senha = '$senha', 
    u_endereco = '$endereco', u_telefone = '$telefone' WHERE u_id = '$u_id'";
    $sql_query = $mysqli->query($usuario) or die($mysqli->error);

    if($sql_query)
    echo "<script> location.href='sairuser.php';</script>";
    else
    echo "<script> alert('Não foi possível editar o usuário'); location.href='sairuser.php';</script>";
    ?>
    
    </body>    
</html>