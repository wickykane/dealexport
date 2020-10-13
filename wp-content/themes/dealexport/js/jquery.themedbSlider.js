/*
 * 	Themedb Slider 1.0 - jQuery plugin
 *	written by Ihor Ahnianikov	
 *
 *	Copyright (c) 2013 Ihor Ahnianikov
 *
 *	Built for jQuery library
 *	http://jquery.com
 *
 */
 
(function($) {
    $.fn.themedbSlider = function (options) {
        var options = jQuery.extend ({
            speed: 1000,
            pause: 0,
            effect: 'fade',
        }, options);
    
        var slider=$(this);
        var list=$(this).children('ul');
        var disabled=false;
        var autoSlide;
        
        //build slider sliderect
        function init() {
        
            //init slides
            var slidesNumber=list.children('li').length;
            
            if(options.effect=='slide') {
                list.children('li:first-child').clone().appendTo(list);
                list.children('li:last-child').prev('li').clone().prependTo(list);								
            } else {
                list.children('li').hide();
                list.children('li:first-child').show().addClass('current');				
            }
            
            //add arrows
            if(slidesNumber>1) {
                var html='<a href="#" class="slider-arrow right"></a><a href="#" class="slider-arrow left"></a>';
                var arrows;
                
                if(slider.parent().hasClass('widget')) {
                    arrows=slider.parent().find('.widget-title').append(html);
                } else {
                    arrows=slider.append(html);
                }
                
                arrows.find('.slider-arrow').click(function() {
                    if($(this).hasClass('left')) {
                        animate('left');
                    } else {
                        animate('right');
                    }

                    //stop slider
                    clearInterval(autoSlide);
                    
                    return false;
                });
            }				
            
            //add indicators // Mark
            if(slidesNumber>1) {
                var html='<div class="indicator-bar" style="position: absolute; bottom: 10%; left: 50%; z-index: 1;"></div>';
                var indicatorBar;

                if(slider.parent().hasClass('widget')) {
                    indicatorBar=slider.parent().find('.widget-title').append(html);
                } else {
                    indicatorBar=slider.append(html);
                }

                indicatorBar.find('.indicator-bar').append('<ul></ul>');

                for(let i=1; i<=slidesNumber; i++) {
                    $('.indicator-bar').find("ul").append('<li style="display: inline-block; width: 16px; height: 16px; margin-bottom: 0 !important; margin-left: 4px; margin-right: 4px; background-color: grey; border-radius: 50%;"></li>');
                }
            
                $('.indicator-bar ul li').click(function() {
                    clickedNumber=$(this).index()+1;
                    $('.indicator-bar ul li').css('background-color', 'grey');
                    $(this).css('background-color', 'white');
                    animateTo(clickedNumber);
                });
            }

            //rotate slider
            if(options.pause!=0 && slidesNumber>1) {
                rotate();
            }
            
            //show slider
            slider.addClass('visible');
        }
        
        //rotate slider
        function rotate() {
            autoSlide=setInterval(function() {
                animate('right');
             
            }, options.pause+options.speed);
        }
                
        //show next slide
        function animate(direction) {
        
            if(disabled) {
                return;
            } else {
                //disable animation
                disabled=true;
            }
            
            //get current slide
            var currentSlide=list.children('li.current');			
            
            //get next slide for current direction and make the indicators white
            if(direction=='left') {
                if(list.children('li.current').prev('li').length) {
                    nextSlide=list.children('li.current').prev('li');
                } else if(options.effect=='fade') {
                    nextSlide=list.children('li:last-child');
                }
            } else if(direction=='right') {
                if(list.children('li.current').next('li').length) {
                    nextSlide=list.children('li.current').next('li');
                } else if(options.effect=='fade') {
                    nextSlide=list.children('li:first-child');
                }				
            }
         
            //remove current slide class and reset the indicators to grey
            currentSlide.removeClass('current');
            $('.indicator-bar ul li').css('background-color', 'grey'); // Mark
                    
            //calculate position
            $('.indicator-bar ul li:nth-child(' + nextSlide.index() + ')').css('background-color', 'white'); // Mark: SỬA LẠI CHỖ NÀY BỊ LỖI INDEX LỚN HƠN TỔNG SỐ SLIDE
            
            if(options.effect=='slide') {
                var sliderPos=-nextSlide.index()*slider.width();
                
                list.animate({
                    'left':sliderPos,
                    'height':nextSlide.outerHeight()
                },options.speed, function(){
                    if(nextSlide.is(':last-child')) {
                        list.children('li').eq(1).addClass('current');
                        sliderPos=-slider.width();
                    } else if(nextSlide.is(':first-child')) {
                        list.children('li:last-child').prev('li').addClass('current');
                        sliderPos=-(list.children('li').length-2)*slider.width();
                    } else {
                        nextSlide.addClass('current');
                    }
                    list.css('left',sliderPos);
                    disabled=false;
                });
                
            } else {
                list.animate({'height':nextSlide.outerHeight()},options.speed);
                
                nextSlide.css({'position':'absolute','z-index':'2'});
                currentSlide.fadeOut(options.speed/2, function() {
                    nextSlide.fadeIn(options.speed/2, function() {
                        
                        //set current slide class
                        currentSlide.hide().removeClass('current');
                        nextSlide.addClass('current').css({'position':'relative', 'z-index':'1'});
                        
                        //enable animation
                        disabled=false;
                    });
                });
            }
        }
        
        //show selected slide // Mark
        function animateTo(nextNumber) {
        
            if(disabled) {
                return;
            } else {
                //disable animation
                disabled=true;
            }
            
            //get current slide and current slide index
            var currentSlide=list.children('li.current');
            var currentSlideNumber=currentSlide.index();			

            //get next slide
            var adjustedNextNumber=nextNumber+1; // Mark: do thư viện tự add thêm 2 thẻ li ở đầu và cuối danh sách slide nên slide muốn đến có số thứ tự bằng param + 1
            nextSlide=list.children('li:nth-child(' + adjustedNextNumber + ')');
            
            //remove current slide class
            currentSlide.removeClass('current');
            
            //calculate position
            if(options.effect=='slide') {
                var sliderPos=-nextSlide.index()*slider.width();
                
                list.animate({
                    'left':sliderPos,
                    'height':nextSlide.outerHeight()
                },options.speed, function(){
                    if(nextSlide.is(':last-child')) {
                        list.children('li').eq(1).addClass('current');
                        sliderPos=-slider.width();
                    } else if(nextSlide.is(':first-child')) {
                        list.children('li:last-child').prev('li').addClass('current');
                        sliderPos=-(list.children('li').length-2)*slider.width();
                    } else {
                        nextSlide.addClass('current');
                    }
                    list.css('left',sliderPos);
                    disabled=false;
                });
                
            } else {
                list.animate({'height':nextSlide.outerHeight()},options.speed);
                
                nextSlide.css({'position':'absolute','z-index':'2'});
                currentSlide.fadeOut(options.speed/2, function() {
                    nextSlide.fadeIn(options.speed/2, function() {
                        
                        //set current slide class
                        currentSlide.hide().removeClass('current');
                        nextSlide.addClass('current').css({'position':'relative', 'z-index':'1'});
                        
                        //enable animation
                        disabled=false;
                    });
                });
            }
        }

        //resize slider
        function resize() {
            if(options.effect=='slide') {
                list.children('li').width(slider.width());
                list.width(list.children('li').length*slider.width());
                
                list.children('li').removeClass('current');
                list.children('li:first-child').next().addClass('current');
                list.css({
                    'overflow': 'hidden',
                    'left': -slider.width()					
                });
            }
            
            list.height(list.find('li.current').outerHeight());
        }
            
        //init slider
        $(window).bind('load', function() {		
            init();
            resize();
        });
        
        //window resize event
        $(window).bind('resize', function() {
            resize();
        });
    }
})(jQuery);