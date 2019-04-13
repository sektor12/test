<?php include $themeDir . '/theme.php'; ?>
<?php foreach($javascriptFiles as $file): ?>
<script type="text/javascript" src="/theme/backend/<?php print $config['mainBackendTheme']; ?>/js/<?php print $file; ?>"></script>
<?php endforeach; ?>
