    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-400 py-16 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">
                
                <!-- Column 1: Logo & About -->
                <div class="space-y-4">
                    <a href="#" class="flex items-center gap-2 group w-max">
                        <div class="w-8 h-8 rounded-lg bg-blue-600 flex items-center justify-center text-white font-bold font-heading shadow-md">
                            IK
                        </div>
                        <span class="font-heading font-extrabold text-base text-white tracking-tight">
                            Ikhsan<span class="text-blue-500">.</span>
                        </span>
                    </a>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        <?= e($settings['footer_text'] ?? (($profile['full_name'] ?? 'M. Ikhsan Hidayat') . '. Dibuat menggunakan Native PHP, MySQL & Tailwind CSS.')) ?>
                    </p>
                </div>

                <!-- Column 2: NAVIGASI PENTING -->
                <div class="space-y-4">
                    <h4 class="text-xs font-bold text-white uppercase tracking-wider">Navigasi Penting</h4>
                    <ul class="space-y-2 text-xs">
                        <li><a href="/#home" class="hover:text-white transition-colors">Beranda Utama</a></li>
                        <li><a href="/#tentang" class="hover:text-white transition-colors">Tentang Saya</a></li>
                        <li><a href="/#keahlian" class="hover:text-white transition-colors">Keahlian & Kompetensi</a></li>
                        <li><a href="/#pendidikan" class="hover:text-white transition-colors">Riwayat Studi</a></li>
                        <li><a href="/#proyek" class="hover:text-white transition-colors">Dokumentasi Proyek</a></li>
                        <li><a href="/#kontak" class="hover:text-white transition-colors">Hubungi Saya</a></li>
                    </ul>
                </div>

                <!-- Column 3: KONTAK HUBUNG -->
                <div class="space-y-4">
                    <h4 class="text-xs font-bold text-white uppercase tracking-wider">Kontak Hubung</h4>
                    <ul class="space-y-3 text-xs">
                        <li class="flex items-start gap-3">
                            <i data-lucide="map-pin" class="w-4 h-4 text-blue-500 flex-shrink-0 mt-0.5"></i>
                            <span><?= e($profile['location'] ?? 'Tasikmalaya, Indonesia') ?></span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i data-lucide="phone" class="w-4 h-4 text-blue-500 flex-shrink-0 mt-0.5"></i>
                            <span>WhatsApp: <?= e($profile['whatsapp'] ?? '+6282119491906') ?></span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i data-lucide="mail" class="w-4 h-4 text-blue-500 flex-shrink-0 mt-0.5"></i>
                            <span class="break-all"><?= e($profile['email'] ?? 'ikhsanhidayatmuhamad@gmail.com') ?></span>
                        </li>
                    </ul>
                </div>

                <!-- Column 4: IKUTI KAMI -->
                <div class="space-y-4">
                    <h4 class="text-xs font-bold text-white uppercase tracking-wider">Ikuti Kami</h4>
                    <div class="flex flex-wrap items-center gap-3 mb-2">
                        <?php if (!empty($profile['github_url'])): ?>
                            <a href="<?= e($profile['github_url']) ?>" target="_blank" 
                               class="w-8 h-8 rounded-lg bg-slate-800 hover:bg-blue-600 text-slate-400 hover:text-white flex items-center justify-center transition-colors" 
                               title="GitHub">
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 22v-4a4.8 4.8 0 0 0-1-3.5c3 0 6-2 6-5.5.08-1.25-.27-2.48-1-3.5.28-1.15.28-2.35 0-3.5 0 0-1 0-3 1.5-2.64-.5-5.36-.5-8 0C6 2 5 2 5 2c-.3 1.15-.3 2.35 0 3.5A5.403 5.403 0 0 0 4 9c0 3.5 3 5.5 6 5.5-.39.49-.68 1.05-.85 1.65-.17.6-.22 1.23-.15 1.85v4"></path><path d="M9 18c-4.51 2-5-2-7-2"></path></svg>
                            </a>
                        <?php endif; ?>
                        <?php if (!empty($profile['linkedin_url'])): ?>
                            <a href="<?= e($profile['linkedin_url']) ?>" target="_blank" 
                               class="w-8 h-8 rounded-lg bg-slate-800 hover:bg-blue-600 text-slate-400 hover:text-white flex items-center justify-center transition-colors" 
                               title="LinkedIn">
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path><rect width="4" height="12" x="2" y="9"></rect><circle cx="4" cy="4" r="2"></circle></svg>
                            </a>
                        <?php endif; ?>
                        <?php if (!empty($profile['instagram_url'])): ?>
                            <a href="<?= e($profile['instagram_url']) ?>" target="_blank" 
                               class="w-8 h-8 rounded-lg bg-slate-800 hover:bg-blue-600 text-slate-400 hover:text-white flex items-center justify-center transition-colors" 
                               title="Instagram">
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="20" x="2" y="2" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"></line></svg>
                            </a>
                        <?php endif; ?>
                        <?php if (!empty($profile['tiktok_url'])): ?>
                            <a href="<?= e($profile['tiktok_url']) ?>" target="_blank" 
                               class="w-8 h-8 rounded-lg bg-slate-800 hover:bg-blue-600 text-slate-400 hover:text-white flex items-center justify-center transition-colors" 
                               title="TikTok">
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 12a4 4 0 1 0 4 4V4a5 5 0 0 0 5 5"></path></svg>
                            </a>
                        <?php endif; ?>
                        <?php if (!empty($profile['youtube_url'])): ?>
                            <a href="<?= e($profile['youtube_url']) ?>" target="_blank" 
                               class="w-8 h-8 rounded-lg bg-slate-800 hover:bg-blue-600 text-slate-400 hover:text-white flex items-center justify-center transition-colors" 
                               title="YouTube">
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2.5 17a24.12 24.12 0 0 1 0-10 2 2 0 0 1 1.4-1.4 49.56 49.56 0 0 1 16.2 0A2 2 0 0 1 21.5 7a24.12 24.12 0 0 1 0 10 2 2 0 0 1-1.4 1.4 49.55 49.55 0 0 1-16.2 0A2 2 0 0 1 2.5 17z"></path><polygon points="10 15 15 12 10 9"></polygon></svg>
                            </a>
                        <?php endif; ?>
                    </div>
                    <p class="text-[11px] text-slate-500 leading-relaxed">
                        Hubungi saya melalui nomor WhatsApp di atas untuk kerja sama atau pertanyaan lebih lanjut.
                    </p>
                </div>

            </div>

            <!-- Bottom Row: Copyright & Credits -->
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 border-t border-slate-800/60 pt-8 mt-12 text-[11px] text-slate-500">
                <p>&copy; <?= date('Y') ?> <?= e($profile['full_name'] ?? 'M. Ikhsan Hidayat') ?>. All rights reserved.</p>
                <p>Powered by <?= e($profile['full_name'] ?? 'M. Ikhsan Hidayat') ?></p>
            </div>
        </div>
    </footer>

    <!-- Scroll To Top Button -->
    <button id="scroll-to-top" onclick="window.scrollTo({top: 0, behavior: 'smooth'})"
        class="fixed bottom-6 right-6 z-30 p-2.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white shadow-lg transition-all duration-300 scale-0 opacity-0 focus:outline-none">
        <i data-lucide="arrow-up" class="w-5 h-5"></i>
    </button>

    <!-- GLightbox JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>

    <!-- Global Javascript UI Interactions -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // 1. Initialize Lucide Icons
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }

            // 2. Initialize GLightbox
            if (typeof GLightbox !== 'undefined') {
                const lightbox = GLightbox({
                    selector: '.glightbox',
                    touchNavigation: true,
                    loop: true,
                    autoplayVideos: true
                });
            }

            // 3. Header shrink on Scroll & Scroll To Top Visibility
            const header = document.getElementById('main-header');
            const navbarContainer = document.getElementById('navbar-container');
            const scrollTopBtn = document.getElementById('scroll-to-top');

            window.addEventListener('scroll', () => {
                if (window.scrollY > 50) {
                    header.classList.add('shadow-md', 'bg-white');
                    header.classList.remove('bg-white/80');
                    navbarContainer.classList.add('h-14', 'md:h-16');
                    navbarContainer.classList.remove('h-16', 'md:h-20');
                    
                    // Show scroll to top button
                    scrollTopBtn.classList.remove('scale-0', 'opacity-0');
                    scrollTopBtn.classList.add('scale-100', 'opacity-100');
                } else {
                    header.classList.remove('shadow-md');
                    header.classList.add('bg-white/80');
                    navbarContainer.classList.remove('h-14', 'md:h-16');
                    navbarContainer.classList.add('h-16', 'md:h-20');
                    
                    // Hide scroll to top button
                    scrollTopBtn.classList.remove('scale-100', 'opacity-100');
                    scrollTopBtn.classList.add('scale-0', 'opacity-0');
                }
            });

            // 4. Active Link Highlight scroll tracking (Intersection Observer)
            const sections = document.querySelectorAll('section[id]');
            const navLinks = document.querySelectorAll('.nav-link');

            const observerOptions = {
                root: null,
                rootMargin: '-30% 0px -60% 0px',
                threshold: 0
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const id = entry.target.getAttribute('id');
                        navLinks.forEach(link => {
                            if (link.getAttribute('href') === '/#' + id || link.getAttribute('href') === '#' + id) {
                                link.classList.add('active-nav-link');
                                link.classList.remove('text-slate-500');
                            } else {
                                link.classList.remove('active-nav-link');
                                link.classList.add('text-slate-500');
                            }
                        });
                    }
                });
            }, observerOptions);

            sections.forEach(section => {
                observer.observe(section);
            });
        });

        // 5. Mobile Hamburger Menu Drawer Toggle
        const mobileMenu = document.getElementById('mobile-menu');
        const menuIcon = document.getElementById('menu-icon');
        function toggleMobileMenu() {
            if (mobileMenu.classList.contains('hidden')) {
                mobileMenu.classList.remove('hidden');
                menuIcon.innerHTML = '<path d="M18 6 6 18M6 6l12 12"></path>'; // X close icon
            } else {
                mobileMenu.classList.add('hidden');
                menuIcon.innerHTML = '<line x1="4" x2="20" y1="12" y2="12"></line><line x1="4" x2="20" y1="6" y2="6"></line><line x1="4" x2="20" y1="18" y2="18"></line>'; // Hamburger menu
            }
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        }
    </script>
</body>
</html>
