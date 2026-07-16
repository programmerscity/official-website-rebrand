<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

require __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"><!-- Page Title -->
    <title>Our Services - Programmers City Software Hub | Software Dev & IT Training</title>

    <!-- Primary Meta Tags -->
    <meta name="description" content="Explore our comprehensive services: custom software development, mobile apps, ERP & automation, UI/UX design, enterprise solutions, corporate training, 3D visualization, and digital transformation consulting in Owerri, Nigeria.">
    <meta name="keywords" content="software development services Nigeria, IT training, custom software, mobile app development, ERP automation, UI/UX design, enterprise software, corporate training, digital transformation consulting, 3D visualization, Owerri, Nigeria">
    <meta name="robots" content="index, follow">

    <!-- Open Graph / Social Media Meta Tags -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="Our Services - Programmers City Software Hub | Software Dev & IT Training">
    <meta property="og:description" content="Explore our comprehensive services: custom software development, mobile apps, ERP & automation, UI/UX design, enterprise solutions, corporate training, 3D visualization, and digital transformation consulting.">
    <meta property="og:url" content="https://programmerscity.com/services">
    <meta property="og:site_name" content="Programmers City Software Hub">
    <meta property="og:image" content="https://programmerscity.com/public/assets/images/og-image.jpg">

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Our Services - Programmers City Software Hub | Software Dev & IT Training">
    <meta name="twitter:description" content="Explore our comprehensive services: custom software development, mobile apps, ERP & automation, UI/UX design, enterprise solutions, corporate training, 3D visualization, and digital transformation consulting.">
    <meta name="twitter:image" content="https://programmerscity.com/public/assets/images/og-image.jpg">

    <!-- Canonical URL -->
    <link rel="canonical" href="https://programmerscity.com/services">

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
            "@type": "ItemList",
            "name": "Services Offered by Programmers City Software Hub",
            "description": "Comprehensive software development and IT training services in Owerri, Nigeria.",
            "url": "https://programmerscity.com/services",
            "numberOfItems": 8,
            "itemListElement": [{
                    "@type": "ListItem",
                    "position": 1,
                    "name": "Custom Software Development",
                    "description": "Tailor‑made business software, enterprise systems, portals, and web applications that streamline operations, improve efficiency, and support long‑term growth.",
                    "url": "https://programmerscity.com/service-details.php?slug=custom-software-development"
                },
                {
                    "@type": "ListItem",
                    "position": 2,
                    "name": "Mobile App Development",
                    "description": "Intuitive Android and iOS applications that keep your customers connected and your business accessible from anywhere.",
                    "url": "https://programmerscity.com/service-details.php?slug=mobile-app-development"
                },
                {
                    "@type": "ListItem",
                    "position": 3,
                    "name": "ERP & Business Automation",
                    "description": "Integrated ERP solutions that connect departments, automate workflows, and provide real‑time business insights.",
                    "url": "https://programmerscity.com/service-details.php?slug=erp-business-automation"
                },
                {
                    "@type": "ListItem",
                    "position": 4,
                    "name": "UI/UX Design",
                    "description": "User‑focused interface and experience design that improves usability, adoption, and customer satisfaction.",
                    "url": "https://programmerscity.com/service-details.php?slug=ui-ux-design"
                },
                {
                    "@type": "ListItem",
                    "position": 5,
                    "name": "Enterprise Software Development",
                    "description": "Secure, scalable software solutions tailored to your organization's unique processes with enterprise‑grade reliability.",
                    "url": "https://programmerscity.com/service-details.php?slug=enterprise-software-development"
                },
                {
                    "@type": "ListItem",
                    "position": 6,
                    "name": "Corporate IT Training",
                    "description": "Practical ICT training in software development, cybersecurity, UI/UX design, data analysis, CAD, productivity tools, and emerging technologies.",
                    "url": "https://programmerscity.com/service-details.php?slug=corporate-training"
                },
                {
                    "@type": "ListItem",
                    "position": 7,
                    "name": "Architectural & 3D Visualization",
                    "description": "Professional architectural drawings, 3D visualisations, interior and exterior renderings, construction documentation, and presentation‑ready designs.",
                    "url": "https://programmerscity.com/service-details.php?slug=architectural-3d-visualization"
                },
                {
                    "@type": "ListItem",
                    "position": 8,
                    "name": "Digital Transformation & Technology Consulting",
                    "description": "Strategic consulting to evaluate existing processes, identify opportunities for improvement, and implement technology solutions that enhance productivity and accelerate innovation.",
                    "url": "https://programmerscity.com/service-details.php?slug=digital-transformation-consulting"
                }
            ]
        }
    </script>
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
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
                "https://www.linkedin.com/company/programmers-city"
            ]
        }
    </script>
</head>

<body class="bg-main-theme text-secondary font-inter">
    <?php include_once './components/header.html' ?>
    <main class="min-h-screen">
        <?php include_once './components/services/service-banner.html' ?>
        <?php include_once './components/services/our-services-section.html' ?>
    </main>
    <?php include_once './components/footer.html' ?>


    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init();

        // Set the anchor tag with hyper-reffernce (href) "./services" to active
        document.querySelectorAll('a[href="./services"]').forEach(el => el.classList.add('active'));
    </script>
</body>

</html>