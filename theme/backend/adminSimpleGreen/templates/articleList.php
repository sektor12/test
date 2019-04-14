<?php include_once $themeDir . '/templates/forms/filterByUser.php'; ?>
<table class="article-list" cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Body</th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($articleList as $article): ?>
            <tr>
                <td><?php print $article['id']; ?></td>
                <td><?php print $article['title']; ?></td>
                <td><?php print $article['body']; ?></td>
                <td><a href="/?page=article&articleid=<?php print $article['id']; ?>" target="_blank">Preview</a></td>
                <td><a href="/admin/?action=editarticle&id=<?php print $article['id']; ?>">Edit</a></td>
                <td><a href="/admin/?action=articles&method=delete&id=<?php print $article['id']; ?>" class="delete-btn">Delete</a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
