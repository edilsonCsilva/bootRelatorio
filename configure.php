<?php
 
session_start();
require_once(__DIR__."/vendor/autoload.php");
require_once("env.php");
 
use Stilldistribuidora\Libs\Arquivo;
use Stilldistribuidora\Res\Libs\Libs;
use Stilldistribuidora\Res\Values\StringPtBr;
use Stilldistribuidora\Repository\Index\Points;
use Stilldistribuidora\Repository\Index\Operation;
use Stilldistribuidora\Repository\Entity\Operation as EntityOperation;


$re = '/(operations=[0-9]+)/m';
$str =$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"];
preg_match_all($re, $str, $matches, PREG_SET_ORDER, 0);
if(count($matches)===0){ header("location:index.php");    exit();}  
$operationUuid=substr($matches[0][0],strpos($matches[0][0],"=")+1,strlen($matches[0][0]));
if(strlen(trim($operationUuid)) == 0){ header("location:index.php");    exit();}
$StringPtBr=new StringPtBr();
$operacaoModel=new Operation();
$pointModel=new Points();
$operations=$operacaoModel->operationByUuid($operationUuid);

$operacaoModel->addActiveOperationByIp($operationUuid,"{}");

$associatedCustomers=json_decode($operations[0]->getDelivery_raw(),true);
$photoOperations=Arquivo::getFilesToDir(PATH_FILES_FOTOS,$operationUuid,PATH_FILES_TYPE_IMGS_VALID);
$photoScreenPrint=Arquivo::getFilesToDir(PATH_FILES_PRINT_SCREEN,$operationUuid,PATH_FILES_TYPE_IMGS_VALID);
$coordinatesOfOperations=Arquivo::readFiles(Arquivo::getFilesToDir(PATH_FILES,$operationUuid,PATH_FILES_TYPE_POINTS_VALID)[0]);


if(isset($_POST["ACTION"]) &&   $_POST["ACTION"]=="CREATE_REPORT_OPERATIONS"){
    $data=array(
      'ACTION'=>$_POST["ACTION"],
      'delivery'=>$_POST["delivery"],
      'screens'=>$_POST["screens"],
      'photos'=>$_POST["photos"],
      'info'=>$operacaoModel->getDetailOperations($operationUuid)[0],
      'client'=>$_POST["client"],
    );
    $_SESSION["DATA"]=base64_encode(serialize($data));
    
  $go_to_url="pdf/relatorio1.php";
  echo "<script>window.open('".$go_to_url."', '_blank');</script>";
  //header(sprintf("location:configure.php?operations=%s",$operationUuid));
  //exit();


}

//Libs::dd($coordinatesOfOperations);
//Libs::dd($photoScreenPrint);
//Libs::dd($photoOperations);
//Libs::dd($associatedCustomers);
//Libs::dd($operations);

?>

<!doctype html>
<html lang="pt-br">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css" >
    <link rel="stylesheet" href="helper/css/operation.css" >
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAfExgkDk1YVKNStBloZjL8kjzM9Ym48wc&callback=initMap&libraries=&v=weekly"
      defer
    ></script>
    
    <style type="text/css">
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height:100%;
        width: 99%;
        border: 1px solid #000;
        margin-left:2px;;
      }
      /* Optional: Makes the sample page fill the window. */
      html,
      body {
        height: 100%;
      }
    </style>
   <title>Hello, world!</title>
  </head>
  <body>
    <h1>Hello, world!</h1><div class="fixed-top">
    <div class="collapse" id="navbarToggleExternalContent">
        <div class="bg-dark p-4">
        <a href="index.php">    
        <h5 class="text-white h4"><?php echo $StringPtBr->getString("str_title_menu");?></h5>
        </a>
        <span class="text-muted"><?php echo $StringPtBr->getString("str_detail_operations_date_selected");?>  </span>
            <div class="row">
              <div class="col-12">
                
              </div>
          </div>  
        </div>
    </div>
    <nav class="navbar navbar-dark bg-dark">
        <button class="navbar-toggler" type="button"  data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
    </nav>
    </div>

    <div id="map"></div>

    <div class="container">
       
        <form action=" " method="post" id="form_continue">
          <input type="hidden" name="ACTION" value="CREATE_REPORT_OPERATIONS" />
          <input type="hidden" name="delivery" value="<?php echo $operationUuid; ?>" />
                  <br>

          
                <div class="row">
                      <div class="col-md-12 FaseImg">
                        <a href="javascript:void(0)" data-target="#exampleModal"  data-toggle="modal" class="btn btn-danger">Carregar Foto do Mapa.</a>
                      </div>
                </div> 
                
                <input  type="hidden" id="store_rel" name="store_rel" value="<?php echo $associatedCustomers["store_rel"];?>" />
                <div class="container-fluid">
                        <div class=""> 
                        <br>
                                <div class="row">
                                    <div class="col-sm-12">
                                    <div class="form-group">
                                      <label for="exampleInputEmail1"><?php echo $StringPtBr->getString("str_detail_operations_customens_associated");?></label>
                                            <select name="client" id="client"  class="form form-control" >
                                            <option value="<?php echo $index;?>" value="-1" > Selecione o Cliente  </option>
                                              <?php foreach($associatedCustomers["storeinfo"] as $index=> $associated){  ?>
                                                <option value="<?php echo $index;?>" class="boxs" data-role="<?php echo $index;?>">
                                                <img src="<?php echo $associated[2];?>">
                                                <?php echo strtoupper(sprintf("%s    %s - %s ",(1+$index), $associated[1],$associated[0]));?></option>
                                              <?php }?>
                                            </select>

                                            

                                    </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12"><hr></div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">
                                      
                                        <table class="table">
                                              <tbody class="content">
                                                <?php foreach($photoScreenPrint as $uuid=>$print){?> 
                                                    <tr>
                                                            <td>
                                                            <div class="card" style=" width: 16rem;">
                                                                <img style="padding: 5px;" data-role="<?php echo $print;?>" src="<?php echo $print;?>" class="img-thumbnail fullScreenPrint" alt=" ">
                                                                <div class="card-body">
                                                                <h6 style="left:25px;">Captura :<?php echo $uuid+1;?></h6>
                                                                    <p class="card-text"><input type="checkbox" `+select+`  value="<?php echo $print;?>" name="screens[]" data-role="<?php echo $uuid;?>" class="print_select" /> Selecionar</p>
                                                                </div>
                                                            </div>
                                                            
                                                            </td>
                                                    </tr>
                                                <?php } ?>      
                                                                                  
                                              </tbody>

                                        </table>
                                    </div> 
                                    <div class="col-9">
                                            <div class="alert alert-danger text-center" role="alert">
                                              Fotos da Operação
                                            </div>
                                                  <table class="table tab-content " >

                                                  <?php 
                                                                      $i=0; 
                                                                      foreach($photoOperations as $key=>$img){
                                                                  ?>
                                                                      <?php if($i==0){echo "<tr >";}?>
                                                                              <td>
                                                                                      <div class="card" style=" width: 12rem;">
                                                                                              <img style="padding: 5px;" style=" width: 12rem;" src="<?php echo $img;?>" class="card-img-top" alt="...">
                                                                                              <div class="card-body">
                                                                                                  <p class="card-text"><input type="checkbox" name="photos[]" value="<?php echo $img;?>"  data-role="<?php echo $img;?>" class="photos_operations" /> Selecionar</p>
                                                                                              </div>
                                                                                      </div>
                                                                              </td>
                                                                      <?php 
                                                                          $i++;
                                                                          if($i>3){echo "</tr>"; $i=0;} ?>
                                                                      <?php }?>

                                                              
                                                  </table>
                                            </div>
                                </div>
                        </div>    
                        <div class="row">
                          <div class="col-sm-12">
                              <hr>                                           
                          </div>
                        </div>


                        <div class="row">
                          <div class="col-sm-12">
                              <input type="button" class="btn btn-info btn-block" id="btn_continue_process" value="Criar Relatorio.."/>                                       
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-sm-12">
                              <br>                                           
                          </div>
                        </div>

                </div>


        </form>

        
    </div>


<!-- Modal -->


<form method="POST" action="loadScreenPrintMaps.php" enctype="multipart/form-data" id="fwb_up_screen">
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
                 <input type="hidden" name="txt_delivery" value="<?php echo $operationUuid;?>" />
                 <div class="form-group">
                      <label for="exampleInputEmail1">Selecione as Imagens do Mapa. </label>
                      <input type="file" name="file[]" multiple="multiple" class="form-control" />
                   
                      <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                  </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <input type="submit" class="btn btn-primary" id="btn-upload"  value="Save changess"   />
      </div>
    </div>
  </div>
</div>
</form>

 

    



    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.1/js/bootstrap.min.js" integrity="sha384-XEerZL0cuoUbHE4nZReLT7nx9gQrQreJekYhJD9WNWhH8nEW+0c5qq7aIo2Wl30J" crossorigin="anonymous"></script>
      
    <script src="//code.jquery.com/jquery-2.1.4.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.4.1/jquery.maskedinput.min.js"></script>

    <?php echo sprintf("<script>var coodenadosDoMap='%s';</script>",$coordinatesOfOperations[0]); ?>
    <SCRIPT language="javascript">

        var pointMarker=[];    
        var map=null;
        var photoScreenPrint=0;
        var printScreen=[],printScreen_img=[],photos_operations=[],checked=-1;

        function initMap() {
                    var dataObjmaps=JSON.parse(coodenadosDoMap);
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
                          mapTypeId: google.maps.MapTypeId.ROADMAP,
                          fullscreenControl:true,
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
            setInterval(function(){
              checkIfYouHaveScreenPrint();
            },5000);
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



        

        function checkIfYouHaveScreenPrint(){
           
          var paramets={"operationUuid":"<?php echo $operationUuid;?>"};
                  $.post("loadScreenPrint.php",paramets, function(response){
                      console.log(response)
                      if(photoScreenPrint !=response.sumNewPhotoPrint){
                         photoScreenPrint=response.sumNewPhotoPrint;
                         $(".content").html("")
                          var row="";
                          for(var i=0;i < photoScreenPrint;i++){
                            var imagem=response.files[i];
                            if(printScreen_img.indexOf(imagem)==-1){
                               
                                console.log(imagem)
                                var select="";
                                try{if(printScreen[i].selected){ select="checked";}}catch(e){}
                                
                                row+= `<tr>
                                        <td>
                                        <div class="card" style=" width: 16rem;">
                                            
                                            <img style="padding: 5px;" data-role="`+imagem+`" src="`+imagem+`" class="img-thumbnail fullScreenPrint" alt=" ">
                                            <div class="card-body">
                                            <h6 style="left:25px;">Print :`+(1+i)+`</h6>
                                                <p class="card-text"><input type="checkbox" `+select+`  value="`+imagem+`" name="screens[]" data-role="`+i+`" class="print_select" /> Selecionar</p>
                                            </div>
                                        </div>
                                        
                                        </td>
                                    </tr>
                                    ` ;

                                  printScreen.push({"selected":false,"screen":imagem});
                                  printScreen_img.push(imagem)


                              }
                              $(".content").html(row);
                                $(".print_select").on("click",function(){
                                    if(printScreen[$(this).attr("data-role")].selected){
                                      printScreen[$(this).attr("data-role")].selected=false;
                                      return
                                    }
                                    printScreen[$(this).attr("data-role")].selected=true
                                });

                                $(".photos_operations").on('click',function(){
                                    var photo=$(this).attr("data-role");
                                    var index = photos_operations.indexOf(photo);
                                    if(index==-1){
                                        photos_operations.push(photo);
                                    }else{
                                        photos_operations.splice(index, 1);
                                    } 
                                    console.log(photos_operations)
                                });
                                


                           }



                          
                          
                      }
                      
                      
                      
                  },"json");

      }

    
    
    
    
    
    
    
    
    
   
   
    </SCRIPT>

    <script>
      $(document).ready(function(){
        $("#client").change(function(){
          checked=$(this).val();
        });
        $("#btn_continue_process").on("click",function(){
                        var hasSelectPhotoScreen=false;
                        for(var i=0;i < printScreen.length;i++){
                            if(printScreen[i].selected){
                              hasSelectPhotoScreen=true;
                              break;
                              }
                        }
                        if(checked===-1){
                            alert("Selecione um Cliente Para Continuar..")
                            return
                        }
                        if(!hasSelectPhotoScreen){
                          alert("Selecione uma ou Mais Imagem(s) de Print..")
                            return
                        }
                        $("#form_continue").submit();
                  });

      });
    </script>



      <script src="./jquery-3.5.1.min.js"></script>

      <script src="./html2canvas.min.js" ></script>
       
  
      <script>

        $(document).ready(function(){
          $("#fwb_up_screen").submit(function(event){
            
            //event.preventDefault();

            var data = new FormData();
                data.append('fileimagem', $('#files')[0].files[0]);

                $.ajax({
                    url: 'loadScreenPrintMaps.php',
                    data: data,
                    processData: false,
                    contentType: false,
                    type: 'POST',
                    success: function(data) 
                    {
                        alert(data);
                    }
                });

             




            
              
           });




 


             



      
        });
        </script>
  
  
  
  </body>
</html>