var themedbElements={
    page: '.themedb-page',
    popup: '.themedb-popup',
    button: '.themedb-button',
    buttonSave: '.themedb-save-button',
    buttonSubmit: '.themedb-submit-button',
    buttonReset: '.themedb-reset-button',
    buttonUpload: '.themedb-upload-button',
    buttonAdd: '.themedb-add-button',
    buttonClone: '.themedb-clone-button',
    buttonRemove: '.themedb-remove-button',
    buttonRefresh: '.themedb-refresh-button',
    option: '.themedb-option',
    optionImage: '.themedb-select-image',
    optionColor: '.themedb-colorpicker',
    optionSlider: '.themedb-slider-controls',
    optionSliderValue: '.themedb-slider-value',
    selectSubmit: '.themedb-submit-select',
    sidebarModule: '.themedb-sidebar',
    shortcodeModule: '.themedb-shortcode',
    shortcodeModuleClone: '.themedb-shortcode-clone',
    shortcodeModuleValue: '.themedb-shortcode-value',
    shortcodeModulePattern: '.themedb-shortcode-pattern',
    tabsContainer: '.themedb-page',
    tabsList: '.themedb-menu',
    tabsPane: '.themedb-section',
}

jQuery(document).ready(function($) {

    //Options
    $(themedbElements.page).find('form').submit(function() {
        return false;
    });	
    
    $(themedbElements.page).find('input[type="submit"]:not(.disabled)').live('click', function() {
        var options = $(themedbElements.page).find('form').serialize();
        var data = {
            action: $(this).attr('name'),
            options: options
        };
        
        if($(this).attr('name')=='themedb_reset_options') {
            $(themedbElements.buttonReset).addClass('disabled');
        } else {
            $(themedbElements.buttonReset).removeClass('disabled');
        }
        
        $(themedbElements.buttonSave).addClass('disabled');		
        $.post($(themedbElements.page).find('form').attr('action'), data, function(response) {
            $(themedbElements.popup).text(response).fadeIn(300);
            window.setTimeout(function() {
                $(themedbElements.popup).fadeOut(300);
            }, 2000);
        });
    });
    
    $(themedbElements.page).find(themedbElements.option).each(function() {
        var parent=$(this).data('parent'),
            value=$(this).data('value');
            
        if(parent) {		
            parent=$('#'+parent);
            if(parent.length && ((parent.is('select') && parent.val()!=value) || (parent.is('input') && !parent.is(':checked')))) {
                $(this).hide();
            }
        }
    });
    
    $(themedbElements.page).find('select, input[type="checkbox"]').change(function() {
        var value=$(this).val();
        if($(this).is('input') && !$(this).is(':checked')) {
            value='';
        }
        
        var children=$(themedbElements.page).find('[data-parent="'+$(this).attr('id')+'"]'),
            visible=children.filter('[data-value="'+value+'"]'),
            hidden=children.filter('[data-value!="'+value+'"]');
            
        if(children.length) {
            visible.slideDown(300);
            hidden.slideUp(300);
        }
    });
    
    //Buttons
    $(themedbElements.page).find('input, select').live('change', function(){
        $(themedbElements.buttonSave).removeClass('disabled');
    });
    
    $(themedbElements.page).find('input, textarea').each(function() {
        $(this).data('value', $(this).val());
        $(this).bind('propertychange keyup input paste', function(event){
            if ($(this).data('value')!=$(this).val()) {
                $(this).data('value', $(this).val());
                $(themedbElements.buttonSave).removeClass('disabled');
            }
        });
    });
    
    $(themedbElements.buttonAdd).live('click', function() {
        var button=$(this);
        var data = {
            action: button.data('action'),
            value: $(themedbElements.page).find('#'+button.data('value')).val(),
        };
        
        if(button.data('value')) {
            $.post($(themedbElements.page).find('form').attr('action'), data, function(response) {			
                if(response) {				
                    $(themedbElements.buttonSave).removeClass('disabled');					
                    if(button.data('container')) {
                        $('#'+button.data('container')).prepend(response);
                        $('#'+button.data('container')).find('>*:first-child').hide().slideToggle(300);
                    } else if(button.data('element')) {
                        $('#'+button.data('element')).after(response);
                        $('#'+button.data('element')).next('*').hide().slideToggle(300);
                    }
                }
            });
        }	
        
        return false;
    });
    
    $(themedbElements.buttonRemove).live('click', function() {
        var button=$(this);
        
        $('#'+button.data('element')).slideToggle(300, function() {
            $(themedbElements.buttonSave).removeClass('disabled');
            $(this).remove();
        });
        
        return false;
    });
    
    $(themedbElements.buttonClone).live('click', function() {
        var button=$(this),
            pane=$(button.data('element')),
            key='a'+(new Date().getTime().toString(16));
        
        if(!pane.length) {
            pane=button.parent();
        }
        
        newPane=pane.clone().attr('id', pane.attr('id').replace(button.data('value'), key)).hide();
        newPane.html(newPane.html().replace(new RegExp(button.data('value'), 'igm'), key));
        newPane.find('input[type="text"], input[type="number"], select, textarea').val('');
        newPane.find('input[type="checkbox"]').attr('checked', false);
        newPane.insertAfter(pane).slideToggle(300);
        
        return false;
    });
    
    $(themedbElements.buttonSubmit).click(function() {
        var form=$(this).parent();
        
        if(!form.length || !form.is('form')) {
            form=$(this).parent();
            while(!form.is('form')) {
                form=form.parent();
            }
        }
            
        form.submit();
        return false;
    });
    
    $(themedbElements.buttonRefresh).click(function() {
        location.reload();
        return false;
    });
    
    //Tabs
    $(themedbElements.tabsContainer).each(function() {
        var tabsContainer=$(this);
        
        if(window.location.hash && tabsContainer.find(window.location.hash).length) {
            tabsContainer.find(window.location.hash).show();
            
            tabsContainer.find(themedbElements.tabsList).find('li').each(function() {
                if($(this).find('a').attr('href')==window.location.hash) {
                    $(this).addClass('current');
                }
            });
            
        } else {
            tabsContainer.find(themedbElements.tabsList).find('li:eq(0)').addClass('current');
            tabsContainer.find(themedbElements.tabsPane).eq(0).show();
        }
    
        tabsContainer.find(themedbElements.tabsList).find('a').click(function() {
            var tabLink=$(this).attr('href');
            window.location.hash=tabLink;
            
            tabsContainer.find(themedbElements.tabsList).find('li').removeClass('current');
            $(this).parent().addClass('current');
            
            tabsContainer.find(themedbElements.tabsPane).hide();
            tabsContainer.find(tabLink).show();
            
            window.scrollTo(0, 0);
            return false;
        });
    });
    
    //Colorpicker
    $(themedbElements.optionColor).wpColorPicker({
        defaultColor: $(this).val(),
        palettes: false,
        change: function(event, ui){
            $(themedbElements.buttonSave).removeClass('disabled');
        }
    });
    
    //Select
    $(themedbElements.selectSubmit).change(function() {
        var form=$(this).parent();
        
        if(!form.length || !form.is('form')) {
            form=$(this).parent();
            while(!form.is('form')) {
                form=form.parent();
            }
        }
            
        form.submit();
        return false;
    });
    
    //Slider
    $(themedbElements.optionSlider).each(function() {
        var slider=$(this);
        var unit=slider.parent().find('input.slider-unit').val();
        var value=parseInt(slider.parent().find('input.slider-value').val());
        var minValue=parseInt(slider.parent().find('input.slider-min').val());
        var maxValue=parseInt(slider.parent().find('input.slider-max').val());		

        slider.parent().find(themedbElements.optionSliderValue).text(value+' '+unit);		
        slider.slider({
            value: value,
            min: minValue,
            max: maxValue,
            slide: function( event, ui ) {
                slider.parent().find(themedbElements.optionSliderValue).text( ui.value+' '+unit );
                slider.parent().find('input.slider-value').val(ui.value);
                $(themedbElements.buttonSave).removeClass('disabled');
            }
        });
    });
    
    //Select Image
    $(themedbElements.optionImage).find('img').click(function(){
        $(themedbElements.buttonSave).removeClass('disabled');
        $(this).parent().find('img').removeClass('current');
        $(this).addClass('current');	
        $(this).parent().find('input').val($(this).data('value'));				
    });	
    
    //Uploader
    var header_clicked = false,
        fileInput = '',
        imageInput = '';

    $(themedbElements.buttonUpload).live('click', function(e) {		
        fileInput = jQuery(this).prev('input');		
        
        if(fileInput.length) {
            imageInput = fileInput.prev('img');
        }
        
        if(fileInput.length) {
            tb_show('', 'media-upload.php?post=-629834&amp;themedb_uploader=1&amp;TB_iframe=true');
            header_clicked = true;
            e.preventDefault();
        }
    });

    //store original
    window.original_send_to_editor = window.send_to_editor;
    window.original_tb_remove = window.tb_remove;

    //override removing
    window.tb_remove = function() {
        header_clicked = false;
        window.original_tb_remove();
    }
    
    //send to editor
    window.send_to_editor = function(html) {
        $(themedbElements.buttonSave).removeClass('disabled');
        if (header_clicked) {
            imgurl = $(html).attr('href');
            fileInput.val(imgurl);
            
            if(imageInput!='' && imageInput.length) {
                imageInput.attr('src', imgurl);
            }
            
            tb_remove();
        } else {
            window.original_send_to_editor(html);
        }		
    }
    
    //Profile
    if($('#profile-page').length) {
        $('#description').parents('tr').remove();
    }
});