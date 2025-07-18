<?php
// Empêcher l'accès direct au fichier
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Customizer pour le FOOTER
 */

function isabel_register_footer_customizer($wp_customize) {
    
    // ===== SECTION FOOTER =====
    $wp_customize->add_section('isabel_footer_section', array(
        'title' => '📋 Footer du Site',
        'priority' => 44,
        'description' => 'Modifiez tous les textes du footer avec l\'éditeur Word'
    ));
    
    // Nom principal footer
    isabel_add_word_editor(
        $wp_customize,
        'isabel_footer_name_word',
        '📝 Nom Principal Footer',
        '<span style="font-weight: bold; color: #c47dd9;">Isabel GONCALVES</span>',
        'isabel_footer_section',
        array(
            'description' => 'Nom affiché dans le footer',
            'editor_height' => '80px'
        )
    );
    
    // Description footer
    isabel_add_word_editor(
        $wp_customize,
        'isabel_footer_description_word',
        '📝 Description Footer',
        '<p style="color: #6b5b73; line-height: 1.7;">Coach Certifiée &amp; Hypnocoach<br>Accompagnement personnalisé pour votre transformation</p>',
        'isabel_footer_section',
        array(
            'description' => 'Description ou slogan dans le footer',
            'editor_height' => '100px'
        )
    );
    
    // Titre section services footer
    isabel_add_word_editor(
        $wp_customize,
        'isabel_footer_services_title_word',
        '📝 Titre Services Footer',
        '<h3 style="color: #c47dd9; font-weight: bold;">Mes Services</h3>',
        'isabel_footer_section',
        array(
            'description' => 'Titre de la section services dans le footer',
            'editor_height' => '80px'
        )
    );
    
    // Titre section à propos footer
    isabel_add_word_editor(
        $wp_customize,
        'isabel_footer_about_title_word',
        '📝 Titre À Propos Footer',
        '<h3 style="color: #c47dd9; font-weight: bold;">À propos</h3>',
        'isabel_footer_section',
        array(
            'description' => 'Titre de la section à propos dans le footer',
            'editor_height' => '80px'
        )
    );
    
    // Texte à propos footer
    isabel_add_word_editor(
        $wp_customize,
        'isabel_footer_about_text_word',
        '📝 Texte À Propos Footer',
        '<p style="color: #6b5b73; line-height: 1.8;">Accompagnement professionnel pour votre développement personnel et professionnel.</p>',
        'isabel_footer_section',
        array(
            'description' => 'Texte de présentation dans le footer',
            'editor_height' => '120px'
        )
    );
    
    // Points clés footer
    $footer_points = array(
        1 => '✨ Coach certifiée',
        2 => '🎯 Approche personnalisée', 
        3 => '📞 Consultation sur rendez-vous'
    );
    
    foreach ($footer_points as $i => $default) {
        isabel_add_word_editor(
            $wp_customize,
            "isabel_footer_point{$i}_word",
            "📝 Point Clé Footer $i",
            '<span style="color: #c47dd9; font-weight: bold;">' . substr($default, 0, 2) . '</span> <span style="font-weight: 500; color: #6b5b73;">' . substr($default, 3) . '</span>',
            'isabel_footer_section',
            array(
                'description' => "Point clé $i du footer",
                'editor_height' => '80px'
            )
        );
    }
    
    // Call to action footer
    isabel_add_word_editor(
        $wp_customize,
        'isabel_footer_cta_word',
        '📝 Call-to-Action Footer',
        '<strong style="color: #2d1b3d;">Ensemble, réalisons vos objectifs</strong><br><span style="color: #6b5b73;">Contactez-moi pour commencer votre transformation</span>',
        'isabel_footer_section',
        array(
            'description' => 'Message d\'encouragement dans le footer',
            'editor_height' => '100px'
        )
    );
    
    // Copyright footer
    isabel_add_word_editor(
        $wp_customize,
        'isabel_footer_copyright_word',
        '📝 Copyright Footer',
        '<span style="color: #6b5b73;">© ' . date('Y') . ' Isabel GONCALVES - Coach Certifiée. Tous droits réservés.</span>',
        'isabel_footer_section',
        array(
            'description' => 'Mention de copyright dans le footer',
            'editor_height' => '80px'
        )
    );
    
    // Badge professionnel footer
    isabel_add_word_editor(
        $wp_customize,
        'isabel_footer_badge_word',
        '📝 Badge Professionnel Footer',
        '<span style="color: #c47dd9; font-weight: bold;">✨ Coach Professionnelle Certifiée ✨</span>',
        'isabel_footer_section',
        array(
            'description' => 'Badge professionnel dans le footer',
            'editor_height' => '80px'
        )
    );

    // ===== PARAMÈTRES FOOTER TRADITIONNELS (FALLBACK) =====
    
    // Email de contact
    $wp_customize->add_setting('isabel_email', array(
        'default' => 'contact@forma-coach.com',
        'sanitize_callback' => 'sanitize_email',
    ));
    $wp_customize->add_control('isabel_email', array(
        'label' => 'Email de contact',
        'description' => 'Adresse email affichée dans le footer',
        'section' => 'isabel_footer_section',
        'type' => 'email',
        'priority' => 50,
    ));
    
    // Téléphone de contact
    $wp_customize->add_setting('isabel_phone', array(
        'default' => '+33123456789',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('isabel_phone', array(
        'label' => 'Téléphone de contact',
        'description' => 'Numéro de téléphone affiché dans le footer',
        'section' => 'isabel_footer_section',
        'type' => 'tel',
        'priority' => 51,
    ));
    
    // Adresse
    $wp_customize->add_setting('isabel_address', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    $wp_customize->add_control('isabel_address', array(
        'label' => 'Adresse (optionnelle)',
        'description' => 'Adresse physique à afficher dans le footer',
        'section' => 'isabel_footer_section',
        'type' => 'textarea',
        'priority' => 52,
    ));
    
    // Réseaux sociaux
    $social_networks = array(
        'facebook' => 'Facebook',
        'instagram' => 'Instagram', 
        'linkedin' => 'LinkedIn',
        'twitter' => 'Twitter',
        'youtube' => 'YouTube'
    );
    
    foreach ($social_networks as $network => $label) {
        $wp_customize->add_setting("isabel_{$network}_url", array(
            'default' => '',
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control("isabel_{$network}_url", array(
            'label' => "URL $label",
            'description' => "Lien vers votre profil $label",
            'section' => 'isabel_footer_section',
            'type' => 'url',
            'priority' => 53 + array_search($network, array_keys($social_networks)),
        ));
    }
    
    // Affichage des réseaux sociaux
    $wp_customize->add_setting('isabel_show_social_links', array(
        'default' => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('isabel_show_social_links', array(
        'label' => 'Afficher les réseaux sociaux',
        'description' => 'Cocher pour afficher les liens vers vos réseaux sociaux',
        'section' => 'isabel_footer_section',
        'type' => 'checkbox',
        'priority' => 60,
    ));
}

/**
 * Fonctions d'affichage pour le footer
 */

// Fonction pour afficher le contenu principal du footer
function isabel_display_footer_content() {
    echo '<h3>';
    
    // Priorité à l'éditeur Word, fallback vers l'option simple
    $footer_name_word = isabel_get_word_editor_content('isabel_footer_name_word', '');
    if (!empty($footer_name_word)) {
        echo $footer_name_word;
    } else {
        echo esc_html(isabel_get_option('isabel_main_name', 'Isabel GONCALVES'));
    }
    
    echo '</h3>';
    
    $footer_description_word = isabel_get_word_editor_content('isabel_footer_description_word', '');
    if (!empty($footer_description_word)) {
        echo $footer_description_word;
    } else {
        echo '<p>Coach Certifiée & Hypnocoach</p>';
    }
}

// Fonction pour afficher les informations de contact du footer
function isabel_display_footer_contact() {
    $email = isabel_get_option('isabel_email', 'contact@forma-coach.com');
    $phone = isabel_get_option('isabel_phone', '+33123456789');
    $address = isabel_get_option('isabel_address', '');
    
    echo '<div style="display: flex; flex-direction: column; gap: 1rem;">';
    
    if (!empty($email)) {
        echo '<a href="mailto:' . esc_attr($email) . '" style="color: var(--rose-700); text-decoration: none; font-weight: 500; display: flex; align-items: center; gap: 0.75rem; transition: all 0.3s ease; padding: 0.5rem 0;">';
        echo '<span style="font-size: 1.1rem;">📧</span>';
        echo '<span>Email</span>';
        echo '</a>';
    }
    
    if (!empty($phone)) {
        echo '<a href="tel:' . esc_attr($phone) . '" style="color: var(--rose-700); text-decoration: none; font-weight: 500; display: flex; align-items: center; gap: 0.75rem; transition: all 0.3s ease; padding: 0.5rem 0;">';
        echo '<span style="font-size: 1.1rem;">📞</span>';
        echo '<span>Téléphone</span>';
        echo '</a>';
    }
    
    if (!empty($address)) {
        echo '<div style="color: var(--text-light); display: flex; align-items: flex-start; gap: 0.75rem; padding: 0.5rem 0;">';
        echo '<span style="font-size: 1.1rem;">📍</span>';
        echo '<span>' . nl2br(esc_html($address)) . '</span>';
        echo '</div>';
    }
    
    echo '</div>';
}

// Fonction pour afficher les réseaux sociaux
function isabel_display_footer_social() {
    if (!isabel_get_option('isabel_show_social_links', true)) {
        return;
    }
    
    $social_networks = array(
        'facebook' => array('name' => 'Facebook', 'icon' => '📘'),
        'instagram' => array('name' => 'Instagram', 'icon' => '📷'),
        'linkedin' => array('name' => 'LinkedIn', 'icon' => '💼'),
        'twitter' => array('name' => 'Twitter', 'icon' => '🐦'),
        'youtube' => array('name' => 'YouTube', 'icon' => '📺')
    );
    
    $has_social = false;
    foreach ($social_networks as $network => $data) {
        if (!empty(isabel_get_option("isabel_{$network}_url", ''))) {
            $has_social = true;
            break;
        }
    }
    
    if (!$has_social) {
        return;
    }
    
    echo '<div style="margin-top: 1.5rem;">';
    echo '<h4 style="color: var(--rose-700); margin-bottom: 1rem;">Suivez-moi</h4>';
    echo '<div style="display: flex; gap: 1rem; flex-wrap: wrap;">';
    
    foreach ($social_networks as $network => $data) {
        $url = isabel_get_option("isabel_{$network}_url", '');
        if (!empty($url)) {
            echo '<a href="' . esc_url($url) . '" target="_blank" rel="noopener noreferrer" style="color: var(--rose-700); text-decoration: none; display: flex; align-items: center; gap: 0.5rem; padding: 0.5rem; border-radius: 8px; transition: background 0.3s ease;">';
            echo '<span>' . $data['icon'] . '</span>';
            echo '<span>' . $data['name'] . '</span>';
            echo '</a>';
        }
    }
    
    echo '</div>';
    echo '</div>';
}

// Fonction pour afficher les points clés du footer
function isabel_display_footer_points() {
    for ($i = 1; $i <= 3; $i++) {
        $point_word = isabel_get_word_editor_content("isabel_footer_point{$i}_word", '');
        if (!empty($point_word)) {
            echo '<div style="display: flex; align-items: center; gap: 0.75rem; padding: 0.5rem 0;">';
            echo $point_word;
            echo '</div>';
        }
    }
}

// Fonction pour afficher le CTA du footer
function isabel_display_footer_cta() {
    $cta_word = isabel_get_word_editor_content('isabel_footer_cta_word', '');
    if (!empty($cta_word)) {
        echo '<div style="margin-top: 1.5rem; padding: 1.5rem; background: linear-gradient(135deg, var(--pastel-lavender), var(--pastel-pink)); border-radius: 12px; font-size: 0.95rem; text-align: center;">';
        echo $cta_word;
        echo '</div>';
    }
}

// Fonction pour afficher le copyright
function isabel_display_footer_copyright() {
    $copyright_word = isabel_get_word_editor_content('isabel_footer_copyright_word', '');
    if (!empty($copyright_word)) {
        echo $copyright_word;
    } else {
        echo '<span style="color: #6b5b73;">© ' . date('Y') . ' ' . isabel_get_option('isabel_main_name', 'Isabel GONCALVES') . ' - Coach Certifiée. Tous droits réservés.</span>';
    }
}

// Fonction pour afficher le badge professionnel
function isabel_display_footer_badge() {
    $badge_word = isabel_get_word_editor_content('isabel_footer_badge_word', '');
    if (!empty($badge_word)) {
        echo '<div style="display: inline-flex; align-items: center; gap: 0.75rem; padding: 1rem 2rem; background: var(--white); border-radius: 50px; border: 2px solid var(--rose-300); box-shadow: var(--shadow-soft);">';
        echo $badge_word;
        echo '</div>';
    }
}

?>