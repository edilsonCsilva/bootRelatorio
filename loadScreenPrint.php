<?php

use Stilldistribuidora\Libs\Arquivo;
use Stilldistribuidora\Res\Libs\Libs;

require_once(__DIR__."/vendor/autoload.php");
require_once("env.php");
$photoScreenPrint=Arquivo::getFilesToDir(PATH_FILES_PRINT_SCREEN,$_POST["operationUuid"],PATH_FILES_TYPE_IMGS_VALID);
echo json_encode([
      'sumNewPhotoPrint' =>count($photoScreenPrint),
      'files' =>$photoScreenPrint,
   ]);

 
?>