<form action="/admin/?action=<?php print $_GET['action'] == 'editarticle' ? 'editarticle&id=' . $singleArticle['id'] : 'addarticle'; ?>" method="post" class="form add-article" enctype="multipart/form-data">
    <h2>
        <?php print $_GET['action'] == 'editarticle' ? 'Edit article' : 'Create new article' ?>
    </h2>

    <div class="form-field">
        <label for="title">Title: <span class="required">*</span></label>
        <input type="text" name="title" required value="<?php print isset($singleArticle) ? $singleArticle['title'] : ''; ?>"/>
    </div>
    
    <div class="form-field">
        <label for="password">Body: <span class="required">*</span></label>
        <textarea name="body" id="body" class="article-form-body" required><?php print isset($singleArticle) ? $singleArticle['body'] : ''; ?></textarea>
    </div>
    
    <div class="form-field article-images">
        <?php if (!isset($singleArticle)): ?>
            <label for="articleimage">Choose images:</label>
            <input name="articleimage[]" class="articleimage" type="file" />
        <?php else: ?>
            <?php foreach ($singleArticle['images'] as $image): ?>
                <div class="image">
                    <img src="/files/images/<?php print $image['filename']; ?>"/>
                    <a href="#" class="img-remove" id="<?php print $image['id']; ?>">Remove</a>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <a href="#" class="add-more-images">Add image</a>

    <div class="form-field">
        <?php if ($_GET['action'] == 'editarticle'): ?>
        <input type="hidden" name="articleid" value="<?php print $singleArticle['id']; ?>"/>
        <?php endif; ?>
        <input type="submit" name="saveArticle" value="Save" class="form-submit" />
    </div>
</form>