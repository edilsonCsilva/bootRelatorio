<?php
require_once(__DIR__."/vendor/autoload.php");
use Stilldistribuidora\Res\Libs\Libs;
use Stilldistribuidora\Res\Values\StringPtBr;
use Stilldistribuidora\Repository\Index\Points;
use Stilldistribuidora\Repository\Index\Operation;
$operationsModel=new Operation();
print_r(json_encode($operationsModel->getOperationsActiveToIp()));


?>
