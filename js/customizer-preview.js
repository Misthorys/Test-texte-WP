/**
 * CORRECTION COMPLÈTE - Synchronisation Customizer Word-like
 * Résout les bugs de mise à jour en temps réel
 */

(function($) {
    'use strict';

    // Configuration globale
    const IsabelSync = {
        debug: true,
        instances: {},
        previewWindow: null,
        
        // Mapping des settings vers les sélecteurs CSS dans le preview
        settingsMap: {
            // Hero section
            'isabel_main_name_word': '.profile-info, .profile-info h1',
            'isabel_subtitle_word': '.profile-subtitle, .profile-subtitle p',
            'isabel_intro_text_word': '.intro-text, .intro-text p',
            'isabel_hero_badge_word': '.hero-badge',
            'isabel_main_button_text_word': '.cta-main span:last-child',
            
            // Services - 4 services complets
            'isabel_services_title_word': '.services-section .section-title, .services-section h2',
            'isabel_services_subtitle_word': '.services-section .section-subtitle, .services-section p',
            
            // Services individuels
            'isabel_service1_title_word': '.service-card:nth-child(1) h3, .service-card:nth-child(1) .service-title-container',
            'isabel_service1_desc_word': '.service-card:nth-child(1) p, .service-card:nth-child(1) .service-description-container',
            'isabel_service2_title_word': '.service-card:nth-child(2) h3, .service-card:nth-child(2) .service-title-container',
            'isabel_service2_desc_word': '.service-card:nth-child(2) p, .service-card:nth-child(2) .service-description-container',
            'isabel_service3_title_word': '.service-card:nth-child(3) h3, .service-card:nth-child(3) .service-title-container',
            'isabel_service3_desc_word': '.service-card:nth-child(3) p, .service-card:nth-child(3) .service-description-container',
            'isabel_service4_title_word': '.service-card:nth-child(4) h3, .service-card:nth-child(4) .service-title-container',
            'isabel_service4_desc_word': '.service-card:nth-child(4) p, .service-card:nth-child(4) .service-description-container',
            
            // Témoignages
            'isabel_testimonials_title_word': '.testimonials-section .section-title, .testimonials-section h2',
            'isabel_testimonials_subtitle_word': '.testimonials-section .section-subtitle, .testimonials-section p',
            
            // CTA finale
            'isabel_cta_title_word': '.cta-title, .cta-box h2',
            'isabel_cta_text_word': '.cta-text, .cta-box p',
            'isabel_cta_button_word': '.cta-button',
            
            // Modal
            'isabel_modal_title_word': '.modal-title',
            'isabel_modal_subtitle_word': '.modal-subtitle',
            
            // Header
            'isabel_header_name_word': '.logo-name',
            'isabel_header_subtitle_word': '.logo-subtitle',
            
            // Footer
            'isabel_footer_name_word': '.footer h3',
            'isabel_footer_description_word': '.footer p',
            
            // Pages de services - Coaching
            'isabel_coaching_title_word': '.page-header h1',
            'isabel_coaching_subtitle_word': '.page-header .subtitle',
            'isabel_coaching_box1_title_word': '.coaching-box-1 h3',
            'isabel_coaching_box1_text_word': '.coaching-box-1 p',
            'isabel_coaching_box2_title_word': '.coaching-box-2 h3',
            'isabel_coaching_box2_text_word': '.coaching-box-2 p',
            'isabel_coaching_box3_title_word': '.coaching-box-3 h3',
            'isabel_coaching_box3_text_word': '.coaching-box-3 p',
            'isabel_coaching_box4_title_word': '.coaching-box-4 h3',
            'isabel_coaching_box4_text_word': '.coaching-box-4 p',
            'isabel_coaching_cta_word': '.cta-service',
            
            // Pages de services - VAE
            'isabel_vae_title_word': '.page-header h1',
            'isabel_vae_subtitle_word': '.page-header .subtitle',
            'isabel_vae_box1_title_word': '.vae-box-1 h3',
            'isabel_vae_box1_text_word': '.vae-box-1 p',
            'isabel_vae_box2_title_word': '.vae-box-2 h3',
            'isabel_vae_box2_text_word': '.vae-box-2 p',
            'isabel_vae_box3_title_word': '.vae-box-3 h3',
            'isabel_vae_box3_text_word': '.vae-box-3 p',
            'isabel_vae_box4_title_word': '.vae-box-4 h3',
            'isabel_vae_box4_text_word': '.vae-box-4 p',
            'isabel_vae_cta_word': '.cta-service',
            
            // Pages de services - Hypnocoaching
            'isabel_hypno_title_word': '.page-header h1',
            'isabel_hypno_subtitle_word': '.page-header .subtitle',
            'isabel_hypno_box1_title_word': '.hypno-box-1 h3',
            'isabel_hypno_box1_text_word': '.hypno-box-1 p',
            'isabel_hypno_box2_title_word': '.hypno-box-2 h3',
            'isabel_hypno_box2_text_word': '.hypno-box-2 p',
            'isabel_hypno_box3_title_word': '.hypno-box-3 h3',
            'isabel_hypno_box3_text_word': '.hypno-box-3 p',
            'isabel_hypno_box4_title_word': '.hypno-box-4 h3',
            'isabel_hypno_box4_text_word': '.hypno-box-4 p',
            'isabel_hypno_cta_word': '.cta-service',
            
            // Pages de services - Consultation
            'isabel_consultation_title_word': '.page-header h1',
            'isabel_consultation_subtitle_word': '.page-header .subtitle',
            'isabel_consultation_box1_title_word': '.consultation-box-1 h3',
            'isabel_consultation_box1_text_word': '.consultation-box-1 p',
            'isabel_consultation_box2_title_word': '.consultation-box-2 h3',
            'isabel_consultation_box2_text_word': '.consultation-box-2 p',
            'isabel_consultation_box3_title_word': '.consultation-box-3 h3',
            'isabel_consultation_box3_text_word': '.consultation-box-3 p',
            'isabel_consultation_box4_title_word': '.consultation-box-4 h3',
            'isabel_consultation_box4_text_word': '.consultation-box-4 p',
            'isabel_consultation_cta_word': '.cta-service',
            'isabel_consultation_highlight_word': '.consultation-highlight',
            
            // Qualiopi
            'isabel_qualiopi_title_word': '.qualiopi-text h3',
            'isabel_qualiopi_description_word': '.qualiopi-text p',
            'isabel_qualiopi_number_word': '.qualiopi-number',
            'isabel_qualiopi_date_word': '.qualiopi-date'
        }
    };

    /**
     * Initialisation du système de synchronisation
     */
    function initSyncSystem() {
        if (typeof wp === 'undefined' || !wp.customize) {
            console.log('❌ WordPress Customizer non disponible');
            return;
        }

        IsabelSync.previewWindow = window.parent;
        
        console.log('🔄 Initialisation du système de synchronisation Isabel...');
        
        // Attendre que le customizer soit prêt
        wp.customize.bind('ready', function() {
            setupRealtimeSync();
            setupWordEditorSync();
            console.log('✅ Système de synchronisation Isabel prêt !');
        });
    }

    /**
     * Configuration de la synchronisation temps réel
     */
    function setupRealtimeSync() {
        // Pour chaque setting dans notre mapping
        Object.keys(IsabelSync.settingsMap).forEach(function(settingId) {
            const selectors = IsabelSync.settingsMap[settingId];
            
            // Écouter les changements du setting
            wp.customize(settingId, function(setting) {
                setting.bind(function(newValue) {
                    updatePreviewContent(selectors, newValue, settingId);
                });
            });
        });

        // Synchronisation des images
        setupImageSync();
        
        // Synchronisation des couleurs
        setupColorSync();
        
        // Synchronisation des options on/off
        setupToggleSync();
    }

    /**
     * Mise à jour du contenu dans le preview
     */
    function updatePreviewContent(selectors, newValue, settingId) {
        if (!newValue) return;

        const selectorArray = selectors.split(',').map(s => s.trim());
        
        selectorArray.forEach(function(selector) {
            const elements = $(selector);
            
            if (elements.length > 0) {
                // Déterminer le type d'élément et la méthode d'update
                elements.each(function() {
                    const $el = $(this);
                    
                    // Pour les containers qui peuvent contenir du HTML formaté
                    if ($el.hasClass('service-title-container') || 
                        $el.hasClass('service-description-container') ||
                        $el.hasClass('profile-info') ||
                        $el.hasClass('profile-subtitle') ||
                        $el.hasClass('intro-text') ||
                        $el.hasClass('cta-service') ||
                        selector.includes('word')) {
                        
                        $el.html(newValue);
                        
                    } else if ($el.is('input, textarea, select')) {
                        // Pour les champs de formulaire
                        $el.val(newValue);
                        
                    } else {
                        // Pour les autres éléments, utiliser text() pour éviter l'injection HTML
                        const textContent = $('<div>').html(newValue).text();
                        $el.text(textContent);
                    }
                    
                    // Effet visuel pour indiquer la mise à jour
                    addUpdateEffect($el, settingId);
                });
                
                if (IsabelSync.debug) {
                    console.log(`🔄 Mis à jour: ${selector} = ${newValue.substring(0, 50)}...`);
                }
            } else {
                if (IsabelSync.debug) {
                    console.warn(`⚠️ Sélecteur non trouvé: ${selector}`);
                }
            }
        });
    }

    /**
     * Synchronisation des images
     */
    function setupImageSync() {
        const imageSettings = {
            'isabel_profile_image': '.hero-profile-image, .mobile-profile-image',
            'isabel_mobile_profile_image': '.mobile-profile-image',
            'isabel_hero_background_image': '.hero-floating',
            'isabel_header_logo': '.logo-image',
            'isabel_qualiopi_logo': '.qualiopi-logo img'
        };

        // Images des pages de services
        for (let i = 1; i <= 4; i++) {
            imageSettings[`isabel_coaching_box${i}_image`] = `.coaching-box-${i} .full-box-image-fixed`;
            imageSettings[`isabel_vae_box${i}_image`] = `.vae-box-${i} .full-box-image-fixed`;
            imageSettings[`isabel_hypno_box${i}_image`] = `.hypno-box-${i} .full-box-image-fixed`;
            imageSettings[`isabel_consultation_box${i}_image`] = `.consultation-box-${i} .full-box-image-fixed`;
        }

        Object.keys(imageSettings).forEach(function(settingId) {
            wp.customize(settingId, function(setting) {
                setting.bind(function(newValue) {
                    updateImagePreview(imageSettings[settingId], newValue, settingId);
                });
            });
        });
    }

    /**
     * Mise à jour des images dans le preview
     */
    function updateImagePreview(selectors, newValue, settingId) {
        const selectorArray = selectors.split(',').map(s => s.trim());
        
        selectorArray.forEach(function(selector) {
            const elements = $(selector);
            
            if (elements.length > 0) {
                if (settingId === 'isabel_hero_background_image') {
                    // Image de fond spéciale
                    if (newValue) {
                        $(':root').get(0).style.setProperty('--hero-bg-image', `url(${newValue})`);
                        $('.hero-floating').addClass('has-bg-image').removeClass('no-bg-image');
                    } else {
                        $('.hero-floating').addClass('no-bg-image').removeClass('has-bg-image');
                    }
                } else {
                    // Images normales
                    elements.each(function() {
                        const $el = $(this);
                        
                        if (newValue) {
                            if ($el.is('img')) {
                                $el.attr('src', newValue).show();
                            } else {
                                $el.css('background-image', `url(${newValue})`);
                            }
                            
                            // Masquer les placeholders
                            $el.siblings('.placeholder, .logo-placeholder, .full-box-placeholder-fixed').hide();
                        } else {
                            if ($el.is('img')) {
                                $el.hide();
                            }
                            
                            // Afficher les placeholders
                            $el.siblings('.placeholder, .logo-placeholder, .full-box-placeholder-fixed').show();
                        }
                        
                        addUpdateEffect($el, settingId);
                    });
                }
                
                if (IsabelSync.debug) {
                    console.log(`🖼️ Image mise à jour: ${selector}`);
                }
            }
        });
    }

    /**
     * Synchronisation des couleurs
     */
    function setupColorSync() {
        const colorSettings = {
            'isabel_primary_color': '--rose-500',
            'isabel_secondary_color': '--rose-700',
            'isabel_text_color': '--text-dark',
            'isabel_text_light_color': '--text-light'
        };

        Object.keys(colorSettings).forEach(function(settingId) {
            wp.customize(settingId, function(setting) {
                setting.bind(function(newValue) {
                    const cssVar = colorSettings[settingId];
                    $(':root').get(0).style.setProperty(cssVar, newValue);
                    
                    if (IsabelSync.debug) {
                        console.log(`🎨 Couleur mise à jour: ${cssVar} = ${newValue}`);
                    }
                });
            });
        });
    }

    /**
     * Synchronisation des options on/off
     */
    function setupToggleSync() {
        const toggleSettings = {
            'isabel_qualiopi_enable': '.qualiopi-certification, .qualiopi-home-section',
            'isabel_show_dragonfly': '.dragonfly',
            'isabel_alert_bar_enable': '.top-alert'
        };

        Object.keys(toggleSettings).forEach(function(settingId) {
            wp.customize(settingId, function(setting) {
                setting.bind(function(newValue) {
                    const elements = $(toggleSettings[settingId]);
                    
                    if (newValue) {
                        elements.show();
                    } else {
                        elements.hide();
                    }
                    
                    if (IsabelSync.debug) {
                        console.log(`🔧 Toggle mis à jour: ${settingId} = ${newValue}`);
                    }
                });
            });
        });
    }

    /**
     * Synchronisation spéciale pour les éditeurs Word-like
     */
    function setupWordEditorSync() {
        // Écouter les changements dans les éditeurs Word-like
        $('.isabel-word-editor').on('input', function() {
            const settingId = $(this).data('setting');
            const content = $(this).html();
            
            if (settingId && wp.customize(settingId)) {
                // Délai pour éviter trop de mises à jour
                clearTimeout(IsabelSync.updateTimer);
                IsabelSync.updateTimer = setTimeout(function() {
                    wp.customize(settingId).set(content);
                }, 500);
            }
        });

        // Synchronisation bidirectionnelle
        Object.keys(IsabelSync.settingsMap).forEach(function(settingId) {
            wp.customize(settingId, function(setting) {
                setting.bind(function(newValue) {
                    // Mettre à jour l'éditeur si la valeur vient d'ailleurs
                    const editor = $(`.isabel-word-editor[data-setting="${settingId}"]`);
                    if (editor.length && editor.html() !== newValue) {
                        editor.html(newValue);
                    }
                });
            });
        });
    }

    /**
     * Effet visuel pour indiquer les mises à jour
     */
    function addUpdateEffect($element, settingId) {
        $element.addClass('isabel-updating');
        
        setTimeout(function() {
            $element.removeClass('isabel-updating');
        }, 600);
    }

    /**
     * Synchronisation forcée pour résoudre les désync
     */
    function forceSyncAll() {
        if (!wp.customize) return;

        console.log('🔄 Synchronisation forcée de tous les éléments...');
        
        Object.keys(IsabelSync.settingsMap).forEach(function(settingId) {
            const setting = wp.customize(settingId);
            if (setting) {
                const value = setting.get();
                if (value) {
                    updatePreviewContent(IsabelSync.settingsMap[settingId], value, settingId);
                }
            }
        });
        
        console.log('✅ Synchronisation forcée terminée');
    }

    /**
     * Fonction de debug pour diagnostiquer les problèmes
     */
    function debugSync() {
        console.group('🔍 Debug Synchronisation Isabel');
        
        console.log('Settings disponibles:');
        Object.keys(IsabelSync.settingsMap).forEach(function(settingId) {
            const setting = wp.customize ? wp.customize(settingId) : null;
            const value = setting ? setting.get() : 'N/A';
            const elements = $(IsabelSync.settingsMap[settingId]);
            
            console.log(`${settingId}:`, {
                value: value ? value.substring(0, 50) + '...' : 'VIDE',
                elements: elements.length,
                selectors: IsabelSync.settingsMap[settingId]
            });
        });
        
        console.groupEnd();
    }

    /**
     * Correction automatique des problèmes courants
     */
    function autoFixCommonIssues() {
        // Corriger les containers vides
        $('.service-title-container, .service-description-container').each(function() {
            const $container = $(this);
            if ($container.html().trim() === '') {
                const fallback = $container.hasClass('service-title-container') ? 
                    '<h3>Titre du service</h3>' : 
                    '<p>Description du service</p>';
                $container.html(fallback);
            }
        });

        // Corriger les images manquantes
        $('.hero-profile-image, .mobile-profile-image').each(function() {
            const $img = $(this);
            if (!$img.attr('src') || $img.attr('src') === '') {
                $img.hide();
                $img.siblings('.placeholder, .hero-profile-placeholder').show();
            }
        });

        // Corriger les éditeurs Word vides
        $('.isabel-word-editor').each(function() {
            const $editor = $(this);
            if ($editor.html().trim() === '') {
                $editor.html('<p>Contenu à personnaliser...</p>');
            }
        });
    }

    /**
     * API publique pour le debugging
     */
    window.IsabelSyncDebug = {
        forceSync: forceSyncAll,
        debug: debugSync,
        autoFix: autoFixCommonIssues,
        settings: IsabelSync.settingsMap,
        status: function() {
            return {
                isActive: typeof wp !== 'undefined' && !!wp.customize,
                settingsCount: Object.keys(IsabelSync.settingsMap).length,
                previewWindow: !!IsabelSync.previewWindow
            };
        }
    };

    // CSS pour les effets visuels
    const syncStyles = `
        <style id="isabel-sync-styles">
        .isabel-updating {
            position: relative;
            overflow: hidden;
        }
        
        .isabel-updating::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(228, 167, 245, 0.4), transparent);
            animation: isabel-update-sweep 0.6s ease-out;
            pointer-events: none;
            z-index: 1000;
        }
        
        @keyframes isabel-update-sweep {
            0% { left: -100%; }
            100% { left: 100%; }
        }
        
        .service-title-container,
        .service-description-container,
        .profile-info,
        .profile-subtitle,
        .intro-text {
            transition: all 0.3s ease;
            min-height: 1em;
        }
        
        .service-title-container:empty::before,
        .service-description-container:empty::before {
            content: 'Contenu à personnaliser...';
            color: #999;
            font-style: italic;
        }
        </style>
    `;

    // Initialisation
    $(document).ready(function() {
        // Ajouter les styles
        $('head').append(syncStyles);
        
        // Initialiser le système
        initSyncSystem();
        
        // Auto-fix au chargement
        setTimeout(autoFixCommonIssues, 1000);
        
        // Synchronisation forcée toutes les 5 secondes si en mode debug
        if (IsabelSync.debug && typeof wp !== 'undefined' && wp.customize) {
            setInterval(function() {
                if ($(document).find('.isabel-updating').length === 0) {
                    forceSyncAll();
                }
            }, 5000);
        }
        
        console.log('🎨 Système de synchronisation Isabel chargé !');
        console.log('💡 Utilisez window.IsabelSyncDebug pour débugger');
    });

    // Gestion des erreurs
    $(window).on('error', function(e) {
        if (e.originalEvent.message.includes('Isabel') || e.originalEvent.message.includes('customize')) {
            console.error('❌ Erreur dans le système de synchronisation:', e.originalEvent.message);
            console.log('🔧 Tentative de correction automatique...');
            autoFixCommonIssues();
        }
    });

})(jQuery);