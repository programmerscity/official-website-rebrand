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
    <title>Terms of Service - Procity Software Hub</title>
    <meta name="description" content="Terms of Service for Procity Software Hub. Understand the terms and conditions governing our software development and IT training services.">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="https://programmerscity.com/terms-of-service">

    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="Terms of Service - Procity Software Hub">
    <meta property="og:description" content="Terms of Service for Procity Software Hub. Understand the terms and conditions governing our software development and IT training services.">
    <meta property="og:url" content="https://programmerscity.com/terms-of-service">
    <meta property="og:site_name" content="Procity Software Hub">

    <link rel="stylesheet" href="<?php echo $_ENV['APP_ENV'] == 'dev' ? './public/css/dev_styles.css' : './public/css/styles.css' ?>" />
    <link rel="shortcut icon" href="./public/assets/images/favicon.png" type="image/*">
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@3.0.2/dist/iconify-icon.min.js"></script>
    <link rel="preconnect" href="https://googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <style>
        .legal-content h1,
        .legal-content h2,
        .legal-content h3 {
            color: var(--color-secondary);
        }

        .legal-content p,
        .legal-content li {
            color: var(--color-secondary-light);
            line-height: 1.8;
        }

        .legal-content ul {
            padding-left: 1.5rem;
        }

        .legal-content li {
            margin-bottom: 0.5rem;
        }

        .last-updated {
            font-size: 0.875rem;
            color: var(--color-secondary-light);
            font-style: italic;
        }
    </style>
</head>

<body class="bg-main-theme text-secondary font-inter">
    <?php include_once './components/header.html' ?>
    <main>

        <!-- HERO -->
        <section class="relative py-12 overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="bg-white rounded-3xl p-8 md:p-12 lg:p-16 shadow-xl border border-theme-light/30 text-center" data-aos="fade-up">
                    <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-secondary leading-tight">
                        Terms of Service
                    </h1>
                    <p class="text-secondary-light text-base md:text-lg mt-4 max-w-2xl mx-auto">
                        Please read these terms carefully before using our services.
                    </p>
                    <p class="last-updated mt-2">Last Updated: July 15, 2025</p>
                </div>
            </div>
        </section>

        <!-- CONTENT -->
        <section class="py-12 lg:py-16 bg-white border-t border-theme-light/30">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 legal-content">

                <p class="text-secondary-light mb-8">
                    Welcome to <strong>Procity Software Hub</strong> (also referred to as "we," "our," or "us"). These Terms of Service ("Terms") govern your use of our website, software development services, IT training programs, consulting services, and all related products and services (collectively, the "Services"). By accessing or using our Services, you agree to be bound by these Terms. If you do not agree to these Terms, please do not use our Services.
                </p>

                <h2 class="text-2xl font-bold mt-10 mb-4">1. Acceptance of Terms</h2>
                <p>By using our Services, you acknowledge that you have read, understood, and agree to comply with these Terms. These Terms constitute a legally binding agreement between you and Procity Software Hub. If you are using our Services on behalf of an organization, you represent that you have the authority to bind that organization to these Terms.</p>

                <h2 class="text-2xl font-bold mt-10 mb-4">2. Description of Services</h2>
                <p>Procity Software Hub provides the following services:</p>
                <ul>
                    <li><strong>Software Development:</strong> Custom software development, mobile app development, ERP systems, web applications, enterprise software, and digital solutions.</li>
                    <li><strong>IT Training:</strong> Professional training in software development, cybersecurity, UI/UX design, data analytics, CAD, and other emerging technologies.</li>
                    <li><strong>Consulting:</strong> Digital transformation consulting, technology strategy, and system architecture advisory services.</li>
                    <li><strong>UI/UX Design:</strong> User experience research, interface design, and product design services.</li>
                    <li><strong>Cloud & Infrastructure:</strong> Cloud deployment, hosting, maintenance, and infrastructure management.</li>
                </ul>

                <h2 class="text-2xl font-bold mt-10 mb-4">3. User Accounts and Registration</h2>
                <h3 class="text-xl font-semibold mt-6 mb-2">3.1 Account Creation</h3>
                <p>Some Services may require you to create an account. You agree to provide accurate, complete, and current information during registration and to update your information as necessary.</p>

                <h3 class="text-xl font-semibold mt-6 mb-2">3.2 Account Security</h3>
                <p>You are solely responsible for maintaining the confidentiality of your account credentials. You agree to notify us immediately of any unauthorized use of your account or any other security breach. We are not liable for any loss or damage arising from your failure to protect your account credentials.</p>

                <h3 class="text-xl font-semibold mt-6 mb-2">3.3 Account Termination</h3>
                <p>We reserve the right to suspend or terminate your account at our sole discretion if we believe you have violated these Terms or if your use of the Services poses a risk to us or other users.</p>

                <h2 class="text-2xl font-bold mt-10 mb-4">4. Intellectual Property Rights</h2>

                <h3 class="text-xl font-semibold mt-6 mb-2">4.1 Our Intellectual Property</h3>
                <p>All content, materials, software, designs, graphics, logos, and other intellectual property on our website and Services are owned by Procity Software Hub or our licensors and are protected by Nigerian and international copyright, trademark, and other intellectual property laws. You may not copy, modify, distribute, display, or create derivative works of our intellectual property without our prior written consent.</p>

                <h3 class="text-xl font-semibold mt-6 mb-2">4.2 Client Intellectual Property</h3>
                <p>Any intellectual property you provide to us (including project requirements, business information, designs, and content) remains your property. We will use such information only for the purpose of providing Services to you and will not disclose it to third parties without your consent.</p>

                <h3 class="text-xl font-semibold mt-6 mb-2">4.3 Deliverables</h3>
                <p>Unless otherwise agreed in a separate written agreement, ownership of deliverables (source code, designs, documentation, etc.) will be transferred to you upon full payment of all fees. We retain the right to use any general knowledge, skills, and reusable components developed during the project for future work.</p>

                <h2 class="text-2xl font-bold mt-10 mb-4">5. Fees and Payment</h2>

                <h3 class="text-xl font-semibold mt-6 mb-2">5.1 Fees</h3>
                <p>All fees for our Services will be communicated to you in a proposal, quotation, or agreement before the commencement of work. Unless otherwise stated, all fees are quoted in Nigerian Naira (NGN) or US Dollars (USD) and are exclusive of applicable taxes.</p>

                <h3 class="text-xl font-semibold mt-6 mb-2">5.2 Invoicing and Payment</h3>
                <p>We will invoice you according to the payment terms specified in your agreement. Payment is due within the specified timeframe. Late payments may incur interest at a rate of 1.5% per month or the maximum legal rate, whichever is lower. We reserve the right to suspend Services for unpaid invoices.</p>

                <h3 class="text-xl font-semibold mt-6 mb-2">5.3 Payment Methods</h3>
                <p>We accept bank transfers, credit/debit cards, and other payment methods as specified on our invoices. All payments are processed through secure payment gateways.</p>

                <h2 class="text-2xl font-bold mt-10 mb-4">6. Confidentiality</h2>
                <p>We understand that you may disclose confidential information to us during the course of our engagement. We agree to use such information solely for the purpose of providing Services to you and to protect it from unauthorized disclosure. Our obligations of confidentiality will survive the termination of our agreement.</p>

                <h2 class="text-2xl font-bold mt-10 mb-4">7. Warranties and Disclaimers</h2>

                <h3 class="text-xl font-semibold mt-6 mb-2">7.1 Our Warranties</h3>
                <p>We warrant that our Services will be performed in a professional and workmanlike manner. We do not warrant that our Services will be error-free, uninterrupted, or meet all of your specific requirements.</p>

                <h3 class="text-xl font-semibold mt-6 mb-2">7.2 Disclaimers</h3>
                <p>Our Services are provided "as is" and "as available." To the fullest extent permitted by law, we disclaim all warranties, express or implied, including but not limited to implied warranties of merchantability, fitness for a particular purpose, and non-infringement. We do not warrant that our Services will be secure, timely, or free from errors.</p>

                <h2 class="text-2xl font-bold mt-10 mb-4">8. Limitation of Liability</h2>
                <p>To the fullest extent permitted by law, Procity Software Hub and its officers, directors, employees, and agents shall not be liable for any indirect, incidental, special, consequential, or punitive damages, including loss of profits, data, or goodwill, arising out of or in connection with your use of our Services. Our total liability for any claim arising out of these Terms shall not exceed the total fees paid by you for the specific Services giving rise to the claim.</p>

                <h2 class="text-2xl font-bold mt-10 mb-4">9. Indemnification</h2>
                <p>You agree to indemnify, defend, and hold harmless Procity Software Hub and its officers, directors, employees, and agents from and against any claims, liabilities, damages, losses, and expenses (including reasonable legal fees) arising out of or in connection with your use of our Services, your violation of these Terms, or your violation of any rights of a third party.</p>

                <h2 class="text-2xl font-bold mt-10 mb-4">10. Termination</h2>

                <h3 class="text-xl font-semibold mt-6 mb-2">10.1 Termination by You</h3>
                <p>You may terminate this agreement at any time by providing written notice. Upon termination, you remain obligated to pay for all Services rendered up to the date of termination.</p>

                <h3 class="text-xl font-semibold mt-6 mb-2">10.2 Termination by Us</h3>
                <p>We may terminate or suspend your access to our Services at any time, without prior notice, for any reason, including if we believe you have violated these Terms. Upon termination, all rights granted to you under these Terms will cease immediately.</p>

                <h2 class="text-2xl font-bold mt-10 mb-4">11. Governing Law and Dispute Resolution</h2>

                <h3 class="text-xl font-semibold mt-6 mb-2">11.1 Governing Law</h3>
                <p>These Terms shall be governed by and construed in accordance with the laws of the Federal Republic of Nigeria, without regard to its conflict of law principles.</p>

                <h3 class="text-xl font-semibold mt-6 mb-2">11.2 Dispute Resolution</h3>
                <p>Any dispute arising out of or relating to these Terms shall first be attempted to be resolved through good-faith negotiations between the parties. If the dispute cannot be resolved through negotiations, it shall be submitted to mediation and, if necessary, to arbitration in accordance with the Arbitration and Conciliation Act, Cap A18, Laws of the Federation of Nigeria, 2004. The arbitration shall be conducted in Owerri, Imo State, Nigeria, and the language of the arbitration shall be English.</p>

                <h2 class="text-2xl font-bold mt-10 mb-4">12. Changes to Terms</h2>
                <p>We reserve the right to update or modify these Terms at any time. We will notify you of any material changes by posting the updated Terms on our website and updating the "Last Updated" date. Your continued use of our Services after any such changes constitutes your acceptance of the new Terms.</p>

                <h2 class="text-2xl font-bold mt-10 mb-4">13. Privacy</h2>
                <p>Our collection and use of your personal information is governed by our Privacy Policy, which is incorporated into these Terms by reference. Please review our Privacy Policy to understand how we handle your data.</p>

                <h2 class="text-2xl font-bold mt-10 mb-4">14. Miscellaneous</h2>

                <h3 class="text-xl font-semibold mt-6 mb-2">14.1 Entire Agreement</h3>
                <p>These Terms, together with our Privacy Policy and any additional agreements you enter into with us, constitute the entire agreement between you and Procity Software Hub regarding your use of our Services.</p>

                <h3 class="text-xl font-semibold mt-6 mb-2">14.2 Severability</h3>
                <p>If any provision of these Terms is held to be invalid or unenforceable, the remaining provisions shall continue in full force and effect.</p>

                <h3 class="text-xl font-semibold mt-6 mb-2">14.3 Waiver</h3>
                <p>Our failure to enforce any right or provision of these Terms shall not be considered a waiver of those rights.</p>

                <h3 class="text-xl font-semibold mt-6 mb-2">14.4 Assignment</h3>
                <p>You may not assign or transfer these Terms without our prior written consent. We may assign these Terms without restriction.</p>

                <h3 class="text-xl font-semibold mt-6 mb-2">14.5 Force Majeure</h3>
                <p>We shall not be liable for any delay or failure to perform our obligations if such delay or failure is caused by circumstances beyond our reasonable control, including acts of God, war, terrorism, pandemics, government actions, or natural disasters.</p>

                <h2 class="text-2xl font-bold mt-10 mb-4">15. Contact Us</h2>
                <p>If you have any questions, concerns, or feedback regarding these Terms, please contact us:</p>
                <div class="bg-main-theme rounded-2xl p-6 mt-4 border border-theme-light/60">
                    <p><strong>Procity Software Hub</strong><br>
                        181 Douglas Road, By Wetheral Junction,<br>
                        Owerri-Aba Road, Owerri,<br>
                        Imo State, Nigeria</p>
                    <p><strong>Email:</strong> <a href="mailto:info@programmerscity.com" class="text-primary hover:underline">info@programmerscity.com</a></p>
                    <p><strong>Phone:</strong> <a href="tel:+2349019606166" class="text-primary hover:underline">+234 9019 606166</a></p>
                </div>

            </div>
        </section>

        <!-- BOTTOM CTA -->
        <section class="px-4 sm:px-6 lg:px-8 pb-16 lg:pb-24 bg-white">
            <div data-aos="fade-up" class="max-w-7xl mx-auto bg-secondary rounded-3xl p-8 sm:p-10 lg:p-16 text-center shadow-2xl border border-white/10">
                <h3 class="text-2xl md:text-3xl lg:text-4xl font-bold text-white mb-4">Have Questions About Our Terms?</h3>
                <p class="text-primary-light/70 text-base md:text-lg max-w-2xl mx-auto mb-8">
                    We're here to help. Contact us anytime for clarification about our terms and conditions.
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="/contact-us" class="inline-block bg-primary hover:bg-primary-dark text-white font-medium py-3 px-8 rounded-full shadow-lg transition-all duration-300 hover:-translate-y-0.5">
                        Contact Us
                    </a>
                    <a href="/" class="inline-block bg-white hover:bg-theme-light text-secondary font-medium py-3 px-8 rounded-full shadow-lg transition-all duration-300 hover:-translate-y-0.5">
                        Return to Home
                    </a>
                </div>
            </div>
        </section>

    </main>
    <?php include_once './components/footer.html'; ?>

    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init({
            once: true,
            offset: 20
        });
    </script>
</body>

</html>