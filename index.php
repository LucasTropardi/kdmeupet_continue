<?php

    if (!isset($_SESSION)) session_start();

    require_once"conexao.php";

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

        <?php
            if (isset($_SESSION['msgContent'])) {
            echo '<div class="container p-3">' . $_SESSION['msgContent'] . '</div>';
            }
            unset($_SESSION['msgContent']);
        ?>
        <!-- Achados -->
        <section class="page-section bg-light" id="portfolio">
            <div class="container" id="achados">
                <div class="text-center">
                    <h2 class="section-heading text-uppercase">Achados</h2>
                    <h3 class="section-subheading text-muted">Últimos animais achados postados em nosso site.</h3>
                </div>
                <?php
                    try {
                        $query = "SELECT count(a.c_id) as total FROM `cadastro_animal` a WHERE a.c_situacao = 1 AND a.c_finalizado = 0";
                        $stmt_query = $pdo->prepare($query);
                        $stmt_query->execute();
                        $achados_tot =  $stmt_query->fetch(PDO::FETCH_ASSOC)['total'];              
                        $query_achados = "SELECT a.*,
                                                t.t_nometm,
                                                r.r_nome,
                                                c.c_cor,
                                                u.u_nomecompleto,
                                                tp.t_nome
                                                FROM `cadastro_animal` a
                                                JOIN `cadastro_tamanho` t ON a.c_tamanho = t.t_id
                                                JOIN `cadastro_raca` r ON a.c_raca = r.r_id
                                                JOIN `cadastro_cor` c ON a.id_cor = c.c_id
                                                JOIN `cadastro_usuario` u ON a.c_usuario = u.u_id
                                                JOIN `cadastro_tipo` tp ON r.r_tipos = tp.t_id
                                                WHERE a.c_situacao = 1 AND a.c_finalizado = 0
                                                ORDER BY a.c_data DESC";
                        if ($achados_tot > 5){
                            $query_achados .= " LIMIT 5";
                        }
                        $stmt_achados = $pdo->prepare($query_achados);
                        $stmt_achados->execute();
                    } catch (PDOException $e) {
                        echo "Erro: " . $e->getMessage();
                        die();
                    }   
                ?>
                <div class="row">
                    <?php
                        $achados_row = 1;
                        while ($achados = $stmt_achados->fetch(PDO::FETCH_ASSOC)) {              
                    ?>
                    <div class="col-lg-4 col-sm-6 mb-4">
                        
                        <div class="portfolio-item">
                            <a class="portfolio-link" data-bs-toggle="modal" href="#achadosModal<?php echo $achados_row; ?>">
                                <div class="portfolio-hover" style="z-index:1;">
                                    <div class="portfolio-hover-content"><i class="fas fa-plus fa-3x"></i></div>
                                </div>
                                <div class="ratio ratio-1x1"><img style="object-fit: cover;"
                                <?php
                                    if ($achados['c_foto'] != ""){
                                        echo 'src="upload/'. $achados['c_foto'] .'"'; 
                                    } else {
                                        echo 'src="assets/img/sem_imagem.png"';
                                    }
                                ?>
                                    alt="..." /></div>
                            </a>
                            <div class="portfolio-caption">
                                <div class="portfolio-caption-heading"><?php echo $achados['c_nomeanimal']; ?></div>
                            </div>
                        </div>
                    </div>
                    <?php
                        $achados_row ++;
                        }
                        if ($achados_tot > 5) {
                    ?>
                    <div class="col-lg-4 col-sm-6 mb-4">
                        <!-- VER MAIS -->
                        <div class="portfolio-item">
                            <a class="portfolio-link" data-bs-toggle="modal" href="#">
                                <div class="portfolio-hover">
                                    <div class="portfolio-hover-content"><i class="fas fa-plus fa-3x"></i></div>
                                </div>
                                <img class="img-fluid" src="assets/img/mais_resultados.png" alt="..." />
                            </a>
                            <div class="portfolio-caption">
                                <div class="portfolio-caption-heading">Ver Mais...</div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </section>
        <!-- FIM Achados -->

        <!-- Perdidos -->
        <section class="page-section bg-light" id="portfolio">
            <div class="container" id="perdidos">
                <div class="text-center">
                    <h2 class="section-heading text-uppercase">Perdidos</h2>
                    <h3 class="section-subheading text-muted">Últimos animais perdidos postados em nosso site.</h3>
                </div>
                <?php
                    try {
                        $query = "SELECT count(a.c_id) as total FROM `cadastro_animal` a WHERE a.c_situacao = 2 AND a.c_finalizado = 0";
                        $stmt_query = $pdo->prepare($query);
                        $stmt_query->execute();
                        $perdidos_tot =  $stmt_query->fetch(PDO::FETCH_ASSOC)['total'];              
                        $query_perdidos = "SELECT a.*,
                                                t.t_nometm,
                                                r.r_nome,
                                                c.c_cor,
                                                u.u_nomecompleto,
                                                tp.t_nome
                                                FROM `cadastro_animal` a
                                                JOIN `cadastro_tamanho` t ON a.c_tamanho = t.t_id
                                                JOIN `cadastro_raca` r ON a.c_raca = r.r_id
                                                JOIN `cadastro_cor` c ON a.id_cor = c.c_id
                                                JOIN `cadastro_usuario` u ON a.c_usuario = u.u_id
                                                JOIN `cadastro_tipo` tp ON r.r_tipos = tp.t_id
                                                WHERE a.c_situacao = 2 AND a.c_finalizado = 0
                                                ORDER BY a.c_data DESC";
                        if ($perdidos_tot > 5){
                            $query_perdidos .= " LIMIT 5";
                        }
                    $stmt_perdidos = $pdo->prepare($query_perdidos);
                    $stmt_perdidos->execute();
                    } catch (PDOException $e) {
                        echo "Erro: " . $e->getMessage();
                        die();
                    }
                ?>
                <div class="row">
                    <?php
                        $perdidos_row = 1;
                        while ($perdidos = $stmt_perdidos->fetch(PDO::FETCH_ASSOC)) {              
                    ?>
                    <div class="col-lg-4 col-sm-6 mb-4">
                        
                        <div class="portfolio-item">
                            <a class="portfolio-link" data-bs-toggle="modal" href="#perdidosModal<?php echo $perdidos_row; ?>">
                                <div class="portfolio-hover" style="z-index:1;">
                                    <div class="portfolio-hover-content"><i class="fas fa-plus fa-3x"></i></div>
                                </div>
                                <div class="ratio ratio-1x1"><img style="object-fit: cover;"
                                <?php
                                    if ($perdidos['c_foto'] != ""){
                                        echo 'src="upload/'. $perdidos['c_foto'] .'"'; 
                                    } else {
                                        echo 'src="assets/img/sem_imagem.png"';
                                    }
                                ?>
                                    alt="..." /></div>
                            </a>
                            <div class="portfolio-caption">
                                <div class="portfolio-caption-heading"><?php echo $perdidos['c_nomeanimal']; ?></div>
                            </div>
                        </div>
                    </div>
                    <?php
                        $perdidos_row ++;
                        }
                        if ($perdidos_tot > 5) {
                    ?>
                    <div class="col-lg-4 col-sm-6 mb-4">
                        <!-- VER MAIS -->
                        <div class="portfolio-item">
                            <a class="portfolio-link" data-bs-toggle="modal" href="#">
                                <div class="portfolio-hover">
                                    <div class="portfolio-hover-content"><i class="fas fa-plus fa-3x"></i></div>
                                </div>
                                <img class="img-fluid" src="assets/img/mais_resultados.png" alt="..." />
                            </a>
                            <div class="portfolio-caption">
                                <div class="portfolio-caption-heading">Ver Mais...</div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </section>
        <!-- FIM Perdidos -->

        <!-- Parcerias -->
        <?php
        // busca parcerias
            try {
                $query = "SELECT * FROM `contacts_msg` WHERE `aprovado` = 1 ORDER BY RAND() LIMIT 5";
                $stmt = $pdo->prepare($query);
                $stmt->execute();
            } catch (PDOException $e) {
                echo "Erro: " . $e->getMessage();
                die();
            }   
        ?>
        <section class="page-section" id="about">
            <div class="container">
                <div class="text-center">
                    <h2 class="section-heading text-uppercase">Parcerias</h2>
                    <?php
                        if ($stmt->rowCount() > 0) {
                    ?>
                        <h3 class="section-subheading text-muted">Aqui estão listados alguns de nossos parceiros.</h3>
                    <?php } ?>
                </div>
                <?php
                    if ($stmt->rowCount() > 0) {
                        echo '<ul class="timeline">';
                        $num_linha = 1;
                        while ($parceria = $stmt->fetch(PDO::FETCH_ASSOC)) {
                ?>
                        <li <?php if ($num_linha % 2 == 0) echo 'class="timeline-inverted"'?> >
                            <div class="timeline-image ratio ratio-1x1">
                                <img class="rounded-circle" style="object-fit: cover;" src="upload/parcerias/<?php echo $parceria['imagem']; ?>" alt="Logo <?php echo $parceria['titulo']; ?>" />
                            </div>
                            <div class="timeline-panel">
                            <div class="timeline-heading">
                                <h4><?php echo $parceria['titulo']; ?></h4>
                                <h5 class="subheading"><?php echo $parceria['contato_organizacao']; ?></h5>
                            </div>
                            <div class="timeline-body"><p class="text-muted"><?php echo $parceria['msg']; ?></p></div>
                        </div>
                        </li>
                    <?php
                        $num_linha++; 
                        }
                    echo '</ul>';
                    }
                    ?>      
            </div>
        </section>
        <!-- FIM Parcerias -->       
        
        <!-- Contato -->
        <?php include "contato.php"; ?>
        <!-- FIM Contato -->

        <!-- Rodapé -->
            <!--
                <footer class="footer py-4">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-lg-4 my-3 my-lg-0">
                            </div>
                            <div class="col-lg-4 text-lg-end">
                            </div>
                        </div>
                    </div>
                </footer>
            -->
        <!-- FIM Rodapé -->

        <!-- ACHADOS Modals-->
        <?php
            try {
                $stmt_achados = $pdo->prepare($query_achados);
                $stmt_achados->execute();
            } catch (PDOException $e) {
                echo "Erro: " . $e->getMessage();
                die();
            }

            $achados_row = 1;
            while ($achados = $stmt_achados->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <div class="portfolio-modal modal fade" id="achadosModal<?php echo $achados_row; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="close-modal" data-bs-dismiss="modal"><img src="assets/img/close-icon.svg" alt="Close modal" /></div>
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-lg-8">
                                    <div class="modal-body">
                                        <!-- Project details-->
                                        <h2 class="text-uppercase"><?php echo $achados['c_nomeanimal']; ?></h2>
                                        <p class="item-intro text-muted"><strong>Enviado por:</strong> <?php echo $achados['u_nomecompleto']; ?>
                                        <br><strong>Em:</strong> <?php echo date("d/m/Y H:i:s", strtotime($achados['c_data'])); ?></p>
                                        <img class="img-fluid d-block mx-auto"
                                            <?php
                                                if ($achados['c_foto'] != ""){
                                                    echo 'src="upload/'. $achados['c_foto'] .'"'; 
                                                } else {
                                                    echo 'src="assets/img/sem_imagem.png"';
                                                }
                                            ?>
                                            alt="..." />
                                        <p><?php echo $achados['c_descricao']; ?></p>
                                        <ul class="list-inline">
                                            <li>
                                                <strong>Tamanho:</strong>
                                                <?php echo $achados['t_nometm']; ?>
                                            </li>
                                            <li>
                                                <strong>Raça:</strong>
                                                <?php echo $achados['r_nome']; ?>
                                            </li>
                                            <li>
                                                <strong>Cor:</strong>
                                                <?php echo $achados['c_cor']; ?>
                                            </li>
                                            <li>
                                                <?php
                                                    if ($achados['c_endereco'] != ""){ ?>
                                                <strong>Localização:</strong>
                                                <?php echo $achados['c_endereco'];
                                                    } ?>
                                            </li>
                                            <li>
                                                <?php
                                                    if ($achados['c_contato'] != ""){ ?>
                                                <strong>Contato:</strong>
                                                <?php echo $achados['c_contato'];
                                                    } ?>
                                            </li>
                                        </ul>
                                        <button class="btn btn-primary btn-xl text-uppercase" data-bs-dismiss="modal" type="button">
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
            <?php
                $achados_row++;
            }
        ?>
        <!-- FIM ACHADOS Modals-->

        <!-- PERDIDOS Modals-->
        <?php
            try {
                $stmt_perdidos = $pdo->prepare($query_perdidos);
                $stmt_perdidos->execute();
            } catch (PDOException $e) {
                echo "Erro: " . $e->getMessage();
                die();
            }

            $perdidos_row = 1;
            while ($perdidos = $stmt_perdidos->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <div class="portfolio-modal modal fade" id="perdidosModal<?php echo $perdidos_row; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="close-modal" data-bs-dismiss="modal"><img src="assets/img/close-icon.svg" alt="Close modal" /></div>
                            <div class="container">
                                <div class="row justify-content-center">
                                    <div class="col-lg-8">
                                        <div class="modal-body">
                                            <!-- Project details-->
                                            <h2 class="text-uppercase"><?php echo $perdidos['c_nomeanimal']; ?></h2>
                                            <p class="item-intro text-muted"><strong>Enviado por:</strong> <?php echo $perdidos['u_nomecompleto']; ?>
                                                <br><strong>Em:</strong> <?php echo date("d/m/Y H:i:s", strtotime($perdidos['c_data'])); ?></p>
                                            <img class="img-fluid d-block mx-auto"
                                                <?php
                                                if ($perdidos['c_foto'] != "") {
                                                    echo 'src="upload/' . $perdidos['c_foto'] . '"';
                                                } else {
                                                    echo 'src="assets/img/sem_imagem.png"';
                                                }
                                                ?>
                                                alt="..." />
                                            <p><?php echo $perdidos['c_descricao']; ?></p>
                                            <ul class="list-inline">
                                                <li>
                                                    <strong>Tamanho:</strong>
                                                    <?php echo $perdidos['t_nometm']; ?>
                                                </li>
                                                <li>
                                                    <strong>Raça:</strong>
                                                    <?php echo $perdidos['r_nome']; ?>
                                                </li>
                                                <li>
                                                    <strong>Cor:</strong>
                                                    <?php echo $perdidos['c_cor']; ?>
                                                </li>
                                                <li>
                                                    <?php
                                                    if ($perdidos['c_endereco'] != "") { ?>
                                                        <strong>Localização:</strong>
                                                        <?php echo $perdidos['c_endereco'];
                                                    } ?>
                                                </li>
                                                <li>
                                                    <?php
                                                    if ($perdidos['c_contato'] != "") { ?>
                                                        <strong>Contato:</strong>
                                                        <?php echo $perdidos['c_contato'];
                                                    } ?>
                                                </li>
                                            </ul>
                                            <button class="btn btn-primary btn-xl text-uppercase" data-bs-dismiss="modal"
                                                    type="button">
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
                <?php
                $perdidos_row++;
            }
        ?>
        <!-- FIM PERDIDOS Modals-->

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>

    </body>
</html>