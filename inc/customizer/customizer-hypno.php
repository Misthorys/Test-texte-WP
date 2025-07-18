<?php
// Empêcher l'accès direct au fichier
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Customizer pour la PAGE HYPNOCOACHING
 */

function isabel_register_hypno_customizer($wp_customize) {
    
    // ===== SECTION HYPNOCOACHING =====
    $wp_customize->add_section('isabel_hypno_section', array(
        'title' => '🧘 Page Hypnocoaching',
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
        array(
            'description' => 'Titre principal de la page Hypnocoaching',
            'editor_height' => '80px'
        )
    );
    
    // Sous-titre Hypno
    isabel_add_word_editor(
        $wp_customize,
        'isabel_hypno_subtitle_word',
        '📝 Sous-titre Hypnocoaching',
        '<p style="font-size: 20px; color: rgba(255,255,255,0.9);">Libérez-vous de vos blocages en profondeur grâce à l\'alliance du coaching et de l\'hypnose</p>',
        'isabel_hypno_section',
        array(
            'description' => 'Sous-titre de la page Hypnocoaching',
            'editor_height' => '100px'
        )
    );
    
    // Introduction Hypno
    isabel_add_word_editor(
        $wp_customize,
        'isabel_hypno_intro_word',
        '📝 Introduction Hypnocoaching',
        '<p style="font-size: 16px; line-height: 1.7;">L\'<strong>hypnocoaching</strong> est une approche innovante qui combine les bienfaits du coaching traditionnel avec la puissance de l\'hypnose thérapeutique.</p>',
        'isabel_hypno_section',
        array(
            'description' => 'Texte d\'introduction de la page Hypnocoaching',
            'editor_height' => '120px'
        )
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
            'description' => "Image pour la box Hypnocoaching $i (optionnelle)",
            'section' => 'isabel_hypno_section',
        )));
        
        // Titre box Hypno
        isabel_add_word_editor(
            $wp_customize,
            "isabel_hypno_box{$i}_title_word",
            "📝 Box Hypno $i - Titre",
            '<h3 style="font-weight: bold; color: #2d1b3d;">🧘 Titre Box Hypno ' . $i . '</h3>',
            'isabel_hypno_section',
            array(
                'description' => "Titre de la box Hypnocoaching $i",
                'editor_height' => '80px'
            )
        );
        
        // Texte box Hypno
        isabel_add_word_editor(
            $wp_customize,
            "isabel_hypno_box{$i}_text_word",
            "📝 Box Hypno $i - Texte",
            '<p style="color: #6b5b73; line-height: 1.5;">Description de la box Hypnocoaching ' . $i . ' avec du texte personnalisable pour expliquer les bénéfices de l\'hypnocoaching.</p>',
            'isabel_hypno_section',
            array(
                'description' => "Description de la box Hypnocoaching $i",
                'editor_height' => '100px'
            )
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
            array(
                'description' => "Étape $i du processus d'hypnocoaching",
                'editor_height' => '120px'
            )
        );
    }
    
    // CTA Hypno
    isabel_add_word_editor(
        $wp_customize,
        'isabel_hypno_cta_word',
        '📝 CTA Hypnocoaching',
        '<h3 style="font-weight: bold; margin-bottom: 15px;">Prêt(e) à libérer votre potentiel ?</h3><p style="margin-bottom: 20px;">Découvrez la puissance de l\'hypnocoaching lors d\'une consultation et explorons ensemble comment cette approche peut vous aider.</p>',
        'isabel_hypno_section',
        array(
            'description' => 'Appel à l\'action final de la page Hypnocoaching',
            'editor_height' => '150px'
        )
    );

    // ===== PARAMÈTRES HYPNO TRADITIONNELS (FALLBACK) =====
    
    // Titre simple (fallback)
    $wp_customize->add_setting('isabel_hypno_title', array(
        'default' => 'Hypnocoaching',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('isabel_hypno_title', array(
        'label' => 'Titre (version simple)',
        'description' => 'Version simple sans formatage',
        'section' => 'isabel_hypno_section',
        'type' => 'text',
        'priority' => 50,
    ));
    
    // Sous-titre simple (fallback)
    $wp_customize->add_setting('isabel_hypno_subtitle', array(
        'default' => 'Libérez-vous de vos blocages en profondeur',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('isabel_hypno_subtitle', array(
        'label' => 'Sous-titre (version simple)',
        'description' => 'Version simple sans formatage',
        'section' => 'isabel_hypno_section',
        'type' => 'text',
        'priority' => 51,
    ));
    
    // Introduction simple (fallback)
    $wp_customize->add_setting('isabel_hypno_intro', array(
        'default' => 'L\'hypnocoaching combine les bienfaits du coaching et de l\'hypnose thérapeutique.',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    $wp_customize->add_control('isabel_hypno_intro', array(
        'label' => 'Introduction (version simple)',
        'description' => 'Version simple sans formatage',
        'section' => 'isabel_hypno_section',
        'type' => 'textarea',
        'priority' => 52,
    ));
}

/**
 * Fonctions d'affichage pour la page Hypnocoaching
 */

// Fonction pour afficher les boxes de la page Hypnocoaching
function isabel_display_hypno_boxes($box_count = 4) {
    echo '<div class="benefits-grid-fixed">';
    
    for ($i = 1; $i <= $box_count; $i++) {
        if ($i % 2 == 1) {
            // Box texte (impaire)
            echo '<div class="benefit-card-fixed text-card-fixed">';
            
            $title_word = isabel_get_word_editor_content("isabel_hypno_box{$i}_title_word", '');
            if (!empty($title_word)) {
                echo $title_word;
            } else {
                echo '<h3><span class="benefit-icon">🧘</span> Titre Box Hypno ' . $i . '</h3>';
            }
            
            $text_word = isabel_get_word_editor_content("isabel_hypno_box{$i}_text_word", '');
            if (!empty($text_word)) {
                echo $text_word;
            } else {
                echo '<p>Description de la box Hypnocoaching ' . $i . '</p>';
            }
            
            echo '</div>';
        } else {
            // Box image (paire)
            echo '<div class="benefit-card-fixed image-only-card-fixed">';
            $box_image = isabel_get_option("isabel_hypno_box{$i}_image", '');
            if (!empty($box_image)) {
                echo '<div class="image-wrapper">';
                echo '<img src="' . esc_url($box_image) . '" alt="Image hypnocoaching" class="full-box-image-fixed" />';
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

// Fonction pour afficher les étapes de l'hypnocoaching
function isabel_display_hypno_steps($step_count = 4) {
    echo '<div class="process-steps">';
    echo '<h3>Déroulement d\'une séance d\'hypnocoaching</h3>';
    echo '<div class="steps-list">';
    
    for ($i = 1; $i <= $step_count; $i++) {
        echo '<div class="step-item">';
        echo '<div class="step-number">' . $i . '</div>';
        echo '<div class="step-content">';
        
        $step_word = isabel_get_word_editor_content("isabel_hypno_step{$i}_word", '');
        if (!empty($step_word)) {
            echo $step_word;
        } else {
            echo '<h4>Étape ' . $i . ' Hypnocoaching</h4>';
            echo '<p>Description de l\'étape ' . $i . '</p>';
        }
        
        echo '</div>';
        echo '</div>';
    }
    
    echo '</div>';
    echo '</div>';
}

// Fonction pour afficher le CTA de la page Hypnocoaching
function isabel_display_hypno_cta() {
    echo '<div class="cta-service">';
    
    $cta_word = isabel_get_word_editor_content('isabel_hypno_cta_word', '');
    if (!empty($cta_word)) {
        echo $cta_word;
    } else {
        echo '<h3>Prêt(e) à libérer votre potentiel ?</h3>';
        echo '<p>Découvrez la puissance de l\'hypnocoaching.</p>';
    }
    
    echo '<button class="btn-cta" onclick="openPopup()">Découvrir l\'hypnocoaching</button>';
    echo '</div>';
}

?>