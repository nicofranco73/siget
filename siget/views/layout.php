<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= isset($title) ? htmlspecialchars($title) . ' - SIGET' : 'SIGET' ?></title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/custom.css">
</head>
<body class="theme-light">

    <div class="wrapper">
        <?php require __DIR__ . '/partials/sidebar.php'; ?>

        <div id="content-wrapper" class="d-flex flex-column min-vh-100">
            
            <?php require __DIR__ . '/partials/header.php'; ?>

            <main class="container-fluid px-4 py-4">
                <?= $content ?? '' ?>
            </main>

            <?php require __DIR__ . '/partials/footer.php'; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/theme.js"></script>

</body>
</html>