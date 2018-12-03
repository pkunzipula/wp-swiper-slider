(function() {
    let the_slider = document.getElementById('js-home-slider');
    let ext_thumbs_array = swiperObject.json_thumbs.replace(/&quot;/g, '"');
    let json_thumbs_array = JSON.parse(ext_thumbs_array);
    let ext_cats_array = swiperObject.slider_categories.replace(/&quot;/g, '"');
    let json_cats_array = JSON.parse(ext_cats_array);
    let button = document.getElementById('js-skip-slider');
    let content = document.getElementById('js-after-slider');
    let swiper = new Swiper('.swiper-container', {
     preloadImages: true,
     updateOnImagesReady: true,
     on: {
        imagesReady: function() {
          the_slider.classList.add('images-loaded')
         },
     },
     autoplay: {
       delay: 7000,
       stopOnLastSlide: false
     },
     speed: 400,
     parallax: true,
     loop: true,
     loopAdditionalSlides: 2,
     hasNavigation: false,
     simluateTouch: false,
     allowTouchMove: false,
     pagination: {
       el: '.home-slider-navigation',
       type: 'custom',
       renderCustom: function(swiper, current, total) {
           let slider = document.getElementById('js-home-slider');
           for (let i = 0; i < json_cats_array.length; i++ ) {
            slider.classList.remove(json_cats_array[i]);
           }
           let currentClass = json_cats_array[current-1];
           slider.classList.add(currentClass);
           let text = '<ul class="pagination-station">';
           for (let i = 1; i <= total; i++) {
               if(current != i) {
                   text += '<li class="swiper-pagination-bullet" data-index="'+i+'">';
                   text +=    '<span>';
                   text +=      '<img src="'+json_thumbs_array[i-1]+'">';
                   text +=    '</span>';
                   text += '</li>';
               } else {
                   text += '<li class="swiper-pagination-bullet swiper-pagination-bullet-active" data-index="'+i+'">';
                   text +=    '<span>';
                   text +=      '<img src="'+json_thumbs_array[i-1]+'">';
                   text +=    '</span>';
                   text += '</li>';
               }
           };
           text += '</ul>';
           return text;
       },
       clickable: true,       
      },
    });
    button.addEventListener('click', function() {
		content.scrollIntoView({
			behavior: 'smooth',
			block: 'start'
		});
	});
})();