<?php

$imageName=null;
$fileName=null;
$images=[];

if ($_FILES['image']["name"]!=''){
    $imageName=upload($_FILES["image"],"image");
}
if ($_FILES['file']["name"]!=''){
    $fileName=upload($_FILES["file"],"file");
}
if (!empty($_FILES['images'])){
    for ($i=0;$i<4;$i++){
        if ($_FILES['images']["name"][$i]==''){continue;}
        $new_file=[];
        foreach($_FILES['images'] as $key => $value){
            $new_file[$key]=$value[$i];
        }
        array_push($images,upload($new_file,"image"));
    }
}

function upload($file,$type){

    $fileName=$file['name'];
    $fileTmpName=$file['tmp_name'];
    $fileSize=$file['size'];
    $fileError=$file['error'];

    $fileExt=explode('.',$fileName);
    $fileActualExt=strtolower(end($fileExt));

    $allowed = ['jpg','jpeg','png'];

    if (!in_array($fileActualExt,$allowed) && $type=="image"){
        echo "wrong file type";
        return;
    }
    if ($fileError!=0){
        echo "error while uploading";
        return;
    }
    if ($fileSize>500000){
        echo "file max size is 500kb";
        return;
    }
    $fileNameNew=uniqid('',true).".".$fileActualExt;
    $fileDestination='uploads/'.$fileNameNew;
    move_uploaded_file($fileTmpName,$fileDestination);
    return $fileNameNew;
}