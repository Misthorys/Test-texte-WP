/**
 * Script de prévisualisation en temps réel pour le customizer Isabel
 * Permet de voir les changements de formatage instantanément
 */

(function($) {
    'use strict';

    // Configuration des éléments à prévisualiser
    const previewElements = {
        // Header
        'isabel_header_name': '.logo-name',
        'isabel_header_subtitle': '.logo-subtitle',
        
        // Hero section
        'isabel_main_name': '.profile-info h1',
        'isabel_subtitle': '.profile-subtitle',
        'isabel_intro_text': '.intro-text',
        'isabel_hero_badge': '.hero-badge',
        'isabel_main_button_text': '.cta-main span:last-child',
        
        // Services
        'isabel_services_title': '.services-section .section-title',
        'isabel_services_subtitle': '.services-section .section-subtitle',
        
        // Témoignages
        'isabel_testimonials_title': '.testimonials-section .section-title',
        'isabel_testimonials_subtitle': '.testimonials-section .section-subtitle',
        
        // CTA
        'isabel_cta_title': '.cta-title',
        'isabel_cta_text': '.cta-text',
        'isabel_cta_button': '.cta-button',
        
        // Modal
        'isabel_form_title': '.modal-title',
        'isabel_form_subtitle': '.modal-subtitle',
        
        // Qualiopi
        'isabel_qualiopi_title': '.qualiopi-text h3',
        'isabel_qualiopi_description': '.qualiopi-text p'
    };

    // Services individuels
    for (let i = 1; i <= 4; i++) {
        previewElements[`isabel_service${i}_title`] = `.service-card:nth-child(${i}) h3`;
        previewElements[`isabel_service${i}_desc`] = `.service-card:nth-child(${i}) p`;
    }

    /**
     * Fonction pour appliquer les styles en temps réel
     */
    function applyRealTimeStyles(settingBase, selector) {
        // Texte
        wp.customize(settingBase, function(value) {
            value.bind(function(newval) {
                $(selector).text(newval);
            });
        });

        // Taille de police
        wp.customize(settingBase + '_font_size', function(value) {
            value.bind(function(newval) {
                $(selector).css('font-size', newval + 'px');
            });
        });

        // Gras
        wp.customize(settingBase + '_bold', function(value) {
            value.bind(function(newval) {
                $(selector).css('font-weight', newval ? 'bold' : 'normal');
            });
        });

        // Italique
        wp.customize(settingBase + '_italic', function(value) {
            value.bind(function(newval) {
                $(selector).css('font-style', newval ? 'italic' : 'normal');
            });
        });

        // Couleur
        wp.customize(settingBase + '_color', function(value) {
            value.bind(function(newval) {
                $(selector).css('color', newval);
            });
        });

        // Ombre de texte
        wp.customize(settingBase + '_text_shadow', function(value) {
            value.bind(function(newval) {
                $(selector).css('text-shadow', newval ? '0 2px 4px rgba(0,0,0,0.3)' : 'none');
            });
        });

        // Hauteur de ligne
        wp.customize(settingBase + '_line_height', function(value) {
            value.bind(function(newval) {
                $(selector).css('line-height', newval);
            });
        });
    }

    /**
     * Prévisualisation des images
     */
    function setupImagePreviews() {
        // Image de profil principale
        wp.customize('isabel_profile_image', function(value) {
            value.bind(function(newval) {
                if (newval) {
                    $('.hero-profile-image, .mobile-profile-image').attr('src', newval);
                    $('.hero-profile-placeholder, .mobile-profile-placeholder').hide();
                    $('.hero-profile-image, .mobile-profile-image').show();
                } else {
                    $('.hero-profile-image, .mobile-profile-image').hide();
                    $('.hero-profile-placeholder, .mobile-profile-placeholder').show();
                }
            });
        });

        // Image de fond hero
        wp.customize('isabel_hero_background_image', function(value) {
            value.bind(function(newval) {
                if (newval) {
                    $('.hero-floating').css('background-image', 'url(' + newval + ')');
                    $('.hero-floating').addClass('has-bg-image').removeClass('no-bg-image');
                } else {
                    $('.hero-floating').css('background-image', 'none');
                    $('.hero-floating').addClass('no-bg-image').removeClass('has-bg-image');
                }
            });
        });

        // Image de profil mobile
        wp.customize('isabel_mobile_profile_image', function(value) {
            value.bind(function(newval) {
                if (newval) {
                    $('.mobile-profile-image').attr('src', newval);
                }
            });
        });

        // Logo header
        wp.customize('isabel_header_logo', function(value) {
            value.bind(function(newval) {
                if (newval) {
                    $('.logo-image').attr('src', newval).show();
                    $('.logo-placeholder').hide();
                } else {
                    $('.logo-image').hide();
                    $('.logo-placeholder').show();
                }
            });
        });

        // Logo Qualiopi
        wp.customize('isabel_qualiopi_logo', function(value) {
            value.bind(function(newval) {
                if (newval) {
                    $('.qualiopi-logo img').attr('src', newval);
                }
            });
        });
    }

    /**
     * Prévisualisation de la typographie globale
     */
    function setupGlobalTypography() {
        // Police principale
        wp.customize('isabel_main_font_family', function(value) {
            value.bind(function(newval) {
                $('body').css('font-family', newval);
            });
        });

        // Taille de base
        wp.customize('isabel_base_font_size', function(value) {
            value.bind(function(newval) {
                $('body').css('font-size', newval + 'px');
            });
        });
    }

    /**
     * Prévisualisation des couleurs
     */
    function setupColorPreviews() {
        wp.customize('isabel_primary_color', function(value) {
            value.bind(function(newval) {
                // Mettre à jour la variable CSS
                $(':root').get(0).style.setProperty('--rose-500', newval);
                
                // Appliquer aux éléments qui utilisent cette couleur
                $('.service-icon, .author-avatar, .step-number').css('background-color', newval);
                $('.service-card').css('border-color', newval);
            });
        });
    }

    /**
     * Prévisualisation des éléments de contenu spéciaux
     */
    function setupSpecialPreviews() {
        // Activation/désactivation Qualiopi
        wp.customize('isabel_qualiopi_enable', function(value) {
            value.bind(function(newval) {
                if (newval) {
                    $('.qualiopi-certification, .qualiopi-home-section').show();
                } else {
                    $('.qualiopi-certification, .qualiopi-home-section').hide();
                }
            });
        });

        // Images des boxes de services
        for (let i = 1; i <= 4; i++) {
            // Coaching
            wp.customize(`isabel_coaching_box${i}_image`, function(value) {
                value.bind(function(newval) {
                    if (newval) {
                        $(`.coaching-box-${i} .full-box-image-fixed`).attr('src', newval).show();
                        $(`.coaching-box-${i} .full-box-placeholder-fixed`).hide();
                    }
                });
            });

            // VAE
            wp.customize(`isabel_vae_box${i}_image`, function(value) {
                value.bind(function(newval) {
                    if (newval) {
                        $(`.vae-box-${i} .full-box-image-fixed`).attr('src', newval).show();
                        $(`.vae-box-${i} .full-box-placeholder-fixed`).hide();
                    }
                });
            });

            // Hypnocoaching
            wp.customize(`isabel_hypno_box${i}_image`, function(value) {
                value.bind(function(newval) {
                    if (newval) {
                        $(`.hypno-box-${i} .full-box-image-fixed`).attr('src', newval).show();
                        $(`.hypno-box-${i} .full-box-placeholder-fixed`).hide();
                    }
                });
            });
        }
    }

    /**
     * Prévisualisation avancée pour les éléments avec formatage multiple
     */
    function setupAdvancedPreviews() {
        // Boutons avec changement de texte et style
        wp.customize('isabel_main_button_text', function(value) {
            value.bind(function(newval) {
                $('.cta-main span:last-child, .btn-cta').text(newval);
            });
        });

        wp.customize('isabel_cta_button', function(value) {
            value.bind(function(newval) {
                $('.cta-button').text(newval);
            });
        });

        // Badges avec style spécial
        wp.customize('isabel_hero_badge', function(value) {
            value.bind(function(newval) {
                $('.hero-badge').contents().filter(function() {
                    return this.nodeType === 3; // Text nodes only
                }).first().replaceWith(newval);
            });
        });
    }

    /**
     * Fonction pour créer des effets visuels lors des changements
     */
    function addVisualFeedback() {
        // Effet de mise en surbrillance lors des changements
        function highlightElement(selector) {
            $(selector).addClass('customizer-highlight');
            setTimeout(function() {
                $(selector).removeClass('customizer-highlight');
            }, 1000);
        }

        // Ajouter les styles pour l'effet de surbrillance
        $('<style>')
            .prop('type', 'text/css')
            .html(`
                .customizer-highlight {
                    outline: 3px solid #0073aa !important;
                    outline-offset: 2px !important;
                    transition: outline 0.3s ease !important;
                }
            `)
            .appendTo('head');

        // Appliquer l'effet aux changements
        Object.keys(previewElements).forEach(function(settingBase) {
            const selector = previewElements[settingBase];
            
            wp.customize(settingBase, function(value) {
                value.bind(function() {
                    highlightElement(selector);
                });
            });
        });
    }

    /**
     * Prévisualisation responsive
     */
    function setupResponsivePreviews() {
        // Ajuster les prévisualisations selon la taille d'écran
        function adjustForScreenSize() {
            const width = $(window).width();
            
            if (width < 768) {
                // Mode mobile
                $('.hero-right').hide();
                $('.mobile-profile-section').show();
            } else {
                // Mode desktop/tablette
                $('.hero-right').show();
                $('.mobile-profile-section').hide();
            }
        }

        $(window).on('resize', adjustForScreenSize);
        adjustForScreenSize(); // Appel initial
    }

    /**
     * Messages informatifs dans le customizer
     */
    function setupCustomizerMessages() {
        // Ajouter des messages d'aide
        wp.customize.bind('ready', function() {
            // Message de bienvenue
            wp.customize.notifications.add('isabel_welcome', new wp.customize.Notification('isabel_welcome', {
                type: 'info',
                message: '🎨 Bienvenue dans le customizer avancé Isabel ! Tous vos changements sont visibles en temps réel.'
            }));

            // Conseils d'utilisation
            setTimeout(function() {
                wp.customize.notifications.add('isabel_tips', new wp.customize.Notification('isabel_tips', {
                    type: 'success',
                    message: '💡 Astuce : Utilisez les curseurs pour ajuster les tailles de police et voyez le résultat instantanément !'
                }));
            }, 3000);

            // Supprimer les messages après un délai
            setTimeout(function() {
                wp.customize.notifications.remove('isabel_welcome');
                wp.customize.notifications.remove('isabel_tips');
            }, 10000);
        });
    }

    /**
     * Sauvegarde automatique des modifications
     */
    function setupAutoSave() {
        let saveTimeout;
        
        wp.customize.bind('change', function() {
            clearTimeout(saveTimeout);
            
            // Afficher un indicateur de sauvegarde
            wp.customize.notifications.add('isabel_saving', new wp.customize.Notification('isabel_saving', {
                type: 'info',
                message: '💾 Sauvegarde automatique en cours...'
            }));
            
            saveTimeout = setTimeout(function() {
                wp.customize.notifications.remove('isabel_saving');
                wp.customize.notifications.add('isabel_saved', new wp.customize.Notification('isabel_saved', {
                    type: 'success',
                    message: '✅ Modifications sauvegardées !'
                }));
                
                setTimeout(function() {
                    wp.customize.notifications.remove('isabel_saved');
                }, 2000);
            }, 1000);
        });
    }

    /**
     * Initialisation principale
     */
    function initCustomizerPreview() {
        console.log('🎨 Initialisation du preview customizer Isabel...');

        // Configurer toutes les prévisualisations
        Object.keys(previewElements).forEach(function(settingBase) {
            const selector = previewElements[settingBase];
            applyRealTimeStyles(settingBase, selector);
        });

        // Configurer les autres types de prévisualisations
        setupImagePreviews();
        setupGlobalTypography();
        setupColorPreviews();
        setupSpecialPreviews();
        setupAdvancedPreviews();
        setupResponsivePreviews();
        
        // Fonctionnalités avancées
        addVisualFeedback();
        setupCustomizerMessages();
        setupAutoSave();

        console.log('✅ Preview customizer Isabel initialisé !');
    }

    // Lancer l'initialisation quand le customizer est prêt
    wp.customize.bind('ready', function() {
        initCustomizerPreview();
    });

    // Support pour les changements de device (responsive)
    wp.customize.previewedDevice.bind(function(device) {
        $('body').removeClass('preview-desktop preview-tablet preview-mobile')
                 .addClass('preview-' + device);
    });

})(jQuery);