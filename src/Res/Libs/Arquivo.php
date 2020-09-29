<?php 
namespace Stilldistribuidora\Libs;

use Exception;

class Arquivo{

    public static function getFilesToDir($pathBase,$uuid,$typesValids=[]){
            $filesFoundInTheDirectory=[];
            if ( $handle = opendir(sprintf("%s%s",$pathBase,$uuid)) ) {
                while ( $entry = readdir( $handle ) ) {
                    $ext = strtolower( pathinfo( $entry, PATHINFO_EXTENSION) );
                    if( in_array( $ext,$typesValids ) ){
                        $filesFoundInTheDirectory[]=sprintf("%s%s/%s",$pathBase,$uuid,$entry);
                    }  
                }
                closedir($handle);
            }    

         return $filesFoundInTheDirectory;   
            
    }

    public static function readFiles($pathFile){
        try{
            return file($pathFile);
        }catch(Exception $e){

        }
        return "";
    }



}


?>