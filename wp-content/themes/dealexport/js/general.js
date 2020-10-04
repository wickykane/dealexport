//Elements
var themeElements = {
    menu: '.element-menu',
    select: '.element-select',
    slider: '.element-slider',
    submit: '.element-submit',
    rating: '.element-rating',
    colorbox: '.element-colorbox',
    videoColorbox: '.video-colorbox',
    upload: '.element-upload',
    form: '.element-form',
    file: '.element-file',
    trigger: '.element-trigger',
    facebook: '.element-facebook',
    chosen: '.element-chosen',
    copy: '.element-copy',
    options: '.element-options',
    remove: '.element-remove',
    clone: '.element-clone',
    filter: '.element-filter',
    toggle: '.element-toggle',
    autosave: '.element-autosave',
}

//DOM Loaded
jQuery(document).ready(function($) {

    //Menu
    $(themeElements.menu).find('li').hoverIntent(
        function() {
            var menuItem=$(this);
            menuItem.parent('ul').css('overflow','visible');
            menuItem.children('ul').slideToggle(200, function() {
                menuItem.addClass('hover');
            });
        },
        function() {
            var menuItem=$(this);
            menuItem.children('ul').slideToggle(200, function() {
                menuItem.removeClass('hover');
            });
        }
    );
    
    //Autosave
    $(themeElements.autosave).each(function() {
        $(this).themedbAutosave();
    });

    //Select
    function initSelect() {
        $(themeElements.select).each(function() {
            var element=$(this);
            
            element.find('select:first').fadeTo(0, 0);
            if(element.hasClass('redirect')) {
                element.find('option').each(function() {
                    if(window.location.href==$(this).val()) {
                        $(this).attr('selected','selected');					
                    }
                });
            }
            
            element.find('span').text($.trim(element.find('option:first').text()));
            if(element.find('option:selected').length) {
                element.find('span').text($.trim(element.find('option:selected').text()));
            }
            
            element.on('click, change', function() {
                element.find('span').text($.trim($(this).find('option:selected').text()));			
                if(element.hasClass('redirect')) {
                    window.location.href=$(this).find('option:selected').val();
                }
            });
        });
    }
    
    initSelect();
    
    //Toggles
    $(themeElements.toggle).each(function() {
        $(this).find('.toggle-container').eq(0).addClass('expanded').find('.toggle-content').show();
    });
    
    $(themeElements.toggle).find('.toggle-title').live('click', function() {
        if($(this).parent().parent().find('.expanded').length) {
            if($(this).parent().hasClass('expanded')) {
                return false;
            }
            
            $(this).parent().parent().find('.expanded').find('.toggle-content').slideUp(200, function() {
                $(this).parent().removeClass('expanded');		
            });
        }
        
        $(this).parent().find('.toggle-content').slideToggle(200, function(){
            $(this).parent().toggleClass('expanded');		
        });
    });
    
    //Trigger
    $(themeElements.trigger).each(function() {
        var id=$(this).attr('id').replace(/_/g, '-'),
            current=$(this).find('option:first').val();
            
        if($(this).find('option:selected').length) {
            current=$(this).find('option:selected').val();
        }
        
        $(this).find('option').each(function() {
            $('.trigger-'+id+'-'+$(this).val()).hide();
        });
        
        $('.trigger-'+id+'-'+current).show();
        $(this).change(function() {
            $(this).find('option').each(function() {
                $('.trigger-'+id+'-'+$(this).val()).hide();
            });
            
            $('.trigger-'+id+'-'+$(this).val()).show();
        });
    });
    
    //Chosen
    if(jQuery().chosen) {
        $(themeElements.chosen).chosen();
    }
    
    //Options
    $(themeElements.options).each(function() {
        var element=$(this),
            id=$(this).attr('id').replace(/_/g, '-');
        
        element.find('a').click(function() {
            var name=$(this).attr('href').replace('#', '-'),
                option=$('.option-'+id+name);
            
            if($(this).is(themeElements.remove)) {
                $(this).parent().remove();
                option.remove();
            } else {
                if($(this).is(themeElements.clone) && option.is(':visible')) {
                    var clone=option.clone().removeClass('option-'+id+name).addClass('option-'+id+'-temp').insertAfter(option);
                    
                    clone.find('input').val('');
                    clone.find('select').prop('selectedIndex', 0);
                    initSelect();
                } else {
                    element.find('a').each(function() {
                        var name=$(this).attr('href').replace('#', '-');
                        $('.option-'+id+name).hide();
                    });
                    
                    option.show();
                    $('.option-'+id+'-temp').remove();
                }
            }
            
            return false;
        });
    });
    
    //Filter
    $(themeElements.filter).each(function() {
        var filter=$('.'+$(this).data('filter')),
            label=$(this).parent().find('span'),
            select=$(this),
            clone=select.clone(false).insertAfter(select.parent());
            
        clone.removeAttr('name class data-filter').hide();		
        label.text(clone.find('option:first').text());
        select.prop('disabled', true);
        select.html('');
        
        filter.change(function() {
            var options=clone.find('option:first').add(clone.find('option.'+filter.val()));
            
            select.html('');
            label.text(clone.find('option:first').text());
            
            if(options.length > 1) {
                select.prop('disabled', false);				
                options.clone().appendTo(select);
            } else {
                select.prop('disabled', true);
            }
        });
        
        if(filter.val()) {
            var options=clone.find('option:first').add(clone.find('option.'+filter.val()));
            
            if(options.length > 1) {
                select.prop('disabled', false);
                options.clone().appendTo(select);
                
                if(options.filter(':selected').length) {
                    label.text(options.filter(':selected').text());
                }
            } else {
                select.prop('disabled', true);
            }
        }
    });
    
    //Colorbox
    $(themeElements.colorbox).each(function() {
        var inline=false;
        
        if($(this).attr('href').charAt(0)=='#') {
            inline=true;
        }
    
        $(this).colorbox({
            rel: $(this).data('rel'),
            inline: inline,
            current: '',
            maxWidth:'95%',
            maxHeight:'95%'
        });
    });
    
  //Video colorbox
    $(themeElements.videoColorbox).each(function() {
        var inline = false,
            video_url = $(this).attr('href'),
            width,
            heigth,
            window_width = $( window ).width(),
            height_width = $( window ).height();
        
        if($(this).attr('href').charAt(0)=='#') {
            inline=true;
        }
    
        $(this).colorbox({
            rel: $(this).data('rel'),
            inline: inline,
            iframe:true, 
            href: video_url,
            maxWidth:'95%',
            maxHeight:'95%',
            innerWidth:640, 
            innerHeight:360
        });
    });
    
    //Slider
    $(themeElements.slider).each(function() {
        var sliderOptions= {
            effect: $(this).data('effect'),
            pause: $(this).data('pause'),
            speed: $(this).data('speed'),
        };
        
        $(this).themedbSlider(sliderOptions);
    });
    
    //Submit
    $(themeElements.submit).click(function() {
        if(!$(this).hasClass('disabled')) {
            var button=$(this),
                form=$($(this).attr('href'));
            
            if(typeof button.data('value')!=='undefined') {
                $(button.attr('href')).val(button.data('value'));
            }
        
            if(!form.length || !form.is('form')) {
                form=button.parent();
                while(!form.is('form')) {
                    form=form.parent();
                }
            }
            
            button.addClass('disabled');
            form.submit();
            
            if(button.data('title')) {
                var title=button.data('title');
                
                if(button.attr('title')) {
                    button.data('title', button.attr('title'));
                    button.attr('title', title);
                } else {
                    button.data('title', button.text());
                    button.text(title);
                }				
                
                button.toggleClass('active');
            }
        }
                
        return false;
    });
    
    //Facebook
    $(themeElements.facebook).click(function() {
        var redirect=$(this).attr('href');
        
        if(typeof(FB)!='undefined') {
            FB.login(function(response) {
                if (response.authResponse) {
                    window.location.href=redirect;
                }
            }, {
                scope: 'email',
            });
        }
        
        return false;
    });
    
    //Rating
    $(themeElements.rating).each(function() {
        var title=$(this).parent().attr('title');
        
        $(this).raty({
            score: $(this).data('score'),
            readOnly: true,
            halfShow: false,
            hints: [title, title, title, title, title],
            noRatedMsg: '',
        });
    });
    
    //Copy
    $(themeElements.copy).click(function() {
        this.select();
    });
    
    //Uploader
    $(themeElements.upload).change(function() {
        var form=$(this).parent();
        
        while(!form.is('form')) {
            form=form.parent();
        }
        
        form.submit();
    });
    
    //File
    $(themeElements.file).change(function() {
        var name=$(this).val().replace(/^.*[\\\/]/, '');
        
        $(this).parent().children('span').text(name);
    });
    
    //Form
    $(themeElements.form).each(function() {
        var form=$(this);
        
        form.submit(function() {
            var message=form.find('.message'),
                loader=form.find('.loader'),
                toggle=form.find('.toggle'),
                button=form.find(themeElements.submit);
                
            var data={
                action: form.find('.action').val(),
                nonce: form.find('.nonce').val(),
                data: form.serialize(),
            }
            
            if(button.length==0 && form.attr('id')) {
                button=$('a[href="#'+form.attr('id')+'"]');
            }
            
            if(!form.hasClass('option')) {
                if(!message.length) {
                    message=$('<div class="message" />').prependTo(form);
                }
                
                if(!loader.length) {
                    loader=$('<div class="loader" />').appendTo(form);
                }
            }
            
            loader.show();
            button.addClass('disabled');
            
            message.slideUp(300, function() {
                $(themeElements.colorbox).colorbox.resize();
            });
            
            toggle.each(function() {
                var value=toggle.val();
                
                toggle.val(toggle.data('value'));
                toggle.data('value', value);
            });
            
            jQuery.post(form.attr('action'), data, function(response) {
                loader.hide();
                button.removeClass('disabled');
                
                if(response!='' &&  response!='0' && response!='-1') {
                    if(jQuery('.redirect', response).length) {
                        if(jQuery('.redirect', response).attr('href')) {
                            window.location.href=jQuery('.redirect',response).attr('href');
                        } else {
                            window.location.reload();
                        }
                    } else {
                        message.html(response).slideDown(300, function() {
                            $(themeElements.colorbox).colorbox.resize();
                        });					
                    }					
                }
            });
            
            return false;
        });
    });
    
    //DOM Elements
    $('p:empty').remove();
    $('h1,h2,h3,h4,h5,h6,blockquote').prev('br').remove();
    
    $('ul, ol').each(function() {
        if($(this).css('list-style-type')!='none') {
            $(this).css('padding-left', '1em');
            $(this).css('text-indent', '-1em');
        }
    });
    
    // top menu
    $('.ui-beacon-nav >li ').hover(function () {
        $(this).addClass('ui-beacon-drop-hover');
    }, function () {
        $(this).removeClass('ui-beacon-drop-hover');
    });
    
    
    //tab content 
    $( 'a.tab-title' ).click( function(e) {
        $('.box').css('display','none');
        $('.boxLinks li').each( function(index, element){
            $(this).find('a').removeClass('active');
        });
        $(this).addClass('active');
        e.preventDefault();
        var targetId = $(this).attr("href");
        $(targetId).css('display','block');
     } );
    
    function resizeVideoThumbnail(){
        // change video size 
        var cw = $('.video-thumbnail').width();
        $('.video-thumbnail').css({
        'min-height': cw + 'px'
        });
    }
    resizeVideoThumbnail();
    $( window ).resize(function(){
        resizeVideoThumbnail();
    });


    //Initialize AOS
    AOS.init({
        disable: 'mobile'
    });

    // Make sidebar of shop page fixed
    // var elementPosition = $('div.sticky-wrapper').offset();
    // $(window).scroll(function(){
    //     if($(window).scrollTop() > elementPosition.top){
    //         $('div.sticky-wrapper').css('position','fixed').css('top','0');
    //     } else {
    //         $('div.sticky-wrapper').css('position','relative').css('top', '-128px');
    //     }
    // });

});





(function($){

    //Defines variables
    const regionUl = document.querySelector('.region-menu');

    //TODO: refactor 
    $( document ).ready(function() {
        init();
    });

    function init() {
        initializeDropdownOver();
        initializeHeaderSearch();
        initializeDropdown();


        $(".country-filter").on('select2:select', function (e) {
            var selected_country_id = e.params.data.id;
            $.ajax({
                type: "post",
                dataType: "json",
                url: filter_ajax.ajax_url,
                data: {action: "de_get_list_region_of_country", country_id: selected_country_id}
            }).done(function (response) {
                renderRegion(response);
            });
        });

        // Prepare filter criteria
        const checkboxes = Array.from(document.querySelectorAll('.dropdown input[type="checkbox"]'));
        checkboxes.forEach(checkbox => checkbox.addEventListener('change', filterService));

        const category_menu_links = Array.from(document.querySelectorAll('.category_main_menu .menu-item a'));
        category_menu_links.forEach(link => link.addEventListener('click', filterExporterServiceByMainmenu));
       


    }

    function initializeDropdownOver() {
        let dropdown = $('.dropdownOver');
        dropdown.on( "click", function() {
            let $this = $(this);
            dropdown.not($this).removeClass('open');
            $this.toggleClass('open');
        });

        // Close when clicking outside
        $(document).on("click", function(event) {
          if ($(event.target).closest('.dropdownOver').length === 0) {
            dropdown.removeClass('open');
          }
          event.stopPropagation();
        });


        $(document).on('keydown', '.dropdown', function(event) {
            var focused_option = $($(this).find('ul li:focus')[0] || $(this).find('ul li.selected')[0]);
            // Space or Enter
            if (event.keyCode == 32 || event.keyCode == 13) {
                if ($(this).hasClass('open')) {
                    focused_option.trigger('click');
                } else {
                    $(this).trigger('click');
                }
                return false;
            // Down
            } else if (event.keyCode == 40) {
                if (!$(this).hasClass('open')) {
                    $(this).trigger('click');
                } else {
                    focused_option.next().focus();
                }
                return false;
            // Up
            } else if (event.keyCode == 38) {
                if (!$(this).hasClass('open')) {
                    $(this).trigger('click');
                } else {
                  var focused_option = $($(this).find('ul li:focus')[0] || $(this).find('ul li.selected')[0]);
                  focused_option.prev().focus();
                }
                return false;
              // Esc
            } else if (event.keyCode == 27) {
                if ($(this).hasClass('open')) {
                    $(this).trigger('click');
                }
                return false;
            }
        });


        let select = $('.dropdownOver ul li');

        select.on('click', function(event) {
            if($(this).attr('data-label')) {
                $(this).closest('ul').find('.selected').removeClass('selected');
                let text = $(this).attr('data-label');
                $(this).closest('.dropdownOver').find('.label').text(text);
            } else {
                $(this).closest('ul').find('.selected').removeClass('selected');
                $(this).addClass('selected');
                let text = $(this).text();
                $(this).closest('.dropdownOver').find('.label').text(text);
            }
        });
    }

    function initializeHeaderSearch() {
        let categoryMenu = $('.main-header .site-toolbar');
        let searchMenu = $('.header-search-container');
        $('.icon-nav-item.search-item').on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            if(!searchMenu.hasClass('active')) {
                categoryMenu.removeClass('active').slideUp(300);
                searchMenu.addClass('active').delay(300).slideDown();
            }
        });

        $('.header-search-close').on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            if(searchMenu.hasClass('active')) {
                searchMenu.removeClass('active').slideUp(300);
                categoryMenu.addClass('active').delay(300).slideDown();
            }
        });


        searchForm = $('.header-search-container form');
        searchLink = $('.header-search-start-link');
        searchLink.on('click', function() {
            searchForm.submit();
        });
    }


    function initializeDropdown() {
        let dropdown = document.querySelectorAll('.dropdown');
        let dropdownArray = Array.prototype.slice.call(dropdown,0);
    
        dropdownArray.forEach(function(el){
            let trigger = el.querySelector('a[data-toggle="dropdown"]'),
                menuList = el.querySelector('.dropdown-menu');
                

            trigger.onclick = function(event) {
                event.preventDefault();
                event.stopPropagation();
                if(!menuList.classList.contains('show')) {
                    menuList.classList.add('show');
                    menuList.classList.remove('hide');
                    trigger.classList.add('open');
                    trigger.classList.remove('close');
                } else {
                    menuList.classList.add('hide');
                    menuList.classList.remove('show');
                    trigger.classList.add('close');
                    trigger.classList.remove('open');
                }
            };

        });

    }


    function renderRegion(regionArray) {
        let i = 0;
        // Empty the region list 
        while(regionUl.firstChild){
            regionUl.removeChild(regionUl.firstChild);
        }
        // Apprend the regions
        for (i; i < regionArray.length; i++) {
            let region = regionArray[i];
            let regionLi = document.createElement('li');
            let label = document.createElement("label");
            let checkbox = document.createElement("INPUT");
            label.appendChild(document.createTextNode(region.title));
            checkbox.setAttribute("type", "checkbox");
            checkbox.setAttribute("name", region.slug);
            checkbox.setAttribute("value", region.slug);
            checkbox.setAttribute("class", "filter-term");
            regionLi.appendChild(checkbox);
            regionLi.appendChild(label);
            regionUl.appendChild(regionLi);
            checkbox.addEventListener('change', filterService);
        }
    }



    function filterExporterServiceByMainmenu(event) {
            //Select the category main menu
            event.preventDefault();
            event.stopPropagation();
            let filter_array = new Array();
            let term = event.target;
            let term_value = term.getAttribute("data-filter");
            let taxanomy = findAncestor(term, 'category_main_menu').getAttribute("data-taxonomy");
           
            let object = {
                taxonomy: taxanomy,
                slug: term_value
            };
            filter_array.push(object);
            
            console.log(filter_array);

            // Map slugs that share the same taxonomy
            let res = filter_array.reduce((r, {taxonomy, slug}) => {
                return r.set(taxonomy, (r.get(taxonomy) || []).concat(slug))
            }, new Map).values()
            let result = [...res];
            let filter_data = JSON.stringify(result);
            $.ajax({
                    type : 'POST',
                    data : {'action' : 'filter_action', 'filter_data' : filter_data},
                    url : filter_ajax.ajax_url,
                    beforeSend: function() {
                        console.log('beforeSend');
                    },
                    success : function (response){
                        if(response) {
                            console.log('response :' + response);
                            let objs = JSON.parse(response);
                            console.log('objs :' + response);
                            console.log(objs);
                            renderFilterResult(objs);

                        }
                    }
            });
            

    }

    function filterService(event) {

        let filter_array = new Array();
       
        if(event.target.checked) {
            let term = event.target;
            
            // Select all the checkboxes
            let checkboxes = Array.from(document.querySelectorAll('.dropdown input[type="checkbox"]'));
            checkboxes.forEach(checkbox =>  {
                let taxanomy = findAncestor(checkbox, 'filter-list').getAttribute("data-taxonomy");
                if(checkbox.checked){
                    // Get the taxonomy of the selected/ unselected term
                    let object = {
                        taxonomy: taxanomy,
                        slug: checkbox.value
                    };
                    // Add each object into an array
                    filter_array.push(object);
                } else {
                    //console.log(taxanomy.getAttribute("data-taxonomy"));
                }
            });
            
            console.log(filter_array);

            // Map slugs that share the same taxonomy
            let res = filter_array.reduce((r, {taxonomy, slug}) => {
              return r.set(taxonomy, (r.get(taxonomy) || []).concat(slug))
            }, new Map).values()
            let result = [...res];
            let filter_data = JSON.stringify(result);
            $.ajax({
                type : 'POST',
                data : {'action' : 'filter_action', 'filter_data' : filter_data},
                url : filter_ajax.ajax_url,
                beforeSend: function() {
                    console.log('beforeSend');
                },
                success : function (response){
                    if(response) {
                        // filter_content.empty();
                        // filter_content.append(response);
                        console.log('response :' + response);
						let objs = JSON.parse(response);
                        console.log('objs :' + response);
                        console.log(objs);
	                    renderFilterResult(objs);

                    }
                }
            });
        }
    }


    function renderFilterResult(post_array) {
    	//Loop through an array of objects
        let count = 1;
        let container = document.querySelector('#main .items-wrap');
         // Empty the container
        if(container.firstChild) {
            while(container.firstChild){
                container.removeChild(container.firstChild);
            }
        }
        

    	post_array.forEach( function (eachObj){
            let product_column = document.createElement('div');
            if(count % 3 == 0) {
                product_column.setAttribute("class", "column fourcol last");
            } else {
                product_column.setAttribute("class", "column fourcol");
            }
            
            let product_item_preview = document.createElement('div');
                product_item_preview.setAttribute("class", "item-preview");
            let product_item_image = document.createElement('div');
                product_item_image.setAttribute("class", "item-image");
            let product_item_image_wrap = document.createElement('div');
                product_item_image_wrap.setAttribute("class", "image-wrap");

            // Product/ Service URL
            let product_item_link = document.createElement('a');
            let product_data_url = "#";
            if (eachObj.hasOwnProperty("post_url")){
                product_data_url = eachObj["post_url"];
            }
            product_item_link.setAttribute("href", product_data_url);



            // Product/ Service Thumbnail
            let product_item_image_thumbnail = document.createElement('img');
            let product_data_src = "#";
            if (eachObj.hasOwnProperty("thumbnail")){
                product_data_src = eachObj["thumbnail"];
            }
            product_item_image_thumbnail.setAttribute("src", product_data_src);

            product_item_link.appendChild(product_item_image_thumbnail);
            product_item_image_wrap.appendChild(product_item_link);
            product_item_image.appendChild(product_item_image_wrap);
                

            let product_item_details = document.createElement('div');
                product_item_details.setAttribute("class", "item-details");
            let product_item_title = document.createElement('h3');
                product_item_title.setAttribute("class", "item-name");
            let product_item_title_link = document.createElement('a');
                product_item_title_link.setAttribute("href", product_data_url);
            let title = "COMING SOON";
            if (eachObj.hasOwnProperty("title")){
                title = eachObj["title"];
            }

            //product_item_title_link.appendChild(document.createTextNode(title));
            product_item_title_link.innerHTML = title;


            let product_item_author = document.createElement('div');
                product_item_author.setAttribute("class", "author-name");
            let product_item_author_link = document.createElement('a');
            let product_data_author_url = "#";
            if (eachObj.hasOwnProperty("thumbnail")){
                product_data_author_url = eachObj["author_url"];
            }
            product_item_author_link.setAttribute("href", product_data_author_url);
            let product_data_author_title = "#";
            if (eachObj.hasOwnProperty("author")){
                product_data_author_title = eachObj["author"];
            }
            product_item_author_link.appendChild(document.createTextNode(product_data_author_title));

            product_item_author.appendChild(product_item_author_link);
            product_item_title.appendChild(product_item_title_link);
            product_item_details.appendChild(product_item_title);
            product_item_details.appendChild(product_item_author);
                //console.log(product_item_details);


            let product_item_footer = document.createElement('footer');
                product_item_footer.setAttribute("class", "item-footer clearfix");
            let product_item_footer_category = document.createElement('div');
                product_item_footer_category.setAttribute("class", "item-category");
            let product_data_category = "Uncategorized";

            if (eachObj.hasOwnProperty("category")){
                product_data_category = eachObj["category"];
            }
            product_item_footer_category.appendChild(document.createTextNode(product_data_category));
                
            let product_item_footer_price = document.createElement('div');
                product_item_footer_price.setAttribute("class", "item-price");
            let product_data_id = "#";
                if (eachObj.hasOwnProperty("ID")){
                   product_data_id = eachObj["ID"];
                }
            product_item_footer_price.setAttribute("data-id", product_data_id);

            product_item_footer.appendChild(product_item_footer_category);
            product_item_footer.appendChild(product_item_footer_price);

            product_item_preview.appendChild(product_item_image);
            product_item_preview.appendChild(product_item_details);
            product_item_preview.appendChild(product_item_footer);
            product_column.appendChild(product_item_preview);
            container.appendChild(product_column);
      

            count++;

		    for (var key in eachObj) {
		    	
		        // if (eachObj.hasOwnProperty(key)){
		        //    console.log(key,eachObj[key]);

		        // }
		    }
		});


    }



    function findAncestor(el, cls) {
        while ((el = el.parentNode) && el.className.indexOf(cls) < 0);
        return el;
    }

/** Huy add new js */
    jQuery('.ui.accordion').accordion();

        jQuery('#customer_details').accordion({
            selector: {
                trigger: '.title',
                title: '.title',
                content: '.content',
            }
        });

        jQuery('.section-edit').on('click', function(e) {
            if (jQuery(this).parent().hasClass('active')) {
                e.preventDefault();
                e.stopPropagation();
            }
            jQuery(this).parent().parent().toggleClass('show-detail');
        });

        jQuery('.checkout-condition-to-approve #conditions_to_approve').on('change', function(e) {
            if(e.target.checked) {
                jQuery('#place_order').removeAttr('disabled');
            } else {
                jQuery('#place_order').attr('disabled', true);
            }
        });



})(jQuery);


