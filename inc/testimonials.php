<?php
// Empêcher l'accès direct au fichier
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Gestion complète des témoignages
 * - Type de contenu personnalisé
 * - Champs personnalisés
 * - Interface d'administration
 */

// ========================================
// CRÉATION DU TYPE DE CONTENU TÉMOIGNAGES
// ========================================

// Créer un type de contenu personnalisé pour les témoignages
function isabel_create_testimonial_post_type() {
    register_post_type('testimonial', array(
        'labels' => array(
            'name' => 'Témoignages',
            'singular_name' => 'Témoignage',
            'add_new' => 'Ajouter un témoignage',
            'add_new_item' => 'Ajouter un nouveau témoignage',
            'edit_item' => 'Modifier le témoignage',
            'new_item' => 'Nouveau témoignage',
            'view_item' => 'Voir le témoignage',
            'search_items' => 'Chercher des témoignages',
            'not_found' => 'Aucun témoignage trouvé',
            'not_found_in_trash' => 'Aucun témoignage dans la corbeille'
        ),
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_icon' => 'dashicons-format-chat',
        'supports' => array('title', 'editor'),
        'menu_position' => 20
    ));
}
add_action('init', 'isabel_create_testimonial_post_type');

// ========================================
// CHAMPS PERSONNALISÉS POUR LES TÉMOIGNAGES
// ========================================

// Ajouter des champs personnalisés pour les témoignages
function isabel_add_testimonial_meta_boxes() {
    add_meta_box(
        'testimonial-details',
        'Détails du témoignage',
        'isabel_testimonial_meta_box_callback',
        'testimonial',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'isabel_add_testimonial_meta_boxes');

function isabel_testimonial_meta_box_callback($post) {
    wp_nonce_field('isabel_save_testimonial_data', 'isabel_testimonial_nonce');
    
    $author_name = get_post_meta($post->ID, '_testimonial_author_name', true);
    $author_title = get_post_meta($post->ID, '_testimonial_author_title', true);
    $author_initials = get_post_meta($post->ID, '_testimonial_author_initials', true);
    
    echo '<table class="form-table">';
    echo '<tr><th><label for="testimonial_author_name">Nom du client</label></th>';
    echo '<td><input type="text" id="testimonial_author_name" name="testimonial_author_name" value="' . esc_attr($author_name) . '" style="width: 100%;" /></td></tr>';
    
    echo '<tr><th><label for="testimonial_author_title">Fonction/Titre</label></th>';
    echo '<td><input type="text" id="testimonial_author_title" name="testimonial_author_title" value="' . esc_attr($author_title) . '" style="width: 100%;" /></td></tr>';
    
    echo '<tr><th><label for="testimonial_author_initials">Initiales</label></th>';
    echo '<td><input type="text" id="testimonial_author_initials" name="testimonial_author_initials" value="' . esc_attr($author_initials) . '" placeholder="Ex: ML" style="width: 100px;" />';
    echo '<p class="description">Ces initiales apparaîtront dans l\'avatar du témoignage</p></td></tr>';
    echo '</table>';
}

// Sauvegarder les données des témoignages
function isabel_save_testimonial_data($post_id) {
    if (!isset($_POST['isabel_testimonial_nonce']) || !wp_verify_nonce($_POST['isabel_testimonial_nonce'], 'isabel_save_testimonial_data')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;
    
    if (isset($_POST['testimonial_author_name'])) {
        update_post_meta($post_id, '_testimonial_author_name', sanitize_text_field($_POST['testimonial_author_name']));
    }
    if (isset($_POST['testimonial_author_title'])) {
        update_post_meta($post_id, '_testimonial_author_title', sanitize_text_field($_POST['testimonial_author_title']));
    }
    if (isset($_POST['testimonial_author_initials'])) {
        update_post_meta($post_id, '_testimonial_author_initials', sanitize_text_field($_POST['testimonial_author_initials']));
    }
}
add_action('save_post', 'isabel_save_testimonial_data');

// ========================================
// FONCTIONS UTILITAIRES POUR LES TÉMOIGNAGES
// ========================================

/**
 * Récupérer tous les témoignages publiés
 * @return array
 */
function isabel_get_testimonials() {
    $testimonials = get_posts(array(
        'post_type' => 'testimonial',
        'post_status' => 'publish',
        'numberposts' => -1,
        'orderby' => 'date',
        'order' => 'DESC'
    ));
    
    $formatted_testimonials = array();
    
    foreach ($testimonials as $testimonial) {
        $formatted_testimonials[] = array(
            'id' => $testimonial->ID,
            'content' => get_the_content(null, false, $testimonial),
            'author_name' => get_post_meta($testimonial->ID, '_testimonial_author_name', true),
            'author_title' => get_post_meta($testimonial->ID, '_testimonial_author_title', true),
            'author_initials' => get_post_meta($testimonial->ID, '_testimonial_author_initials', true),
            'date' => $testimonial->post_date
        );
    }
    
    return $formatted_testimonials;
}

/**
 * Afficher les témoignages sous forme de HTML
 * @param int $limit Nombre de témoignages à afficher
 * @return string
 */
function isabel_display_testimonials($limit = -1) {
    $testimonials = isabel_get_testimonials();
    
    if (empty($testimonials)) {
        return '<p>Aucun témoignage disponible pour le moment.</p>';
    }
    
    if ($limit > 0) {
        $testimonials = array_slice($testimonials, 0, $limit);
    }
    
    $html = '<div class="isabel-testimonials">';
    
    foreach ($testimonials as $testimonial) {
        $initials = !empty($testimonial['author_initials']) ? $testimonial['author_initials'] : substr($testimonial['author_name'], 0, 2);
        
        $html .= '<div class="testimonial-item">';
        $html .= '<div class="testimonial-content">';
        $html .= '<blockquote>' . wp_kses_post($testimonial['content']) . '</blockquote>';
        $html .= '</div>';
        $html .= '<div class="testimonial-author">';
        $html .= '<div class="author-avatar">' . esc_html($initials) . '</div>';
        $html .= '<div class="author-info">';
        $html .= '<div class="author-name">' . esc_html($testimonial['author_name']) . '</div>';
        if (!empty($testimonial['author_title'])) {
            $html .= '<div class="author-title">' . esc_html($testimonial['author_title']) . '</div>';
        }
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
    }
    
    $html .= '</div>';
    
    return $html;
}

// ========================================
// PERSONNALISATION DE L'INTERFACE ADMIN
// ========================================

// Modifier les colonnes de la liste des témoignages
function isabel_testimonial_columns($columns) {
    $new_columns = array();
    $new_columns['cb'] = $columns['cb'];
    $new_columns['title'] = 'Témoignage';
    $new_columns['author_name'] = 'Nom du client';
    $new_columns['author_title'] = 'Fonction';
    $new_columns['date'] = $columns['date'];
    
    return $new_columns;
}
add_filter('manage_testimonial_posts_columns', 'isabel_testimonial_columns');

// Remplir les colonnes personnalisées
function isabel_testimonial_column_content($column, $post_id) {
    switch ($column) {
        case 'author_name':
            echo esc_html(get_post_meta($post_id, '_testimonial_author_name', true));
            break;
        case 'author_title':
            echo esc_html(get_post_meta($post_id, '_testimonial_author_title', true));
            break;
    }
}
add_action('manage_testimonial_posts_custom_column', 'isabel_testimonial_column_content', 10, 2);

// Rendre les colonnes triables
function isabel_testimonial_sortable_columns($columns) {
    $columns['author_name'] = 'author_name';
    return $columns;
}
add_filter('manage_edit-testimonial_sortable_columns', 'isabel_testimonial_sortable_columns');

// Ajouter des instructions pour l'utilisateur
function isabel_testimonial_help_text() {
    $screen = get_current_screen();
    if ($screen->post_type == 'testimonial') {
        echo '<div class="notice notice-info">';
        echo '<p><strong>💡 Comment utiliser les témoignages :</strong></p>';
        echo '<ul>';
        echo '<li>📝 <strong>Titre :</strong> Un titre court pour identifier le témoignage (non affiché publiquement)</li>';
        echo '<li>💬 <strong>Contenu :</strong> Le témoignage complet du client</li>';
        echo '<li>👤 <strong>Nom du client :</strong> Le nom complet (peut être anonymisé)</li>';
        echo '<li>💼 <strong>Fonction :</strong> Le métier ou la fonction du client</li>';
        echo '<li>🔤 <strong>Initiales :</strong> Pour l\'avatar (ex: ML pour Marie Leroy)</li>';
        echo '</ul>';
        echo '</div>';
    }
}
add_action('admin_notices', 'isabel_testimonial_help_text');