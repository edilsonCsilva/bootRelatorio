<?php
require_once(__DIR__."/vendor/autoload.php");
require_once("env.php");
$dir=sprintf("%s/%s",PATH_FILES_PRINT_SCREEN,$_POST["txt_delivery"]);
shell_exec('sh pemisao.sh ');
$url=sprintf("configure.php?operations=%s",$_POST["txt_delivery"]);
        foreach ($_FILES["file"]["error"] as $key => $error) {
            if ($error == UPLOAD_ERR_OK) {
                $tmp_name = $_FILES["file"]["tmp_name"][$key];
                // basename() may prevent filesystem traversal attacks;
                // further validation/sanitation of the filename may be appropriate
                $name = basename($_FILES["file"]["name"][$key]);
                mkdir(dirname(__FILE__).'/'.$dir, 0777, true);
                move_uploaded_file($tmp_name, $dir."/$name");
            }
        }
    header("location:".$url);

    





?>