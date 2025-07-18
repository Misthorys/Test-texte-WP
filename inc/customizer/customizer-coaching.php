<?php
// Empêcher l'accès direct au fichier
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Customizer pour la PAGE COACHING PERSONNEL
 */

function isabel_register_coaching_customizer($wp_customize) {
    
    // ===== SECTION COACHING PERSONNEL =====
    $wp_customize->add_section('isabel_coaching_section', array(
        'title' => '🎯 Page Coaching Personnel',
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
        array(
            'description' => 'Titre principal de la page coaching',
            'editor_height' => '80px'
        )
    );
    
    // Sous-titre coaching
    isabel_add_word_editor(
        $wp_customize,
        'isabel_coaching_subtitle_word',
        '📝 Sous-titre Coaching',
        '<p style="font-size: 20px; color: rgba(255,255,255,0.9);">Révélez votre potentiel et transformez votre vie personnelle et professionnelle</p>',
        'isabel_coaching_section',
        array(
            'description' => 'Sous-titre de la page coaching',
            'editor_height' => '100px'
        )
    );
    
    // Introduction coaching
    isabel_add_word_editor(
        $wp_customize,
        'isabel_coaching_intro_word',
        '📝 Introduction Coaching',
        '<p style="font-size: 16px; line-height: 1.7;">Le coaching personnel est un accompagnement sur mesure qui vous aide à <strong>clarifier vos objectifs</strong>, développer votre potentiel et créer la vie que vous désirez vraiment.</p>',
        'isabel_coaching_section',
        array(
            'description' => 'Texte d\'introduction de la page coaching',
            'editor_height' => '120px'
        )
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
            'description' => "Image pour la box $i (optionnelle)",
            'section' => 'isabel_coaching_section',
        )));
        
        // Titre box coaching
        isabel_add_word_editor(
            $wp_customize,
            "isabel_coaching_box{$i}_title_word",
            "📝 Box Coaching $i - Titre",
            '<h3 style="font-weight: bold; color: #2d1b3d;">💡 Titre Box ' . $i . '</h3>',
            'isabel_coaching_section',
            array(
                'description' => "Titre de la box coaching $i",
                'editor_height' => '80px'
            )
        );
        
        // Texte box coaching
        isabel_add_word_editor(
            $wp_customize,
            "isabel_coaching_box{$i}_text_word",
            "📝 Box Coaching $i - Texte",
            '<p style="color: #6b5b73; line-height: 1.5;">Description de la box ' . $i . ' avec du texte personnalisable pour expliquer les bénéfices du coaching.</p>',
            'isabel_coaching_section',
            array(
                'description' => "Description de la box coaching $i",
                'editor_height' => '100px'
            )
        );
    }
    
    // Étapes coaching
    for ($i = 1; $i <= 4; $i++) {
        isabel_add_word_editor(
            $wp_customize,
            "isabel_coaching_step{$i}_word",
            "📝 Étape Coaching $i",
            '<h4 style="font-weight: bold; margin-bottom: 8px;">Étape ' . $i . '</h4><p style="color: #6b5b73;">Description de l\'étape ' . $i . ' du processus de coaching personnalisé.</p>',
            'isabel_coaching_section',
            array(
                'description' => "Étape $i du processus de coaching",
                'editor_height' => '120px'
            )
        );
    }
    
    // CTA coaching
    isabel_add_word_editor(
        $wp_customize,
        'isabel_coaching_cta_word',
        '📝 CTA Coaching',
        '<h3 style="font-weight: bold; margin-bottom: 15px;">Prêt(e) à commencer votre transformation ?</h3><p style="margin-bottom: 20px;">Contactez-moi pour discuter de vos objectifs et découvrir comment le coaching personnel peut vous aider à révéler votre potentiel.</p>',
        'isabel_coaching_section',
        array(
            'description' => 'Appel à l\'action final de la page coaching',
            'editor_height' => '150px'
        )
    );

    // ===== PARAMÈTRES COACHING TRADITIONNELS (FALLBACK) =====
    
    // Titre simple (fallback)
    $wp_customize->add_setting('isabel_coaching_title', array(
        'default' => 'Coaching Personnel',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('isabel_coaching_title', array(
        'label' => 'Titre (version simple)',
        'description' => 'Version simple sans formatage',
        'section' => 'isabel_coaching_section',
        'type' => 'text',
        'priority' => 50,
    ));
    
    // Sous-titre simple (fallback)
    $wp_customize->add_setting('isabel_coaching_subtitle', array(
        'default' => 'Révélez votre potentiel et transformez votre vie',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('isabel_coaching_subtitle', array(
        'label' => 'Sous-titre (version simple)',
        'description' => 'Version simple sans formatage',
        'section' => 'isabel_coaching_section',
        'type' => 'text',
        'priority' => 51,
    ));
    
    // Introduction simple (fallback)
    $wp_customize->add_setting('isabel_coaching_intro', array(
        'default' => 'Le coaching personnel est un accompagnement sur mesure qui vous aide à clarifier vos objectifs.',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    $wp_customize->add_control('isabel_coaching_intro', array(
        'label' => 'Introduction (version simple)',
        'description' => 'Version simple sans formatage',
        'section' => 'isabel_coaching_section',
        'type' => 'textarea',
        'priority' => 52,
    ));
}

/**
 * Fonctions d'affichage pour la page Coaching
 */

// Fonction pour afficher les boxes de la page coaching
function isabel_display_coaching_boxes($box_count = 4) {
    echo '<div class="benefits-grid-fixed">';
    
    for ($i = 1; $i <= $box_count; $i++) {
        if ($i % 2 == 1) {
            // Box texte (impaire)
            echo '<div class="benefit-card-fixed text-card-fixed">';
            
            $title_word = isabel_get_word_editor_content("isabel_coaching_box{$i}_title_word", '');
            if (!empty($title_word)) {
                echo $title_word;
            } else {
                echo '<h3><span class="benefit-icon">💡</span> Titre Box ' . $i . '</h3>';
            }
            
            $text_word = isabel_get_word_editor_content("isabel_coaching_box{$i}_text_word", '');
            if (!empty($text_word)) {
                echo $text_word;
            } else {
                echo '<p>Description de la box ' . $i . '</p>';
            }
            
            echo '</div>';
        } else {
            // Box image (paire)
            echo '<div class="benefit-card-fixed image-only-card-fixed">';
            $box_image = isabel_get_option("isabel_coaching_box{$i}_image", '');
            if (!empty($box_image)) {
                echo '<div class="image-wrapper">';
                echo '<img src="' . esc_url($box_image) . '" alt="Image coaching" class="full-box-image-fixed" />';
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

// Fonction pour afficher les étapes du coaching
function isabel_display_coaching_steps($step_count = 4) {
    echo '<div class="process-steps">';
    echo '<h3>Déroulement de l\'accompagnement</h3>';
    echo '<div class="steps-list">';
    
    for ($i = 1; $i <= $step_count; $i++) {
        echo '<div class="step-item">';
        echo '<div class="step-number">' . $i . '</div>';
        echo '<div class="step-content">';
        
        $step_word = isabel_get_word_editor_content("isabel_coaching_step{$i}_word", '');
        if (!empty($step_word)) {
            echo $step_word;
        } else {
            echo '<h4>Étape ' . $i . '</h4>';
            echo '<p>Description de l\'étape ' . $i . '</p>';
        }
        
        echo '</div>';
        echo '</div>';
    }
    
    echo '</div>';
    echo '</div>';
}

// Fonction pour afficher le CTA de la page coaching
function isabel_display_coaching_cta() {
    echo '<div class="cta-service">';
    
    $cta_word = isabel_get_word_editor_content('isabel_coaching_cta_word', '');
    if (!empty($cta_word)) {
        echo $cta_word;
    } else {
        echo '<h3>Prêt(e) à commencer ?</h3>';
        echo '<p>Contactez-moi pour en savoir plus.</p>';
    }
    
    echo '<button class="btn-cta" onclick="openPopup()">Prendre rendez-vous</button>';
    echo '</div>';
}

?>