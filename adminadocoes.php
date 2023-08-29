<?php

  if (!isset($_SESSION)) session_start();

  include_once"conexao.php";

  if (!isset($_SESSION['gerenciadorId'])) {
       session_destroy();      
       header("Location: admin.php"); exit;
  }
?>
<html lang="pt">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>KD meu PET</title>

    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700" rel="stylesheet" type="text/css" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Principal CSS do Bootstrap -->
    <link href="css/bootstrap-4.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">

    <!-- Estilos customizados para esse template -->
    <link href="css/dashboard.css" rel="stylesheet">
  
  </head>

  <body>
    <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
      <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">KD meu PET?</a>

      <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
          <a class="nav-link" href="sairgerenciador.php">Sair</a>
        </li>
      </ul>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
          <div class="sidebar-sticky">
          <?php include "menuadmin.php"; ?>           
          </div>
        </nav>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">

        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Cadastro de Animais</h1>           
          </div>

        <!-- CADASTRO DO ANIMAL -->   
        <!-- MENSAGEM RESULTADO DO CADASTRO: SUCESSO OU ERRO -->
        <?php
                if (isset($_SESSION["cadastro_adocao"])){
                    if ($_SESSION["cadastro_adocao"] == 1){
                        echo '<div class="alert alert-success" role="alert">
                            Animal cadastrado/editado/excluído com Sucesso!
                            </div>';
                    } elseif ($_SESSION["cadastro_adocao"] == -1){
                        echo '<div class="alert alert-danger" role="alert">
                            Ocorreu um erro ao cadastrar o animal. Por favor, tente novamente!<br>' . 
			                $_SESSION['msg'] . '
                            </div>';
                    } elseif ($_SESSION["cadastro_adocao"] == -2){
                        echo '<div class="alert alert-danger" role="alert">
                            Erro ao Salvar Arquivo. Por favor, tente novamente!
                            </div>';
                    } elseif ($_SESSION["cadastro_adocao"] == -3){
                        echo '<div class="alert alert-danger" role="alert">
                            Formato de Arquivo não suportado. Por favor, tente novamente!
                            </div>';
                    }
                }
            ?>

            <form action="processa_cadastro_adocoes.php" method="post" enctype="multipart/form-data">

                <!-- NOME DO ANIMAL -->
                <div class="row">
                <div class="col">
                    <label for="nome" class="form-label">Nome do Animal:</label>
                    <input type="text" class="form-control" maxlength="250" id="nome" name="nome" required>
                </div>
                
                <!-- IDADE DO ANIMAL -->
                <div class="col">
                    <label for="idade" class="form-label">Idade do Animal:</label>
                    <input type="text" class="form-control" maxlength="250" id="idade" name="idade" required>
                </div>
                </div>
                 
                <!-- FOTO DO ANIMAL -->
                <div class="mb-3">
                    <label for="foto" class="form-label">Envie uma foto:</label>
                    <input type="file" class="form-control" accept=".png, .jpg, .jpeg" id="foto" name="foto">
                </div>

                <!-- DESCRICAO DO ANIMAL -->
                <div class="mb-3">
                    <label for="descricao" class="form-label">Descrição:</label>
                    <textarea rows="4" class="form-control" id="descricao" name="descricao" required placeholder="Descreva o animal, suas condições ou dê qualquer informação que julgue importante. Cada detalhe pode ser importante!"></textarea>
                </div>                

                <!-- TIPO DO ANIMAL -->
                <div class="row">
                <div class="col">
                    <label for="tipo" class="form-label">Tipo do Animal: </label>
                    <select class="form-select" id="tipo" name="tipo">
                        <option disabled selected value="">Selecione uma Opção</option>
                        <?php 
                            try {
                              $query = "SELECT * FROM cadastro_tipo ORDER BY t_nome ASC";
                              $stmt = $pdo->prepare($query);
                              $stmt->execute();
                            } catch (PDOException $e) {
                              echo "Erro: " . $e->getMessage();
                            }
                            while ($tp = $stmt->fetch(PDO::FETCH_ASSOC)) {              
                        ?> 
                        <option value="<?php echo $tp["t_id"]; ?>">
                            <?php echo $tp["t_nome"]; ?>
                        </option>
                        <?php } ?>
                    </select>
                </div>

                <!-- RACA DO ANIMAL -->
                <div class="col">
                    <label for="raca" class="form-label">Raça: </label>
                    <select class="form-select" id="raca" name="raca">
                        <option disabled selected value="">Selecione uma Opção</option>';
                    </select>
                </div>
                </div>
                
                <!-- TAMANHO DO ANIMAL -->
                <div class="row">
                <div class="col">
                    <label for="tamanho" class="form-label">Tamanho: </label>
                    <select class="form-select" id="tamanho" name="tamanho">
                        <option disabled selected value="">Selecione uma Opção</option>
                        <?php 
                            try {
                              $query = "SELECT * FROM cadastro_tamanho ORDER BY t_nometm ASC";
                              $stmt = $pdo->prepare($query);
                              $stmt->execute();
                            } catch (PDOException $e) {
                              echo "Erro: " . $e->getMessage();
                            }
                            while ($tm = $stmt->fetch(PDO::FETCH_ASSOC)) {              
                        ?> 
                        <option value="<?php echo $tm["t_id"]; ?>">
                            <?php echo $tm["t_nometm"]; ?>
                        </option>
                        <?php } ?>
                    </select>
                </div>                

                <!-- COR DO ANIMAL -->
                <div class="col">
                    <label for="cor" class="form-label">Cor: </label>
                    <select class="form-select" id="cor" name="cor">
                        <option disabled selected value="">Selecione uma Opção</option>
                        <?php 
                            try {
                              $query = "SELECT * FROM cadastro_cor ORDER BY c_cor ASC";
                              $stmt = $pdo->prepare($query);
                              $stmt->execute();
                            } catch (PDOException $e) {
                              echo "Erro: " . $e->getMessage();
                            }
                            while ($cr = $stmt->fetch(PDO::FETCH_ASSOC)) {              
                        ?> 
                        <option value="<?php echo $cr["c_id"]; ?>">
                            <?php echo $cr["c_cor"]; ?>
                        </option>
                        <?php } ?>
                    </select>
                </div> 
                </div>                         
               
                <!-- CONTATO -->
                <div class="mb-3">
                    <label for="contato" class="form-label">Contato:</label>
                    <input type="text" class="form-control" maxlength="200" id="contato" name="contato" placeholder="Informe como as pessoas poderão entrar em contato.">
                </div>

                <!-- BOTAO ENVIA -->
                <input type="submit" class="btn btn-primary" value="Enviar">
            </form>
            <!-- FIM CADASTRO DO ANIMAL --> 


          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Adoção de Animais</h1>           
          </div>

          <div class="table-responsive">   
                
                <div class="table-responsive">
                <table class="table table-striped table-sm">
                <?php 
                    try {
                      $consulta = "SELECT * FROM cadastro_adocao ORDER BY p_nome ASC";
                      $stmt_consulta = $pdo->prepare($consulta);
                      $stmt_consulta->execute();
                    } catch (PDOException $e) {
                      echo "Erro: " . $e->getMessage();
                    }
                    $conta = $stmt_consulta->rowCount();

                    if($conta > 0)
                    {
                ?>
                <thead>
                    <tr>
                    <th>Status</th>
                    <th>Nome</th>
                    <th>Descrição</th> 
                    <th>Contato</th> 
                    <th>Idade</th> 
                    <th>Tipo</th> 
                    <th>Raça</th> 
                    <th>Tamanho</th> 
                    <th>Cor</th> 
                    <th>Ações</th> 
                    </tr>
                </thead>
                <tbody>                
                    <?php                 
                    while($dado = $stmt_consulta->fetch(PDO::FETCH_ASSOC))    
                    {              
                    ?>
                    <tr>                    
                    <td>
                    <?php if ($dado["p_status"] == 0)
                         { echo 'Disponível'; } 
                         else { echo 'Adotado';}                                        
                    ?>
                    </td>
                    <td><?php echo $dado["p_nome"]; ?></td>
                    <td><?php echo $dado["p_descricao"]; ?></td>
                    <td><?php echo $dado["p_contato"]; ?></td>
                    <td><?php echo $dado["p_idade"]; ?></td>
                    <td>                
                    <?php 
                       try { 
                        $tipo = "SELECT * from cadastro_tipo r";
                        $stmt = $pdo->prepare($tipo);
                        $stmt->execute();
                       } catch (PDOException $e) {
                        echo "Erro: " . $e->getMessage();
                       }
                       while($row = $stmt->fetch(PDO::FETCH_ASSOC))
                       {          
                        if ($dado["p_tipo"] == $row['t_id'])         
                          {                     
                            echo $row['t_nome'];                                           
                    } }?>                
                    </td>                     
                    <td>                
                    <?php 
                       try { 
                        $racas = "SELECT  * from cadastro_raca r";
                        $stmt = $pdo->prepare($racas);
                        $stmt->execute();
                       } catch (PDOException $e) {
                        echo "Erro: " . $e->getMessage();
                       }
                       while($row = $stmt->fetch(PDO::FETCH_ASSOC))
                       {          
                        if ($dado["p_raca"] == $row['r_id'])         
                          {                     
                            echo $row['r_nome'];                                           
                    } }?>                
                    </td>
                    <td>
                    <?php 
                       try {
                        $tamanho = "SELECT  * from cadastro_tamanho t";
                        $stmt = $pdo->prepare($tamanho);
                        $stmt->execute();
                       } catch (PDOException $e) {
                        echo "Erro: " . $e->getMessage();
                       }
                       while($tam = $stmt->fetch(PDO::FETCH_ASSOC))
                       {          
                        if ($dado["p_tamanho"] == $tam['t_id'])         
                          {                     
                            echo $tam['t_nometm'];                                           
                    } }?> 
                    </td>    
                    <td>
                    <?php 
                       try {
                        $cor = "SELECT  * from cadastro_cor c";
                        $stmt = $pdo->prepare($cor);
                        $stmt->execute();
                       } catch (PDOException $e) {
                        echo "Erro: " . $e->getMessage();
                       }
                       while($cores = $stmt->fetch(PDO::FETCH_ASSOC))
                       {          
                        if ($dado["p_cor"] == $cores['c_id'])         
                          {                     
                            echo $cores['c_cor'];                                           
                    } }?>     
                    </td>                       
                    <td class="text-nowrap actionGroup">
                      <?php
                        if ($dado['p_status'] == 0) {
                          echo '<a href="adocao_aprovar.php?p_id='.$dado['p_id'] . '" class="btn btn-success btn-sm text-light" role="button">Adotado?</a>';
                        } else {
                          echo '<a class="btn btn-secondary btn-sm text-light disabled" aria-disabled="true" role="button">Indisponível</a>';
                        }
                      ?>

                      <a href="c_adocao_editar.php?p_id=<?php echo $dado['p_id']; ?>" class="btn btn-primary btn-sm text-light" role="button">Editar</a>    
                      <a href="c_adocao_excluir.php?p_id=<?php echo $dado['p_id']; ?>" class="btn btn-danger btn-sm text-light btn-excluir" role="button">Excluir</a>
                      <a href="c_adocao_interesses.php?p_id=<?php echo $dado['p_id']; ?>" class="btn btn-primary btn-sm text-light" role="button">Interesses</a>    
                                            
                    </td>   
                    </tr> 
                    <?php } ?> 
                </tbody>
                <?php } ?> 
                </table>
            </div>
                   
          </div>
        </main>
      </div>
    </div>

     <!-- Bootstrap core JS-->
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Core theme JS-->
<script src="js/scripts.js"></script> 
<script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>

  <!-- BUSCA RACAS AO ALTERAR TIPO DO ANIMAL -->
  <script>
      $(document).ready(function() {
          $('#tipo').on('change', function() {
              var tipo_id = this.value;
              $.ajax({
                  url: "busca_racas.php",
                  type: "POST",
                  data: {
                      tipo_id: tipo_id
                  },
                  cache: false,
                  success: function(result) {
                      $("#raca").html(result);
                  }
              });
          });
      });
  </script>

  </body>
</html>
