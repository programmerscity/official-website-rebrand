<?php
require __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome - <?php echo $_ENV['APP_NAME'] ?? 'Procity' ?></title>
    <link rel="stylesheet" href="<?php echo $_ENV['APP_ENV'] == 'dev' ? './public/css/dev_styles.css' : './public/css/styles.css' ?>" />
    <link rel="shortcut icon" href="./public/assets/images/favicon.png" type="image/*">
    <!-- Browser Iconify Library: https://icon-sets.iconify.design/ -->
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@3.0.2/dist/iconify-icon.min.js"></script>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <!-- AOS Animation Library : REFEERENCE - https://michalsnik.github.io/aos/ -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
</head>

<body class="bg-main-theme text-secondary font-inter">
    <?php include_once './components/header.html' ?>
    <main class="min-h-screen">
        <?php include_once './components/home/hero.html' ?>
        <?php include_once './components/home/choose-path.html' ?>
        <?php include_once './components/home/services.html' ?>
        <?php include_once './components/home/why-choose-us.html' ?>
        <?php include_once './components/home/blog-section.html' ?>
        <?php include_once './components/home/what-our-client-says.html' ?>
        <?php include_once './components/home/our-process.html' ?>
        <?php include_once './components/home/featured-projects.html' ?>
        <?php include_once './components/portfolio/project-portfolio.html' ?>
    </main>
    <?php include_once './components/footer.html' ?>
    <?php include_once './components/home/chatbox.html' ?>


    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init();

        // Set the anchor tag with hyper-reffernce (href) "./" to active
        document.querySelectorAll('a[href="./"]').forEach(el => el.classList.add('active'));
    </script>
</body>

</html>