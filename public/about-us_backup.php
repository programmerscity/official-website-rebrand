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
    <title>About Us | Programmers City Software Hub</title>
    <link rel="stylesheet" href="<?php echo $_ENV['APP_ENV'] == 'dev' ? './public/css/dev_styles.css' : './public/css/styles.css' ?>" />
    <link rel="shortcut icon" href="./public/assets/images/favicon.png" type="image/*">
    <!-- Browser Iconify Library -->
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@3.0.2/dist/iconify-icon.min.js"></script>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <!-- AOS Animation Library -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

    <!-- Custom CSS for Corner Accents -->
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
    </style>
</head>

<body class="bg-main-theme text-secondary font-inter">
    <?php include_once './components/header.html' ?>
    <main class="min-h-screen">

        <!-- ======= 1. HERO SECTION ======= -->
        <section class="relative py-12 overflow-hidden">
            <!-- Corner Accents - Hidden on mobile, Visible on Large Screens -->
            <div class="corner-accent-top-right lg:w-16 lg:h-16 hidden lg:block"></div>
            <div class="corner-accent-bottom-left lg:w-16 lg:h-16 hidden lg:block"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

                <!-- Mobile View -->
                <div class="flex lg:hidden flex-col items-center text-center bg-linear-to-br from-primary to-primary-dark p-8 md:p-10 rounded-3xl shadow-xl gap-6">
                    <div class="inline-flex bg-white/90 text-primary items-center gap-2.5 px-4 py-1.5 rounded-full w-fit shadow-sm">
                        <iconify-icon icon="material-symbols:lock-outline" width="16" height="16"></iconify-icon>
                        <span class="text-xs font-bold uppercase tracking-wider">Our Journey</span>
                    </div>

                    <h1 class="text-3xl md:text-4xl font-bold text-white leading-tight">
                        Your Trusted Partner for Digital Transformation
                    </h1>

                    <p class="text-primary-light text-base leading-relaxed max-w-2xl">
                        At <strong class="text-white">Programmers City Software Hub</strong>, we help businesses, government institutions, startups, and organizations solve complex operational challenges through innovative technology. From enterprise software and mobile applications to ERP systems, cloud infrastructure, and digital transformation consulting, we build solutions that improve efficiency, increase productivity, and create lasting business value.
                    </p>

                    <div class="relative rounded-2xl overflow-hidden w-full max-w-sm mt-4 shadow-md border-2 border-white/20">
                        <img src="./public/assets/images/about-hero-image.jpg"
                            alt="Modern collaborative workspace representing enterprise execution"
                            class="w-full h-auto object-cover"
                            loading="lazy" />
                    </div>
                </div>

                <!-- Desktop View -->
                <div data-aos="fade-up" data-aos-duration="800"
                    class="hidden lg:grid grid-cols-1 lg:grid-cols-2 bg-white p-6 sm:p-8 md:p-10 lg:p-14 rounded-3xl shadow-xl border border-theme-light/30 gap-10 lg:gap-16 items-center">

                    <!-- Left Content -->
                    <div class="flex flex-col gap-6">
                        <div class="inline-flex bg-primary text-white items-center gap-2.5 px-4 py-1.5 rounded-full w-fit shadow-sm shadow-primary/20">
                            <iconify-icon icon="material-symbols:lock-outline" width="16" height="16"></iconify-icon>
                            <span class="text-xs font-bold uppercase tracking-wider">Our Journey</span>
                        </div>

                        <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-secondary leading-tight">
                            Your Trusted Partner for Digital Transformation
                        </h1>

                        <p class="text-secondary-light text-base md:text-lg leading-relaxed">
                            At <strong>Programmers City Software Hub</strong>, we help businesses, government institutions, startups, and organizations solve complex operational challenges through innovative technology. From enterprise software and mobile applications to ERP systems, cloud infrastructure, and digital transformation consulting, we build solutions that improve efficiency, increase productivity, and create lasting business value.
                        </p>
                    </div>

                    <!-- Right Image -->
                    <div class="relative rounded-2xl overflow-hidden h-75 md:h-100 shadow-md border border-theme-light/40">
                        <img src="./public/assets/images/about-hero-image.jpg"
                            alt="Modern collaborative workspace representing enterprise execution"
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

        <!-- ======= 3. WHO WE ARE & EXPERTISE ======= -->
        <section class="py-16 lg:py-24 bg-main-theme">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col lg:flex-row gap-12 lg:gap-20">
                    <!-- Left Text -->
                    <div class="lg:w-5/12 flex flex-col justify-center gap-6" data-aos="fade-right">
                        <span class="text-primary text-sm font-bold uppercase tracking-widest">Our Capabilities</span>
                        <h2 class="text-3xl md:text-4xl font-bold text-secondary leading-tight">Technology Expertise Built Around Your Business</h2>
                        <p class="text-secondary-light text-base leading-relaxed">
                            Every organization is unique, and so are its challenges. We work closely with our clients to understand their operations, identify opportunities for improvement, and develop technology solutions that simplify processes, improve collaboration, and support long‑term growth. Whether you're launching a new digital product or modernizing existing systems, we provide the expertise to turn ideas into measurable results.
                        </p>
                        <a href="./contact-us" class="w-fit bg-primary hover:bg-primary-dark text-white font-medium py-3 px-8 rounded-full shadow-lg shadow-primary/20 transition-all duration-300 hover:-translate-y-0.5 mt-4">
                            Schedule a Consultation
                        </a>
                    </div>

                    <!-- Right Grid (Expertise - Business Capabilities) -->
                    <div class="lg:w-7/12 grid grid-cols-2 sm:grid-cols-2 gap-4 text-center" data-aos="fade-left">
                        <div class="bg-white p-6 rounded-2xl border border-theme-light/60 flex flex-col gap-4 hover:shadow-md transition-all">
                            <iconify-icon icon="mdi:application-outline" width="32" height="32" class="text-primary"></iconify-icon>
                            <h4 class="font-semibold text-secondary text-lg">Enterprise Software</h4>
                            <p class="text-sm text-secondary-light leading-relaxed">Design and development of scalable software solutions that automate business operations and support organizational growth.</p>
                        </div>
                        <div class="bg-white p-6 rounded-2xl border border-theme-light/60 flex flex-col gap-4 hover:shadow-md transition-all">
                            <iconify-icon icon="material-symbols:phone-android" width="32" height="32" class="text-primary"></iconify-icon>
                            <h4 class="font-semibold text-secondary text-lg">Mobile Applications</h4>
                            <p class="text-sm text-secondary-light leading-relaxed">Android and iOS applications that improve customer engagement and provide seamless digital experiences.</p>
                        </div>
                        <div class="bg-white p-6 rounded-2xl border border-theme-light/60 flex flex-col gap-4 hover:shadow-md transition-all">
                            <iconify-icon icon="material-symbols:settings-applications" width="32" height="32" class="text-primary"></iconify-icon>
                            <h4 class="font-semibold text-secondary text-lg">Business Automation</h4>
                            <p class="text-sm text-secondary-light leading-relaxed">Digitize manual workflows, eliminate repetitive tasks, and improve operational efficiency through intelligent automation.</p>
                        </div>
                        <div class="bg-white p-6 rounded-2xl border border-theme-light/60 flex flex-col gap-4 hover:shadow-md transition-all">
                            <iconify-icon icon="mdi:cloud-check" width="32" height="32" class="text-primary"></iconify-icon>
                            <h4 class="font-semibold text-secondary text-lg">Cloud & Infrastructure</h4>
                            <p class="text-sm text-secondary-light leading-relaxed">Reliable cloud deployment, business email, hosting, maintenance, backup, and infrastructure management for secure business operations.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ======= 4. IMPACT & GOVERNMENT PROJECTS (Digisol) ======= -->
        <section class="py-16 lg:py-24 bg-white border-t border-theme-light/30">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-primary-light/10 rounded-3xl p-6 md:p-10 lg:p-16 border border-primary-light/30 flex flex-col lg:flex-row items-center gap-10 lg:gap-16" data-aos="zoom-in">

                    <!-- Left Content -->
                    <div class="flex-1 flex flex-col gap-5">
                        <div class="inline-flex items-center gap-2 bg-white py-1 px-3 rounded-full shadow-sm w-fit">
                            <span class="text-xs font-bold uppercase text-secondary">Government & Enterprise</span>
                        </div>
                        <h3 class="text-2xl md:text-3xl lg:text-4xl font-bold text-secondary leading-tight">Delivering Digital Solutions with National Impact</h3>
                        <p class="text-secondary-light text-base leading-relaxed">
                            One of our notable projects involved contributing to the development of the Digisol digital marketplace, an initiative designed to strengthen Nigeria's agricultural value chain through technology. The platform enables farmers, vendors, and stakeholders to connect more efficiently using integrated web and mobile applications.
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

                    <!-- Right Visual -->
                    <div class="flex-1 w-full">
                        <div class="rounded-2xl overflow-hidden shadow-xl border border-white/60 relative h-56 md:h-100 lg:h-80 w-full bg-linear-to-br from-green-100 to-blue-200">
                            <img src="./public/assets/images/digisol_mockup.jpg"
                                alt="Agriculture and digital farming technology"
                                class="w-full h-full object-cover" />
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ======= 5. CORE PHILOSOPHY ======= -->
        <section class="py-16 lg:py-24 bg-main-theme border-t border-theme-light/30">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 data-aos="fade-up" data-aos-duration="800" class="text-3xl md:text-4xl lg:text-5xl font-bold text-secondary text-center mb-12 lg:mb-16 tracking-tight">
                    Our Core Philosophy
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6">

                    <!-- Innovation -->
                    <div data-aos="fade-up" data-aos-delay="100" class="bg-white p-6 lg:p-8 rounded-2xl border border-theme-light/60 shadow-sm hover:shadow-md transition-all flex flex-col gap-4">
                        <div class="w-12 h-12 bg-primary-light rounded-xl flex items-center justify-center"><iconify-icon icon="material-symbols:lightbulb-outline" width="24" height="24" class="text-primary"></iconify-icon></div>
                        <div>
                            <h4 class="font-bold text-secondary text-lg">Innovation</h4>
                            <p class="text-sm text-secondary-light mt-1 leading-relaxed">We embrace emerging technologies to solve today's business challenges and prepare organizations for tomorrow's opportunities.</p>
                        </div>
                    </div>

                    <!-- Excellence -->
                    <div data-aos="fade-up" data-aos-delay="150" class="bg-white p-6 lg:p-8 rounded-2xl border border-theme-light/60 shadow-sm hover:shadow-md transition-all flex flex-col gap-4">
                        <div class="w-12 h-12 bg-primary-light rounded-xl flex items-center justify-center"><iconify-icon icon="material-symbols:stars-outline" width="24" height="24" class="text-primary"></iconify-icon></div>
                        <div>
                            <h4 class="font-bold text-secondary text-lg">Excellence</h4>
                            <p class="text-sm text-secondary-light mt-1 leading-relaxed">Every solution we deliver is designed with quality, scalability, security, and long‑term value in mind.</p>
                        </div>
                    </div>

                    <!-- Partnership -->
                    <div data-aos="fade-up" data-aos-delay="200" class="bg-white p-6 lg:p-8 rounded-2xl border border-theme-light/60 shadow-sm hover:shadow-md transition-all flex flex-col gap-4">
                        <div class="w-12 h-12 bg-primary-light rounded-xl flex items-center justify-center"><iconify-icon icon="material-symbols:handshake-outline" width="24" height="24" class="text-primary"></iconify-icon></div>
                        <div>
                            <h4 class="font-bold text-secondary text-lg">Partnership</h4>
                            <p class="text-sm text-secondary-light mt-1 leading-relaxed">We work as an extension of our clients' teams, building lasting relationships based on trust, collaboration, and shared success.</p>
                        </div>
                    </div>

                    <!-- Integrity -->
                    <div data-aos="fade-up" data-aos-delay="250" class="bg-primary-light/10 p-6 lg:p-8 rounded-2xl border border-primary-light/30 shadow-sm hover:shadow-md transition-all flex flex-col gap-4 md:col-span-2 lg:col-span-1">
                        <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center"><iconify-icon icon="material-symbols:verified-outline" width="24" height="24" class="text-primary"></iconify-icon></div>
                        <div>
                            <h4 class="font-bold text-secondary text-lg">Integrity</h4>
                            <p class="text-sm text-secondary-light mt-1 leading-relaxed">We believe transparency, accountability, and professionalism are the foundation of every successful partnership.</p>
                        </div>
                    </div>

                    <!-- Continuous Improvement -->
                    <div data-aos="fade-up" data-aos-delay="300" class="bg-primary-light/10 p-6 lg:p-8 rounded-2xl border border-primary-light/30 shadow-sm hover:shadow-md transition-all flex flex-col gap-4 md:col-span-2 lg:col-span-1">
                        <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center"><iconify-icon icon="material-symbols:sync-problem" width="24" height="24" class="text-primary"></iconify-icon></div>
                        <div>
                            <h4 class="font-bold text-secondary text-lg">Continuous Improvement</h4>
                            <p class="text-sm text-secondary-light mt-1 leading-relaxed">Technology evolves rapidly. We continuously learn, innovate, and improve so our clients remain competitive in an ever‑changing digital world.</p>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- ======= 6. TRUSTED PARTNERS ======= -->
        <section class="py-12 lg:py-16 bg-white border-t border-theme-light/30">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h4 data-aos="fade-up" class="text-xs font-bold uppercase tracking-widest text-secondary-light mb-8">
                    Trusted by leading organizations & governments
                </h4>

                <div data-aos="fade-up" data-aos-delay="100"
                    class="flex flex-wrap justify-center items-center gap-8 lg:gap-12 opacity-60 grayscale">

                    <!-- Partner 1: TechCorp -->
                    <div class="flex flex-col items-center justify-center gap-1.5 p-2">
                        <img class="h-10 w-auto object-contain"
                            src="https://placehold.co/120x50/1a202c/FFFFFF?text=Logo"
                            alt="TechCorp logo" />
                        <span class="text-xs font-semibold text-secondary">TechCorp</span>
                    </div>

                    <!-- Partner 2: NigeriaGov -->
                    <div class="flex flex-col items-center justify-center gap-1.5 p-2">
                        <img class="h-10 w-auto object-contain"
                            src="https://placehold.co/120x50/1a202c/FFFFFF?text=Logo"
                            alt="NigeriaGov logo" />
                        <span class="text-xs font-semibold text-secondary">NigeriaGov</span>
                    </div>

                    <!-- Partner 3: Digisol -->
                    <div class="flex flex-col items-center justify-center gap-1.5 p-2">
                        <img class="h-10 w-auto object-contain"
                            src="https://placehold.co/120x50/1a202c/FFFFFF?text=Logo"
                            alt="Digisol logo" />
                        <span class="text-xs font-semibold text-secondary">Digisol</span>
                    </div>

                    <!-- Partner 4: StartupHub -->
                    <div class="flex flex-col items-center justify-center gap-1.5 p-2">
                        <img class="h-10 w-auto object-contain"
                            src="https://placehold.co/120x50/1a202c/FFFFFF?text=Logo"
                            alt="StartupHub logo" />
                        <span class="text-xs font-semibold text-secondary">StartupHub</span>
                    </div>

                    <!-- Partner 5: DevGlobal -->
                    <div class="flex flex-col items-center justify-center gap-1.5 p-2">
                        <img class="h-10 w-auto object-contain"
                            src="https://placehold.co/120x50/1a202c/FFFFFF?text=Logo"
                            alt="DevGlobal logo" />
                        <span class="text-xs font-semibold text-secondary">DevGlobal</span>
                    </div>

                </div>
            </div>
        </section>

        <!-- ======= 7. TEAM SECTION ======= -->
        <section class="py-16 lg:py-24 bg-main-theme border-t border-theme-light/30">
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

                <!-- Team Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">

                    <!-- Member 1: Destiny -->
                    <div data-aos="fade-up" data-aos-duration="800" data-aos-delay="100"
                        class="bg-white rounded-2xl overflow-hidden border border-theme-light/60 shadow-sm hover:shadow-xl transition-all duration-300 group">
                        <div class="team-card-image w-full h-72 md:h-96 bg-secondary relative overflow-hidden">
                            <img src="./public/assets/images/destiny.png"
                                alt="Destiny Brotobor Emuobohwoghare"
                                class="w-full h-full object-cover filter grayscale brightness-90 group-hover:grayscale-0 group-hover:scale-105 transition-all duration-500" />
                        </div>
                        <div class="p-6 lg:p-8">
                            <p class="text-secondary-light text-sm font-medium mb-1">Founder & CEO</p>
                            <h3 class="text-xl font-bold text-secondary mb-3">Destiny Brotobor Emuobohwoghare</h3>
                            <p class="text-secondary-light text-sm leading-relaxed">
                                Destiny is the Founder and CEO of Programmers City Software Hub. With over 15 years of experience in software engineering, systems architecture, and technology consulting, he has led the successful delivery of enterprise software solutions, ERP systems, mobile applications, and digital transformation initiatives for businesses, educational institutions, and public sector organizations.
                            </p>
                        </div>
                    </div>

                    <!-- Member 2: Silver -->
                    <div data-aos="fade-up" data-aos-duration="800" data-aos-delay="150"
                        class="bg-white rounded-2xl overflow-hidden border border-theme-light/60 shadow-sm hover:shadow-xl transition-all duration-300 group">
                        <div class="team-card-image w-full h-72 md:h-96 bg-secondary relative overflow-hidden">
                            <img src="./public/assets/images/silver.jpg"
                                alt="Mrs. Silver Iwuji Destiny"
                                class="w-full h-full object-cover filter grayscale brightness-90 group-hover:grayscale-0 group-hover:scale-105 transition-all duration-500" />
                        </div>
                        <div class="p-6 lg:p-8">
                            <p class="text-secondary-light text-sm font-medium mb-1">Head of Operations & HR</p>
                            <h3 class="text-xl font-bold text-secondary mb-3">Mrs. Silver Iwuji Destiny</h3>
                            <p class="text-secondary-light text-sm leading-relaxed">
                                Silver brings exceptional organizational precision to our operations. An expert in product research, UI/UX design, and office management technology, she ensures seamless project management, client satisfaction, and smooth internal workflows.
                            </p>
                        </div>
                    </div>

                    <!-- Member 3: Godwin -->
                    <div data-aos="fade-up" data-aos-duration="800" data-aos-delay="200"
                        class="bg-white rounded-2xl overflow-hidden border border-theme-light/60 shadow-sm hover:shadow-xl transition-all duration-300 group">
                        <div class="team-card-image w-full h-72 md:h-96 bg-secondary relative overflow-hidden">
                            <img src="./public/assets/images/godwin.png"
                                alt="Godwin Inyene"
                                class="w-full h-full object-cover filter grayscale brightness-90 group-hover:grayscale-0 group-hover:scale-105 transition-all duration-500" />
                        </div>
                        <div class="p-6 lg:p-8">
                            <p class="text-secondary-light text-sm font-medium mb-1">Lead Web Development Facilitator</p>
                            <h3 class="text-xl font-bold text-secondary mb-3">Godwin Inyene</h3>
                            <p class="text-secondary-light text-sm leading-relaxed">
                                Godwin is a professional full‑stack developer dedicated to shaping the next generation of tech talent. He combines deep technical knowledge with a passion for teaching, ensuring our training programs deliver real‑world, industry‑ready skills.
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- ======= 8. BOTTOM CTA BANNER ======= -->
        <section class="px-4 sm:px-6 lg:px-8 pb-16 lg:pb-24 bg-main-theme">
            <div data-aos="fade-up" class="max-w-7xl mx-auto bg-secondary rounded-3xl p-8 sm:p-10 lg:p-16 text-center shadow-2xl border border-white/10">
                <h3 class="text-2xl md:text-3xl lg:text-4xl font-bold text-white mb-4">Let's Build Technology That Moves Your Business Forward</h3>
                <p class="text-primary-light/70 text-base md:text-lg max-w-2xl mx-auto mb-8">
                    Whether you're looking to automate operations, develop enterprise software, launch a digital platform, or transform your organization through technology, our team is ready to help you achieve your goals.
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="./contact-us" class="inline-block bg-primary hover:bg-primary-dark text-white font-medium py-3 px-8 rounded-full shadow-lg transition-all duration-300 hover:-translate-y-0.5">
                        Schedule a Free Consultation
                    </a>
                    <a href="./services" class="inline-block bg-white hover:bg-theme-light text-secondary font-medium py-3 px-8 rounded-full shadow-lg transition-all duration-300 hover:-translate-y-0.5">
                        Explore Our Services
                    </a>
                </div>
            </div>
        </section>

    </main>
    <?php include_once './components/footer.html' ?>
    <?php include_once './components/home/chatbox.html' ?>

    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init({
            once: true,
            offset: 20
        });

        // Set the anchor tag with href "./about-us" to active
        document.querySelectorAll('a[href="./about-us"]').forEach(el => el.classList.add('active'));
    </script>
</body>

</html>