<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'OrgSync') ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/main.css">
</head>
<body class="auth-page">
    <main class="auth-container">
        <div class="auth-card-wrapper">
            <?php require APP_PATH . '/Views/partials/auth-branding.php'; ?>
            
            <section class="auth-form-panel">
                <div class="form-card">
                    <?= $content ?>
                </div>
            </section>
        </div>
    </main>

    <script>
        window.ORG_SYNC_BASE_URL = <?= json_encode(BASE_URL) ?>;
    </script>
    <script src="<?= BASE_URL ?>/assets/js/lucide.min.js"></script>
    <script src="<?= BASE_URL ?>/assets/js/auth.js"></script>
</body>
</html>
