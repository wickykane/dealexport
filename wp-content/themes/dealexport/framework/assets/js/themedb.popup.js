jQuery(document).ready(function($) {
    var themedbPopup={	
        loadVals: function() {
            var shortcode=$(themedbElements.shortcodeModule).find('form').children(themedbElements.shortcodeModulePattern).html();
            var clones='';

            $(themedbElements.shortcodeModule).find('input, select, textarea').each(function() {
                var id=$(this).attr('id'),
                    re=new RegExp('{{'+id+'}}','g');
                    
                shortcode=shortcode.replace(re, $(this).val());
            });
            
            $(themedbElements.shortcodeModule).find(themedbElements.shortcodeModuleClone).each(function() {
                var shortcode=$(this).children(themedbElements.shortcodeModulePattern).html();
                
                $(this).find('input, select, textarea').each(function() {
                    var id=$(this).attr('id'),
                        re=new RegExp('{{'+id+'}}','g');
                        
                    shortcode=shortcode.replace(re, $(this).val());
                });
                
                clones=clones+shortcode;
            });
            
            shortcode=shortcode.replace('{{clone}}', clones);
            shortcode=shortcode.replace('="null"', '="0"');
            $(themedbElements.shortcodeModuleValue).html(shortcode);
        },
        
        resize: function() {
            $('#TB_ajaxContent').outerHeight($('#TB_window').outerHeight()-$('#TB_title').outerHeight()-2);
        },
        
        init: function() {
            var	themedbPopup=this,
                form=$(themedbElements.shortcodeModule).find('form');
                
            //update values
            form.find('select').live('change', function() {
                themedbPopup.loadVals();
            });
            
            form.find('input').live('change', function() {
                themedbPopup.loadVals();
            });
            
            form.find('textarea').bind('propertychange keyup input paste', function(event){
                themedbPopup.loadVals();				
            });
            
            //update clones
            form.find(themedbElements.buttonClone).live('click', function() {
                themedbPopup.loadVals();
                themedbPopup.resize();
            });
            
            form.find(themedbElements.buttonRemove).live('click', function() {
                themedbPopup.loadVals();
                themedbPopup.resize();
            });
            
            //send to editor
            form.live('submit', function() {
                themedbPopup.loadVals();
                if(window.tinyMCE) {
                    if(window.tinyMCE.majorVersion>3) {
                        window.tinyMCE.execCommand('mceInsertContent', false, $(themedbElements.shortcodeModuleValue).html());
                    } else {
                        window.tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, $(themedbElements.shortcodeModuleValue).html());
                    }
                    
                    tb_remove();
                }
                
                return false;
            });	
        }
    }
    
    //init popup
    themedbPopup.init();
    
    //resize popup
    $(window).resize(function() {
        themedbPopup.resize();
    });
});