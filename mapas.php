<?php

    if (!isset($_SESSION)) session_start();

    include_once"conexao.php";

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

        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.2/dist/leaflet.css"
        integrity="sha256-sA+zWATbFveLLNqWO2gtiw3HL/lh1giY/Inf1BJ0z14="
        crossorigin=""/>

        <script src="https://unpkg.com/leaflet@1.9.2/dist/leaflet.js"
        integrity="sha256-o9N1jGDZrf5tS+Ft4gbIK7mYMipq9lqpVJ91xHSyKhg="
        crossorigin=""></script>    
        
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
        
        <!-- Mapas -->
        <section class="page-section bg-light" id="portfolio">
            <div class="container" id="mapas">              
             
              <div id="mapid" style="width: 100%; height: 600px;"></div>         
              
              <?php
                    $query = "SELECT count(a.c_id) total FROM `cadastro_animal` a WHERE a.c_finalizado = 0 AND a.c_latitude is not null";
                    $sql_animais_tot = $mysqli->query($query) or die($mysqli->error);
                    $animais_tot =  $sql_animais_tot->fetch_array()['total'];              
                    $query_animais = "SELECT a.*,
                                             t.t_nometm,
                                             r.r_nome,
                                             c.c_cor,
                                             u.u_nomecompleto,
                                             tp.t_nome
                                        FROM `cadastro_animal` a,
                                             `cadastro_tamanho` t,
                                             `cadastro_raca` r,
                                             `cadastro_cor` c,
                                             `cadastro_usuario` u,
                                             `cadastro_tipo` tp
                                       WHERE a.c_tamanho = t.t_id
                                         AND a.c_raca = r.r_id
                                         AND a.id_cor = c.c_id
                                         AND a.c_usuario = u.u_id
                                         AND r.r_tipos = tp.t_id                                         
                                         AND a.c_finalizado = 0
                                    ORDER BY a.c_data DESC";
                $sql_animais = $mysqli->query($query_animais) or die($mysqli->error);
               ?>               

               <script>

                var mymap = L.map('mapid').setView([-21.4209, -50.078], 14);   

                L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                }).addTo(mymap);

                var iconachado = L.icon({
                    iconUrl: './img/achado.png',
                    iconSize: [38,60],
                });

                var iconperdido = L.icon({
                    iconUrl: './img/perdido.png',
                    iconSize: [38,60],
                });               
                   
                <?php
                        $animais_row = 1;
                        while ($animais = $sql_animais->fetch_array()){              
                ?>
                // DADOS MARCADOR PET PERDIDO
                var pontos = [{"latitude":"-21.416483360170187","longitude":"-50.07927415722406", "nome":"teste"}];

                var indicePonto = 0;
                pontos.forEach(function(ponto) {
                    indicePonto++;               
                    
                    // CRIANDO MARCADOR
                    var markerLeaflet = L.marker(
                        [<?php echo $animais['c_latitude']; ?>, <?php echo $animais['c_longitude']; ?>],
                        <?php if ($animais['c_situacao'] == 1) { ?>
                        {icon: iconachado}
                        <?php } else { ?>
                        {icon: iconperdido}
                        <?php } ?>                       
                        ).addTo(mymap)
                        .bindPopup("<b><?php echo $animais['c_nomeanimal']; ?> - <?php echo $animais['r_nome']; ?></b><br>" +
                        "<img src='upload/<?php if ($animais['c_foto'] != ""){ echo $animais['c_foto']; } else { echo "sem_imagem.png";}?>' style='width: 100px; height: 80px;'>");   
                    });
                // FIM DADOS MARCADOR PET PERDIDO
                <?php
                        $animais_row ++;
                        }
                ?>          
              
                </script>            
               
            </div>
        </section>
        <!-- FIM Mapas -->

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

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>

    </body>
</html>