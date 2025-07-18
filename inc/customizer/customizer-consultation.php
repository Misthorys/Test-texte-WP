<?php
// Empêcher l'accès direct au fichier
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Customizer pour la PAGE CONSULTATION DÉCOUVERTE
 */

function isabel_register_consultation_customizer($wp_customize) {
    
    // ===== SECTION CONSULTATION DÉCOUVERTE =====
    $wp_customize->add_section('isabel_consultation_section', array(
        'title' => '💡 Page Consultation Découverte',
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
        array(
            'description' => 'Titre principal de la page Consultation Découverte',
            'editor_height' => '80px'
        )
    );
    
    // Sous-titre Consultation
    isabel_add_word_editor(
        $wp_customize,
        'isabel_consultation_subtitle_word',
        '📝 Sous-titre Consultation',
        '<p style="font-size: 20px; color: rgba(255,255,255,0.9);">Première rencontre gratuite pour définir ensemble votre parcours</p>',
        'isabel_consultation_section',
        array(
            'description' => 'Sous-titre de la page Consultation Découverte',
            'editor_height' => '100px'
        )
    );
    
    // Introduction Consultation
    isabel_add_word_editor(
        $wp_customize,
        'isabel_consultation_intro_word',
        '📝 Introduction Consultation',
        '<p style="font-size: 16px; line-height: 1.7;">La <strong>consultation découverte</strong> est un moment privilégié pour faire connaissance et comprendre vos besoins spécifiques.</p>',
        'isabel_consultation_section',
        array(
            'description' => 'Texte d\'introduction de la page Consultation Découverte',
            'editor_height' => '120px'
        )
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
            'description' => "Image pour la box Consultation $i (optionnelle)",
            'section' => 'isabel_consultation_section',
        )));
        
        // Titre box Consultation
        isabel_add_word_editor(
            $wp_customize,
            "isabel_consultation_box{$i}_title_word",
            "📝 Box Consultation $i - Titre",
            '<h3 style="font-weight: bold; color: #2d1b3d;">💡 Titre Box Consultation ' . $i . '</h3>',
            'isabel_consultation_section',
            array(
                'description' => "Titre de la box Consultation $i",
                'editor_height' => '80px'
            )
        );
        
        // Texte box Consultation
        isabel_add_word_editor(
            $wp_customize,
            "isabel_consultation_box{$i}_text_word",
            "📝 Box Consultation $i - Texte",
            '<p style="color: #6b5b73; line-height: 1.5;">Description de la box Consultation ' . $i . ' avec du texte personnalisable pour expliquer les bénéfices de la consultation découverte.</p>',
            'isabel_consultation_section',
            array(
                'description' => "Description de la box Consultation $i",
                'editor_height' => '100px'
            )
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
            array(
                'description' => "Étape $i de la consultation découverte",
                'editor_height' => '120px'
            )
        );
    }
    
    // Highlight box consultation
    isabel_add_word_editor(
        $wp_customize,
        'isabel_consultation_highlight_word',
        '📝 Encadré Spécial Consultation',
        '<h3 style="color: #c47dd9; margin-bottom: 15px; font-size: 20px;">🎁 Consultation 100% gratuite</h3><p style="color: #2d1b3d; font-size: 16px; font-weight: 500;">Cette première rencontre est entièrement offerte et sans aucun engagement.</p>',
        'isabel_consultation_section',
        array(
            'description' => 'Encadré spécial pour mettre en avant la gratuité',
            'editor_height' => '120px'
        )
    );
    
    // CTA Consultation
    isabel_add_word_editor(
        $wp_customize,
        'isabel_consultation_cta_word',
        '📝 CTA Consultation',
        '<h3 style="font-weight: bold; margin-bottom: 15px;">Prêt(e) à faire le premier pas ?</h3><p style="margin-bottom: 20px;">Réservez dès maintenant votre consultation découverte gratuite et commençons ensemble votre parcours de transformation.</p>',
        'isabel_consultation_section',
        array(
            'description' => 'Appel à l\'action final de la page Consultation',
            'editor_height' => '150px'
        )
    );

    // ===== PARAMÈTRES CONSULTATION TRADITIONNELS (FALLBACK) =====
    
    // Titre simple (fallback)
    $wp_customize->add_setting('isabel_consultation_title', array(
        'default' => 'Consultation Découverte',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('isabel_consultation_title', array(
        'label' => 'Titre (version simple)',
        'description' => 'Version simple sans formatage',
        'section' => 'isabel_consultation_section',
        'type' => 'text',
        'priority' => 50,
    ));
    
    // Sous-titre simple (fallback)
    $wp_customize->add_setting('isabel_consultation_subtitle', array(
        'default' => 'Première rencontre gratuite pour définir ensemble votre parcours',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('isabel_consultation_subtitle', array(
        'label' => 'Sous-titre (version simple)',
        'description' => 'Version simple sans formatage',
        'section' => 'isabel_consultation_section',
        'type' => 'text',
        'priority' => 51,
    ));
    
    // Introduction simple (fallback)
    $wp_customize->add_setting('isabel_consultation_intro', array(
        'default' => 'La consultation découverte est un moment privilégié pour faire connaissance.',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    $wp_customize->add_control('isabel_consultation_intro', array(
        'label' => 'Introduction (version simple)',
        'description' => 'Version simple sans formatage',
        'section' => 'isabel_consultation_section',
        'type' => 'textarea',
        'priority' => 52,
    ));
}

/**
 * Fonctions d'affichage pour la page Consultation Découverte
 */

// Fonction pour afficher les boxes de la page Consultation
function isabel_display_consultation_boxes($box_count = 4) {
    echo '<div class="benefits-grid-fixed">';
    
    for ($i = 1; $i <= $box_count; $i++) {
        if ($i % 2 == 1) {
            // Box texte (impaire)
            echo '<div class="benefit-card-fixed text-card-fixed">';
            
            $title_word = isabel_get_word_editor_content("isabel_consultation_box{$i}_title_word", '');
            if (!empty($title_word)) {
                echo $title_word;
            } else {
                echo '<h3><span class="benefit-icon">💡</span> Titre Box Consultation ' . $i . '</h3>';
            }
            
            $text_word = isabel_get_word_editor_content("isabel_consultation_box{$i}_text_word", '');
            if (!empty($text_word)) {
                echo $text_word;
            } else {
                echo '<p>Description de la box Consultation ' . $i . '</p>';
            }
            
            echo '</div>';
        } else {
            // Box image (paire)
            echo '<div class="benefit-card-fixed image-only-card-fixed">';
            $box_image = isabel_get_option("isabel_consultation_box{$i}_image", '');
            if (!empty($box_image)) {
                echo '<div class="image-wrapper">';
                echo '<img src="' . esc_url($box_image) . '" alt="Image consultation" class="full-box-image-fixed" />';
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

// Fonction pour afficher les étapes de la consultation
function isabel_display_consultation_steps($step_count = 4) {
    echo '<div class="process-steps">';
    echo '<h3>Déroulement de la consultation</h3>';
    echo '<div class="steps-list">';
    
    for ($i = 1; $i <= $step_count; $i++) {
        echo '<div class="step-item">';
        echo '<div class="step-number">' . $i . '</div>';
        echo '<div class="step-content">';
        
        $step_word = isabel_get_word_editor_content("isabel_consultation_step{$i}_word", '');
        if (!empty($step_word)) {
            echo $step_word;
        } else {
            echo '<h4>Étape ' . $i . ' Consultation</h4>';
            echo '<p>Description de l\'étape ' . $i . '</p>';
        }
        
        echo '</div>';
        echo '</div>';
    }
    
    echo '</div>';
    echo '</div>';
}

// Fonction pour afficher l'encadré spécial consultation
function isabel_display_consultation_highlight() {
    echo '<div style="background: linear-gradient(135deg, var(--pastel-lavender), var(--pastel-pink)); border-radius: 16px; padding: 2rem; margin: 3rem 0; text-align: center;">';
    
    $highlight_word = isabel_get_word_editor_content('isabel_consultation_highlight_word', '');
    if (!empty($highlight_word)) {
        echo $highlight_word;
    } else {
        echo '<h3 style="color: var(--rose-700); margin-bottom: 1rem; font-size: 1.3rem;">🎁 Consultation 100% gratuite</h3>';
        echo '<p style="color: var(--text-dark); font-size: 1.1rem; margin: 0; font-weight: 500;">Cette première rencontre est entièrement offerte et sans aucun engagement.</p>';
    }
    
    echo '</div>';
}

// Fonction pour afficher le CTA de la page Consultation
function isabel_display_consultation_cta() {
    echo '<div class="cta-service">';
    
    $cta_word = isabel_get_word_editor_content('isabel_consultation_cta_word', '');
    if (!empty($cta_word)) {
        echo $cta_word;
    } else {
        echo '<h3>Prêt(e) à faire le premier pas ?</h3>';
        echo '<p>Réservez dès maintenant votre consultation découverte gratuite.</p>';
    }
    
    echo '<button class="btn-cta" onclick="openPopup()">Réserver ma consultation gratuite</button>';
    echo '</div>';
}

?>