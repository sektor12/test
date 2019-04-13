<div class="promo-image">
    <?php foreach ($articleData[count($articleData) - 1]['files'] as $image): ?>
        <img src="/files/images/<?php print $image['filename']; ?>" />
    <?php endforeach; ?>
</div>