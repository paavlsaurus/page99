<?php

    if (isset($_GET['id'])){
        $article=run("SELECT * FROM articles WHERE id=?",[$_GET["id"]])->fetch();
        $images=run("SELECT * FROM images WHERE articleID=?",[$_GET["id"]])->fetchAll();
    }else{
        header("Location:" . config('site_url'));
    } 

?>

<article>
    <h2> 
        <?php echo $article["title"]; ?> 
    </h2>

    <?php
        if ($article["picture"]!=null){
            echo '<img src="uploads/' . $article["picture"] . '" alt="Hlavní Obrázek">';
        }
    ?> 

    <p>
        <?php echo $article["content"]; ?> 
    </p>
    <br>

    <p><?php 
        if ($article["last_updated"]!=null){
            echo ('Poslední úprava: ' . $article["last_updated"]);
        }
    ?></p>

    <?php
        if ($article["attachment"]!=null){
            echo '<a href="uploads/' . $article["attachment"] . '">'.$article["attachment"].'</a>';
        }
    ?> 
    <br>
    <?php
        foreach($images as $image){
            echo '<a href="uploads/' . $image["picture"] . '"><img width="auto" height="130" src="uploads/' . $image["picture"] . '" alt="Dalsi Obrazek"></a>';
        }
    ?> 
    <br>

    <p>
        Čas vytvoření:  <?php echo $article["created_at"]; ?> 
        <br>
        Čas vypršení platnosti:  <?php echo ($article["expiration"]==null ? 'Neomezený' : $article["expiration"]); ?> 
    </p>


    <br>
    <button onclick="location.href='<?php echo config('site_url');?>/?page=article-edit&id=<?php echo $_GET['id'];?>'" type="button">Upravit Článek</button>

    
</article>
