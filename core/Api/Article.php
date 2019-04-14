<?php

include $_SERVER['DOCUMENT_ROOT'] . '/config.php';
include $_SERVER['DOCUMENT_ROOT'] . '/core/Api/config.php';

use Controllers\Article;

$themeDir = $_SERVER['DOCUMENT_ROOT'] . '/theme/backend/' . $config['mainBackendTheme'];

if (isset($_SESSION['uid'])) {
    
    /**
     * Filter by uid
     */
    if (isset($_POST['filterby'])) {
        $uid = $_POST['filterby'];
        $page = $_POST['page'] ?? 1;
        $article = new Article();
        
        $articleList = $article->getArticlesTable($page, $uid);
        $articlePagination = $article->getPagination($page, $uid);

        $articleTemplate = $themeDir . '/templates/articleList.php';
        ob_start();
        include $articleTemplate;
        $articlesHtml = ob_get_contents();
        ob_end_clean();
        $output['table'] = $articlesHtml;
        
        $paginationTemplate = $themeDir . '/templates/pagination.php';
        ob_start();
        include $paginationTemplate;
        $paginationHtml = ob_get_contents();
        ob_end_clean();
        $output['pagination'] = $paginationHtml;
    }
}

echo json_encode($output);