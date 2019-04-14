<div class="dashboard-panel">
    <div class="top-bar">
        <?php include $themeDir . '/templates/navigation.php'; ?>
    </div>
    <div class="content">
        <?php include $themeDir . '/templates/messages.php'; ?>
        <?php 
            if (isset($_GET['action']) && $_GET['action'] == 'addarticle') {
                include $themeDir . '/templates/forms/article.php';
            } else if (isset($_GET['action']) && $_GET['action'] == 'editarticle') {
                include $themeDir . '/templates/forms/article.php';
            } else if (isset($_GET['action']) && $_GET['action'] == 'articles') {
                include $themeDir . '/templates/articleList.php';
                include $themeDir . '/templates/pagination.php';
            }
        ?>
    </div>
</div>