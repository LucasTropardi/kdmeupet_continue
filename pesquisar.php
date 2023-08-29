<?php

    if (!isset($_SESSION)) session_start();

    include_once"conexao.php";

    $tipoanimal = $_POST['tipo'];
    $tiporaca = $_POST['raca'];
    $tamanhoanimal = $_POST['tamanho'];
    $coranimal = $_POST['cor'];

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
        
        <!-- Achados -->
        <section class="page-section bg-light" id="portfolio">
            <div class="container" id="achados">
                <div class="text-center">
                    <h2 class="section-heading text-uppercase">Achados</h2>
                    <h3 class="section-subheading text-muted">Últimos animais achados postados em nosso site.</h3>
                </div>
                
                 <!-- Filtros de buscas -->
                 <form method="POST" action="pesquisar.php">

                    <!-- TIPO DO ANIMAL -->      
                    <div class="row">
                        <div class="col">
                        <label for="tipo" class="form-label">Tipo do Animal: </label>
                        <select class="form-select" id="tipo" name="tipo" required  >
                            <option disabled selected value="">Selecione uma Opção</option>
                            <?php 
                                try {
                                    $query = "SELECT * FROM cadastro_tipo ORDER BY t_nome ASC";
                                    $stmt = $pdo->prepare($query);
                                    $stmt->execute();
                                } catch (PDOException $e) {
                                    echo "Erro: " . $e->getMessage();
                                    die();
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
                        <select class="form-select" id="raca" name="raca" required>
                            <option disabled selected value="">Selecione uma Opção</option>';
                        </select>
                    </div>
                    </div> 

                    <!-- TAMANHO DO ANIMAL -->
                    <div class="row">
                        <div class="col">
                        <label for="tamanho" class="form-label">Tamanho: </label>
                        <select class="form-select" id="tamanho" name="tamanho" required>
                            <option disabled selected value="">Selecione uma Opção</option>
                            <?php 
                                try {
                                    $query = "SELECT * FROM cadastro_tamanho ORDER BY t_nometm ASC";
                                    $stmt = $pdo->prepare($query);
                                    $stmt->execute();
                                } catch (PDOException $e) {
                                    echo "Erro: " . $e->getMessage();
                                    die();
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
                        <select class="form-select" id="cor" name="cor" required>
                            <option disabled selected value="">Selecione uma Opção</option>
                            <?php
                                try { 
                                    $query = "SELECT * FROM cadastro_cor ORDER BY c_cor ASC";
                                    $stmt = $pdo->prepare($query);
                                    $stmt->execute();
                                } catch (PDOException $e) {
                                    echo "Erro: " . $e->getMessage();
                                    die();
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

                    <br>
                    <div class="text-center">
                    <button class="btn btn-lg btn-primary btn-block" type="submit">Buscar</button> 
                    </div>
                    <br>
                    </form>
                    <!-- FIM Filtros de buscas -->


                <?php
                    try {
                        $query = "SELECT count(a.c_id) total FROM `cadastro_animal` a WHERE a.c_situacao = 1 AND a.c_finalizado = 0";                                     
                        $stmt = $pdo->prepare($query);
                        $stmt->execute();
                        $achados_tot =  $stmt->fetch(PDO::FETCH_ASSOC)['total'];              
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
                                            AND tp.t_id = $tipoanimal
                                            AND r.r_id = $tiporaca
                                            AND t.t_id = $tamanhoanimal 
                                            AND c.c_id = $coranimal 
                                            ORDER BY a.c_data DESC";
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
                    ?>
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
            $achados_row ++;
            }
        ?>
        <!-- FIM ACHADOS Modals-->

        <script>
        feather.replace()
        </script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>

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