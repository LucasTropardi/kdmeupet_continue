<?php

  if (!isset($_SESSION)) session_start();

  require_once "conexao.php";
  require_once "classes/Adocao.php";

  /* todo
   * ok - verifica se usuario logado
   * ok - verifica se animal para adocao existe
   * ok - criar formulario para enviar msg
   * ok - exibindo informacoes do animal para adocao
   * criar sistema de msgs, alerta, aviso usuario
   * 
   */

  if (!isset($_GET['id'])) {
    header("Location: adocao.php"); exit;
  }

  if (!isset($_SESSION['usuarioId'])) {
    session_destroy();
    header("Location: usuario.php"); exit;
  }

  $animal = Adocao::buscaPorId($mysqli, $_GET['id']);
  if (!$animal) {
    header("Location: adocao.php"); exit;
  }

?>
<!DOCTYPE html>
<html lang="pt">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>KD meu PET?</title>
        
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

        <!-- Mapas -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.2/dist/leaflet.css"
        integrity="sha256-sA+zWATbFveLLNqWO2gtiw3HL/lh1giY/Inf1BJ0z14="
        crossorigin=""/>
        <script src="https://unpkg.com/leaflet@1.9.2/dist/leaflet.js"
        integrity="sha256-o9N1jGDZrf5tS+Ft4gbIK7mYMipq9lqpVJ91xHSyKhg="
        crossorigin=""></script>   


    </head>
    <body id="page-top">
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
            <div class="container">
                <a class="navbar-brand" href="index.php"><img src="assets/img/navbar-logo.png" alt="..." /></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    Menu
                    <i class="fas fa-bars ms-1"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                 <?php include "topo.php"; ?>
                </div>
            </div>
        </nav>
        <!-- Masthead-->
        <header class="masthead">
            <div class="container">             
            </div>
        </header>        

        <!-- Área de usuário -->
        <div class="container-fluid">
        <div class="row">
            <nav class="col-md-2 d-none d-md-block bg-light sidebar">
            <div class="sidebar-sticky">
            <?php include "menuuser.php"; ?>             
            </div>
            </nav>

            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Adoção</h1>           
            </div>
   
        <!-- MENSAGEM ALERTA -->
        <?php
            if (isset($_SESSION["alert_msg"])){
                echo '<div id="alert_msg" class="text-center alert alert-' . $_SESSION['alert_type'] . '" role="alert">' .
                        $_SESSION["alert_msg"]
                      . '</div>';
                unset($_SESSION["alert_msg"]);
                unset($_SESSION["alert_type"]);
            }
        ?>
        <!-- FIM MENSAGEM -->

            <!-- Card Animal-->
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
                                <strong>Tipo:</strong> <?= $animal['tipo'] ?><br>
                                <strong>Tamanho:</strong> <?= $animal['tamanho'] ?><br>
                                <strong>Raça:</strong> <?= $animal['raca'] ?><br>
                                <strong>Cor:</strong> <?= $animal['cor'] ?></small>
                            </small></p>
                        </div>
                    </div>
                </div>
            </div>

            <form action="processa_cadastro_interesse_adocao.php" method="post" enctype="multipart/form-data">
                
                <input type="hidden" name="i_adocao" value="<?= $animal['p_id'] ?>">
                <!-- MENSAGEM -->
                <div class="mb-3">
                    <label for="msg" class="form-label">Mensagem:</label>
                    <textarea rows="5" class="form-control" maxlength="250" id="msg" name="msg" required placeholder="Escreva uma mensagem demonstrando o seu interesse pelo animal."></textarea>
                </div>

                <!-- BOTAO ENVIA -->
                <input type="submit" class="btn btn-primary" value="Enviar">
            </form>
                       
            </div>
            </main>
            <br>
        </div>
        </div>
       <!-- FIM Área de usuário -->   

        <!-- Ícones -->
        <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
        <script>
        feather.replace()
        </script>
    
        <!-- Footer-->
        <footer class="footer2 py-4">
            <div class="container">
                <div class="row align-items-center">
                   <!-- <div class="col-lg-4 text-lg-start">Copyright &copy; Your Website 2022</div>-->
                    <div class="col-lg-4 my-3 my-lg-0">
                        <!-- <a class="btn btn-dark btn-social mx-2" href="#!" aria-label="Twitter"><i class="fab fa-twitter"></i></a>-->
                        <!--<a class="btn btn-dark btn-social mx-2" href="#!" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>-->
                        <!--<a class="btn btn-dark btn-social mx-2" href="#!" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>-->
                    </div>
                    <div class="col-lg-4 text-lg-end">
                        <!--<a class="link-dark text-decoration-none me-3" href="#!">Privacy Policy</a>-->
                        <!--<a class="link-dark text-decoration-none" href="#!">Terms of Use</a>-->
                    </div>
                </div>
            </div>
        </footer>
        
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