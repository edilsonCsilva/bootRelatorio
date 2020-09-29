<?php
session_start();
require_once(__DIR__."/vendor/autoload.php");
use Stilldistribuidora\Repository\Index\Calendar;
use Stilldistribuidora\Repository\Index\Operation;
use Stilldistribuidora\Repository\Index\Points;
use Stilldistribuidora\Res\Values\StringPtBr;
  $currentDate=date("Y-m-d");
  $StringPtBr=new StringPtBr();
  $calendario=new Calendar();
  $operacaoModel=new Operation();
  $pointModel=new Points();




  if(!isset($_SESSION["month"])){
     $_SESSION["month"]=date("m");
     $_SESSION["year"]=date("Y");
  }
try{
  if(isset($_POST["researchDateString"]) && strlen(trim($_POST["researchDateString"]))!=0){
    $newmonthYear=explode("/",$_POST["researchDateString"]);
    $_SESSION["month"]=$newmonthYear[0];
    $_SESSION["year"]=$newmonthYear[1];
    header("location:index.php");
    exit();
  }
  $days=$calendario->limitOfThemonthToDays($_SESSION["month"],$_SESSION["year"]);

}catch(Exception $e){
  $_SESSION["month"]=date("m");
  $_SESSION["year"]=date("Y");
  header("location:index.php");
  exit();
}





 

?>

<!doctype html>
<html lang="pt-br">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css" >
    <link rel="stylesheet" href="helper/css/calendar.css" >


    <title>Hello, world!</title>
  </head>
  <body>
    <h1>Hello, world!</h1><div class="fixed-top">
    <div class="collapse" id="navbarToggleExternalContent">
        <div class="bg-dark p-4">
        <h5 class="text-white h4"><?php echo $StringPtBr->getString("str_title_menu");?></h5>
        <span class="text-muted"><?php echo $StringPtBr->getString("str_title_seach");?>  </span>
        

        <div class="row">
          <div class="col-12">
           <br> 
              <form class="form-inline" method="POST">
                <div class="form-group mx-sm-3 mb-2">
                  <input type="text" class="form-control" 
                  value="<?php echo sprintf("%s/%s",$_SESSION["month"],$_SESSION["year"]); ?>" 
                  name="researchDateString" id="researchDateString" >
                </div>
                <button type="submit" class="btn btn-primary mb-2">Consultar</button>
              </form>


          



          </div>
       </div>  




        </div>
    </div>
    <nav class="navbar navbar-dark bg-dark">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>


        <a class="navbar-brand" href="#"><?php echo sprintf("%s de %s",$calendario->getMonthActive(),$_SESSION["year"])   ;?></a>

       
    </nav>
    </div>

    <div class="container">

    
    <div class="row row-cols-1">
     <?php foreach( $days as $key => $day){?>
    <?php
      $activeDayClass="";
      $data=sprintf("%s-%s-%s",$_SESSION["year"],
      str_pad($_SESSION["month"], 2, '0',STR_PAD_LEFT),
      str_pad($day["day"], 2, '0',STR_PAD_LEFT) );
      if($currentDate==$data){$activeDayClass="card-custom-active";}
      $summaryTheOperations=$operacaoModel->operationSummaryByDate($data);
      $occurrenceOfTheDay=sprintf("view.php?dt=%s",$data);


        
        
    ?>
     
          <div class="col"  >
            
              <div class="card card-custom <?php echo $activeDayClass;?>" >
                    <div class="card-body">
                        <div class="card-header">
                          <div class="header-custom "> <?php  echo $day["name"];?></div>
                        </div>
                        <h5 class="card-title"><span class="display-day"><?php echo $day["day"];?></span></h5>
                        <table class="table">
                          <thead>
                            <tr  class="text-center" > 
                            <th scope="col"><img class="small-ico" src="helper/sysimgs/fluxo50px.png" title="Operações"></th>
                              <th scope="col"><img class="small-ico" src="helper/sysimgs/photo50px.png" title="Fotos"></th>
                              <th scope="col"><img class="small-ico" src="helper/sysimgs/point50px.png" title="Pontos"></th>
                              
                            </tr>
                          </thead>
                          <tbody>

                            <tr class="text-center">
                            <td><?php echo $summaryTheOperations["summaryOfTheOperation"];?></td>
                              <td><?php echo $summaryTheOperations["summaryOfThePhotos"];?></td>
                              <td><?php echo $summaryTheOperations["summaryOfThePonts"];?></td>
                            </tr>
                          </tbody>
                        </table>
                    </div>

                    <div class="card-footer bg-transparent ">
                      <?php if($summaryTheOperations["summaryOfTheOperation"]!=0){ ?>
                      <a href="<?php echo $occurrenceOfTheDay; ?>" class="btn btn-danger  btn-block" title="Visualizar Operação..!">
                        <img class="small-ico small-ico-25" src="helper/sysimgs/maps50px.png" title="Operações"> &nbsp;Visualizar</a>
                      <?php }else{ ?>
                        &nbsp;
                      <?php } ?>
                    </div>

            </div>

          
          
        
        
          </div>
      
    
     <?php } ?> 
     </div>



    </div>





    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.1/js/bootstrap.min.js" integrity="sha384-XEerZL0cuoUbHE4nZReLT7nx9gQrQreJekYhJD9WNWhH8nEW+0c5qq7aIo2Wl30J" crossorigin="anonymous"></script>
      
    <script src="//code.jquery.com/jquery-2.1.4.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.4.1/jquery.maskedinput.min.js"></script>
    <SCRIPT language="javascript">
     $(document).ready(function () {
        $('#researchDateString').mask('99/9999');
        return false;
    });
    </SCRIPT>
  
  
  
  
  </body>
</html>