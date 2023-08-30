<?php

  if (!isset($_SESSION)) session_start();

  require_once"conexao.php";

  if (!isset($_SESSION['usuarioId'])) {
       session_destroy();      
       header("Location: usuario.php"); exit;
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
                <h1 class="h2">Área do usuário</h1>           
            </div>
   
            <!-- MENSAGEM RESULTADO DO CADASTRO: SUCESSO OU ERRO -->
            <?php
                if (isset($_SESSION["cadastro_animais"])){
                    if ($_SESSION["cadastro_animais"] == 1){
                        echo '<div class="alert alert-success" role="alert">
                            Animal cadastrado com Sucesso!
                            </div>';
                    } elseif ($_SESSION["cadastro_animais"] == -1){
                        echo '<div class="alert alert-danger" role="alert">
                            Ocorreu um erro ao cadastrar o animal. Por favor, tente novamente!<br>' . 
			                $_SESSION['msg'] . '
                            </div>';
                    } elseif ($_SESSION["cadastro_animais"] == -2){
                        echo '<div class="alert alert-danger" role="alert">
                            Erro ao Salvar Arquivo. Por favor, tente novamente!
                            </div>';
                    } elseif ($_SESSION["cadastro_animais"] == -3){
                        echo '<div class="alert alert-danger" role="alert">
                            Formato de Arquivo não suportado. Por favor, tente novamente!
                            </div>';
                    }
                }
            ?>

            <form action="processa_cadastro_animais.php" method="post" enctype="multipart/form-data">

                <!-- SITUACAO DO ANIMAL -->
                <div class="mb-3">
                    <p>Qual a situação você deseja publicar?</p>
                    <div class="form-check form-check-inline">
                        <input type="radio" class="form-check-input" id="encontrado" name="situacao" value="1">
                        <label for="encontrado" class="form-check-label">Encontrei um animal</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio" class="form-check-input" id="perdido" name="situacao" value="2">
                        <label for="perdido" class="form-check-label">Meu animal está perdido</label>
                    </div>
                </div>

                <!-- NOME DO ANIMAL -->
                <div class="mb-3">
                    <label for="nome" class="form-label">Nome do Animal:</label>
                    <input type="text" class="form-control" maxlength="250" id="nome" name="nome" required>
                </div>

                <!-- FOTO DO ANIMAL -->
                <div class="mb-3">
                    <label for="foto" class="form-label">Envie uma foto:</label>
                    <input type="file" class="form-control" accept=".png, .jpg, .jpeg" id="foto" name="foto">
                </div>

                <!-- DESCRICAO DO ANIMAL -->
                <div class="mb-3">
                    <label for="descricao" class="form-label">Descrição:</label>
                    <textarea rows="5" class="form-control" id="descricao" name="descricao" required placeholder="Descreva o animal, suas condições ou dê qualquer informação que julgue importante. Cada detalhe pode ser importante!"></textarea>
                </div>

                <!-- TIPO DO ANIMAL -->
                <div class="mb-3">
                    <label for="tipo" class="form-label">Espécie do Animal: </label>
                    <select class="form-select" id="tipo" name="tipo">
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
                <div class="mb-3">
                    <label for="raca" class="form-label">Raça: </label>
                    <select class="form-select" id="raca" name="raca">
                        <option disabled selected value="">Selecione uma Opção</option>';
                    </select>
                </div>
                
                <!-- TAMANHO DO ANIMAL -->
                <div class="mb-3">
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
                <div class="mb-3">
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

                <!-- SELECAO DO ENDERECO -->                
                <div class="row">
                    <div class="mb-3">
                        <div id="mapid" style="width: 100%; height: 400px;"></div>
                    </div>
                    <div class="mb-3">
                        <div class="form-group">
                            <label>Latitude:</label>
                            <input class="form-control" id="latitude" name="latitude" readonly>
                        </div>
                        <div class="form-group">
                            <label>Longitude:</label>
                            <input class="form-control" id="longitude" name="longitude" readonly>
                        </div>
                    </div>
               </div>        
               
               <script>
               var mymap = L.map('mapid').setView([-21.4209, -50.078], 13);       

                L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                }).addTo(mymap);

                //capturando coordenadas automaticas
                var latInput = document.querySelector("[name=latitude]");
                var lngInput = document.querySelector("[name=longitude]");

                var curLocation = [-21.4209, -50.078];

                mymap.attributionControl.setPrefix(false);

                var marker = new L.marker(curLocation, {
                    draggable: 'true',
                });

                marker.on('dragend', function(event) {
                    var position = marker.getLatLng();
                    marker.setLatLng(position, {
                        draggable: 'true',   
                    }).bindPopup(position).update();
                    $("#latitude").val(position.lat);
                    $("#longitude").val(position.lng);
                });
                mymap.addLayer(marker);

                mymap.on("click", function(e){
                    var lat = e.latlng.lat;
                    var lng = e.latlng.lng;
                    if (!marker)
                    {
                        marker = L.marker(e.latlng).addTo(mymap);
                    } else {
                        marker.setLatLng(e.latlng); 
                    }
                    latInput.value=lat;
                    lngInput.value=lng;
                });

                </script>    
                <!-- FIM SELECAO DO ENDERECO -->            
               
                <!-- CONTATO -->
                <div class="mb-3">
                    <label for="contato" class="form-label">Contato:</label>
                    <input type="text" class="form-control" maxlength="200" id="contato" name="contato" placeholder="Informe como as pessoas poderão entrar em contato.">
                </div>

                <!-- BOTAO ENVIA -->
                <input type="submit" class="btn btn-primary" value="Enviar">
            </form>
                       
            </div>
            </main>
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

<?php
    unset($_SESSION["cadastro_animais"]);
?>