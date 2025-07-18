<?php
// Empêcher l'accès direct au fichier
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Customizer pour la MODAL/FORMULAIRE DE CONTACT
 */

function isabel_register_modal_customizer($wp_customize) {
    
    // ===== SECTION MODAL FORMULAIRE =====
    $wp_customize->add_section('isabel_modal_section', array(
        'title' => '📝 Modal Formulaire de Contact',
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
        array(
            'description' => 'Titre principal de la modal de contact',
            'editor_height' => '80px'
        )
    );
    
    // Sous-titre modal
    isabel_add_word_editor(
        $wp_customize,
        'isabel_modal_subtitle_word',
        '📝 Sous-titre Modal',
        '<p style="color: #6b5b73; font-style: italic;">Première consultation personnalisée</p>',
        'isabel_modal_section',
        array(
            'description' => 'Sous-titre de la modal de contact',
            'editor_height' => '80px'
        )
    );
    
    // Note du formulaire
    isabel_add_word_editor(
        $wp_customize,
        'isabel_modal_note_word',
        '📝 Note Formulaire',
        '<p style="background: #f8d7ff; padding: 15px; border-radius: 8px; color: #c47dd9; font-weight: 500;">💼 Première consultation pour faire connaissance et définir vos besoins ensemble.</p>',
        'isabel_modal_section',
        array(
            'description' => 'Note explicative dans le formulaire',
            'editor_height' => '100px'
        )
    );
    
    // Texte du bouton de soumission
    isabel_add_word_editor(
        $wp_customize,
        'isabel_modal_submit_button_word',
        '📝 Bouton de Soumission',
        '<span style="font-weight: bold;">Confirmer ma demande de rendez-vous</span>',
        'isabel_modal_section',
        array(
            'description' => 'Texte du bouton de soumission du formulaire',
            'editor_height' => '80px'
        )
    );

    // ===== LABELS DES CHAMPS DU FORMULAIRE =====
    
    // Labels des champs avec éditeurs Word
    $form_fields = array(
        'name' => array(
            'label' => 'Label Champ Nom',
            'default' => '<span style="font-weight: 500;">Nom complet</span>',
            'placeholder' => 'Placeholder Champ Nom',
            'placeholder_default' => 'Votre nom et prénom'
        ),
        'email' => array(
            'label' => 'Label Champ Email',
            'default' => '<span style="font-weight: 500;">Adresse email</span>',
            'placeholder' => 'Placeholder Champ Email',
            'placeholder_default' => 'votre@email.com'
        ),
        'phone' => array(
            'label' => 'Label Champ Téléphone',
            'default' => '<span style="font-weight: 500;">Téléphone</span>',
            'placeholder' => 'Placeholder Champ Téléphone',
            'placeholder_default' => '06 12 34 56 78'
        ),
        'service' => array(
            'label' => 'Label Champ Service',
            'default' => '<span style="font-weight: 500;">Type d\'accompagnement souhaité</span>',
            'placeholder' => 'Option par défaut Service',
            'placeholder_default' => 'Choisissez une option'
        ),
        'message' => array(
            'label' => 'Label Champ Message',
            'default' => '<span style="font-weight: 500;">Votre situation et objectifs</span>',
            'placeholder' => 'Placeholder Champ Message',
            'placeholder_default' => 'Décrivez-nous brièvement votre situation actuelle et ce que vous aimeriez accomplir...'
        )
    );
    
    foreach ($form_fields as $field => $config) {
        // Label du champ
        isabel_add_word_editor(
            $wp_customize,
            "isabel_modal_{$field}_label_word",
            "📝 {$config['label']}",
            $config['default'],
            'isabel_modal_section',
            array(
                'description' => "Label du champ {$field}",
                'editor_height' => '80px'
            )
        );
        
        // Placeholder du champ
        $wp_customize->add_setting("isabel_modal_{$field}_placeholder", array(
            'default' => $config['placeholder_default'],
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control("isabel_modal_{$field}_placeholder", array(
            'label' => $config['placeholder'],
            'description' => "Texte d'aide affiché dans le champ {$field}",
            'section' => 'isabel_modal_section',
            'type' => 'text',
        ));
    }

    // ===== OPTIONS DU CHAMP SERVICE =====
    
    // Options du sélecteur de service
    for ($i = 1; $i <= 4; $i++) {
        $service_options = array(
            1 => 'Coaching Personnel',
            2 => 'Accompagnement VAE',
            3 => 'Hypnocoaching',
            4 => 'Consultation Découverte'
        );
        
        $wp_customize->add_setting("isabel_modal_service_option_{$i}", array(
            'default' => $service_options[$i],
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control("isabel_modal_service_option_{$i}", array(
            'label' => "Option Service $i",
            'description' => "Texte de l'option $i dans le sélecteur de service",
            'section' => 'isabel_modal_section',
            'type' => 'text',
        ));
    }

    // ===== MESSAGES DE CONFIRMATION =====
    
    // Message de succès
    isabel_add_word_editor(
        $wp_customize,
        'isabel_modal_success_message_word',
        '📝 Message de Succès',
        '<p style="color: #00a32a; font-weight: bold;">🎉 Parfait ! Votre demande a été enregistrée et envoyée. Isabel vous contactera très rapidement pour programmer votre rendez-vous.</p>',
        'isabel_modal_section',
        array(
            'description' => 'Message affiché lors de l\'envoi réussi du formulaire',
            'editor_height' => '120px'
        )
    );
    
    // Message d'erreur
    isabel_add_word_editor(
        $wp_customize,
        'isabel_modal_error_message_word',
        '📝 Message d\'Erreur',
        '<p style="color: #e74c3c; font-weight: bold;">❌ Une erreur s\'est produite. Veuillez réessayer ou nous contacter directement.</p>',
        'isabel_modal_section',
        array(
            'description' => 'Message affiché en cas d\'erreur lors de l\'envoi',
            'editor_height' => '120px'
        )
    );

    // ===== PARAMÈTRES TRADITIONNELS (FALLBACK) =====
    
    // Titre simple (fallback)
    $wp_customize->add_setting('isabel_modal_title', array(
        'default' => 'Réservez votre rendez-vous',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('isabel_modal_title', array(
        'label' => 'Titre (version simple)',
        'description' => 'Version simple sans formatage',
        'section' => 'isabel_modal_section',
        'type' => 'text',
        'priority' => 50,
    ));
    
    // Sous-titre simple (fallback)
    $wp_customize->add_setting('isabel_modal_subtitle', array(
        'default' => 'Première consultation personnalisée',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('isabel_modal_subtitle', array(
        'label' => 'Sous-titre (version simple)',
        'description' => 'Version simple sans formatage',
        'section' => 'isabel_modal_section',
        'type' => 'text',
        'priority' => 51,
    ));
    
    // Style de la modal
    $wp_customize->add_setting('isabel_modal_style', array(
        'default' => 'default',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('isabel_modal_style', array(
        'label' => 'Style de la modal',
        'section' => 'isabel_modal_section',
        'type' => 'select',
        'choices' => array(
            'default' => 'Style par défaut',
            'minimal' => 'Style minimal',
            'elegant' => 'Style élégant',
            'modern' => 'Style moderne'
        ),
        'priority' => 52,
    ));
    
    // Couleur de fond de la modal
    $wp_customize->add_setting('isabel_modal_bg_color', array(
        'default' => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'isabel_modal_bg_color', array(
        'label' => 'Couleur de fond de la modal',
        'section' => 'isabel_modal_section',
        'priority' => 53,
    )));
}

/**
 * Fonctions d'affichage pour la modal
 */

// Fonction pour afficher le contenu de la modal
function isabel_display_modal_content() {
    echo '<h2 class="modal-title">';
    
    $modal_title_word = isabel_get_word_editor_content('isabel_modal_title_word', '');
    if (!empty($modal_title_word)) {
        echo $modal_title_word;
    } else {
        echo esc_html(isabel_get_option('isabel_modal_title', 'Réservez votre rendez-vous'));
    }
    
    echo '</h2>';
    
    echo '<p class="modal-subtitle">';
    
    $modal_subtitle_word = isabel_get_word_editor_content('isabel_modal_subtitle_word', '');
    if (!empty($modal_subtitle_word)) {
        echo $modal_subtitle_word;
    } else {
        echo esc_html(isabel_get_option('isabel_modal_subtitle', 'Première consultation personnalisée'));
    }
    
    echo '</p>';
}

// Fonction pour afficher le label d'un champ du formulaire
function isabel_display_modal_field_label($field) {
    $label_word = isabel_get_word_editor_content("isabel_modal_{$field}_label_word", '');
    if (!empty($label_word)) {
        echo $label_word;
    } else {
        // Labels par défaut
        $default_labels = array(
            'name' => 'Nom complet',
            'email' => 'Adresse email',
            'phone' => 'Téléphone',
            'service' => 'Type d\'accompagnement souhaité',
            'message' => 'Votre situation et objectifs'
        );
        echo esc_html($default_labels[$field] ?? 'Champ');
    }
}

// Fonction pour afficher le placeholder d'un champ
function isabel_display_modal_field_placeholder($field) {
    $placeholder = isabel_get_option("isabel_modal_{$field}_placeholder", '');
    if (!empty($placeholder)) {
        return esc_attr($placeholder);
    }
    
    // Placeholders par défaut
    $default_placeholders = array(
        'name' => 'Votre nom et prénom',
        'email' => 'votre@email.com',
        'phone' => '06 12 34 56 78',
        'service' => 'Choisissez une option',
        'message' => 'Décrivez-nous brièvement votre situation...'
    );
    
    return esc_attr($default_placeholders[$field] ?? '');
}

// Fonction pour afficher les options du champ service
function isabel_display_modal_service_options() {
    for ($i = 1; $i <= 4; $i++) {
        $option_text = isabel_get_option("isabel_modal_service_option_{$i}", '');
        if (!empty($option_text)) {
            echo '<option value="' . esc_attr($option_text) . '">' . esc_html($option_text) . '</option>';
        } else {
            // Options par défaut
            $default_options = array(
                1 => 'Coaching Personnel',
                2 => 'Accompagnement VAE',
                3 => 'Hypnocoaching',
                4 => 'Consultation Découverte'
            );
            if (isset($default_options[$i])) {
                echo '<option value="' . esc_attr($default_options[$i]) . '">' . esc_html($default_options[$i]) . '</option>';
            }
        }
    }
}

// Fonction pour afficher la note du formulaire
function isabel_display_modal_note() {
    $note_word = isabel_get_word_editor_content('isabel_modal_note_word', '');
    if (!empty($note_word)) {
        echo '<div class="form-note">';
        echo $note_word;
        echo '</div>';
    } else {
        echo '<div class="form-note">';
        echo '💼 Première consultation pour faire connaissance et définir vos besoins ensemble.';
        echo '</div>';
    }
}

// Fonction pour afficher le texte du bouton de soumission
function isabel_display_modal_submit_button() {
    $submit_button_word = isabel_get_word_editor_content('isabel_modal_submit_button_word', '');
    if (!empty($submit_button_word)) {
        echo $submit_button_word;
    } else {
        echo 'Confirmer ma demande de rendez-vous';
    }
}

// Fonction pour afficher les messages de retour
function isabel_display_modal_message($type = 'success') {
    if ($type === 'success') {
        $message_word = isabel_get_word_editor_content('isabel_modal_success_message_word', '');
        if (!empty($message_word)) {
            return $message_word;
        } else {
            return '🎉 Parfait ! Votre demande a été enregistrée et envoyée.';
        }
    } else {
        $message_word = isabel_get_word_editor_content('isabel_modal_error_message_word', '');
        if (!empty($message_word)) {
            return $message_word;
        } else {
            return '❌ Une erreur s\'est produite. Veuillez réessayer.';
        }
    }
}

// Fonction complète pour afficher le formulaire modal
function isabel_display_complete_modal_form() {
    ?>
    <form class="modal-form" id="contact-form" onsubmit="handleFormSubmit(event)">
        
        <div class="form-group">
            <label class="form-label"><?php isabel_display_modal_field_label('name'); ?></label>
            <input type="text" class="form-input" placeholder="<?php echo isabel_display_modal_field_placeholder('name'); ?>" name="name" required>
        </div>

        <div class="form-group">
            <label class="form-label"><?php isabel_display_modal_field_label('email'); ?></label>
            <input type="email" class="form-input" placeholder="<?php echo isabel_display_modal_field_placeholder('email'); ?>" name="email" required>
        </div>

        <div class="form-group">
            <label class="form-label"><?php isabel_display_modal_field_label('phone'); ?></label>
            <input type="tel" class="form-input" placeholder="<?php echo isabel_display_modal_field_placeholder('phone'); ?>" name="phone" required>
        </div>

        <div class="form-group">
            <label class="form-label"><?php isabel_display_modal_field_label('service'); ?></label>
            <select class="form-input" name="service" required>
                <option value=""><?php echo isabel_display_modal_field_placeholder('service'); ?></option>
                <?php isabel_display_modal_service_options(); ?>
            </select>
        </div>

        <div class="form-group">
            <label class="form-label"><?php isabel_display_modal_field_label('message'); ?></label>
            <textarea class="form-input form-textarea" placeholder="<?php echo isabel_display_modal_field_placeholder('message'); ?>" rows="4" name="message"></textarea>
        </div>

        <?php isabel_display_modal_note(); ?>

        <button type="submit" class="form-submit" id="submit-btn">
            <?php isabel_display_modal_submit_button(); ?>
        </button>
        
        <div id="form-messages" style="margin-top: 1rem;"></div>
    </form>
    <?php
}

?>