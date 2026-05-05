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
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <!-- AOS Animation Library : REFEERENCE - https://michalsnik.github.io/aos/ -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
</head>

<body>
    <?php include_once './components/header.html' ?>
    <main class="min-h-screen">
        <?php include_once './components/home/hero.html' ?>
        <?php include_once './components/home/choose-path.html' ?>
        <?php include_once './components/home/services.html' ?>
        <?php include_once './components/home/why-choose-us.html' ?>

    </main>
    <?php include_once './components/footer.html' ?>
    <?php include_once './components/home/chatbox.html' ?>


    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>

</html>