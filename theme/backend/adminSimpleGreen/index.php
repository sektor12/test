<!DOCTYPE html>
<html>
    <head>
        <title><?php print isset($_SESSION['uid']) ? 'Dashboard' : 'Login to continue'; ?></title>
        <?php include $themeDir . '/templates/head/styles.php'; ?>
        <?php include $themeDir . '/templates/head/scripts.php'; ?>
    </head>
    <body>
        <?php if (!isset($_SESSION['uid'])): ?>
            <?php include $themeDir . '/templates/messages.php'; ?>
        <?php endif; ?>

        <?php
            if (isset($_SESSION['uid'])) {
                include $themeDir . '/templates/dashboard.php';
            } else {
                include $themeDir . '/templates/forms/login.php';
            }
        ?>
    </body>
</html>