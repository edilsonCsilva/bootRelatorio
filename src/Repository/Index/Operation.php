<?php

namespace Stilldistribuidora\Repository\Index;

use Exception;
use Stilldistribuidora\Res\Libs\Libs;
use Stilldistribuidora\Repository\Mysql;
use Stilldistribuidora\Repository\Index\Photos;
use Stilldistribuidora\Repository\Index\Points;
use Stilldistribuidora\Repository\Entity\Operation as EntityOperation;
 


class Operation extends Mysql{


    private $status=['P'=>"Processado.",'N'=>"Em Processado."];


function __construct()
{
    parent::__construnct();
}


public function operationSummaryByDate($data){
    $numberOfOperations=0;
    $numberOfOperationsPoints=0;
    $numberOfOperationsPhotos=0;
    $pointModel=new Points();
    $photoModel=new Photos();
    try {
        $sql = "SELECT delivery_id  FROM operations  where dt_processing=?";
        $stmt = $this->conn->prepare($sql);
        if($stmt->execute(array($data))){
            $result=$stmt->fetchAll();
            $numberOfOperations=count($result);
            foreach($result as $index => $operation){
                $numberOfOperationsPoints+=$pointModel->pointsSummaryBy($operation["delivery_id"]);
                $numberOfOperationsPhotos+=$photoModel->photoSummaryBy($operation["delivery_id"]);

            }


        }
     }   catch (Exception $e) {
         echo "Unable to connect";
         print_r($e);
     }
    return array("summaryOfTheOperation"=>$numberOfOperations,
                 "summaryOfThePonts"=>$numberOfOperationsPoints,
                 "summaryOfThePhotos"=>$numberOfOperationsPhotos);

}
public function operationByDate($yearMonthDay){
    $operations=[];
    //Libs::dd($yearMonthDay);
    try {
        $sql = "SELECT ObjId, delivery_id, dt_processed, status, dt_processing, metadata, delivery_raw FROM operations  where dt_processing=?";
        $stmt = $this->conn->prepare($sql);
        if($stmt->execute(array($yearMonthDay))){
            $result=$stmt->fetchAll();
            foreach($result as $index=>$operation){
                $data=explode("-",$operation["dt_processing"]);
                $operation["dt_processing"]=sprintf("%s/%s/%s",$data[2],$data[1],$data[0]);
                array_push($operations,
                new EntityOperation($operation["ObjId"],$operation["delivery_id"],
                                    $operation["dt_processed"],$operation["status"],
                                    $operation["dt_processing"],$operation["metadata"],$operation["delivery_raw"]));

            }
        }
     }   catch (Exception $e) {
         echo "Unable to connect";
         print_r($e);
     }
    return $operations;

}
public function operationByUuid($uuid){
    $operations=[];
    //Libs::dd($yearMonthDay);
    try {
        $sql = "SELECT ObjId, delivery_id, dt_processed, status, dt_processing, metadata, delivery_raw FROM operations  where delivery_id=?";
        $stmt = $this->conn->prepare($sql);
        if($stmt->execute(array($uuid))){
            $result=$stmt->fetchAll();
            foreach($result as $index=>$operation){
                $data=explode("-",$operation["dt_processing"]);
                $operation["dt_processing"]=sprintf("%s/%s/%s",$data[2],$data[1],$data[0]);
                array_push($operations,
                new EntityOperation($operation["ObjId"],$operation["delivery_id"],
                                    $operation["dt_processed"],$operation["status"],
                                    $operation["dt_processing"],$operation["metadata"],$operation["delivery_raw"]));

            }
        }
     }   catch (Exception $e) {
         echo "Unable to connect";
         print_r($e);
     }
    return $operations;

}



function addActiveOperationByIp($action,$params=""){
    try {
        $sql = 'INSERT INTO operation_active(ip,delivery,metadata) VALUES(?,?,?)';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(array($_SERVER["REMOTE_ADDR"],$action,$params));
     }   catch (Exception $e) {
         $sql = 'update   operation_active set delivery=?,metadata=?  where  ip=?';
         $stmt = $this->conn->prepare($sql);
         $stmt->execute(array($action,$params,$_SERVER["REMOTE_ADDR"]));
     }
}



function getOperationsActiveToIp(){
    $operations=[];
    try {
        
        $sql = 'SELECT * FROM operation_active where ip =?';
        $sqlDelete = 'DELETE FROM operation_active where ip =?';

        $stmt = $this->conn->prepare($sql);
        if($stmt->execute(array($_SERVER["REMOTE_ADDR"]))){
            $result=$stmt->fetchAll();
            foreach($result as $i=>$operation){
                $operations=array(
                    "ip"=>$operation["ip"],
                    "delivery"=>$operation["delivery"],
                    "metadata"=>$operation["metadata"],
                );
            }
            $stmt = $this->conn->prepare($sqlDelete);
            if ($stmt->execute(array($_SERVER["REMOTE_ADDR"]))) {
            
            }

        }
     }   catch (Exception $e) {
         echo "Unable to connect";
         echo $e->getMessage();
     }

    

    return $operations;
}


function getDetailOperations($uuid){
    $operations=[];
    try {
        
        $sql = 'SELECT * FROM operations where delivery_id =?';
        $stmt = $this->conn->prepare($sql);
        if($stmt->execute(array($uuid))){
            $result=$stmt->fetchAll();
            foreach($result as $i=>$operation){
                $operations[]=array(
                    "uuid"=>$operation["ObjId"],
                    "delivery_raw"=>$operation["delivery_raw"],
                    "dt_processing"=>$operation["dt_processing"],
                   
                );
            }
        }
     }   catch (Exception $e) {
         echo "Unable to connect";
         echo $e->getMessage();
     }
    return $operations;
}



public function getStatusLabel($status){
     
    return $this->status[$status];
}




   




}


?>