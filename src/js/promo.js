const promo = {

  promo: null,

  init (){
    this.promo = document.querySelector('.s-promo');
    if(!this.promo){
      console.log('[:-(] Can`t find element .s-promo');
      return;
    }


    window.addEventListener('scroll', () => {

      // console.log(window.scrollY)
      this.promo.style.top = (0.5 * window.scrollY) + 'px';


    })


  },
}

export default promo;