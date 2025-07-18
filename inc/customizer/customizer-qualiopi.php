<?php
// Empêcher l'accès direct au fichier
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Customizer pour la SECTION QUALIOPI
 */

function isabel_register_qualiopi_customizer($wp_customize) {
    
    // ===== SECTION QUALIOPI =====
    $wp_customize->add_section('isabel_qualiopi_section', array(
        'title' => '🏅 Certification Qualiopi',
        'priority' => 36,
        'description' => 'Personnalisez votre section certification Qualiopi'
    ));
    
    // Activation Qualiopi
    $wp_customize->add_setting('isabel_qualiopi_enable', array(
        'default' => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('isabel_qualiopi_enable', array(
        'label' => 'Afficher la section Qualiopi',
        'description' => 'Cocher pour afficher la certification Qualiopi sur le site',
        'section' => 'isabel_qualiopi_section',
        'type' => 'checkbox',
        'priority' => 5,
    ));
    
    // Logo Qualiopi
    $wp_customize->add_setting('isabel_qualiopi_logo', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'isabel_qualiopi_logo', array(
        'label' => 'Logo Qualiopi',
        'description' => 'Téléchargez votre logo de certification Qualiopi',
        'section' => 'isabel_qualiopi_section',
        'priority' => 10,
    )));
    
    // Titre Qualiopi avec éditeur Word-like
    isabel_add_word_editor(
        $wp_customize,
        'isabel_qualiopi_title_word',
        '📝 Titre Certification Qualiopi',
        '<h3 style="font-size: 20px; font-weight: bold; color: #1e40af;">Organisme de formation certifié Qualiopi</h3>',
        'isabel_qualiopi_section',
        array(
            'description' => 'Titre de votre certification Qualiopi',
            'editor_height' => '80px',
            'priority' => 20
        )
    );
    
    // Description Qualiopi avec éditeur Word-like
    isabel_add_word_editor(
        $wp_customize,
        'isabel_qualiopi_description_word',
        '📝 Description Certification',
        '<p style="color: #475569; font-style: italic;">La certification qualité a été délivrée au titre de la catégorie d\'actions suivante : <strong>actions de formation</strong></p>',
        'isabel_qualiopi_section',
        array(
            'description' => 'Description de votre certification Qualiopi',
            'editor_height' => '100px',
            'priority' => 30
        )
    );
    
    // Numéro Qualiopi avec éditeur Word-like
    isabel_add_word_editor(
        $wp_customize,
        'isabel_qualiopi_number_word',
        '📝 Numéro Certification',
        '<p style="color: #1e40af; font-weight: bold;">N° de certification : <span style="font-family: monospace;">12345-QUALIOPI</span></p>',
        'isabel_qualiopi_section',
        array(
            'description' => 'Numéro de votre certification Qualiopi',
            'editor_height' => '80px',
            'priority' => 40
        )
    );
    
    // Date de certification avec éditeur Word-like
    isabel_add_word_editor(
        $wp_customize,
        'isabel_qualiopi_date_word',
        '📝 Date de Certification',
        '<p style="color: #64748b; font-size: 0.9rem;">Certification obtenue le <strong>' . date('d/m/Y') . '</strong></p>',
        'isabel_qualiopi_section',
        array(
            'description' => 'Date d\'obtention de la certification',
            'editor_height' => '80px',
            'priority' => 45
        )
    );

    // ===== PARAMÈTRES QUALIOPI TRADITIONNELS (FALLBACK) =====
    
    // Titre simple (fallback)
    $wp_customize->add_setting('isabel_qualiopi_title', array(
        'default' => 'Organisme de formation certifié Qualiopi',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('isabel_qualiopi_title', array(
        'label' => 'Titre (version simple)',
        'description' => 'Version simple sans formatage',
        'section' => 'isabel_qualiopi_section',
        'type' => 'text',
        'priority' => 50,
    ));
    
    // Description simple (fallback)
    $wp_customize->add_setting('isabel_qualiopi_description', array(
        'default' => 'La certification qualité a été délivrée au titre de la catégorie d\'actions suivante : actions de formation',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    $wp_customize->add_control('isabel_qualiopi_description', array(
        'label' => 'Description (version simple)',
        'description' => 'Version simple sans formatage',
        'section' => 'isabel_qualiopi_section',
        'type' => 'textarea',
        'priority' => 51,
    ));
    
    // Numéro simple (fallback)
    $wp_customize->add_setting('isabel_qualiopi_number', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('isabel_qualiopi_number', array(
        'label' => 'Numéro de certification (version simple)',
        'description' => 'Votre numéro de certification Qualiopi',
        'section' => 'isabel_qualiopi_section',
        'type' => 'text',
        'priority' => 52,
    ));
    
    // Date simple (fallback)
    $wp_customize->add_setting('isabel_qualiopi_date', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('isabel_qualiopi_date', array(
        'label' => 'Date de certification (version simple)',
        'description' => 'Date d\'obtention de votre certification',
        'section' => 'isabel_qualiopi_section',
        'type' => 'date',
        'priority' => 53,
    ));
    
    // Style de la section Qualiopi
    $wp_customize->add_setting('isabel_qualiopi_style', array(
        'default' => 'standard',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('isabel_qualiopi_style', array(
        'label' => 'Style de la section Qualiopi',
        'section' => 'isabel_qualiopi_section',
        'type' => 'select',
        'choices' => array(
            'standard' => 'Style standard',
            'compact' => 'Style compact',
            'premium' => 'Style premium',
            'minimal' => 'Style minimal'
        ),
        'priority' => 54,
    ));
    
    // Position de la section Qualiopi
    $wp_customize->add_setting('isabel_qualiopi_position', array(
        'default' => 'after_hero',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('isabel_qualiopi_position', array(
        'label' => 'Position de la section Qualiopi',
        'section' => 'isabel_qualiopi_section',
        'type' => 'select',
        'choices' => array(
            'after_hero' => 'Après la section hero',
            'before_services' => 'Avant les services',
            'after_services' => 'Après les services',
            'before_footer' => 'Avant le footer'
        ),
        'priority' => 55,
    ));
    
    // Couleur de fond de la section Qualiopi
    $wp_customize->add_setting('isabel_qualiopi_bg_color', array(
        'default' => '#f8fafc',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'isabel_qualiopi_bg_color', array(
        'label' => 'Couleur de fond de la section',
        'section' => 'isabel_qualiopi_section',
        'priority' => 56,
    )));
}

/**
 * Fonctions d'affichage pour la section Qualiopi
 */

// Fonction principale pour afficher la section Qualiopi
function isabel_display_qualiopi_section($context = 'page') {
    
    // Vérifier si la section est activée
    if (!isabel_get_option('isabel_qualiopi_enable', true)) {
        return;
    }
    
    // Récupérer les options depuis le customizer
    $logo = isabel_get_option('isabel_qualiopi_logo', '');
    $style = isabel_get_option('isabel_qualiopi_style', 'standard');
    $bg_color = isabel_get_option('isabel_qualiopi_bg_color', '#f8fafc');
    
    // Définir les classes CSS selon le contexte et le style
    $section_class = $context === 'home' ? 'qualiopi-home-section' : '';
    $container_class = $context === 'home' ? 'qualiopi-home-certification' : 'qualiopi-certification';
    $content_class = $context === 'home' ? 'qualiopi-home-content' : 'qualiopi-content';
    $logo_class = $context === 'home' ? 'qualiopi-home-logo' : 'qualiopi-logo';
    $text_class = $context === 'home' ? 'qualiopi-home-text' : 'qualiopi-text';
    
    // Ajouter des classes pour les styles
    $style_classes = ' qualiopi-' . $style;
    
    // Conteneur selon le contexte
    if ($context === 'home') {
        echo '<section class="' . esc_attr($section_class . $style_classes) . '" style="background-color: ' . esc_attr($bg_color) . ';">';
        echo '<div class="section-container">';
    }
    
    echo '<div class="' . esc_attr($container_class . $style_classes) . '">';
    echo '<div class="' . esc_attr($content_class) . '">';
    
    // Logo Qualiopi
    if (!empty($logo)) {
        echo '<div class="' . esc_attr($logo_class) . '">';
        echo '<img src="' . esc_url($logo) . '" alt="Certification Qualiopi" />';
        echo '</div>';
    }
    
    // Contenu texte
    echo '<div class="' . esc_attr($text_class) . '">';
    
    // Titre depuis l'éditeur Word ou fallback
    $title_word = isabel_get_word_editor_content('isabel_qualiopi_title_word', '');
    if (!empty($title_word)) {
        echo $title_word;
    } else {
        echo '<h3>' . esc_html(isabel_get_option('isabel_qualiopi_title', 'Organisme de formation certifié Qualiopi')) . '</h3>';
    }
    
    // Description depuis l'éditeur Word ou fallback
    $description_word = isabel_get_word_editor_content('isabel_qualiopi_description_word', '');
    if (!empty($description_word)) {
        echo $description_word;
    } else {
        echo '<p>' . esc_html(isabel_get_option('isabel_qualiopi_description', 'La certification qualité a été délivrée au titre de la catégorie d\'actions suivante : actions de formation')) . '</p>';
    }
    
    // Numéro depuis l'éditeur Word ou fallback
    $number_word = isabel_get_word_editor_content('isabel_qualiopi_number_word', '');
    $number_simple = isabel_get_option('isabel_qualiopi_number', '');
    if (!empty($number_word)) {
        echo $number_word;
    } elseif (!empty($number_simple)) {
        echo '<p class="qualiopi-number">';
        echo '<strong>N° de certification :</strong> ' . esc_html($number_simple);
        echo '</p>';
    }
    
    // Date depuis l'éditeur Word ou fallback
    $date_word = isabel_get_word_editor_content('isabel_qualiopi_date_word', '');
    $date_simple = isabel_get_option('isabel_qualiopi_date', '');
    if (!empty($date_word)) {
        echo $date_word;
    } elseif (!empty($date_simple)) {
        echo '<p class="qualiopi-date">';
        echo 'Certification obtenue le ' . esc_html(date('d/m/Y', strtotime($date_simple)));
        echo '</p>';
    }
    
    echo '</div>'; // Fermer text_class
    echo '</div>'; // Fermer content_class
    echo '</div>'; // Fermer container_class
    
    // Fermer le conteneur pour la page d'accueil
    if ($context === 'home') {
        echo '</div>';
        echo '</section>';
    }
}

// Fonction pour afficher uniquement le logo Qualiopi
function isabel_display_qualiopi_logo_only() {
    if (!isabel_get_option('isabel_qualiopi_enable', true)) {
        return;
    }
    
    $logo = isabel_get_option('isabel_qualiopi_logo', '');
    if (!empty($logo)) {
        echo '<div class="qualiopi-logo-simple">';
        echo '<img src="' . esc_url($logo) . '" alt="Certification Qualiopi" style="height: 60px; width: auto;" />';
        echo '</div>';
    }
}

// Fonction pour afficher le titre Qualiopi seul
function isabel_display_qualiopi_title_only() {
    if (!isabel_get_option('isabel_qualiopi_enable', true)) {
        return;
    }
    
    $title_word = isabel_get_word_editor_content('isabel_qualiopi_title_word', '');
    if (!empty($title_word)) {
        echo $title_word;
    } else {
        echo esc_html(isabel_get_option('isabel_qualiopi_title', 'Organisme de formation certifié Qualiopi'));
    }
}

// Fonction pour vérifier si Qualiopi est activé
function isabel_is_qualiopi_enabled() {
    return isabel_get_option('isabel_qualiopi_enable', true);
}

// CSS dynamique pour Qualiopi selon les paramètres du customizer
function isabel_qualiopi_dynamic_css() {
    if (!isabel_is_qualiopi_enabled()) {
        return;
    }
    
    $bg_color = isabel_get_option('isabel_qualiopi_bg_color', '#f8fafc');
    $style = isabel_get_option('isabel_qualiopi_style', 'standard');
    
    ?>
    <style type="text/css">
    .qualiopi-certification,
    .qualiopi-home-certification {
        background-color: <?php echo esc_attr($bg_color); ?> !important;
    }
    
    <?php if ($style === 'premium'): ?>
    .qualiopi-premium {
        border: 2px solid #3b82f6 !important;
        box-shadow: 0 8px 25px rgba(59, 130, 246, 0.15) !important;
    }
    .qualiopi-premium::before {
        background: linear-gradient(90deg, #1e40af, #3b82f6, #60a5fa);
    }
    <?php endif; ?>
    
    <?php if ($style === 'compact'): ?>
    .qualiopi-compact {
        padding: 1.5rem !important;
        margin: 1.5rem 0 2rem 0 !important;
    }
    .qualiopi-compact .qualiopi-logo img,
    .qualiopi-compact .qualiopi-home-logo img {
        height: 60px !important;
    }
    .qualiopi-compact h3 {
        font-size: 1.1rem !important;
    }
    .qualiopi-compact p {
        font-size: 0.9rem !important;
    }
    <?php endif; ?>
    
    <?php if ($style === 'minimal'): ?>
    .qualiopi-minimal {
        background: transparent !important;
        border: 1px solid rgba(59, 130, 246, 0.2) !important;
        padding: 1rem !important;
    }
    .qualiopi-minimal .qualiopi-content,
    .qualiopi-minimal .qualiopi-home-content {
        gap: 1rem !important;
    }
    .qualiopi-minimal .qualiopi-logo img,
    .qualiopi-minimal .qualiopi-home-logo img {
        height: 50px !important;
    }
    <?php endif; ?>
    </style>
    <?php
}
add_action('wp_head', 'isabel_qualiopi_dynamic_css');

?>