<?php

$uri = $_SERVER['REQUEST_URI'];

$routes = [
    [
        'uri' => '/onfido-bypass',
        'title' => 'Onfido bypass',
        'file' => 'snipets/onfido_bypass.php',
    ],
    [
        'uri' => '/other',
        'title' => 'Other...',
        'file' => 'snipets/other.php',
    ],
];

$foundRoute = null;

foreach ($routes as $route){
    if($route['uri'] == rtrim($uri, '/') ){
        $foundRoute = $route;
        break;
    }
}

if(!$foundRoute){
    $foundRoute = $routes[0];
}

$content = null;
$includeFile = null;

if($file = $foundRoute['file'] ?? null){
    if(file_exists($file)){
        $includeFile = $file;
    }
}

$title = $foundRoute['title'] ?? null;

require 'view.php';



