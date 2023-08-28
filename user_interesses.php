<?php

  if (!isset($_SESSION)) session_start();

  include_once"conexao.php";

  if (!isset($_SESSION['usuarioId'])) {
       session_destroy();      
       header("Location: usuario.php"); exit;
  }

  include_once "./classes/Adocao.php";
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
                <!-- Menu Usuario -->
                <nav class="col-md-2 d-none d-md-block bg-light sidebar">
                    <div class="sidebar-sticky">                
                    <?php include "menuuser.php"; ?> 
                    </div>
                </nav>
                <!-- Fim Menu Usuario -->

                <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <h1 class="h2">Interesse para Adoção</h1>           
                    </div>
    

                    <div class="container-fluid">   
                    <?php
                        $lista_animais = Adocao::buscaPorUsuario($mysqli, $_SESSION['usuarioId']);
                        foreach ($lista_animais as $animal) {
                    ?>
                        <div class="card mb-3"">
                          <div class="row g-0 align-items-center">
                                <div class="col-md-2">
                                    <img src=
                                    <?php
                                        if ($animal['p_foto'] != "" && is_file('upload/'.$animal['p_foto'])){
                                            echo '"upload/'. $animal['p_foto'] .'"'; 
                                        } else {
                                            echo '"assets/img/sem_imagem.png"';
                                        }
                                    ?>
                                    class="img-thumbnail rounded-start" alt="...">
                                </div>
                                <div class="col-md-10">
                                    <div class="card-body p-1">
                                        <div class="p-1">
                                            <h5 class="card-title"><?= $animal['p_nome'] ?></h5>
                                            <p class="card-text"><?= $animal['p_descricao'] ?></p>
                                        </div>
                                        <div class="card-footer border">
                                            <div class="d-flex flex-column flex-md-row flex-wrap gap-2 justify-content-center">
                                                <?php
                                                    if (!$animal['p_status']) {
                                                        echo '<a class="btn btn-primary" style="pointer-events: none;">Situação: Disponível</a>';
                                                    } else {
                                                        echo '<a class="btn btn-secondary" style="pointer-events: none;">Situação: Adotado</a>';
                                                    }
                                                ?>
                                                <a class="btn btn-secondary" style="pointer-events: none;"><?= "Contato: ". $animal['p_contato'] ?></a>
                                                <?php
                                                    if ($animal['i_lida']) {
                                                        echo '<a class="btn btn-primary" style="pointer-events: none;">Mensagem: Lida</a>';
                                                    } else {
                                                        echo '<a class="btn btn-secondary" style="pointer-events: none;">Mensagem: Recebida</a>';
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    </div>
                </main>
            </div>
        </div>
       <!-- FIM Área de usuário -->

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
        
    </body>
</html>