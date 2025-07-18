<?php
// Empêcher l'accès direct au fichier
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Customizer STYLE WORD avec éditeur WYSIWYG complet
 * Interface identique à Microsoft Word pour modifier les textes
 * VERSION RÉVOLUTIONNAIRE
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
        // Récupérer la police depuis les réglages
        return get_theme_mod('isabel_main_font_family', 'Arial, sans-serif');
    }
    
    private function get_font_size() {
        // Récupérer la taille depuis les réglages
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
 * Configuration principale du customizer avec éditeurs Word-like
 */
function isabel_customize_register_word_like($wp_customize) {
    
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

    // ===== SECTION HERO AVEC ÉDITEURS WORD-LIKE =====
    $wp_customize->add_section('isabel_hero_section', array(
        'title' => '✏️ Section d\'Accueil - Éditeur Word',
        'priority' => 30,
        'description' => 'Modifiez vos textes avec un éditeur identique à Microsoft Word'
    ));
    
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

    // ===== AUTRES SECTIONS IMPORTANTES =====
    
    // Section témoignages
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
}

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
 * Initialiser le customizer Word-like
 */
add_action('customize_register', 'isabel_customize_register_word_like');

?>