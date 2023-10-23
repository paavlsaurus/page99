<?php


function config($key = '')
{
    $config = [
        'name' => 'Mini Novinky',
        'site_url' => '',
        'nav_menu' => [
            '' => 'Novinky',
            'about-us' => 'Info',
        ],
        'other_sites' => [
            'article' => 'Článek',
        ],
        'template_path' => 'template',
        'content_path' => 'content',
    ];

    return isset($config[$key]) ? $config[$key] : null;
}
