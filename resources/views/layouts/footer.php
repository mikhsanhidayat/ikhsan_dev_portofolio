    </main>

    <!-- ================= RETRO MINIMALIST FOOTER ================= -->
    <footer class="max-w-[1380px] w-[92%] mx-auto py-10 mt-14 border-t-2 border-retro-border font-mono text-xs">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-8 mb-8">
            
            <!-- Col 1: Brand Info (5 cols) -->
            <div class="md:col-span-5 space-y-3">
                <a href="/#beranda" class="font-serif font-black text-xl tracking-tight flex items-center gap-2 group w-max">
                    <span class="w-7 h-7 rounded-lg bg-retro-accent text-white retro-border flex items-center justify-center font-mono text-sm group-hover:rotate-12 transition-transform shadow-xs">IK</span>
                    <span class="text-retro-text">Ikhsan<span class="text-retro-accent">.dev</span></span>
                </a>
                <p class="text-retro-text/75 font-sans text-xs leading-relaxed max-w-sm">
                    Website portofolio resmi M. Ikhsan Hidayat, Fullstack Developer. Dibangun dengan pendekatan Minimalist Retro OS 90-an yang bersih, terstruktur, dan responsif.
                </p>
                <div class="pt-1">
                    <span class="inline-block px-2 py-0.5 rounded bg-retro-secondary retro-border text-[10px] font-bold">
                        SYS_STATUS: ACTIVE // TASIKMALAYA
                    </span>
                </div>
            </div>

            <!-- Col 2: Navigasi Cepat (3 cols) -->
            <div class="md:col-span-3 space-y-2.5">
                <div class="font-bold text-retro-text uppercase tracking-wider text-[11px] border-b border-retro-border/30 pb-1">
                    Navigasi Cepat
                </div>
                <ul class="space-y-1.5 text-xs text-retro-text/80">
                    <li><a href="/#beranda" class="hover:text-retro-accent hover:underline transition-colors block">Beranda</a></li>
                    <li><a href="/#tentang" class="hover:text-retro-accent hover:underline transition-colors block">Tentang Saya</a></li>
                    <li><a href="/#keahlian" class="hover:text-retro-accent hover:underline transition-colors block">Keahlian &amp; Tools</a></li>
                    <li><a href="/#studi" class="hover:text-retro-accent hover:underline transition-colors block">Log Studi</a></li>
                    <li><a href="/#proyek" class="hover:text-retro-accent hover:underline transition-colors block">Arsip Karya</a></li>
                    <li><a href="/#kontak" class="hover:text-retro-accent hover:underline transition-colors block">Hubungi Saya</a></li>
                </ul>
            </div>

            <!-- Col 3: Kontak & Jejaring (4 cols) -->
            <div class="md:col-span-4 space-y-2.5">
                <div class="font-bold text-retro-text uppercase tracking-wider text-[11px] border-b border-retro-border/30 pb-1">
                    Kontak Hubung
                </div>
                <div class="space-y-1.5 text-xs text-retro-text/80">
                    <p class="flex items-center gap-1.5">
                        <i class="ph-bold ph-map-pin text-retro-accent"></i>
                        <span>Tasikmalaya, Jawa Barat, ID</span>
                    </p>
                    <p class="flex items-center gap-1.5">
                        <i class="ph-bold ph-envelope text-retro-accent"></i>
                        <span class="break-all"><?= e($profile['email'] ?? 'ikhsanhidayatmuhamad@gmail.com') ?></span>
                    </p>
                    <p class="flex items-center gap-1.5">
                        <i class="ph-bold ph-whatsapp-logo text-retro-accent"></i>
                        <span><?= e($profile['whatsapp'] ?? '+6282119491906') ?></span>
                    </p>
                </div>

                <div class="flex flex-wrap gap-2 pt-2">
                    <?php if (!empty($profile['github_url'])): ?>
                        <a href="<?= e($profile['github_url']) ?>" target="_blank" rel="noopener noreferrer" 
                           class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg bg-retro-card hover:bg-retro-accent hover:text-white retro-border text-xs transition-colors" 
                           title="GitHub">
                            <svg class="w-3.5 h-3.5 fill-current shrink-0" viewBox="0 0 24 24"><path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0024 12c0-6.63-5.37-12-12-12z"/></svg>
                            <span class="font-bold">GitHub</span>
                        </a>
                    <?php endif; ?>
                    <?php if (!empty($profile['linkedin_url'])): ?>
                        <a href="<?= e($profile['linkedin_url']) ?>" target="_blank" rel="noopener noreferrer" 
                           class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg bg-retro-card hover:bg-retro-accent hover:text-white retro-border text-xs transition-colors" 
                           title="LinkedIn">
                            <svg class="w-3.5 h-3.5 fill-current shrink-0" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                            <span class="font-bold">LinkedIn</span>
                        </a>
                    <?php endif; ?>
                    <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $profile['whatsapp'] ?? '6282119491906') ?>" target="_blank" rel="noopener noreferrer" 
                       class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg bg-retro-card hover:bg-retro-accent hover:text-white retro-border text-xs transition-colors" 
                       title="WhatsApp">
                        <svg class="w-3.5 h-3.5 fill-current shrink-0" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                        <span class="font-bold">WhatsApp</span>
                    </a>
                </div>
            </div>

        </div>

        <!-- Bottom Row -->
        <div class="pt-6 border-t-2 border-retro-border flex flex-col sm:flex-row items-center justify-between gap-4 text-retro-text/75">
            <div>
                &copy; <?= date('Y') ?> <?= strtoupper(e($profile['full_name'] ?? 'M. IKHSAN HIDAYAT')) ?>. DIRAKIT DENGAN PHP NATIVE &amp; RETRO OS 90S.
            </div>
            <button type="button" onclick="window.scrollTo({top: 0, behavior: 'smooth'})" class="px-3.5 py-1.5 rounded-lg bg-retro-card retro-border hover:bg-retro-accent hover:text-white transition-colors cursor-pointer flex items-center gap-1.5 font-bold">
                <span>KEMBALI KE ATAS</span>
                <i class="ph-bold ph-arrow-up"></i>
            </button>
        </div>
    </footer>

    <!-- Custom Retro OS Toast Notification Window -->
    <div id="toast" class="fixed bottom-5 right-5 z-50 hidden flex-col bg-retro-card retro-border retro-shadow rounded-2xl overflow-hidden max-w-sm sm:max-w-md w-[calc(100%-2.5rem)] sm:w-auto transition-all duration-300" role="alert">
        <!-- Toast Title Bar -->
        <div class="bg-retro-secondary border-b-2 border-retro-border px-3.5 py-2 flex items-center justify-between font-mono text-xs font-bold">
            <div class="flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-[#FF5F56] border border-black inline-block"></span>
                <span class="w-2 h-2 rounded-full bg-[#FFBD2E] border border-black inline-block"></span>
                <span class="w-2 h-2 rounded-full bg-[#27C93F] border border-black inline-block"></span>
                <span id="toast-title" class="ml-1 tracking-wider text-retro-text uppercase">CLIPBOARD.SYS</span>
            </div>
            <button type="button" onclick="hideToast()" class="text-retro-text hover:text-retro-accent text-xs font-bold px-1.5 py-0.5 rounded hover:bg-retro-card cursor-pointer" aria-label="Tutup Notifikasi">✕</button>
        </div>
        <!-- Toast Body -->
        <div class="p-4 flex items-center gap-3.5 bg-retro-card">
            <div id="toast-icon-wrapper" class="w-8 h-8 rounded-lg bg-retro-secondary retro-border flex items-center justify-center shrink-0 text-retro-accent text-base">
                <i id="toast-icon" class="ph-bold ph-check-circle text-lg"></i>
            </div>
            <div class="font-mono text-xs sm:text-sm text-retro-text font-bold leading-tight break-words" id="toast-message">
                CLIPBOARD.SYS: Alamat email berhasil disalin!
            </div>
        </div>
    </div>

    <!-- ================= INTERACTIVE JAVASCRIPT ================= -->
    <script>
        // 1. Live Clock WIB
        function updateClock() {
            try {
                const now = new Date();
                const timeString = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
                const clockEl = document.getElementById('live-clock');
                if (clockEl) {
                    clockEl.textContent = `${timeString} WIB`;
                }
            } catch (err) {}
        }
        setInterval(updateClock, 1000);
        updateClock();

        // 2. Theme Switcher with localStorage Persistence
        function setTheme(themeName) {
            try {
                if (themeName === 'default') {
                    document.documentElement.removeAttribute('data-theme');
                    localStorage.setItem('ikhsan_retro_theme', 'default');
                    showToast('Tema diubah ke: Classic Cream');
                } else {
                    document.documentElement.setAttribute('data-theme', themeName);
                    localStorage.setItem('ikhsan_retro_theme', themeName);
                    const label = themeName === 'matcha' ? 'Retro Matcha' : 'Cyber 95 Dark';
                    showToast(`Tema diubah ke: ${label}`);
                }
            } catch (err) {}
        }

        // 3. Mobile Menu Toggle (Android & Mobile Screens)
        const mobileBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        const mobileIcon = document.getElementById('mobile-menu-icon');
        if (mobileBtn && mobileMenu) {
            mobileBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                const isHidden = mobileMenu.classList.contains('hidden');
                if (isHidden) {
                    mobileMenu.classList.remove('hidden');
                    mobileMenu.classList.add('flex');
                    mobileBtn.setAttribute('aria-expanded', 'true');
                    if (mobileIcon) mobileIcon.className = 'ph-bold ph-x';
                } else {
                    mobileMenu.classList.add('hidden');
                    mobileMenu.classList.remove('flex');
                    mobileBtn.setAttribute('aria-expanded', 'false');
                    if (mobileIcon) mobileIcon.className = 'ph-bold ph-list';
                }
            });

            document.querySelectorAll('.mobile-link').forEach(link => {
                link.addEventListener('click', () => {
                    mobileMenu.classList.add('hidden');
                    mobileMenu.classList.remove('flex');
                    mobileBtn.setAttribute('aria-expanded', 'false');
                    if (mobileIcon) mobileIcon.className = 'ph-bold ph-list';
                });
            });

            // Close on outside click
            document.addEventListener('click', (e) => {
                if (!mobileMenu.contains(e.target) && !mobileBtn.contains(e.target) && !mobileMenu.classList.contains('hidden')) {
                    mobileMenu.classList.add('hidden');
                    mobileMenu.classList.remove('flex');
                    mobileBtn.setAttribute('aria-expanded', 'false');
                    if (mobileIcon) mobileIcon.className = 'ph-bold ph-list';
                }
            });
        }

        // 4. Custom Cursor Follower (Desktop Only)
        const cursor = document.getElementById('cursor');
        if (cursor) {
            document.addEventListener('mousemove', (e) => {
                cursor.style.left = e.clientX + 'px';
                cursor.style.top = e.clientY + 'px';
            });

            document.querySelectorAll('a, button, input, textarea, .project-card').forEach(el => {
                el.addEventListener('mouseenter', () => cursor.classList.add('hovered'));
                el.addEventListener('mouseleave', () => cursor.classList.remove('hovered'));
            });
        }

        // 5. 3D Tilt Effect on Hero Card
        const heroCard = document.getElementById('hero-card');
        if (heroCard) {
            heroCard.addEventListener('mousemove', (e) => {
                const rect = heroCard.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                const centerX = rect.width / 2;
                const centerY = rect.height / 2;
                const rotateX = ((y - centerY) / centerY) * -5;
                const rotateY = ((x - centerX) / centerX) * 5;
                heroCard.style.transform = `perspective(800px) rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
            });
            heroCard.addEventListener('mouseleave', () => {
                heroCard.style.transform = 'perspective(800px) rotateX(0deg) rotateY(0deg)';
            });
        }

        // 6. Web Audio API Retro Lofi / Chiptune Loop
        let isPlaying = false;
        let audioCtx = null;
        let melodyInterval = null;

        function toggleRetroSound() {
            const disc = document.getElementById('vinyl-disc');
            const icon = document.getElementById('play-icon');
            const text = document.getElementById('play-text');
            const status = document.getElementById('track-status');

            if (!isPlaying) {
                try {
                    if (!audioCtx) {
                        audioCtx = new (window.AudioContext || window.webkitAudioContext)();
                    }
                    if (audioCtx.state === 'suspended') {
                        audioCtx.resume();
                    }

                    isPlaying = true;
                    if (disc) disc.classList.add('playing');
                    if (icon) icon.className = 'ph-fill ph-pause';
                    if (text) text.textContent = 'STOP';
                    if (status) status.textContent = '♪ Playing 8-Bit Groove...';

                    // Melodic soft retro synth chord notes
                    const notes = [261.63, 329.63, 392.00, 493.88, 392.00, 329.63];
                    let step = 0;

                    const playNote = () => {
                        if (!isPlaying || !audioCtx) return;
                        try {
                            const osc = audioCtx.createOscillator();
                            const gain = audioCtx.createGain();
                            osc.type = 'triangle';
                            osc.frequency.setValueAtTime(notes[step % notes.length], audioCtx.currentTime);

                            gain.gain.setValueAtTime(0.05, audioCtx.currentTime);
                            gain.gain.exponentialRampToValueAtTime(0.0001, audioCtx.currentTime + 0.35);

                            osc.connect(gain);
                            gain.connect(audioCtx.destination);
                            osc.start();
                            osc.stop(audioCtx.currentTime + 0.35);
                            step++;
                        } catch (e) {}
                    };

                    playNote();
                    melodyInterval = setInterval(playNote, 400);
                } catch (e) {
                    showToast('Audio API tidak didukung pada browser ini.');
                }
            } else {
                isPlaying = false;
                if (melodyInterval) clearInterval(melodyInterval);
                if (disc) disc.classList.remove('playing');
                if (icon) icon.className = 'ph-fill ph-play';
                if (text) text.textContent = 'PLAY';
                if (status) status.textContent = '8-Bit Coffee Shop';
            }
        }

        // 7. Project Category Filter with Smooth In-Out Transitions
        function filterRetroProjects(categoryId, buttonEl) {
            const cards = document.querySelectorAll('.project-card');
            const buttons = document.querySelectorAll('.filter-btn');

            buttons.forEach(btn => {
                btn.classList.remove('bg-retro-accent', 'text-white', 'font-bold');
                btn.classList.add('bg-retro-card', 'text-retro-text');
            });
            if (buttonEl) {
                buttonEl.classList.remove('bg-retro-card', 'text-retro-text');
                buttonEl.classList.add('bg-retro-accent', 'text-white', 'font-bold');
            }

            cards.forEach(card => {
                const cardCat = card.getAttribute('data-category-id');
                const isMatch = (categoryId === 'all' || cardCat === String(categoryId));

                if (isMatch) {
                    card.style.display = 'flex';
                    requestAnimationFrame(() => {
                        card.style.opacity = '0';
                        card.style.transform = 'scale(0.95) translateY(15px)';
                        setTimeout(() => {
                            card.style.opacity = '1';
                            card.style.transform = 'scale(1) translateY(0)';
                        }, 30);
                    });
                } else {
                    card.style.opacity = '0';
                    card.style.transform = 'scale(0.95) translateY(15px)';
                    setTimeout(() => {
                        if (card.style.opacity === '0') {
                            card.style.display = 'none';
                        }
                    }, 200);
                }
            });
        }

        // 8. Copy Email to Clipboard Helpers (Retro Toast: CLIPBOARD.SYS)
        function copyTextToClipboard(text, successMessage = 'CLIPBOARD.SYS: Alamat email berhasil disalin!') {
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(text).then(() => {
                    showToast(successMessage, 'CLIPBOARD.SYS', 'success');
                }).catch(() => fallbackCopy(text, successMessage));
            } else {
                fallbackCopy(text, successMessage);
            }
        }

        function fallbackCopy(text, successMessage) {
            const temp = document.createElement('textarea');
            temp.value = text;
            temp.setAttribute('readonly', '');
            temp.style.position = 'absolute';
            temp.style.left = '-9999px';
            document.body.appendChild(temp);
            temp.select();
            document.execCommand('copy');
            document.body.removeChild(temp);
            showToast(successMessage, 'CLIPBOARD.SYS', 'success');
        }

        function copyContactEmail() {
            const el = document.getElementById('email-text');
            const text = el ? el.textContent.trim() : 'ikhsanhidayatmuhamad@gmail.com';
            const label = document.getElementById('copy-label');
            if (label) label.textContent = 'Tersalin!';
            copyTextToClipboard(text, 'CLIPBOARD.SYS: Alamat email berhasil disalin!');
            setTimeout(() => {
                if (label) label.textContent = 'Salin';
            }, 2500);
        }

        function copyPersonalEmail() {
            const el = document.getElementById('about-email-text');
            const text = el ? el.textContent.trim() : 'ikhsanhidayatmuhamad@gmail.com';
            const label = document.getElementById('about-copy-label');
            if (label) label.textContent = 'Tersalin!';
            copyTextToClipboard(text, 'CLIPBOARD.SYS: Alamat email berhasil disalin!');
            setTimeout(() => {
                if (label) label.textContent = 'Salin';
            }, 2500);
        }

        // 9. Custom Retro OS Toast Notification Helper
        let toastTimeout;
        function showToast(msg, title = 'NOTIFIKASI.SYS', type = 'info') {
            const toast = document.getElementById('toast');
            const msgEl = document.getElementById('toast-message');
            const titleEl = document.getElementById('toast-title');
            const iconEl = document.getElementById('toast-icon');
            if (!toast || !msgEl) return;

            msgEl.textContent = msg;
            if (titleEl) titleEl.textContent = title;

            if (iconEl) {
                if (type === 'success') {
                    iconEl.className = 'ph-bold ph-check-circle text-green-600 text-lg';
                } else if (type === 'error') {
                    iconEl.className = 'ph-bold ph-warning-circle text-red-600 text-lg';
                } else {
                    iconEl.className = 'ph-bold ph-bell-simple text-retro-accent text-lg';
                }
            }

            toast.classList.remove('hidden');
            toast.classList.add('flex');

            clearTimeout(toastTimeout);
            toastTimeout = setTimeout(() => {
                hideToast();
            }, 3600);
        }

        function hideToast() {
            const toast = document.getElementById('toast');
            if (toast) {
                toast.classList.add('hidden');
                toast.classList.remove('flex');
            }
        }

        // 10. AJAX Public Contact Form Submission
        const contactForm = document.getElementById('public-contact-form');
        const submitBtn = document.getElementById('form-submit-btn');

        if (contactForm && submitBtn) {
            contactForm.addEventListener('submit', (e) => {
                e.preventDefault();

                const nameVal = (document.getElementById('form-name')?.value || '').trim();
                const subjectVal = (document.getElementById('form-subject')?.value || '').trim();
                const messageVal = (document.getElementById('form-message')?.value || '').trim();

                if (nameVal.length < 3) {
                    showToast('Nama minimal terdiri dari 3 karakter.', 'VALIDASI_FORM.ERR', 'error');
                    return;
                }
                if (subjectVal.length < 5) {
                    showToast('Subjek minimal terdiri dari 5 karakter.', 'VALIDASI_FORM.ERR', 'error');
                    return;
                }
                if (messageVal.length < 15) {
                    showToast('Pesan minimal terdiri dari 15 karakter.', 'VALIDASI_FORM.ERR', 'error');
                    return;
                }

                // Set loading state
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="inline-block animate-spin border-2 border-white border-t-transparent rounded-full w-3.5 h-3.5"></span> Mengirim Transmisi...';

                const formData = new FormData(contactForm);

                fetch('/contact', {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                .then(async response => {
                    const res = await response.json();
                    if (!response.ok) {
                        throw new Error(res.message || 'Terjadi kesalahan sistem.');
                    }
                    return res;
                })
                .then(res => {
                    if (res.success) {
                        showToast(res.message || 'Pesan Anda telah berhasil dikirim!', 'TRANSMISI.EXE', 'success');
                        contactForm.reset();
                    } else {
                        showToast(res.message || 'Gagal mengirim pesan.', 'TRANSMISI_ERR.SYS', 'error');
                    }
                })
                .catch(err => {
                    console.error(err);
                    showToast(err.message || 'Gagal mengirim pesan. Silakan coba kembali.', 'TRANSMISI_ERR.SYS', 'error');
                })
                .finally(() => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="ph-bold ph-paper-plane-tilt"></i><span>KIRIM TRANSMISI PESAN</span>';
                });
            });
        }

        // 11. Two-Way Scroll Reveal Observer (IN & OUT)
        const revealElements = document.querySelectorAll('.retro-reveal');
        if (revealElements.length > 0 && 'IntersectionObserver' in window) {
            const revealObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        entry.target.classList.remove('is-exited-up');
                    } else {
                        if (entry.boundingClientRect.top < 0) {
                            entry.target.classList.add('is-exited-up');
                            entry.target.classList.remove('is-visible');
                        } else {
                            entry.target.classList.remove('is-visible', 'is-exited-up');
                        }
                    }
                });
            }, {
                threshold: 0.12,
                rootMargin: "-40px 0px -40px 0px"
            });
            revealElements.forEach(el => revealObserver.observe(el));
        } else {
            revealElements.forEach(el => el.classList.add('is-visible'));
        }

        // 12. Navbar ScrollSpy Active Indicator & Smooth Scrolling
        const navLinks = document.querySelectorAll('.nav-link-retro');
        const trackedSections = document.querySelectorAll('section[id]');
        if (trackedSections.length > 0 && 'IntersectionObserver' in window) {
            const spyObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const activeId = entry.target.id;
                        navLinks.forEach(link => {
                            if (link.getAttribute('data-target') === activeId) {
                                link.classList.add('is-active');
                            } else {
                                link.classList.remove('is-active');
                            }
                        });
                    }
                });
            }, {
                root: null,
                threshold: 0.25,
                rootMargin: "-10% 0px -50% 0px"
            });
            trackedSections.forEach(sec => spyObserver.observe(sec));
        }

        navLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                const targetId = link.getAttribute('data-target');
                const targetEl = document.getElementById(targetId);
                if (targetEl) {
                    e.preventDefault();
                    targetEl.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    history.replaceState(null, '', '#' + targetId);
                }
            });
        });

        // 12. Safe Fallback for Lucide
        if (typeof lucide !== 'undefined' && lucide.createIcons) {
            lucide.createIcons();
        }
    </script>
</body>
</html>
