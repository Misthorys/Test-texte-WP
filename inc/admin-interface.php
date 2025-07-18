<?php
// Empêcher l'accès direct au fichier
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Interface d'administration pour le thème Isabel
 * - Page de gestion des contacts
 * - Page de configuration
 * - Widget dashboard
 * - Styles admin
 */

// ========================================
// CRÉATION DES MENUS D'ADMINISTRATION
// ========================================

// Créer un menu pour voir les contacts reçus
function isabel_admin_menu() {
    add_theme_page(
        'Configuration Isabel',
        'Configuration Isabel',
        'manage_options',
        'isabel-settings',
        'isabel_settings_page'
    );
    
    add_menu_page(
        'Demandes de contact',
        'Contacts reçus',
        'manage_options',
        'isabel-contacts',
        'isabel_contacts_page',
        'dashicons-email-alt',
        25
    );
}
add_action('admin_menu', 'isabel_admin_menu');

// ========================================
// PAGE DE GESTION DES CONTACTS
// ========================================

function isabel_contacts_page() {
    global $wpdb;
    
    $table_name = $wpdb->prefix . 'isabel_contacts';
    
    // Vérifier si la table existe
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        isabel_create_contacts_table();
    }
    
    $contacts = $wpdb->get_results("SELECT * FROM $table_name ORDER BY created_at DESC");
    
    ?>
    <div class="wrap">
        <h1>📧 Demandes de contact reçues</h1>
        
        <?php if (empty($contacts)): ?>
            <div class="notice notice-info">
                <p>Aucune demande de contact reçue pour le moment.</p>
                <p><strong>Note :</strong> Les demandes sont automatiquement sauvegardées ici quand quelqu'un remplit le formulaire sur votre site.</p>
            </div>
        <?php else: ?>
            <div class="notice notice-success" style="margin-bottom: 20px;">
                <p><strong><?php echo count($contacts); ?> demande(s) de contact</strong> - Les plus récentes en premier</p>
            </div>
            
            <table class="wp-list-table widefat fixed striped" id="contacts-table">
                <thead>
                    <tr>
                        <th style="width: 120px;">Date</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Téléphone</th>
                        <th>Service</th>
                        <th>Message</th>
                        <th style="width: 100px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($contacts as $contact): ?>
                        <tr id="contact-<?php echo $contact->id; ?>">
                            <td><?php echo date('d/m/Y H:i', strtotime($contact->created_at)); ?></td>
                            <td><strong><?php echo esc_html($contact->name); ?></strong></td>
                            <td><a href="mailto:<?php echo esc_attr($contact->email); ?>" style="color: #0073aa;"><?php echo esc_html($contact->email); ?></a></td>
                            <td><a href="tel:<?php echo esc_attr($contact->phone); ?>" style="color: #0073aa;"><?php echo esc_html($contact->phone); ?></a></td>
                            <td><span style="background: #e4a7f5; color: white; padding: 3px 8px; border-radius: 12px; font-size: 11px;"><?php echo esc_html($contact->service); ?></span></td>
                            <td style="max-width: 300px;">
                                <?php 
                                $message = esc_html($contact->message);
                                if (strlen($message) > 100) {
                                    echo '<span title="' . $message . '">' . substr($message, 0, 100) . '...</span>';
                                } else {
                                    echo $message;
                                }
                                ?>
                            </td>
                            <td>
                                <button type="button" class="button button-small button-link-delete delete-contact" 
                                        data-contact-id="<?php echo $contact->id; ?>"
                                        onclick="deleteContact(<?php echo $contact->id; ?>)"
                                        style="color: #d63384;">
                                    🗑️ Supprimer
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
        
        <div style="margin-top: 30px; padding: 20px; background: #f9f9f9; border-radius: 8px;">
            <h3>📊 Statistiques</h3>
            <p><strong>Total des demandes :</strong> <?php echo count($contacts); ?></p>
            <?php if (!empty($contacts)): ?>
                <p><strong>Dernière demande :</strong> <?php echo date('d/m/Y à H:i', strtotime($contacts[0]->created_at)); ?></p>
                
                <?php
                // Statistiques par service
                $services_stats = array();
                foreach ($contacts as $contact) {
                    $service = $contact->service;
                    if (!isset($services_stats[$service])) {
                        $services_stats[$service] = 0;
                    }
                    $services_stats[$service]++;
                }
                ?>
                
                <h4>📈 Demandes par service :</h4>
                <ul>
                    <?php foreach ($services_stats as $service => $count): ?>
                        <li><strong><?php echo esc_html($service); ?> :</strong> <?php echo $count; ?> demande(s)</li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
    
    <script>
    function deleteContact(contactId) {
        if (!confirm('Êtes-vous sûr de vouloir supprimer cette demande de contact ?')) {
            return;
        }
        
        const row = document.getElementById('contact-' + contactId);
        const originalContent = row.innerHTML;
        
        // Animation de suppression
        row.style.opacity = '0.5';
        row.innerHTML = '<td colspan="7" style="text-align: center; padding: 20px;">🗑️ Suppression en cours...</td>';
        
        // Envoi AJAX
        fetch(ajaxurl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                action: 'isabel_delete_contact',
                contact_id: contactId,
                nonce: '<?php echo wp_create_nonce('isabel_delete_contact_nonce'); ?>'
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Animation de suppression réussie
                row.style.backgroundColor = '#d4edda';
                row.innerHTML = '<td colspan="7" style="text-align: center; padding: 20px; color: #155724;">✅ Contact supprimé avec succès</td>';
                
                setTimeout(() => {
                    row.remove();
                    // Mettre à jour le compteur
                    location.reload();
                }, 1500);
            } else {
                // Restaurer en cas d'erreur
                row.style.opacity = '1';
                row.style.backgroundColor = '#f8d7da';
                row.innerHTML = '<td colspan="7" style="text-align: center; padding: 20px; color: #721c24;">❌ Erreur: ' + (data.data || 'Impossible de supprimer') + '</td>';
                
                setTimeout(() => {
                    row.style.backgroundColor = '';
                    row.innerHTML = originalContent;
                }, 3000);
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            row.style.opacity = '1';
            row.style.backgroundColor = '#f8d7da';
            row.innerHTML = '<td colspan="7" style="text-align: center; padding: 20px; color: #721c24;">❌ Erreur de connexion</td>';
            
            setTimeout(() => {
                row.style.backgroundColor = '';
                row.innerHTML = originalContent;
            }, 3000);
        });
    }
    </script>
    <?php
}

// ========================================
// PAGE DE CONFIGURATION DU THÈME
// ========================================

function isabel_settings_page() {
    // Obtenir des statistiques
    global $wpdb;
    $table_name = $wpdb->prefix . 'isabel_contacts';
    $contact_count = $wpdb->get_var("SELECT COUNT(*) FROM $table_name");
    $testimonial_count = wp_count_posts('testimonial')->publish;
    
    ?>
    <div class="wrap">
        <h1>🎨 Configuration du thème Isabel GONCALVES</h1>
        
        <div style="background: white; padding: 20px; border-radius: 8px; margin: 20px 0; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            <h2>✨ Félicitations ! Votre thème est installé</h2>
            <p><strong>🎨 Page entièrement modifiable depuis le customizer !</strong></p>
            <p><strong>📧 Le formulaire de contact envoie les emails à : contact@forma-coach.com</strong></p>
            <p><strong>💾 Les demandes sont automatiquement sauvegardées dans la base de données</strong></p>
            <p><strong>🗑️ Vous pouvez maintenant supprimer les contacts traités</strong></p>
            <p><strong>🆕 3 pages de services créées automatiquement !</strong></p>
        </div>
        
        <!-- Statistiques rapides -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin: 20px 0;">
            <div style="background: #e4a7f5; color: white; padding: 20px; border-radius: 8px; text-align: center;">
                <h3 style="margin: 0; font-size: 2em;"><?php echo $contact_count; ?></h3>
                <p style="margin: 5px 0 0 0;">Contacts reçus</p>
            </div>
            <div style="background: #4CAF50; color: white; padding: 20px; border-radius: 8px; text-align: center;">
                <h3 style="margin: 0; font-size: 2em;"><?php echo $testimonial_count; ?></h3>
                <p style="margin: 5px 0 0 0;">Témoignages publiés</p>
            </div>
            <div style="background: #2196F3; color: white; padding: 20px; border-radius: 8px; text-align: center;">
                <h3 style="margin: 0; font-size: 2em;">3</h3>
                <p style="margin: 5px 0 0 0;">Pages de services</p>
            </div>
        </div>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 30px;">
            
            <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <h3>📝 Modifier TOUT le contenu</h3>
                <p>Allez dans <strong>Apparence > Personnaliser</strong></p>
                <ul style="margin-left: 20px;">
                    <li>📷 Image de profil</li>
                    <li>🏠 Section d'accueil (complète)</li>
                    <li>🎁 Barre d'alerte</li>
                    <li>🎯 Services (titre + 3 services)</li>
                    <li>💬 Témoignages</li>
                    <li>📞 Call-to-Action final</li>
                    <li>📝 Formulaire de contact</li>
                    <li>📄 Footer (contacts)</li>
                    <li>🎨 Couleurs</li>
                    <li>🎯 Page Coaching Personnel</li>
                    <li>🎓 Page Accompagnement VAE</li>
                    <li>🧘 Page Hypnocoaching</li>
                </ul>
                <a href="<?php echo admin_url('customize.php'); ?>" class="button button-primary" style="margin-top: 10px;">Personnaliser maintenant</a>
            </div>
            
            <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <h3>💬 Gérer les témoignages</h3>
                <p>Ajoutez/modifiez vos témoignages clients</p>
                <ul style="margin-left: 20px;">
                    <li>Nom du client</li>
                    <li>Fonction/titre</li>
                    <li>Initiales pour l'avatar</li>
                    <li>Contenu du témoignage</li>
                </ul>
                <a href="<?php echo admin_url('edit.php?post_type=testimonial'); ?>" class="button button-primary" style="margin-top: 10px;">Gérer les témoignages</a>
            </div>
            
        </div>
        
        <!-- Liens rapides -->
        <div style="background: white; padding: 20px; border-radius: 8px; margin: 20px 0; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            <h3>🔗 Liens rapides</h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 10px;">
                <a href="<?php echo admin_url('admin.php?page=isabel-contacts'); ?>" class="button">📧 Voir les contacts</a>
                <a href="<?php echo admin_url('customize.php'); ?>" class="button">🎨 Personnaliser</a>
                <a href="<?php echo admin_url('edit.php?post_type=testimonial'); ?>" class="button">💬 Témoignages</a>
                <a href="<?php echo home_url(); ?>" class="button" target="_blank">🌐 Voir le site</a>
                <a href="<?php echo home_url('/coaching-personnel'); ?>" class="button" target="_blank">🎯 Page Coaching</a>
                <a href="<?php echo home_url('/accompagnement-vae'); ?>" class="button" target="_blank">🎓 Page VAE</a>
                <a href="<?php echo home_url('/hypnocoaching'); ?>" class="button" target="_blank">🧘 Page Hypno</a>
            </div>
        </div>
        
        <div style="background: #e8f5e8; padding: 20px; border-radius: 8px; margin: 30px 0; border-left: 4px solid #00a32a;">
            <h3>🚀 Prochaines étapes recommandées</h3>
            <ol style="margin-left: 20px;">
                <li><strong>Ajoutez votre photo :</strong> Apparence > Personnaliser > Image de profil</li>
                <li><strong>Modifiez tous les textes :</strong> Apparence > Personnaliser</li>
                <li><strong>Ajoutez vos témoignages :</strong> Témoignages > Ajouter</li>
                <li><strong>Gérez les contacts :</strong> Supprimez ceux traités</li>
                <li><strong>Personnalisez les pages de services :</strong> Coaching, VAE, Hypnocoaching</li>
                <li><strong>Testez le formulaire :</strong> Remplissez-le depuis votre site</li>
            </ol>
        </div>
        
        <!-- Informations techniques -->
        <div style="background: #f0f8ff; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #0073aa;">
            <h3>⚙️ Informations techniques</h3>
            <ul style="margin-left: 20px;">
                <li><strong>Version du thème :</strong> 1.0.0</li>
                <li><strong>Base de données :</strong> Table <?php echo $table_name; ?> créée</li>
                <li><strong>Email de réception :</strong> contact@forma-coach.com</li>
                <li><strong>Pages créées :</strong> /coaching-personnel, /accompagnement-vae, /hypnocoaching</li>
                <li><strong>Organisation :</strong> Fichiers séparés dans /inc/</li>
            </ul>
        </div>
        
    </div>
    <?php
}

// ========================================
// WIDGET DASHBOARD POUR LES CONTACTS RÉCENTS
// ========================================

// Widget de dashboard pour les contacts récents
add_action('wp_dashboard_setup', function() {
    wp_add_dashboard_widget(
        'isabel_recent_contacts',
        '📧 Contacts récents - Isabel',
        'isabel_dashboard_widget'
    );
});

function isabel_dashboard_widget() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'isabel_contacts';
    
    $recent_contacts = $wpdb->get_results(
        "SELECT * FROM $table_name ORDER BY created_at DESC LIMIT 5"
    );
    
    if (empty($recent_contacts)) {
        echo '<p>Aucun contact récent.</p>';
        echo '<p><a href="' . admin_url('admin.php?page=isabel-contacts') . '">Gérer les contacts</a></p>';
        return;
    }
    
    echo '<table style="width: 100%; font-size: 12px;">';
    echo '<thead><tr style="background: #f9f9f9;"><th>Date</th><th>Nom</th><th>Service</th><th>Email</th></tr></thead>';
    echo '<tbody>';
    
    foreach ($recent_contacts as $contact) {
        echo '<tr>';
        echo '<td>' . date('d/m H:i', strtotime($contact->created_at)) . '</td>';
        echo '<td><strong>' . esc_html($contact->name) . '</strong></td>';
        echo '<td><span style="background: #e4a7f5; color: white; padding: 2px 6px; border-radius: 8px; font-size: 10px;">' . esc_html($contact->service) . '</span></td>';
        echo '<td><a href="mailto:' . esc_attr($contact->email) . '">' . esc_html($contact->email) . '</a></td>';
        echo '</tr>';
    }
    
    echo '</tbody></table>';
    echo '<p style="text-align: center; margin-top: 10px;">';
    echo '<a href="' . admin_url('admin.php?page=isabel-contacts') . '" class="button button-primary button-small">Voir tous les contacts</a>';
    echo '</p>';
}

// ========================================
// STYLES CSS POUR L'INTERFACE ADMIN
// ========================================

// Ajouter des styles CSS pour l'admin
add_action('admin_head', function() {
    echo '<style>
        .isabel-admin-icon { color: #e4a7f5; }
        #isabel_recent_contacts .inside { padding: 12px; }
        #isabel_recent_contacts table { border-collapse: collapse; }
        #isabel_recent_contacts th, #isabel_recent_contacts td { 
            padding: 8px 4px; 
            border-bottom: 1px solid #eee; 
            text-align: left; 
        }
        .delete-contact:hover {
            background-color: #d63384 !important;
            color: white !important;
        }
        
        /* Styles pour la page de configuration */
        .isabel-config-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin: 20px 0;
        }
        
        .isabel-stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin: 20px 0;
        }
        
        .isabel-stat-card {
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            color: white;
        }
        
        .isabel-links-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 10px;
        }
        
        /* Animation pour les notifications */
        .isabel-notification {
            animation: slideInDown 0.5s ease-out;
        }
        
        @keyframes slideInDown {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
        
        /* Styles pour les boutons personnalisés */
        .isabel-button {
            background: linear-gradient(135deg, #e4a7f5, #c47dd9);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
        }
        
        .isabel-button:hover {
            background: linear-gradient(135deg, #c47dd9, #a85fcb);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
    </style>';
});

// ========================================
// NOTIFICATIONS ADMIN
// ========================================

/**
 * Afficher une notification si aucun témoignage n'est publié
 */
function isabel_admin_notices() {
    $screen = get_current_screen();
    
    // Vérifier si on est sur une page du thème Isabel
    if (strpos($screen->id, 'isabel') !== false || $screen->base === 'dashboard') {
        $testimonial_count = wp_count_posts('testimonial')->publish;
        
        if ($testimonial_count == 0) {
            echo '<div class="notice notice-warning isabel-notification">';
            echo '<p><strong>💬 Ajoutez vos premiers témoignages !</strong> ';
            echo 'Vos témoignages clients renforcent votre crédibilité. ';
            echo '<a href="' . admin_url('post-new.php?post_type=testimonial') . '">Ajouter un témoignage</a></p>';
            echo '</div>';
        }
    }
}
add_action('admin_notices', 'isabel_admin_notices');

/**
 * Notification de bienvenue lors de l'activation
 */
function isabel_activation_notice() {
    if (get_transient('isabel_activation_notice')) {
        echo '<div class="notice notice-success is-dismissible isabel-notification">';
        echo '<p><strong>🎉 Thème Isabel activé avec succès !</strong> ';
        echo 'Commencez par <a href="' . admin_url('admin.php?page=isabel-settings') . '">configurer votre thème</a> ';
        echo 'ou <a href="' . admin_url('customize.php') . '">personnaliser le contenu</a>.</p>';
        echo '</div>';
        delete_transient('isabel_activation_notice');
    }
}
add_action('admin_notices', 'isabel_activation_notice');

// Créer la notification lors de l'activation
add_action('after_switch_theme', function() {
    set_transient('isabel_activation_notice', true, 60);
});