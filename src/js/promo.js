const promo = {

  promo: null,

  init (){
    this.promo = document.querySelector('.s-promo');
    if(!this.promo){
      console.log('[:-(] Can`t find element .s-promo');
      return;
    }

    let sPpromoCenter = document.querySelector('.s-promo__center');

    window.addEventListener('scroll', () => {

      sPpromoCenter.style.opacity = 1 - window.scrollY / this.promo.offsetHeight;
      // console.log(window.scrollY)
      this.promo.style.top = (0.5 * window.scrollY) + 'px';


    })

  },
}

export default promo;