<?php

namespace Stilldistribuidora\Repository\Index;

use Exception;
use Stilldistribuidora\Repository\Mysql;



class Points extends Mysql{


function __construct()
{
    parent::__construnct();
}


 
public function pointsSummaryBy($uuid_operation){
    $numberOfPoints=0;
   
    try {
        $sql = "SELECT metadata from operations_poits where fk_delivery=? ";
        $stmt = $this->conn->prepare($sql);
        if($stmt->execute(array($uuid_operation))){
            $result=$stmt->fetch();
            $metadata=json_decode(base64_decode($result["metadata"]),true);
            $numberOfPoints=count($metadata);
        }
     }   catch (Exception $e) {
         echo "Unable to connect";
         print_r($e);
     }
    return $numberOfPoints;

}


   




}


?>