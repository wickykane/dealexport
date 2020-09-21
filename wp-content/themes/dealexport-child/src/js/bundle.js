import './components/slider';

(function($){
	$( document ).ready(function() {
	    init();
	});

    function init() {
        initializeDropdown();
        console.log('test');
    }

	function initializeDropdown(){
        let dropdown = document.querySelectorAll('.dropdown');
        let dropdownArray = Array.prototype.slice.call(dropdown,0);

        const filter_links = Array.from(document.querySelectorAll('.dropdown ul li a'));
        let filter_label = document.querySelector('.dropdown .label');

        console.log('filter_label.textContent', filter_label);
        filter_links.forEach(link => link.addEventListener('click', function(event) {
            filter_label.textContent = event.target.textContent;
            console.log('filter_label.textContent', filter_label.textContent);
        }));

        dropdownArray.forEach(function(el){
            let trigger = el,
                menuList = el.querySelector('.dropdown-menu');
            trigger.onclick = function(event) {
                event.preventDefault();
                event.stopPropagation();
                if(!trigger.classList.contains('open')) {
                    trigger.classList.add('open');
                } else {
                    trigger.classList.remove('open');
                }
            };
        });
    }
})(jQuery);
