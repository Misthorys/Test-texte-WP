<footer class="site-footer" style="background: var(--white); margin-top: 4rem; padding: 3rem 0 2rem; border-top: 1px solid var(--rose-300);">
    <div style="max-width: 1200px; margin: 0 auto; padding: 0 1.5rem;">
        <div style="display: grid; gap: 3rem; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); margin-bottom: 3rem;">
            
            <!-- Informations de contact -->
            <div>
                <h3 style="color: var(--rose-700); margin-bottom: 1.5rem; font-size: 1.2rem; font-weight: 700; display: flex; align-items: center; gap: 0.5rem;">
                    <?php echo esc_html(isabel_get_option('isabel_main_name', 'Isabel GONCALVES')); ?>
                    <div style="width: 6px; height: 6px; background: var(--rose-500); border-radius: 50%;"></div>
                </h3>
                <p style="color: var(--text-light); line-height: 1.7; margin-bottom: 1.5rem; font-size: 1rem;">
                    <?php echo esc_html(isabel_get_option('isabel_subtitle', 'Coach Certifiée & Hypnocoach')); ?><br>
                    Accompagnement personnalisé pour votre transformation
                </p>
                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    <a href="mailto:<?php echo esc_attr(isabel_get_option('isabel_email', 'contact@forma-coach.com')); ?>" 
                       style="color: var(--rose-700); text-decoration: none; font-weight: 500; display: flex; align-items: center; gap: 0.75rem; transition: all 0.3s ease; padding: 0.5rem 0;">
                        <span style="font-size: 1.1rem;">📧</span>
                        <span>Email</span>
                    </a>
                    <a href="tel:<?php echo esc_attr(isabel_get_option('isabel_phone', '+33123456789')); ?>" 
                       style="color: var(--rose-700); text-decoration: none; font-weight: 500; display: flex; align-items: center; gap: 0.75rem; transition: all 0.3s ease; padding: 0.5rem 0;">
                        <span style="font-size: 1.1rem;">📞</span>
                        <span>Téléphone</span>
                    </a>
                </div>
            </div>

            <!-- Services -->
            <div>
                <h3 style="color: var(--rose-700); margin-bottom: 1.5rem; font-size: 1.2rem; font-weight: 700;">Mes Services</h3>
                <ul style="list-style: none; padding: 0; line-height: 1.8; display: flex; flex-direction: column; gap: 0.75rem;">
                    <li>
                        <a href="#services" style="color: var(--text-light); text-decoration: none; display: flex; align-items: center; gap: 0.75rem; transition: all 0.3s ease; padding: 0.5rem 0; font-weight: 500;">
                            <span style="color: var(--rose-500);">01</span>
                            <?php echo esc_html(isabel_get_option('isabel_service1_title', 'Coaching Personnel')); ?>
                        </a>
                    </li>
                    <li>
                        <a href="#services" style="color: var(--text-light); text-decoration: none; display: flex; align-items: center; gap: 0.75rem; transition: all 0.3s ease; padding: 0.5rem 0; font-weight: 500;">
                            <span style="color: var(--rose-500);">02</span>
                            <?php echo esc_html(isabel_get_option('isabel_service2_title', 'Accompagnement VAE')); ?>
                        </a>
                    </li>
                    <li>
                        <a href="#services" style="color: var(--text-light); text-decoration: none; display: flex; align-items: center; gap: 0.75rem; transition: all 0.3s ease; padding: 0.5rem 0; font-weight: 500;">
                            <span style="color: var(--rose-500);">03</span>
                            <?php echo esc_html(isabel_get_option('isabel_service3_title', 'Hypnocoaching')); ?>
                        </a>
                    </li>
                    <li>
                        <a href="#" onclick="openPopup()" style="color: var(--rose-700); text-decoration: none; display: flex; align-items: center; gap: 0.75rem; transition: all 0.3s ease; padding: 0.5rem 0; font-weight: 600; background: var(--rose-300); padding: 0.75rem 1rem; border-radius: 25px; margin-top: 0.5rem;">
                            <span>💼</span>
                            Prendre rendez-vous
                        </a>
                    </li>
                </ul>
            </div>

            <!-- À propos - Remplace la section horaires -->
            <div>
                <h3 style="color: var(--rose-700); margin-bottom: 1.5rem; font-size: 1.2rem; font-weight: 700;">À propos</h3>
                <div style="color: var(--text-light); line-height: 1.8; display: flex; flex-direction: column; gap: 0.75rem;">
                    <p style="margin: 0; font-size: 0.95rem;">
                        Accompagnement professionnel pour votre développement personnel et professionnel.
                    </p>
                    <div style="display: flex; align-items: center; gap: 0.75rem; padding: 0.5rem 0;">
                        <span style="color: var(--rose-500); font-weight: 600;">✨</span>
                        <span style="font-weight: 500; font-size: 0.9rem;">Coach certifiée</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.75rem; padding: 0.5rem 0;">
                        <span style="color: var(--rose-500); font-weight: 600;">🎯</span>
                        <span style="font-weight: 500; font-size: 0.9rem;">Approche personnalisée</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.75rem; padding: 0.5rem 0;">
                        <span style="color: var(--rose-500); font-weight: 600;">📞</span>
                        <span style="font-weight: 500; font-size: 0.9rem;">Consultation sur rendez-vous</span>
                    </div>
                    
                    <div style="margin-top: 1.5rem; padding: 1.5rem; background: linear-gradient(135deg, var(--pastel-lavender), var(--pastel-pink)); border-radius: 12px; font-size: 0.95rem; text-align: center;">
                        <strong>Ensemble, réalisons vos objectifs</strong><br>
                        Contactez-moi pour commencer votre transformation
                    </div>
                </div>
            </div>

        </div>

        <!-- Séparateur élégant -->
        <div style="height: 1px; background: linear-gradient(90deg, transparent, var(--rose-300), transparent); margin: 2rem 0;"></div>

        <!-- Copyright et mentions légales -->
        <div style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 1.5rem; padding: 1rem 0;">
            <div style="color: var(--text-light); font-size: 0.95rem; display: flex; align-items: center; gap: 0.5rem;">
                <span>© <?php echo date('Y'); ?> <?php echo esc_html(isabel_get_option('isabel_main_name', 'Isabel GONCALVES')); ?></span>
                <div style="width: 4px; height: 4px; background: var(--rose-500); border-radius: 50%;"></div>
                <span>Coach Certifiée. Tous droits réservés.</span>
            </div>
            
            <div style="display: flex; gap: 2rem; font-size: 0.95rem;">
                <a href="/mentions-legales" style="color: var(--text-light); text-decoration: none; font-weight: 500; transition: color 0.3s ease;">Mentions légales</a>
                <a href="/confidentialite" style="color: var(--text-light); text-decoration: none; font-weight: 500; transition: color 0.3s ease;">Confidentialité</a>
                <a href="/cgv" style="color: var(--text-light); text-decoration: none; font-weight: 500; transition: color 0.3s ease;">CGV</a>
            </div>
        </div>

        <!-- Badge professionnel épuré -->
        <div style="text-align: center; margin-top: 2rem;">
            <div style="display: inline-flex; align-items: center; gap: 0.75rem; padding: 1rem 2rem; background: var(--white); border-radius: 50px; border: 2px solid var(--rose-300); box-shadow: var(--shadow-soft);">
                <span style="color: var(--rose-700); font-size: 1rem;">✨</span>
                <span style="color: var(--rose-700); font-size: 0.9rem; font-weight: 700;">Coach Professionnelle Certifiée</span>
                <span style="color: var(--rose-700); font-size: 1rem;">✨</span>
            </div>
        </div>
    </div>
</footer>

<!-- CSS pour les effets hover -->
<style>
footer a:hover {
    color: var(--rose-700) !important;
    transform: translateX(4px);
}

footer .site-footer a[href^="/"]:hover {
    transform: none;
}

/* Styles pour la navigation au clavier */
.keyboard-navigation a:focus,
.keyboard-navigation button:focus {
    outline: 2px solid var(--rose-500) !important;
    outline-offset: 2px !important;
}
</style>

<!-- Script JavaScript minimaliste -->
<script>
// Navigation mobile - Version minimaliste
document.addEventListener('DOMContentLoaded', function() {
    // Vérifier si main.js a déjà initialisé les fonctions
    if (typeof window.openPopup === 'undefined') {
        console.log('🔧 Initialisation du fallback JavaScript minimaliste');
        
        // Navigation mobile
        const navToggle = document.getElementById('nav-toggle');
        const navMenu = document.getElementById('nav-menu');

        if (navToggle && navMenu) {
            navToggle.addEventListener('click', function() {
                navMenu.classList.toggle('active');
            });

            // Fermer le menu mobile en cliquant sur un lien
            const navLinks = navMenu.querySelectorAll('a');
            navLinks.forEach(function(link) {
                link.addEventListener('click', function() {
                    if (navMenu.classList.contains('active')) {
                        navMenu.classList.remove('active');
                    }
                });
            });

            // Fermer le menu en cliquant ailleurs
            document.addEventListener('click', function(e) {
                if (!navToggle.contains(e.target) && !navMenu.contains(e.target)) {
                    navMenu.classList.remove('active');
                }
            });
        }

        // Fonctions modal - Version minimaliste
        window.openPopup = function() {
            const overlay = document.getElementById('modal-overlay');
            if (overlay) {
                overlay.style.display = 'flex';
                document.body.style.overflow = 'hidden';
                setTimeout(function() {
                    overlay.classList.add('active');
                }, 10);
            }
        };

        window.closePopup = function() {
            const overlay = document.getElementById('modal-overlay');
            if (overlay) {
                overlay.classList.remove('active');
                document.body.style.overflow = '';
                setTimeout(function() {
                    overlay.style.display = 'none';
                }, 300);