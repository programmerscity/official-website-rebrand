<?php
require __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Get the slug from the URL query string
$slug = isset($_GET['slug']) ? htmlspecialchars($_GET['slug']) : '';

// Load services from JSON
$jsonPath = __DIR__ . '/assets/data/procity-services.json';
$services = [];
if (file_exists($jsonPath)) {
    $jsonContent = file_get_contents($jsonPath);
    $services = json_decode($jsonContent, true);
}

// Find service by slug
$service = null;
foreach ($services as $s) {
    if ($s['slug'] === $slug) {
        $service = $s;
        break;
    }
}

$notFound = ($service === null);

// SEO metadata (fallback values)
$pageTitle = $notFound ? 'Service Not Found | Programmers City' : ($service['pageTitle'] ?? $service['title'] . ' | Programmers City');
$metaDescription = $notFound ? 'The service you are looking for could not be found.' : ($service['metaDescription'] ?? '');
$metaKeywords = $notFound ? '' : ($service['metaKeywords'] ?? '');
$canonicalUrl = $notFound ? '' : ($service['canonicalUrl'] ?? '');
$ogTitle = $notFound ? 'Service Not Found' : ($service['ogTitle'] ?? $pageTitle);
$ogDescription = $notFound ? '' : ($service['ogDescription'] ?? $metaDescription);
$ogImage = $notFound ? '' : ($service['ogImage'] ?? '');
$ogUrl = $notFound ? '' : ($service['ogUrl'] ?? $canonicalUrl);
$twitterTitle = $notFound ? 'Service Not Found' : ($service['twitterTitle'] ?? $ogTitle);
$twitterDescription = $notFound ? '' : ($service['twitterDescription'] ?? $ogDescription);
$twitterImage = $notFound ? '' : ($service['twitterImage'] ?? $ogImage);

// Helper to convert relative paths to absolute URLs for OG/Twitter images
function absoluteUrl($path)
{
    if (empty($path)) return '';
    if (filter_var($path, FILTER_VALIDATE_URL)) return $path;
    // If it starts with '/', assume root-relative
    if (strpos($path, '/') === 0) {
        return 'https://' . $_SERVER['HTTP_HOST'] . $path;
    }
    return 'https://' . $_SERVER['HTTP_HOST'] . '/' . ltrim($path, './');
}
$ogImageAbsolute = absoluteUrl($ogImage);
$twitterImageAbsolute = absoluteUrl($twitterImage);

// Generate JSON-LD
$jsonLd = null;
if (!$notFound) {
    $jsonLd = [
        '@context' => 'https://schema.org',
        '@type' => 'Service',
        'name' => $service['title'],
        'description' => $service['heroDescription'] ?? $service['overviewDescription'] ?? '',
        'provider' => [
            '@type' => 'Organization',
            'name' => 'Programmers City Software Hub',
            'url' => 'https://programmerscity.com'
        ],
        'url' => $canonicalUrl,
    ];
    if ($ogImageAbsolute) {
        $jsonLd['image'] = $ogImageAbsolute;
    }
    $jsonLd = json_encode($jsonLd, JSON_UNESCAPED_SLASHES);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <?php if ($metaDescription): ?>
        <meta name="description" content="<?php echo htmlspecialchars($metaDescription); ?>">
    <?php endif; ?>
    <?php if ($metaKeywords): ?>
        <meta name="keywords" content="<?php echo htmlspecialchars($metaKeywords); ?>">
    <?php endif; ?>
    <meta name="robots" content="index, follow">
    <?php if ($canonicalUrl): ?>
        <link rel="canonical" href="<?php echo htmlspecialchars($canonicalUrl); ?>">
    <?php endif; ?>

    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?php echo htmlspecialchars($ogTitle); ?>">
    <?php if ($ogDescription): ?>
        <meta property="og:description" content="<?php echo htmlspecialchars($ogDescription); ?>">
    <?php endif; ?>
    <?php if ($ogImageAbsolute): ?>
        <meta property="og:image" content="<?php echo htmlspecialchars($ogImageAbsolute); ?>">
    <?php endif; ?>
    <?php if ($ogUrl): ?>
        <meta property="og:url" content="<?php echo htmlspecialchars($ogUrl); ?>">
    <?php endif; ?>
    <meta property="og:site_name" content="Programmers City Software Hub">

    <!-- Twitter Cards -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo htmlspecialchars($twitterTitle); ?>">
    <?php if ($twitterDescription): ?>
        <meta name="twitter:description" content="<?php echo htmlspecialchars($twitterDescription); ?>">
    <?php endif; ?>
    <?php if ($twitterImageAbsolute): ?>
        <meta name="twitter:image" content="<?php echo htmlspecialchars($twitterImageAbsolute); ?>">
    <?php endif; ?>

    <?php if ($jsonLd): ?>
        <script type="application/ld+json">
            <?php echo $jsonLd; ?>
        </script>
    <?php endif; ?>

    <link rel="stylesheet" href="<?php echo $_ENV['APP_ENV'] == 'dev' ? './public/css/dev_styles.css' : './public/css/styles.css' ?>" />
    <link rel="shortcut icon" href="./public/assets/images/favicon.png" type="image/*">
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@3.0.2/dist/iconify-icon.min.js"></script>
    <link rel="preconnect" href="https://googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <style>
        .corner-accent-top-right {
            position: absolute;
            top: 0;
            right: 0;
            width: 400px;
            height: 400px;
            background-color: var(--color-primary);
            clip-path: polygon(0 0, 100% 0, 100% 100%);
        }

        .corner-accent-bottom-left {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 400px;
            height: 400px;
            background-color: var(--color-primary);
            clip-path: polygon(0 100%, 100% 100%, 0 0);
        }

        .feature-icon-wrapper {
            background: rgba(0, 122, 255, 0.1);
            border-radius: 1rem;
            width: 4rem;
            height: 4rem;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .feature-icon-wrapper iconify-icon {
            color: var(--color-primary);
        }

        .process-step {
            transition: transform 0.3s ease;
        }

        .process-step:hover {
            transform: translateY(-4px);
        }
    </style>
</head>

<body class="bg-main-theme text-secondary font-inter">
    <?php include_once './components/header.html'; ?>
    <main>

        <?php if ($notFound): ?>
            <div class="max-w-2xl mx-auto px-4 py-20 text-center">
                <iconify-icon icon="mdi:alert-circle-outline" width="64" height="64" class="text-primary mx-auto mb-4"></iconify-icon>
                <h2 class="text-3xl font-bold text-secondary mb-4">Service Not Found</h2>
                <p class="text-secondary-light mb-8">We couldn't find the service you're looking for. Please check the URL or explore our full range of services.</p>
                <a href="/services" class="inline-block bg-primary hover:bg-primary-dark text-white font-medium px-8 py-3 rounded-full shadow-lg transition-all duration-300">
                    View All Services
                </a>
            </div>
        <?php else: ?>

            <!-- ======= HERO ======= -->
            <section class="relative py-6 overflow-hidden">
                <div class="corner-accent-top-right lg:w-16 lg:h-16 hidden lg:block"></div>
                <div class="corner-accent-bottom-left lg:w-16 lg:h-16 hidden lg:block"></div>
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                    <div class="flex flex-col lg:flex-row items-center gap-10 lg:gap-16 bg-white px-4 py-6 md:p-12 lg:p-16 rounded-3xl shadow-xl border border-theme-light/30" data-aos="fade-up">
                        <div class="lg:w-1/2 flex flex-col gap-5">
                            <a href="./our-services" class="text-primary text-sm font-bold uppercase w-fit inline-flex gap-2 items-center px-2 py-1">
                                <iconify-icon icon="mdi:arrow-left" width="24" height="24"></iconify-icon>
                                <span>Back to Our Service</span>
                            </a>
                            <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-secondary leading-tight"><?php echo htmlspecialchars($service['heroTitle']); ?></h1>
                            <p class="text-secondary-light text-base md:text-lg leading-relaxed"><?php echo htmlspecialchars($service['heroDescription']); ?></p>
                            <div class="flex flex-wrap items-center gap-2 md:gap-4 mt-2 text-xs sm:text-sm md:text-base">
                                <a href="./contact-us?service=<?php echo urlencode($service['slug']); ?>" class="bg-primary hover:bg-primary-dark text-white font-medium px-5 sm:px-6 py-3.5 rounded-full shadow-lg shadow-primary/20 transition-all duration-300 hover:-translate-y-0.5">
                                    <?php echo htmlspecialchars($service['ctaButtonText']); ?>
                                </a>
                                <a href="#process" class="bg-transparent border-2 border-secondary/20 hover:border-primary text-secondary font-medium px-5 sm:px-6 py-3.5 rounded-full transition-all duration-300">How We Work</a>
                            </div>
                        </div>
                        <div class="lg:w-1/2 rounded-2xl overflow-hidden shadow-md border border-theme-light/40 h-64 md:h-80 w-full">
                            <img src="<?php echo htmlspecialchars($service['heroImage']); ?>" alt="<?php echo htmlspecialchars($service['imageAlt']); ?>" class="w-full h-full object-cover" loading="lazy" />
                        </div>
                    </div>
                </div>
            </section>

            <!-- ======= OVERVIEW / STATS ======= -->
            <section class="py-16 lg:py-20 bg-white border-t border-theme-light/30">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                        <div data-aos="fade-right">
                            <h2 class="text-3xl md:text-4xl font-bold text-secondary leading-tight"><?php echo htmlspecialchars($service['overviewTitle']); ?></h2>
                            <p class="text-secondary-light text-base leading-relaxed mt-4"><?php echo htmlspecialchars($service['overviewDescription']); ?></p>
                        </div>
                        <div class="grid grid-cols-2 gap-4" data-aos="fade-left">
                            <div class="bg-main-theme p-6 rounded-2xl text-center border border-theme-light/60">
                                <span class="block text-3xl font-bold text-primary"><?php echo htmlspecialchars($service['stat1']); ?></span>
                                <span class="text-sm text-secondary-light"><?php echo htmlspecialchars($service['stat1Label']); ?></span>
                            </div>
                            <div class="bg-main-theme p-6 rounded-2xl text-center border border-theme-light/60">
                                <span class="block text-3xl font-bold text-primary"><?php echo htmlspecialchars($service['stat2']); ?></span>
                                <span class="text-sm text-secondary-light"><?php echo htmlspecialchars($service['stat2Label']); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- ======= FEATURES ======= -->
            <section id="process" class="py-16 lg:py-24 bg-main-theme border-t border-theme-light/30">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <h2 data-aos="fade-up" class="text-3xl md:text-4xl font-bold text-secondary text-center mb-12 lg:mb-16"><?php echo htmlspecialchars($service['featuresTitle']); ?></h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <?php foreach ($service['features'] as $index => $feature): ?>
                            <div data-aos="fade-up" data-aos-delay="<?php echo 100 + ($index * 50); ?>" class="bg-white p-6 lg:p-8 rounded-2xl border border-theme-light/60 shadow-sm hover:shadow-md transition-all flex flex-col gap-4">
                                <div class="feature-icon-wrapper">
                                    <iconify-icon icon="<?php echo htmlspecialchars($feature['icon']); ?>" width="28" height="28"></iconify-icon>
                                </div>
                                <h4 class="font-bold text-secondary text-lg"><?php echo htmlspecialchars($feature['title']); ?></h4>
                                <p class="text-sm text-secondary-light leading-relaxed"><?php echo htmlspecialchars($feature['description']); ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>

            <!-- ======= PROCESS ======= -->
            <section class="py-16 lg:py-24 bg-white border-t border-theme-light/30">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <h2 data-aos="fade-up" class="text-3xl md:text-4xl font-bold text-secondary text-center mb-4">Our Process</h2>
                    <p class="text-center text-secondary-light max-w-2xl mx-auto mb-12"><?php echo htmlspecialchars($service['processSubtext']); ?></p>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div data-aos="fade-up" data-aos-delay="100" class="process-step text-center">
                            <div class="w-16 h-16 rounded-full bg-primary text-white text-2xl font-bold flex items-center justify-center mx-auto mb-4">1</div>
                            <h4 class="font-bold text-secondary">Discovery</h4>
                            <p class="text-sm text-secondary-light">We understand your goals and challenges.</p>
                        </div>
                        <div data-aos="fade-up" data-aos-delay="150" class="process-step text-center">
                            <div class="w-16 h-16 rounded-full bg-primary text-white text-2xl font-bold flex items-center justify-center mx-auto mb-4">2</div>
                            <h4 class="font-bold text-secondary">Strategy</h4>
                            <p class="text-sm text-secondary-light">We design the right solution architecture.</p>
                        </div>
                        <div data-aos="fade-up" data-aos-delay="200" class="process-step text-center">
                            <div class="w-16 h-16 rounded-full bg-primary text-white text-2xl font-bold flex items-center justify-center mx-auto mb-4">3</div>
                            <h4 class="font-bold text-secondary">Execution</h4>
                            <p class="text-sm text-secondary-light">We build, test, and deploy with precision.</p>
                        </div>
                        <div data-aos="fade-up" data-aos-delay="250" class="process-step text-center">
                            <div class="w-16 h-16 rounded-full bg-primary text-white text-2xl font-bold flex items-center justify-center mx-auto mb-4">4</div>
                            <h4 class="font-bold text-secondary">Optimization</h4>
                            <p class="text-sm text-secondary-light">We monitor, iterate, and scale.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- ======= BOTTOM CTA ======= -->
            <section class="px-4 sm:px-6 lg:px-8 pb-16 lg:pb-24 bg-white">
                <div data-aos="fade-up" class="max-w-7xl mx-auto bg-secondary rounded-3xl p-8 sm:p-10 lg:p-16 text-center shadow-2xl border border-white/10">
                    <h3 class="text-2xl md:text-3xl lg:text-4xl font-bold text-white mb-4"><?php echo htmlspecialchars($service['ctaHeading']); ?></h3>
                    <p class="text-primary-light/70 text-base md:text-lg max-w-2xl mx-auto mb-8"><?php echo htmlspecialchars($service['ctaDescription']); ?></p>
                    <div class="flex flex-col sm:flex-row justify-center gap-4">
                        <a href="./contact-us?service=<?php echo urlencode($service['slug']); ?>" class="inline-block bg-primary hover:bg-primary-dark text-white font-medium py-3 px-8 rounded-full shadow-lg transition-all duration-300 hover:-translate-y-0.5">
                            <?php echo htmlspecialchars($service['ctaButton']); ?>
                        </a>
                        <a href="./our-services" class="inline-block bg-white hover:bg-theme-light text-secondary font-medium py-3 px-8 rounded-full shadow-lg transition-all duration-300 hover:-translate-y-0.5">
                            Explore All Services
                        </a>
                    </div>
                </div>
            </section>

        <?php endif; ?>

    </main>
    <?php include_once './components/footer.php' ?>

    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init({
            once: true,
            offset: 20
        });
        // Set the anchor tag with hyper-reffernce (href) "./our-services" to active
        document.querySelectorAll('a[href="./our-services"]').forEach(el => el.classList.add('active'));
    </script>
</body>

</html>