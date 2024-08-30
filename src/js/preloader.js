const preloader = {

  preloader: null,
  transition: 500, // same in css

  init (){
    this.preloader = document.querySelector('#preloader');
    if(!this.preloader){
      console.log('[:-(] Can`t find element #preloader');
      return;
    }
    this.preloaderHide();

    let a = document.querySelectorAll('a');
    a.forEach((el) => {
      el.addEventListener('click', (event) => {
        this.preloaderShow();
        event.preventDefault();
      })
    })

  },

  preloaderHide(transition = this.transition) {
    this.preloader.classList.replace('show', 'fade');

    setTimeout(() => {
      this.preloader.classList.replace('fade', 'hide');
    }, transition);

  },
  preloaderShow(transition = this.transition) {
    this.preloader.classList.replace('hide', 'show');

  }

}


export default preloader;