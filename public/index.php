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
    <!-- Page Title -->
    <title>Programmers City Software Hub - Software Development & IT Training in Nigeria</title>

    <!-- Primary Meta Tags -->
    <meta name="description" content="Programmers City is a leading software development and IT training company in Owerri, Nigeria. We build custom software, mobile apps, ERP systems, and train tech professionals. Get a free consultation today.">
    <meta name="keywords" content="software development company Nigeria, IT training Nigeria, custom software development, mobile app development, ERP solutions, UI/UX design, corporate training, digital transformation, programmers city, Owerri tech hub">
    <meta name="robots" content="index, follow">

    <!-- Open Graph / Social Media Meta Tags -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="Programmers City Software Hub - Software Development & IT Training in Nigeria">
    <meta property="og:description" content="Programmers City is a leading software development and IT training company in Owerri, Nigeria. We build custom software, mobile apps, ERP systems, and train tech professionals. Get a free consultation today.">
    <meta property="og:url" content="https://programmerscity.com/">
    <meta property="og:site_name" content="Programmers City Software Hub">
    <meta property="og:image" content="https://programmerscity.com/public/assets/images/og-image.jpg">

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Programmers City Software Hub - Software Development & IT Training in Nigeria">
    <meta name="twitter:description" content="Programmers City is a leading software development and IT training company in Owerri, Nigeria. We build custom software, mobile apps, ERP systems, and train tech professionals.">
    <meta name="twitter:image" content="https://programmerscity.com/public/assets/images/og-image.jpg">

    <!-- Canonical URL -->
    <link rel="canonical" href="https://programmerscity.com/">


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

    <!-- ===== JSON-LD STRUCTURED DATA ===== -->
    <!-- Organization & Website Schema -->
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "WebSite",
            "name": "Programmers City Software Hub",
            "url": "https://programmerscity.com",
            "description": "Programmers City is a leading software development and IT training company in Nigeria. We build custom software, mobile apps, ERP systems, and train tech professionals.",
            "potentialAction": {
                "@type": "SearchAction",
                "target": "https://programmerscity.com/search?q={search_term_string}",
                "query-input": "required name=search_term_string"
            },
            "about": {
                "@type": "Organization",
                "name": "Programmers City Software Hub",
                "url": "https://programmerscity.com",
                "logo": "https://programmerscity.com/public/assets/images/logo.png",
                "description": "Programmers City is a dual-purpose technology leader: a dedicated Software Development Hub and a comprehensive IT Training Institution.",
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
                },
                "sameAs": [
                    "https://www.facebook.com/programmerscityhub",
                    "https://www.instagram.com/programmers.city",
                    "https://www.linkedin.com/company/programmers-city",
                    "https://www.youtube.com/@programmerscity",
                    "https://x.com/programmerscity"
                ]
            }
        }
    </script>

    <!-- Service Offerings Schema -->
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "ItemList",
            "name": "Core Services at Programmers City Software Hub",
            "description": "Comprehensive software development and IT training services in Owerri, Nigeria.",
            "url": "https://programmerscity.com",
            "numberOfItems": 8,
            "itemListElement": [{
                    "@type": "ListItem",
                    "position": 1,
                    "name": "Custom Software Development",
                    "description": "Tailor‑made business software and enterprise systems that streamline operations and improve efficiency.",
                    "url": "https://programmerscity.com/service-details.php?slug=custom-software-development"
                },
                {
                    "@type": "ListItem",
                    "position": 2,
                    "name": "Mobile App Development",
                    "description": "Intuitive Android and iOS applications that keep your business accessible from anywhere.",
                    "url": "https://programmerscity.com/service-details.php?slug=mobile-app-development"
                },
                {
                    "@type": "ListItem",
                    "position": 3,
                    "name": "ERP & Business Automation",
                    "description": "Integrated ERP solutions that connect departments and automate workflows for real‑time business insights.",
                    "url": "https://programmerscity.com/service-details.php?slug=erp-business-automation"
                },
                {
                    "@type": "ListItem",
                    "position": 4,
                    "name": "UI/UX Design",
                    "description": "User‑focused interface design that improves usability, adoption, and customer satisfaction.",
                    "url": "https://programmerscity.com/service-details.php?slug=ui-ux-design"
                },
                {
                    "@type": "ListItem",
                    "position": 5,
                    "name": "Enterprise Software Development",
                    "description": "Secure, scalable software solutions for enterprise‑grade operations and legacy modernisation.",
                    "url": "https://programmerscity.com/service-details.php?slug=enterprise-software-development"
                },
                {
                    "@type": "ListItem",
                    "position": 6,
                    "name": "Corporate Training",
                    "description": "Practical ICT training in software development, cybersecurity, UI/UX design, data analysis, and more.",
                    "url": "https://programmerscity.com/service-details.php?slug=corporate-training"
                },
                {
                    "@type": "ListItem",
                    "position": 7,
                    "name": "Architectural & 3D Visualization",
                    "description": "Professional architectural drawings, 3D renderings, and construction documentation.",
                    "url": "https://programmerscity.com/service-details.php?slug=architectural-3d-visualization"
                },
                {
                    "@type": "ListItem",
                    "position": 8,
                    "name": "Digital Transformation Consulting",
                    "description": "Strategic consulting to evaluate processes and implement technology solutions for growth.",
                    "url": "https://programmerscity.com/service-details.php?slug=digital-transformation-consulting"
                }
            ]
        }
    </script>
</head>

<body class="bg-main-theme text-secondary font-inter">
    <?php include_once './components/header.html' ?>
    <main class="min-h-screen">
        <?php include_once './components/home/hero.html' ?>
        <?php include_once './components/home/choose-path.html' ?>
        <?php include_once './components/home/services.html' ?>
        <?php include_once './components/home/why-choose-us.html' ?>
        <?php // include_once './components/home/blog-section.html' 
        ?>
        <?php // include_once './components/home/what-our-client-says.html' 
        ?>
        <?php include_once './components/home/training-programs.html' ?>
        <?php include_once './components/home/our-process.html' ?>
        <?php include_once './components/home/featured-projects.php' ?>
    </main>
    <?php include_once './components/footer.php' ?>


    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init();

        // Set the anchor tag with hyper-reffernce (href) "./" to active
        document.querySelectorAll('a[href="./"]').forEach(el => el.classList.add('active'));
    </script>
</body>

</html>