<?php

namespace Controllers;

use Snippets\Messages;
use Models\Article as ArticleModel;
use Services\Operations;

class Article
{
    private $snippets;
    public  $messages = [];
    private $services;
    private $articleModel;
    
    public function __construct() 
    {
        $snippets = new Messages();
        $this->snippets = $snippets::$article;
        $this->services = new Operations();
        $this->articleModel = new ArticleModel();
    }

    /**
     * Article removal
     * @param int $id
     */
    public function deleteArticle(int $id)
    {
        if ($this->articleModel->deleteArticle($id)) {
            $this->messages[] = [
                'text' => $this->snippets['delete_article_success'],
                'type' => 'success'
            ]; 
        }
    }
    
    /**
     * Updating existing article
     * @param type $data
     * @return $this
     */
    public function updateArticle($data)
    {
        if ($this->validParameters($data)) {
            $files = $this->uploadFiles();
            if ($this->articleModel->updateArticle($data, $files)) {
                $this->messages[] = [
                    'text' => $this->snippets['update_article_success'],
                    'type' => 'success'
                ];
            }
        }
        return $this;
    }

    /**
     * Initiating function for storing articles
     * @return $this
     */
    public function addArticle($data)
    {
        if ($this->validParameters($data)) {
            $files = $this->uploadFiles();
            if ($this->articleModel->insertArticle($data, $files)) {
                $this->messages[] = [
                    'text' => $this->snippets['add_article_success'],
                    'type' => 'success'
                ];
            }
        }
        return $this;
    }
    
    private function validParameters($data) : bool
    {
        $valid = true;
        if (empty($data['title'])) {
            $this->messages[] = [
                'text' => $this->snippets['missing_title'],
                'type' => 'error'
            ];
            $valid = false;
        }
        if (empty($data['body'])) {
            $this->messages[] = [
                'text' => $this->snippets['missing_body'],
                'type' => 'error'
            ];
            $valid = false;
        }
        return $valid;
    }
    
    /**
     * Get single article by ID
     * @param int $id
     * @return array
     */
    public function getArticleById(int $id): array
    {
        $article = $this->articleModel->getArticleById($id);
        return $article;
    }
    
    /**
     * Getting articles table
     * @return array
     */
    public function getArticlesTable(int $page, int $filter) : array
    {
        $articles = $this->articleModel->getList($page, $filter);
        foreach ($articles as $key => $article) {
            $articles[$key]['body'] = $this->services->limitString(300, strip_tags($articles[$key]['body']));
        }
        return $articles;
    }
    
    /**
     * Get all articles
     * @param int $page
     * @param int $filter
     * @return array
     */
    public function getArticles(int $page, int $filter) : array
    {
        return $this->articleModel->getList($page, $filter);
    }
    
    /**
     * Pagination
     * @param int $page
     * @param int $filter
     * @return array
     */
    public function getPagination(int $page, int $filter): array
    {
        $pagination = $this->articleModel->getArticlePaginationData($page, $filter);
        return $pagination;
    }
    
    /**
     * Storing files to directory /files with unique names
     * @return array
     */
    private function uploadFiles() : array
    {
        $fileNames = [];
        if (isset($_FILES["articleimage"])) {
            foreach ($_FILES["articleimage"]['tmp_name'] as $key => $tmpName) {
                $name = $_FILES["articleimage"]["name"][$key];
                $type = $_FILES["articleimage"]["type"][$key];
                if ($type == 'image/jpeg') {
                    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/files/images/" . $name)) {
                        $fileNumber = 0;
                        // Handling files so that they have unique names
                        while (file_exists($_SERVER['DOCUMENT_ROOT'] . "/files/images/" . $name)) {
                            $extensionSeparation = explode('.', $name);
                            $nameSeparation = explode('_', $extensionSeparation[0]);
                            if (is_numeric($nameSeparation[count($nameSeparation) - 1]) && $nameSeparation[count($nameSeparation) - 1] != $nameSeparation[0]) {
                                $fileNumber = $nameSeparation[count($nameSeparation) - 1];
                                $fileNumber++;
                                unset($nameSeparation[count($nameSeparation) - 1]);
                            } else {
                                $fileNumber++;
                            }
                            
                            $name = implode('_', $nameSeparation) . '_' . $fileNumber . '.' . $extensionSeparation[1];
                            if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/files/images/" . $name)) {
                                $fileNames[] = $name;
                            }
                        }
                    } else {
                        $fileNames[] = $name;
                    }
                    move_uploaded_file($tmpName, $_SERVER['DOCUMENT_ROOT'] . "/files/images/" . $name);
                } else {
                    $this->messages[] = [
                        'text' => $this->snippets['wrong_image_type'],
                        'type' => 'error'
                    ];
                }
            }
        }
        return $fileNames;
    }
}