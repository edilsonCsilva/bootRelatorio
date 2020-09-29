<?php
namespace Stilldistribuidora\Res\Libs;

class Libs{
    public static function dd($debugRaw){
        echo "<pre>";
        print_r($debugRaw);
        exit();
    }
}


?>