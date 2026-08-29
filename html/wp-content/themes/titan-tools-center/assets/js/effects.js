//Scroll Animations
const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      // console.log(entry);
      if (entry.isIntersecting) {
        entry.target.classList.add('animations-show-item');
        observer.unobserve(entry.target);
      } else {
        entry.target.classList.remove('animations-show-item');
      }
    });
  });

  const hiddenElements = document.querySelectorAll('.animations-hidden-item');
  hiddenElements.forEach((el) => observer.observe(el));

jQuery('document').ready(function(){
  var owl = jQuery('.slider .owl-carousel');
    owl.owlCarousel({
    margin:0,
    nav: false,
    autoplay : true,
    lazyLoad: true,
    autoplayTimeout: 3000,
    loop: true,
    dots:true,
    navText : ['<span class="dashicons dashicons-arrow-left-alt2"></span>','<span class="dashicons dashicons-arrow-right-alt2"></span> '],
    responsive: {
      0: {
        items: 1,
        nav: false,
      },
      600: {
        items: 1,
        nav: false,
      },
      1000: {
        items: 1
      },
      1200: {
        items: 1
      }
    },
    autoplayHoverPause : true,
    mouseDrag: true
  });

    var owl = jQuery('.slider-right .owl-carousel');
    owl.owlCarousel({
    margin:0,
    nav: false,
    autoplay : true,
    lazyLoad: true,
    autoplayTimeout: 3000,
    loop: true,
    dots:true,
    navText : ['<span class="dashicons dashicons-arrow-left-alt2"></span>','<span class="dashicons dashicons-arrow-right-alt2"></span> '],
    responsive: {
      0: {
        items: 1,
        nav: false,
      },
      600: {
        margin:20,
        items: 2,
        nav: false,
      },
      781: {
        items: 1,
        nav: false,
      },
      1000: {
        items: 1
      },
      1200: {
        items: 1
      }
    },
    autoplayHoverPause : true,
    mouseDrag: true
  });
});