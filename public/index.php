<?php
require __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..\/');
$dotenv->load();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome - <?php echo $_ENV['APP_NAME'] ?? 'Procity' ?></title>
    <link rel="stylesheet" href="<?php echo $_ENV['APP_ENV'] == 'dev' ? './css/dev_styles.css' : './css/styles.css' ?>" />
    <link rel="shortcut icon" href="./assets/images/favicon.png" type="image/*">
    <!-- Browser Iconify Library: https://icon-sets.iconify.design/ -->
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@3.0.2/dist/iconify-icon.min.js"></script>
</head>

<body>
    <?php include_once './components/header.html' ?>
    <main class="min-h-screen">
        <h1>
            Hello, <?php echo $_ENV['APP_NAME'] ?? 'Procity' ?>
        </h1>
        <iconify-icon icon="heroicons-outline:chat" class="text-primary text-7xl"></iconify-icon>

        <img src="./assets/images/icon.png" alt="logo">

    </main>
    <?php include_once './components/footer.html' ?>
</body>

</html>