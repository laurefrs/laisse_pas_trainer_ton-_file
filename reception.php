<?php

if (!empty($_FILES['files']['name'][0])){
    $files = $_FILES['files'];
    $uploaded = [];
    $failed = [];
    $allowed = array('jpg', 'png', 'gif');

    foreach ($files['name'] as $position => $file_name){
        $file_tmp = $files['tmp_name'][$position];

        $file_size = $files['size'][$position];
        $file_error = $files['error'][$position];
        $file_ext = explode('.', $file_name);
        $file_ext = strtolower(end($file_ext));

    //verif des fichiers
    if (in_array($file_ext, $allowed)){
        //controle si presence d'erreurs
        if($file_error === 0) {
            // verif de la taille
            if($file_size <= 1000000){
                //definition du nouveau nom de fichier
                $file_name_new = uniqid('image') . '.' . $file_ext;
                $file_destination = 'upload/' . $file_name_new;
                //deplacement du fichier dans dossier dédié
                if(move_uploaded_file($file_tmp, $file_destination)){
                    $uploaded[$position] = $file_destination;
                    header('Location: index.php');
                }else{
                    $failed[$position] = "[$file_name] Le fichier n'a pas pu être téléchargé.";
                }
            }else{
                $failed[$position] = "[$file_name] Le fichier est trop lourd.";
            }
        }else{
            $failed[$position] = "[$file_name] Le fichier n'a pas pu être téléchargé.";
        }
    }else{
        //debug
        $failed[$position] = "[$file_name] L'extension du fichier [" . $file_ext . "] n'est pas autorisée.";
}
}
}

