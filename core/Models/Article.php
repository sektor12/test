<?php

namespace Models;

use Connection;

class Article
{
    private $connection;
    private $articleListLimit = 5;
    
    public function __construct()
    {
        $conn = new Connection();
        $this->connection = $conn->getConnection();
    }

    /**
     * Deleting article by ID
     * @param int $id
     * @return bool
     */
    public function deleteArticle(int $id): bool
    {
        $images = $this->getImagesByArticle($id);
        $imageIds = [];
        foreach ($images as $image) {
            $imageIds[] = $image['id'];
        }
        $this->removeImages($imageIds);
        $query = 'DELETE FROM articles WHERE id=?';
        $pdo = $this->connection->prepare($query);
        return $pdo->execute([$id]);
    }

    /**
     * Updating article and removing images
     * 
     * @param array $data
     * @param array $files
     * @return bool
     */
    public function updateArticle(array $data, array $files): bool
    {
        $query = "UPDATE articles "
               . "SET title=?, body=? "
               . "WHERE id=?";
        $pdo = $this->connection->prepare($query);
        $update = $pdo->execute([$data['title'], $data['body'], $data['articleid']]);
        if (!empty($files) && isset($data['articleid'])) {
            $this->insertFiles($data['articleid'], $files);
        }
        if (isset($data['removeimage'])) {
            $this->removeImages($data['removeimage']);
        }
        return $update;
    }
    
    /**
     * Inserting article data
     * @return bool
     */
    public function insertArticle(array $data, array $files): bool
    {
        $query = "INSERT INTO articles(title, body, uid) VALUES(?, ?, ?)";
        $pdo = $this->connection->prepare($query);
        $insert = $pdo->execute([$data['title'], $data['body'], $_SESSION['uid']]);
        $articleId = $this->connection->lastInsertId();
        if ($articleId) {
            $this->insertFiles($articleId, $files);
        }
        return $insert;
    }
    
    /**
     * Get list of all articles
     * @return array
     */
    public function getList($page, $filter): array
    {
        $articles = [];
        if ($page != 0) {
            $paginationData = $this->getArticlePaginationData($page, $filter);
            $paginationAdditional = 'LIMIT :limit OFFSET :offset';
        } else {
            $paginationAdditional = '';
        }
        
        if ($filter != 0) {
            $additionalQuery = ' WHERE uid=:uid ';
        } else {
            $additionalQuery = '';
        }
        $query = 'SELECT * FROM articles ' . $additionalQuery . ' ORDER BY id DESC ' . $paginationAdditional;
        $pdo = $this->connection->prepare($query);
        
        if ($page != 0) {
            $pdo->bindParam(':limit', $this->articleListLimit, \PDO::PARAM_INT);
            $pdo->bindParam(':offset', $paginationData['offset'], \PDO::PARAM_INT);
        }
        if ($filter != 0) {
            $pdo->bindParam(':uid', $filter, \PDO::PARAM_INT);
        }
        $pdo->execute();
        $articles = $pdo->fetchAll(\PDO::FETCH_ASSOC);
        
        if (!empty($articles)) {
            foreach ($articles as $key => $article) {
                $articles[$key]['files'] = $this->getImagesByArticle($article['id']);
            }
        }
        return $articles;
    }
    
    public function getArticlePaginationData(int $page, int $filter) : array
    {
        if ($filter != 0) {
            $additionalQuery = ' WHERE uid=:uid ';
        } else {
            $additionalQuery = '';
        }
        $query = 'SELECT COUNT(*) as artnum FROM articles' . $additionalQuery;
        $pdo = $this->connection->prepare($query);
        if ($filter != 0) {
            $pdo->bindParam(':uid', $filter, \PDO::PARAM_INT);
        }
        $pdo->execute();
        $result = $pdo->fetch(\PDO::FETCH_ASSOC);
        $total = $result['artnum'];
        $pages = ceil($total / $this->articleListLimit);
        $offset = ($page - 1)  * $this->articleListLimit;
        return [
            'total' => $total,
            'pages' => $pages,
            'offset' => $offset,
            'filter' => $filter
        ];
    }
    
    /**
     * Get single article
     * @param int $id
     * @return array
     */
    public function getArticleById(int $id): array
    {
        $query = 'SELECT * FROM articles WHERE id=?';
        $pdo = $this->connection->prepare($query);
        $pdo->execute([$id]);
        $data = $pdo->fetch(\PDO::FETCH_ASSOC);
        $data['files'] = $this->getImagesByArticle($id);
        return $data;
    }
    
    /**
     * Get all images attached to articles
     * @param int $id
     * @return array
     */
    public function getImagesByArticle(int $id): array
    {
        $query = 'SELECT * FROM articles_images WHERE articleId=?';
        $pdo = $this->connection->prepare($query);
        $pdo->execute([$id]);
        $images = $pdo->fetchAll(\PDO::FETCH_ASSOC);
        return $images;
    }
    
    /**
     * Inserting files per article
     * @param type $articleId
     * @return bool
     */
    private function insertFiles($articleId, $files): bool
    {
        $insert = false;
        foreach ($files as $file) {
            $query = "INSERT INTO articles_images(filename, articleId) VALUES(?, ?)";
            $pdo = $this->connection->prepare($query);
            if ($pdo->execute([$file, $articleId])) {
                $insert = true;
            }
        }
        return $insert;
    }
    
    /**
     * Returns the filename by id
     * @param int $id
     */
    private function getImageById(int $id) : string
    {
        $query = "SELECT filename FROM articles_images WHERE id=?";
        $pdo = $this->connection->prepare($query);
        $pdo->execute([$id]);
        $result = $pdo->fetch(\PDO::FETCH_ASSOC);
        if ($result) {
            return $result['filename'];
        }
        return '';
    }

    /**
     * Removing array of images
     * @param array $images
     */
    private function removeImages(array $images)
    {
        if (isset($images) && !empty($images)) {
            foreach ($images as $imageForRemoval) {
                $imageName = $this->getImageById($imageForRemoval);
                if ($this->removeImage($imageForRemoval) && $imageName) {
                    unlink($_SERVER['DOCUMENT_ROOT'] . '/files/images/' . $imageName);
                }
            }
        }
    }
    
    /**
     * Remove single image
     * @param int $id
     * @return type
     */
    private function removeImage(int $id)
    {
        $query = "DELETE FROM articles_images WHERE id=?";
        $pdo = $this->connection->prepare($query);
        return $pdo->execute([$id]);
    }
}
