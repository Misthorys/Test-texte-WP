<?php get_header(); ?>

<!-- Header épuré avec logo et boutons -->
<header class="header">
  <div class="header-container">
    <!-- Logo Section -->
    <a href="<?php echo esc_url(home_url('/')); ?>" class="header-logo">
      <?php 
      $header_logo = isabel_get_option('isabel_header_logo', '');
      if (!empty($header_logo)) {
        echo '<img src="' . esc_url($header_logo) . '" alt="Logo Isabel GONCALVES" class="logo-image" />';
      } else {
        echo '<div class="logo-placeholder">IG</div>';
      }
      ?>
      <div class="logo-text">
        <div class="logo-name"><?php echo esc_html(isabel_get_option('isabel_header_name', 'Isabel GONCALVES')); ?></div>
        <div class="logo-subtitle"><?php echo esc_html(isabel_get_option('isabel_header_subtitle', 'Formatrice & Coach Certifiée')); ?></div>
      </div>
    </a>

    <!-- Navigation avec boutons -->
    <nav class="nav-menu" id="nav-menu">
      <?php
      wp_nav_menu(array(
        'theme_location' => 'main-menu',
        'container' => false,
        'items_wrap' => '<ul>%3$s</ul>',
        'fallback_cb' => 'isabel_default_menu'
      ));
      ?>
    </nav>

    <!-- Button CTA Header -->
    <div class="header-cta">
      <button onclick="openPopup()">Prendre rendez-vous</button>
    </div>

    <!-- Mobile Toggle -->
    <button class="nav-toggle" id="nav-toggle">Menu</button>
  </div>
</header>

<!-- Hero Section avec contenu des éditeurs Word-like -->
<section class="hero-floating" id="accueil">
  <div class="hero-content-wrapper">
    
    <!-- Image de profil mobile -->
    <div class="mobile-profile-section">
      <?php 
      $mobile_profile_image = isabel_get_option('isabel_mobile_profile_image', '');
      if (!empty($mobile_profile_image)) {
        echo '<div class="mobile-profile-container-simple">';
        echo '<img src="' . esc_url($mobile_profile_image) . '" alt="Photo d\'Isabel GONCALVES" class="mobile-profile-image" />';
        echo '</div>';
      }
      ?>
    </div>

    <!-- Contenu texte avec formatage Word-like -->
    <div class="intro-card">
      <div class="hero-badge">
        <span>✨</span>
        Coach certifiée
      </div>
      
      <!-- Titre principal depuis l'éditeur Word-like -->
      <div class="profile-info">
        <?php isabel_display_word_editor_content_fixed('isabel_main_name_word', '<h1 style="font-size: 48px; font-weight: bold; color: #2d1b3d;">Isabel GONCALVES</h1>'); ?>
      </div>
      
      <!-- Sous-titre depuis l'éditeur Word-like -->
      <div class="profile-subtitle">
        <?php isabel_display_word_editor_content_fixed('isabel_subtitle_word', '<p style="font-size: 24px; color: #2d1b3d; font-style: italic;">Coach Certifiée &amp; Hypnocoach</p>'); ?>
      </div>
      
      <!-- Texte d'introduction depuis l'éditeur Word-like -->
      <div class="intro-text">
        <?php isabel_display_word_editor_content_fixed('isabel_intro_text_word', '<p style="font-size: 18px; line-height: 1.7; color: #2d1b3d;">Bienvenue dans votre espace de <strong>transformation personnelle</strong> ! Je vous accompagne avec <em>bienveillance</em> vers l\'épanouissement de votre potentiel grâce au coaching, à la VAE et à l\'hypnocoaching.</p>'); ?>
      </div>
      
      <div class="hero-cta">
        <button class="cta-main" onclick="openPopup()">
          <span>🚀</span>
          <span>Prendre rendez-vous</span>
        </button>
        <button class="btn-secondary">En savoir plus</button>
      </div>
    </div>

    <!-- Image de profil principale (desktop seulement) -->
    <div class="hero-right">
      <div class="hero-profile-container-simple">
        <?php 
        $profile_image = isabel_get_option('isabel_profile_image', '');
        if (!empty($profile_image)) {
          echo '<img src="' . esc_url($profile_image) . '" alt="Photo d\'Isabel GONCALVES" class="hero-profile-image" />';
        } else {
          echo '<div class="hero-profile-placeholder">';
          echo '<svg width="280" height="280" viewBox="0 0 280 280" xmlns="http://www.w3.org/2000/svg">';
          echo '<defs>';
          echo '<linearGradient id="placeholderGradient" x1="0%" y1="0%" x2="100%" y2="100%">';
          echo '<stop offset="0%" style="stop-color:var(--rose-500);stop-opacity:0.8" />';
          echo '<stop offset="100%" style="stop-color:var(--rose-700);stop-opacity:0.8" />';
          echo '</linearGradient>';
          echo '</defs>';
          echo '<circle cx="140" cy="140" r="130" fill="url(#placeholderGradient)"/>';
          echo '<circle cx="140" cy="100" r="35" fill="white" opacity="0.9"/>';
          echo '<path d="M85 200 Q140 160 195 200 L195 240 Q140 200 85 240 Z" fill="white" opacity="0.9"/>';
          echo '</svg>';
          echo '</div>';
        }
        ?>
      </div>
    </div>

  </div>
</section>

<!-- Section Certification Qualiopi -->
<?php isabel_display_qualiopi_section('home'); ?>

<!-- Services Section avec contenu des éditeurs Word-like -->
<section class="services-section" id="services">
  <div class="section-container">
    
    <!-- Titre et sous-titre depuis les éditeurs Word-like -->
    <?php isabel_display_word_editor_content_fixed('isabel_services_title_word', '<h2 style="font-size: 36px; font-weight: bold; color: #2d1b3d; text-align: center;">Mes Accompagnements Sur Mesure</h2>'); ?>
    
    <?php isabel_display_word_editor_content_fixed('isabel_services_subtitle_word', '<p style="font-size: 18px; color: #6b5b73; text-align: center; font-style: italic;">Quatre approches complémentaires pour révéler votre potentiel et atteindre vos objectifs personnels et professionnels.</p>'); ?>

    <div class="services-grid">
      <?php for ($i = 1; $i <= 4; $i++): ?>
        <?php
        $service_urls = array(
          1 => home_url('/coaching-personnel'),
          2 => home_url('/accompagnement-vae'),
          3 => home_url('/hypnocoaching'),
          4 => home_url('/consultation-decouverte')
        );
        
        // Contenu par défaut si pas encore défini dans l'éditeur Word-like
        $default_titles = array(
          1 => '<h3 style="font-size: 22px; font-weight: bold; color: #2d1b3d;">Coaching Personnel</h3>',
          2 => '<h3 style="font-size: 22px; font-weight: bold; color: #2d1b3d;">Accompagnement VAE</h3>',
          3 => '<h3 style="font-size: 22px; font-weight: bold; color: #2d1b3d;">Hypnocoaching</h3>',
          4 => '<h3 style="font-size: 22px; font-weight: bold; color: #2d1b3d;">Consultation Découverte</h3>'
        );
        
        $default_descriptions = array(
          1 => '<p style="font-size: 16px; color: #6b5b73; line-height: 1.6;">Révélez votre <strong>potentiel</strong>, clarifiez vos objectifs et transformez votre vie avec un accompagnement personnalisé et des outils concrets.</p>',
          2 => '<p style="font-size: 16px; color: #6b5b73; line-height: 1.6;">Valorisez votre <em>expérience</em> et obtenez une reconnaissance officielle de vos compétences grâce à un accompagnement expert VAE.</p>',
          3 => '<p style="font-size: 16px; color: #6b5b73; line-height: 1.6;">Libérez-vous de vos <u>blocages</u> en profondeur en combinant les bienfaits de l\'hypnose thérapeutique et du coaching de vie.</p>',
          4 => '<p style="font-size: 16px; color: #6b5b73; line-height: 1.6;">Première rencontre <span style="background-color: #ffff00;">gratuite</span> pour faire connaissance, comprendre vos besoins et définir ensemble le meilleur accompagnement pour vous.</p>'
        );
        ?>
        <a href="<?php echo esc_url($service_urls[$i]); ?>" class="service-card service-link">
          <div class="service-icon"><?php echo sprintf('%02d', $i); ?></div>
          
          <!-- Titre du service depuis l'éditeur Word-like -->
          <div class="service-title-container">
            <?php isabel_display_word_editor_content_fixed("isabel_service{$i}_title_word", $default_titles[$i]); ?>
          </div>
          
          <!-- Description du service depuis l'éditeur Word-like -->
          <div class="service-description-container">
            <?php isabel_display_word_editor_content_fixed("isabel_service{$i}_desc_word", $default_descriptions[$i]); ?>
          </div>
          
          <div class="service-arrow">→</div>
        </a>
      <?php endfor; ?>
    </div>
  </div>
</section>

<!-- Témoignages Section avec contenu des éditeurs Word-like -->
<section class="testimonials-section" id="temoignages">
  <div class="section-container">
    
    <!-- Titre depuis l'éditeur Word-like -->
    <?php isabel_display_word_editor_content_fixed('isabel_testimonials_title_word', '<h2 style="font-size: 36px; font-weight: bold; color: #2d1b3d; text-align: center;">Ce que disent mes <span style="color: #c47dd9;">clients</span></h2>'); ?>
    
    <!-- Sous-titre depuis l'éditeur Word-like -->
    <?php isabel_display_word_editor_content_fixed('isabel_testimonials_subtitle_word', '<p style="font-size: 18px; color: #6b5b73; text-align: center; font-style: italic;">Découvrez les témoignages de personnes qui ont <strong>transformé leur vie</strong> grâce à un accompagnement personnalisé.</p>'); ?>

    <div class="testimonials-grid">
      <?php
      // Récupérer les témoignages depuis le type de contenu personnalisé
      $testimonials = get_posts(array(
        'post_type' => 'testimonial',
        'posts_per_page' => 3,
        'post_status' => 'publish'
      ));
      
      if (!empty($testimonials)) {
        foreach ($testimonials as $testimonial) {
          $author_name = get_post_meta($testimonial->ID, '_testimonial_author_name', true);
          $author_title = get_post_meta($testimonial->ID, '_testimonial_author_title', true);
          $author_initials = get_post_meta($testimonial->ID, '_testimonial_author_initials', true);
          ?>
          <div class="testimonial-card">
            <div class="testimonial-content">
              <?php echo esc_html(get_the_content(null, false, $testimonial)); ?>
            </div>
            <div class="testimonial-author">
              <div class="author-avatar"><?php echo esc_html($author_initials); ?></div>
              <div class="author-info">
                <div class="author-name"><?php echo esc_html($author_name); ?></div>
                <div class="author-title"><?php echo esc_html($author_title); ?></div>
              </div>
            </div>
          </div>
          <?php
        }
      } else {
        // Témoignages par défaut si aucun n'est créé
        ?>
        <div class="testimonial-card">
          <div class="testimonial-content">
            "Grâce à Isabel, j'ai enfin trouvé ma voie professionnelle. Son approche bienveillante et ses outils concrets m'ont permis de reprendre confiance en moi et d'atteindre mes objectifs."
          </div>
          <div class="testimonial-author">
            <div class="author-avatar">ML</div>
            <div class="author-info">
              <div class="author-name">Marie L.</div>
              <div class="author-title">Manager</div>
            </div>
          </div>
        </div>

        <div class="testimonial-card">
          <div class="testimonial-content">
            "L'accompagnement VAE avec Isabel a été un véritable succès. Elle m'a guidé à chaque étape avec professionnalisme et empathie. Je recommande vivement ses services."
          </div>
          <div class="testimonial-author">
            <div class="author-avatar">TR</div>
            <div class="author-info">
              <div class="author-name">Thomas R.</div>
              <div class="author-title">Technicien Certifié</div>
            </div>
          </div>
        </div>

        <div class="testimonial-card">
          <div class="testimonial-content">
            "Les séances d'hypnocoaching m'ont aidée à surmonter mes angoisses et à retrouver un équilibre. Merci Isabel pour cette transformation profonde et durable."
          </div>
          <div class="testimonial-author">
            <div class="author-avatar">LM</div>
            <div class="author-info">
              <div class="author-name">Léa M.</div>
              <div class="author-title">Entrepreneur</div>
            </div>
          </div>
        </div>
        <?php
      }
      ?>
    </div>
  </div>
</section>

<!-- CTA Section avec contenu des éditeurs Word-like -->
<section class="cta-section" id="contact">
  <div class="section-container">
    <div class="cta-box">
      
      <!-- Titre CTA depuis l'éditeur Word-like -->
      <?php isabel_display_word_editor_content_fixed('isabel_cta_title_word', '<h2 style="font-size: 32px; font-weight: bold; color: #ffffff; text-align: center;">Prêt(e) à <span style="color: #ffff00;">Commencer</span> Votre Transformation ?</h2>'); ?>
      
      <!-- Texte CTA depuis l'éditeur Word-like -->
      <?php isabel_display_word_editor_content_fixed('isabel_cta_text_word', '<p style="font-size: 18px; color: #ffffff; text-align: center; line-height: 1.6;"><strong>Contactez-moi dès maintenant</strong> pour discuter de vos objectifs et découvrir comment je peux vous accompagner dans votre <em>transformation</em>.</p>'); ?>
      
      <button class="cta-button" onclick="openPopup()">
        Prendre rendez-vous
      </button>
    </div>
  </div>
</section>

<!-- Libellule animée -->
<div class="dragonfly">
  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 60" width="100%" height="100%">
    <ellipse cx="50" cy="30" rx="2" ry="10" fill="var(--rose-700)" opacity="0.8"/>
    <ellipse cx="38" cy="22" rx="10" ry="5" fill="var(--rose-500)" opacity="0.6"/>
    <ellipse cx="62" cy="22" rx="10" ry="5" fill="var(--rose-500)" opacity="0.6"/>
    <ellipse cx="38" cy="32" rx="8" ry="4" fill="var(--pastel-violet)" opacity="0.6"/>
    <ellipse cx="62" cy="32" rx="8" ry="4" fill="var(--pastel-violet)" opacity="0.6"/>
    <circle cx="50" cy="18" r="2.5" fill="var(--rose-700)"/>
    <circle cx="48.5" cy="16.5" r="0.8" fill="white"/>
    <circle cx="51.5" cy="16.5" r="0.8" fill="white"/>
  </svg>
</div>

<!-- Modal formulaire de contact -->
<div class="modal-overlay" id="modal-overlay">
  <div class="modal-content">
    <button class="modal-close" onclick="closePopup()">×</button>
    
    <h2 class="modal-title">Réservez votre rendez-vous</h2>
    <p class="modal-subtitle">Première consultation personnalisée</p>

    <form class="modal-form" id="contact-form">
      <div class="form-group">
        <label class="form-label">Nom complet</label>
        <input type="text" class="form-input" placeholder="Votre nom et prénom" name="name" required>
      </div>

      <div class="form-group">
        <label class="form-label">Adresse email</label>
        <input type="email" class="form-input" placeholder="votre@email.com" name="email" required>
      </div>

      <div class="form-group">
        <label class="form-label">Téléphone</label>
        <input type="tel" class="form-input" placeholder="06 12 34 56 78" name="phone" required>
      </div>

      <div class="form-group">
        <label class="form-label">Type d'accompagnement souhaité</label>
        <select class="form-input" name="service" required>
          <option value="">Choisissez une option</option>
          <option value="Coaching Personnel">Coaching Personnel</option>
          <option value="Accompagnement VAE">Accompagnement VAE</option>
          <option value="Hypnocoaching">Hypnocoaching</option>
          <option value="Consultation Découverte">Consultation Découverte</option>
        </select>
      </div>

      <div class="form-group">
        <label class="form-label">Votre situation et objectifs</label>
        <textarea class="form-input form-textarea" placeholder="Décrivez-nous brièvement votre situation actuelle et ce que vous aimeriez accomplir..." rows="4" name="message"></textarea>
      </div>

      <div class="form-note">
        💼 Première consultation pour faire connaissance et définir vos besoins ensemble.
      </div>

      <button type="submit" class="form-submit" id="submit-btn">
        Confirmer ma demande de rendez-vous
      </button>
      
      <div id="form-messages" style="margin-top: 1rem;"></div>
    </form>
  </div>
</div>

<!-- SCRIPT COMPLET INTÉGRÉ -->
<script>
// Configuration AJAX WordPress
const ISABEL_CONFIG = {
    ajax_url: '<?php echo admin_url('admin-ajax.php'); ?>',
    nonce: '<?php echo wp_create_nonce('isabel_contact_nonce'); ?>',
    debug: <?php echo (defined('WP_DEBUG') && WP_DEBUG) ? 'true' : 'false'; ?>
};

// Fonctions globales pour les boutons
window.openPopup = function() {
    const overlay = document.getElementById('modal-overlay');
    if (overlay) {
        overlay.style.display = 'flex';
        document.body.style.overflow = 'hidden';
        setTimeout(() => {
            overlay.classList.add('active');
        }, 10);
    }
};

window.closePopup = function() {
    const overlay = document.getElementById('modal-overlay');
    if (overlay) {
        overlay.classList.remove('active');
        document.body.style.overflow = '';
        setTimeout(() => {
            overlay.style.display = 'none';
        }, 300);
    }
};

// Initialisation au chargement du DOM
document.addEventListener('DOMContentLoaded', function() {
    initModal();
    initContactForm();
    initNavigation();
    initHeroBackground();
});

function initModal() {
    const overlay = document.getElementById('modal-overlay');
    if (!overlay) return;

    overlay.addEventListener('click', function(e) {
        if (e.target === overlay) {
            window.closePopup();
        }
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && overlay.classList.contains('active')) {
            window.closePopup();
        }
    });
}

function initContactForm() {
    const form = document.getElementById('contact-form');
    if (!form) return;

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        handleFormSubmission(form);
    });
}

function initNavigation() {
    const navToggle = document.getElementById('nav-toggle');
    const navMenu = document.getElementById('nav-menu');

    if (navToggle && navMenu) {
        navToggle.addEventListener('click', function() {
            navMenu.classList.toggle('mobile-active');
            
            // Amélioration accessibilité
            const isOpen = navMenu.classList.contains('mobile-active');
            navToggle.setAttribute('aria-expanded', isOpen);
            navMenu.setAttribute('aria-hidden', !isOpen);
            navToggle.textContent = isOpen ? 'Fermer' : 'Menu';
        });

        // Fermer le menu en cliquant sur un lien
        const navLinks = navMenu.querySelectorAll('a');
        navLinks.forEach(function(link) {
            link.addEventListener('click', function() {
                if (navMenu.classList.contains('mobile-active')) {
                    navMenu.classList.remove('mobile-active');
                    navToggle.setAttribute('aria-expanded', 'false');
                    navMenu.setAttribute('aria-hidden', 'true');
                    navToggle.textContent = 'Menu';
                }
            });
        });

        // Fermer le menu en cliquant ailleurs
        document.addEventListener('click', function(e) {
            if (!navToggle.contains(e.target) && !navMenu.contains(e.target)) {
                navMenu.classList.remove('mobile-active');
                navToggle.setAttribute('aria-expanded', 'false');
                navMenu.setAttribute('aria-hidden', 'true');
                navToggle.textContent = 'Menu';
            }
        });
    }
}

function initHeroBackground() {
    // Récupérer l'image de fond depuis WordPress
    const heroSection = document.querySelector('.hero-floating');
    const bgImage = '<?php echo esc_js(isabel_get_option('isabel_hero_background_image', '')); ?>';
    
    if (bgImage && heroSection) {
        // Définir l'image de fond via CSS custom property
        document.documentElement.style.setProperty('--hero-bg-image', `url(${bgImage})`);
        heroSection.classList.add('has-bg-image');
        console.log('🖼️ Image de fond hero définie:', bgImage);
    } else {
        // Pas d'image de fond, utiliser le dégradé par défaut
        heroSection.classList.add('no-bg-image');
        console.log('🎨 Dégradé par défaut utilisé pour le hero');
    }
}

function handleFormSubmission(form) {
    const submitBtn = document.getElementById('submit-btn');
    const originalText = submitBtn.textContent;
    
    const formData = new FormData(form);
    const data = {
        name: formData.get('name')?.trim() || '',
        email: formData.get('email')?.trim() || '',
        phone: formData.get('phone')?.trim() || '',
        service: formData.get('service')?.trim() || '',
        message: formData.get('message')?.trim() || ''
    };
    
    if (!data.name || !data.email || !data.phone) {
        showMessage('Veuillez remplir tous les champs obligatoires.', 'error');
        return;
    }
    
    if (!isValidEmail(data.email)) {
        showMessage('Veuillez entrer une adresse email valide.', 'error');
        return;
    }
    
    submitBtn.disabled = true;
    submitBtn.textContent = 'Envoi en cours...';
    
    const ajaxData = new FormData();
    ajaxData.append('action', 'isabel_contact');
    ajaxData.append('nonce', ISABEL_CONFIG.nonce);
    ajaxData.append('name', data.name);
    ajaxData.append('email', data.email);
    ajaxData.append('phone', data.phone);
    ajaxData.append('service', data.service);
    ajaxData.append('message', data.message);
    
    fetch(ISABEL_CONFIG.ajax_url, {
        method: 'POST',
        body: ajaxData
    })
    .then(response => response.text())
    .then(text => {
        try {
            const responseData = JSON.parse(text);
            if (responseData.success) {
                showMessage(responseData.data, 'success');
                form.reset();
                setTimeout(() => {
                    window.closePopup();
                }, 2000);
            } else {
                showMessage(responseData.data || 'Erreur lors de l\'envoi.', 'error');
            }
        } catch (e) {
            showMessage('Erreur de communication avec le serveur.', 'error');
        }
    })
    .catch(error => {
        showMessage('Erreur de connexion. Veuillez réessayer.', 'error');
    })
    .finally(() => {
        submitBtn.disabled = false;
        submitBtn.textContent = originalText;
    });
}

function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

function showMessage(message, type) {
    const messagesDiv = document.getElementById('form-messages');
    const color = type === 'success' ? '#00a32a' : '#e74c3c';
    const icon = type === 'success' ? '✅' : '❌';
    
    messagesDiv.innerHTML = `
        <div style="
            padding: 15px; 
            background: ${color}; 
            color: white; 
            border-radius: 8px; 
            margin-top: 15px;
            text-align: center;
            font-weight: 500;
        ">
            ${icon} ${message}
        </div>
    `;
    
    setTimeout(() => {
        messagesDiv.innerHTML = '';
    }, 5000);
}

// Affichage des statistiques de l'éditeur Word-like (pour développement)
if (ISABEL_CONFIG.debug && typeof window.IsabelWordEditor !== 'undefined') {
    console.log('📊 Statistiques des éditeurs Word-like:', window.IsabelWordEditor.getStats());
}
</script>

<!-- Styles supplémentaires pour l'intégration des éditeurs Word-like -->
<style>
/* Intégration harmonieuse du contenu des éditeurs Word-like */
.service-title-container h3,
.service-description-container p {
    margin: 0;
    padding: 0;
}

.service-title-container {
    margin-bottom: 1rem;
}

.service-description-container {
    flex: 1;
    margin-bottom: 1.5rem;
}

/* Assurer que le contenu HTML des éditeurs s'affiche correctement */
.profile-info,
.profile-subtitle,
.intro-text,
.service-title-container,
.service-description-container {
    word-wrap: break-word;
    overflow-wrap: break-word;
}

/* Styles pour le contenu formaté depuis les éditeurs Word-like */
.profile-info h1 {
    line-height: 1.2;
    margin: 0;
}

.profile-subtitle p {
    margin: 0;
    line-height: 1.4;
}

.intro-text p {
    margin: 0;
    line-height: 1.7;
}

/* Support pour les éléments span avec couleurs personnalisées */
.profile-info span,
.profile-subtitle span,
.intro-text span,
.service-title-container span,
.service-description-container span {
    display: inline;
}

/* Support pour les mises en forme dans les services */
.service-card h3 {
    line-height: 1.3;
}

.service-card p {
    line-height: 1.6;
}

/* Styles pour les éléments formatés dans le CTA */
.cta-box h2,
.cta-box p {
    margin: 0 0 1rem 0;
}

.cta-box h2:last-child,
.cta-box p:last-child {
    margin-bottom: 2rem;
}

/* Préservation des styles inline des éditeurs Word-like */
.cta-box span[style],
.profile-info span[style],
.service-card span[style] {
    /* Les styles inline sont préservés automatiquement */
}

/* Animation douce pour le contenu dynamique */
.service-title-container,
.service-description-container,
.profile-info,
.profile-subtitle,
.intro-text {
    transition: opacity 0.3s ease;
}

/* Mode debug pour visualiser les zones des éditeurs Word-like */
.isabel-debug .service-title-container,
.isabel-debug .service-description-container,
.isabel-debug .profile-info,
.isabel-debug .profile-subtitle,
.isabel-debug .intro-text {
    outline: 1px dashed rgba(0, 123, 255, 0.5);
    position: relative;
}

.isabel-debug .service-title-container::before,
.isabel-debug .service-description-container::before,
.isabel-debug .profile-info::before,
.isabel-debug .profile-subtitle::before,
.isabel-debug .intro-text::before {
    content: 'Word Editor';
    position: absolute;
    top: -20px;
    left: 0;
    font-size: 10px;
    background: rgba(0, 123, 255, 0.8);
    color: white;
    padding: 2px 6px;
    border-radius: 3px;
    font-family: monospace;
}

/* Responsive pour le contenu des éditeurs */
@media (max-width: 768px) {
    .service-title-container h3 {
        font-size: 1.1rem !important;
    }
    
    .service-description-container p {
        font-size: 0.9rem !important;
    }
    
    .profile-info h1 {
        font-size: 2rem !important;
    }
    
    .intro-text p {
        font-size: 0.95rem !important;
    }
}
</style>

<?php
// Fonction menu par défaut
function isabel_default_menu() {
    echo '<ul>';
    echo '<li><a href="' . home_url('/') . '">Accueil</a></li>';
    echo '<li><a href="' . home_url('/coaching-personnel') . '">Coaching Personnel</a></li>';
    echo '<li><a href="' . home_url('/accompagnement-vae') . '">Accompagnement VAE</a></li>';
    echo '<li><a href="' . home_url('/hypnocoaching') . '">Hypnocoaching</a></li>';
    echo '<li><a href="' . home_url('/consultation-decouverte') . '">Consultation Découverte</a></li>';
    echo '<li><a href="#temoignages">Témoignages</a></li>';
    echo '<li><a href="#contact">Contact</a></li>';
    echo '</ul>';
}
?>

<?php get_footer(); ?>