!function($){$.fn.fullpage=function(options){function createSlimScrollingHandler(){$(".section").each(function(){var slides=$(this).find(".slide");slides.length?slides.each(function(){createSlimScrolling($(this))}):createSlimScrolling($(this))}),$.isFunction(options.afterRender)&&options.afterRender.call(this)}function scrollHandler(){if(!options.autoScrolling){var currentScroll=$(window).scrollTop(),scrolledSections=$(".section").map(function(){if($(this).offset().top<currentScroll+100)return $(this)}),currentSection=scrolledSections[scrolledSections.length-1];if(!currentSection.hasClass("active")){var leavingSection=$(".section.active").index(".section")+1;isScrolling=!0;var yMovement=getYmovement(currentSection);currentSection.addClass("active").siblings().removeClass("active");var anchorLink=currentSection.data("anchor");$.isFunction(options.onLeave)&&options.onLeave.call(this,leavingSection,currentSection.index(".section")+1,yMovement),$.isFunction(options.afterLoad)&&options.afterLoad.call(this,anchorLink,currentSection.index(".section")+1),activateMenuElement(anchorLink),activateNavDots(anchorLink,0),options.anchors.length&&!isMoving&&(lastScrolledDestiny=anchorLink,location.hash=anchorLink),clearTimeout(scrollId),scrollId=setTimeout(function(){isScrolling=!1},100)}}}function touchMoveHandler(event){var e=event.originalEvent;if(options.autoScrolling&&event.preventDefault(),!checkParentForNormalScrollElement(event.target)){var touchMoved=!1,activeSection=$(".section.active"),scrollable;if(!isMoving&&!slideMoving){var touchEvents=getEventsPage(e);if(touchEndY=touchEvents.y,touchEndX=touchEvents.x,activeSection.find(".slides").length&&Math.abs(touchStartX-touchEndX)>Math.abs(touchStartY-touchEndY))Math.abs(touchStartX-touchEndX)>$(window).width()/100*options.touchSensitivity&&(touchStartX>touchEndX?$.fn.fullpage.moveSlideRight():$.fn.fullpage.moveSlideLeft());else if(options.autoScrolling&&(scrollable=activeSection.find(".slides").length?activeSection.find(".slide.active").find(".scrollable"):activeSection.find(".scrollable"),Math.abs(touchStartY-touchEndY)>$(window).height()/100*options.touchSensitivity))if(touchStartY>touchEndY)if(scrollable.length>0){if(!isScrolled("bottom",scrollable))return!0;$.fn.fullpage.moveSectionDown()}else $.fn.fullpage.moveSectionDown();else if(touchEndY>touchStartY)if(scrollable.length>0){if(!isScrolled("top",scrollable))return!0;$.fn.fullpage.moveSectionUp()}else $.fn.fullpage.moveSectionUp()}}}function checkParentForNormalScrollElement(el,hop){hop=hop||0;var parent=$(el).parent();return!!(hop<options.normalScrollElementTouchThreshold&&parent.is(options.normalScrollElements))||hop!=options.normalScrollElementTouchThreshold&&checkParentForNormalScrollElement(parent,++hop)}function touchStartHandler(event){var e=event.originalEvent,touchEvents=getEventsPage(e);touchStartY=touchEvents.y,touchStartX=touchEvents.x}function MouseWheelHandler(e){if(options.autoScrolling){e=window.event||e;var delta=Math.max(-1,Math.min(1,e.wheelDelta||-e.deltaY||-e.detail)),scrollable,activeSection=$(".section.active");if(!isMoving)if(scrollable=activeSection.find(".slides").length?activeSection.find(".slide.active").find(".scrollable"):activeSection.find(".scrollable"),delta<0)if(scrollable.length>0){if(!isScrolled("bottom",scrollable))return!0;$.fn.fullpage.moveSectionDown()}else $.fn.fullpage.moveSectionDown();else if(scrollable.length>0){if(!isScrolled("top",scrollable))return!0;$.fn.fullpage.moveSectionUp()}else $.fn.fullpage.moveSectionUp();return!1}}function moveSlide(direction){var activeSection=$(".section.active"),slides=activeSection.find(".slides");if(slides.length&&!slideMoving){var currentSlide=slides.find(".slide.active"),destiny=null;if(destiny="prev"===direction?currentSlide.prev(".slide"):currentSlide.next(".slide"),!destiny.length){if(!options.loopHorizontal)return;destiny="prev"===direction?currentSlide.siblings(":last"):currentSlide.siblings(":first")}slideMoving=!0,landscapeScroll(slides,destiny)}}function scrollPage(element,callback,isMovementUp){var scrollOptions={},scrolledElement,dest=element.position();if(void 0!==dest){var dtop=dest.top,yMovement=getYmovement(element),anchorLink=element.data("anchor"),sectionIndex=element.index(".section"),activeSlide=element.find(".slide.active"),activeSection=$(".section.active"),leavingSection=activeSection.index(".section")+1,localIsResizing=isResizing;if(activeSlide.length)var slideAnchorLink=activeSlide.data("anchor"),slideIndex=activeSlide.index();if(options.autoScrolling&&options.continuousVertical&&void 0!==isMovementUp&&(!isMovementUp&&"up"==yMovement||isMovementUp&&"down"==yMovement)){isMovementUp?$(".section.active").before(activeSection.nextAll(".section")):$(".section.active").after(activeSection.prevAll(".section").get().reverse()),silentScroll($(".section.active").position().top);var wrapAroundElements=activeSection;dest=element.position(),dtop=dest.top,yMovement=getYmovement(element)}element.addClass("active").siblings().removeClass("active"),isMoving=!0,void 0!==anchorLink&&setURLHash(slideIndex,slideAnchorLink,anchorLink),options.autoScrolling?(scrollOptions.top=-dtop,scrolledElement="."+wrapperSelector):(scrollOptions.scrollTop=dtop,scrolledElement="html, body");var continuousVerticalFixSectionOrder=function(){wrapAroundElements&&wrapAroundElements.length&&(isMovementUp?$(".section:first").before(wrapAroundElements):$(".section:last").after(wrapAroundElements),silentScroll($(".section.active").position().top))};if(options.css3&&options.autoScrolling){$.isFunction(options.onLeave)&&!localIsResizing&&options.onLeave.call(this,leavingSection,sectionIndex+1,yMovement);transformContainer("translate3d(0px, -"+dtop+"px, 0px)",!0),setTimeout(function(){continuousVerticalFixSectionOrder(),$.isFunction(options.afterLoad)&&!localIsResizing&&options.afterLoad.call(this,anchorLink,sectionIndex+1),setTimeout(function(){isMoving=!1,$.isFunction(callback)&&callback.call(this)},scrollDelay)},options.scrollingSpeed)}else $.isFunction(options.onLeave)&&!localIsResizing&&options.onLeave.call(this,leavingSection,sectionIndex+1,yMovement),$(scrolledElement).animate(scrollOptions,options.scrollingSpeed,options.easing,function(){continuousVerticalFixSectionOrder(),$.isFunction(options.afterLoad)&&!localIsResizing&&options.afterLoad.call(this,anchorLink,sectionIndex+1),setTimeout(function(){isMoving=!1,$.isFunction(callback)&&callback.call(this)},scrollDelay)});lastScrolledDestiny=anchorLink,options.autoScrolling&&(activateMenuElement(anchorLink),activateNavDots(anchorLink,sectionIndex))}}function scrollToAnchor(){var value=window.location.hash.replace("#","").split("/"),section=value[0],slide=value[1];section&&scrollPageAndSlide(section,slide)}function hashChangeHandler(){if(!isScrolling){var value=window.location.hash.replace("#","").split("/"),section=value[0],slide=value[1],isFirstSlideMove=void 0===lastScrolledDestiny,isFirstScrollMove=void 0===lastScrolledDestiny&&void 0===slide&&!slideMoving;(section&&section!==lastScrolledDestiny&&!isFirstSlideMove||isFirstScrollMove||!slideMoving&&lastScrolledSlide!=slide)&&scrollPageAndSlide(section,slide)}}function landscapeScroll(slides,destiny){var destinyPos=destiny.position(),slidesContainer=slides.find(".slidesContainer").parent(),slideIndex=destiny.index(),section=slides.closest(".section"),sectionIndex=section.index(".section"),anchorLink=section.data("anchor"),slidesNav=section.find(".fullPage-slidesNav"),slideAnchor=destiny.data("anchor"),localIsResizing=isResizing;if(options.onSlideLeave){var prevSlideIndex=section.find(".slide.active").index(),xMovement=getXmovement(prevSlideIndex,slideIndex);localIsResizing||$.isFunction(options.onSlideLeave)&&options.onSlideLeave.call(this,anchorLink,sectionIndex+1,prevSlideIndex,xMovement)}if(destiny.addClass("active").siblings().removeClass("active"),void 0===slideAnchor&&(slideAnchor=slideIndex),section.hasClass("active")&&(options.loopHorizontal||(section.find(".controlArrow.prev").toggle(0!=slideIndex),section.find(".controlArrow.next").toggle(!destiny.is(":last-child"))),setURLHash(slideIndex,slideAnchor,anchorLink)),options.css3){var translate3d="translate3d(-"+destinyPos.left+"px, 0px, 0px)";slides.find(".slidesContainer").toggleClass("easing",options.scrollingSpeed>0).css(getTransforms(translate3d)),setTimeout(function(){localIsResizing||$.isFunction(options.afterSlideLoad)&&options.afterSlideLoad.call(this,anchorLink,sectionIndex+1,slideAnchor,slideIndex),slideMoving=!1},options.scrollingSpeed,options.easing)}else slidesContainer.animate({scrollLeft:destinyPos.left},options.scrollingSpeed,options.easing,function(){localIsResizing||$.isFunction(options.afterSlideLoad)&&options.afterSlideLoad.call(this,anchorLink,sectionIndex+1,slideAnchor,slideIndex),slideMoving=!1});slidesNav.find(".active").removeClass("active"),slidesNav.find("li").eq(slideIndex).find("a").addClass("active")}function resizeMe(displayHeight,displayWidth){var preferredHeight=825,windowSize=displayHeight;if(displayHeight<825||displayWidth<900){displayWidth<900&&(windowSize=displayWidth,preferredHeight=900);var percentage=100*windowSize/preferredHeight,newFontSize=percentage.toFixed(2);$("body").css("font-size",newFontSize+"%")}else $("body").css("font-size","100%")}function activateNavDots(name,sectionIndex){options.navigation&&($("#fullPage-nav").find(".active").removeClass("active"),name?$("#fullPage-nav").find('a[href="#'+name+'"]').addClass("active"):$("#fullPage-nav").find("li").eq(sectionIndex).find("a").addClass("active"))}function activateMenuElement(name){options.menu&&($(options.menu).find(".active").removeClass("active"),$(options.menu).find('[data-menuanchor="'+name+'"]').addClass("active"))}function isScrolled(type,scrollable){return"top"===type?!scrollable.scrollTop():"bottom"===type?scrollable.scrollTop()+1+scrollable.innerHeight()>=scrollable[0].scrollHeight:void 0}function getYmovement(destiny){return $(".section.active").index(".section")>destiny.index(".section")?"up":"down"}function getXmovement(fromIndex,toIndex){return fromIndex==toIndex?"none":fromIndex>toIndex?"left":"right"}function createSlimScrolling(element){element.css("overflow","hidden");var section=element.closest(".section"),scrollable=element.find(".scrollable");if(scrollable.length)var contentHeight=element.find(".scrollable").get(0).scrollHeight;else{var contentHeight=element.get(0).scrollHeight;options.verticalCentered&&(contentHeight=element.find(".tableCell").get(0).scrollHeight)}var scrollHeight=windowsHeight-parseInt(section.css("padding-bottom"))-parseInt(section.css("padding-top"));contentHeight>scrollHeight?scrollable.length?scrollable.css("height",scrollHeight+"px").parent().css("height",scrollHeight+"px"):(options.verticalCentered?element.find(".tableCell").wrapInner('<div class="scrollable" />'):element.wrapInner('<div class="scrollable" />'),element.find(".scrollable").slimScroll({height:scrollHeight+"px",size:"10px",alwaysVisible:!0})):removeSlimScroll(element),element.css("overflow","")}function removeSlimScroll(element){element.find(".scrollable").children().first().unwrap().unwrap(),element.find(".slimScrollBar").remove(),element.find(".slimScrollRail").remove()}function addTableClass(element){element.addClass("table").wrapInner('<div class="tableCell" style="height:'+getTableHeight(element)+'px;" />')}function getTableHeight(element){var sectionHeight=windowsHeight;if(options.paddingTop||options.paddingBottom){var section=element;section.hasClass("section")||(section=element.closest(".section"));var paddings=parseInt(section.css("padding-top"))+parseInt(section.css("padding-bottom"));sectionHeight=windowsHeight-paddings}return sectionHeight}function transformContainer(translate3d,animated){container.toggleClass("easing",animated),container.css(getTransforms(translate3d))}function scrollPageAndSlide(destiny,slide){if(void 0===slide&&(slide=0),isNaN(destiny))var section=$('[data-anchor="'+destiny+'"]');else var section=$(".section").eq(destiny-1);destiny===lastScrolledDestiny||section.hasClass("active")?scrollSlider(section,slide):scrollPage(section,function(){scrollSlider(section,slide)})}function scrollSlider(section,slide){if(void 0!==slide){var slides=section.find(".slides"),destiny=slides.find('[data-anchor="'+slide+'"]');destiny.length||(destiny=slides.find(".slide").eq(slide)),destiny.length&&landscapeScroll(slides,destiny)}}function addSlidesNavigation(section,numSlides){section.append('<div class="fullPage-slidesNav"><ul></ul></div>');var nav=section.find(".fullPage-slidesNav");nav.addClass(options.slidesNavPosition);for(var i=0;i<numSlides;i++)nav.find("ul").append('<li><a href="#"><span></span></a></li>');nav.css("margin-left","-"+nav.width()/2+"px"),nav.find("li").first().find("a").addClass("active")}function setURLHash(slideIndex,slideAnchor,anchorLink){var sectionHash="";options.anchors.length&&(slideIndex?(void 0!==anchorLink&&(sectionHash=anchorLink),void 0===slideAnchor&&(slideAnchor=slideIndex),lastScrolledSlide=slideAnchor,location.hash=sectionHash+"/"+slideAnchor):void 0!==slideIndex?(lastScrolledSlide=slideAnchor,location.hash=anchorLink):location.hash=anchorLink)}function support3d(){var el=document.createElement("p"),has3d,transforms={webkitTransform:"-webkit-transform",OTransform:"-o-transform",msTransform:"-ms-transform",MozTransform:"-moz-transform",transform:"transform"};document.body.insertBefore(el,null);for(var t in transforms)void 0!==el.style[t]&&(el.style[t]="translate3d(1px,1px,1px)",has3d=window.getComputedStyle(el).getPropertyValue(transforms[t]));return document.body.removeChild(el),void 0!==has3d&&has3d.length>0&&"none"!==has3d}function removeMouseWheelHandler(){document.addEventListener?(document.removeEventListener("mousewheel",MouseWheelHandler,!1),document.removeEventListener("wheel",MouseWheelHandler,!1)):document.detachEvent("onmousewheel",MouseWheelHandler)}function addMouseWheelHandler(){document.addEventListener?(document.addEventListener("mousewheel",MouseWheelHandler,!1),document.addEventListener("wheel",MouseWheelHandler,!1)):document.attachEvent("onmousewheel",MouseWheelHandler)}function addTouchHandler(){isTouchDevice&&(MSPointer=getMSPointer(),$(document).off("touchstart "+MSPointer.down).on("touchstart "+MSPointer.down,touchStartHandler),$(document).off("touchmove "+MSPointer.move).on("touchmove "+MSPointer.move,touchMoveHandler))}function removeTouchHandler(){isTouchDevice&&(MSPointer=getMSPointer(),$(document).off("touchstart "+MSPointer.down),$(document).off("touchmove "+MSPointer.move))}function getMSPointer(){var pointer;return pointer=window.PointerEvent?{down:"pointerdown",move:"pointermove"}:{down:"MSPointerDown",move:"MSPointerMove"}}function getEventsPage(e){var events=new Array;return window.navigator.msPointerEnabled?(events.y=e.pageY,events.x=e.pageX):(events.y=e.touches[0].pageY,events.x=e.touches[0].pageX),events}function silentScroll(top){if(options.css3){transformContainer("translate3d(0px, -"+top+"px, 0px)",!1)}else container.css("top",-top)}function getTransforms(translate3d){return{"-webkit-transform":translate3d,"-moz-transform":translate3d,"-ms-transform":translate3d,transform:translate3d}}function destroyStructure(){silentScroll(0),$("#fullPage-nav, .fullPage-slidesNav, .controlArrow").remove(),$(".section").css({height:"","background-color":"",padding:""}),$(".slide").css({width:""}),container.css({height:"",position:"","-ms-touch-action":""}),$(".section, .slide").each(function(){removeSlimScroll($(this)),$(this).removeClass("table active")}),container.find(".easing").removeClass("easing"),container.find(".tableCell, .slidesContainer, .slides").each(function(){$(this).replaceWith(this.childNodes)}),$("html, body").scrollTop(0),container.addClass("fullpage-used")}options=$.extend({verticalCentered:!0,resize:!0,sectionsColor:[],anchors:[],scrollingSpeed:700,easing:"easeInQuart",menu:!1,navigation:!1,navigationPosition:"right",navigationColor:"#000",navigationTooltips:[],slidesNavigation:!1,slidesNavPosition:"bottom",controlArrowColor:"#fff",loopBottom:!1,loopTop:!1,loopHorizontal:!0,autoScrolling:!0,scrollOverflow:!1,css3:!1,paddingTop:0,paddingBottom:0,fixedElements:null,normalScrollElements:null,keyboardScrolling:!0,touchSensitivity:5,continuousVertical:!1,animateAnchor:!0,normalScrollElementTouchThreshold:5,afterLoad:null,onLeave:null,afterRender:null,afterResize:null,afterSlideLoad:null,onSlideLeave:null},options),options.continuousVertical&&(options.loopTop||options.loopBottom)&&(options.continuousVertical=!1,console&&console.log&&console.log("Option loopTop/loopBottom is mutually exclusive with continuousVertical; continuousVertical disabled"));var scrollDelay=600;$.fn.fullpage.setAutoScrolling=function(value){options.autoScrolling=value;var element=$(".section.active");options.autoScrolling?($("html, body").css({overflow:"hidden",height:"100%"}),element.length&&silentScroll(element.position().top)):($("html, body").css({overflow:"auto",height:"auto"}),silentScroll(0),$("html, body").scrollTop(element.position().top))},$.fn.fullpage.setScrollingSpeed=function(value){options.scrollingSpeed=value},$.fn.fullpage.setMouseWheelScrolling=function(value){value?addMouseWheelHandler():removeMouseWheelHandler()},$.fn.fullpage.setAllowScrolling=function(value){value?($.fn.fullpage.setMouseWheelScrolling(!0),addTouchHandler()):($.fn.fullpage.setMouseWheelScrolling(!1),removeTouchHandler())},$.fn.fullpage.setKeyboardScrolling=function(value){options.keyboardScrolling=value};var slideMoving=!1,isTouchDevice=navigator.userAgent.match(/(iPhone|iPod|iPad|Android|BlackBerry|BB10|Windows Phone|Tizen|Bada)/),container=$(this),windowsHeight=$(window).height(),isMoving=!1,isResizing=!1,lastScrolledDestiny,lastScrolledSlide,wrapperSelector="fullpage-wrapper";if($.fn.fullpage.setAllowScrolling(!0),options.css3&&(options.css3=support3d()),$(this).length?(container.css({height:"100%",position:"relative","-ms-touch-action":"none"}),container.addClass(wrapperSelector)):console.error("Error! Fullpage.js needs to be initialized with a selector. For example: $('#myContainer').fullpage();"),options.navigation){$("#mk-theme-container").append('<div id="fullPage-nav"><ul></ul></div>');var nav=$("#fullPage-nav");nav.css("color",options.navigationColor),nav.addClass(options.navigationPosition)}$(".section").each(function(index){var that=$(this),slides=$(this).find(".slide"),numSlides=slides.length;if(index||0!==$(".section.active").length||$(this).addClass("active"),$(this).css("height",windowsHeight+"px"),(options.paddingTop||options.paddingBottom)&&$(this).css("padding",options.paddingTop+" 0 "+options.paddingBottom+" 0"),void 0!==options.sectionsColor[index]&&$(this).css("background-color",options.sectionsColor[index]),void 0!==options.anchors[index]&&$(this).attr("data-anchor",options.anchors[index]),options.navigation){var link="";options.anchors.length&&(link=options.anchors[index]);var tooltip=options.navigationTooltips[index];void 0===tooltip&&(tooltip=""),nav.find("ul").append('<li data-tooltip="'+tooltip+'"><a href="#'+link+'"><span></span></a></li>')}if(numSlides>1){var sliderWidth=100*numSlides,slideWidth=100/numSlides;slides.wrapAll('<div class="slidesContainer" />'),slides.parent().wrap('<div class="slides" />'),$(this).find(".slidesContainer").css("width",sliderWidth+"%"),$(this).find(".slides").after('<div class="controlArrow prev"></div><div class="controlArrow next"></div>'),"#fff"!=options.controlArrowColor&&($(this).find(".controlArrow.next").css("border-color","transparent transparent transparent "+options.controlArrowColor),$(this).find(".controlArrow.prev").css("border-color","transparent "+options.controlArrowColor+" transparent transparent")),options.loopHorizontal||$(this).find(".controlArrow.prev").hide(),options.slidesNavigation&&addSlidesNavigation($(this),numSlides),slides.each(function(index){index||0!=that.find(".slide.active").length||$(this).addClass("active"),$(this).css("width",slideWidth+"%"),options.verticalCentered&&addTableClass($(this))})}else options.verticalCentered&&addTableClass($(this))}).promise().done(function(){$.fn.fullpage.setAutoScrolling(options.autoScrolling);var activeSlide=$(".section.active").find(".slide.active");if(activeSlide.length&&(0!=$(".section.active").index(".section")||0==$(".section.active").index(".section")&&0!=activeSlide.index())){var prevScrollingSpeepd=options.scrollingSpeed;$.fn.fullpage.setScrollingSpeed(0),landscapeScroll($(".section.active").find(".slides"),activeSlide),$.fn.fullpage.setScrollingSpeed(prevScrollingSpeepd)}options.fixedElements&&options.css3&&$(options.fixedElements).appendTo("body"),options.navigation&&(nav.css("margin-top","-"+nav.height()/2+"px"),nav.find("li").eq($(".section.active").index(".section")).find("a").addClass("active")),options.menu&&options.css3&&$(options.menu).closest(".fullpage-wrapper").length&&$(options.menu).appendTo("body"),options.scrollOverflow?(container.hasClass("fullpage-used")&&createSlimScrollingHandler(),$(window).on("load",createSlimScrollingHandler)):$.isFunction(options.afterRender)&&options.afterRender.call(this);var value=window.location.hash.replace("#","").split("/"),destiny=value[0];if(destiny.length){var section=$('[data-anchor="'+destiny+'"]');!options.animateAnchor&&section.length&&(silentScroll(section.position().top),$.isFunction(options.afterLoad)&&options.afterLoad.call(this,destiny,section.index(".section")+1),section.addClass("active").siblings().removeClass("active"))}$(window).on("load",function(){scrollToAnchor()})});var scrollId,isScrolling=!1;$(window).on("scroll",scrollHandler);var touchStartY=0,touchStartX=0,touchEndY=0,touchEndX=0;if($.fn.fullpage.moveSectionUp=function(){var prev=$(".section.active").prev(".section");prev.length||!options.loopTop&&!options.continuousVertical||(prev=$(".section").last()),prev.length&&scrollPage(prev,null,!0)},$.fn.fullpage.moveSectionDown=function(){var next=$(".section.active").next(".section");next.length||!options.loopBottom&&!options.continuousVertical||(next=$(".section").first()),(next.length>0||!next.length&&(options.loopBottom||options.continuousVertical))&&scrollPage(next,null,!1)},$.fn.fullpage.moveTo=function(section,slide){var destiny="";destiny=isNaN(section)?$('[data-anchor="'+section+'"]'):$(".section").eq(section-1),void 0!==slide?scrollPageAndSlide(section,slide):destiny.length>0&&scrollPage(destiny)},$.fn.fullpage.moveSlideRight=function(){moveSlide("next")},$.fn.fullpage.moveSlideLeft=function(){moveSlide("prev")},$(window).on("hashchange",hashChangeHandler),$(document).keydown(function(e){if(options.keyboardScrolling&&!isMoving)switch(e.which){case 38:case 33:$.fn.fullpage.moveSectionUp();break;case 40:case 34:$.fn.fullpage.moveSectionDown();break;case 36:$.fn.fullpage.moveTo(1);break;case 35:$.fn.fullpage.moveTo($(".section").length);break;case 37:$.fn.fullpage.moveSlideLeft();break;case 39:$.fn.fullpage.moveSlideRight();break;default:return}}),$(document).on("click","#fullPage-nav a",function(e){e.preventDefault();var index=$(this).parent().index();scrollPage($(".section").eq(index))}),$(document).on({mouseenter:function(){var tooltip=$(this).data("tooltip");$('<div class="fullPage-tooltip '+options.navigationPosition+'">'+tooltip+"</div>").hide().appendTo($(this)).fadeIn(200)},mouseleave:function(){$(this).find(".fullPage-tooltip").fadeOut().remove()}},"#fullPage-nav li"),options.normalScrollElements&&($(document).on("mouseover",options.normalScrollElements,function(){$.fn.fullpage.setMouseWheelScrolling(!1)}),$(document).on("mouseout",options.normalScrollElements,function(){$.fn.fullpage.setMouseWheelScrolling(!0)})),$(".section").on("click",".controlArrow",function(){$(this).hasClass("prev")?$.fn.fullpage.moveSlideLeft():$.fn.fullpage.moveSlideRight()}),$(".section").on("click",".toSlide",function(e){e.preventDefault();var slides=$(this).closest(".section").find(".slides"),currentSlide=slides.find(".slide.active"),destiny=null;destiny=slides.find(".slide").eq($(this).data("index")-1),destiny.length>0&&landscapeScroll(slides,destiny)}),!isTouchDevice){var resizeId;$(window).resize(function(){clearTimeout(resizeId),resizeId=setTimeout($.fn.fullpage.reBuild,500)})}var supportsOrientationChange="onorientationchange"in window,orientationEvent=supportsOrientationChange?"orientationchange":"resize";$(window).bind(orientationEvent,function(){isTouchDevice&&$.fn.fullpage.reBuild()}),$.fn.fullpage.reBuild=function(){isResizing=!0;var windowsWidth=$(window).width();windowsHeight=$(window).height(),options.resize&&resizeMe(windowsHeight,windowsWidth),$(".section").each(function(){var scrollHeight=windowsHeight-parseInt($(this).css("padding-bottom"))-parseInt($(this).css("padding-top"));if(options.verticalCentered&&$(this).find(".tableCell").css("height",getTableHeight($(this))+"px"),$(this).css("height",windowsHeight+"px"),options.scrollOverflow){var slides=$(this).find(".slide");slides.length?slides.each(function(){createSlimScrolling($(this))}):createSlimScrolling($(this))}var slides=$(this).find(".slides");slides.length&&landscapeScroll(slides,slides.find(".slide.active"))});var destinyPos=$(".section.active").position(),activeSection=$(".section.active");activeSection.index(".section")&&scrollPage(activeSection),isResizing=!1,$.isFunction(options.afterResize)&&options.afterResize.call(this)},$(document).on("click",".fullPage-slidesNav a",function(e){e.preventDefault();var slides=$(this).closest(".section").find(".slides");landscapeScroll(slides,slides.find(".slide").eq($(this).closest("li").index()))}),$("body").on("mk-opened-nav",function(){$.fn.fullpage.setAutoScrolling(!1),$.fn.fullpage.setAllowScrolling(!1),$.fn.fullpage.setKeyboardScrolling(!1),$(window).off("scroll",scrollHandler)}),$("body").on("mk-closed-nav",function(){$.fn.fullpage.setAutoScrolling(!0),$.fn.fullpage.setAllowScrolling(!0),$.fn.fullpage.setKeyboardScrolling(!0),$(window).on("scroll",scrollHandler)}),$.fn.fullpage.destroy=function(all){$.fn.fullpage.setAutoScrolling(!1),$.fn.fullpage.setAllowScrolling(!1),$.fn.fullpage.setKeyboardScrolling(!1),$(window).off("scroll",scrollHandler).off("hashchange",hashChangeHandler),$(document).off("click","#fullPage-nav a").off("mouseenter","#fullPage-nav li").off("mouseleave","#fullPage-nav li").off("click",".fullPage-slidesNav a").off("mouseover",options.normalScrollElements).off("mouseout",options.normalScrollElements),$(".section").off("click",".controlArrow").off("click",".toSlide"),all&&destroyStructure()}}}(jQuery);