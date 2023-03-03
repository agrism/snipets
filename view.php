<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/css/css.css?v=1">
    <script type="text/javascript" src="/js/js.js"></script>
    <title><?=$title ?? 'Snippets';?></title>
</head>
<body>

<div class="w3-sidebar w3-bar-block" style="display:none;z-index:5" id="mySidebar">
    <button class="w3-bar-item w3-button w3-large" onclick="w3_close()">&times;</button>
    <?php foreach ($routes as $index => $route){?>
    <a href="<?=$route['uri']?>" class="w3-bar-item w3-button"><?=$route['title']?></a>
    <?php }?>
</div>

<div class="w3-overlay" onclick="w3_close()" style="cursor:pointer" id="myOverlay"></div>

<div>
    <button class="w3-button w3-white w3-xxlarge" onclick="w3_open()">&#9776;</button>
    <div class="w3-container">

        <h1><?= $title ?? null;?></h1>

        <?php
        $includeFile = $includeFile ?? null;
        if($includeFile && file_exists($includeFile)){
            include_once $includeFile;
        }
        ?>

    </div>
</div>
</body>
</html>
