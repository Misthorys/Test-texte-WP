<?php
// Empêcher l'accès direct au fichier
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Customizer pour la PAGE ACCOMPAGNEMENT VAE
 */

function isabel_register_vae_customizer($wp_customize) {
    
    // ===== SECTION VAE =====
    $wp_customize->add_section('isabel_vae_section', array(
        'title' => '🎓 Page Accompagnement VAE',
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
        array(
            'description' => 'Titre principal de la page VAE',
            'editor_height' => '80px'
        )
    );
    
    // Sous-titre VAE
    isabel_add_word_editor(
        $wp_customize,
        'isabel_vae_subtitle_word',
        '📝 Sous-titre VAE',
        '<p style="font-size: 20px; color: rgba(255,255,255,0.9);">Valorisez votre expérience et obtenez une reconnaissance officielle de vos compétences</p>',
        'isabel_vae_section',
        array(
            'description' => 'Sous-titre de la page VAE',
            'editor_height' => '100px'
        )
    );
    
    // Introduction VAE
    isabel_add_word_editor(
        $wp_customize,
        'isabel_vae_intro_word',
        '📝 Introduction VAE',
        '<p style="font-size: 16px; line-height: 1.7;">La <strong>Validation des Acquis de l\'Expérience (VAE)</strong> est un dispositif qui permet de faire reconnaître officiellement vos compétences acquises par l\'expérience professionnelle.</p>',
        'isabel_vae_section',
        array(
            'description' => 'Texte d\'introduction de la page VAE',
            'editor_height' => '120px'
        )
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
            'description' => "Image pour la box VAE $i (optionnelle)",
            'section' => 'isabel_vae_section',
        )));
        
        // Titre box VAE
        isabel_add_word_editor(
            $wp_customize,
            "isabel_vae_box{$i}_title_word",
            "📝 Box VAE $i - Titre",
            '<h3 style="font-weight: bold; color: #2d1b3d;">🎓 Titre Box VAE ' . $i . '</h3>',
            'isabel_vae_section',
            array(
                'description' => "Titre de la box VAE $i",
                'editor_height' => '80px'
            )
        );
        
        // Texte box VAE
        isabel_add_word_editor(
            $wp_customize,
            "isabel_vae_box{$i}_text_word",
            "📝 Box VAE $i - Texte",
            '<p style="color: #6b5b73; line-height: 1.5;">Description de la box VAE ' . $i . ' avec du texte personnalisable pour expliquer les bénéfices de la VAE.</p>',
            'isabel_vae_section',
            array(
                'description' => "Description de la box VAE $i",
                'editor_height' => '100px'
            )
        );
    }
    
    // Étapes VAE
    for ($i = 1; $i <= 4; $i++) {
        isabel_add_word_editor(
            $wp_customize,
            "isabel_vae_step{$i}_word",
            "📝 Étape VAE $i",
            '<h4 style="font-weight: bold; margin-bottom: 8px;">Étape ' . $i . ' VAE</h4><p style="color: #6b5b73;">Description de l\'étape ' . $i . ' du processus d\'accompagnement VAE.</p>',
            'isabel_vae_section',
            array(
                'description' => "Étape $i du processus VAE",
                'editor_height' => '120px'
            )
        );
    }
    
    // CTA VAE
    isabel_add_word_editor(
        $wp_customize,
        'isabel_vae_cta_word',
        '📝 CTA VAE',
        '<h3 style="font-weight: bold; margin-bottom: 15px;">Prêt(e) à valoriser votre expérience ?</h3><p style="margin-bottom: 20px;">Contactez-moi pour une première évaluation de votre projet VAE et découvrons ensemble les possibilités qui s\'offrent à vous.</p>',
        'isabel_vae_section',
        array(
            'description' => 'Appel à l\'action final de la page VAE',
            'editor_height' => '150px'
        )
    );

    // ===== PARAMÈTRES VAE TRADITIONNELS (FALLBACK) =====
    
    // Titre simple (fallback)
    $wp_customize->add_setting('isabel_vae_title', array(
        'default' => 'Accompagnement VAE',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('isabel_vae_title', array(
        'label' => 'Titre (version simple)',
        'description' => 'Version simple sans formatage',
        'section' => 'isabel_vae_section',
        'type' => 'text',
        'priority' => 50,
    ));
    
    // Sous-titre simple (fallback)
    $wp_customize->add_setting('isabel_vae_subtitle', array(
        'default' => 'Valorisez votre expérience et obtenez une reconnaissance officielle',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('isabel_vae_subtitle', array(
        'label' => 'Sous-titre (version simple)',
        'description' => 'Version simple sans formatage',
        'section' => 'isabel_vae_section',
        'type' => 'text',
        'priority' => 51,
    ));
    
    // Introduction simple (fallback)
    $wp_customize->add_setting('isabel_vae_intro', array(
        'default' => 'La VAE permet de faire reconnaître officiellement vos compétences acquises par l\'expérience.',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    $wp_customize->add_control('isabel_vae_intro', array(
        'label' => 'Introduction (version simple)',
        'description' => 'Version simple sans formatage',
        'section' => 'isabel_vae_section',
        'type' => 'textarea',
        'priority' => 52,
    ));
}

/**
 * Fonctions d'affichage pour la page VAE
 */

// Fonction pour afficher les boxes de la page VAE
function isabel_display_vae_boxes($box_count = 4) {
    echo '<div class="benefits-grid-fixed">';
    
    for ($i = 1; $i <= $box_count; $i++) {
        if ($i % 2 == 1) {
            // Box texte (impaire)
            echo '<div class="benefit-card-fixed text-card-fixed">';
            
            $title_word = isabel_get_word_editor_content("isabel_vae_box{$i}_title_word", '');
            if (!empty($title_word)) {
                echo $title_word;
            } else {
                echo '<h3><span class="benefit-icon">🎓</span> Titre Box VAE ' . $i . '</h3>';
            }
            
            $text_word = isabel_get_word_editor_content("isabel_vae_box{$i}_text_word", '');
            if (!empty($text_word)) {
                echo $text_word;
            } else {
                echo '<p>Description de la box VAE ' . $i . '</p>';
            }
            
            echo '</div>';
        } else {
            // Box image (paire)
            echo '<div class="benefit-card-fixed image-only-card-fixed">';
            $box_image = isabel_get_option("isabel_vae_box{$i}_image", '');
            if (!empty($box_image)) {
                echo '<div class="image-wrapper">';
                echo '<img src="' . esc_url($box_image) . '" alt="Image VAE" class="full-box-image-fixed" />';
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

// Fonction pour afficher les étapes de la VAE
function isabel_display_vae_steps($step_count = 4) {
    echo '<div class="process-steps">';
    echo '<h3>Les étapes de votre VAE</h3>';
    echo '<div class="steps-list">';
    
    for ($i = 1; $i <= $step_count; $i++) {
        echo '<div class="step-item">';
        echo '<div class="step-number">' . $i . '</div>';
        echo '<div class="step-content">';
        
        $step_word = isabel_get_word_editor_content("isabel_vae_step{$i}_word", '');
        if (!empty($step_word)) {
            echo $step_word;
        } else {
            echo '<h4>Étape ' . $i . ' VAE</h4>';
            echo '<p>Description de l\'étape ' . $i . '</p>';
        }
        
        echo '</div>';
        echo '</div>';
    }
    
    echo '</div>';
    echo '</div>';
}

// Fonction pour afficher le CTA de la page VAE
function isabel_display_vae_cta() {
    echo '<div class="cta-service">';
    
    $cta_word = isabel_get_word_editor_content('isabel_vae_cta_word', '');
    if (!empty($cta_word)) {
        echo $cta_word;
    } else {
        echo '<h3>Prêt(e) à valoriser votre expérience ?</h3>';
        echo '<p>Contactez-moi pour une première évaluation de votre projet VAE.</p>';
    }
    
    echo '<button class="btn-cta" onclick="openPopup()">Évaluer mon projet VAE</button>';
    echo '</div>';
}

?>