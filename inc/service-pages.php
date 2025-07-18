<?php
// Empêcher l'accès direct au fichier
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Gestion des pages de services - VERSION CORRIGÉE
 * - URLs personnalisées
 * - Templates dédiés
 * - Règles de réécriture
 * - Support pour 4 pages de services
 */

// ========================================
// GESTION DES URLS ET TEMPLATES - CORRIGÉE
// ========================================

// Template personnalisé pour les pages de services
function isabel_page_template_redirect() {
    if (is_home() || is_front_page()) {
        return;
    }
    
    $pagename = get_query_var('pagename');
    
    if (empty($pagename)) {
        return;
    }
    
    $templates = array(
        'coaching-personnel' => '/page-coaching-personnel.php',
        'accompagnement-vae' => '/page-accompagnement-vae.php',
        'hypnocoaching' => '/page-hypnocoaching.php',
        'consultation-decouverte' => '/page-consultation-decouverte.php'
    );
    
    if (isset($templates[$pagename])) {
        $template_file = get_template_directory() . $templates[$pagename];
        
        if (file_exists($template_file)) {
            // Log pour debug
            if (defined('WP_DEBUG') && WP_DEBUG) {
                error_log('Isabel: Chargement template ' . $pagename . ' depuis ' . $template_file);
            }
            
            include($template_file);
            exit;
        } else {
            // Log d'erreur si le template n'existe pas
            error_log('Isabel: Template manquant pour ' . $pagename . ' - Fichier attendu: ' . $template_file);
        }
    }
}
add_action('template_redirect', 'isabel_page_template_redirect');

// Ajouter les règles de réécriture pour les pages de services
function isabel_add_rewrite_rules() {
    add_rewrite_rule('^coaching-personnel/?$', 'index.php?pagename=coaching-personnel', 'top');
    add_rewrite_rule('^accompagnement-vae/?$', 'index.php?pagename=accompagnement-vae', 'top');
    add_rewrite_rule('^hypnocoaching/?$', 'index.php?pagename=hypnocoaching', 'top');
    add_rewrite_rule('^consultation-decouverte/?$', 'index.php?pagename=consultation-decouverte', 'top');
    
    // Log pour debug
    if (defined('WP_DEBUG') && WP_DEBUG) {
        error_log('Isabel: Règles de réécriture ajoutées pour les pages de services');
    }
}
add_action('init', 'isabel_add_rewrite_rules');

// Flush les règles de réécriture lors de l'activation du thème
function isabel_flush_rewrite_rules() {
    isabel_add_rewrite_rules();
    flush_rewrite_rules();
    
    if (defined('WP_DEBUG') && WP_DEBUG) {
        error_log('Isabel: Règles de réécriture rechargées');
    }
}
add_action('after_switch_theme', 'isabel_flush_rewrite_rules');

// ========================================
// CRÉATION AUTOMATIQUE DES PAGES - 4 PAGES
// ========================================

/**
 * Créer automatiquement les pages de services si elles n'existent pas
 */
function isabel_create_service_pages() {
    $services = array(
        'coaching-personnel' => array(
            'title' => 'Coaching Personnel',
            'content' => 'Page de coaching personnel - Contenu géré par le customizer'
        ),
        'accompagnement-vae' => array(
            'title' => 'Accompagnement VAE', 
            'content' => 'Page d\'accompagnement VAE - Contenu géré par le customizer'
        ),
        'hypnocoaching' => array(
            'title' => 'Hypnocoaching',
            'content' => 'Page d\'hypnocoaching - Contenu géré par le customizer'
        ),
        'consultation-decouverte' => array(
            'title' => 'Consultation Découverte',
            'content' => 'Page de consultation découverte - Contenu géré par le customizer'
        )
    );
    
    foreach ($services as $slug => $service) {
        // Vérifier si la page existe déjà
        $existing_page = get_page_by_path($slug);
        if (!$existing_page) {
            $page_id = wp_insert_post(array(
                'post_title' => $service['title'],
                'post_content' => $service['content'],
                'post_status' => 'publish',
                'post_type' => 'page',
                'post_name' => $slug,
                'post_author' => 1
            ));
            
            if ($page_id && !is_wp_error($page_id)) {
                error_log('Isabel: Page créée - ' . $service['title'] . ' (ID: ' . $page_id . ')');
            } else {
                error_log('Isabel: Erreur création page - ' . $service['title']);
            }
        } else {
            error_log('Isabel: Page existe déjà - ' . $service['title'] . ' (ID: ' . $existing_page->ID . ')');
        }
    }
}

// Créer les pages lors de l'activation du thème
add_action('after_switch_theme', 'isabel_create_service_pages');

// ========================================
// NAVIGATION ET MENU - 4 PAGES
// ========================================

/**
 * Ajouter les pages de services au menu principal automatiquement
 */
function isabel_add_services_to_menu() {
    $menu_name = 'main-menu';
    $menu_exists = wp_get_nav_menu_object($menu_name);
    
    if (!$menu_exists) {
        // Créer le menu s'il n'existe pas
        $menu_id = wp_create_nav_menu($menu_name);
        
        if (is_wp_error($menu_id)) {
            error_log('Isabel: Erreur création menu - ' . $menu_id->get_error_message());
            return;
        }
        
        // Ajouter les items de menu - AVEC 4ème PAGE
        $services = array(
            'Accueil' => home_url('/'),
            'Coaching Personnel' => home_url('/coaching-personnel'),
            'Accompagnement VAE' => home_url('/accompagnement-vae'),
            'Hypnocoaching' => home_url('/hypnocoaching'),
            'Consultation Découverte' => home_url('/consultation-decouverte'),
            'Contact' => home_url('/#contact')
        );
        
        $menu_order = 1;
        foreach ($services as $title => $url) {
            $item_id = wp_update_nav_menu_item($menu_id, 0, array(
                'menu-item-title' => $title,
                'menu-item-url' => $url,
                'menu-item-status' => 'publish',
                'menu-item-position' => $menu_order++
            ));
            
            if (is_wp_error($item_id)) {
                error_log('Isabel: Erreur ajout item menu - ' . $title);
            }
        }
        
        // Assigner le menu à l'emplacement
        $locations = get_theme_mod('nav_menu_locations');
        $locations['main-menu'] = $menu_id;
        set_theme_mod('nav_menu_locations', $locations);
        
        error_log('Isabel: Menu principal créé avec ID: ' . $menu_id);
    } else {
        error_log('Isabel: Menu principal existe déjà');
    }
}

// Créer le menu lors de l'activation du thème
add_action('after_switch_theme', 'isabel_add_services_to_menu');

// ========================================
// FONCTIONS UTILITAIRES POUR LES SERVICES - 4 PAGES
// ========================================

/**
 * Vérifier si une page de service existe
 * @param string $service_slug
 * @return bool
 */
function isabel_service_page_exists($service_slug) {
    $page = get_page_by_path($service_slug);
    return $page !== null;
}

/**
 * Récupérer l'URL d'un service
 * @param string $service_slug
 * @return string
 */
function isabel_get_service_url($service_slug) {
    return home_url('/' . $service_slug);
}

/**
 * Récupérer tous les services disponibles - AVEC 4ème SERVICE
 * @return array
 */
function isabel_get_all_services() {
    return array(
        'coaching-personnel' => array(
            'title' => isabel_get_option('isabel_service1_title', 'Coaching Personnel'),
            'icon' => isabel_get_option('isabel_service1_icon', '🎯'),
            'description' => isabel_get_option('isabel_service1_desc', 'Révélez votre potentiel...'),
            'url' => isabel_get_service_url('coaching-personnel')
        ),
        'accompagnement-vae' => array(
            'title' => isabel_get_option('isabel_service2_title', 'Accompagnement VAE'),
            'icon' => isabel_get_option('isabel_service2_icon', '🎓'),
            'description' => isabel_get_option('isabel_service2_desc', 'Valorisez votre expérience...'),
            'url' => isabel_get_service_url('accompagnement-vae')
        ),
        'hypnocoaching' => array(
            'title' => isabel_get_option('isabel_service3_title', 'Hypnocoaching'),
            'icon' => isabel_get_option('isabel_service3_icon', '🧘'),
            'description' => isabel_get_option('isabel_service3_desc', 'Libérez-vous de vos blocages...'),
            'url' => isabel_get_service_url('hypnocoaching')
        ),
        'consultation-decouverte' => array(
            'title' => isabel_get_option('isabel_service4_title', 'Consultation Découverte'),
            'icon' => isabel_get_option('isabel_service4_icon', '💡'),
            'description' => isabel_get_option('isabel_service4_desc', 'Première rencontre pour définir vos besoins...'),
            'url' => isabel_get_service_url('consultation-decouverte')
        )
    );
}

/**
 * Générer le HTML pour la liste des services - 4 SERVICES
 * @return string
 */
function isabel_display_services() {
    $services = isabel_get_all_services();
    $html = '<div class="isabel-services-list">';
    
    foreach ($services as $slug => $service) {
        $html .= '<div class="service-item">';
        $html .= '<div class="service-icon">' . esc_html($service['icon']) . '</div>';
        $html .= '<h3 class="service-title">' . esc_html($service['title']) . '</h3>';
        $html .= '<p class="service-description">' . esc_html($service['description']) . '</p>';
        $html .= '<a href="' . esc_url($service['url']) . '" class="service-link">En savoir plus</a>';
        $html .= '</div>';
    }
    
    $html .= '</div>';
    return $html;
}

// ========================================
// BREADCRUMBS POUR LES PAGES DE SERVICES
// ========================================

/**
 * Générer des breadcrumbs pour les pages de services
 * @param string $current_page
 * @return string
 */
function isabel_get_service_breadcrumbs($current_page) {
    $breadcrumbs = '<nav class="isabel-breadcrumbs">';
    $breadcrumbs .= '<a href="' . home_url() . '">Accueil</a>';
    $breadcrumbs .= ' > ';
    
    $services = isabel_get_all_services();
    if (isset($services[$current_page])) {
        $breadcrumbs .= '<span>' . esc_html($services[$current_page]['title']) . '</span>';
    } else {
        $breadcrumbs .= '<span>' . esc_html($current_page) . '</span>';
    }
    
    $breadcrumbs .= '</nav>';
    return $breadcrumbs;
}

// ========================================
// SEO ET META POUR LES PAGES DE SERVICES - 4 PAGES
// ========================================

/**
 * Ajouter des meta descriptions pour les pages de services
 */
function isabel_service_meta_description() {
    $pagename = get_query_var('pagename');
    
    $meta_descriptions = array(
        'coaching-personnel' => 'Coaching personnel avec Isabel Goncalves. Révélez votre potentiel et transformez votre vie personnelle et professionnelle.',
        'accompagnement-vae' => 'Accompagnement VAE avec Isabel Goncalves. Valorisez votre expérience et obtenez une reconnaissance officielle.',
        'hypnocoaching' => 'Hypnocoaching avec Isabel Goncalves. Libérez-vous de vos blocages grâce à l\'alliance du coaching et de l\'hypnose.',
        'consultation-decouverte' => 'Consultation découverte avec Isabel Goncalves. Première rencontre pour définir vos objectifs et découvrir mes services.'
    );
    
    if (isset($meta_descriptions[$pagename])) {
        echo '<meta name="description" content="' . esc_attr($meta_descriptions[$pagename]) . '">' . "\n";
    }
}
add_action('wp_head', 'isabel_service_meta_description');

// ========================================
// GESTION DES QUERY VARS
// ========================================

/**
 * Ajouter les query vars personnalisées
 */
function isabel_add_query_vars($vars) {
    $vars[] = 'pagename';
    return $vars;
}
add_filter('query_vars', 'isabel_add_query_vars');

// ========================================
// FONCTION DE DIAGNOSTIC POUR LES PAGES
// ========================================

/**
 * Vérifier l'état des pages de services
 */
function isabel_check_service_pages_status() {
    if (current_user_can('manage_options') && isset($_GET['isabel_debug'])) {
        $services = array('coaching-personnel', 'accompagnement-vae', 'hypnocoaching', 'consultation-decouverte');
        
        echo '<div style="background: white; padding: 20px; margin: 20px; border: 1px solid #ddd; position: fixed; top: 50px; right: 20px; z-index: 99999; max-width: 400px;">';
        echo '<h3>🔍 État des pages de services Isabel</h3>';
        
        foreach ($services as $slug) {
            $page = get_page_by_path($slug);
            $status = $page ? '✅ Existe (ID: ' . $page->ID . ')' : '❌ Manquante';
            $url = home_url('/' . $slug);
            $template_file = get_template_directory() . '/page-' . $slug . '.php';
            $template_exists = file_exists($template_file) ? '✅' : '❌';
            
            echo '<div style="margin: 10px 0; padding: 10px; border: 1px solid #eee;">';
            echo '<strong>' . $slug . '</strong><br>';
            echo 'Page: ' . $status . '<br>';
            echo 'Template: ' . $template_exists . '<br>';
            echo '<a href="' . $url . '" target="_blank" style="color: blue;">Tester la page</a>';
            echo '</div>';
        }
        
        echo '<p><em>Ajoutez ?isabel_debug=1 à votre URL pour voir ce diagnostic</em></p>';
        echo '<button onclick="this.parentElement.style.display=\'none\'" style="background: #ccc; border: none; padding: 5px 10px; cursor: pointer;">Fermer</button>';
        echo '</div>';
    }
}
add_action('wp_footer', 'isabel_check_service_pages_status');

// ========================================
// HOOKS DE VÉRIFICATION ET MAINTENANCE
// ========================================

/**
 * Vérifier les templates au chargement
 */
function isabel_check_templates() {
    if (defined('WP_DEBUG') && WP_DEBUG) {
        $services = array('coaching-personnel', 'accompagnement-vae', 'hypnocoaching', 'consultation-decouverte');
        
        foreach ($services as $slug) {
            $template_file = get_template_directory() . '/page-' . $slug . '.php';
            if (!file_exists($template_file)) {
                error_log('Isabel: Template manquant - ' . $template_file);
            }
        }
    }
}
add_action('init', 'isabel_check_templates');

/**
 * Régénérer les règles de réécriture si nécessaire
 */
function isabel_maybe_flush_rewrite_rules() {
    if (get_option('isabel_rewrite_rules_flushed') !== get_template_directory()) {
        isabel_add_rewrite_rules();
        flush_rewrite_rules();
        update_option('isabel_rewrite_rules_flushed', get_template_directory());
        
        if (defined('WP_DEBUG') && WP_DEBUG) {
            error_log('Isabel: Règles de réécriture régénérées automatiquement');
        }
    }
}
add_action('init', 'isabel_maybe_flush_rewrite_rules');

?>