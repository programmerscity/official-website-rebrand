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
    <title>About Us - Programmers City Software Hub | Nigeria's Premier Software Engineering & IT Training Company</title>

    <!-- Primary Meta Tags -->
    <meta name="description" content="Programmers City Software Hub (Procity Software Hub) is Nigeria's leading software development and IT training company. We deliver enterprise-grade software solutions and world-class tech training from Owerri, Imo State. Trusted by governments and global organizations.">
    <meta name="keywords" content="Programmers City, Procity Software Hub, software development company Nigeria, IT training Nigeria, software engineering, enterprise software solutions, ERP systems, mobile app development, tech training Owerri, digital transformation Nigeria, custom software development, IT consulting Nigeria">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="https://programmerscity.com/about-us">

    <!-- Open Graph / Social Media Meta Tags -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="About Us - Programmers City Software Hub | Nigeria's Premier Software Engineering & IT Training Company">
    <meta property="og:description" content="Programmers City Software Hub (Procity Software Hub) is Nigeria's leading software development and IT training company. We deliver enterprise-grade software solutions and world-class tech training from Owerri.">
    <meta property="og:url" content="https://programmerscity.com/about-us">
    <meta property="og:site_name" content="Programmers City Software Hub">
    <meta property="og:image" content="https://programmerscity.com/public/assets/images/og-image.jpg">

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="About Us - Programmers City Software Hub | Nigeria's Premier Software Engineering & IT Training Company">
    <meta name="twitter:description" content="Programmers City Software Hub (Procity Software Hub) is Nigeria's leading software development and IT training company. We deliver enterprise-grade software solutions and world-class tech training.">
    <meta name="twitter:image" content="https://programmerscity.com/public/assets/images/og-image.jpg">

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

        .team-card-image img {
            transition: filter 0.5s ease, transform 0.5s ease;
        }

        .team-card-image:hover img {
            filter: grayscale(0%);
            transform: scale(1.03);
        }

        .partner-logo {
            filter: grayscale(100%) opacity(0.6);
            transition: filter 0.3s ease;
        }

        .partner-logo:hover {
            filter: grayscale(0%) opacity(1);
        }

        .value-icon-wrapper {
            width: 4rem;
            height: 4rem;
            min-width: 4rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 1rem;
            background-color: var(--color-primary-light);
            color: var(--color-primary);
            transition: all 0.3s ease;
        }

        .value-card:hover .value-icon-wrapper {
            background-color: var(--color-primary);
            color: #ffffff;
        }

        .stat-number {
            font-size: 3.5rem;
            line-height: 1;
            font-weight: 700;
            color: var(--color-primary);
        }

        @media (min-width: 768px) {
            .stat-number {
                font-size: 4.5rem;
            }
        }
    </style>

    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "Organization",
            "name": "Programmers City Software Hub",
            "alternateName": "Procity Software Hub",
            "url": "https://programmerscity.com",
            "logo": "https://programmerscity.com/public/assets/images/logo.png",
            "description": "Programmers City Software Hub (Procity Software Hub) is Nigeria's premier software development and IT training institution, delivering enterprise-grade solutions and world-class tech education.",
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
                "https://www.linkedin.com/company/programmers-city",
                "https://www.youtube.com/@programmerscity",
                "https://www.instagram.com/programmers.city",
                "https://www.facebook.com/programmerscityhub",
                "https://x.com/programmerscity"
            ]
        }
    </script>
</head>

<body class="bg-main-theme text-secondary font-inter">
    <?php include_once './components/header.html' ?>
    <main class="min-h-screen">

        <!-- ======= 1. HERO SECTION ======= -->
        <section class="relative py-12 overflow-hidden">
            <div class="corner-accent-top-right lg:w-16 lg:h-16 hidden lg:block"></div>
            <div class="corner-accent-bottom-left lg:w-16 lg:h-16 hidden lg:block"></div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

                <!-- Mobile View -->
                <div class="flex lg:hidden flex-col items-center text-center bg-linear-to-br from-primary to-primary-dark p-8 md:p-10 rounded-3xl shadow-xl gap-6">
                    <div class="inline-flex bg-white/90 text-primary items-center gap-2.5 px-4 py-1.5 rounded-full w-fit shadow-sm">
                        <iconify-icon icon="material-symbols:lock-outline" width="16" height="16"></iconify-icon>
                        <span class="text-xs font-bold uppercase tracking-wider">Our Story</span>
                    </div>

                    <h1 class="text-3xl md:text-4xl font-bold text-white leading-tight">
                        Africa's Trusted Partner for Digital Transformation
                    </h1>

                    <p class="text-primary-light text-base leading-relaxed max-w-2xl">
                        <strong class="text-white">Programmers City Software Hub</strong> — also known as <strong class="text-white">Procity Software Hub</strong> — is Nigeria's premier software engineering and IT training institution. From enterprise ERP systems to mobile applications, and from corporate training to digital transformation consulting, we deliver world-class technology solutions that drive business growth and innovation across Africa and beyond.
                    </p>

                    <div class="relative rounded-2xl overflow-hidden w-full max-w-sm mt-4 shadow-md border-2 border-white/20">
                        <img src="./public/assets/images/about-hero-image.jpg"
                            alt="Programmers City Software Hub - Team collaboration in modern workspace"
                            class="w-full h-auto object-cover"
                            loading="lazy" />
                    </div>
                </div>

                <!-- Desktop View -->
                <div data-aos="fade-up" data-aos-duration="800"
                    class="hidden lg:grid grid-cols-1 lg:grid-cols-2 bg-white p-6 sm:p-8 md:p-10 lg:p-14 rounded-3xl shadow-xl border border-theme-light/30 gap-10 lg:gap-16 items-center">

                    <div class="flex flex-col gap-6">
                        <div class="inline-flex bg-primary text-white items-center gap-2.5 px-4 py-1.5 rounded-full w-fit shadow-sm shadow-primary/20">
                            <iconify-icon icon="material-symbols:lock-outline" width="16" height="16"></iconify-icon>
                            <span class="text-xs font-bold uppercase tracking-wider">Our Story</span>
                        </div>

                        <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-secondary leading-tight">
                            Africa's Trusted Partner for Digital Transformation
                        </h1>

                        <p class="text-secondary-light text-base md:text-lg leading-relaxed">
                            <strong>Programmers City Software Hub</strong> — officially registered as <strong>Procity Software Hub</strong> — is Nigeria's premier software engineering and IT training institution. From enterprise ERP systems to mobile applications, and from corporate training to digital transformation consulting, we deliver world-class technology solutions that drive business growth and innovation across Africa and beyond.
                        </p>
                    </div>

                    <div class="relative rounded-2xl overflow-hidden h-75 md:h-100 shadow-md border border-theme-light/40">
                        <img src="./public/assets/images/about-hero-image.jpg"
                            alt="Programmers City Software Hub - Team collaboration in modern workspace"
                            class="w-full h-full object-cover"
                            loading="lazy" />
                    </div>
                </div>
            </div>
        </section>

        <!-- ======= 2. STATS DASHBOARD ======= -->
        <section class="py-16 lg:py-20 bg-white border-t border-theme-light/30">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 lg:gap-8 divide-x-0 md:divide-x divide-theme-light/50">
                    <div data-aos="fade-up" data-aos-delay="100" class="text-center">
                        <span class="block text-4xl lg:text-5xl font-bold text-primary">500+</span>
                        <span class="text-secondary-light text-sm font-medium">Professionals Trained</span>
                    </div>
                    <div data-aos="fade-up" data-aos-delay="200" class="text-center pl-0 md:pl-6 lg:pl-8">
                        <span class="block text-4xl lg:text-5xl font-bold text-primary">100+</span>
                        <span class="text-secondary-light text-sm font-medium">Projects Delivered</span>
                    </div>
                    <div data-aos="fade-up" data-aos-delay="300" class="text-center pl-0 md:pl-6 lg:pl-8">
                        <span class="block text-4xl lg:text-5xl font-bold text-primary">45+</span>
                        <span class="text-secondary-light text-sm font-medium">Global Partnerships</span>
                    </div>
                    <div data-aos="fade-up" data-aos-delay="400" class="text-center pl-0 md:pl-6 lg:pl-8">
                        <span class="block text-4xl lg:text-5xl font-bold text-primary">10+</span>
                        <span class="text-secondary-light text-sm font-medium">Government & Enterprise Engagements</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- ======= 3. WHO WE ARE & OUR STORY ======= -->
        <section class="py-16 lg:py-24 bg-main-theme">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col lg:flex-row gap-12 lg:gap-20">
                    <div class="lg:w-5/12 flex flex-col justify-center gap-6" data-aos="fade-right">
                        <span class="text-primary text-sm font-bold uppercase tracking-widest">Who We Are</span>
                        <h2 class="text-3xl md:text-4xl font-bold text-secondary leading-tight">Engineering the Future, One Solution at a Time</h2>
                        <p class="text-secondary-light text-base leading-relaxed">
                            <strong>Programmers City Software Hub</strong> — also known as <strong>Procity Software Hub</strong> — was founded with a singular vision: to bridge the gap between Africa's immense potential and the technology needed to unlock it. Headquartered in <strong>Owerri, Imo State, Nigeria</strong>, we have grown from a passionate team of developers into a recognized leader in software engineering and IT training.
                        </p>
                        <p class="text-secondary-light text-base leading-relaxed">
                            Our dual mandate — building world-class software solutions and training the next generation of tech talent — positions us uniquely in the African technology ecosystem. We don't just write code; we architect futures. We don't just teach; we transform careers.
                        </p>
                        <div class="flex flex-wrap gap-4 mt-2">
                            <div class="flex items-center gap-2">
                                <iconify-icon icon="mdi:check-circle" width="20" height="20" class="text-primary"></iconify-icon>
                                <span class="text-sm font-medium text-secondary">Registered as <strong>Procity Software Hub</strong></span>
                            </div>
                            <div class="flex items-center gap-2">
                                <iconify-icon icon="mdi:check-circle" width="20" height="20" class="text-primary"></iconify-icon>
                                <span class="text-sm font-medium text-secondary">Trusted by Governments & Enterprises</span>
                            </div>
                        </div>
                        <a href="./contact-us" class="w-fit bg-primary hover:bg-primary-dark text-white font-medium py-3 px-8 rounded-full shadow-lg shadow-primary/20 transition-all duration-300 hover:-translate-y-0.5 mt-4">
                            Partner With Us
                        </a>
                    </div>

                    <div class="lg:w-7/12 grid grid-cols-2 sm:grid-cols-2 gap-4" data-aos="fade-left">
                        <div class="bg-white p-6 rounded-2xl border border-theme-light/60 flex flex-col gap-4 hover:shadow-md transition-all">
                            <iconify-icon icon="mdi:application-outline" width="32" height="32" class="text-primary"></iconify-icon>
                            <h4 class="font-semibold text-secondary text-lg">Enterprise Software</h4>
                            <p class="text-sm text-secondary-light leading-relaxed">Custom software solutions that automate operations, streamline workflows, and drive organizational growth.</p>
                        </div>
                        <div class="bg-white p-6 rounded-2xl border border-theme-light/60 flex flex-col gap-4 hover:shadow-md transition-all">
                            <iconify-icon icon="material-symbols:phone-android" width="32" height="32" class="text-primary"></iconify-icon>
                            <h4 class="font-semibold text-secondary text-lg">Mobile Applications</h4>
                            <p class="text-sm text-secondary-light leading-relaxed">Native and cross-platform mobile apps for Android and iOS that connect businesses with customers.</p>
                        </div>
                        <div class="bg-white p-6 rounded-2xl border border-theme-light/60 flex flex-col gap-4 hover:shadow-md transition-all">
                            <iconify-icon icon="material-symbols:settings-applications" width="32" height="32" class="text-primary"></iconify-icon>
                            <h4 class="font-semibold text-secondary text-lg">Business Automation</h4>
                            <p class="text-sm text-secondary-light leading-relaxed">Intelligent automation solutions that eliminate manual processes and improve efficiency.</p>
                        </div>
                        <div class="bg-white p-6 rounded-2xl border border-theme-light/60 flex flex-col gap-4 hover:shadow-md transition-all">
                            <iconify-icon icon="mdi:cloud-check" width="32" height="32" class="text-primary"></iconify-icon>
                            <h4 class="font-semibold text-secondary text-lg">Cloud & Infrastructure</h4>
                            <p class="text-sm text-secondary-light leading-relaxed">Cloud deployment, hosting, maintenance, and infrastructure management for secure operations.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ======= 4. OUR VISION & MISSION ======= -->
        <section class="py-16 lg:py-20 bg-white border-t border-theme-light/30">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-12">
                    <div data-aos="fade-up" data-aos-delay="100" class="bg-primary-light/10 rounded-3xl p-8 lg:p-12 border border-primary-light/30">
                        <div class="w-14 h-14 bg-primary rounded-2xl flex items-center justify-center mb-6">
                            <iconify-icon icon="material-symbols:visibility-outline" width="28" height="28" class="text-white"></iconify-icon>
                        </div>
                        <h3 class="text-2xl font-bold text-secondary mb-4">Our Vision</h3>
                        <p class="text-secondary-light text-base leading-relaxed">
                            To be <strong>Africa's most trusted technology partner</strong> — recognized globally for engineering excellence, innovation, and the transformative power of our software and training programs. We envision a future where African businesses and professionals lead the global digital economy, powered by solutions built in Africa, for the world.
                        </p>
                    </div>
                    <div data-aos="fade-up" data-aos-delay="200" class="bg-primary/5 rounded-3xl p-8 lg:p-12 border border-primary/10">
                        <div class="w-14 h-14 bg-primary rounded-2xl flex items-center justify-center mb-6">
                            <iconify-icon icon="material-symbols:target" width="28" height="28" class="text-white"></iconify-icon>
                        </div>
                        <h3 class="text-2xl font-bold text-secondary mb-4">Our Mission</h3>
                        <p class="text-secondary-light text-base leading-relaxed">
                            To <strong>democratize technology excellence</strong> across Africa by delivering enterprise-grade software solutions and world-class IT training that empower organizations to innovate, professionals to excel, and communities to thrive — all from our home base in <strong>Owerri, Nigeria</strong>.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- ======= 5. IMPACT & GOVERNMENT PROJECTS ======= -->
        <section class="py-16 lg:py-24 bg-main-theme border-t border-theme-light/30">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-primary-light/10 rounded-3xl p-6 md:p-10 lg:p-16 border border-primary-light/30 flex flex-col lg:flex-row items-center gap-10 lg:gap-16" data-aos="zoom-in">

                    <div class="flex-1 flex flex-col gap-5">
                        <div class="inline-flex items-center gap-2 bg-white py-1 px-3 rounded-full shadow-sm w-fit">
                            <span class="text-xs font-bold uppercase text-secondary">Government & Enterprise</span>
                        </div>
                        <h3 class="text-2xl md:text-3xl lg:text-4xl font-bold text-secondary leading-tight">Delivering Digital Solutions with National Impact</h3>
                        <p class="text-secondary-light text-base leading-relaxed">
                            One of our most significant achievements was our role as the <strong>primary IT consultants and technical architects</strong> for the Digisol Marketplace — a landmark digital farming initiative designed to revolutionize Nigeria's agricultural value chain. Our team engineered a robust web marketplace alongside comprehensive Android and iOS applications, connecting farmers, vendors, and stakeholders more efficiently than ever before.
                        </p>
                        <div class="flex flex-wrap gap-4">
                            <div class="flex items-center gap-2">
                                <iconify-icon icon="mdi:check-circle" width="20" height="20" class="text-primary"></iconify-icon>
                                <span class="text-sm font-medium text-secondary">Web Marketplace Engine</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <iconify-icon icon="mdi:check-circle" width="20" height="20" class="text-primary"></iconify-icon>
                                <span class="text-sm font-medium text-secondary">Native Mobile Apps (Android & iOS)</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <iconify-icon icon="mdi:check-circle" width="20" height="20" class="text-primary"></iconify-icon>
                                <span class="text-sm font-medium text-secondary">Secured Digital Payment Infrastructure</span>
                            </div>
                        </div>
                        <a href="https://guardian.ng/business-services/digisol-launches-digital-farming-tool-to-boost-agriculture-in-nigeria/" target="_blank" class="w-fit text-primary font-medium hover:text-primary-dark underline underline-offset-4 transition-all mt-2">
                            Read the Guardian Feature Article &rarr;
                        </a>
                    </div>

                    <div class="flex-1 w-full">
                        <div class="rounded-2xl overflow-hidden shadow-xl border border-white/60 relative h-56 md:h-100 lg:h-80 w-full bg-linear-to-br from-green-100 to-blue-200">
                            <img src="./public/assets/images/digisol_mockup.jpg"
                                alt="Digisol digital marketplace - agricultural technology platform"
                                class="w-full h-full object-cover" />
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ======= 6. WHY CHOOSE US ======= -->
        <section class="py-16 lg:py-24 bg-white border-t border-theme-light/30">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 data-aos="fade-up" class="text-3xl md:text-4xl lg:text-5xl font-bold text-secondary text-center mb-6">Why Choose <span class="text-primary">Programmers City</span>?</h2>
                <p class="text-center text-secondary-light text-lg max-w-3xl mx-auto mb-12 lg:mb-16">
                    We combine technical excellence with business acumen to deliver solutions that drive measurable results.
                </p>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div data-aos="fade-up" data-aos-delay="100" class="value-card bg-main-theme p-6 rounded-2xl border border-theme-light/60 text-center hover:shadow-md transition-all">
                        <div class="value-icon-wrapper mx-auto mb-4">
                            <iconify-icon icon="material-symbols:rocket-launch" width="28" height="28"></iconify-icon>
                        </div>
                        <h4 class="font-bold text-secondary text-lg">Technical Excellence</h4>
                        <p class="text-sm text-secondary-light leading-relaxed">Our team comprises seasoned engineers with deep expertise across modern technology stacks.</p>
                    </div>
                    <div data-aos="fade-up" data-aos-delay="150" class="value-card bg-main-theme p-6 rounded-2xl border border-theme-light/60 text-center hover:shadow-md transition-all">
                        <div class="value-icon-wrapper mx-auto mb-4">
                            <iconify-icon icon="material-symbols:handshake" width="28" height="28"></iconify-icon>
                        </div>
                        <h4 class="font-bold text-secondary text-lg">Partnership Focus</h4>
                        <p class="text-sm text-secondary-light leading-relaxed">We work as an extension of your team, building lasting relationships based on trust and results.</p>
                    </div>
                    <div data-aos="fade-up" data-aos-delay="200" class="value-card bg-main-theme p-6 rounded-2xl border border-theme-light/60 text-center hover:shadow-md transition-all">
                        <div class="value-icon-wrapper mx-auto mb-4">
                            <iconify-icon icon="material-symbols:scale" width="28" height="28"></iconify-icon>
                        </div>
                        <h4 class="font-bold text-secondary text-lg">Scalable Solutions</h4>
                        <p class="text-sm text-secondary-light leading-relaxed">Every solution we deliver is built to grow with your organization, from startup to enterprise.</p>
                    </div>
                    <div data-aos="fade-up" data-aos-delay="250" class="value-card bg-main-theme p-6 rounded-2xl border border-theme-light/60 text-center hover:shadow-md transition-all">
                        <div class="value-icon-wrapper mx-auto mb-4">
                            <iconify-icon icon="material-symbols:shield-lock" width="28" height="28"></iconify-icon>
                        </div>
                        <h4 class="font-bold text-secondary text-lg">Enterprise Security</h4>
                        <p class="text-sm text-secondary-light leading-relaxed">We prioritize security at every level — from code to infrastructure to compliance.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- ======= 7. OUR LOCATION & GLOBAL REACH ======= -->
        <section class="py-16 lg:py-20 bg-main-theme border-t border-theme-light/30">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <div data-aos="fade-right">
                        <span class="text-primary text-sm font-bold uppercase tracking-widest">Our Home Base</span>
                        <h2 class="text-3xl md:text-4xl font-bold text-secondary leading-tight mt-2">Proudly Nigerian, Globally Competitive</h2>
                        <p class="text-secondary-light text-base leading-relaxed mt-4">
                            From our headquarters in <strong>Owerri, Imo State, Nigeria</strong>, we serve clients across continents. Our location at <strong>181 Douglas Road, By Wetheral Junction, Owerri-Aba Road</strong> positions us at the heart of Nigeria's emerging tech ecosystem.
                        </p>
                        <p class="text-secondary-light text-base leading-relaxed mt-4">
                            But our reach extends far beyond. We've delivered solutions for clients in the <strong>United Kingdom, United States, South Africa,</strong> and across Nigeria. Our work has been recognized by governments, featured in national media, and trusted by leading organizations.
                        </p>
                        <div class="flex flex-wrap gap-6 mt-6">
                            <div class="flex items-center gap-3">
                                <iconify-icon icon="mdi:map-marker" width="24" height="24" class="text-primary"></iconify-icon>
                                <span class="text-sm text-secondary">Owerri, Imo State, Nigeria</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <iconify-icon icon="mdi:globe" width="24" height="24" class="text-primary"></iconify-icon>
                                <span class="text-sm text-secondary">Serving Clients Globally</span>
                            </div>
                        </div>
                    </div>
                    <div data-aos="fade-left" class="bg-white rounded-2xl p-6 border border-theme-light/60 shadow-sm">
                        <div class="rounded-xl overflow-hidden h-64 w-full bg-primary-light/20 flex items-center justify-center">
                            <div class="text-center p-8">
                                <iconify-icon icon="mdi:map-marker-radius" width="64" height="64" class="text-primary mx-auto mb-4"></iconify-icon>
                                <h4 class="text-xl font-bold text-secondary">181 Douglas Road</h4>
                                <p class="text-secondary-light">By Wetheral Junction, Owerri-Aba Road<br>Owerri, Imo State, Nigeria</p>
                                <div class="mt-4 flex justify-center gap-4">
                                    <span class="inline-flex items-center gap-1 bg-primary-light/20 px-3 py-1 rounded-full text-xs font-medium text-primary">
                                        <iconify-icon icon="mdi:flag" width="14" height="14"></iconify-icon> Nigeria
                                    </span>
                                    <span class="inline-flex items-center gap-1 bg-primary-light/20 px-3 py-1 rounded-full text-xs font-medium text-primary">
                                        <iconify-icon icon="mdi:clock" width="14" height="14"></iconify-icon> WAT (UTC+1)
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ======= 8. CORE PHILOSOPHY ======= -->
        <section class="py-16 lg:py-24 bg-white border-t border-theme-light/30">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 data-aos="fade-up" class="text-3xl md:text-4xl lg:text-5xl font-bold text-secondary text-center mb-12 lg:mb-16 tracking-tight">
                    Our Core Philosophy
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6">

                    <div data-aos="fade-up" data-aos-delay="100" class="bg-main-theme p-6 lg:p-8 rounded-2xl border border-theme-light/60 shadow-sm hover:shadow-md transition-all flex flex-col gap-4">
                        <div class="w-12 h-12 bg-primary-light rounded-xl flex items-center justify-center"><iconify-icon icon="material-symbols:lightbulb-outline" width="24" height="24" class="text-primary"></iconify-icon></div>
                        <div>
                            <h4 class="font-bold text-secondary text-lg">Innovation</h4>
                            <p class="text-sm text-secondary-light mt-1 leading-relaxed">We embrace emerging technologies to solve today's business challenges and prepare organizations for tomorrow's opportunities.</p>
                        </div>
                    </div>

                    <div data-aos="fade-up" data-aos-delay="150" class="bg-main-theme p-6 lg:p-8 rounded-2xl border border-theme-light/60 shadow-sm hover:shadow-md transition-all flex flex-col gap-4">
                        <div class="w-12 h-12 bg-primary-light rounded-xl flex items-center justify-center"><iconify-icon icon="material-symbols:stars-outline" width="24" height="24" class="text-primary"></iconify-icon></div>
                        <div>
                            <h4 class="font-bold text-secondary text-lg">Excellence</h4>
                            <p class="text-sm text-secondary-light mt-1 leading-relaxed">Every solution we deliver is designed with quality, scalability, security, and long‑term value in mind.</p>
                        </div>
                    </div>

                    <div data-aos="fade-up" data-aos-delay="200" class="bg-main-theme p-6 lg:p-8 rounded-2xl border border-theme-light/60 shadow-sm hover:shadow-md transition-all flex flex-col gap-4">
                        <div class="w-12 h-12 bg-primary-light rounded-xl flex items-center justify-center"><iconify-icon icon="material-symbols:handshake-outline" width="24" height="24" class="text-primary"></iconify-icon></div>
                        <div>
                            <h4 class="font-bold text-secondary text-lg">Partnership</h4>
                            <p class="text-sm text-secondary-light mt-1 leading-relaxed">We work as an extension of our clients' teams, building lasting relationships based on trust, collaboration, and shared success.</p>
                        </div>
                    </div>

                    <div data-aos="fade-up" data-aos-delay="250" class="bg-primary-light/10 p-6 lg:p-8 rounded-2xl border border-primary-light/30 shadow-sm hover:shadow-md transition-all flex flex-col gap-4 md:col-span-2 lg:col-span-1">
                        <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center"><iconify-icon icon="material-symbols:verified-outline" width="24" height="24" class="text-primary"></iconify-icon></div>
                        <div>
                            <h4 class="font-bold text-secondary text-lg">Integrity</h4>
                            <p class="text-sm text-secondary-light mt-1 leading-relaxed">We believe transparency, accountability, and professionalism are the foundation of every successful partnership.</p>
                        </div>
                    </div>

                    <div data-aos="fade-up" data-aos-delay="300" class="bg-primary-light/10 p-6 lg:p-8 rounded-2xl border border-primary-light/30 shadow-sm hover:shadow-md transition-all flex flex-col gap-4 md:col-span-2 lg:col-span-1">
                        <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center"><iconify-icon icon="material-symbols:sync-problem" width="24" height="24" class="text-primary"></iconify-icon></div>
                        <div>
                            <h4 class="font-bold text-secondary text-lg">Continuous Improvement</h4>
                            <p class="text-sm text-secondary-light mt-1 leading-relaxed">Technology evolves rapidly. We continuously learn, innovate, and improve so our clients remain competitive.</p>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- ======= 9. TRUSTED PARTNERS ======= -->
        <section class="py-12 lg:py-16 bg-main-theme border-t border-theme-light/30">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h4 data-aos="fade-up" class="text-xs font-bold uppercase tracking-widest text-secondary-light mb-8">
                    Trusted by Leading Organizations & Governments
                </h4>

                <div data-aos="fade-up" data-aos-delay="100"
                    class="flex flex-wrap justify-center items-center gap-8 lg:gap-12 opacity-60">

                    <div class="flex flex-col items-center justify-center gap-1.5 p-2">
                        <img class="h-16 w-auto object-contain grayscale hover:grayscale-0 transition-all"
                            src="https://panpetglobal.com/build/assets/icon-512x512-C_rJ58aM.png"
                            alt="Panpet Global Enterprise logo" />
                        <span class="text-xs font-semibold text-secondary">Panpet Global Enterprise</span>
                    </div>

                    <div class="flex flex-col items-center justify-center gap-1.5 p-2">
                        <img class="h-16 w-auto object-contain grayscale hover:grayscale-0 transition-all"
                            src="https://silktakeliquidation.com/favicon.png"
                            alt="Silktake logo" />
                        <span class="text-xs font-semibold text-secondary">Silktake</span>
                    </div>

                    <div class="flex flex-col items-center justify-center gap-1.5 p-2">
                        <img class="h-16 w-auto object-contain grayscale hover:grayscale-0 transition-all"
                            src="https://digisolfarm.com/uploads/website-images/logo-2025-03-26-12-39-39-3871.png"
                            alt="Digisol Projects logo" />
                        <span class="text-xs font-semibold text-secondary">Digisol Projects</span>
                    </div>

                    <div class="flex flex-col items-center justify-center gap-1.5 p-2">
                        <img class="h-16 w-auto object-contain grayscale hover:grayscale-0 transition-all"
                            src="https://gridspiresoftware.com/build/assets/logo-BxRwEuRf.png"
                            alt="Gridspire Software logo" />
                        <span class="text-xs font-semibold text-secondary">Gridspire Software</span>
                    </div>

                    <div class="flex flex-col items-center justify-center gap-1.5 p-2">
                        <img class="h-16 w-auto object-contain sm:grayscale hover:grayscale-0 transition-all bg-slate-900 rounded"
                            src="https://bondlogisticsllc.com/images/bond_logo.png"
                            alt="Bond Logistics LLC logo" />
                        <span class="text-xs font-semibold text-secondary">Bond Logistics LLC</span>
                    </div>

                </div>
            </div>
        </section>

        <!-- ======= 10. TEAM SECTION ======= -->
        <!-- <section class="py-16 lg:py-24 bg-white border-t border-theme-light/30">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <div class="flex flex-col lg:flex-row justify-between items-end mb-12 gap-4">
                    <div data-aos="fade-right" data-aos-duration="800">
                        <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-secondary mb-4 tracking-tight">Meet the Team Behind the Innovation</h2>
                        <p class="text-secondary-light text-lg max-w-2xl leading-relaxed">
                            Our multidisciplinary team brings together software engineers, solution architects, UI/UX designers, project managers, and technology educators committed to delivering innovative digital solutions that help organizations achieve their goals.
                        </p>
                    </div>
                    <a href="./staff" class="text-primary font-medium hover:text-primary-dark transition-colors duration-300 flex items-center gap-1 group">
                        Explore All Staff
                        <span class="inline-block transform transition-transform duration-300 group-hover:translate-x-1">&rarr;</span>
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">

                    <div data-aos="fade-up" data-aos-duration="800" data-aos-delay="100"
                        class="bg-main-theme rounded-2xl overflow-hidden border border-theme-light/60 shadow-sm hover:shadow-xl transition-all duration-300 group">
                        <div class="team-card-image w-full h-72 md:h-96 bg-secondary relative overflow-hidden">
                            <img src="./public/assets/images/destiny.png"
                                alt="Destiny Brotobor Emuobohwoghare - CEO, Programmers City Software Hub"
                                class="w-full h-full object-cover filter grayscale brightness-90 group-hover:grayscale-0 group-hover:scale-105 transition-all duration-500" />
                        </div>
                        <div class="p-6 lg:p-8">
                            <p class="text-secondary-light text-sm font-medium mb-1">Founder & CEO</p>
                            <h3 class="text-xl font-bold text-secondary mb-3">Destiny Brotobor Emuobohwoghare</h3>
                            <p class="text-secondary-light text-sm leading-relaxed">
                                With over 15 years of experience in software engineering, systems architecture, and technology consulting, Destiny leads the vision and strategic direction of <strong>Programmers City Software Hub (Procity Software Hub)</strong>. He has successfully delivered enterprise software solutions, ERP systems, mobile applications, and digital transformation initiatives for businesses, educational institutions, and public sector organizations across Africa and internationally.
                            </p>
                        </div>
                    </div>

                    <div data-aos="fade-up" data-aos-duration="800" data-aos-delay="150"
                        class="bg-main-theme rounded-2xl overflow-hidden border border-theme-light/60 shadow-sm hover:shadow-xl transition-all duration-300 group">
                        <div class="team-card-image w-full h-72 md:h-96 bg-secondary relative overflow-hidden">
                            <img src="./public/assets/images/silver.jpg"
                                alt="Mrs. Silver Iwuji Destiny - Head of Operations, Programmers City Software Hub"
                                class="w-full h-full object-cover filter grayscale brightness-90 group-hover:grayscale-0 group-hover:scale-105 transition-all duration-500" />
                        </div>
                        <div class="p-6 lg:p-8">
                            <p class="text-secondary-light text-sm font-medium mb-1">Head of Operations & HR</p>
                            <h3 class="text-xl font-bold text-secondary mb-3">Mrs. Silver Iwuji Destiny</h3>
                            <p class="text-secondary-light text-sm leading-relaxed">
                                Silver brings exceptional organizational precision to our operations. An expert in product research, UI/UX design, and office management technology, she ensures seamless project management, client satisfaction, and smooth internal workflows that drive our success.
                            </p>
                        </div>
                    </div>

                    <div data-aos="fade-up" data-aos-duration="800" data-aos-delay="200"
                        class="bg-main-theme rounded-2xl overflow-hidden border border-theme-light/60 shadow-sm hover:shadow-xl transition-all duration-300 group">
                        <div class="team-card-image w-full h-72 md:h-96 bg-secondary relative overflow-hidden">
                            <img src="./public/assets/images/godwin.png"
                                alt="Godwin Inyene - Lead Web Development Facilitator, Programmers City Software Hub"
                                class="w-full h-full object-cover filter grayscale brightness-90 group-hover:grayscale-0 group-hover:scale-105 transition-all duration-500" />
                        </div>
                        <div class="p-6 lg:p-8">
                            <p class="text-secondary-light text-sm font-medium mb-1">Lead Web Development Facilitator</p>
                            <h3 class="text-xl font-bold text-secondary mb-3">Godwin Inyene</h3>
                            <p class="text-secondary-light text-sm leading-relaxed">
                                Godwin is a professional full‑stack developer dedicated to shaping the next generation of tech talent. He combines deep technical knowledge with a passion for teaching, ensuring our training programs deliver real‑world, industry‑ready skills that transform careers.
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </section> -->

        <!-- ======= 11. BOTTOM CTA BANNER ======= -->
        <section class="px-4 sm:px-6 lg:px-8 pb-16 lg:pb-24 bg-white">
            <div data-aos="fade-up" class="max-w-7xl mx-auto bg-secondary rounded-3xl p-8 sm:p-10 lg:p-16 text-center shadow-2xl border border-white/10">
                <h3 class="text-2xl md:text-3xl lg:text-4xl font-bold text-white mb-4">Let's Build Technology That Moves Your Business Forward</h3>
                <p class="text-primary-light/70 text-base md:text-lg max-w-2xl mx-auto mb-8">
                    Whether you're looking to automate operations, develop enterprise software, launch a digital platform, or transform your organization through technology, <strong>Programmers City Software Hub (Procity Software Hub)</strong> is ready to help you achieve your goals.
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="tel:+2349019606166" class="inline-block bg-primary hover:bg-primary-dark text-white font-medium py-3 px-8 rounded-full shadow-lg transition-all duration-300 hover:-translate-y-0.5">
                        Call Us Now for a Free Consultation
                    </a>
                    <a href="./our-services" class="inline-block bg-white hover:bg-theme-light text-secondary font-medium py-3 px-8 rounded-full shadow-lg transition-all duration-300 hover:-translate-y-0.5">
                        Explore Our Services
                    </a>
                </div>
            </div>
        </section>

    </main>
    <?php include_once './components/footer.html' ?>

    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init({
            once: true,
            offset: 20
        });

        document.querySelectorAll('a[href="./about-us"]').forEach(el => el.classList.add('active'));
    </script>
</body>

</html>