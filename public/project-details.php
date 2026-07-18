<?php
require __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Get the slug from the URL
$slug = isset($_GET['slug']) ? htmlspecialchars($_GET['slug']) : '';

// Load projects from JSON
$jsonPath = __DIR__ . '/assets/data/projects.json';
$projects = [];
if (file_exists($jsonPath)) {
    $jsonContent = file_get_contents($jsonPath);
    $projects = json_decode($jsonContent, true);
}

// Find project by slug
$project = null;
foreach ($projects as $p) {
    if ($p['slug'] === $slug) {
        $project = $p;
        break;
    }
}

$notFound = ($project === null);

// SEO metadata
$pageTitle = $notFound ? 'Project Not Found | Programmers City' : ($project['title'] . ' | Programmers City');
$metaDescription = $notFound ? 'The project you are looking for could not be found.' : ($project['metaDescription'] ?? $project['short_description']);
$metaKeywords = $notFound ? '' : ($project['metaKeywords'] ?? '');
$canonicalUrl = $notFound ? '' : ($project['canonicalUrl'] ?? '');
$ogTitle = $notFound ? 'Project Not Found' : ($project['ogTitle'] ?? $project['title']);
$ogDescription = $notFound ? '' : ($project['ogDescription'] ?? $project['short_description']);
$ogImage = $notFound ? '' : ($project['ogImage'] ?? $project['image']);
$twitterTitle = $notFound ? 'Project Not Found' : ($project['twitterTitle'] ?? $ogTitle);
$twitterDescription = $notFound ? '' : ($project['twitterDescription'] ?? $ogDescription);
$twitterImage = $notFound ? '' : ($project['twitterImage'] ?? $ogImage);

// Helper for absolute URLs
function absoluteUrl($path)
{
    if (empty($path)) return '';
    if (filter_var($path, FILTER_VALIDATE_URL)) return $path;
    if (strpos($path, '/') === 0) {
        return 'https://' . $_SERVER['HTTP_HOST'] . $path;
    }
    return 'https://' . $_SERVER['HTTP_HOST'] . '/' . ltrim($path, './');
}
$ogImageAbsolute = absoluteUrl($ogImage);
$twitterImageAbsolute = absoluteUrl($twitterImage);

// JSON-LD for Project
$jsonLd = null;
if (!$notFound) {
    $jsonLd = [
        '@context' => 'https://schema.org',
        '@type' => 'Project',
        'name' => $project['title'],
        'description' => $project['full_description'] ?? $project['short_description'],
        'url' => $canonicalUrl,
        'image' => $ogImageAbsolute,
        'author' => [
            '@type' => 'Organization',
            'name' => 'Programmers City Software Hub'
        ],
        'client' => [
            '@type' => 'Organization',
            'name' => $project['client']
        ],
        'datePublished' => $project['year'] . '-01-01',
        'keywords' => implode(', ', $project['technologies'] ?? []),
    ];
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
    <?php if ($canonicalUrl): ?>
        <meta property="og:url" content="<?php echo htmlspecialchars($canonicalUrl); ?>">
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

    <!-- Asset links -->
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

        .tech-tag {
            background: rgba(0, 122, 255, 0.08);
            border: 1px solid rgba(0, 122, 255, 0.15);
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            color: var(--color-secondary-light);
        }

        .tech-tag:hover {
            background: rgba(0, 122, 255, 0.15);
        }
    </style>
</head>

<body class="bg-main-theme text-secondary font-inter">
    <?php include_once './components/header.html'; ?>
    <main>

        <?php if ($notFound): ?>
            <div class="max-w-2xl mx-auto px-4 py-20 text-center">
                <iconify-icon icon="mdi:alert-circle-outline" width="64" height="64" class="text-primary mx-auto mb-4"></iconify-icon>
                <h2 class="text-3xl font-bold text-secondary mb-4">Project Not Found</h2>
                <p class="text-secondary-light mb-8">We couldn't find the project you're looking for. Please check the URL or explore our portfolio.</p>
                <a href="/portfolio" class="inline-block bg-primary hover:bg-primary-dark text-white font-medium px-8 py-3 rounded-full shadow-lg transition-all duration-300">
                    View All Projects
                </a>
            </div>
        <?php else: ?>

            <!-- ======= PROJECT HERO ======= -->
            <section class="relative py-6 overflow-hidden">
                <div class="corner-accent-top-right lg:w-16 lg:h-16 hidden lg:block"></div>
                <div class="corner-accent-bottom-left lg:w-16 lg:h-16 hidden lg:block"></div>
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                    <div class="flex flex-col lg:flex-row items-center gap-10 lg:gap-16 bg-white px-4 py-6 md:p-12 lg:p-16 rounded-3xl shadow-xl border border-theme-light/30" data-aos="fade-up">
                        <div class="lg:w-1/2 flex flex-col gap-5">
                            <a href="./portfolio" class="text-primary text-sm font-bold uppercase w-fit inline-flex gap-2 items-center px-2 py-1">
                                <iconify-icon icon="mdi:arrow-left" width="24" height="24"></iconify-icon>
                                <span>Back to Portfolio</span>
                            </a>
                            <div class="text-primary bg-primary-light w-fit py-1 px-3.5 rounded-full text-xs font-bold uppercase tracking-wider"><?php echo $project['tag']; ?></div>
                            <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-secondary leading-tight"><?php echo $project['title']; ?></h1>
                            <p class="text-secondary-light text-base md:text-lg leading-relaxed"><?php echo $project['short_description']; ?></p>
                            <?php if (isset($project['link']) && $project['link']): ?>
                                <a href="<?php echo $project['link']; ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 bg-primary hover:bg-primary-dark text-white font-medium px-6 py-3 rounded-full shadow-lg shadow-primary/20 transition-all duration-300 hover:-translate-y-0.5 w-fit">
                                    Visit Website
                                    <iconify-icon icon="mdi:arrow-right" width="18" height="18"></iconify-icon>
                                </a>
                            <?php endif; ?>
                        </div>
                        <div class="lg:w-1/2 rounded-2xl overflow-hidden shadow-md border border-theme-light/40 h-64 md:h-80 w-full">
                            <img src="<?php echo $project['image']; ?>" alt="<?php echo $project['title']; ?>" class="w-full h-full object-cover" loading="lazy" />
                        </div>
                    </div>
                </div>
            </section>

            <!-- ======= PROJECT DETAILS ======= -->
            <section class="py-16 lg:py-20 bg-white border-t border-theme-light/30">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-12">

                        <!-- Main Content -->
                        <div class="lg:col-span-2">
                            <h2 class="text-2xl md:text-3xl font-bold text-secondary mb-4">Project Overview</h2>
                            <p class="text-secondary-light text-base leading-relaxed"><?php echo $project['full_description']; ?></p>

                            <?php if (!empty($project['contributions'])): ?>
                                <h3 class="text-xl font-bold text-secondary mt-8 mb-4">Our Contributions</h3>
                                <ul class="space-y-3">
                                    <?php foreach ($project['contributions'] as $contribution): ?>
                                        <li class="flex items-start gap-3 text-secondary-light">
                                            <iconify-icon icon="mdi:check-circle" width="20" height="20" class="text-primary mt-1 shrink-0"></iconify-icon>
                                            <span><?php echo $contribution; ?></span>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div>

                        <!-- Sidebar -->
                        <div class="lg:col-span-1">
                            <div class="bg-main-theme rounded-2xl p-6 lg:p-8 border border-theme-light/60">
                                <h4 class="font-bold text-secondary text-lg mb-4">Project Details</h4>

                                <div class="space-y-4">
                                    <div>
                                        <p class="text-xs font-bold uppercase tracking-wider text-secondary-light">Client</p>
                                        <p class="text-secondary font-medium"><?php echo $project['client']; ?></p>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold uppercase tracking-wider text-secondary-light">Year</p>
                                        <p class="text-secondary font-medium"><?php echo $project['year']; ?></p>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold uppercase tracking-wider text-secondary-light">Role</p>
                                        <p class="text-secondary font-medium"><?php echo $project['role']; ?></p>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold uppercase tracking-wider text-secondary-light">Technologies</p>
                                        <div class="flex flex-wrap gap-2 mt-2">
                                            <?php foreach ($project['technologies'] as $tech): ?>
                                                <span class="tech-tag"><?php echo $tech; ?></span>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                    <?php if (isset($project['link']) && $project['link']): ?>
                                        <div class="pt-4 border-t border-theme-light/60">
                                            <a href="<?php echo $project['link']; ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 text-primary hover:text-primary-dark font-medium transition-colors">
                                                Visit Live Project
                                                <iconify-icon icon="mdi:arrow-right" width="18" height="18"></iconify-icon>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Gallery (if images exist) -->
                            <?php if (!empty($project['gallery_images']) && count($project['gallery_images']) > 0): ?>
                                <div class="bg-main-theme rounded-2xl p-6 lg:p-8 border border-theme-light/60 mt-4">
                                    <h4 class="font-bold text-secondary text-lg mb-4">Gallery</h4>
                                    <div class="grid grid-cols-2 gap-3">
                                        <?php foreach (array_slice($project['gallery_images'], 0, 4) as $img): ?>
                                            <div class="rounded-xl overflow-hidden border border-theme-light/60 h-24">
                                                <img src="<?php echo $img; ?>" alt="Project screenshot" class="w-full h-full object-cover" loading="lazy" />
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>
            </section>

            <!-- ======= BOTTOM CTA ======= -->
            <section class="px-4 sm:px-6 lg:px-8 pb-16 lg:pb-24 bg-white">
                <div data-aos="fade-up" class="max-w-7xl mx-auto bg-secondary rounded-3xl p-8 sm:p-10 lg:p-16 text-center shadow-2xl border border-white/10">
                    <h3 class="text-2xl md:text-3xl lg:text-4xl font-bold text-white mb-4">Ready to Build Your Next Project?</h3>
                    <p class="text-primary-light/70 text-base md:text-lg max-w-2xl mx-auto mb-8">
                        Let's discuss how we can bring your vision to life. Our team is ready to deliver exceptional results.
                    </p>
                    <div class="flex flex-col sm:flex-row justify-center gap-4">
                        <a href="/contact-us?project=<?php echo $project['slug']; ?>" class="inline-block bg-primary hover:bg-primary-dark text-white font-medium py-3 px-8 rounded-full shadow-lg transition-all duration-300 hover:-translate-y-0.5">
                            Start Your Project
                        </a>
                        <a href="/portfolio" class="inline-block bg-white hover:bg-theme-light text-secondary font-medium py-3 px-8 rounded-full shadow-lg transition-all duration-300 hover:-translate-y-0.5">
                            View More Projects
                        </a>
                    </div>
                </div>
            </section>

        <?php endif; ?>

    </main>
    <?php include_once './components/footer.php'; ?>

    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init();
        document.querySelectorAll('a[href="/portfolio"]').forEach(el => el.classList.add('active'));
    </script>
</body>

</html>