import toTop from './toTop.js'
import preloader from "./preloader.js";
import header from "./header.js";

document.addEventListener('DOMContentLoaded', ()=>{

  console.log('[:-)] Loading js scripts!');
  preloader.init();
  toTop.init();
  header.init();

});