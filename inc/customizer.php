<?php
// Empêcher l'accès direct au fichier
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Customizer COMPLET avec éditeurs Word-like pour TOUTES LES PAGES
 * Interface identique à Microsoft Word pour modifier TOUS les textes du site
 * VERSION RÉVOLUTIONNAIRE COMPLÈTE
 */

// Enregistrer les scripts et styles pour l'éditeur Word-like
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
        
        <!-- Styles inline pour cet éditeur -->
        <style>
            #isabel-editor-<?php echo $this->id; ?> {
                font-family: <?php echo esc_attr($this->get_font_family()); ?>;
                font-size: <?php echo esc_attr($this->get_font_size()); ?>;
            }
        </style>
        <?php
    }
    
    private function get_font_family() {
        return get_theme_mod('isabel_main_font_family', 'Arial, sans-serif');
    }
    
    private function get_font_size() {
        return get_theme_mod('isabel_base_font_size', '14') . 'px';
    }
}

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

/**
 * Configuration principale du customizer avec éditeurs Word-like POUR TOUTES LES PAGES
 */
function isabel_customize_register($wp_customize) {
    
    // ===== SECTION TYPOGRAPHIE GLOBALE =====
    $wp_customize->add_section('isabel_typography_section', array(
        'title' => '🎨 Typographie Globale',
        'priority' => 25,
        'description' => 'Configurez les polices de base de votre site'
    ));
    
    // Police principale
    $wp_customize->add_setting('isabel_main_font_family', array(
        'default' => 'Arial, sans-serif',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('isabel_main_font_family', array(
        'label' => 'Police principale du site',
        'section' => 'isabel_typography_section',
        'type' => 'select',
        'choices' => array(
            'Arial, sans-serif' => 'Arial',
            'Times New Roman, serif' => 'Times New Roman',
            'Calibri, sans-serif' => 'Calibri',
            'Georgia, serif' => 'Georgia',
            'Verdana, sans-serif' => 'Verdana',
            'Roboto, sans-serif' => 'Roboto',
            'Open Sans, sans-serif' => 'Open Sans',
            'Montserrat, sans-serif' => 'Montserrat'
        ),
    ));
    
    // Taille de police de base
    $wp_customize->add_setting('isabel_base_font_size', array(
        'default' => '16',
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control('isabel_base_font_size', array(
        'label' => 'Taille de police de base (px)',
        'section' => 'isabel_typography_section',
        'type' => 'range',
        'input_attrs' => array(
            'min' => 12,
            'max' => 24,
            'step' => 1,
        ),
    ));

    // ===== SECTION IMAGES =====
    $wp_customize->add_section('isabel_images_section', array(
        'title' => '📷 Images du Site',
        'priority' => 26,
        'description' => 'Gérez toutes les images de votre site'
    ));
    
    // Image de profil principale
    $wp_customize->add_setting('isabel_profile_image', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'isabel_profile_image', array(
        'label' => 'Image de profil principale',
        'description' => 'Photo affichée sur la page d\'accueil (format carré recommandé)',
        'section' => 'isabel_images_section',
        'priority' => 10,
    )));
    
    // Image de profil mobile
    $wp_customize->add_setting('isabel_mobile_profile_image', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'isabel_mobile_profile_image', array(
        'label' => 'Image de profil mobile',
        'description' => 'Photo spécifique pour les mobiles (optionnel)',
        'section' => 'isabel_images_section',
        'priority' => 20,
    )));
    
    // Image de fond hero
    $wp_customize->add_setting('isabel_hero_background_image', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'isabel_hero_background_image', array(
        'label' => 'Image de fond section héro',
        'description' => 'Image de fond pour la section d\'accueil',
        'section' => 'isabel_images_section',
        'priority' => 30,
    )));
    
    // Logo header
    $wp_customize->add_setting('isabel_header_logo', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'isabel_header_logo', array(
        'label' => 'Logo du header',
        'description' => 'Logo affiché dans l\'en-tête',
        'section' => 'isabel_images_section',
        'priority' => 40,
    )));

    // ===== SECTION HEADER AVEC ÉDITEURS WORD-LIKE =====
    $wp_customize->add_section('isabel_header_section', array(
        'title' => '✏️ Header - Éditeur Word',
        'priority' => 28,
        'description' => 'Modifiez les textes du header avec l\'éditeur Word'
    ));
    
    // Nom dans le header
    isabel_add_word_editor(
        $wp_customize,
        'isabel_header_name_word',
        '📝 Nom Header (Éditeur Word)',
        '<div style="font-weight: bold; color: #c47dd9;">Isabel GONCALVES</div>',
        'isabel_header_section',
        array('editor_height' => '80px')
    );
    
    // Sous-titre header
    isabel_add_word_editor(
        $wp_customize,
        'isabel_header_subtitle_word',
        '📝 Sous-titre Header (Éditeur Word)',
        '<div style="font-size: 0.9rem; color: #6b5b73;">Formatrice &amp; Coach Certifiée</div>',
        'isabel_header_section',
        array('editor_height' => '80px')
    );

    // ===== SECTION HERO AVEC ÉDITEURS WORD-LIKE =====
    $wp_customize->add_section('isabel_hero_section', array(
        'title' => '✏️ Section d\'Accueil - Éditeur Word',
        'priority' => 30,
        'description' => 'Modifiez vos textes avec un éditeur identique à Microsoft Word'
    ));
    
    // Badge hero
    isabel_add_word_editor(
        $wp_customize,
        'isabel_hero_badge_word',
        '📝 Badge Hero (Éditeur Word)',
        '<span style="font-weight: bold; color: #c47dd9;">✨ Coach certifiée</span>',
        'isabel_hero_section',
        array('editor_height' => '80px')
    );
    
    // Titre principal avec éditeur Word-like
    isabel_add_word_editor(
        $wp_customize,
        'isabel_main_name_word',
        '📝 Titre Principal (Éditeur Word)',
        '<h1 style="font-size: 48px; font-weight: bold; color: #2d1b3d;">Isabel GONCALVES</h1>',
        'isabel_hero_section',
        array(
            'description' => 'Utilisez la barre d\'outils pour formater votre titre principal comme dans Word',
            'editor_height' => '120px'
        )
    );
    
    // Sous-titre avec éditeur Word-like
    isabel_add_word_editor(
        $wp_customize,
        'isabel_subtitle_word',
        '📝 Sous-titre (Éditeur Word)',
        '<p style="font-size: 24px; color: #2d1b3d; font-style: italic;">Coach Certifiée &amp; Hypnocoach</p>',
        'isabel_hero_section',
        array(
            'description' => 'Formatez votre sous-titre avec toutes les options de Word',
            'editor_height' => '100px'
        )
    );
    
    // Texte d'introduction avec éditeur Word-like
    isabel_add_word_editor(
        $wp_customize,
        'isabel_intro_text_word',
        '📝 Texte d\'Introduction (Éditeur Word)',
        '<p style="font-size: 18px; line-height: 1.7; color: #2d1b3d;">Bienvenue dans votre espace de <strong>transformation personnelle</strong> ! Je vous accompagne avec <em>bienveillance</em> vers l\'épanouissement de votre potentiel grâce au coaching, à la VAE et à l\'hypnocoaching.</p>',
        'isabel_hero_section',
        array(
            'description' => 'Rédigez votre introduction avec formatage riche (gras, italique, couleurs, etc.)',
            'editor_height' => '150px'
        )
    );
    
    // Texte du bouton principal
    isabel_add_word_editor(
        $wp_customize,
        'isabel_main_button_word',
        '📝 Texte Bouton Principal (Éditeur Word)',
        '<span style="font-weight: bold;">🚀 Prendre rendez-vous</span>',
        'isabel_hero_section',
        array('editor_height' => '80px')
    );

    // ===== SECTION SERVICES AVEC ÉDITEURS WORD-LIKE =====
    $wp_customize->add_section('isabel_services_section', array(
        'title' => '✏️ Services - Éditeur Word',
        'priority' => 32,
        'description' => 'Modifiez vos services avec l\'éditeur Word intégré'
    ));
    
    // Titre section services
    isabel_add_word_editor(
        $wp_customize,
        'isabel_services_title_word',
        '📝 Titre Section Services',
        '<h2 style="font-size: 36px; font-weight: bold; color: #2d1b3d; text-align: center;">Mes Accompagnements Sur Mesure</h2>',
        'isabel_services_section',
        array(
            'description' => 'Titre principal de votre section services',
            'editor_height' => '100px'
        )
    );
    
    // Sous-titre section services
    isabel_add_word_editor(
        $wp_customize,
        'isabel_services_subtitle_word',
        '📝 Sous-titre Section Services',
        '<p style="font-size: 18px; color: #6b5b73; text-align: center; font-style: italic;">Quatre approches complémentaires pour révéler votre potentiel et atteindre vos objectifs personnels et professionnels.</p>',
        'isabel_services_section',
        array(
            'description' => 'Description de votre section services',
            'editor_height' => '120px'
        )
    );
    
    // Services individuels avec éditeurs Word-like
    $services_defaults = array(
        1 => array(
            'title' => '<h3 style="font-size: 22px; font-weight: bold; color: #2d1b3d;">Coaching Personnel</h3>',
            'desc' => '<p style="font-size: 16px; color: #6b5b73; line-height: 1.6;">Révélez votre <strong>potentiel</strong>, clarifiez vos objectifs et transformez votre vie avec un accompagnement personnalisé et des outils concrets.</p>'
        ),
        2 => array(
            'title' => '<h3 style="font-size: 22px; font-weight: bold; color: #2d1b3d;">Accompagnement VAE</h3>',
            'desc' => '<p style="font-size: 16px; color: #6b5b73; line-height: 1.6;">Valorisez votre <em>expérience</em> et obtenez une reconnaissance officielle de vos compétences grâce à un accompagnement expert VAE.</p>'
        ),
        3 => array(
            'title' => '<h3 style="font-size: 22px; font-weight: bold; color: #2d1b3d;">Hypnocoaching</h3>',
            'desc' => '<p style="font-size: 16px; color: #6b5b73; line-height: 1.6;">Libérez-vous de vos <u>blocages</u> en profondeur en combinant les bienfaits de l\'hypnose thérapeutique et du coaching de vie.</p>'
        ),
        4 => array(
            'title' => '<h3 style="font-size: 22px; font-weight: bold; color: #2d1b3d;">Consultation Découverte</h3>',
            'desc' => '<p style="font-size: 16px; color: #6b5b73; line-height: 1.6;">Première rencontre <span style="background-color: #ffff00;">gratuite</span> pour faire connaissance, comprendre vos besoins et définir ensemble le meilleur accompagnement pour vous.</p>'
        )
    );
    
    foreach ($services_defaults as $i => $service) {
        // Titre du service
        isabel_add_word_editor(
            $wp_customize,
            "isabel_service{$i}_title_word",
            "📝 Service $i - Titre",
            $service['title'],
            'isabel_services_section',
            array(
                'description' => "Titre du service $i avec formatage Word",
                'editor_height' => '80px'
            )
        );
        
        // Description du service  
        isabel_add_word_editor(
            $wp_customize,
            "isabel_service{$i}_desc_word",
            "📝 Service $i - Description",
            $service['desc'],
            'isabel_services_section',
            array(
                'description' => "Description détaillée du service $i",
                'editor_height' => '120px'
            )
        );
    }

    // ===== SECTION TÉMOIGNAGES AVEC ÉDITEUR WORD-LIKE =====
    $wp_customize->add_section('isabel_testimonials_section', array(
        'title' => '✏️ Témoignages - Éditeur Word',
        'priority' => 33,
    ));
    
    isabel_add_word_editor(
        $wp_customize,
        'isabel_testimonials_title_word',
        '📝 Titre Section Témoignages',
        '<h2 style="font-size: 36px; font-weight: bold; color: #2d1b3d; text-align: center;">Ce que disent mes <span style="color: #c47dd9;">clients</span></h2>',
        'isabel_testimonials_section',
        array('editor_height' => '100px')
    );
    
    isabel_add_word_editor(
        $wp_customize,
        'isabel_testimonials_subtitle_word',
        '📝 Sous-titre Témoignages',
        '<p style="font-size: 18px; color: #6b5b73; text-align: center; font-style: italic;">Découvrez les témoignages de personnes qui ont <strong>transformé leur vie</strong> grâce à un accompagnement personnalisé.</p>',
        'isabel_testimonials_section',
        array('editor_height' => '100px')
    );

    // ===== SECTION CTA AVEC ÉDITEUR WORD-LIKE =====
    $wp_customize->add_section('isabel_cta_section', array(
        'title' => '✏️ Call-to-Action - Éditeur Word',
        'priority' => 34,
        'description' => 'Créez un appel à l\'action percutant avec l\'éditeur Word'
    ));
    
    // Titre CTA
    isabel_add_word_editor(
        $wp_customize,
        'isabel_cta_title_word',
        '📝 Titre Call-to-Action',
        '<h2 style="font-size: 32px; font-weight: bold; color: #ffffff; text-align: center;">Prêt(e) à <span style="color: #ffff00;">Commencer</span> Votre Transformation ?</h2>',
        'isabel_cta_section',
        array(
            'description' => 'Titre principal de votre appel à l\'action',
            'editor_height' => '100px'
        )
    );
    
    // Texte CTA
    isabel_add_word_editor(
        $wp_customize,
        'isabel_cta_text_word',
        '📝 Texte Call-to-Action',
        '<p style="font-size: 18px; color: #ffffff; text-align: center; line-height: 1.6;"><strong>Contactez-moi dès maintenant</strong> pour discuter de vos objectifs et découvrir comment je peux vous accompagner dans votre <em>transformation</em>.</p>',
        'isabel_cta_section',
        array(
            'description' => 'Texte convaincant pour votre appel à l\'action',
            'editor_height' => '120px'
        )
    );
    
    // Bouton CTA
    isabel_add_word_editor(
        $wp_customize,
        'isabel_cta_button_word',
        '📝 Texte Bouton CTA',
        '<span style="font-weight: bold;">Prendre rendez-vous</span>',
        'isabel_cta_section',
        array('editor_height' => '80px')
    );

    // ===== SECTION MODAL FORMULAIRE AVEC ÉDITEUR WORD-LIKE =====
    $wp_customize->add_section('isabel_modal_section', array(
        'title' => '✏️ Modal Formulaire - Éditeur Word',
        'priority' => 35,
        'description' => 'Personnalisez le formulaire de contact avec l\'éditeur Word'
    ));
    
    // Titre modal
    isabel_add_word_editor(
        $wp_customize,
        'isabel_modal_title_word',
        '📝 Titre Modal',
        '<h2 style="font-size: 24px; font-weight: bold; color: #2d1b3d;">Réservez votre rendez-vous</h2>',
        'isabel_modal_section',
        array('editor_height' => '80px')
    );
    
    // Sous-titre modal
    isabel_add_word_editor(
        $wp_customize,
        'isabel_modal_subtitle_word',
        '📝 Sous-titre Modal',
        '<p style="color: #6b5b73; font-style: italic;">Première consultation personnalisée</p>',
        'isabel_modal_section',
        array('editor_height' => '80px')
    );
    
    // Note du formulaire
    isabel_add_word_editor(
        $wp_customize,
        'isabel_modal_note_word',
        '📝 Note Formulaire',
        '<p style="background: #f8d7ff; padding: 15px; border-radius: 8px; color: #c47dd9; font-weight: 500;">💼 Première consultation pour faire connaissance et définir vos besoins ensemble.</p>',
        'isabel_modal_section',
        array('editor_height' => '100px')
    );

    // ===== SECTION QUALIOPI AVEC ÉDITEUR WORD-LIKE =====
    $wp_customize->add_section('isabel_qualiopi_section', array(
        'title' => '✏️ Certification Qualiopi - Éditeur Word',
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
        'section' => 'isabel_qualiopi_section',
        'priority' => 10,
    )));
    
    // Titre Qualiopi
    isabel_add_word_editor(
        $wp_customize,
        'isabel_qualiopi_title_word',
        '📝 Titre Certification Qualiopi',
        '<h3 style="font-size: 20px; font-weight: bold; color: #1e40af;">Organisme de formation certifié Qualiopi</h3>',
        'isabel_qualiopi_section',
        array('editor_height' => '80px', 'priority' => 20)
    );
    
    // Description Qualiopi
    isabel_add_word_editor(
        $wp_customize,
        'isabel_qualiopi_description_word',
        '📝 Description Certification',
        '<p style="color: #475569; font-style: italic;">La certification qualité a été délivrée au titre de la catégorie d\'actions suivante : <strong>actions de formation</strong></p>',
        'isabel_qualiopi_section',
        array('editor_height' => '100px', 'priority' => 30)
    );
    
    // Numéro Qualiopi
    isabel_add_word_editor(
        $wp_customize,
        'isabel_qualiopi_number_word',
        '📝 Numéro Certification',
        '<p style="color: #1e40af; font-weight: bold;">N° de certification : 12345-QUALIOPI</p>',
        'isabel_qualiopi_section',
        array('editor_height' => '80px', 'priority' => 40)
    );

    // ===== PAGES DE SERVICES - COACHING PERSONNEL =====
    $wp_customize->add_section('isabel_coaching_section', array(
        'title' => '✏️ Page Coaching Personnel - Éditeur Word',
        'priority' => 40,
        'description' => 'Modifiez tout le contenu de la page Coaching Personnel'
    ));
    
    // Titre page coaching
    isabel_add_word_editor(
        $wp_customize,
        'isabel_coaching_title_word',
        '📝 Titre Page Coaching',
        '<h1 style="font-size: 40px; font-weight: bold; color: #ffffff;">Coaching Personnel</h1>',
        'isabel_coaching_section',
        array('editor_height' => '80px')
    );
    
    // Sous-titre coaching
    isabel_add_word_editor(
        $wp_customize,
        'isabel_coaching_subtitle_word',
        '📝 Sous-titre Coaching',
        '<p style="font-size: 20px; color: rgba(255,255,255,0.9);">Révélez votre potentiel et transformez votre vie personnelle et professionnelle</p>',
        'isabel_coaching_section',
        array('editor_height' => '100px')
    );
    
    // Introduction coaching
    isabel_add_word_editor(
        $wp_customize,
        'isabel_coaching_intro_word',
        '📝 Introduction Coaching',
        '<p style="font-size: 16px; line-height: 1.7;">Le coaching personnel est un accompagnement sur mesure qui vous aide à <strong>clarifier vos objectifs</strong>, développer votre potentiel et créer la vie que vous désirez vraiment.</p>',
        'isabel_coaching_section',
        array('editor_height' => '120px')
    );
    
    // Boxes coaching (4 boxes)
    for ($i = 1; $i <= 4; $i++) {
        // Image box coaching
        $wp_customize->add_setting("isabel_coaching_box{$i}_image", array(
            'default' => '',
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, "isabel_coaching_box{$i}_image", array(
            'label' => "Image Box Coaching $i",
            'section' => 'isabel_coaching_section',
        )));
        
        // Titre box coaching
        isabel_add_word_editor(
            $wp_customize,
            "isabel_coaching_box{$i}_title_word",
            "📝 Box Coaching $i - Titre",
            '<h3 style="font-weight: bold; color: #2d1b3d;">Titre Box ' . $i . '</h3>',
            'isabel_coaching_section',
            array('editor_height' => '80px')
        );
        
        // Texte box coaching
        isabel_add_word_editor(
            $wp_customize,
            "isabel_coaching_box{$i}_text_word",
            "📝 Box Coaching $i - Texte",
            '<p style="color: #6b5b73; line-height: 1.5;">Description de la box ' . $i . ' avec du texte personnalisable.</p>',
            'isabel_coaching_section',
            array('editor_height' => '100px')
        );
    }
    
    // Étapes coaching
    for ($i = 1; $i <= 4; $i++) {
        isabel_add_word_editor(
            $wp_customize,
            "isabel_coaching_step{$i}_word",
            "📝 Étape Coaching $i",
            '<h4 style="font-weight: bold; margin-bottom: 8px;">Étape ' . $i . '</h4><p style="color: #6b5b73;">Description de l\'étape ' . $i . ' du processus de coaching.</p>',
            'isabel_coaching_section',
            array('editor_height' => '120px')
        );
    }
    
    // CTA coaching
    isabel_add_word_editor(
        $wp_customize,
        'isabel_coaching_cta_word',
        '📝 CTA Coaching',
        '<h3 style="font-weight: bold; margin-bottom: 15px;">Prêt(e) à commencer votre transformation ?</h3><p style="margin-bottom: 20px;">Contactez-moi pour discuter de vos objectifs et découvrir comment le coaching personnel peut vous aider.</p>',
        'isabel_coaching_section',
        array('editor_height' => '150px')
    );

    // ===== PAGES DE SERVICES - VAE =====
    $wp_customize->add_section('isabel_vae_section', array(
        'title' => '✏️ Page Accompagnement VAE - Éditeur Word',
        'priority' => 41,
        'description' => 'Modifiez tout le contenu de la page VAE'
    ));
    
    // Titre page VAE
    isabel_add_word_editor(
        $wp_customize,
        'isabel_vae_title_word',
        '📝 Titre Page VAE',
        '<h1 style="font-size: 40px; font-weight: bold; color: #ffffff;">Accompagnement VAE</h1>',
        'isabel_vae_section',
        array('editor_height' => '80px')
    );
    
    // Sous-titre VAE
    isabel_add_word_editor(
        $wp_customize,
        'isabel_vae_subtitle_word',
        '📝 Sous-titre VAE',
        '<p style="font-size: 20px; color: rgba(255,255,255,0.9);">Valorisez votre expérience et obtenez une reconnaissance officielle de vos compétences</p>',
        'isabel_vae_section',
        array('editor_height' => '100px')
    );
    
    // Introduction VAE
    isabel_add_word_editor(
        $wp_customize,
        'isabel_vae_intro_word',
        '📝 Introduction VAE',
        '<p style="font-size: 16px; line-height: 1.7;">La <strong>Validation des Acquis de l\'Expérience (VAE)</strong> est un dispositif qui permet de faire reconnaître officiellement vos compétences acquises par l\'expérience professionnelle.</p>',
        'isabel_vae_section',
        array('editor_height' => '120px')
    );
    
    // Boxes VAE (4 boxes)
    for ($i = 1; $i <= 4; $i++) {
        // Image box VAE
        $wp_customize->add_setting("isabel_vae_box{$i}_image", array(
            'default' => '',
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, "isabel_vae_box{$i}_image", array(
            'label' => "Image Box VAE $i",
            'section' => 'isabel_vae_section',
        )));
        
        // Titre box VAE
        isabel_add_word_editor(
            $wp_customize,
            "isabel_vae_box{$i}_title_word",
            "📝 Box VAE $i - Titre",
            '<h3 style="font-weight: bold; color: #2d1b3d;">🎓 Titre Box VAE ' . $i . '</h3>',
            'isabel_vae_section',
            array('editor_height' => '80px')
        );
        
        // Texte box VAE
        isabel_add_word_editor(
            $wp_customize,
            "isabel_vae_box{$i}_text_word",
            "📝 Box VAE $i - Texte",
            '<p style="color: #6b5b73; line-height: 1.5;">Description de la box VAE ' . $i . ' avec du texte personnalisable.</p>',
            'isabel_vae_section',
            array('editor_height' => '100px')
        );
    }
    
    // Étapes VAE
    for ($i = 1; $i <= 4; $i++) {
        isabel_add_word_editor(
            $wp_customize,
            "isabel_vae_step{$i}_word",
            "📝 Étape VAE $i",
            '<h4 style="font-weight: bold; margin-bottom: 8px;">Étape ' . $i . ' VAE</h4><p style="color: #6b5b73;">Description de l\'étape ' . $i . ' du processus VAE.</p>',
            'isabel_vae_section',
            array('editor_height' => '120px')
        );
    }
    
    // CTA VAE
    isabel_add_word_editor(
        $wp_customize,
        'isabel_vae_cta_word',
        '📝 CTA VAE',
        '<h3 style="font-weight: bold; margin-bottom: 15px;">Prêt(e) à valoriser votre expérience ?</h3><p style="margin-bottom: 20px;">Contactez-moi pour une première évaluation de votre projet VAE.</p>',
        'isabel_vae_section',
        array('editor_height' => '150px')
    );

    // ===== PAGES DE SERVICES - HYPNOCOACHING =====
    $wp_customize->add_section('isabel_hypno_section', array(
        'title' => '✏️ Page Hypnocoaching - Éditeur Word',
        'priority' => 42,
        'description' => 'Modifiez tout le contenu de la page Hypnocoaching'
    ));
    
    // Titre page Hypno
    isabel_add_word_editor(
        $wp_customize,
        'isabel_hypno_title_word',
        '📝 Titre Page Hypnocoaching',
        '<h1 style="font-size: 40px; font-weight: bold; color: #ffffff;">Hypnocoaching</h1>',
        'isabel_hypno_section',
        array('editor_height' => '80px')
    );
    
    // Sous-titre Hypno
    isabel_add_word_editor(
        $wp_customize,
        'isabel_hypno_subtitle_word',
        '📝 Sous-titre Hypnocoaching',
        '<p style="font-size: 20px; color: rgba(255,255,255,0.9);">Libérez-vous de vos blocages en profondeur grâce à l\'alliance du coaching et de l\'hypnose</p>',
        'isabel_hypno_section',
        array('editor_height' => '100px')
    );
    
    // Introduction Hypno
    isabel_add_word_editor(
        $wp_customize,
        'isabel_hypno_intro_word',
        '📝 Introduction Hypnocoaching',
        '<p style="font-size: 16px; line-height: 1.7;">L\'<strong>hypnocoaching</strong> est une approche innovante qui combine les bienfaits du coaching traditionnel avec la puissance de l\'hypnose thérapeutique.</p>',
        'isabel_hypno_section',
        array('editor_height' => '120px')
    );
    
    // Boxes Hypno (4 boxes)
    for ($i = 1; $i <= 4; $i++) {
        // Image box Hypno
        $wp_customize->add_setting("isabel_hypno_box{$i}_image", array(
            'default' => '',
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, "isabel_hypno_box{$i}_image", array(
            'label' => "Image Box Hypnocoaching $i",
            'section' => 'isabel_hypno_section',
        )));
        
        // Titre box Hypno
        isabel_add_word_editor(
            $wp_customize,
            "isabel_hypno_box{$i}_title_word",
            "📝 Box Hypno $i - Titre",
            '<h3 style="font-weight: bold; color: #2d1b3d;">🧘 Titre Box Hypno ' . $i . '</h3>',
            'isabel_hypno_section',
            array('editor_height' => '80px')
        );
        
        // Texte box Hypno
        isabel_add_word_editor(
            $wp_customize,
            "isabel_hypno_box{$i}_text_word",
            "📝 Box Hypno $i - Texte",
            '<p style="color: #6b5b73; line-height: 1.5;">Description de la box Hypnocoaching ' . $i . ' avec du texte personnalisable.</p>',
            'isabel_hypno_section',
            array('editor_height' => '100px')
        );
    }
    
    // Étapes Hypno
    for ($i = 1; $i <= 4; $i++) {
        isabel_add_word_editor(
            $wp_customize,
            "isabel_hypno_step{$i}_word",
            "📝 Étape Hypnocoaching $i",
            '<h4 style="font-weight: bold; margin-bottom: 8px;">Étape ' . $i . ' Hypnocoaching</h4><p style="color: #6b5b73;">Description de l\'étape ' . $i . ' du processus d\'hypnocoaching.</p>',
            'isabel_hypno_section',
            array('editor_height' => '120px')
        );
    }
    
    // CTA Hypno
    isabel_add_word_editor(
        $wp_customize,
        'isabel_hypno_cta_word',
        '📝 CTA Hypnocoaching',
        '<h3 style="font-weight: bold; margin-bottom: 15px;">Prêt(e) à libérer votre potentiel ?</h3><p style="margin-bottom: 20px;">Découvrez la puissance de l\'hypnocoaching lors d\'une consultation.</p>',
        'isabel_hypno_section',
        array('editor_height' => '150px')
    );

    // ===== PAGES DE SERVICES - CONSULTATION DÉCOUVERTE =====
    $wp_customize->add_section('isabel_consultation_section', array(
        'title' => '✏️ Page Consultation Découverte - Éditeur Word',
        'priority' => 43,
        'description' => 'Modifiez tout le contenu de la page Consultation Découverte'
    ));
    
    // Titre page Consultation
    isabel_add_word_editor(
        $wp_customize,
        'isabel_consultation_title_word',
        '📝 Titre Page Consultation',
        '<h1 style="font-size: 40px; font-weight: bold; color: #ffffff;">Consultation Découverte</h1>',
        'isabel_consultation_section',
        array('editor_height' => '80px')
    );
    
    // Sous-titre Consultation
    isabel_add_word_editor(
        $wp_customize,
        'isabel_consultation_subtitle_word',
        '📝 Sous-titre Consultation',
        '<p style="font-size: 20px; color: rgba(255,255,255,0.9);">Première rencontre gratuite pour définir ensemble votre parcours</p>',
        'isabel_consultation_section',
        array('editor_height' => '100px')
    );
    
    // Introduction Consultation
    isabel_add_word_editor(
        $wp_customize,
        'isabel_consultation_intro_word',
        '📝 Introduction Consultation',
        '<p style="font-size: 16px; line-height: 1.7;">La <strong>consultation découverte</strong> est un moment privilégié pour faire connaissance et comprendre vos besoins spécifiques.</p>',
        'isabel_consultation_section',
        array('editor_height' => '120px')
    );
    
    // Boxes Consultation (4 boxes)
    for ($i = 1; $i <= 4; $i++) {
        // Image box Consultation
        $wp_customize->add_setting("isabel_consultation_box{$i}_image", array(
            'default' => '',
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, "isabel_consultation_box{$i}_image", array(
            'label' => "Image Box Consultation $i",
            'section' => 'isabel_consultation_section',
        )));
        
        // Titre box Consultation
        isabel_add_word_editor(
            $wp_customize,
            "isabel_consultation_box{$i}_title_word",
            "📝 Box Consultation $i - Titre",
            '<h3 style="font-weight: bold; color: #2d1b3d;">💡 Titre Box Consultation ' . $i . '</h3>',
            'isabel_consultation_section',
            array('editor_height' => '80px')
        );
        
        // Texte box Consultation
        isabel_add_word_editor(
            $wp_customize,
            "isabel_consultation_box{$i}_text_word",
            "📝 Box Consultation $i - Texte",
            '<p style="color: #6b5b73; line-height: 1.5;">Description de la box Consultation ' . $i . ' avec du texte personnalisable.</p>',
            'isabel_consultation_section',
            array('editor_height' => '100px')
        );
    }
    
    // Étapes Consultation
    for ($i = 1; $i <= 4; $i++) {
        isabel_add_word_editor(
            $wp_customize,
            "isabel_consultation_step{$i}_word",
            "📝 Étape Consultation $i",
            '<h4 style="font-weight: bold; margin-bottom: 8px;">Étape ' . $i . ' Consultation</h4><p style="color: #6b5b73;">Description de l\'étape ' . $i . ' de la consultation découverte.</p>',
            'isabel_consultation_section',
            array('editor_height' => '120px')
        );
    }
    
    // Highlight box consultation
    isabel_add_word_editor(
        $wp_customize,
        'isabel_consultation_highlight_word',
        '📝 Encadré Spécial Consultation',
        '<h3 style="color: #c47dd9; margin-bottom: 15px; font-size: 20px;">🎁 Consultation 100% gratuite</h3><p style="color: #2d1b3d; font-size: 16px; font-weight: 500;">Cette première rencontre est entièrement offerte et sans aucun engagement.</p>',
        'isabel_consultation_section',
        array('editor_height' => '120px')
    );
    
    // CTA Consultation
    isabel_add_word_editor(
        $wp_customize,
        'isabel_consultation_cta_word',
        '📝 CTA Consultation',
        '<h3 style="font-weight: bold; margin-bottom: 15px;">Prêt(e) à faire le premier pas ?</h3><p style="margin-bottom: 20px;">Réservez dès maintenant votre consultation découverte gratuite.</p>',
        'isabel_consultation_section',
        array('editor_height' => '150px')
    );

    // ===== SECTION FOOTER AVEC ÉDITEUR WORD-LIKE =====
    $wp_customize->add_section('isabel_footer_section', array(
        'title' => '✏️ Footer - Éditeur Word',
        'priority' => 44,
        'description' => 'Modifiez tous les textes du footer'
    ));
    
    // Nom principal footer
    isabel_add_word_editor(
        $wp_customize,
        'isabel_footer_name_word',
        '📝 Nom Principal Footer',
        '<span style="font-weight: bold; color: #c47dd9;">Isabel GONCALVES</span>',
        'isabel_footer_section',
        array('editor_height' => '80px')
    );
    
    // Description footer
    isabel_add_word_editor(
        $wp_customize,
        'isabel_footer_description_word',
        '📝 Description Footer',
        '<p style="color: #6b5b73; line-height: 1.7;">Coach Certifiée &amp; Hypnocoach<br>Accompagnement personnalisé pour votre transformation</p>',
        'isabel_footer_section',
        array('editor_height' => '100px')
    );
    
    // Titre section services footer
    isabel_add_word_editor(
        $wp_customize,
        'isabel_footer_services_title_word',
        '📝 Titre Services Footer',
        '<h3 style="color: #c47dd9; font-weight: bold;">Mes Services</h3>',
        'isabel_footer_section',
        array('editor_height' => '80px')
    );
    
    // Titre section à propos footer
    isabel_add_word_editor(
        $wp_customize,
        'isabel_footer_about_title_word',
        '📝 Titre À Propos Footer',
        '<h3 style="color: #c47dd9; font-weight: bold;">À propos</h3>',
        'isabel_footer_section',
        array('editor_height' => '80px')
    );
    
    // Texte à propos footer
    isabel_add_word_editor(
        $wp_customize,
        'isabel_footer_about_text_word',
        '📝 Texte À Propos Footer',
        '<p style="color: #6b5b73; line-height: 1.8;">Accompagnement professionnel pour votre développement personnel et professionnel.</p>',
        'isabel_footer_section',
        array('editor_height' => '120px')
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
            array('editor_height' => '80px')
        );
    }
    
    // Call to action footer
    isabel_add_word_editor(
        $wp_customize,
        'isabel_footer_cta_word',
        '📝 Call-to-Action Footer',
        '<strong style="color: #2d1b3d;">Ensemble, réalisons vos objectifs</strong><br><span style="color: #6b5b73;">Contactez-moi pour commencer votre transformation</span>',
        'isabel_footer_section',
        array('editor_height' => '100px')
    );
    
    // Copyright footer
    isabel_add_word_editor(
        $wp_customize,
        'isabel_footer_copyright_word',
        '📝 Copyright Footer',
        '<span style="color: #6b5b73;">© 2024 Isabel GONCALVES - Coach Certifiée. Tous droits réservés.</span>',
        'isabel_footer_section',
        array('editor_height' => '80px')
    );
    
    // Badge professionnel footer
    isabel_add_word_editor(
        $wp_customize,
        'isabel_footer_badge_word',
        '📝 Badge Professionnel Footer',
        '<span style="color: #c47dd9; font-weight: bold;">✨ Coach Professionnelle Certifiée ✨</span>',
        'isabel_footer_section',
        array('editor_height' => '80px')
    );

    // ===== COULEURS ET STYLES =====
    $wp_customize->add_section('isabel_colors_section', array(
        'title' => '🎨 Couleurs du Site',
        'priority' => 45,
        'description' => 'Personnalisez les couleurs principales'
    ));
    
    // Couleur principale
    $wp_customize->add_setting('isabel_primary_color', array(
        'default' => '#e4a7f5',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'isabel_primary_color', array(
        'label' => 'Couleur principale (rose)',
        'section' => 'isabel_colors_section',
    )));
    
    // Couleur secondaire
    $wp_customize->add_setting('isabel_secondary_color', array(
        'default' => '#c47dd9',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'isabel_secondary_color', array(
        'label' => 'Couleur secondaire (rose foncé)',
        'section' => 'isabel_colors_section',
    )));
}

/**
 * Fonctions pour récupérer le contenu des éditeurs Word-like
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
    // Essayer d'abord le setting Word-like
    $word_content = get_theme_mod($word_setting, '');
    if (!empty($word_content)) {
        return wp_kses_post($word_content);
    }
    
    // Fallback vers l'ancien setting
    $regular_content = get_theme_mod($regular_setting, $default);
    if (!empty($regular_content)) {
        return esc_html($regular_content);
    }
    
    // Dernier fallback
    return esc_html($default);
}

/**
 * Fonctions helper pour les pages de services
 */

// Fonction pour afficher les boxes des pages de services
function isabel_display_service_boxes($service_type, $box_count = 4) {
    echo '<div class="benefits-grid-fixed">';
    
    for ($i = 1; $i <= $box_count; $i++) {
        if ($i % 2 == 1) {
            // Box texte (impaire)
            echo '<div class="benefit-card-fixed text-card-fixed">';
            isabel_display_word_editor_content(
                "isabel_{$service_type}_box{$i}_title_word",
                '<h3><span class="benefit-icon">💡</span> Titre Box ' . $i . '</h3>'
            );
            isabel_display_word_editor_content(
                "isabel_{$service_type}_box{$i}_text_word",
                '<p>Description de la box ' . $i . '</p>'
            );
            echo '</div>';
        } else {
            // Box image (paire)
            echo '<div class="benefit-card-fixed image-only-card-fixed">';
            $box_image = isabel_get_option("isabel_{$service_type}_box{$i}_image", '');
            if (!empty($box_image)) {
                echo '<div class="image-wrapper">';
                echo '<img src="' . esc_url($box_image) . '" alt="Image ' . $service_type . '" class="full-box-image-fixed" />';
                echo '</div>';
            } else {
                echo '<div class="full-box-placeholder-fixed">';
                echo '<div class="placeholder-content">';
                echo '<span class="placeholder-text">IMAGE</span>';
                echo '</div>';
                echo '</div>';
            }
            echo '</div>';
        }
    }
    
    echo '</div>';
}

// Fonction pour afficher les étapes des processus
function isabel_display_service_steps($service_type, $step_count = 4) {
    echo '<div class="process-steps">';
    echo '<h3>Déroulement de l\'accompagnement</h3>';
    echo '<div class="steps-list">';
    
    for ($i = 1; $i <= $step_count; $i++) {
        echo '<div class="step-item">';
        echo '<div class="step-number">' . $i . '</div>';
        echo '<div class="step-content">';
        isabel_display_word_editor_content(
            "isabel_{$service_type}_step{$i}_word",
            '<h4>Étape ' . $i . '</h4><p>Description de l\'étape ' . $i . '</p>'
        );
        echo '</div>';
        echo '</div>';
    }
    
    echo '</div>';
    echo '</div>';
}

// Fonction pour afficher le CTA des pages de services
function isabel_display_service_cta($service_type) {
    echo '<div class="cta-service">';
    isabel_display_word_editor_content(
        "isabel_{$service_type}_cta_word",
        '<h3>Prêt(e) à commencer ?</h3><p>Contactez-moi pour en savoir plus.</p>'
    );
    echo '<button class="btn-cta" onclick="openPopup()">Prendre rendez-vous</button>';
    echo '</div>';
}

/**
 * Fonctions pour l'affichage des contenus Word-like dans les templates
 */

// Header
function isabel_display_header_content() {
    echo '<div class="logo-text">';
    echo '<div class="logo-name">';
    isabel_display_word_editor_content('isabel_header_name_word', 'Isabel GONCALVES');
    echo '</div>';
    echo '<div class="logo-subtitle">';
    isabel_display_word_editor_content('isabel_header_subtitle_word', 'Formatrice & Coach Certifiée');
    echo '</div>';
    echo '</div>';
}

// Hero section
function isabel_display_hero_content() {
    echo '<div class="hero-badge">';
    isabel_display_word_editor_content('isabel_hero_badge_word', '✨ Coach certifiée');
    echo '</div>';
    
    echo '<div class="profile-info">';
    isabel_display_word_editor_content('isabel_main_name_word', '<h1>Isabel GONCALVES</h1>');
    echo '</div>';
    
    echo '<div class="profile-subtitle">';
    isabel_display_word_editor_content('isabel_subtitle_word', '<p>Coach Certifiée & Hypnocoach</p>');
    echo '</div>';
    
    echo '<div class="intro-text">';
    isabel_display_word_editor_content('isabel_intro_text_word', '<p>Bienvenue dans votre espace de transformation personnelle !</p>');
    echo '</div>';
    
    echo '<div class="hero-cta">';
    echo '<button class="cta-main" onclick="openPopup()"><span>🚀</span>';
    isabel_display_word_editor_content('isabel_main_button_word', '<span>Prendre rendez-vous</span>');
    echo '</button>';
    echo '<button class="btn-secondary">En savoir plus</button>';
    echo '</div>';
}

// Services section
function isabel_display_services_content() {
    isabel_display_word_editor_content('isabel_services_title_word', '<h2>Mes Accompagnements Sur Mesure</h2>');
    isabel_display_word_editor_content('isabel_services_subtitle_word', '<p>Quatre approches complémentaires pour révéler votre potentiel.</p>');
    
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
        echo '<div class="service-title-container">';
        isabel_display_word_editor_content("isabel_service{$i}_title_word", '<h3>Service ' . $i . '</h3>');
        echo '</div>';
        echo '<div class="service-description-container">';
        isabel_display_word_editor_content("isabel_service{$i}_desc_word", '<p>Description du service ' . $i . '</p>');
        echo '</div>';
        echo '<div class="service-arrow">→</div>';
        echo '</a>';
    }
    echo '</div>';
}

// Témoignages section
function isabel_display_testimonials_content() {
    isabel_display_word_editor_content('isabel_testimonials_title_word', '<h2>Ce que disent mes clients</h2>');
    isabel_display_word_editor_content('isabel_testimonials_subtitle_word', '<p>Découvrez les témoignages de personnes qui ont transformé leur vie.</p>');
}

// CTA section
function isabel_display_cta_content() {
    echo '<div class="cta-box">';
    isabel_display_word_editor_content('isabel_cta_title_word', '<h2>Prêt(e) à Commencer Votre Transformation ?</h2>');
    isabel_display_word_editor_content('isabel_cta_text_word', '<p>Contactez-moi dès maintenant pour discuter de vos objectifs.</p>');
    echo '<button class="cta-button" onclick="openPopup()">';
    isabel_display_word_editor_content('isabel_cta_button_word', 'Prendre rendez-vous');
    echo '</button>';
    echo '</div>';
}

// Modal content
function isabel_display_modal_content() {
    echo '<h2 class="modal-title">';
    isabel_display_word_editor_content('isabel_modal_title_word', 'Réservez votre rendez-vous');
    echo '</h2>';
    
    echo '<p class="modal-subtitle">';
    isabel_display_word_editor_content('isabel_modal_subtitle_word', 'Première consultation personnalisée');
    echo '</p>';
}

// Footer content
function isabel_display_footer_content() {
    echo '<h3>';
    isabel_display_word_editor_content('isabel_footer_name_word', 'Isabel GONCALVES');
    echo '</h3>';
    
    isabel_display_word_editor_content('isabel_footer_description_word', '<p>Coach Certifiée & Hypnocoach</p>');
}

/**
 * Initialiser le customizer Word-like
 */
add_action('customize_register', 'isabel_customize_register');

/**
 * Script pour le preview en temps réel
 */
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

/**
 * CSS dynamique pour les couleurs personnalisées
 */
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

/**
 * Instructions d'utilisation pour l'admin
 */
function isabel_customizer_help() {
    if (is_admin() && isset($_GET['page']) && $_GET['page'] === 'isabel-settings') {
        ?>
        <div class="notice notice-info">
            <h3>🎨 Comment utiliser les éditeurs Word-like</h3>
            <p><strong>Tous vos textes sont maintenant modifiables avec un éditeur identique à Microsoft Word !</strong></p>
            <ol>
                <li>Allez dans <strong>Apparence > Personnaliser</strong></li>
                <li>Choisissez la section que vous voulez modifier (Hero, Services, etc.)</li>
                <li>Utilisez les éditeurs Word-like pour formater vos textes comme dans Microsoft Word</li>
                <li>Sauvegardez et admirez le résultat en temps réel !</li>
            </ol>
            <p><em>Toutes les pages sont maintenant couvertes : Accueil, Coaching, VAE, Hypnocoaching, Consultation, Header, Footer, Modal...</em></p>
        </div>
        <?php
    }
}
add_action('admin_notices', 'isabel_customizer_help');

/**
 * FONCTIONS DE COMPATIBILITÉ POUR LES ANCIENS TEMPLATES
 */

// Fonction pour récupérer l'option avec fallback Word-like
function isabel_get_option_with_wordlike($word_setting, $old_setting, $default = '') {
    // Priorité aux éditeurs Word-like
    $word_content = get_theme_mod($word_setting, '');
    if (!empty($word_content)) {
        return wp_kses_post($word_content);
    }
    
    // Fallback vers l'ancien système
    return esc_html(get_theme_mod($old_setting, $default));
}

/**
 * Fonctions de migration automatique (optionnel)
 */
function isabel_migrate_old_settings_to_wordlike() {
    // Cette fonction peut être appelée pour migrer automatiquement
    // les anciens réglages vers les nouveaux éditeurs Word-like
    
    $migrations = array(
        'isabel_main_name' => 'isabel_main_name_word',
        'isabel_subtitle' => 'isabel_subtitle_word',
        'isabel_intro_text' => 'isabel_intro_text_word',
        // ... autres migrations
    );
    
    foreach ($migrations as $old_setting => $new_setting) {
        $old_value = get_theme_mod($old_setting, '');
        $new_value = get_theme_mod($new_setting, '');
        
        // Si nouveau vide et ancien rempli, migrer
        if (empty($new_value) && !empty($old_value)) {
            set_theme_mod($new_setting, '<p>' . esc_html($old_value) . '</p>');
        }
    }
}

// Décommenter la ligne suivante pour activer la migration automatique
// add_action('after_setup_theme', 'isabel_migrate_old_settings_to_wordlike');

?>