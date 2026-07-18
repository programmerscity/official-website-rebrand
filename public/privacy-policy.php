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
    <title>Privacy Policy - Procity Software Hub</title>
    <meta name="description" content="Privacy Policy for Procity Software Hub. Learn how we collect, use, and protect your personal information.">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="https://programmerscity.com/privacy-policy">

    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="Privacy Policy - Procity Software Hub">
    <meta property="og:description" content="Privacy Policy for Procity Software Hub. Learn how we collect, use, and protect your personal information.">
    <meta property="og:url" content="https://programmerscity.com/privacy-policy">
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
                        Privacy Policy
                    </h1>
                    <p class="text-secondary-light text-base md:text-lg mt-4 max-w-2xl mx-auto">
                        Your privacy matters to us. Learn how we handle your data.
                    </p>
                    <p class="last-updated mt-2">Last Updated: July 15, 2025</p>
                </div>
            </div>
        </section>

        <!-- CONTENT -->
        <section class="py-12 lg:py-16 bg-white border-t border-theme-light/30">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 legal-content">

                <p class="text-secondary-light mb-8">
                    At <strong>Procity Software Hub</strong> (also referred to as "we," "our," or "us"), we are committed to protecting your privacy and ensuring the security of your personal information. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you visit our website, use our services, or interact with us.
                </p>

                <h2 class="text-2xl font-bold mt-10 mb-4">1. Information We Collect</h2>
                <p>We may collect the following types of information:</p>

                <h3 class="text-xl font-semibold mt-6 mb-2">1.1 Personal Information You Provide</h3>
                <ul>
                    <li><strong>Contact Information:</strong> Name, email address, phone number, company name, and job title.</li>
                    <li><strong>Project Information:</strong> Details about your project requirements, business needs, and technical specifications.</li>
                    <li><strong>Account Information:</strong> Usernames, passwords, and other credentials if you create an account with us.</li>
                    <li><strong>Communication:</strong> Any information you provide through our contact forms, emails, chat, or phone calls.</li>
                    <li><strong>Payment Information:</strong> Billing address, payment method details, and transaction history (processed securely through third-party payment gateways).</li>
                </ul>

                <h3 class="text-xl font-semibold mt-6 mb-2">1.2 Information Collected Automatically</h3>
                <ul>
                    <li><strong>Device and Usage Information:</strong> IP address, browser type, operating system, device type, referring URLs, pages visited, time spent on pages, and clickstream data.</li>
                    <li><strong>Cookies and Tracking Technologies:</strong> We use cookies to enhance your experience, analyze site traffic, and personalize content. You can manage your cookie preferences through your browser settings.</li>
                    <li><strong>Location Information:</strong> General geographic location based on your IP address.</li>
                </ul>

                <h3 class="text-xl font-semibold mt-6 mb-2">1.3 Information from Third Parties</h3>
                <ul>
                    <li>We may receive information about you from third-party services such as social media platforms, analytics providers, and business partners, in accordance with their privacy policies.</li>
                </ul>

                <h2 class="text-2xl font-bold mt-10 mb-4">2. How We Use Your Information</h2>
                <p>We use your information for the following purposes:</p>
                <ul>
                    <li><strong>To Provide and Improve Services:</strong> Delivering our software development, training, consulting, and other services; understanding your needs; and improving our offerings.</li>
                    <li><strong>To Communicate:</strong> Responding to your inquiries, sending project updates, providing technical support, and sharing relevant information about our services.</li>
                    <li><strong>To Personalize Your Experience:</strong> Tailoring content and recommendations to your interests and preferences.</li>
                    <li><strong>To Process Transactions:</strong> Managing payments, invoices, and billing for our services.</li>
                    <li><strong>To Send Marketing Communications:</strong> With your consent, sending newsletters, promotional materials, and information about our latest projects and offerings. You can opt-out at any time.</li>
                    <li><strong>To Comply with Legal Obligations:</strong> Meeting regulatory and legal requirements, including tax and anti-fraud obligations.</li>
                    <li><strong>To Protect Our Rights:</strong> Enforcing our terms of service, preventing fraud, and protecting the security of our systems and users.</li>
                </ul>

                <h2 class="text-2xl font-bold mt-10 mb-4">3. Legal Basis for Processing</h2>
                <p>We process your personal information based on one or more of the following legal grounds:</p>
                <ul>
                    <li><strong>Consent:</strong> Where you have given us explicit consent to process your data for specific purposes.</li>
                    <li><strong>Contractual Necessity:</strong> Where processing is necessary to fulfill a contract with you or to take steps at your request before entering into a contract.</li>
                    <li><strong>Legal Obligation:</strong> Where processing is required to comply with legal or regulatory obligations.</li>
                    <li><strong>Legitimate Interests:</strong> Where processing is necessary for our legitimate business interests, such as improving our services, marketing, and ensuring security, provided these interests do not override your rights and freedoms.</li>
                </ul>

                <h2 class="text-2xl font-bold mt-10 mb-4">4. How We Share Your Information</h2>
                <p>We do not sell, rent, or trade your personal information. We may share your information in the following circumstances:</p>
                <ul>
                    <li><strong>Service Providers:</strong> With trusted third-party vendors who assist us in operating our website, providing services, processing payments, and managing communications. These providers are contractually obligated to protect your data.</li>
                    <li><strong>Business Partners:</strong> With strategic partners when necessary to deliver co-branded services or joint projects, with your consent.</li>
                    <li><strong>Legal Requirements:</strong> When required by law, court order, or government request, or to protect the rights, property, or safety of Procity Software Hub, our users, or others.</li>
                    <li><strong>Business Transfers:</strong> In the event of a merger, acquisition, reorganization, or sale of assets, your information may be transferred as part of the business transaction, subject to continued protection under this policy.</li>
                    <li><strong>With Your Consent:</strong> In other cases, we will obtain your explicit consent before sharing your information.</li>
                </ul>

                <h2 class="text-2xl font-bold mt-10 mb-4">5. Data Retention</h2>
                <p>We retain your personal information for as long as necessary to fulfill the purposes outlined in this Privacy Policy, unless a longer retention period is required or permitted by law. We will securely delete or anonymize your data when it is no longer needed.</p>

                <h2 class="text-2xl font-bold mt-10 mb-4">6. Data Security</h2>
                <p>We implement appropriate technical and organizational measures to protect your personal information against unauthorized access, alteration, disclosure, or destruction. These include:</p>
                <ul>
                    <li><strong>Encryption:</strong> We use SSL/TLS encryption to secure data transmitted between your browser and our servers.</li>
                    <li><strong>Access Controls:</strong> We restrict access to personal information to authorized personnel who need it to perform their job functions.</li>
                    <li><strong>Regular Security Audits:</strong> We conduct regular assessments to identify and address security vulnerabilities.</li>
                    <li><strong>Data Minimization:</strong> We collect only the minimum amount of information necessary for the intended purpose.</li>
                </ul>

                <h2 class="text-2xl font-bold mt-10 mb-4">7. Your Rights and Choices</h2>
                <p>Depending on your jurisdiction, you may have the following rights regarding your personal information:</p>
                <ul>
                    <li><strong>Access:</strong> Request a copy of the personal information we hold about you.</li>
                    <li><strong>Correction:</strong> Request correction of inaccurate or incomplete information.</li>
                    <li><strong>Deletion:</strong> Request deletion of your personal information, subject to legal obligations.</li>
                    <li><strong>Restriction:</strong> Request restriction of processing your data in certain circumstances.</li>
                    <li><strong>Objection:</strong> Object to the processing of your data for marketing or other purposes.</li>
                    <li><strong>Data Portability:</strong> Request a copy of your data in a structured, machine-readable format.</li>
                    <li><strong>Withdraw Consent:</strong> Withdraw your consent at any time where we rely on consent for processing.</li>
                </ul>
                <p>To exercise any of these rights, please contact us using the information provided in the "Contact Us" section below. We will respond to your request within a reasonable timeframe, as required by applicable law.</p>

                <h2 class="text-2xl font-bold mt-10 mb-4">8. Cookies and Tracking Technologies</h2>
                <p>We use cookies and similar tracking technologies to enhance your experience on our website. These may include:</p>
                <ul>
                    <li><strong>Essential Cookies:</strong> Required for basic website functionality.</li>
                    <li><strong>Performance Cookies:</strong> Help us understand how visitors interact with our site.</li>
                    <li><strong>Functionality Cookies:</strong> Remember your preferences and settings.</li>
                    <li><strong>Marketing Cookies:</strong> Used to deliver relevant advertisements to you.</li>
                </ul>
                <p>You can manage your cookie preferences through your browser settings. However, disabling certain cookies may affect the functionality of our website.</p>

                <h2 class="text-2xl font-bold mt-10 mb-4">9. International Data Transfers</h2>
                <p>We are based in Nigeria but may process data in other countries where our service providers are located. We ensure that appropriate safeguards are in place for any international data transfers, in compliance with applicable data protection laws.</p>

                <h2 class="text-2xl font-bold mt-10 mb-4">10. Children's Privacy</h2>
                <p>Our services are not directed to individuals under the age of 16. We do not knowingly collect personal information from children. If you are a parent or guardian and believe your child has provided us with personal information, please contact us, and we will take steps to delete such information.</p>

                <h2 class="text-2xl font-bold mt-10 mb-4">11. Third-Party Links</h2>
                <p>Our website may contain links to third-party websites, including client sites and partner platforms. We are not responsible for the privacy practices or content of these external sites. We encourage you to review their privacy policies before providing any personal information.</p>

                <h2 class="text-2xl font-bold mt-10 mb-4">12. Updates to This Privacy Policy</h2>
                <p>We may update this Privacy Policy from time to time to reflect changes in our practices, legal requirements, or operational needs. We will notify you of any material changes by posting the updated policy on our website and updating the "Last Updated" date. We encourage you to review this policy periodically.</p>

                <h2 class="text-2xl font-bold mt-10 mb-4">13. Contact Us</h2>
                <p>If you have any questions, concerns, or requests regarding this Privacy Policy or our data practices, please contact us:</p>
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
                <h3 class="text-2xl md:text-3xl lg:text-4xl font-bold text-white mb-4">Have Questions About Your Privacy?</h3>
                <p class="text-primary-light/70 text-base md:text-lg max-w-2xl mx-auto mb-8">
                    We're here to help. Contact us anytime with your privacy concerns or data requests.
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
    <?php include_once './components/footer.php' ?>

    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init({
            once: true,
            offset: 20
        });
    </script>
</body>

</html>