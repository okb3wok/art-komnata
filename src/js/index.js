import toTop from './toTop.js'
import preloader from "./preloader.js";
import header from "./header.js";
import promo  from "./promo.js";
import swiper from "./swiper.js";
import tags from "./tags.js";
import metrika from "./metrika.js";

document.addEventListener('DOMContentLoaded', ()=>{

  console.log('[:-)] Loading js scripts!');
  metrika.init();
  preloader.init();
  toTop.init();
  header.init();
  promo.init();
  swiper.init();
  tags.init();




});