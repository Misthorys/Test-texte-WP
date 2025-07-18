<?php
// Empêcher l'accès direct au fichier
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Customizer pour la PAGE D'ACCUEIL
 */

function isabel_register_home_customizer($wp_customize) {
    
    // ===== SECTION HERO =====
    $wp_customize->add_section('isabel_hero_section', array(
        'title' => '🏠 Page d\'Accueil - Hero',
        'priority' => 25,
        'description' => 'Section principale de la page d\'accueil'
    ));
    
    // Image de profil principale
    $wp_customize->add_setting('isabel_profile_image', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'isabel_profile_image', array(
        'label' => 'Photo de Profil Principale',
        'description' => 'Photo affichée sur desktop (400x400px recommandé)',
        'section' => 'isabel_hero_section',
        'priority' => 10,
    )));
    
    // Image de profil mobile
    $wp_customize->add_setting('isabel_mobile_profile_image', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'isabel_mobile_profile_image', array(
        'label' => 'Photo de Profil Mobile',
        'description' => 'Photo affichée sur mobile (200x200px recommandé)',
        'section' => 'isabel_hero_section',
        'priority' => 11,
    )));
    
    // Image de fond hero
    $wp_customize->add_setting('isabel_hero_background_image', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'isabel_hero_background_image', array(
        'label' => 'Image de Fond Hero',
        'description' => 'Image de fond pour la section hero (1920x1080px recommandé)',
        'section' => 'isabel_hero_section',
        'priority' => 12,
    )));
    
    // Nom principal avec éditeur Word-like
    isabel_add_word_editor(
        $wp_customize,
        'isabel_main_name_word',
        '📝 Nom Principal',
        '<h1 style="font-size: 48px; font-weight: bold; color: #2d1b3d;">Isabel GONCALVES</h1>',
        'isabel_hero_section',
        array(
            'description' => 'Nom affiché en grand dans la section hero',
            'editor_height' => '100px',
            'priority' => 20
        )
    );
    
    // Sous-titre avec éditeur Word-like
    isabel_add_word_editor(
        $wp_customize,
        'isabel_subtitle_word',
        '📝 Sous-titre',
        '<p style="font-size: 24px; color: #2d1b3d; font-style: italic;">Coach Certifiée &amp; Hypnocoach</p>',
        'isabel_hero_section',
        array(
            'description' => 'Sous-titre descriptif',
            'editor_height' => '100px',
            'priority' => 21
        )
    );
    
    // Texte d'introduction avec éditeur Word-like
    isabel_add_word_editor(
        $wp_customize,
        'isabel_intro_text_word',
        '📝 Texte d\'Introduction',
        '<p style="font-size: 18px; line-height: 1.7; color: #2d1b3d;">Bienvenue dans votre espace de <strong>transformation personnelle</strong> ! Je vous accompagne avec <em>bienveillance</em> vers l\'épanouissement de votre potentiel grâce au coaching, à la VAE et à l\'hypnocoaching.</p>',
        'isabel_hero_section',
        array(
            'description' => 'Texte de présentation principal',
            'editor_height' => '150px',
            'priority' => 22
        )
    );
    
    // Badge hero avec éditeur Word-like
    isabel_add_word_editor(
        $wp_customize,
        'isabel_hero_badge_word',
        '📝 Badge Hero',
        '<span style="font-weight: bold;">✨ Coach certifiée</span>',
        'isabel_hero_section',
        array(
            'description' => 'Badge affiché au-dessus du nom',
            'editor_height' => '80px',
            'priority' => 23
        )
    );
    
    // Texte bouton principal avec éditeur Word-like
    isabel_add_word_editor(
        $wp_customize,
        'isabel_main_button_text_word',
        '📝 Texte Bouton Principal',
        '<span style="font-weight: bold;">🚀 Prendre rendez-vous</span>',
        'isabel_hero_section',
        array(
            'description' => 'Texte du bouton principal',
            'editor_height' => '80px',
            'priority' => 24
        )
    );
    
    // ===== SECTION SERVICES =====
    $wp_customize->add_section('isabel_services_section', array(
        'title' => '🎯 Page d\'Accueil - Services',
        'priority' => 26,
        'description' => 'Section des services sur la page d\'accueil'
    ));
    
    // Titre services avec éditeur Word-like
    isabel_add_word_editor(
        $wp_customize,
        'isabel_services_title_word',
        '📝 Titre Services',
        '<h2 style="font-size: 36px; font-weight: bold; color: #2d1b3d; text-align: center;">Mes Accompagnements Sur Mesure</h2>',
        'isabel_services_section',
        array(
            'description' => 'Titre de la section services',
            'editor_height' => '100px',
            'priority' => 10
        )
    );
    
    // Sous-titre services avec éditeur Word-like
    isabel_add_word_editor(
        $wp_customize,
        'isabel_services_subtitle_word',
        '📝 Sous-titre Services',
        '<p style="font-size: 18px; color: #6b5b73; text-align: center; font-style: italic;">Quatre approches complémentaires pour révéler votre potentiel et atteindre vos objectifs personnels et professionnels.</p>',
        'isabel_services_section',
        array(
            'description' => 'Sous-titre de la section services',
            'editor_height' => '120px',
            'priority' => 11
        )
    );
    
    // Services individuels (4 services) avec éditeurs Word-like
    for ($i = 1; $i <= 4; $i++) {
        $service_names = array(
            1 => 'Coaching Personnel',
            2 => 'Accompagnement VAE',
            3 => 'Hypnocoaching',
            4 => 'Consultation Découverte'
        );
        
        $default_descriptions = array(
            1 => '<p style="font-size: 16px; color: #6b5b73; line-height: 1.6;">Révélez votre <strong>potentiel</strong>, clarifiez vos objectifs et transformez votre vie avec un accompagnement personnalisé et des outils concrets.</p>',
            2 => '<p style="font-size: 16px; color: #6b5b73; line-height: 1.6;">Valorisez votre <em>expérience</em> et obtenez une reconnaissance officielle de vos compétences grâce à un accompagnement expert VAE.</p>',
            3 => '<p style="font-size: 16px; color: #6b5b73; line-height: 1.6;">Libérez-vous de vos <u>blocages</u> en profondeur en combinant les bienfaits de l\'hypnose thérapeutique et du coaching de vie.</p>',
            4 => '<p style="font-size: 16px; color: #6b5b73; line-height: 1.6;">Première rencontre <span style="background-color: #ffff00;">gratuite</span> pour faire connaissance, comprendre vos besoins et définir ensemble le meilleur accompagnement pour vous.</p>'
        );
        
        // Titre service avec éditeur Word-like
        isabel_add_word_editor(
            $wp_customize,
            "isabel_service{$i}_title_word",
            "📝 Service {$i} - Titre",
            '<h3 style="font-size: 22px; font-weight: bold; color: #2d1b3d;">' . $service_names[$i] . '</h3>',
            'isabel_services_section',
            array(
                'description' => "Titre du service {$i}",
                'editor_height' => '80px',
                'priority' => 20 + ($i * 2)
            )
        );
        
        // Description service avec éditeur Word-like
        isabel_add_word_editor(
            $wp_customize,
            "isabel_service{$i}_desc_word",
            "📝 Service {$i} - Description",
            $default_descriptions[$i],
            'isabel_services_section',
            array(
                'description' => "Description du service {$i}",
                'editor_height' => '120px',
                'priority' => 21 + ($i * 2)
            )
        );
    }
    
    // ===== SECTION TÉMOIGNAGES =====
    $wp_customize->add_section('isabel_testimonials_section', array(
        'title' => '💬 Page d\'Accueil - Témoignages',
        'priority' => 27,
        'description' => 'Section des témoignages sur la page d\'accueil'
    ));
    
    // Titre témoignages avec éditeur Word-like
    isabel_add_word_editor(
        $wp_customize,
        'isabel_testimonials_title_word',
        '📝 Titre Témoignages',
        '<h2 style="font-size: 36px; font-weight: bold; color: #2d1b3d; text-align: center;">Ce que disent mes <span style="color: #c47dd9;">clients</span></h2>',
        'isabel_testimonials_section',
        array(
            'description' => 'Titre de la section témoignages',
            'editor_height' => '100px',
            'priority' => 10
        )
    );
    
    // Sous-titre témoignages avec éditeur Word-like
    isabel_add_word_editor(
        $wp_customize,
        'isabel_testimonials_subtitle_word',
        '📝 Sous-titre Témoignages',
        '<p style="font-size: 18px; color: #6b5b73; text-align: center; font-style: italic;">Découvrez les témoignages de personnes qui ont <strong>transformé leur vie</strong> grâce à un accompagnement personnalisé.</p>',
        'isabel_testimonials_section',
        array(
            'description' => 'Sous-titre de la section témoignages',
            'editor_height' => '120px',
            'priority' => 11
        )
    );
    
    // ===== SECTION CTA FINALE =====
    $wp_customize->add_section('isabel_cta_section', array(
        'title' => '🚀 Page d\'Accueil - Call-to-Action',
        'priority' => 28,
        'description' => 'Section finale d\'appel à l\'action'
    ));
    
    // Titre CTA avec éditeur Word-like
    isabel_add_word_editor(
        $wp_customize,
        'isabel_cta_title_word',
        '📝 Titre CTA',
        '<h2 style="font-size: 32px; font-weight: bold; color: #ffffff; text-align: center;">Prêt(e) à <span style="color: #ffff00;">Commencer</span> Votre Transformation ?</h2>',
        'isabel_cta_section',
        array(
            'description' => 'Titre de l\'appel à l\'action final',
            'editor_height' => '100px',
            'priority' => 10
        )
    );
    
    // Texte CTA avec éditeur Word-like
    isabel_add_word_editor(
        $wp_customize,
        'isabel_cta_text_word',
        '📝 Texte CTA',
        '<p style="font-size: 18px; color: #ffffff; text-align: center; line-height: 1.6;"><strong>Contactez-moi dès maintenant</strong> pour discuter de vos objectifs et découvrir comment je peux vous accompagner dans votre <em>transformation</em>.</p>',
        'isabel_cta_section',
        array(
            'description' => 'Texte de l\'appel à l\'action final',
            'editor_height' => '120px',
            'priority' => 11
        )
    );
    
    // Texte bouton CTA avec éditeur Word-like
    isabel_add_word_editor(
        $wp_customize,
        'isabel_cta_button_word',
        '📝 Bouton CTA',
        '<span style="font-weight: bold;">Prendre rendez-vous</span>',
        'isabel_cta_section',
        array(
            'description' => 'Texte du bouton final',
            'editor_height' => '80px',
            'priority' => 12
        )
    );

    // ===== PARAMÈTRES FALLBACK (versions simples) =====
    
    // Nom principal simple (fallback)
    $wp_customize->add_setting('isabel_main_name', array(
        'default' => 'Isabel GONCALVES',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('isabel_main_name', array(
        'label' => 'Nom Principal (version simple)',
        'description' => 'Version simple sans formatage',
        'section' => 'isabel_hero_section',
        'type' => 'text',
        'priority' => 50,
    ));
    
    // Sous-titre simple (fallback)
    $wp_customize->add_setting('isabel_subtitle', array(
        'default' => 'Coach Certifiée & Hypnocoach',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('isabel_subtitle', array(
        'label' => 'Sous-titre (version simple)',
        'description' => 'Version simple sans formatage',
        'section' => 'isabel_hero_section',
        'type' => 'text',
        'priority' => 51,
    ));
    
    // Texte d'introduction simple (fallback)
    $wp_customize->add_setting('isabel_intro_text', array(
        'default' => 'Bienvenue dans votre espace de transformation personnelle ! Je vous accompagne avec bienveillance vers l\'épanouissement de votre potentiel.',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    $wp_customize->add_control('isabel_intro_text', array(
        'label' => 'Texte d\'Introduction (version simple)',
        'description' => 'Version simple sans formatage',
        'section' => 'isabel_hero_section',
        'type' => 'textarea',
        'priority' => 52,
    ));
    
    // Services individuels (fallback)
    for ($i = 1; $i <= 4; $i++) {
        $service_defaults = array(
            1 => array('title' => 'Coaching Personnel', 'desc' => 'Révélez votre potentiel et transformez votre vie', 'icon' => '🎯'),
            2 => array('title' => 'Accompagnement VAE', 'desc' => 'Valorisez votre expérience professionnelle', 'icon' => '🎓'),
            3 => array('title' => 'Hypnocoaching', 'desc' => 'Libérez-vous de vos blocages en profondeur', 'icon' => '🧘'),
            4 => array('title' => 'Consultation Découverte', 'desc' => 'Première rencontre pour définir vos besoins', 'icon' => '💡')
        );
        
        // Titre service simple
        $wp_customize->add_setting("isabel_service{$i}_title", array(
            'default' => $service_defaults[$i]['title'],
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control("isabel_service{$i}_title", array(
            'label' => "Service {$i} - Titre (simple)",
            'section' => 'isabel_services_section',
            'type' => 'text',
            'priority' => 60 + $i,
        ));
        
        // Description service simple
        $wp_customize->add_setting("isabel_service{$i}_desc", array(
            'default' => $service_defaults[$i]['desc'],
            'sanitize_callback' => 'sanitize_textarea_field',
        ));
        $wp_customize->add_control("isabel_service{$i}_desc", array(
            'label' => "Service {$i} - Description (simple)",
            'section' => 'isabel_services_section',
            'type' => 'textarea',
            'priority' => 70 + $i,
        ));
        
        // Icône service
        $wp_customize->add_setting("isabel_service{$i}_icon", array(
            'default' => $service_defaults[$i]['icon'],
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control("isabel_service{$i}_icon", array(
            'label' => "Service {$i} - Icône",
            'description' => 'Emoji ou symbole (ex: 🎯)',
            'section' => 'isabel_services_section',
            'type' => 'text',
            'priority' => 80 + $i,
        ));
    }
    
    // ===== PARAMÈTRES AVANCÉS DE LA PAGE D'ACCUEIL =====
    
    // Style de la section hero
    $wp_customize->add_setting('isabel_hero_style', array(
        'default' => 'floating',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('isabel_hero_style', array(
        'label' => 'Style Section Hero',
        'section' => 'isabel_hero_section',
        'type' => 'select',
        'choices' => array(
            'floating' => 'Flottant (Recommandé)',
            'classic' => 'Classique',
            'minimal' => 'Minimal',
            'fullscreen' => 'Plein écran',
        ),
        'priority' => 100,
    ));
    
    // Disposition sur mobile
    $wp_customize->add_setting('isabel_mobile_layout', array(
        'default' => 'image_first',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('isabel_mobile_layout', array(
        'label' => 'Disposition Mobile',
        'section' => 'isabel_hero_section',
        'type' => 'select',
        'choices' => array(
            'image_first' => 'Image en haut, texte en bas',
            'text_first' => 'Texte en haut, image en bas',
            'image_only' => 'Image uniquement',
            'text_only' => 'Texte uniquement',
        ),
        'priority' => 101,
    ));
    
    // Effet parallax
    $wp_customize->add_setting('isabel_parallax_effect', array(
        'default' => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('isabel_parallax_effect', array(
        'label' => 'Effet Parallax',
        'description' => 'Effet de profondeur lors du scroll',
        'section' => 'isabel_hero_section',
        'type' => 'checkbox',
        'priority' => 102,
    ));
    
    // Masquer sections
    $wp_customize->add_setting('isabel_hide_services', array(
        'default' => false,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('isabel_hide_services', array(
        'label' => 'Masquer Section Services',
        'section' => 'isabel_services_section',
        'type' => 'checkbox',
        'priority' => 100,
    ));
    
    $wp_customize->add_setting('isabel_hide_testimonials', array(
        'default' => false,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('isabel_hide_testimonials', array(
        'label' => 'Masquer Section Témoignages',
        'section' => 'isabel_testimonials_section',
        'type' => 'checkbox',
        'priority' => 100,
    ));
}

/**
 * Fonctions d'affichage pour la page d'accueil
 */

// Fonction pour afficher le contenu hero complet
function isabel_display_hero_content() {
    echo '<div class="hero-content-wrapper">';
    
    // Section image mobile
    echo '<div class="mobile-profile-section">';
    $mobile_image = isabel_get_option('isabel_mobile_profile_image', '');
    if (!empty($mobile_image)) {
        echo '<div class="mobile-profile-container-simple">';
        echo '<img src="' . esc_url($mobile_image) . '" alt="Photo d\'Isabel GONCALVES" class="mobile-profile-image" />';
        echo '</div>';
    }
    echo '</div>';
    
    // Contenu texte
    echo '<div class="intro-card">';
    
    // Badge
    echo '<div class="hero-badge">';
    $badge_word = isabel_get_word_editor_content('isabel_hero_badge_word', '');
    if (!empty($badge_word)) {
        echo $badge_word;
    } else {
        echo '<span>✨</span> Coach certifiée';
    }
    echo '</div>';
    
    // Nom principal
    echo '<div class="profile-info">';
    isabel_display_word_editor_content('isabel_main_name_word', '<h1 style="font-size: 48px; font-weight: bold; color: #2d1b3d;">Isabel GONCALVES</h1>');
    echo '</div>';
    
    // Sous-titre
    echo '<div class="profile-subtitle">';
    isabel_display_word_editor_content('isabel_subtitle_word', '<p style="font-size: 24px; color: #2d1b3d; font-style: italic;">Coach Certifiée &amp; Hypnocoach</p>');
    echo '</div>';
    
    // Texte d'introduction
    echo '<div class="intro-text">';
    isabel_display_word_editor_content('isabel_intro_text_word', '<p style="font-size: 18px; line-height: 1.7; color: #2d1b3d;">Bienvenue dans votre espace de transformation personnelle !</p>');
    echo '</div>';
    
    // Boutons CTA
    echo '<div class="hero-cta">';
    echo '<button class="cta-main" onclick="openPopup()">';
    
    $button_text_word = isabel_get_word_editor_content('isabel_main_button_text_word', '');
    if (!empty($button_text_word)) {
        echo $button_text_word;
    } else {
        echo '<span>🚀</span><span>Prendre rendez-vous</span>';
    }
    
    echo '</button>';
    echo '<button class="btn-secondary">En savoir plus</button>';
    echo '</div>';
    
    echo '</div>'; // Fermer intro-card
    
    // Image de profil principale (desktop)
    echo '<div class="hero-right">';
    echo '<div class="hero-profile-container-simple">';
    
    $profile_image = isabel_get_option('isabel_profile_image', '');
    if (!empty($profile_image)) {
        echo '<img src="' . esc_url($profile_image) . '" alt="Photo d\'Isabel GONCALVES" class="hero-profile-image" />';
    } else {
        // SVG placeholder
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
    
    echo '</div>'; // Fermer hero-profile-container-simple
    echo '</div>'; // Fermer hero-right
    
    echo '</div>'; // Fermer hero-content-wrapper
}

// Fonction pour afficher la section services
function isabel_display_services_section() {
    if (isabel_get_option('isabel_hide_services', false)) {
        return;
    }
    
    echo '<section class="services-section" id="services">';
    echo '<div class="section-container">';
    
    // Titre et sous-titre
    isabel_display_word_editor_content('isabel_services_title_word', '<h2 style="font-size: 36px; font-weight: bold; color: #2d1b3d; text-align: center;">Mes Accompagnements Sur Mesure</h2>');
    isabel_display_word_editor_content('isabel_services_subtitle_word', '<p style="font-size: 18px; color: #6b5b73; text-align: center; font-style: italic;">Quatre approches complémentaires pour révéler votre potentiel.</p>');
    
    // Grille des services
    echo '<div class="services-grid">';
    
    $service_urls = array(
        1 => home_url('/coaching-personnel'),
        2 => home_url('/accompagnement-vae'),
        3 => home_url('/hypnocoaching'),
        4 => home_url('/consultation-decouverte')
    );
    
    for ($i = 1; $i <= 4; $i++) {
        echo '<a href="' . esc_url($service_urls[$i]) . '" class="service-card service-link">';
        echo '<div class="service-icon">' . sprintf('%02d', $i) . '</div>';
        
        // Titre du service
        echo '<div class="service-title-container">';
        isabel_display_word_editor_content("isabel_service{$i}_title_word", '<h3>' . isabel_get_option("isabel_service{$i}_title", "Service {$i}") . '</h3>');
        echo '</div>';
        
        // Description du service
        echo '<div class="service-description-container">';
        isabel_display_word_editor_content("isabel_service{$i}_desc_word", '<p>' . isabel_get_option("isabel_service{$i}_desc", "Description du service {$i}") . '</p>');
        echo '</div>';
        
        echo '<div class="service-arrow">→</div>';
        echo '</a>';
    }
    
    echo '</div>'; // Fermer services-grid
    echo '</div>'; // Fermer section-container
    echo '</section>';
}

// Fonction pour afficher la section témoignages
function isabel_display_testimonials_section() {
    if (isabel_get_option('isabel_hide_testimonials', false)) {
        return;
    }
    
    echo '<section class="testimonials-section" id="temoignages">';
    echo '<div class="section-container">';
    
    // Titre et sous-titre
    isabel_display_word_editor_content('isabel_testimonials_title_word', '<h2 style="font-size: 36px; font-weight: bold; color: #2d1b3d; text-align: center;">Ce que disent mes clients</h2>');
    isabel_display_word_editor_content('isabel_testimonials_subtitle_word', '<p style="font-size: 18px; color: #6b5b73; text-align: center; font-style: italic;">Découvrez les témoignages de transformation.</p>');
    
    // Grille des témoignages
    echo '<div class="testimonials-grid">';
    
    // Récupérer les témoignages du CPT
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
            
            echo '<div class="testimonial-card">';
            echo '<div class="testimonial-content">';
            echo esc_html(get_the_content(null, false, $testimonial));
            echo '</div>';
            echo '<div class="testimonial-author">';
            echo '<div class="author-avatar">' . esc_html($author_initials) . '</div>';
            echo '<div class="author-info">';
            echo '<div class="author-name">' . esc_html($author_name) . '</div>';
            echo '<div class="author-title">' . esc_html($author_title) . '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        // Témoignages par défaut si aucun n'est créé
        $default_testimonials = array(
            array('content' => 'Grâce à Isabel, j\'ai enfin trouvé ma voie professionnelle. Son approche bienveillante m\'a permis de reprendre confiance en moi.', 'name' => 'Marie L.', 'title' => 'Manager', 'initials' => 'ML'),
            array('content' => 'L\'accompagnement VAE avec Isabel a été un véritable succès. Je recommande vivement ses services.', 'name' => 'Thomas R.', 'title' => 'Technicien Certifié', 'initials' => 'TR'),
            array('content' => 'Les séances d\'hypnocoaching m\'ont aidée à surmonter mes angoisses et à retrouver un équilibre.', 'name' => 'Léa M.', 'title' => 'Entrepreneur', 'initials' => 'LM')
        );
        
        foreach ($default_testimonials as $testimonial) {
            echo '<div class="testimonial-card">';
            echo '<div class="testimonial-content">';
            echo '"' . esc_html($testimonial['content']) . '"';
            echo '</div>';
            echo '<div class="testimonial-author">';
            echo '<div class="author-avatar">' . esc_html($testimonial['initials']) . '</div>';
            echo '<div class="author-info">';
            echo '<div class="author-name">' . esc_html($testimonial['name']) . '</div>';
            echo '<div class="author-title">' . esc_html($testimonial['title']) . '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
    }
    
    echo '</div>'; // Fermer testimonials-grid
    echo '</div>'; // Fermer section-container
    echo '</section>';
}

// Fonction pour afficher la section CTA finale
function isabel_display_cta_section() {
    echo '<section class="cta-section" id="contact">';
    echo '<div class="section-container">';
    echo '<div class="cta-box">';
    
    // Titre CTA
    isabel_display_word_editor_content('isabel_cta_title_word', '<h2 style="font-size: 32px; font-weight: bold; color: #ffffff; text-align: center;">Prêt(e) à Commencer ?</h2>');
    
    // Texte CTA
    isabel_display_word_editor_content('isabel_cta_text_word', '<p style="font-size: 18px; color: #ffffff; text-align: center;">Contactez-moi pour discuter de vos objectifs.</p>');
    
    // Bouton CTA
    echo '<button class="cta-button" onclick="openPopup()">';
    
    $cta_button_word = isabel_get_word_editor_content('isabel_cta_button_word', '');
    if (!empty($cta_button_word)) {
        echo $cta_button_word;
    } else {
        echo 'Prendre rendez-vous';
    }
    
    echo '</button>';
    echo '</div>'; // Fermer cta-box
    echo '</div>'; // Fermer section-container
    echo '</section>';
}

/**
 * CSS dynamique pour la page d'accueil
 */
function isabel_home_dynamic_css() {
    $hero_style = isabel_get_option('isabel_hero_style', 'floating');
    $mobile_layout = isabel_get_option('isabel_mobile_layout', 'image_first');
    $parallax_effect = isabel_get_option('isabel_parallax_effect', true);
    $hero_bg_image = isabel_get_option('isabel_hero_background_image', '');
    
    ?>
    <style type="text/css" id="isabel-home-styles">
    /* Hero style */
    <?php if ($hero_style === 'fullscreen'): ?>
    .hero-floating {
        min-height: 100vh;
    }
    <?php elseif ($hero_style === 'minimal'): ?>
    .hero-floating {
        min-height: 60vh;
        background: white !important;
    }
    .hero-floating::before,
    .hero-floating::after {
        display: none;
    }
    <?php elseif ($hero_style === 'classic'): ?>
    .hero-floating {
        min-height: 80vh;
        border-radius: 0;
    }
    <?php endif; ?>
    
    /* Image de fond hero */
    <?php if (!empty($hero_bg_image)): ?>
    .hero-floating {
        --hero-bg-image: url(<?php echo esc_url($hero_bg_image); ?>);
    }
    .hero-floating::before {
        background-image: var(--hero-bg-image);
    }
    <?php endif; ?>
    
    /* Layout mobile */
    @media (max-width: 767px) {
        <?php if ($mobile_layout === 'text_first'): ?>
        .hero-content-wrapper {
            flex-direction: column-reverse;
        }
        .mobile-profile-section {
            order: 2;
        }
        .intro-card {
            order: 1;
        }
        <?php elseif ($mobile_layout === 'image_only'): ?>
        .intro-card {
            display: none;
        }
        <?php elseif ($mobile_layout === 'text_only'): ?>
        .mobile-profile-section {
            display: none;
        }
        <?php endif; ?>
    }
    
    /* Parallax effect */
    <?php if (!$parallax_effect): ?>
    .hero-right svg {
        transform: none !important;
    }
    <?php endif; ?>
    </style>
    <?php
}
add_action('wp_head', 'isabel_home_dynamic_css');

/**
 * Fonction pour obtenir le contenu complet de la page d'accueil
 */
function isabel_get_home_page_content() {
    ob_start();
    
    // Hero section
    echo '<section class="hero-floating" id="accueil">';
    isabel_display_hero_content();
    echo '</section>';
    
    // Section Qualiopi
    isabel_display_qualiopi_section('home');
    
    // Section Services
    isabel_display_services_section();
    
    // Section Témoignages
    isabel_display_testimonials_section();
    
    // Section CTA
    isabel_display_cta_section();
    
    return ob_get_clean();
}

?>