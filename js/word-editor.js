/**
 * Éditeur Word-like pour le Customizer WordPress
 * Fonctionnalités complètes similaires à Microsoft Word
 */

(function($) {
    'use strict';

    // Configuration globale
    const WordEditor = {
        version: '1.0.0',
        instances: {},
        settings: {
            autoSave: true,
            autoSaveDelay: 2000,
            showWordCount: true,
            showCharCount: true,
            enableSpellCheck: true,
            enableAutoFormat: true,
            maxUndoLevels: 50
        }
    };

    /**
     * Classe principale de l'éditeur Word-like
     */
    class IsabelWordEditor {
        constructor(container, options = {}) {
            this.container = $(container);
            this.options = $.extend({}, WordEditor.settings, options);
            this.editor = null;
            this.toolbar = null;
            this.statusBar = null;
            this.preview = null;
            this.undoStack = [];
            this.redoStack = [];
            this.isModified = false;
            this.autoSaveTimer = null;
            this.settingId = null;
            
            this.init();
        }

        /**
         * Initialisation de l'éditeur
         */
        init() {
            this.findElements();
            this.setupEditor();
            this.setupToolbar();
            this.setupStatusBar();
            this.setupPreview();
            this.setupKeyboardShortcuts();
            this.setupAutoSave();
            this.bindEvents();
            
            console.log('🎨 Isabel Word Editor initialisé pour:', this.settingId);
        }

        /**
         * Recherche des éléments DOM
         */
        findElements() {
            this.editor = this.container.find('.isabel-word-editor');
            this.toolbar = this.container.find('.isabel-word-toolbar');
            this.statusBar = this.container.find('.isabel-word-statusbar');
            this.preview = this.container.find('.preview-content');
            this.settingId = this.editor.data('setting');
        }

        /**
         * Configuration de l'éditeur
         */
        setupEditor() {
            const editor = this.editor[0];
            
            // Activer l'édition riche
            editor.contentEditable = true;
            editor.spellcheck = this.options.enableSpellCheck;
            
            // Styles de base
            this.editor.css({
                'outline': 'none',
                'user-select': 'text',
                'white-space': 'pre-wrap',
                'word-wrap': 'break-word'
            });

            // Sauvegarder l'état initial
            this.saveUndoState();
        }

        /**
         * Configuration de la barre d'outils
         */
        setupToolbar() {
            const self = this;
            
            // Boutons de formatage
            this.toolbar.find('[data-command]').on('click', function(e) {
                e.preventDefault();
                const command = $(this).data('command');
                self.executeCommand(command, $(this));
            });

            // Sélecteurs de police
            this.toolbar.find('.font-family-selector').on('change', function() {
                self.executeCommand('fontName', null, $(this).val());
            });

            this.toolbar.find('.font-size-selector').on('change', function() {
                self.executeCommand('fontSize', null, $(this).val());
            });

            // Sélecteurs de couleur
            this.setupColorPickers();
        }

        /**
         * Configuration des sélecteurs de couleur
         */
        setupColorPickers() {
            const self = this;
            
            // Couleur du texte
            this.toolbar.find('.text-color-picker').on('change', function() {
                const color = $(this).val();
                self.executeCommand('foreColor', null, color);
                $(this).siblings('.color-text-btn').find('.color-bar').css('background-color', color);
            });

            // Couleur de fond
            this.toolbar.find('.bg-color-picker').on('change', function() {
                const color = $(this).val();
                self.executeCommand('backColor', null, color);
                $(this).siblings('.color-bg-btn').find('.color-bar').css('background-color', color);
            });

            // Ouvrir les sélecteurs de couleur
            this.toolbar.find('.color-text-btn').on('click', function() {
                $(this).siblings('.text-color-picker').click();
            });

            this.toolbar.find('.color-bg-btn').on('click', function() {
                $(this).siblings('.bg-color-picker').click();
            });
        }

        /**
         * Configuration de la barre de statut
         */
        setupStatusBar() {
            const self = this;
            
            // Contrôles de zoom
            this.statusBar.find('.zoom-btn').on('click', function() {
                const zoomAction = $(this).data('zoom');
                self.handleZoom(zoomAction);
            });

            // Mise à jour initiale
            this.updateStatusBar();
        }

        /**
         * Configuration de l'aperçu
         */
        setupPreview() {
            this.updatePreview();
        }

        /**
         * Raccourcis clavier
         */
        setupKeyboardShortcuts() {
            const self = this;
            
            this.editor.on('keydown', function(e) {
                // Ctrl/Cmd + raccourcis
                if (e.ctrlKey || e.metaKey) {
                    switch(e.which) {
                        case 66: // Ctrl+B (Gras)
                            e.preventDefault();
                            self.executeCommand('bold');
                            break;
                        case 73: // Ctrl+I (Italique)
                            e.preventDefault();
                            self.executeCommand('italic');
                            break;
                        case 85: // Ctrl+U (Souligné)
                            e.preventDefault();
                            self.executeCommand('underline');
                            break;
                        case 90: // Ctrl+Z (Annuler)
                            e.preventDefault();
                            self.undo();
                            break;
                        case 89: // Ctrl+Y (Rétablir)
                            e.preventDefault();
                            self.redo();
                            break;
                        case 83: // Ctrl+S (Sauvegarder)
                            e.preventDefault();
                            self.save();
                            break;
                        case 65: // Ctrl+A (Tout sélectionner)
                            // Laisser le comportement par défaut
                            break;
                    }
                }
                
                // Touches spéciales
                switch(e.which) {
                    case 9: // Tab
                        e.preventDefault();
                        self.executeCommand('indent');
                        break;
                }
            });
        }

        /**
         * Sauvegarde automatique
         */
        setupAutoSave() {
            if (!this.options.autoSave) return;
            
            const self = this;
            this.editor.on('input', function() {
                self.markAsModified();
                
                clearTimeout(self.autoSaveTimer);
                self.autoSaveTimer = setTimeout(function() {
                    self.save();
                }, self.options.autoSaveDelay);
            });
        }

        /**
         * Événements principaux
         */
        bindEvents() {
            const self = this;
            
            // Mise à jour en temps réel
            this.editor.on('input keyup mouseup', function() {
                self.updateStatusBar();
                self.updatePreview();
                self.updateToolbarState();
            });

            // Animation de saisie
            this.editor.on('input', function() {
                $(this).addClass('typing');
                setTimeout(function() {
                    self.editor.removeClass('typing');
                }, 300);
            });

            // Sélection de texte
            this.editor.on('mouseup keyup', function() {
                self.updateToolbarState();
            });

            // Focus/Blur
            this.editor.on('focus', function() {
                self.container.addClass('focused');
            });

            this.editor.on('blur', function() {
                self.container.removeClass('focused');
                if (self.isModified) {
                    self.save();
                }
            });
        }

        /**
         * Exécution des commandes d'édition
         */
        executeCommand(command, button = null, value = null) {
            this.editor.focus();
            
            try {
                // Sauvegarder l'état pour l'annulation
                this.saveUndoState();
                
                // Commandes spéciales
                switch(command) {
                    case 'createLink':
                        const url = prompt('Entrez l\'URL du lien:');
                        if (url) {
                            document.execCommand(command, false, url);
                        }
                        break;
                    
                    case 'fontSize':
                        // Convertir les tailles
                        const sizeMap = {
                            '1': '8px', '2': '10px', '3': '12px', '4': '14px',
                            '5': '18px', '6': '24px', '7': '36px'
                        };
                        document.execCommand(command, false, value);
                        break;
                    
                    default:
                        document.execCommand(command, false, value);
                }
                
                // Mise à jour de l'interface
                this.updateToolbarState();
                this.markAsModified();
                
                // Animation du bouton
                if (button) {
                    button.addClass('active');
                    setTimeout(() => button.removeClass('active'), 150);
                }
                
            } catch (error) {
                console.warn('Erreur lors de l\'exécution de la commande:', command, error);
            }
        }

        /**
         * Annuler (Undo)
         */
        undo() {
            if (this.undoStack.length > 1) {
                const currentState = this.undoStack.pop();
                this.redoStack.push(currentState);
                const previousState = this.undoStack[this.undoStack.length - 1];
                this.editor.html(previousState);
                this.updatePreview();
                this.markAsModified();
            }
        }

        /**
         * Rétablir (Redo)
         */
        redo() {
            if (this.redoStack.length > 0) {
                const state = this.redoStack.pop();
                this.undoStack.push(state);
                this.editor.html(state);
                this.updatePreview();
                this.markAsModified();
            }
        }

        /**
         * Sauvegarder l'état pour l'annulation
         */
        saveUndoState() {
            const currentContent = this.editor.html();
            
            // Éviter les doublons
            if (this.undoStack.length === 0 || this.undoStack[this.undoStack.length - 1] !== currentContent) {
                this.undoStack.push(currentContent);
                
                // Limiter la taille de la pile
                if (this.undoStack.length > this.options.maxUndoLevels) {
                    this.undoStack.shift();
                }
                
                // Vider la pile de rétablissement
                this.redoStack = [];
            }
        }

        /**
         * Mise à jour de l'état de la barre d'outils
         */
        updateToolbarState() {
            const self = this;
            
            // Commandes à vérifier
            const commands = ['bold', 'italic', 'underline', 'strikeThrough'];
            
            commands.forEach(function(command) {
                const isActive = document.queryCommandState(command);
                const button = self.toolbar.find(`[data-command="${command}"]`);
                button.toggleClass('active', isActive);
            });
            
            // Alignement
            const alignCommands = ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'];
            alignCommands.forEach(function(command) {
                const isActive = document.queryCommandState(command);
                const button = self.toolbar.find(`[data-command="${command}"]`);
                button.toggleClass('active', isActive);
            });
        }

        /**
         * Gestion du zoom
         */
        handleZoom(action) {
            const currentZoom = parseInt(this.statusBar.find('.zoom-level').text()) || 100;
            let newZoom = currentZoom;
            
            if (action === 'bigger' && currentZoom < 200) {
                newZoom += 10;
            } else if (action === 'smaller' && currentZoom > 50) {
                newZoom -= 10;
            }
            
            if (newZoom !== currentZoom) {
                this.statusBar.find('.zoom-level').text(newZoom + '%');
                this.editor.css('zoom', newZoom / 100);
                this.preview.css('zoom', newZoom / 100);
            }
        }

        /**
         * Mise à jour de la barre de statut
         */
        updateStatusBar() {
            if (!this.options.showWordCount && !this.options.showCharCount) return;
            
            const content = this.editor.text();
            
            if (this.options.showWordCount) {
                const wordCount = content.trim() === '' ? 0 : content.trim().split(/\s+/).length;
                this.statusBar.find('.word-count').text(wordCount + ' mot' + (wordCount > 1 ? 's' : ''));
            }
            
            if (this.options.showCharCount) {
                const charCount = content.length;
                this.statusBar.find('.char-count').text(charCount + ' caractère' + (charCount > 1 ? 's' : ''));
            }
        }

        /**
         * Mise à jour de l'aperçu
         */
        updatePreview() {
            if (this.preview.length) {
                const content = this.editor.html();
                this.preview.html(content);
            }
        }

        /**
         * Marquer comme modifié
         */
        markAsModified() {
            this.isModified = true;
            this.container.addClass('modified').removeClass('saved');
        }

        /**
         * Sauvegarder
         */
        save() {
            if (!this.isModified || !this.settingId) return;
            
            const content = this.editor.html();
            
            // Sauvegarder dans WordPress
            if (typeof wp !== 'undefined' && wp.customize) {
                wp.customize(this.settingId, function(setting) {
                    setting.set(content);
                });
            }
            
            // Marquer comme sauvegardé
            this.isModified = false;
            this.container.removeClass('modified').addClass('saved');
            
            // Animation de sauvegarde
            this.container.addClass('saving');
            setTimeout(() => {
                this.container.removeClass('saving saved');
            }, 2000);
            
            console.log('💾 Contenu sauvegardé pour:', this.settingId);
        }

        /**
         * Obtenir le contenu HTML
         */
        getContent() {
            return this.editor.html();
        }

        /**
         * Définir le contenu HTML
         */
        setContent(content) {
            this.editor.html(content);
            this.updatePreview();
            this.updateStatusBar();
            this.saveUndoState();
        }

        /**
         * Nettoyer le contenu
         */
        cleanContent() {
            let content = this.editor.html();
            
            // Supprimer les styles inline non désirés
            content = content.replace(/(<[^>]+) style="[^"]*"/gi, '$1');
            
            // Nettoyer les balises vides
            content = content.replace(/<([^>]+)>\s*<\/\1>/gi, '');
            
            this.editor.html(content);
            this.updatePreview();
        }

        /**
         * Mode plein écran
         */
        toggleFullscreen() {
            this.container.toggleClass('fullscreen');
            
            if (this.container.hasClass('fullscreen')) {
                $('body').css('overflow', 'hidden');
            } else {
                $('body').css('overflow', '');
            }
        }

        /**
         * Détruire l'instance
         */
        destroy() {
            clearTimeout(this.autoSaveTimer);
            this.editor.off();
            this.toolbar.off();
            this.statusBar.off();
            
            if (WordEditor.instances[this.settingId]) {
                delete WordEditor.instances[this.settingId];
            }
        }
    }

    /**
     * Fonctions utilitaires
     */
    const Utils = {
        
        /**
         * Formater le texte sélectionné
         */
        formatSelection(command, value = null) {
            if (window.getSelection) {
                const selection = window.getSelection();
                if (selection.rangeCount > 0) {
                    document.execCommand(command, false, value);
                }
            }
        },

        /**
         * Obtenir le texte sélectionné
         */
        getSelectedText() {
            if (window.getSelection) {
                return window.getSelection().toString();
            }
            return '';
        },

        /**
         * Insérer du HTML à la position du curseur
         */
        insertHTML(html) {
            if (window.getSelection) {
                const selection = window.getSelection();
                if (selection.rangeCount > 0) {
                    const range = selection.getRangeAt(0);
                    range.deleteContents();
                    
                    const fragment = range.createContextualFragment(html);
                    range.insertNode(fragment);
                    
                    // Repositionner le curseur
                    range.collapse(false);
                    selection.removeAllRanges();
                    selection.addRange(range);
                }
            }
        },

        /**
         * Nettoyer le HTML collé
         */
        cleanPastedHTML(html) {
            // Créer un élément temporaire
            const temp = $('<div>').html(html);
            
            // Supprimer les attributs indésirables
            temp.find('*').each(function() {
                const $this = $(this);
                const allowedAttrs = ['href', 'src', 'alt', 'title'];
                
                $.each(this.attributes, function() {
                    if (allowedAttrs.indexOf(this.name) === -1) {
                        $this.removeAttr(this.name);
                    }
                });
            });
            
            return temp.html();
        }
    };

    /**
     * Plugin jQuery pour l'éditeur Word-like
     */
    $.fn.isabelWordEditor = function(options) {
        return this.each(function() {
            const $this = $(this);
            const settingId = $this.find('.isabel-word-editor').data('setting');
            
            if (!WordEditor.instances[settingId]) {
                WordEditor.instances[settingId] = new IsabelWordEditor(this, options);
            }
        });
    };

    /**
     * Auto-initialisation lors du chargement du customizer
     */
    function initWordEditors() {
        $('.isabel-word-editor-container').each(function() {
            $(this).isabelWordEditor();
        });
    }

    /**
     * Intégration avec le preview du customizer
     */
    function setupCustomizerIntegration() {
        if (typeof wp !== 'undefined' && wp.customize) {
            
            // Écouter les changements pour le preview en temps réel
            Object.keys(WordEditor.instances).forEach(function(settingId) {
                wp.customize(settingId, function(setting) {
                    setting.bind(function(newValue) {
                        // Mettre à jour le preview dans le customizer
                        const instance = WordEditor.instances[settingId];
                        if (instance && instance.getContent() !== newValue) {
                            instance.setContent(newValue);
                        }
                    });
                });
            });
        }
    }

    /**
     * Gestion du collage de contenu
     */
    function setupPasteHandler() {
        $(document).on('paste', '.isabel-word-editor', function(e) {
            e.preventDefault();
            
            const clipboardData = e.originalEvent.clipboardData || window.clipboardData;
            const pastedData = clipboardData.getData('text/html') || clipboardData.getData('text/plain');
            
            if (pastedData) {
                const cleanedData = Utils.cleanPastedHTML(pastedData);
                Utils.insertHTML(cleanedData);
                
                // Mettre à jour l'éditeur
                const editor = $(this).closest('.isabel-word-editor-container');
                const settingId = $(this).data('setting');
                if (WordEditor.instances[settingId]) {
                    WordEditor.instances[settingId].updatePreview();
                    WordEditor.instances[settingId].updateStatusBar();
                    WordEditor.instances[settingId].markAsModified();
                }
            }
        });
    }

    /**
     * Raccourcis clavier globaux
     */
    function setupGlobalShortcuts() {
        $(document).on('keydown', function(e) {
            // Alt + W : Basculer en mode plein écran pour l'éditeur actif
            if (e.altKey && e.which === 87) {
                const activeEditor = $('.isabel-word-editor:focus');
                if (activeEditor.length) {
                    const container = activeEditor.closest('.isabel-word-editor-container');
                    const settingId = activeEditor.data('setting');
                    if (WordEditor.instances[settingId]) {
                        WordEditor.instances[settingId].toggleFullscreen();
                    }
                }
            }
        });
    }

    /**
     * Fonctions d'aide pour les développeurs
     */
    window.IsabelWordEditor = {
        
        /**
         * Obtenir une instance d'éditeur
         */
        getInstance: function(settingId) {
            return WordEditor.instances[settingId] || null;
        },

        /**
         * Obtenir toutes les instances
         */
        getAllInstances: function() {
            return WordEditor.instances;
        },

        /**
         * Sauvegarder tous les éditeurs
         */
        saveAll: function() {
            Object.keys(WordEditor.instances).forEach(function(settingId) {
                WordEditor.instances[settingId].save();
            });
        },

        /**
         * Nettoyer tous les éditeurs
         */
        cleanAll: function() {
            Object.keys(WordEditor.instances).forEach(function(settingId) {
                WordEditor.instances[settingId].cleanContent();
            });
        },

        /**
         * Mode sombre pour tous les éditeurs
         */
        toggleDarkMode: function() {
            $('.isabel-word-editor-container').toggleClass('dark-mode');
        },

        /**
         * Statistiques d'utilisation
         */
        getStats: function() {
            const stats = {
                totalEditors: Object.keys(WordEditor.instances).length,
                totalWords: 0,
                totalCharacters: 0,
                modifiedEditors: 0
            };

            Object.keys(WordEditor.instances).forEach(function(settingId) {
                const instance = WordEditor.instances[settingId];
                const content = instance.editor.text();
                
                stats.totalWords += content.trim() === '' ? 0 : content.trim().split(/\s+/).length;
                stats.totalCharacters += content.length;
                
                if (instance.isModified) {
                    stats.modifiedEditors++;
                }
            });

            return stats;
        }
    };

    /**
     * Initialisation principale
     */
    $(document).ready(function() {
        console.log('🎨 Initialisation des éditeurs Word-like Isabel...');
        
        // Initialiser les éditeurs existants
        initWordEditors();
        
        // Configurer l'intégration avec le customizer
        setupCustomizerIntegration();
        
        // Gestion du collage
        setupPasteHandler();
        
        // Raccourcis globaux
        setupGlobalShortcuts();
        
        console.log('✅ Éditeurs Word-like Isabel initialisés!');
        console.log('📊 Statistiques:', window.IsabelWordEditor.getStats());
    });

    /**
     * Réinitialiser lors des changements du customizer
     */
    if (typeof wp !== 'undefined' && wp.customize) {
        wp.customize.bind('ready', function() {
            console.log('🔧 Customizer prêt - Réinitialisation des éditeurs Word-like');
            
            // Réinitialiser après un délai pour laisser le customizer se charger
            setTimeout(function() {
                initWordEditors();
                setupCustomizerIntegration();
            }, 500);
        });
    }

    /**
     * Nettoyage lors de la fermeture
     */
    $(window).on('beforeunload', function() {
        // Sauvegarder automatiquement tous les éditeurs modifiés
        Object.keys(WordEditor.instances).forEach(function(settingId) {
            const instance = WordEditor.instances[settingId];
            if (instance.isModified) {
                instance.save();
            }
        });
    });

})(jQuery);