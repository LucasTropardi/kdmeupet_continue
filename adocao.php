<?php

    if (!isset($_SESSION)) session_start();

    require_once "conexao.php";
    require_once "classes/Adocao.php"

?>
<!DOCTYPE html>
<html lang="pt">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <title>KD meu PET?</title>

        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>    
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700" rel="stylesheet" type="text/css" />        
        <link href="css/styles.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

        <?php include "analytics.php"; ?>
        
    </head>
    <body id="page-top">

        <!-- Menu topo-->
        <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
            <div class="container">
                <a class="navbar-brand" href="#page-top"><img src="assets/img/navbar-logo.png" alt="..." /></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    Menu
                    <i class="fas fa-bars ms-1"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                 <?php include "topo.php"; ?>
                </div>
            </div>
        </nav>
        <!-- FIM Menu topo-->

        <!-- Banner -->
        <header class="masthead">
            <div class="container">                             
            </div>
        </header>    
        <!-- FIM Banner -->   
        
        <!-- MENSAGEM RESULTADO DO CADASTRO: SUCESSO OU ERRO -->
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
        
        <!-- Adocao -->
        <section class="page-section bg-light" id="portfolio">
            <div class="container" id="adocao">
                <div class="text-center">
                    <h2 class="section-heading text-uppercase">Adoção</h2>
                    <h3 class="section-subheading text-muted">Animais disponíveis para adoção.</h3>
                </div>
                
                <?php
                    try {
                        $query = "SELECT
                                    a.*,
                                    t.t_nome AS tipo,
                                    r.r_nome AS raca,
                                    tm.t_nometm AS tamanho,
                                    c.c_cor AS cor
                                  FROM
                                    `cadastro_adocao` a
                                  INNER JOIN `cadastro_tipo` t ON
                                    a.p_tipo = t.t_id
                                  INNER JOIN `cadastro_raca` r ON
                                    a.p_raca = r.r_id AND t.t_id = r.r_tipos
                                  INNER JOIN `cadastro_tamanho` tm ON
                                    a.p_tamanho = tm.t_id
                                  INNER JOIN `cadastro_cor` c ON
                                    a.p_cor = c.c_id
                                  WHERE
                                    a.p_status = 0
                                  ORDER BY
                                    a.p_nome ASC";
                    
                        $stmt = $pdo->prepare($query);
                        $stmt->execute();
                    
                        $lista_animais = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    } catch (PDOException $e) {
                        echo "Erro: " . $e->getMessage();
                    }
                ?>
                <div class="row">
                    <?php
                        foreach($lista_animais as $animal){              
                    ?>
                    <div class="col-lg-4 col-sm-6 mb-4">
                        
                        <div class="portfolio-item">
                            <a class="portfolio-link" data-bs-toggle="modal" href="#adocaoModal<?= $animal['p_id']; ?>">
                                <div class="portfolio-hover" style="z-index:1;">
                                    <div class="portfolio-hover-content"><i class="fas fa-plus fa-3x"></i></div>
                                </div>
                                <div class="ratio ratio-1x1"><img style="object-fit: cover;"
                                <?php
                                    if ($animal['p_foto'] != "" && is_file("upload/".$animal['p_foto'])){
                                        echo 'src="upload/'. $animal['p_foto'] .'"'; 
                                    } else {
                                        echo 'src="assets/img/sem_imagem.png"';
                                    }
                                ?>
                                    alt="..." /></div>
                            </a>
                            <div class="portfolio-caption">
                                <div class="portfolio-caption-heading"><?= $animal['p_nome']; ?></div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </section>
        <!-- FIM Achados -->

        <!-- Rodapé -->
        <footer class="footer2 py-4">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-4 my-3 my-lg-0">
                    </div>
                    <div class="col-lg-4 text-lg-end">
                    </div>
                </div>
            </div>
        </footer>
        <!-- FIM Rodapé -->

        <!-- ACHADOS Modals-->
        <?php
            foreach($lista_animais as $animal){
        ?>
        <div class="portfolio-modal modal fade" id="adocaoModal<?= $animal['p_id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="close-modal" data-bs-dismiss="modal"><img src="assets/img/close-icon.svg" alt="Close modal" /></div>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <div class="modal-body">
                                    <!-- Project details-->
                                    <h2 class="text-uppercase"><?= $animal['p_nome']; ?></h2>
                                    <br><strong>Contato: </strong> <?= $animal['p_contato']; ?></p>
                                    <img class="img-fluid d-block mx-auto"
                                        <?php
                                            if ($animal['p_foto'] != "" && is_file('upload/'.$animal['p_foto'])){
                                                echo 'src="upload/'. $animal['p_foto'] .'"'; 
                                            } else {
                                                echo 'src="assets/img/sem_imagem.png"';
                                            }
                                        ?>
                                        alt="..." />
                                    <p><?= $animal['p_descricao']; ?></p>
                                    <ul class="list-inline">
                                        <li>
                                            <strong>Idade:</strong>
                                            <?php echo $animal['p_idade']; ?>
                                        </li>
                                        <li>
                                            <strong>Tipo:</strong>
                                            <?php echo $animal['tipo']; ?>
                                        </li>
                                        <li>
                                            <strong>Tamanho:</strong>
                                            <?php echo $animal['tamanho']; ?>
                                        </li>
                                        <li>
                                            <strong>Raça:</strong>
                                            <?php echo $animal['raca']; ?>
                                        </li>
                                        <li>
                                            <strong>Cor:</strong>
                                            <?php echo $animal['cor']; ?>
                                        </li>
                                    </ul>
                                    <a class="btn btn-primary btn-xl text-uppercase" href="adocao_interesse.php?id=<?= $animal['p_id'] ?>">
                                        <i class="fa-solid fa-paw"></i>
                                        Tenho interesse!
                                        </a>
                                    <button class="btn btn-outline-primary btn-xl text-uppercase" data-bs-dismiss="modal" type="button">
                                        <i class="fas fa-xmark me-1"></i>
                                        Fechar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
        <!-- FIM ACHADOS Modals-->

        <script>
        feather.replace()
        </script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>

    </body>
</html>