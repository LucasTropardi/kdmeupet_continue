<?php

if (!isset($_SESSION)) session_start();
date_default_timezone_set('America/Sao_Paulo');

if (!isset($_SESSION['gerenciadorId'])) {
     session_destroy();      
     header("Location: index.php");
     exit;
}

include_once"conexao.php";

// verifica se ID passado é válido
if (!isset($_GET['p_id']) || $_GET['p_id'] == null || $_GET['p_id'] <= 0) {
    $_SESSION['msgContent'] = '<div class="alert alert-danger" role="alert">
    Não é possível excluir!</div>';
    header("Location: ../adminadocoes.php"); exit;
}

$p_id = $_GET['p_id'];
?>

<html lang="pt">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>KD meu PET</title>

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
            <h1 class="h2">Interesses no PET</h1>           
          </div>

          <div class="table-responsive">   

          <!-- Card Animal-->
          <?php 
                    $interesse = "SELECT distinct c.*, u.*, t.*, tt.*, r.*, cc.* FROM cadastro_adocao_interesse c                    
                    inner join cadastro_adocao u on u.p_id = c.i_adocao   
                    inner join cadastro_tipo t on t.t_id = u.p_tipo  
                    inner join cadastro_tamanho tt on tt.t_id = u.p_tamanho   
                    inner join cadastro_raca r on r.r_id = u.p_raca  
                    inner join cadastro_cor cc on cc.c_id = u.p_cor        
                    where c.i_adocao = $p_id ";         
                    
                    $sql2 = $mysqli -> query($interesse);

                    $animal = $sql2->fetch_array();                   

          ?>
          <div class="card mb-3">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src=
                        <?php
                            if ($animal['p_foto'] != "" && is_file('upload/'.$animal['p_foto'])){
                                echo '"upload/'. $animal['p_foto'] .'"'; 
                            } else {
                                echo '"assets/img/sem_imagem.png"';
                            }
                        ?>
                        class="img-fluid rounded-start h-100" style="object-fit: cover;" alt="...">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title"><?= $animal['p_nome'] ?></h5>
                            <p class="card-text"><?= $animal['p_descricao']?></p>
                            <p class="card-text"><small class="text-body-secondary">
                                <strong>Idade:</strong> <?= $animal['p_idade'] ?><br>
                                <strong>Tipo:</strong> <?= $animal['t_nome'] ?><br>
                                <strong>Tamanho:</strong> <?= $animal['t_nometm'] ?><br>
                                <strong>Raça:</strong> <?= $animal['r_nome'] ?><br>
                                <strong>Cor:</strong> <?= $animal['c_cor'] ?></small>
                            </small></p>
                        </div>
                    </div>
                </div>
            </div> 
                
                <div class="table-responsive">
                <table class="table table-striped table-sm">
                <?php 
                    $consulta = "SELECT c.*, u.* FROM cadastro_adocao_interesse c                    
                    inner join cadastro_usuario u on u.u_id = c.i_usuario                     
                    where c.i_adocao = $p_id order by c.i_id desc";                
                    
                    $sql = $mysqli->query($consulta) or die($mysqli->error);
                    $conta = mysqli_num_rows($sql);

                    if($conta > 0)
                    {
                ?>
                <thead>
                    <tr>
                    <th>ID</th>
                    <th>Nome</th> 
                    <th>E-mail</th>
                    <th>Telefone</th>
                    <th>Mensagem</th>     
                    <th>Ações</th>               
                    </tr>
                </thead>
                <tbody>                
                    <?php                 
                    while($dado = $sql->fetch_array())    
                    {              
                    ?>
                    <tr>
                    <td><?php echo $dado["i_id"]; ?></td>  
                    <td><?php echo $dado["u_nomecompleto"]; ?></td>  
                    <td><?php echo $dado["u_email"]; ?></td>      
                    <td><?php echo $dado["u_telefone"]; ?></td>  
                    <td><?php echo $dado["i_mensagem"]; ?></td>
                    <td>
                    <?php
                        if ($dado['i_lida'] == 0) {
                          echo '<a href="lido_interesse.php?i_id='.$dado['i_id'] . '" class="btn btn-success btn-sm text-light" role="button">Novo</a>';
                        } else {
                          echo '<a class="btn btn-secondary btn-sm text-light disabled" aria-disabled="true" role="button">Lido</a>';
                        }
                      ?>
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

    <!-- Principal JavaScript do Bootstrap
    ================================================== -->
    <!-- Foi colocado no final para a página carregar mais rápido -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="css/bootstrap-4.1.3/assets/js/vendor/popper.min.js"></script>
    <script src="css/bootstrap-4.1.3/dist/js/bootstrap.min.js"></script>

    <!-- Ícones -->
    <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
    <script>
      feather.replace()
    </script>

    

  </body>
</html>
