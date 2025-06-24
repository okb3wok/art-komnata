import Swiper from 'swiper';
import { Navigation, Pagination, Manipulation, Mousewheel, Zoom, Autoplay } from 'swiper/modules';
// import Swiper and modules styles
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

const visual = {

  visual: null,
  visualSwiper: null,
  swiperContainer: null,
  init(){

    this.visual = document.querySelector('#visual');
    if(!this.visual){
      console.log('[:-(] Can`t find element #visual');
      return;
    }

    this.swiperContainer = document.getElementById('visualSwiper-container');
    if(!this.swiperContainer){
      console.log('[:-(] Can`t find element #swiper-container');
      return;
    }

    this.visualSwiper = new Swiper('#visualSwiper', {
      lazy: true,
      direction: "vertical",
      lazyPreloadPrevNext: 2,
      centeredSlides: true,
      mousewheel: true,
      slidesPerView: 1,
      spaceBetween: 30,
      zoom: true,
      limitToOriginalSize:true,
      // configure Swiper to use modules
      modules: [Navigation, Pagination, Manipulation, Mousewheel, Zoom, Autoplay],
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
      // navigation: {
      //   nextEl: ".swiper-button-next",
      //   prevEl: ".swiper-button-prev",
      // },
      autoplay: {
        delay: 3500,
        disableOnInteraction: false,
      },
      loop: true,

    });


    this.showVisualSwiper();

    // Реализация кнопки паузы/старта
    const autoplayToggleButton = document.getElementById('autoplay-toggle');

    autoplayToggleButton.getElementsByTagName('svg')[1].style.display = 'none';
// Обработчик событий для кнопки
    autoplayToggleButton.addEventListener('click', () => {
      if (this.visualSwiper.autoplay.running) {
        this.visualSwiper.autoplay.stop();
        autoplayToggleButton.getElementsByTagName('svg')[0].style.display = 'none';
        autoplayToggleButton.getElementsByTagName('svg')[1].style.display = 'inline';

      } else {
        this.visualSwiper.autoplay.start();

        autoplayToggleButton.getElementsByTagName('svg')[1].style.display = 'none';
        autoplayToggleButton.getElementsByTagName('svg')[0].style.display = 'inline';
      }
    });

  },

  showVisualSwiper(){
    this.swiperContainer.classList.remove('hidden');
    this.swiperContainer.classList.add('show');
  }

}

export default visual;