// core version + navigation, pagination modules:
import Swiper from 'swiper';
import { Navigation, Pagination, Manipulation, Mousewheel, Zoom } from 'swiper/modules';
// import Swiper and modules styles
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

const swiper = {

  selector: '#swiper',
  swiper: null,

  init (){
    if (!document.querySelector(this.selector)) return;


    this.swiper = new Swiper(this.selector, {
      lazy: true,
      lazyPreloadPrevNext: 2,
      centeredSlides: true,
      mousewheel: true,
      slidesPerView: 1,
      spaceBetween: 30,
      zoom: true,
      limitToOriginalSize:true,
      // configure Swiper to use modules
      modules: [Navigation, Pagination, Manipulation, Mousewheel, Zoom],
      pagination: {
        el: ".swiper-pagination",
        type: "fraction",
      },
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },

    });


    if (this.swiper){

      let links = document.querySelectorAll('a');
      let images = [];

      document.getElementById('swiper-container').addEventListener('touchmove',(event)=>{
        event.preventDefault() // For prevent scroll by swipe body/page
      })



      links.forEach( (el)=>{

        let origin = document.location.host;

        const IMG_REGEXP = new RegExp(`^(.*)${origin}(.*)\.(gif|jpg|bmp|png)$`, 'g');
        if(IMG_REGEXP.test(el.href))
        {
          images.push(el.href)
          el.addEventListener('click', (event)=>{
            event.preventDefault();
            document.body.style.position = 'sticky';
            document.body.style.top = window.scrollY;
            document.getElementById('swiper-container').classList.replace('hidden', 'show');

            let imgIndex = images.findIndex((el)=>{ return el === event.target.parentElement.href})
            this.swiper.slideTo(imgIndex, 0, false)
          })

          let slideText = el.querySelector('img');
          if(slideText){
            slideText = `<div class="swiper-slide-text">${slideText.alt}</div>`
          }else {
            slideText=''
          }
          this.swiper.appendSlide(`<div class="swiper-slide"><div class="swiper-zoom-container">
                                         <img loading="lazy" src="${el.href}"  alt="" class="swiper-img" />
                                         <div class="swiper-lazy-preloader swiper-lazy-preloader-white"></div>
                                         </div>${slideText}</div>`)
        }
      })



    }else {
      return;
    }

    const swiperClose = document.getElementById('swiper-close');
    const swiperContainer = document.getElementById('swiper-container');

    swiperClose.addEventListener('click', ()=>{
      swiperContainer.classList.replace('show', 'hidden');
      document.body.style.position = '';
      document.body.style.top = '';

    })


    document.addEventListener('keydown', function(event) {
      if (event.key === 'Escape') {
        if(swiperContainer.classList.contains('show')){
          swiperContainer.classList.replace('show', 'hidden');
          document.body.style.position = '';
          document.body.style.top = '';
        }
      }
    })

  },

}


export default swiper;