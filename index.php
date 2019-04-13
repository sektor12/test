<?php

include $_SERVER['DOCUMENT_ROOT'] . '/config.php';

use Controllers\Article;

$article = new Article();
if (isset($_GET['page']) && isset($_GET['articleid'])) {
    $id = $_GET['articleid'];
    $articleData = [$article->getArticleById($id)];
} else {
    $articleData = $article->getArticles(0, 0);
}

/**
 * Loading theme folder
 */
$themeDir = $_SERVER['DOCUMENT_ROOT'] . '/theme/frontend/' . $config['mainFrontendTheme'];
include $themeDir . '/index.php';