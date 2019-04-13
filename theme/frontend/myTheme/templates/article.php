<article>
    <div class="inner-wrapper">
        <?php foreach ($articleData as $article): ?>
            <div class="single-article">
                <h1><?php print $article['title']; ?></h1>
                <?php print $article['body']; ?>
            </div>
        <?php endforeach; ?>
    </div>
</article>