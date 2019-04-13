<?php include $themeDir . '/theme.php'; ?>
<?php foreach($cssFiles as $file): ?>
<link rel="stylesheet" href="/theme/frontend/<?php print $config['mainFrontendTheme']; ?>/css/<?php print $file; ?>"></script>
<?php endforeach; ?>
