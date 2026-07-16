<?php
header('Content-Type: application/xml; charset=utf-8');

// Load services from JSON
$servicesJson = __DIR__ . '/assets/data/procity-services.json';
$services = [];
if (file_exists($servicesJson)) {
    $services = json_decode(file_get_contents($servicesJson), true);
}

// Load projects from JSON
$projectsJson = __DIR__ . '/assets/data/projects.json';
$projects = [];
if (file_exists($projectsJson)) {
    $projects = json_decode(file_get_contents($projectsJson), true);
}

// Base URL
$baseUrl = 'https://programmerscity.com';
$today = date('Y-m-d');

// Start XML
echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:xhtml="http://www.w3.org/1999/xhtml"
        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">

    <!-- ===== MAIN PAGES ===== -->
    <url>
        <loc><?php echo $baseUrl; ?>/</loc>
        <lastmod><?php echo $today; ?></lastmod>
        <changefreq>weekly</changefreq>
        <priority>1.0</priority>
    </url>

    <url>
        <loc><?php echo $baseUrl; ?>/about-us</loc>
        <lastmod><?php echo $today; ?></lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.9</priority>
    </url>

    <url>
        <loc><?php echo $baseUrl; ?>/services</loc>
        <lastmod><?php echo $today; ?></lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.9</priority>
    </url>

    <url>
        <loc><?php echo $baseUrl; ?>/portfolio</loc>
        <lastmod><?php echo $today; ?></lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.9</priority>
    </url>

    <url>
        <loc><?php echo $baseUrl; ?>/contact-us</loc>
        <lastmod><?php echo $today; ?></lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
    </url>

    <!-- ===== SERVICES ===== -->
    <?php foreach ($services as $service): ?>
    <url>
        <loc><?php echo $baseUrl; ?>/service/<?php echo $service['slug']; ?></loc>
        <lastmod><?php echo $today; ?></lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
    </url>
    <?php endforeach; ?>

    <!-- ===== PROJECTS ===== -->
    <?php foreach ($projects as $project): ?>
    <url>
        <loc><?php echo $baseUrl; ?>/project/<?php echo $project['slug']; ?></loc>
        <lastmod><?php echo $today; ?></lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
    </url>
    <?php endforeach; ?>

</urlset>