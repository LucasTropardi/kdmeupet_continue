<!DOCTYPE html>
<html lang="pt">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <title>KD meu PET?</title>  
           
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>    
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700" rel="stylesheet" type="text/css" />        
        <link href="css/styles.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css"> 
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
       
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.2/dist/leaflet.css"
        integrity="sha256-sA+zWATbFveLLNqWO2gtiw3HL/lh1giY/Inf1BJ0z14="
        crossorigin=""/>
        <script src="https://unpkg.com/leaflet@1.9.2/dist/leaflet.js"
        integrity="sha256-o9N1jGDZrf5tS+Ft4gbIK7mYMipq9lqpVJ91xHSyKhg="
        crossorigin=""></script>           

    </head>
    <body>        
        
            <!-- Achados -->      

               <div class="row">
                    <div class="col-sm-7">
                        <div id="mapid" style="width: 100%; height: 600px;"></div>
                    </div>
                    <div class="col-sm-5">
                        <div class="form-group">
                            <label>Latitude</label>
                            <input class="form-control" id="latitude" name="latitude">
                        </div>
                        <div class="form-group">
                            <label>Longitude</label>
                            <input class="form-control" id="longitude" name="longitude">
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

                   
        <!-- FIM Achados -->

        

    </body>
</html>