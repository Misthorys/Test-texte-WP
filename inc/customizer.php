<?php
// Empêcher l'accès direct au fichier
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Customizer PRINCIPAL - VERSION MODULAIRE
 * Charge tous les customizers spécialisés par page
 */

// ========================================
// INCLUSION DES CUSTOMIZERS SPÉCIALISÉS
// ========================================

// Customizer global (typographie, couleurs, images)
require_once get_template_directory() . '/inc/customizer/customizer-global.php';

// Customizer pour l'en-tête
require_once get_template_directory() . '/inc/customizer/customizer-header.php';

// Customizer pour la page d'accueil
require_once get_template_directory() . '/inc/customizer/customizer-home.php';

// Customizer pour la page Coaching Personnel
require_once get_template_directory() . '/inc/customizer/customizer-coaching.php';

// Customizer pour la page VAE
require_once get_template_directory() . '/inc/customizer/customizer-vae.php';

// Customizer pour la page Hypnocoaching
require_once get_template_directory() . '/inc/customizer/customizer-hypno.php';

// Customizer pour la page Consultation Découverte
require_once get_template_directory() . '/inc/customizer/customizer-consultation.php';

// Customizer pour le footer
require_once get_template_directory() . '/inc/customizer/customizer-footer.php';

// Customizer pour la modal/formulaire
require_once get_template_directory() . '/inc/customizer/customizer-modal.php';

// Customizer pour Qualiopi
require_once get_template_directory() . '/inc/customizer/customizer-qualiopi.php';

// ========================================
// CLASSE PRINCIPALE WORD EDITOR
// ========================================

/**
 * Contrôle personnalisé Word-like pour le customizer
 */
class Isabel_Word_Editor_Control extends WP_Customize_Control {
    public $type = 'isabel_word_editor';
    public $editor_height = '200px';
    public $show_formatting_bar = true;
    public $allowed_formats = array();
    
    public function __construct($manager, $id, $args = array()) {
        parent::__construct($manager, $id, $args);
        
        // Options par défaut pour l'éditeur
        $this->allowed_formats = array_merge(array(
            'bold', 'italic', 'underline', 'strikethrough',
            'fontSize', 'fontFamily', 'textColor', 'backgroundColor',
            'alignLeft', 'alignCenter', 'alignRight', 'alignJustify',
            'bulletList', 'numberedList', 'indent', 'outdent',
            'link', 'removeFormat', 'undo', 'redo'
        ), $this->allowed_formats);
    }
    
    public function render_content() {
        ?>
        <div class="isabel-word-editor-container">
            <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
            
            <?php if (!empty($this->description)): ?>
                <span class="description customize-control-description"><?php echo $this->description; ?></span>
            <?php endif; ?>
            
            <!-- Barre d'outils style Word -->
            <div class="isabel-word-toolbar">
                <!-- Groupe Police -->
                <div class="toolbar-group">
                    <select class="font-family-selector" data-command="fontName">
                        <option value="Arial">Arial</option>
                        <option value="Times New Roman">Times New Roman</option>
                        <option value="Calibri">Calibri</option>
                        <option value="Georgia">Georgia</option>
                        <option value="Verdana">Verdana</option>
                        <option value="Roboto">Roboto</option>
                        <option value="Open Sans">Open Sans</option>
                        <option value="Montserrat">Montserrat</option>
                    </select>
                    
                    <select class="font-size-selector" data-command="fontSize">
                        <option value="1">8pt</option>
                        <option value="2">10pt</option>
                        <option value="3">12pt</option>
                        <option value="4">14pt</option>
                        <option value="5">18pt</option>
                        <option value="6">24pt</option>
                        <option value="7">36pt</option>
                    </select>
                </div>
                
                <!-- Séparateur -->
                <div class="toolbar-separator"></div>
                
                <!-- Groupe Formatage -->
                <div class="toolbar-group">
                    <button type="button" class="toolbar-btn" data-command="bold" title="Gras (Ctrl+B)">
                        <strong>G</strong>
                    </button>
                    <button type="button" class="toolbar-btn" data-command="italic" title="Italique (Ctrl+I)">
                        <em>I</em>
                    </button>
                    <button type="button" class="toolbar-btn" data-command="underline" title="Souligné (Ctrl+U)">
                        <u>S</u>
                    </button>
                    <button type="button" class="toolbar-btn" data-command="strikeThrough" title="Barré">
                        <s>B</s>
                    </button>
                </div>
                
                <!-- Séparateur -->
                <div class="toolbar-separator"></div>
                
                <!-- Groupe Couleurs -->
                <div class="toolbar-group">
                    <div class="color-picker-container">
                        <button type="button" class="toolbar-btn color-text-btn" title="Couleur du texte">
                            <span class="text-icon">A</span>
                            <span class="color-bar" style="background-color: #000000;"></span>
                        </button>
                        <input type="color" class="color-picker text-color-picker" value="#000000">
                    </div>
                    
                    <div class="color-picker-container">
                        <button type="button" class="toolbar-btn color-bg-btn" title="Couleur de fond">
                            <span class="highlight-icon">A</span>
                            <span class="color-bar" style="background-color: #ffff00;"></span>
                        </button>
                        <input type="color" class="color-picker bg-color-picker" value="#ffff00">
                    </div>
                </div>
                
                <!-- Séparateur -->
                <div class="toolbar-separator"></div>
                
                <!-- Groupe Alignement -->
                <div class="toolbar-group">
                    <button type="button" class="toolbar-btn" data-command="justifyLeft" title="Aligner à gauche">
                        ≡
                    </button>
                    <button type="button" class="toolbar-btn" data-command="justifyCenter" title="Centrer">
                        ≡
                    </button>
                    <button type="button" class="toolbar-btn" data-command="justifyRight" title="Aligner à droite">
                        ≡
                    </button>
                    <button type="button" class="toolbar-btn" data-command="justifyFull" title="Justifier">
                        ≡
                    </button>
                </div>
                
                <!-- Séparateur -->
                <div class="toolbar-separator"></div>
                
                <!-- Groupe Listes -->
                <div class="toolbar-group">
                    <button type="button" class="toolbar-btn" data-command="insertUnorderedList" title="Puces">
                        •
                    </button>
                    <button type="button" class="toolbar-btn" data-command="insertOrderedList" title="Numérotation">
                        1.
                    </button>
                    <button type="button" class="toolbar-btn" data-command="indent" title="Augmenter le retrait">
                        →
                    </button>
                    <button type="button" class="toolbar-btn" data-command="outdent" title="Réduire le retrait">
                        ←
                    </button>
                </div>
                
                <!-- Séparateur -->
                <div class="toolbar-separator"></div>
                
                <!-- Groupe Actions -->
                <div class="toolbar-group">
                    <button type="button" class="toolbar-btn" data-command="createLink" title="Insérer un lien">
                        🔗
                    </button>
                    <button type="button" class="toolbar-btn" data-command="removeFormat" title="Effacer la mise en forme">
                        ⌫
                    </button>
                    <button type="button" class="toolbar-btn" data-command="undo" title="Annuler (Ctrl+Z)">
                        ↶
                    </button>
                    <button type="button" class="toolbar-btn" data-command="redo" title="Rétablir (Ctrl+Y)">
                        ↷
                    </button>
                </div>
            </div>
            
            <!-- Éditeur de contenu -->
            <div class="isabel-word-editor" 
                 contenteditable="true" 
                 id="isabel-editor-<?php echo $this->id; ?>"
                 data-setting="<?php echo $this->id; ?>"
                 style="height: <?php echo esc_attr($this->editor_height); ?>;">
                <?php echo wp_kses_post($this->value()); ?>
            </div>
            
            <!-- Barre de statut style Word -->
            <div class="isabel-word-statusbar">
                <span class="word-count">0 mots</span>
                <span class="char-count">0 caractères</span>
                <span class="zoom-control">
                    <button type="button" class="zoom-btn" data-zoom="smaller">-</button>
                    <span class="zoom-level">100%</span>
                    <button type="button" class="zoom-btn" data-zoom="bigger">+</button>
                </span>
            </div>
            
            <!-- Aperçu en temps réel -->
            <div class="isabel-word-preview">
                <h4>Aperçu :</h4>
                <div class="preview-content" id="preview-<?php echo $this->id; ?>">
                    <?php echo wp_kses_post($this->value()); ?>
                </div>
            </div>
        </div>
        <?php
    }
}

// ========================================
// FONCTIONS UTILITAIRES GLOBALES
// ========================================

/**
 * Fonction pour ajouter un éditeur Word-like au customizer
 */
function isabel_add_word_editor($wp_customize, $setting_id, $label, $default_value, $section, $options = array()) {
    
    // Paramètres par défaut
    $defaults = array(
        'description' => '',
        'editor_height' => '200px',
        'priority' => 10,
        'allowed_formats' => array(),
        'transport' => 'postMessage'
    );
    $options = array_merge($defaults, $options);
    
    // Ajouter le réglage
    $wp_customize->add_setting($setting_id, array(
        'default' => $default_value,
        'sanitize_callback' => 'isabel_sanitize_html_content',
        'transport' => $options['transport']
    ));
    
    // Ajouter le contrôle
    $wp_customize->add_control(new Isabel_Word_Editor_Control($wp_customize, $setting_id, array(
        'label' => $label,
        'description' => $options['description'],
        'section' => $section,
        'priority' => $options['priority'],
        'editor_height' => $options['editor_height'],
        'allowed_formats' => $options['allowed_formats']
    )));
}

/**
 * Fonction de nettoyage HTML pour les contenus de l'éditeur
 */
function isabel_sanitize_html_content($input) {
    // Balises autorisées pour l'éditeur Word-like
    $allowed_tags = array(
        'p' => array('style' => array(), 'class' => array()),
        'span' => array('style' => array(), 'class' => array()),
        'strong' => array(),
        'b' => array(),
        'em' => array(),
        'i' => array(),
        'u' => array(),
        's' => array(),
        'strike' => array(),
        'ul' => array('style' => array()),
        'ol' => array('style' => array()),
        'li' => array('style' => array()),
        'a' => array('href' => array(), 'title' => array(), 'target' => array()),
        'br' => array(),
        'div' => array('style' => array(), 'class' => array()),
        'h1' => array('style' => array()),
        'h2' => array('style' => array()),
        'h3' => array('style' => array()),
        'h4' => array('style' => array()),
        'h5' => array('style' => array()),
        'h6' => array('style' => array())
    );
    
    return wp_kses($input, $allowed_tags);
}

// ========================================
// ENREGISTREMENT DES SCRIPTS ET STYLES
// ========================================

function isabel_enqueue_word_editor() {
    // TinyMCE (éditeur WordPress)
    wp_enqueue_script('wp-tinymce');
    wp_enqueue_script('editor');
    
    // Scripts personnalisés pour l'éditeur Word-like
    wp_enqueue_script(
        'isabel-word-editor',
        get_template_directory_uri() . '/js/word-editor.js',
        array('jquery', 'wp-tinymce'),
        '1.0.0',
        true
    );
    
    // Styles pour l'interface Word-like
    wp_enqueue_style(
        'isabel-word-editor-style',
        get_template_directory_uri() . '/css/word-editor.css',
        array(),
        '1.0.0'
    );
    
    // Configuration JavaScript
    wp_localize_script('isabel-word-editor', 'isabelWordEditor', array(
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('isabel_word_editor'),
        'strings' => array(
            'bold' => 'Gras (Ctrl+B)',
            'italic' => 'Italique (Ctrl+I)',
            'underline' => 'Souligné (Ctrl+U)',
            'fontSize' => 'Taille de police',
            'fontFamily' => 'Police',
            'textColor' => 'Couleur du texte',
            'backgroundColor' => 'Couleur de fond',
            'alignment' => 'Alignement',
            'save' => 'Sauvegarder',
            'cancel' => 'Annuler'
        )
    ));
}
add_action('customize_controls_enqueue_scripts', 'isabel_enqueue_word_editor');

// ========================================
// FONCTION PRINCIPALE D'ENREGISTREMENT
// ========================================

/**
 * Configuration principale du customizer - VERSION MODULAIRE
 */
function isabel_customize_register($wp_customize) {
    // Les customizers spécialisés s'occupent de leurs propres sections
    // Cette fonction reste pour la compatibilité
    
    // Charger les customizers dans l'ordre logique
    isabel_register_global_customizer($wp_customize);
    isabel_register_header_customizer($wp_customize);
    isabel_register_home_customizer($wp_customize);
    isabel_register_coaching_customizer($wp_customize);
    isabel_register_vae_customizer($wp_customize);
    isabel_register_hypno_customizer($wp_customize);
    isabel_register_consultation_customizer($wp_customize);
    isabel_register_footer_customizer($wp_customize);
    isabel_register_modal_customizer($wp_customize);
    isabel_register_qualiopi_customizer($wp_customize);
}

// ========================================
// FONCTIONS DE COMPATIBILITÉ
// ========================================

/**
 * Fonction pour récupérer le contenu des éditeurs Word-like
 */
function isabel_get_word_editor_content($setting_id, $default = '') {
    $content = get_theme_mod($setting_id, $default);
    return wp_kses_post($content);
}

/**
 * Fonction pour afficher le contenu des éditeurs Word-like
 */
function isabel_display_word_editor_content($setting_id, $default = '') {
    echo isabel_get_word_editor_content($setting_id, $default);
}

/**
 * Fonction de compatibilité pour les anciens settings
 */
function isabel_get_word_or_regular_content($word_setting, $regular_setting, $default = '') {
    // Priorité aux éditeurs Word-like
    $word_content = get_theme_mod($word_setting, '');
    if (!empty($word_content)) {
        return wp_kses_post($word_content);
    }
    
    // Fallback vers l'ancien système
    return esc_html(get_theme_mod($regular_setting, $default));
}

// ========================================
// INITIALISATION
// ========================================

// Enregistrer le customizer principal
add_action('customize_register', 'isabel_customize_register');

// Script pour le preview en temps réel
function isabel_customize_preview_js() {
    wp_enqueue_script(
        'isabel-customizer-preview',
        get_template_directory_uri() . '/js/customizer-preview.js',
        array('customize-preview'),
        '1.0.0',
        true
    );
}
add_action('customize_preview_init', 'isabel_customize_preview_js');

// CSS dynamique pour les couleurs personnalisées
function isabel_dynamic_css() {
    $primary_color = get_theme_mod('isabel_primary_color', '#e4a7f5');
    $secondary_color = get_theme_mod('isabel_secondary_color', '#c47dd9');
    ?>
    <style type="text/css">
    :root {
        --rose-500: <?php echo esc_attr($primary_color); ?>;
        --rose-700: <?php echo esc_attr($secondary_color); ?>;
    }
    </style>
    <?php
}
add_action('wp_head', 'isabel_dynamic_css');

?>