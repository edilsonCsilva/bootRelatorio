<?php

namespace Stilldistribuidora\Repository\Index;

use Exception;
use Stilldistribuidora\Repository\Mysql;



class Photos extends Mysql{


function __construct()
{
    parent::__construnct();
}


 
public function photoSummaryBy($uuid_operation){
    $numberOfPhotos=0;
   
    try {
        $sql = "SELECT metadata from operations_photos where fk_delivery=? ";
        $stmt = $this->conn->prepare($sql);
        if($stmt->execute(array($uuid_operation))){
            $result=$stmt->fetch();
            $metadata=json_decode(base64_decode($result["metadata"]),true);
            $numberOfPhotos=count($metadata);
        }
     }   catch (Exception $e) {
         echo "Unable to connect";
         print_r($e);
     }
    return $numberOfPhotos;

}


   




}


?>