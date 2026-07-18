<?php
require __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Load projects from JSON
$jsonPath = __DIR__ . '/assets/data/projects.json';
$projects = [];
if (file_exists($jsonPath)) {
    $jsonContent = file_get_contents($jsonPath);
    $projects = json_decode($jsonContent, true);
}

// Featured projects for the hero section (if needed)
$featuredProjects = array_filter($projects, function ($p) {
    return isset($p['featured']) && $p['featured'] === true;
});
$featuredProjects = array_slice($featuredProjects, 0, 3);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio - Programmers City Software Hub | Our Projects</title>
    <meta name="description" content="Explore our portfolio of successful projects including software development, e-commerce platforms, mobile apps, and enterprise solutions for clients across the UK, USA, and Africa.">
    <meta name="keywords" content="portfolio, software development projects, case studies, e-commerce, mobile apps, enterprise solutions, UK, USA, Nigeria">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="https://programmerscity.com/portfolio">

    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="Portfolio - Programmers City Software Hub | Our Projects">
    <meta property="og:description" content="Explore our portfolio of successful projects including software development, e-commerce platforms, mobile apps, and enterprise solutions.">
    <meta property="og:url" content="https://programmerscity.com/portfolio">
    <meta property="og:site_name" content="Programmers City Software Hub">
    <meta property="og:image" content="https://programmerscity.com/public/assets/images/og-image.jpg">

    <!-- Twitter Cards -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Portfolio - Programmers City Software Hub | Our Projects">
    <meta name="twitter:description" content="Explore our portfolio of successful projects including software development, e-commerce platforms, mobile apps, and enterprise solutions.">
    <meta name="twitter:image" content="https://programmerscity.com/public/assets/images/og-image.jpg">

    <link rel="stylesheet" href="<?php echo $_ENV['APP_ENV'] == 'dev' ? './public/css/dev_styles.css' : './public/css/styles.css' ?>" />
    <link rel="shortcut icon" href="./public/assets/images/favicon.png" type="image/*">
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@3.0.2/dist/iconify-icon.min.js"></script>
    <link rel="preconnect" href="https://googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
</head>

<body class="bg-main-theme text-secondary font-inter">
    <?php include_once './components/header.html'; ?>
    <main class="min-h-screen">

        <!-- ======= PORTFOLIO HERO ======= -->
        <?php include_once './components/portfolio/project-portfolio-hero.html'; ?>

        <!-- ======= PORTFOLIO GRID ======= -->
        <section class="bg-main-theme p-4 md:p-6 lg:p-10">
            <div class="bg-white py-10 px-4 md:py-14 md:px-8 lg:py-20 lg:px-12 rounded-2xl shadow-sm">
                <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                    <?php foreach ($projects as $index => $project): ?>
                        <?php if ($index < 3): ?>
                            <!-- Standard cards (first 3 projects) -->
                            <div data-aos="fade-up" data-aos-duration="800" data-aos-delay="<?php echo 100 + ($index * 50); ?>"
                                onclick="window.location.href = './project-details.php?slug=<?php echo $project['slug']; ?>'"
                                class="bg-main-theme border border-theme-light rounded-xl cursor-pointer hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group overflow-hidden col-span-1">
                                <div class="overflow-hidden h-52 md:h-56 lg:h-60 w-full">
                                    <img class="w-full h-full object-cover transform transition-transform duration-500 ease-in-out group-hover:scale-105"
                                        src="<?php echo $project['image']; ?>" alt="<?php echo $project['title']; ?>" loading="lazy" />
                                </div>
                                <div class="p-5 md:p-6">
                                    <h3 class="font-bold text-lg md:text-xl mb-2 text-secondary"><?php echo $project['title']; ?></h3>
                                    <p class="text-secondary-light text-sm md:text-base leading-relaxed"><?php echo $project['short_description']; ?></p>
                                </div>
                                <div class="px-5 pb-5 md:px-6 md:pb-6 flex items-center gap-1.5 group/link">
                                    <span class="text-primary font-medium transition-colors duration-300 group-hover/link:text-primary-dark">View Case Study</span>
                                    <iconify-icon class="text-primary transition-all duration-300 group-hover/link:text-primary-dark group-hover/link:translate-x-1"
                                        icon="weui:arrow-outlined" width="12" height="24"></iconify-icon>
                                </div>
                            </div>
                        <?php else: ?>
                            <?php break; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>

                    <?php
                    // After processing first 3, render the rest with the large cards pattern
                    $remainingProjects = array_slice($projects, 3);
                    $count = 0;
                    foreach ($remainingProjects as $index => $project):
                        $isLarge = ($count % 2 == 0 && $count > 0); // every 2nd item is large
                        $isCta = ($count == 3); // CTA card after 3 items
                    ?>

                        <?php if ($isCta): ?>
                            <!-- CTA Card -->
                            <div data-aos="fade-up" data-aos-duration="800" data-aos-delay="300"
                                class="rounded-xl bg-linear-to-br from-primary to-primary-dark p-8 md:p-10 shadow-lg flex flex-col justify-center items-center text-center col-span-1 lg:col-span-1">
                                <iconify-icon class="text-primary-light mb-4" icon="ic:baseline-rocket-launch" width="44" height="44"></iconify-icon>
                                <h3 class="font-semibold text-xl md:text-2xl text-white mb-3">Need a Technical Partner?</h3>
                                <p class="text-sm md:text-base text-primary-light/90 mb-6 leading-relaxed max-w-xs">
                                    Let's build your next architectural masterpiece together.
                                </p>
                                <a href="/contact-us" class="inline-block bg-main-theme text-primary font-medium py-3 px-8 rounded-full shadow-lg hover:bg-primary-dark hover:text-white hover:shadow-primary/30 transition-all duration-300 hover:-translate-y-1">
                                    Start a Project
                                </a>
                            </div>
                            <?php $count++;
                            continue; ?>
                        <?php endif; ?>

                        <?php if ($isLarge): ?>
                            <!-- Large Card (spans 2 cols) -->
                            <div data-aos="fade-up" data-aos-duration="800" data-aos-delay="<?php echo 250 + ($count * 50); ?>"
                                onclick="window.location.href = '/project-details.php?slug=<?php echo $project['slug']; ?>'"
                                class="flex flex-col md:flex-row rounded-xl border border-theme-light bg-main-theme shadow-sm overflow-hidden hover:shadow-xl transition-all duration-300 group/large-card cursor-pointer col-span-1 md:col-span-2 lg:col-span-2">
                                <div class="shrink-0 w-full md:w-56 lg:w-72 h-56 md:h-auto <?php echo ($count % 2 == 0) ? 'order-1 md:order-1' : 'order-1 md:order-2'; ?> overflow-hidden">
                                    <img class="w-full h-full object-cover transform transition-transform duration-500 ease-in-out group-hover/large-card:scale-105"
                                        src="<?php echo $project['image']; ?>" alt="<?php echo $project['title']; ?>" loading="lazy" />
                                </div>
                                <div class="flex flex-col justify-center gap-3 p-6 md:p-8 flex-1 <?php echo ($count % 2 == 0) ? 'order-2 md:order-2' : 'order-2 md:order-1'; ?>">
                                    <div class="text-primary bg-primary-light w-fit py-1 px-3.5 rounded-full text-xs font-bold uppercase tracking-wider"><?php echo $project['tag']; ?></div>
                                    <h3 class="font-semibold text-xl md:text-2xl text-secondary"><?php echo $project['title']; ?></h3>
                                    <p class="text-sm md:text-base text-secondary-light leading-relaxed"><?php echo $project['short_description']; ?></p>

                                    <?php if (!empty($project['technologies'])): ?>
                                        <div class="flex flex-wrap gap-2 mt-2">
                                            <?php foreach (array_slice($project['technologies'], 0, 3) as $tech): ?>
                                                <span class="bg-primary-light/20 text-secondary text-xs px-3 py-1 rounded-full"><?php echo $tech; ?></span>
                                            <?php endforeach; ?>
                                            <?php if (count($project['technologies']) > 3): ?>
                                                <span class="text-secondary-light text-xs px-3 py-1">+<?php echo count($project['technologies']) - 3; ?> more</span>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>

                                    <div class="flex items-center gap-1.5 group/link mt-2">
                                        <span class="text-primary font-medium transition-colors duration-300 group-hover/link:text-primary-dark">View Case Study</span>
                                        <iconify-icon class="text-primary transition-all duration-300 group-hover/link:text-primary-dark group-hover/link:translate-x-1"
                                            icon="weui:arrow-outlined" width="12" height="24"></iconify-icon>
                                    </div>
                                </div>
                            </div>
                        <?php else: ?>
                            <!-- Standard Card -->
                            <div data-aos="fade-up" data-aos-duration="800" data-aos-delay="<?php echo 150 + ($count * 50); ?>"
                                onclick="window.location.href = './project-details.php?slug=<?php echo $project['slug']; ?>'"
                                class="bg-main-theme border border-theme-light rounded-xl cursor-pointer hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group overflow-hidden col-span-1">
                                <div class="overflow-hidden h-52 md:h-56 lg:h-60 w-full">
                                    <img class="w-full h-full object-cover transform transition-transform duration-500 ease-in-out group-hover:scale-105"
                                        src="<?php echo $project['image']; ?>" alt="<?php echo $project['title']; ?>" loading="lazy" />
                                </div>
                                <div class="p-5 md:p-6">
                                    <div class="text-primary bg-primary-light w-fit py-1 px-3.5 rounded-full text-xs font-bold uppercase tracking-wider mb-2"><?php echo $project['tag']; ?></div>
                                    <h3 class="font-bold text-lg md:text-xl mb-2 text-secondary"><?php echo $project['title']; ?></h3>
                                    <p class="text-secondary-light text-sm md:text-base leading-relaxed"><?php echo $project['short_description']; ?></p>
                                </div>
                                <div class="px-5 pb-5 md:px-6 md:pb-6 flex items-center gap-1.5 group/link">
                                    <span class="text-primary font-medium transition-colors duration-300 group-hover/link:text-primary-dark">View Case Study</span>
                                    <iconify-icon class="text-primary transition-all duration-300 group-hover/link:text-primary-dark group-hover/link:translate-x-1"
                                        icon="weui:arrow-outlined" width="12" height="24"></iconify-icon>
                                </div>
                            </div>
                        <?php endif; ?>

                    <?php $count++;
                    endforeach; ?>

                </div>
            </div>
        </section>

    </main>
    <?php include_once './components/footer.php'; ?>

    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init();

        // Set active state for "Portfolio" nav link
        document.querySelectorAll('a[href="./portfolio"]').forEach(el => el.classList.add('active'));
    </script>
</body>

</html>