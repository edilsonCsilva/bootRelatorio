<?php
require_once(__DIR__."/vendor/autoload.php");
define("path_screens","Downloads/print_screen/");
if (is_dir(path_screens) && is_writable(path_screens)) {
    // do upload logic here



            $jsonToObjArray=json_decode($_POST["param"],true);
            if (isset($_FILES['binaryFile']['name']) 
                    && ($_FILES['binaryFile']['error'] === 0) ) {
                        $arquivo_tmp = $_FILES['binaryFile']['tmp_name'];
                        $nome = $_FILES['binaryFile']['name'];
                        // Pega a extensão
                        $extensao=pathinfo($nome,PATHINFO_EXTENSION);
                        $extensao =strtolower($extensao);
                        if(strstr('.jpg;.jpeg;.gif;.png',$extensao)){
                            $novoNome = uniqid ( time () ).'.'.$extensao;
                            $destino =sprintf("%s%s/%s",path_screens,$jsonToObjArray["delivery"],$novoNome);

                            if(strlen(trim($jsonToObjArray["delivery"]))==0){
                                echo 'Selecione uma Operação Pra Tirar Um Foto.';
                                exit();
                            }

                           
                            //print_r("\n\naaaa  ".$destino);
                                //tenta mover o arquivo para o destino
                                    if (move_uploaded_file($arquivo_tmp, $destino)) {
                                        echo 'Imagen Salva com Sucesso.';
                                    } else {
                                        echo "Erro ao Salvar a Imagens.";
                                    }
                        }
            }



} else {
    echo 'Upload directory is not writable, or does not exist.';
}



?>