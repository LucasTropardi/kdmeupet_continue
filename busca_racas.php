<?php
    include_once"conexao.php";
    $tipo_id = $_POST["tipo_id"];
    try{
        $query = "SELECT r_id, r_nome FROM cadastro_raca WHERE r_tipos = $tipo_id ORDER BY r_nome ASC";

        $stmt = $pdo->prepare($query);
        $stmt->execute();
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
        die();
    }
?>
<option disabled selected value="">Selecione uma Opção</option>';
<?php
    while($raca = $stmt->fetch(PDO::FETCH_ASSOC)) {
?>
<option value="<?php echo $raca["r_id"];?>"><?php echo $raca["r_nome"];?></option>
<?php
}
?>