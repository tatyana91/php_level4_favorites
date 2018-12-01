<?php
function autoloadClass($class){
    if (file_exists("classes/$class.class.php")){
        require_once "classes/$class.class.php";
    }
}
spl_autoload_register('autoloadClass');

$favorites = new Favorites();

$favorite_items = [
    'getLinksItems' => 'Полезные сайты',
    'getAppsItems' => 'Полезные приложения',
    'getArticlesItems' => 'Полезные статьи'
];
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Наши рекомендации</title>
        <meta charset="utf-8"/>
        <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="assets/styles/styles.css">
        <link rel="shortcut icon" href="assets/img/favicon.png" type="image/png">
    </head>
    <body>
        <div class="content">
            <header class="header">
                <h1 class="header__title">Мы рекомендуем</h1>
            </header>
            <div class="favorites">
                <?
                foreach ($favorite_items as $favorite_method => $favorite_title){
                    ?>
                    <div class="favorites__item-wrap">
                        <div class="favorites__item">
                            <h2 class="favorites__title"><?=$favorite_title?></h2>
                            <div>
                                <?
                                $authors_data = $favorites->getFavorites($favorite_method);
                                foreach($authors_data as $author_name => $author_data){
                                    ?>
                                    <div class='favorites__author-links'>
                                        <div class='favorites__author'><?=$author_name?>:</div>
                                        <?
                                        foreach ($author_data as $link_item){
                                            ?>
                                            <div class='favorites__link-wrap'>
                                                <a class='favorites__link' href='http://<?=$link_item[1]?>' target='_blank'>
                                                    <?=$link_item[0]?>
                                                </a>
                                            </div>
                                            <?
                                        }
                                        ?>
                                    </div>
                                    <?
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <?
                }
                ?>
            </div>
        </div>
    </body>
</html>