<?php

include $_SERVER['DOCUMENT_ROOT'] . '/core/Snippets/Messages.php';
include $_SERVER['DOCUMENT_ROOT'] . '/config.php';

/**
 * Controlling user session
 */
session_start();

use Controllers\Article;
use Controllers\User;

/**
 * User login handling
 */
if (isset($_POST['login'])) {
    $user = new User();
    $user->login($_POST['username'], $_POST['password']);
    $messages = $user->messages;
}

if (isset($_SESSION['uid']) && isset($_GET['action'])) {
    if ($_GET['action'] == 'logout') {
        session_destroy();
        header('Location: /admin/?action=articles');
    }
    
    if (isset($_POST['saveArticle'])) {
        $article = new Article();
        if (isset($_POST['articleid'])) {
            $article->updateArticle($_POST);
        } else {
            $article->addArticle($_POST);
        }
        $messages = $article->messages;
    }
    
    if ($_GET['action'] == 'articles') {
        $article = new Article();
        
        if (isset($_GET['method']) && $_GET['method'] == 'delete') {
            $article->deleteArticle($_GET['id']);
            $messages = $article->messages;
        }
        
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
        } else {
            $page = 1;
        }
        
        if (isset($_POST['filterby'])) {
            $filter = $_POST['filterby'];
        } else if(isset($_GET['filter'])) {
            $filter = $_GET['filter'];
        } else {
            $filter = 0;
        }

        $articleList = $article->getArticlesTable($page, $filter);
        $articlePagination = $article->getPagination($page, $filter);
        $userObj = new User();
        $users = $userObj->getUsers();
    }
    
    if ($_GET['action'] == 'editarticle') {
        $article = new Article();
        $singleArticle = $article->getArticleById($_GET['id']);
    }
}

/**
 * Loading theme folder
 */
$themeDir = $_SERVER['DOCUMENT_ROOT'] . '/theme/backend/' . $config['mainBackendTheme'];
include $themeDir . '/index.php';