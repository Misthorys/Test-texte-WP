<?php
// Empêcher l'accès direct au fichier
if (!defined('ABSPATH')) {
    exit;
}

// ========================================
// CONFIGURATION DU THÈME
// ========================================

function isabel_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array(
        'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
    ));
    
    register_nav_menus(array(
        'main-menu' => 'Menu Principal',
    ));
}
add_action('after_setup_theme', 'isabel_theme_setup');

// Enqueue des styles et scripts - VERSION CORRIGÉE
function isabel_theme_scripts() {
    // Enqueue du CSS
    wp_enqueue_style('isabel-style', get_stylesheet_uri(), array(), '2.0.3');
    
    // Enqueue du JavaScript - CORRECTION : enlever jQuery en dépendance
    wp_enqueue_script('isabel-script', get_template_directory_uri() . '/js/main.js', array(), '2.0.3', true);
    
    // CORRECTION : Localiser le script APRÈS l'avoir enregistré
    wp_localize_script('isabel-script', 'isabel_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('isabel_contact_nonce'),
        'delete_nonce' => wp_create_nonce('isabel_delete_contact_nonce'),
        'debug' => defined('WP_DEBUG') && WP_DEBUG ? true : false
    ));
}
add_action('wp_enqueue_scripts', 'isabel_theme_scripts');

// ========================================
// INCLUSIONS DES FICHIERS ORGANISÉS - NOUVEAU SYSTÈME MODULAIRE
// ========================================

// Charger le nouveau customizer modulaire (toutes les options de personnalisation)
require_once get_template_directory() . '/inc/customizer.php';

// Charger la gestion des contacts
require_once get_template_directory() . '/inc/contact-handler.php';

// Charger la gestion des témoignages
require_once get_template_directory() . '/inc/testimonials.php';

// Charger la gestion des pages de services
require_once get_template_directory() . '/inc/service-pages.php';

// Charger l'interface d'administration
require_once get_template_directory() . '/inc/admin-interface.php';

// ========================================
// FONCTIONS UTILITAIRES
// ========================================

// Fonction pour récupérer les options du thème
function isabel_get_option($option_name, $default = '') {
    return get_theme_mod($option_name, $default);
}

// Fonction pour afficher l'image de profil ou le placeholder
function isabel_get_profile_image($size = 'full', $css_class = '') {
    $profile_image = isabel_get_option('isabel_profile_image', '');
    
    if (!empty($profile_image)) {
        return '<img src="' . esc_url($profile_image) . '" alt="Photo de profil" class="' . esc_attr($css_class) . '" />';
    }
    
    return ''; // Retourne vide si pas d'image, le CSS placeholder s'occupera du reste
}

// ========================================
// FONCTIONS DE COMPATIBILITÉ POUR LES NOUVEAUX CUSTOMIZERS
// ========================================

/**
 * Fonction pour récupérer le contenu des éditeurs Word-like
 * (définie ici pour compatibilité si pas encore chargée)
 */
if (!function_exists('isabel_get_word_editor_content')) {
    function isabel_get_word_editor_content($setting_id, $default = '') {
        $content = get_theme_mod($setting_id, $default);
        return wp_kses_post($content);
    }
}

/**
 * Fonction pour afficher le contenu des éditeurs Word-like
 */
if (!function_exists('isabel_display_word_editor_content')) {
    function isabel_display_word_editor_content($setting_id, $default = '') {
        echo isabel_get_word_editor_content($setting_id, $default);
    }
}

/**
 * Fonction de compatibilité pour les anciens settings
 */
if (!function_exists('isabel_get_word_or_regular_content')) {
    function isabel_get_word_or_regular_content($word_setting, $regular_setting, $default = '') {
        // Priorité aux éditeurs Word-like
        $word_content = get_theme_mod($word_setting, '');
        if (!empty($word_content)) {
            return wp_kses_post($word_content);
        }
        
        // Fallback vers l'ancien système
        return esc_html(get_theme_mod($regular_setting, $default));
    }
}

// ========================================
// SÉCURITÉ ET NETTOYAGE
// ========================================

// Nettoyage et sécurité
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'rsd_link');

function isabel_remove_version() {
    return '';
}
add_filter('the_generator', 'isabel_remove_version');

// ========================================
// AMÉLIORATION DE LA CONFIGURATION EMAIL
// ========================================

// Configurer WordPress pour améliorer l'envoi d'emails
add_action('phpmailer_init', function($phpmailer) {
    // Log de debug pour l'email
    if (defined('WP_DEBUG') && WP_DEBUG) {
        error_log('Isabel Email - Configuration PHPMailer');
        error_log('From: ' . $phpmailer->From);
        error_log('FromName: ' . $phpmailer->FromName);
    }
});

// Filtre pour forcer l'email From
add_filter('wp_mail_from', function($from_email) {
    // Utiliser l'email admin par défaut pour éviter les problèmes de deliverabilité
    $admin_email = get_option('admin_email');
    
    if (defined('WP_DEBUG') && WP_DEBUG) {
        error_log('Isabel Email - From email: ' . $admin_email);
    }
    
    return $admin_email;
});

add_filter('wp_mail_from_name', function($from_name) {
    return get_bloginfo('name');
});

// ========================================
// VÉRIFICATIONS ET DEBUG
// ========================================

// Vérification au chargement
add_action('wp_loaded', function() {
    if (defined('WP_DEBUG') && WP_DEBUG) {
        error_log('=== ISABEL THEME LOADED CHECK - SYSTÈME MODULAIRE ===');
        error_log('Contact handler hooks registered: ' . (has_action('wp_ajax_isabel_contact') ? 'YES' : 'NO'));
        error_log('Admin interface loaded: ' . (function_exists('isabel_contacts_page') ? 'YES' : 'NO'));
        error_log('Customizer loaded: ' . (function_exists('isabel_customize_register') ? 'YES' : 'NO'));
        
        // Vérifier les customizers modulaires
        error_log('Global customizer: ' . (function_exists('isabel_register_global_customizer') ? 'YES' : 'NO'));
        error_log('Header customizer: ' . (function_exists('isabel_register_header_customizer') ? 'YES' : 'NO'));
        error_log('Home customizer: ' . (function_exists('isabel_register_home_customizer') ? 'YES' : 'NO'));
        error_log('Coaching customizer: ' . (function_exists('isabel_register_coaching_customizer') ? 'YES' : 'NO'));
        error_log('VAE customizer: ' . (function_exists('isabel_register_vae_customizer') ? 'YES' : 'NO'));
        error_log('Hypno customizer: ' . (function_exists('isabel_register_hypno_customizer') ? 'YES' : 'NO'));
        error_log('Consultation customizer: ' . (function_exists('isabel_register_consultation_customizer') ? 'YES' : 'NO'));
        error_log('Footer customizer: ' . (function_exists('isabel_register_footer_customizer') ? 'YES' : 'NO'));
        error_log('Modal customizer: ' . (function_exists('isabel_register_modal_customizer') ? 'YES' : 'NO'));
        error_log('Qualiopi customizer: ' . (function_exists('isabel_register_qualiopi_customizer') ? 'YES' : 'NO'));
        
        // Vérifier la table
        global $wpdb;
        $table_name = $wpdb->prefix . 'isabel_contacts';
        $table_exists = $wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name;
        error_log('Contact table exists: ' . ($table_exists ? 'YES' : 'NO'));
        
        error_log('============================================');
    }
});

// Fallback JavaScript pour isabel_ajax
add_action('wp_footer', function() {
    if (is_front_page() || is_home()) {
        ?>
        <script>
        // Définir isabel_ajax manuellement si pas défini
        if (typeof isabel_ajax === 'undefined') {
            window.isabel_ajax = {
                ajax_url: '<?php echo admin_url('admin-ajax.php'); ?>',
                nonce: '<?php echo wp_create_nonce('isabel_contact_nonce'); ?>',
                debug: <?php echo (defined('WP_DEBUG') && WP_DEBUG) ? 'true' : 'false'; ?>
            };
            console.log('🔧 isabel_ajax défini manuellement:', isabel_ajax);
        } else {
            console.log('✅ isabel_ajax déjà disponible via wp_localize_script');
        }
        </script>
        <?php
    }
}, 5);

// ========================================
// VÉRIFICATION DE LA TABLE CONTACTS
// ========================================

add_action('init', function() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'isabel_contacts';
    $table_exists = $wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name;
    
    if (!$table_exists) {
        error_log('ISABEL: Table contacts manquante - création en cours');
        if (function_exists('isabel_create_contacts_table')) {
            isabel_create_contacts_table();
        }
    }
});

// ========================================
// NOUVELLES FONCTIONS POUR LE SYSTÈME MODULAIRE
// ========================================

/**
 * Vérifier si tous les customizers modulaires sont chargés
 */
function isabel_check_modular_customizers() {
    $required_functions = array(
        'isabel_register_global_customizer',
        'isabel_register_header_customizer',
        'isabel_register_home_customizer',
        'isabel_register_coaching_customizer',
        'isabel_register_vae_customizer',
        'isabel_register_hypno_customizer',
        'isabel_register_consultation_customizer',
        'isabel_register_footer_customizer',
        'isabel_register_modal_customizer',
        'isabel_register_qualiopi_customizer'
    );
    
    $missing = array();
    foreach ($required_functions as $function) {
        if (!function_exists($function)) {
            $missing[] = $function;
        }
    }
    
    if (!empty($missing)) {
        error_log('ISABEL: Customizers manquants: ' . implode(', ', $missing));
        return false;
    }
    
    return true;
}

/**
 * Fonction d'aide pour créer les dossiers du système modulaire
 */
function isabel_create_customizer_directories() {
    $customizer_dir = get_template_directory() . '/inc/customizer';
    
    if (!file_exists($customizer_dir)) {
        wp_mkdir_p($customizer_dir);
        error_log('ISABEL: Dossier customizer créé: ' . $customizer_dir);
    }
    
    // Vérifier que tous les fichiers customizer existent
    $required_files = array(
        'customizer-global.php',
        'customizer-header.php',
        'customizer-home.php',
        'customizer-coaching.php',
        'customizer-vae.php',
        'customizer-hypno.php',
        'customizer-consultation.php',
        'customizer-footer.php',
        'customizer-modal.php',
        'customizer-qualiopi.php'
    );
    
    $missing_files = array();
    foreach ($required_files as $file) {
        if (!file_exists($customizer_dir . '/' . $file)) {
            $missing_files[] = $file;
        }
    }
    
    if (!empty($missing_files)) {
        error_log('ISABEL: Fichiers customizer manquants: ' . implode(', ', $missing_files));
    }
    
    return empty($missing_files);
}

// Vérifier l'intégrité du système modulaire au chargement
add_action('after_setup_theme', function() {
    if (defined('WP_DEBUG') && WP_DEBUG) {
        isabel_create_customizer_directories();
        isabel_check_modular_customizers();
    }
});

// ========================================
// MIGRATION ET COMPATIBILITÉ
// ========================================

/**
 * Fonction de migration des anciens settings vers les nouveaux éditeurs Word-like
 */
function isabel_migrate_to_modular_customizers() {
    // Cette fonction peut être appelée pour migrer automatiquement
    // les anciens réglages vers les nouveaux éditeurs Word-like
    
    $migrations = array(
        // Hero section
        'isabel_main_name' => 'isabel_main_name_word',
        'isabel_subtitle' => 'isabel_subtitle_word',
        'isabel_intro_text' => 'isabel_intro_text_word',
        
        // Header
        'isabel_header_name' => 'isabel_header_name_word',
        'isabel_header_subtitle' => 'isabel_header_subtitle_word',
        
        // Services
        'isabel_services_title' => 'isabel_services_title_word',
        'isabel_services_subtitle' => 'isabel_services_subtitle_word',
        
        // CTA
        'isabel_cta_title' => 'isabel_cta_title_word',
        'isabel_cta_text' => 'isabel_cta_text_word',
        
        // Modal
        'isabel_form_title' => 'isabel_modal_title_word',
        'isabel_form_subtitle' => 'isabel_modal_subtitle_word',
        
        // Footer
        'isabel_footer_name' => 'isabel_footer_name_word',
        'isabel_footer_description' => 'isabel_footer_description_word'
    );
    
    $migrated = 0;
    foreach ($migrations as $old_setting => $new_setting) {
        $old_value = get_theme_mod($old_setting, '');
        $new_value = get_theme_mod($new_setting, '');
        
        // Si nouveau vide et ancien rempli, migrer
        if (empty($new_value) && !empty($old_value)) {
            // Convertir le texte simple en HTML formaté
            $html_value = '<p>' . esc_html($old_value) . '</p>';
            set_theme_mod($new_setting, $html_value);
            $migrated++;
        }
    }
    
    if ($migrated > 0) {
        error_log("ISABEL: Migration effectuée - {$migrated} paramètres migrés vers les éditeurs Word-like");
    }
    
    return $migrated;
}

// Décommenter la ligne suivante pour activer la migration automatique
// add_action('after_setup_theme', 'isabel_migrate_to_modular_customizers');

/**
 * Interface d'admin pour la migration
 */
function isabel_admin_migration_notice() {
    // Vérifier s'il y a des anciens paramètres à migrer
    $old_settings = array('isabel_main_name', 'isabel_subtitle', 'isabel_intro_text');
    $has_old_data = false;
    
    foreach ($old_settings as $setting) {
        if (!empty(get_theme_mod($setting, ''))) {
            $has_old_data = true;
            break;
        }
    }
    
    if ($has_old_data && current_user_can('manage_options')) {
        ?>
        <div class="notice notice-info is-dismissible">
            <p><strong>🔄 Migration disponible :</strong> Des anciens paramètres de personnalisation ont été détectés. 
            <a href="<?php echo admin_url('admin.php?page=isabel-settings&migrate=1'); ?>">Cliquez ici pour les migrer vers les nouveaux éditeurs Word-like</a>.</p>
        </div>
        <?php
    }
}
add_action('admin_notices', 'isabel_admin_migration_notice');

// Traiter la migration depuis l'admin
add_action('admin_init', function() {
    if (isset($_GET['migrate']) && $_GET['migrate'] == '1' && current_user_can('manage_options')) {
        $migrated = isabel_migrate_to_modular_customizers();
        
        if ($migrated > 0) {
            add_action('admin_notices', function() use ($migrated) {
                ?>
                <div class="notice notice-success is-dismissible">
                    <p><strong>✅ Migration réussie :</strong> <?php echo $migrated; ?> paramètres ont été migrés vers les nouveaux éditeurs Word-like.</p>
                </div>
                <?php
            });
        }
    }
});

?>