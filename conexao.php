<?php

$host = "localhost";
$db = "kdmeupet";
$user = "root";
$pass = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Conexão com a base de dados não estabelecida, verifique.");
}

/*$mysqli = mysqli_connect('kdmeupet.mysql.dbaas.com.br','kdmeupet','K@d#mpe!20','kdmeupet');

// Para mysqli
mysqli_set_charset($mysqli,"utf8");

if (!$mysqli){
    die("Conexão falhou: " . mysqli_connect_error());
}*/
?>