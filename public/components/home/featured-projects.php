<?php
// Load projects from JSON
$jsonPath = '../public/assets/data/projects.json';
$allProjects = [];

if (file_exists($jsonPath)) {
    $jsonContent = file_get_contents($jsonPath);
    $allProjects = json_decode($jsonContent, true);
}

// Filter featured projects and take only first 3
$featuredProjects = array_filter($allProjects, function ($p) {
    return isset($p['featured']) && $p['featured'] === true;
});
$featuredProjects = array_slice($featuredProjects, 0, 3);
?>

<section class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-3xl p-6 lg:p-10 shadow-sm border border-theme-light/30">

        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4 mb-10 max-w-6xl mx-auto">
            <div class="flex flex-col gap-2">
                <h2 class="text-3xl lg:text-[40px] text-secondary font-bold">
                    Featured Projects
                </h2>
                <p class="text-lg text-secondary-light font-normal">
                    Real results from our client partnerships
                </p>
            </div>

            <!-- View Portfolio Link -->
            <div class="flex items-center gap-1 group shrink-0">
                <a href="./portfolio" class="text-primary text-base font-medium hover:text-primary-dark transition-colors duration-300">
                    View Portfolio
                </a>
                <iconify-icon
                    class="text-primary duration-300 group-hover:text-primary-dark transform transition-all group-hover:translate-x-1"
                    icon="weui:arrow-outlined" width="12" height="24"></iconify-icon>
            </div>
        </div>

        <!-- Grid Layout -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 max-w-6xl mx-auto">

            <?php if (empty($featuredProjects)): ?>
                <!-- Fallback message if no featured projects are found -->
                <div class="col-span-3 text-center py-12 text-secondary-light">
                    <p>No featured projects available at the moment. Please check back soon.</p>
                </div>
            <?php else: ?>
                <?php foreach ($featuredProjects as $index => $project): ?>
                    <div data-aos="fade-up" data-aos-duration="800" data-aos-delay="<?php echo 100 + ($index * 100); ?>"
                        onclick="window.location.href = 'project-details.php?slug=<?php echo $project['slug']; ?>'"
                        class="bg-white border border-theme-light rounded-xl cursor-pointer hover:shadow-lg transition-all duration-300 group overflow-hidden">

                        <div class="overflow-hidden h-64 w-full">
                            <img
                                class="transform w-full h-full transition-transform duration-500 ease-in-out group-hover:scale-105 object-cover"
                                src="<?php echo $project['image']; ?>"
                                alt="<?php echo $project['title']; ?>"
                                loading="lazy" />
                        </div>

                        <div class="p-6 flex flex-col gap-2">
                            <!-- Tag/Badge -->
                            <?php if (isset($project['tag'])): ?>
                                <span class="text-primary bg-primary-light text-xs font-bold uppercase tracking-wider w-fit py-1 px-3 rounded-full mb-1"><?php echo $project['tag']; ?></span>
                            <?php endif; ?>
                            <h3 class="font-bold text-lg md:text-xl mb-1 text-secondary">
                                <?php echo $project['title']; ?>
                            </h3>
                            <p class="text-secondary-light text-base leading-relaxed">
                                <?php echo $project['short_description']; ?>
                            </p>
                        </div>

                        <div class="px-6 pb-6 flex items-center gap-1.5 group/link text-primary pt-1">
                            <span class="font-medium transition-colors duration-300 group-hover/link:text-primary-dark">
                                View Case Study
                            </span>
                            <iconify-icon
                                class="text-primary group-hover/link:text-primary-dark duration-300 transform transition-all group-hover/link:translate-x-1"
                                icon="weui:arrow-outlined" width="12" height="24"></iconify-icon>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

        </div>
    </div>
</section>