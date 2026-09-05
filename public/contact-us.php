<?php
require __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

if (isset($_GET['service'])) {
    $service = $_GET['service'];
    $service = str_replace('-', ' ', $service);
    echo "<script>var service = '$service';</script>";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Page Title -->
    <title>Contact Us - Programmers City Software Hub | Software & IT Training</title>

    <!-- Primary Meta Tags -->
    <meta name="description" content="Get in touch with Programmers City Software Hub in Owerri, Nigeria. We offer custom software development and professional IT training. Contact us for a free consultation.">
    <meta name="keywords" content="Programmers City contact, software development company Nigeria, IT training Nigeria, contact software company, Owerri tech hub, software consultation">
    <meta name="robots" content="index, follow">

    <!-- Open Graph / Social Media Meta Tags -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="Contact Us - Programmers City Software Hub | Software & IT Training">
    <meta property="og:description" content="Get in touch with Programmers City Software Hub in Owerri, Nigeria. We offer custom software development and professional IT training. Contact us for a free consultation.">
    <meta property="og:url" content="https://programmerscity.com/contact-us">
    <meta property="og:site_name" content="Programmers City Software Hub">
    <meta property="og:image" content="https://programmerscity.com/public/assets/images/og-image.jpg">

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Contact Us - Programmers City Software Hub | Software & IT Training">
    <meta name="twitter:description" content="Get in touch with Programmers City Software Hub in Owerri, Nigeria. We offer custom software development and professional IT training. Contact us for a free consultation.">
    <meta name="twitter:image" content="https://programmerscity.com/public/assets/images/og-image.jpg">

    <!-- Canonical URL -->
    <link rel="canonical" href="https://programmerscity.com/contact-us">

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

    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "ContactPage",
            "name": "Contact Us - Programmers City Software Hub",
            "description": "Get in touch with Programmers City Software Hub in Owerri, Nigeria. We offer custom software development and professional IT training.",
            "url": "https://programmerscity.com/contact-us",
            "mainEntity": {
                "@type": "Organization",
                "name": "Programmers City Software Hub",
                "url": "https://programmerscity.com",
                "logo": "https://programmerscity.com/public/assets/images/logo.png",
                "address": {
                    "@type": "PostalAddress",
                    "streetAddress": "181 Douglas Road, By Wetheral Junction, Owerri-Aba Road",
                    "addressLocality": "Owerri",
                    "addressRegion": "Imo State",
                    "addressCountry": "NG"
                },
                "contactPoint": {
                    "@type": "ContactPoint",
                    "telephone": "+234-901-960-6166",
                    "contactType": "Sales",
                    "availableLanguage": ["English"]
                }
            }
        }
    </script>
    <script src="https://www.google.com/recaptcha/api.js?render=6Ldu_6otAAAAAEDiIz3CIIyAkSe6P0RQKEzdWMWT"></script>
</head>

<body class="bg-main-theme text-secondary font-inter">
    <?php include_once './components/header.html' ?>
    <main class="min-h-screen">
        <?php include_once './components/contact-us/contact-hero.html' ?>
        <?php include_once './components/contact-us/quick-info.html' ?>
        <?php include_once './components/contact-us/contact-form-section.html' ?>
    </main>
    <?php include_once './components/footer.html' ?>
    <?php include_once './components/home/chatbox.html' ?>


    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>

</html>