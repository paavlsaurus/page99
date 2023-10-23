<button onclick="location.href='<?php echo config('site_url');?>/?page=article-edit'" type="button">Nový Článek</button>
<br>

<?php 

    $articles = run("SELECT * FROM articles");

    foreach($articles as $article){
        echo '<div class="wrap2">';
        echo '<h3>' . $article["title"] . '</h3>';
        echo '<p>' . $article["content"] . '</p>';
        echo '<a href="' . config('site_url') . '/?page=article&id='.$article["id"].'"> Čtěte více </a>';
        echo '</div>';
    }
 ?>

