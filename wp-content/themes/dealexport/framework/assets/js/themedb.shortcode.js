(function() {
    if(tinymce.majorVersion>3) {
        var shortcodes=[];
        
        for(var id in themedbShortcodes) {
            shortcodes.push({
                value: id,
                text: themedbShortcodes[id],
                onclick: function() {
                    tb_show(themedbTitle, themedbURI+'templates/popup.php?width=500&shortcode='+this.value());
                }				
            });
        }
        
        tinymce.PluginManager.add('themedb_shortcode', function( editor, url ) {
            editor.addButton( 'themedb_shortcode', {
                title: themedbTitle,
                type: 'menubutton',
                icon: 'icon themedb-shortcode-icon',
                menu: shortcodes,
            });
        });
    } else {
        tinymce.create('tinymce.plugins.themedb_shortcode', {
            init: function (ed, url) {
                ed.addCommand('themedb_popup', function (a, params) {
                    tb_show(themedbTitle, themedbURI+'templates/popup.php?width=500&shortcode='+params.identifier);
                });
            },
            
            createControl: function (button, e) {
                if (button=='themedb_shortcode') {
                    var a = this;
                        
                    button = e.createMenuButton('themedb_shortcode', {
                        title: themedbTitle,
                        image: themedbURI+'assets/images/icons/icon-shortcode.png',
                        icons: false
                    });
                    
                    button.onRenderMenu.add(function (c, b) {
                        for(var id in themedbShortcodes) {
                            var name=themedbShortcodes[id];
                            a.addWithPopup(b, name, id);
                        }
                    });
                    
                    return button;
                }
                
                return null;
            },
            
            addWithPopup: function (ed, title, id) {
                ed.add({
                    title: title,
                    onclick: function () {
                        tinyMCE.activeEditor.execCommand('themedb_popup', false, {
                            title: title,
                            identifier: id
                        })
                    }
                });
            },
            
            addImmediate: function ( ed, title, shortcode) {
                ed.add({
                    title: title,
                    onclick: function () {
                        tinyMCE.activeEditor.execCommand('mceInsertContent', false, shortcode);
                    }
                })
            },
        });
        
        tinymce.PluginManager.add('themedb_shortcode', tinymce.plugins.themedb_shortcode);	
    }
})();