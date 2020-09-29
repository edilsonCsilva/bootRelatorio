<?php
session_start();
require_once(__DIR__."/vendor/autoload.php");
use Stilldistribuidora\Res\Libs\Libs;
use Stilldistribuidora\Res\Values\StringPtBr;
use Stilldistribuidora\Repository\Index\Points;
use Stilldistribuidora\Repository\Index\Operation;
use Stilldistribuidora\Repository\Entity\Operation as EntityOperation;


$re = '/dt=[0-9]{4}-[0-9]{2}-[0-9]{02}/m';
$str =$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"];
preg_match_all($re, $str, $matches, PREG_SET_ORDER, 0);
if(count($matches)===0){ header("location:index.php");    exit();}  
$data=substr($matches[0][0],strpos($matches[0][0],"=")+1,strlen($matches[0][0]));
$data=explode("-",$data);
 
if(!checkdate($data[1],$data[2],$data[0])){ header("location:index.php");    exit();}


$StringPtBr=new StringPtBr();
$operacaoModel=new Operation();
$pointModel=new Points();
$operations=$operacaoModel->operationByDate(sprintf("%s-%s-%s",$data[0],$data[1],$data[2]));

?>

<!doctype html>
<html lang="pt-br">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="vendor/components/jquery/jquery.js" ></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css" >
    <link rel="stylesheet" href="helper/css/operation.css" >


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
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
    </nav>
    </div>

    <div class="container-fluid">
    <div class="row" >
          <div class="col-12">
          <div class="alert alert-primary table-active" role="alert">
             <?php echo sprintf($StringPtBr->getString("str_detail_operations_date_selected_info"),
            sprintf("%s/%s/%s",$data[2],$data[1],$data[0]));?>
          </div>

          </div>
       </div>

        <div class="row" >
          <div class="col-sm-12">
            <table class="table table-active table-striped table-bordered ">
                <thead class="thead-dark">
                  <tr class="table-primary">
                    <th scope="col">#</th>
                    <th scope="col">Uuid.Delivery</th>
                    <th scope="col">Status</th>
                    <th scope="col">Dt.Criação</th>
                    <th scope="col">Dt.Process</th>
                    <th scope="col" colspan="2">&nbsp;</th>

                  </tr>
                </thead>
                <tbody>
                  <?php 
                  foreach($operations as $index => $operation){
                   //$operations=new EntityOperation();
                  ?>
                  <tr>
                    <th scope="row"><?php echo $index+1?></th>
                    <td><?php echo $operation->getDelivery_id();?></td>
                    <td><div class=" " role="">
                      <?php echo $operacaoModel->getStatusLabel($operation->getStatus());?>
                      </div>
                    </td>
                    <td><?php echo $operation->getDt_processed();?></td>
                    <td><?php echo $operation->getDt_processing();?></td>
                    <td>

                      <div class="row">
                        <div class="col-sm-6">
                          <a href="configure.php?operations=<?php echo $operation->getDelivery_id();?>">
                            <img class="small-ico small-ico-25" src="helper/sysimgs/point50px.png" title="Pontos">
                          </a>
                        </div>
                        <div class="col-sm-6">
                        <a href="javascript:void(0)" class="btn-files" data-role="<?php echo $operation->getDelivery_id();?>">
                          <img class="small-ico small-ico-25" src="helper/sysimgs/photo50px.png" title="Pontos">
                        </a>
                        </div>
                      </div>

                   
                    </td>
                  </tr>
                  <?php }?>  
                 


                </tbody>
              </table>

              
            
 
              <?php require_once("modais/file_type_modal.php");?>
   
              
            

            </div>
       </div>
     </div>
    </div>

    
    
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.1/js/bootstrap.min.js" integrity="sha384-XEerZL0cuoUbHE4nZReLT7nx9gQrQreJekYhJD9WNWhH8nEW+0c5qq7aIo2Wl30J" crossorigin="anonymous"></script>
      
    <script src="//code.jquery.com/jquery-2.1.4.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.4.1/jquery.maskedinput.min.js"></script>
    <SCRIPT language="javascript">

      $(document).ready(function(){

         $(".btn-files").on("click",function(){
                       
                          
          $("#files").show();
               $("#txt_delivery").val($(this).attr("data-role"))
               //alert($(this).attr("data-role"))
          });
                        
        
        
        
        
        
        
      });
  
    
    </SCRIPT>
  
  
  
  
  </body>
</html>