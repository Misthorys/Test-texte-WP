<?php
// Empêcher l'accès direct au fichier
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Customizer pour l'EN-TÊTE (HEADER)
 */

function isabel_register_header_customizer($wp_customize) {
    
    // ===== SECTION HEADER =====
    $wp_customize->add_section('isabel_header_section', array(
        'title' => '🔝 En-tête du Site',
        'priority' => 20,
        'description' => 'Personnalisez l\'en-tête : logo, navigation, boutons'
    ));
    
    // ===== LOGO ET IDENTITÉ =====
    
    // Logo header
    $wp_customize->add_setting('isabel_header_logo', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'isabel_header_logo', array(
        'label' => 'Logo Header',
        'description' => 'Logo affiché dans l\'en-tête (50x50px recommandé)',
        'section' => 'isabel_header_section',
        'priority' => 10,
    )));
    
    // Nom dans le header avec éditeur Word-like
    isabel_add_word_editor(
        $wp_customize,
        'isabel_header_name_word',
        '📝 Nom Header',
        '<span style="font-weight: bold; color: #c47dd9;">Isabel GONCALVES</span>',
        'isabel_header_section',
        array(
            'description' => 'Nom affiché dans l\'en-tête',
            'editor_height' => '80px',
            'priority' => 11
        )
    );
    
    // Sous-titre header avec éditeur Word-like
    isabel_add_word_editor(
        $wp_customize,
        'isabel_header_subtitle_word',
        '📝 Sous-titre Header',
        '<span style="color: #6b5b73; font-size: 0.9rem;">Formatrice &amp; Coach Certifiée</span>',
        'isabel_header_section',
        array(
            'description' => 'Sous-titre dans l\'en-tête',
            'editor_height' => '80px',
            'priority' => 12
        )
    );
    
    // ===== NAVIGATION =====
    
    // Style de navigation
    $wp_customize->add_setting('isabel_nav_style', array(
        'default' => 'buttons',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('isabel_nav_style', array(
        'label' => 'Style de Navigation',
        'description' => 'Apparence des liens de navigation',
        'section' => 'isabel_header_section',
        'type' => 'select',
        'choices' => array(
            'buttons' => 'Boutons arrondis (Recommandé)',
            'underline' => 'Soulignement',
            'minimal' => 'Minimal',
            'pills' => 'Pilules colorées',
        ),
        'priority' => 20,
    ));
    
    // Couleur de fond navigation
    $wp_customize->add_setting('isabel_nav_bg_color', array(
        'default' => 'transparent',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('isabel_nav_bg_color', array(
        'label' => 'Fond Navigation',
        'section' => 'isabel_header_section',
        'type' => 'select',
        'choices' => array(
            'transparent' => 'Transparent',
            'white' => 'Blanc',
            'colored' => 'Coloré',
            'gradient' => 'Dégradé',
        ),
        'priority' => 21,
    ));
    
    // Position sticky
    $wp_customize->add_setting('isabel_header_sticky', array(
        'default' => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('isabel_header_sticky', array(
        'label' => 'En-tête Sticky',
        'description' => 'L\'en-tête reste visible lors du scroll',
        'section' => 'isabel_header_section',
        'type' => 'checkbox',
        'priority' => 22,
    ));
    
    // ===== BOUTON CTA HEADER =====
    
    // Affichage du bouton CTA
    $wp_customize->add_setting('isabel_header_show_cta', array(
        'default' => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('isabel_header_show_cta', array(
        'label' => 'Afficher Bouton CTA',
        'description' => 'Bouton "Prendre rendez-vous" dans l\'en-tête',
        'section' => 'isabel_header_section',
        'type' => 'checkbox',
        'priority' => 30,
    ));
    
    // Texte du bouton CTA avec éditeur Word-like
    isabel_add_word_editor(
        $wp_customize,
        'isabel_header_cta_text_word',
        '📝 Texte Bouton CTA',
        '<span style="font-weight: bold;">Prendre rendez-vous</span>',
        'isabel_header_section',
        array(
            'description' => 'Texte du bouton CTA dans l\'en-tête',
            'editor_height' => '80px',
            'priority' => 31
        )
    );
    
    // Style du bouton CTA
    $wp_customize->add_setting('isabel_header_cta_style', array(
        'default' => 'gradient',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('isabel_header_cta_style', array(
        'label' => 'Style Bouton CTA',
        'section' => 'isabel_header_section',
        'type' => 'select',
        'choices' => array(
            'gradient' => 'Dégradé (Recommandé)',
            'solid' => 'Couleur unie',
            'outline' => 'Contour',
            'ghost' => 'Fantôme',
        ),
        'priority' => 32,
    ));
    
    // ===== BARRE D'ALERTE (optionnelle) =====
    
    // Activation barre d'alerte
    $wp_customize->add_setting('isabel_alert_bar_enable', array(
        'default' => false,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('isabel_alert_bar_enable', array(
        'label' => 'Activer Barre d\'Alerte',
        'description' => 'Barre d\'information en haut du site',
        'section' => 'isabel_header_section',
        'type' => 'checkbox',
        'priority' => 40,
    ));
    
    // Texte barre d'alerte avec éditeur Word-like
    isabel_add_word_editor(
        $wp_customize,
        'isabel_alert_bar_text_word',
        '📝 Texte Barre d\'Alerte',
        '<span style="font-weight: 500;">🎁 <strong>Consultation découverte gratuite</strong> - Prenez rendez-vous dès maintenant !</span>',
        'isabel_header_section',
        array(
            'description' => 'Message affiché dans la barre d\'alerte',
            'editor_height' => '100px',
            'priority' => 41
        )
    );
    
    // Couleur barre d'alerte
    $wp_customize->add_setting('isabel_alert_bar_color', array(
        'default' => 'primary',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('isabel_alert_bar_color', array(
        'label' => 'Couleur Barre d\'Alerte',
        'section' => 'isabel_header_section',
        'type' => 'select',
        'choices' => array(
            'primary' => 'Couleur primaire',
            'success' => 'Vert (succès)',
            'warning' => 'Orange (attention)',
            'info' => 'Bleu (information)',
        ),
        'priority' => 42,
    ));
    
    // Bouton dans la barre d'alerte
    $wp_customize->add_setting('isabel_alert_bar_show_button', array(
        'default' => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('isabel_alert_bar_show_button', array(
        'label' => 'Bouton dans Barre d\'Alerte',
        'description' => 'Afficher un bouton d\'action',
        'section' => 'isabel_header_section',
        'type' => 'checkbox',
        'priority' => 43,
    ));
    
    // Texte bouton barre d'alerte
    isabel_add_word_editor(
        $wp_customize,
        'isabel_alert_bar_button_text_word',
        '📝 Texte Bouton Alerte',
        '<span style="font-weight: bold;">Réserver</span>',
        'isabel_header_section',
        array(
            'description' => 'Texte du bouton dans la barre d\'alerte',
            'editor_height' => '80px',
            'priority' => 44
        )
    );
    
    // ===== PARAMÈTRES AVANCÉS =====
    
    // Hauteur header
    $wp_customize->add_setting('isabel_header_height', array(
        'default' => 'normal',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('isabel_header_height', array(
        'label' => 'Hauteur En-tête',
        'section' => 'isabel_header_section',
        'type' => 'select',
        'choices' => array(
            'compact' => 'Compact',
            'normal' => 'Normal',
            'large' => 'Grand',
        ),
        'priority' => 50,
    ));
    
    // Effet backdrop blur
    $wp_customize->add_setting('isabel_header_blur', array(
        'default' => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('isabel_header_blur', array(
        'label' => 'Effet Flou en Arrière-plan',
        'description' => 'Effet de flou moderne (backdrop-filter)',
        'section' => 'isabel_header_section',
        'type' => 'checkbox',
        'priority' => 51,
    ));
    
    // Ombre header
    $wp_customize->add_setting('isabel_header_shadow', array(
        'default' => 'soft',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('isabel_header_shadow', array(
        'label' => 'Ombre En-tête',
        'section' => 'isabel_header_section',
        'type' => 'select',
        'choices' => array(
            'none' => 'Aucune',
            'soft' => 'Douce',
            'medium' => 'Moyenne',
            'strong' => 'Forte',
        ),
        'priority' => 52,
    ));

    // ===== PARAMÈTRES FALLBACK (version simple) =====
    
    // Nom simple (fallback)
    $wp_customize->add_setting('isabel_header_name', array(
        'default' => 'Isabel GONCALVES',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('isabel_header_name', array(
        'label' => 'Nom (version simple)',
        'description' => 'Version simple sans formatage',
        'section' => 'isabel_header_section',
        'type' => 'text',
        'priority' => 60,
    ));
    
    // Sous-titre simple (fallback)
    $wp_customize->add_setting('isabel_header_subtitle', array(
        'default' => 'Formatrice & Coach Certifiée',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('isabel_header_subtitle', array(
        'label' => 'Sous-titre (version simple)',
        'description' => 'Version simple sans formatage',
        'section' => 'isabel_header_section',
        'type' => 'text',
        'priority' => 61,
    ));
}

/**
 * Fonctions d'affichage pour le header
 */

// Fonction pour afficher le logo ou placeholder
function isabel_display_header_logo() {
    $logo = isabel_get_option('isabel_header_logo', '');
    
    if (!empty($logo)) {
        echo '<img src="' . esc_url($logo) . '" alt="Logo Isabel GONCALVES" class="logo-image" />';
    } else {
        echo '<div class="logo-placeholder">IG</div>';
    }
}

// Fonction pour afficher le nom depuis l'éditeur Word-like
function isabel_display_header_name() {
    $name_word = isabel_get_word_editor_content('isabel_header_name_word', '');
    if (!empty($name_word)) {
        echo $name_word;
    } else {
        echo esc_html(isabel_get_option('isabel_header_name', 'Isabel GONCALVES'));
    }
}

// Fonction pour afficher le sous-titre depuis l'éditeur Word-like
function isabel_display_header_subtitle() {
    $subtitle_word = isabel_get_word_editor_content('isabel_header_subtitle_word', '');
    if (!empty($subtitle_word)) {
        echo $subtitle_word;
    } else {
        echo esc_html(isabel_get_option('isabel_header_subtitle', 'Formatrice & Coach Certifiée'));
    }
}

// Fonction pour afficher le bouton CTA du header
function isabel_display_header_cta() {
    if (!isabel_get_option('isabel_header_show_cta', true)) {
        return;
    }
    
    $cta_text_word = isabel_get_word_editor_content('isabel_header_cta_text_word', '');
    $cta_text = !empty($cta_text_word) ? $cta_text_word : 'Prendre rendez-vous';
    $cta_style = isabel_get_option('isabel_header_cta_style', 'gradient');
    
    $button_class = 'header-cta-btn header-cta-' . $cta_style;
    
    echo '<div class="header-cta">';
    echo '<button class="' . esc_attr($button_class) . '" onclick="openPopup()">';
    echo $cta_text;
    echo '</button>';
    echo '</div>';
}

// Fonction pour afficher la barre d'alerte
function isabel_display_alert_bar() {
    if (!isabel_get_option('isabel_alert_bar_enable', false)) {
        return;
    }
    
    $alert_text_word = isabel_get_word_editor_content('isabel_alert_bar_text_word', '');
    $alert_text = !empty($alert_text_word) ? $alert_text_word : 'Information importante';
    $alert_color = isabel_get_option('isabel_alert_bar_color', 'primary');
    $show_button = isabel_get_option('isabel_alert_bar_show_button', true);
    
    echo '<div class="top-alert alert-' . esc_attr($alert_color) . '">';
    echo '<div class="alert-content">';
    echo '<div class="alert-text">' . $alert_text . '</div>';
    
    if ($show_button) {
        $button_text_word = isabel_get_word_editor_content('isabel_alert_bar_button_text_word', '');
        $button_text = !empty($button_text_word) ? $button_text_word : 'Réserver';
        
        echo '<button class="btn-alert" onclick="openPopup()">';
        echo $button_text;
        echo '</button>';
    }
    
    echo '</div>';
    echo '</div>';
}

/**
 * CSS dynamique pour le header
 */
function isabel_header_dynamic_css() {
    $nav_style = isabel_get_option('isabel_nav_style', 'buttons');
    $nav_bg_color = isabel_get_option('isabel_nav_bg_color', 'transparent');
    $header_sticky = isabel_get_option('isabel_header_sticky', true);
    $header_height = isabel_get_option('isabel_header_height', 'normal');
    $header_blur = isabel_get_option('isabel_header_blur', true);
    $header_shadow = isabel_get_option('isabel_header_shadow', 'soft');
    $cta_style = isabel_get_option('isabel_header_cta_style', 'gradient');
    $alert_color = isabel_get_option('isabel_alert_bar_color', 'primary');
    
    ?>
    <style type="text/css" id="isabel-header-styles">
    /* Header position */
    .header {
        position: <?php echo $header_sticky ? 'sticky' : 'static'; ?>;
        <?php if ($header_blur): ?>
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        <?php endif; ?>
    }
    
    /* Header height */
    .header-container {
        <?php
        switch ($header_height) {
            case 'compact':
                echo 'padding: 0.75rem 1.5rem;';
                break;
            case 'large':
                echo 'padding: 1.5rem 1.5rem;';
                break;
            default:
                echo 'padding: 1rem 1.5rem;';
        }
        ?>
    }
    
    /* Header shadow */
    .header {
        <?php
        switch ($header_shadow) {
            case 'none':
                echo 'box-shadow: none;';
                break;
            case 'medium':
                echo 'box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);';
                break;
            case 'strong':
                echo 'box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);';
                break;
            default:
                echo 'box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);';
        }
        ?>
    }
    
    /* Navigation style */
    <?php if ($nav_style === 'underline'): ?>
    .nav-menu a {
        border-radius: 0;
        position: relative;
    }
    .nav-menu a::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 0;
        height: 2px;
        background: var(--rose-500);
        transition: width 0.3s ease;
    }
    .nav-menu a:hover::after {
        width: 100%;
    }
    <?php elseif ($nav_style === 'minimal'): ?>
    .nav-menu a {
        background: none !important;
        border: none !important;
        color: var(--text-dark);
    }
    .nav-menu a:hover {
        color: var(--rose-700);
    }
    <?php elseif ($nav_style === 'pills'): ?>
    .nav-menu a {
        background: var(--rose-300);
        color: var(--rose-700);
        border-radius: 20px;
        padding: 0.5rem 1rem;
    }
    .nav-menu a:hover {
        background: var(--rose-500);
        color: white;
    }
    <?php endif; ?>
    
    /* Navigation background */
    <?php if ($nav_bg_color === 'white'): ?>
    .nav-menu {
        background: white !important;
    }
    <?php elseif ($nav_bg_color === 'colored'): ?>
    .nav-menu {
        background: var(--rose-300) !important;
    }
    <?php elseif ($nav_bg_color === 'gradient'): ?>
    .nav-menu {
        background: linear-gradient(135deg, var(--rose-300), var(--rose-500)) !important;
    }
    <?php endif; ?>
    
    /* CTA Button style */
    .header-cta-btn {
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 25px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    <?php if ($cta_style === 'gradient'): ?>
    .header-cta-gradient {
        background: linear-gradient(135deg, var(--rose-700), var(--rose-500));
        color: white;
    }
    .header-cta-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(196, 125, 217, 0.4);
    }
    <?php elseif ($cta_style === 'solid'): ?>
    .header-cta-solid {
        background: var(--rose-700);
        color: white;
    }
    .header-cta-solid:hover {
        background: var(--rose-500);
    }
    <?php elseif ($cta_style === 'outline'): ?>
    .header-cta-outline {
        background: transparent;
        color: var(--rose-700);
        border: 2px solid var(--rose-700);
    }
    .header-cta-outline:hover {
        background: var(--rose-700);
        color: white;
    }
    <?php elseif ($cta_style === 'ghost'): ?>
    .header-cta-ghost {
        background: rgba(196, 125, 217, 0.1);
        color: var(--rose-700);
        border: 1px solid rgba(196, 125, 217, 0.3);
    }
    .header-cta-ghost:hover {
        background: rgba(196, 125, 217, 0.2);
    }
    <?php endif; ?>
    
    /* Alert bar colors */
    <?php
    $alert_colors = array(
        'primary' => 'linear-gradient(135deg, var(--rose-700), var(--rose-500))',
        'success' => 'linear-gradient(135deg, #00a32a, #00d084)',
        'warning' => 'linear-gradient(135deg, #ff6900, #ffb900)',
        'info' => 'linear-gradient(135deg, #0073aa, #005a87)',
    );
    ?>
    .alert-<?php echo esc_attr($alert_color); ?> {
        background: <?php echo $alert_colors[$alert_color]; ?>;
    }
    </style>
    <?php
}
add_action('wp_head', 'isabel_header_dynamic_css');

/**
 * Fonction pour déterminer quelle page est active (pour navigation)
 */
function isabel_get_current_page_slug() {
    if (is_front_page() || is_home()) {
        return 'home';
    }
    
    global $wp_query;
    $pagename = get_query_var('pagename');
    
    if (!empty($pagename)) {
        return $pagename;
    }
    
    return '';
}

/**
 * Ajouter classes CSS au header selon les paramètres
 */
function isabel_header_classes() {
    $classes = array('header');
    
    $nav_style = isabel_get_option('isabel_nav_style', 'buttons');
    $header_height = isabel_get_option('isabel_header_height', 'normal');
    $header_blur = isabel_get_option('isabel_header_blur', true);
    
    $classes[] = 'nav-style-' . $nav_style;
    $classes[] = 'header-height-' . $header_height;
    
    if ($header_blur) {
        $classes[] = 'header-blur';
    }
    
    return implode(' ', $classes);
}

/**
 * Menu de navigation par défaut si pas de menu configuré
 */
function isabel_default_header_menu() {
    $menu_items = array(
        'Accueil' => home_url('/'),
        'Coaching Personnel' => home_url('/coaching-personnel'),
        'Accompagnement VAE' => home_url('/accompagnement-vae'),
        'Hypnocoaching' => home_url('/hypnocoaching'),
        'Consultation Découverte' => home_url('/consultation-decouverte'),
        'Contact' => home_url('/#contact')
    );
    
    $current_page = isabel_get_current_page_slug();
    
    echo '<ul>';
    foreach ($menu_items as $title => $url) {
        $is_active = '';
        
        // Déterminer si le lien est actif
        if (($title === 'Accueil' && ($current_page === 'home' || $current_page === '')) ||
            ($title === 'Coaching Personnel' && $current_page === 'coaching-personnel') ||
            ($title === 'Accompagnement VAE' && $current_page === 'accompagnement-vae') ||
            ($title === 'Hypnocoaching' && $current_page === 'hypnocoaching') ||
            ($title === 'Consultation Découverte' && $current_page === 'consultation-decouverte')) {
            $is_active = ' class="active"';
        }
        
        echo '<li' . $is_active . '><a href="' . esc_url($url) . '">' . esc_html($title) . '</a></li>';
    }
    echo '</ul>';
}

?>