<?php


if (!$_SERVER["REQUEST_METHOD"] == "POST" || !isset($_GET["action"])){
    header("Location:". config('site_url'));
    die();
}



$action=$_GET["action"];

if ($action=="delete"){
    run("DELETE FROM articles WHERE id=?",[$_GET["id"]]);
    header("Location:". config('site_url'));
    die();
}
else if ($action=="create" || $action=="update"){
    require 'upload.php';

    $title = $_POST["title"];
    $content = $_POST["content"];
    $expiration = $_POST["expiration"];

    if ($expiration== ''){
        $expiration=null;
    }

    require 'dbh.php';
    if ($action=="create"){
        run(
            "INSERT INTO articles (title,content,expiration,picture,attachment) VALUES (?,?,?,?,?);",
            [$title,$content,$expiration,$imageName,$fileName],
            $pdo
        );
    } else if ($action=="update"){
        run(
            "UPDATE articles SET title=?, content=?, expiration=?, last_updated=CURTIME() WHERE id=?",
            [$title,$content,$expiration,$_GET["id"]]
        );
        if ($imageName!=null){
            run(
                "UPDATE articles SET picture=? WHERE id=?",
                [$imageName,$_GET["id"]]
            );
        }
        if ($fileName!=null){
            run(
                "UPDATE articles SET attachment=? WHERE id=?",
                [$fileName,$_GET["id"]]
            );
        }
        foreach ($_POST['images_delete'] as $image_id){
            run(
                "DELETE FROM images WHERE imageID=?",
                [$image_id]
            );
        }
    }

    $article_id = $action=="create" ? $pdo->lastInsertId() : $_GET["id"];

    foreach ($images as $image){
        run(
            "INSERT INTO images (picture,articleID) VALUES (?,?);",
            [$image,$article_id]
        );
    }

    header('Location: ' . config('site_url') . '?page=article&id=' . $article_id);
    
    die();
}
