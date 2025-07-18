<?php
// Empêcher l'accès direct au fichier
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Customizer GLOBAL - Paramètres généraux du thème
 * Typographie, couleurs, images globales, etc.
 */

function isabel_register_global_customizer($wp_customize) {
    
    // ===== SECTION PARAMÈTRES GLOBAUX =====
    $wp_customize->add_section('isabel_global_section', array(
        'title' => '🌐 Paramètres Globaux',
        'priority' => 10,
        'description' => 'Paramètres généraux du thème : couleurs, typographie, images'
    ));
    
    // ===== COULEURS GLOBALES =====
    
    // Couleur primaire
    $wp_customize->add_setting('isabel_primary_color', array(
        'default' => '#e4a7f5',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'isabel_primary_color', array(
        'label' => 'Couleur Primaire (Rose 500)',
        'description' => 'Couleur principale utilisée pour les boutons, liens, etc.',
        'section' => 'isabel_global_section',
        'priority' => 10,
    )));
    
    // Couleur secondaire
    $wp_customize->add_setting('isabel_secondary_color', array(
        'default' => '#c47dd9',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'isabel_secondary_color', array(
        'label' => 'Couleur Secondaire (Rose 700)',
        'description' => 'Couleur secondaire pour les éléments accentués',
        'section' => 'isabel_global_section',
        'priority' => 11,
    )));
    
    // Couleur de texte principal
    $wp_customize->add_setting('isabel_text_color', array(
        'default' => '#2d1b3d',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'isabel_text_color', array(
        'label' => 'Couleur Texte Principal',
        'description' => 'Couleur pour les titres et textes importants',
        'section' => 'isabel_global_section',
        'priority' => 12,
    )));
    
    // Couleur de texte secondaire
    $wp_customize->add_setting('isabel_text_light_color', array(
        'default' => '#6b5b73',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'isabel_text_light_color', array(
        'label' => 'Couleur Texte Secondaire',
        'description' => 'Couleur pour les textes de description',
        'section' => 'isabel_global_section',
        'priority' => 13,
    )));
    
    // ===== TYPOGRAPHIE =====
    
    // Police principale
    $wp_customize->add_setting('isabel_main_font_family', array(
        'default' => '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control('isabel_main_font_family', array(
        'label' => 'Police Principale',
        'description' => 'Police utilisée pour tout le site',
        'section' => 'isabel_global_section',
        'type' => 'select',
        'choices' => array(
            '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif' => 'Système (Recommandé)',
            '"Helvetica Neue", Helvetica, Arial, sans-serif' => 'Helvetica',
            'Georgia, "Times New Roman", serif' => 'Georgia',
            '"Montserrat", sans-serif' => 'Montserrat (Google Fonts)',
            '"Open Sans", sans-serif' => 'Open Sans (Google Fonts)',
            '"Poppins", sans-serif' => 'Poppins (Google Fonts)',
        ),
        'priority' => 20,
    ));
    
    // Taille de police de base
    $wp_customize->add_setting('isabel_base_font_size', array(
        'default' => 16,
        'sanitize_callback' => 'absint',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control('isabel_base_font_size', array(
        'label' => 'Taille Police de Base',
        'description' => 'Taille en pixels (16px recommandé)',
        'section' => 'isabel_global_section',
        'type' => 'range',
        'input_attrs' => array(
            'min' => 12,
            'max' => 20,
            'step' => 1,
        ),
        'priority' => 21,
    ));
    
    // ===== IMAGES GLOBALES =====
    
    // Logo/Favicon
    $wp_customize->add_setting('isabel_site_logo', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'isabel_site_logo', array(
        'label' => 'Logo du Site',
        'description' => 'Logo affiché dans l\'en-tête (optionnel)',
        'section' => 'isabel_global_section',
        'priority' => 30,
    )));
    
    // Image de fond globale
    $wp_customize->add_setting('isabel_global_background_image', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'isabel_global_background_image', array(
        'label' => 'Image de Fond Globale',
        'description' => 'Image de fond utilisée sur tout le site (optionnelle)',
        'section' => 'isabel_global_section',
        'priority' => 31,
    )));
    
    // ===== PARAMÈTRES AVANCÉS =====
    
    // Mode sombre
    $wp_customize->add_setting('isabel_dark_mode', array(
        'default' => false,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('isabel_dark_mode', array(
        'label' => 'Mode Sombre',
        'description' => 'Activer le thème sombre (expérimental)',
        'section' => 'isabel_global_section',
        'type' => 'checkbox',
        'priority' => 40,
    ));
    
    // Animation réduite
    $wp_customize->add_setting('isabel_reduced_animations', array(
        'default' => false,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('isabel_reduced_animations', array(
        'label' => 'Réduire les Animations',
        'description' => 'Désactiver les animations pour l\'accessibilité',
        'section' => 'isabel_global_section',
        'type' => 'checkbox',
        'priority' => 41,
    ));
    
    // Affichage de la libellule
    $wp_customize->add_setting('isabel_show_dragonfly', array(
        'default' => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('isabel_show_dragonfly', array(
        'label' => 'Afficher la Libellule Animée',
        'description' => 'Animation décorative de libellule sur la page d\'accueil',
        'section' => 'isabel_global_section',
        'type' => 'checkbox',
        'priority' => 42,
    ));
    
    // ===== GOOGLE FONTS =====
    
    // Activation Google Fonts
    $wp_customize->add_setting('isabel_enable_google_fonts', array(
        'default' => false,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('isabel_enable_google_fonts', array(
        'label' => 'Activer Google Fonts',
        'description' => 'Charger les polices Google Fonts (impact sur la vitesse)',
        'section' => 'isabel_global_section',
        'type' => 'checkbox',
        'priority' => 50,
    ));
    
    // ===== PERFORMANCE =====
    
    // Lazy loading
    $wp_customize->add_setting('isabel_lazy_loading', array(
        'default' => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('isabel_lazy_loading', array(
        'label' => 'Lazy Loading Images',
        'description' => 'Chargement différé des images pour améliorer la vitesse',
        'section' => 'isabel_global_section',
        'type' => 'checkbox',
        'priority' => 51,
    ));
    
    // Minification CSS
    $wp_customize->add_setting('isabel_minify_css', array(
        'default' => false,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('isabel_minify_css', array(
        'label' => 'Minifier le CSS',
        'description' => 'Compresser le CSS pour améliorer la vitesse (expérimental)',
        'section' => 'isabel_global_section',
        'type' => 'checkbox',
        'priority' => 52,
    ));
}

/**
 * CSS dynamique pour les paramètres globaux
 */
function isabel_global_dynamic_css() {
    $primary_color = get_theme_mod('isabel_primary_color', '#e4a7f5');
    $secondary_color = get_theme_mod('isabel_secondary_color', '#c47dd9');
    $text_color = get_theme_mod('isabel_text_color', '#2d1b3d');
    $text_light_color = get_theme_mod('isabel_text_light_color', '#6b5b73');
    $font_family = get_theme_mod('isabel_main_font_family', '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif');
    $base_font_size = get_theme_mod('isabel_base_font_size', 16);
    $dark_mode = get_theme_mod('isabel_dark_mode', false);
    $reduced_animations = get_theme_mod('isabel_reduced_animations', false);
    $show_dragonfly = get_theme_mod('isabel_show_dragonfly', true);
    $background_image = get_theme_mod('isabel_global_background_image', '');
    
    ?>
    <style type="text/css" id="isabel-global-styles">
    :root {
        --rose-500: <?php echo esc_attr($primary_color); ?>;
        --rose-700: <?php echo esc_attr($secondary_color); ?>;
        --text-dark: <?php echo esc_attr($text_color); ?>;
        --text-light: <?php echo esc_attr($text_light_color); ?>;
    }
    
    body {
        font-family: <?php echo esc_attr($font_family); ?>;
        font-size: <?php echo esc_attr($base_font_size); ?>px;
        <?php if (!empty($background_image)): ?>
        background-image: url(<?php echo esc_url($background_image); ?>);
        background-attachment: fixed;
        background-size: cover;
        background-position: center;
        <?php endif; ?>
    }
    
    <?php if ($dark_mode): ?>
    body {
        background-color: #1a1a1a;
        color: #ffffff;
    }
    
    .hero-floating,
    .services-section,
    .testimonials-section,
    .cta-section {
        background-color: #2d2d2d;
    }
    
    .service-card,
    .testimonial-card,
    .benefit-card {
        background-color: #3d3d3d;
        border-color: #555555;
        color: #ffffff;
    }
    
    .modal-content {
        background-color: #2d2d2d;
        color: #ffffff;
    }
    
    .form-input {
        background-color: #3d3d3d;
        border-color: #555555;
        color: #ffffff;
    }
    <?php endif; ?>
    
    <?php if ($reduced_animations): ?>
    *, *::before, *::after {
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: 0.01ms !important;
    }
    <?php endif; ?>
    
    <?php if (!$show_dragonfly): ?>
    .dragonfly {
        display: none !important;
    }
    <?php endif; ?>
    </style>
    <?php
}
add_action('wp_head', 'isabel_global_dynamic_css');

/**
 * Chargement conditionnel de Google Fonts
 */
function isabel_load_google_fonts() {
    if (get_theme_mod('isabel_enable_google_fonts', false)) {
        $font_family = get_theme_mod('isabel_main_font_family', '');
        
        $google_fonts_urls = array(
            '"Montserrat", sans-serif' => 'https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap',
            '"Open Sans", sans-serif' => 'https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&display=swap',
            '"Poppins", sans-serif' => 'https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap',
        );
        
        if (isset($google_fonts_urls[$font_family])) {
            wp_enqueue_style('isabel-google-fonts', $google_fonts_urls[$font_family], array(), null);
        }
    }
}
add_action('wp_enqueue_scripts', 'isabel_load_google_fonts');

/**
 * Minification CSS conditionnelle
 */
function isabel_minify_css_output($css) {
    if (get_theme_mod('isabel_minify_css', false)) {
        // Supprimer les commentaires
        $css = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css);
        // Supprimer les espaces inutiles
        $css = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $css);
        return $css;
    }
    return $css;
}

/**
 * Support lazy loading conditionnel
 */
function isabel_add_lazy_loading($content) {
    if (get_theme_mod('isabel_lazy_loading', true)) {
        // Ajouter loading="lazy" aux images
        $content = preg_replace('/<img(.*?)src=/i', '<img$1loading="lazy" src=', $content);
    }
    return $content;
}
add_filter('the_content', 'isabel_add_lazy_loading');

/**
 * Optimisations performance conditionnelles
 */
function isabel_performance_optimizations() {
    // Supprimer les scripts inutiles si performance activée
    if (get_theme_mod('isabel_minify_css', false)) {
        // Supprimer les emoji scripts
        remove_action('wp_head', 'print_emoji_detection_script', 7);
        remove_action('wp_print_styles', 'print_emoji_styles');
        remove_action('admin_print_scripts', 'print_emoji_detection_script');
        remove_action('admin_print_styles', 'print_emoji_styles');
        
        // Supprimer les DNS prefetch
        remove_action('wp_head', 'wp_resource_hints', 2);
    }
}
add_action('init', 'isabel_performance_optimizations');

/**
 * Ajout de classes CSS conditionnelles au body
 */
function isabel_global_body_classes($classes) {
    if (get_theme_mod('isabel_dark_mode', false)) {
        $classes[] = 'isabel-dark-mode';
    }
    
    if (get_theme_mod('isabel_reduced_animations', false)) {
        $classes[] = 'isabel-reduced-motion';
    }
    
    if (!get_theme_mod('isabel_show_dragonfly', true)) {
        $classes[] = 'isabel-no-dragonfly';
    }
    
    return $classes;
}
add_filter('body_class', 'isabel_global_body_classes');

?>