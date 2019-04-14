<div class="pagination">
    <?php if ($articlePagination['pages'] != 1): ?>
        <?php for ($i = 1; $i <= $articlePagination['pages']; $i++): ?>
            <?php $filter = $articlePagination['filter'] != 0 ? '&filter=' . $articlePagination['filter'] : '' ; ?>
            <a href="/admin/?action=articles&page=<?php print $i; print $filter; ?>" class="page <?php print $page == $i ? 'active' : '' ?>"><?php print $i; ?></a>
        <?php endfor; ?>
    <?php endif; ?>
</div>