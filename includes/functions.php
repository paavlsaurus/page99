<?php


function site_name()
{
    echo config('name');
}

function site_url()
{
    echo config('site_url');
}

function nav_menu()
{
    $nav_menu = '';
    $nav_items = config('nav_menu');
    
    foreach ($nav_items as $uri => $name) {
        $query_string = str_replace('page=', '', $_SERVER['QUERY_STRING'] ?? '');
        $class = $query_string == $uri ? ' active' : '';
        $url = config('site_url') . '/' . ($uri == '' ? '' : '?page=') . $uri;
        
        $nav_menu .= '<a href="' . $url . '" title="' . $name . '" class="item ' . $class . '">' . $name . '</a>' . ' | ';
    }
    echo trim($nav_menu, ' | ');
}

function page_title()
{

    if (isset($_GET['page'])){
        $adress=htmlspecialchars($_GET['page']);
        if (array_key_exists($adress,config('nav_menu'))){
            $page=config('nav_menu')[$adress];
        } else{
            $page='Článek';
        }
    }
    else{
        $page='Novinky';
    }

    echo ucwords(str_replace('-', ' ', $page));
}


function page_content()
{
    $page = isset($_GET['page']) ? $_GET['page'] : 'home';
    $path = getcwd() . '/' . config('content_path') . '/' . $page . '.php';
    

    if (! file_exists($path)) {
        $path = getcwd() . '/' . config('content_path') . '/404.php';
    }

    include $path;
    // echo file_get_contents($path);
}

function run($sql,$bind=[],$pdo=null){
    if ($pdo==null){require 'dbh.php';}
    $stmt=$pdo->prepare($sql);
    $stmt->execute($bind);
    return $stmt;
}

function init()
{
    require config('template_path') . '/template.php';
}
