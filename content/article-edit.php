<?php


    if (isset($_GET['action'])){
        include "includes/articleposter.php";
    }

    if (isset($_GET['id'])){
        $article=run("SELECT * FROM articles WHERE id=?",[$_GET["id"]])->fetch();
        $images=run("SELECT * FROM images WHERE articleID=?",[$_GET["id"]])->fetchAll();
    }


?>

<article>
    <form action="?<?php 
        echo $_SERVER['QUERY_STRING'];
        if (isset($_GET['id'])){
            echo '&action=update';
        }else{
            echo '&action=create';
        }
    ?>" method="post" enctype="multipart/form-data">

        <h3>Nadpis</h3>
        <textarea name="title" placeholder="nadpis" cols=75><?php 
            if (isset($_GET['id'])){echo htmlspecialchars($article["title"]);}
        ?></textarea>
        <br>

        <h3>Obsah</h3>
        <textarea name="content" placeholder="obsah" rows=20 cols=75><?php
            if (isset($_GET['id'])){echo htmlspecialchars($article["content"]);}
        ?></textarea>
        
        <h3>Úvodní obrázek</h3>
        <input type="file" name="image">

        <h3>Příloha</h3>
        <input type="file" name="file">
        <br>

        <h3>Další obrázky</h3>
        <?php 
            if (isset($_GET['id'])){
                foreach($images as $image){
                    echo '<br>';
                    echo '<label>Smazat<input type="checkbox" name="images_delete[]" value="'. $image["imageID"] .'"></label>';
                    echo '<a href="uploads/' . $image["picture"] . '"><img width="auto" height="80" src="uploads/' . $image["picture"] . '" alt="Dalsi Obrazek"></a>';
                    echo '<br>';
                }
            }
        ?>
        <br>
        <input type="file" name="images[]">
        <input type="file" name="images[]">
        <input type="file" name="images[]">
        <input type="file" name="images[]">

        <h3>Čas vypršení</h3>
        <input type="date" name="expiration" value=<?php
            if (isset($_GET['id']) && $article["expiration"]!=null){echo $article["expiration"];}
        ?>>
        <br>
        (Ponech prázdné pro neomezené)
        <br>
        <br>

        <button> Poslat </button>

    </form>
    
    <?php if (isset($_GET["id"])):?>
        <br>
        <form action="?<?php echo $_SERVER['QUERY_STRING'];?>&action=delete" method="post">
            <button> Smazat Novinku </button>
        </form>
    <?php endif;?>

</article>
