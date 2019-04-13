<?php include $themeDir . '/theme.php'; ?>
<?php foreach($cssFiles as $file): ?>
<link rel="stylesheet" href="/theme/backend/<?php print $config['mainBackendTheme']; ?>/css/<?php print $file; ?>"></script>
<?php endforeach; ?>
