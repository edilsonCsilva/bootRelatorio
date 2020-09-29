<?php
if(!isset($_GET["operation"]) ||  strlen(trim($_GET["operation"]))==0 ){
  echo "<h1>Operação Invalida..</h1>";
  exit();
}
$operation=$_GET["operation"];
$pathFiles=__DIR__."/../../files/";
$file_raw=file(sprintf("%s%s/%s.json",$pathFiles,$operation,$operation));
 
 

?>
<!DOCTYPE html>
<html>
  <head>
   <script src="assets/jquery-3.5.1.min.js"></script>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=yes">
    <meta charset="utf-8">
    <title>Polygon Arrays</title>
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>

    
  </head>
  <body>
    <div id="writeContent"></div>
    <div id="map"></div>
      
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAfExgkDk1YVKNStBloZjL8kjzM9Ym48wc&callback=initMap&libraries=visualization">
    </script>
      <?php echo sprintf("<script>var teste='%s';</script>",$file_raw[0]); ?>


<script>
    // This example creates a simple polygon representing the Bermuda Triangle.

  var pointMarker=[];    
  var map=null;
  function initMap() {
    var dataObjmaps=JSON.parse(teste);
    var triangleCoords = [];
    zonasLength=dataObjmaps.zonas.length
    for(var i=0;i<zonasLength;i++){
      triangleCoords.push({lat:parseFloat(dataObjmaps.zonas[i].lat), lng: parseFloat(dataObjmaps.zonas[i].lon) })
    }

    if(zonasLength==0){
        var point=dataObjmaps.points[0]
        map = new google.maps.Map(document.getElementById("map"), {
        zoom: 14,
        center: {lat:parseFloat(point[0].latitude),lng:parseFloat(point[0].longitude)},
        disableDefaultUI: true,
        mapTypeId: google.maps.MapTypeId.ROADMAP
      });
    }else{

        map = new google.maps.Map(document.getElementById("map"), {
          zoom: 14,
          center: triangleCoords[0],
          disableDefaultUI: true,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        });
        // Construct the polygon.
        var bermudaTriangle = new google.maps.Polygon({
          paths: triangleCoords,
          strokeColor: "#FF0000",
          strokeOpacity: 0.8,
          strokeWeight: 0,
          fillColor: "#FF0000",
          fillOpacity: 0.35
        });
        bermudaTriangle.setMap(map);
    }

    console.log(dataObjmaps);
      


    
    setPoint(dataObjmaps.points[0]);
  }



    //create number of markers based on collection.length
    function setPoint(poitss){


        var pointMarkerImage=[];
        
        for(var i=0; i<poitss.length; i++){

          var icon = {
          url: 'points/vermelho.svg', // url
          scaledSize: new google.maps.Size(50, 50), // scaled size
          origin: new google.maps.Point(0,0), // origin
          anchor: new google.maps.Point(0, 0) // anchor
      };

          pointMarkerImage[i] = new google.maps.MarkerImage('points/vermelho.svg');
          pointMarker[i] = new google.maps.Marker({
                  position: {lat:parseFloat(poitss[i].latitude),lng:parseFloat(poitss[i].longitude)},
                  map: map,
                 // icon: pointMarkerImage[i],
                  icon:icon,
                  //animation: google.maps.Animation.BOUNCE,
                  title: "ID:"+ poitss[i].id
          });

          google.maps.event.addListener(pointMarker[i], 'click', function(){
            window.open("blog/page01.html","_blank","toolbar=yes, location=yes, directories=no, status=no, menubar=yes, scrollbars=yes, resizable=yes, copyhistory=yes");
          }
          );
        }
      }





  </script>


  </body>
</html>