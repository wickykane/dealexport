!function(e){function t(r){if(a[r])return a[r].exports;var s=a[r]={i:r,l:!1,exports:{}};return e[r].call(s.exports,s,s.exports,t),s.l=!0,s.exports}var a={};t.m=e,t.c=a,t.d=function(e,a,r){t.o(e,a)||Object.defineProperty(e,a,{configurable:!1,enumerable:!0,get:r})},t.n=function(e){var a=e&&e.__esModule?function(){return e.default}:function(){return e};return t.d(a,"a",a),a},t.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},t.p="/",t(t.s=12)}({12:function(e,t,a){"use strict";a(13),a(14);var r=a(15),s=function(e){return e&&e.__esModule?e:{default:e}}(r);!function(e){e(function(){window.ag_customiser||(window.AgeGate=new s.default)})}(jQuery)},13:function(e,t){},14:function(e,t){},15:function(e,t,a){"use strict";function r(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}Object.defineProperty(t,"__esModule",{value:!0});var s=function(){function e(e,t){for(var a=0;a<t.length;a++){var r=t[a];r.enumerable=r.enumerable||!1,r.configurable=!0,"value"in r&&(r.writable=!0),Object.defineProperty(e,r.key,r)}}return function(t,a,r){return a&&e(t.prototype,a),r&&e(t,r),t}}(),i=function(){function e(){r(this,e),this.settings=age_gate_params.settings,this.template=document.getElementById("tmpl-age-gate").innerHTML,this.cookieName=this.settings.cn||"age_gate",this.user_age=this.readCookie(this.cookieName),this.hasHooks="undefined"!=typeof ageGateHooks,this.init()}return s(e,[{key:"init",value:function(){this.viewPort(),this.isBot()||(age_gate_params.ajaxurl.match(/age-gate\/v1/)?(this.check_url=age_gate_params.ajaxurl+"check",this.filter_url=age_gate_params.ajaxurl+"filter",this.request_type="GET"):(this.check_url=this.filter_url=age_gate_params.ajaxurl,this.request_type="POST"),jQuery("body").on("click",'button[name="age_gate[confirm]"]',function(e){jQuery('input[name="confirm_action"]').val(e.target.classList.contains("age-gate-submit-yes")?1:0)}),jQuery("body").on("submit",".age-gate-form",this.formSubmission.bind(this)),this.shouldShow())}},{key:"shouldShow",value:function(){var e=this,t=!0;this.settings.anon&&this.user_age&&(t=!1),this.user_age>=this.settings.age&&(t=!1),this.settings.ignore_logged&&this.isLoggedIn()&&(t=!1),this.settings.inherit&&this.settings.inherit,"all"===this.settings.type&&this.settings.bypass&&(t=!1),"selected"!==this.settings.type||this.settings.restrict||(t=!1);var a={age:age_gate_params.settings.age,type:age_gate_params.settings.screen,bypass:age_gate_params.settings.bypass,restrict:age_gate_params.settings.restrict,anon:age_gate_params.settings.anon};if(this.hasHooks&&(t=ageGateHooks.applyFilters("age_gate_restricted",t,a)),this.settings.has_filter){var r={action:"age_gate_filters",id:age_gate_params.misc.i,type:age_gate_params.misc.t,extra:age_gate_params.extra||!1,show:t};age_gate_params.misc.qs&&(r.query=this.mapQuery()),jQuery.ajax({method:this.request_type,url:this.filter_url,data:r,dataType:"JSON",success:function(a){(t=a.show)&&e.show()}})}else t&&this.show()}},{key:"mapQuery",value:function(){return(arguments.length>0&&void 0!==arguments[0]&&arguments[0]||document.location.search).replace(/(^\?)/,"").split("&").map(function(e){return e=e.split("="),this[e[0]]=e[1],this}.bind({}))[0]}},{key:"show",value:function(){jQuery("html").addClass("age-gate-restricted age-gate-js"),jQuery("body").addClass("age-restriction"),jQuery(this.template).prependTo("body"),!this.settings.rechallenge&&this.readCookie("age_gate_failed")&&(this.removeForm(),jQuery('.age-gate-error[data-error-field="no-rechallenge"]').html('<p class="age-gate-error-message">'+age_gate_params.errors.failed+"</p>").addClass("has-error").show()),this.settings.title&&(this.pageTitle=document.title,document.title=this.settings.title),this.cookiesAllowed()||jQuery(".age-gate-form").prepend('<p class="error">'+age_gate_params.errors.cookies+"</p>"),this.triggerEvent("agegateshown")}},{key:"hide",value:function(){age_gate_params.settings.transition?(jQuery(".age-gate-wrapper").on("transitionend",function(e){jQuery(window).scrollTop(0),jQuery("body").removeClass("age-restriction"),jQuery("html").removeClass("age-gate-restricted age-gate-js"),jQuery("body").removeClass("age-gate--error"),jQuery(".age-gate-wrapper").remove()}),jQuery(".age-gate-wrapper").addClass("transition "+age_gate_params.settings.transition)):(jQuery(window).scrollTop(0),jQuery("body").removeClass("age-restriction"),jQuery("body").removeClass("age-gate--error"),jQuery("html").removeClass("age-gate-restricted age-gate-js"),jQuery(".age-gate-wrapper").remove())}},{key:"formSubmission",value:function(e){var t=this;e.preventDefault(),jQuery("body").addClass("age-gate-working");var a=jQuery(".age-gate-form").serialize();jQuery.ajax({url:this.check_url,data:a,method:this.request_type,dataType:"JSON",success:function(e){if(jQuery("body").removeClass("age-gate-working"),"success"!==e.status)e.redirect?(t.settings.rechallenge||"error"!==e.status||e.set_cookie&&t.setCookie("age_gate_failed",1),window.location.href=e.redirect):(t.clearErrors(),jQuery("body").addClass("age-gate--error"),jQuery.each(e.messages,function(e,t){jQuery('.age-gate-error[data-error-field="'+e+'"]').html('<p class="age-gate-error-message">'+t+"</p>").addClass("has-error").show()}),e.message&&jQuery('.age-gate-error[data-error-field="no-rechallenge"]').html('<p class="age-gate-error-message">'+e.message+"</p>").addClass("has-error").show(),t.settings.rechallenge||"error"!==e.status||(e.set_cookie&&t.setCookie("age_gate_failed",1),t.removeForm()));else{if(t.hasHooks)var a=ageGateHooks.applyFilters("age_gate_set_cookie",e.set_cookie);else var a=e.set_cookie;if(a&&t.setCookie(t.cookieName,Math.floor(e.age),e.remember,e.timescale),t.settings.title&&t.pageTitle&&(document.title=t.pageTitle),t.triggerEvent("agegatepassed"),e.redirect)return void(window.location.href=e.redirect);t.hide()}}})}},{key:"createNewEvent",value:function(e){var t;return"function"==typeof Event?t=new Event(e):(t=document.createEvent("Event"),t.initEvent(e,!0,!0)),t}},{key:"triggerEvent",value:function(e){if(window.Event&&window.dispatchEvent){var t=this.createNewEvent(e);window.dispatchEvent(t)}else jQuery(document).trigger(e)}},{key:"clearErrors",value:function(){jQuery(".age-gate-error").html("").hide()}},{key:"removeForm",value:function(){jQuery(".age-gate-form").find(".age-gate-form-elements, .age-gate-remember-wrapper, input, button, .age-gate-challenge").remove()}},{key:"setCookie",value:function(e,t,a,r){var s="";if(a){var i=new Date;switch(r){case"hours":i.setTime(i.getTime()+60*a*60*1e3);break;case"minutes":i.setTime(i.getTime()+60*a*1e3);break;default:i.setTime(i.getTime()+24*a*60*60*1e3)}s="; expires="+i.toUTCString()}t=this.settings.anon?1:t,document.cookie=e+"="+t+s+"; path=/"}},{key:"isLoggedIn",value:function(){if(jQuery("body").hasClass("logged-in"))return!0}},{key:"readCookie",value:function(e){for(var t=e+"=",a=document.cookie.split(";"),r=0;r<a.length;r++){for(var s=a[r];" "==s.charAt(0);)s=s.substring(1,s.length);if(0==s.indexOf(t))return s.substring(t.length,s.length)}return null}},{key:"isBot",value:function(){return(age_gate_params.bots||[]).indexOf(navigator.userAgent)>-1||navigator.userAgent.match(/bot|crawl|slurp|spider|facebookexternalhit|Facebot|Twitterbot/i)}},{key:"cookiesAllowed",value:function(){return!!navigator.cookieEnabled}},{key:"viewPort",value:function(){if(this.settings.viewport){var e=document.querySelector('meta[name="viewport"]');e?e.setAttribute("content","width=device-width, minimum-scale=1, maximum-scale=1"):jQuery("head").append('<meta name="viewport" content="width=device-width, minimum-scale=1, maximum-scale=1" />')}}}]),e}();t.default=i}});