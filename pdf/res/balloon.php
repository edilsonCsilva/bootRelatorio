<?php
session_start();
$data=unserialize(base64_decode($_SESSION["DATA"]));
$info=json_decode($data["info"]["delivery_raw"],true);
$clientSelectd=$info["storeinfo"][$data["client"]];
$dataoperation=$data["info"]["dt_processing"];
$avatar=$clientSelectd[2];
$area=sprintf("%s - %s",$info["area"][0]["id"],$info["area"][0]["name"]);

?>

<style type="text/css">

/* Image centering */
.image-container {
  display: flex;
  justify-content: center;
}

div.minifiche
{
    position:    relative;
    overflow:    hidden;
    width:       454px;
    height:      138px;
    padding:     0;
    font-size:   11px;
    text-align:  left;
    font-weight: normal;

   
}
div.minifiche img.icone    { position: absolute; border: none; left: 5px;   top: 5px;  width: 240px; height: 128px;overflow: hidden; }
div.minifiche div.zone1    { position: absolute; border: none; left: 257px; top: 8px;  width: 188px; height: 14px; padding-top: 1px; overflow: hidden; text-align: center; font-weight: bold; }
div.minifiche div.zone2    { position: absolute; border: none; left: 315px; top: 28px; width: 131px; height: 14px; padding-top: 1px; overflow: hidden; text-align: left; font-weight: normal; }
div.minifiche div.zone3    { position: absolute; border: none; left: 315px; top: 48px; width: 131px; height: 14px; padding-top: 1px; overflow: hidden; text-align: left; font-weight: normal; }
div.minifiche div.zone4    { position: absolute; border: none; left: 315px; top: 68px; width: 131px; height: 14px; padding-top: 1px; overflow: hidden; text-align: left; font-weight: normal; }
div.minifiche div.zone5    { position: absolute; border: none; left: 315px; top: 88px; width: 131px; height: 14px; padding-top: 1px; overflow: hidden; text-align: left; font-weight: normal; }
div.minifiche div.download { position: absolute; border: none; left: 257px; top: 108px;width: 188px; height: 22px; overflow: hidden; text-align: center; font-weight: normal; }
.img{border: 2px solid #0000;;}
.img .img-td{position: relative; width: 310px;height: 250px; }
.title{color:red;left: 5px;}
</style>
<page>
    <table style="width: 100%">
        <tr>
            <td style="text-indent: 10mm; border: solid 1px #007700; width: 80%">
                <table>
                     <tr>
                        <td style="text-align:center;"><b>&nbsp;&nbsp;Dt.Processamento : </b></td>
                        <td><?php echo date("d/m/Y h:m:s");?></td>
                    </tr>
                    <tr><td ></td> </tr>
                    <tr>
                        <td style="text-align:center;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;<b>Cliente(Rede):</b></td>
                        <td><?php echo(sprintf("%s - (%s)",$clientSelectd[1],$clientSelectd[0]));?></td>
                    </tr>
                    <tr><td ></td> </tr>
                    <tr>
                        <td style="text-align:center;">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;<b>
                             Dt. Operação:</b></td>
                        <td><?php echo $dataoperation;?></td>
                    </tr>
                    <tr><td ></td> </tr>
                    <tr>
                        <td style="text-align:center;"><b>
                        &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp; Loja : </b></td>
                        <td><?php echo(sprintf("(%s)",$clientSelectd[0]));?></td>
                    </tr>
                    <tr><td ></td> </tr>

                    <tr>
                        <td style="text-align:center;"><b>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;Setor:</b></td>
                        <td><?php echo $area;?></td>
                    </tr>
                    </table>
            </td>
            <td style="border: solid 1px #000077; width: 20%">
               
            </td>
        </tr>
    </table>
    <hr>
    <table >
        <?php 
             $row=0;
             $display=2;
        ?>
        <?php foreach($data["photos"] as $key=>$photo){ ?>

        <?php
         if($row==0){
             echo "<tr>";
         }
        ?>
                
                <td style="text-indent: 10mm; border: solid 1px #007700; width: 80% ;padding:35px;">
                    <div class="img">
                        <span class="title" >Ponto <?php echo ($key+1);?></span>  
                        <img class="img-td" src="../<?php echo $photo;?>"/>
                    </div>
                </td>
        <?php
        
          $row++;   
          if($row ==$display){
              echo("</tr>");
              $row=0;
          }       
               
        ?>
        <?php } 
         if((count($data["photos"])%$display >0)){echo("</tr>");}   
          
        ?>
    </table>
 </page>




<?php foreach($data["screens"] as $key=>$photo){ ?>
 
    <page orientation="paysage">

            <table style="width: 100%">
                <tr><td>&nbsp;</td></tr>
                <tr><td>&nbsp;</td></tr>
                <tr><td>&nbsp;</td></tr>
                <tr><td>&nbsp;</td></tr>
                <tr><td>&nbsp;</td></tr>
                <tr><td>&nbsp;</td></tr>
                
                <tr>
                   
                    <td  style="border:2px solid #000;">
                    <div class="image-container">
                            <img style="text-indent: text-aling:center; 10mm; border: solid 1px #007700; width: 100%" src="../<?php echo $photo;?>"  />
                        </div>
                    </td>
                </tr>
                
                
            </table>    

    </page>

<?php } ?>  

  
