<?php include $themeDir . '/theme.php'; ?>
<?php foreach($javascriptFiles as $file): ?>
<script type="text/javascript" src="/theme/frontend/<?php print $config['mainFrontendTheme']; ?>/js/<?php print $file; ?>"></script>
<?php endforeach; ?>
